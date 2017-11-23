<?php
/**
 * Created by PhpStorm.
 * User: root
 * Date: 24/10/17
 * Time: 12:19 AM
 */
namespace Core;
use Core\Constants as c;
use Core\Router as Router;
use Core\CoreException as ce;
use Core\Autoloader as Autoloader;
use Core\View as View;
use Core\LibApcu as Apcu;

class RequestParser {
    // Controllers namespace
    private static $controllerNamespace = "User\\Controllers\\";

    // Holds the status of route match
    private static $mark = false;

    // Holds current route params
    private static $CURRENT_ROUTE_PARAMS = array();

    // Parse the request uri and call appropriate controller and action method

    public static function _parse() {
        // Get all System defined constants such as the ones related to request
        $constants = c::getConstants("SYSTEM");
        if($constants["REQUEST"]["SERVER"]["REQUEST_URI"]!="/") {
            $requestUri = rtrim($constants["REQUEST"]["SERVER"]["REQUEST_URI"], "/");
        } else {
            $requestUri = $constants["REQUEST"]["SERVER"]["REQUEST_URI"];
        }
        // Pick up request URI till ? to omit GET parameters
       $getParamsPos = strpos($requestUri, "?");

        // check if get params exist in uri then only take the string till them otherwise let it be as is.
        if($getParamsPos > 0) {
            $requestUriCleaned = substr($requestUri, 0, $getParamsPos);
        } else {
            $requestUriCleaned = $requestUri;
        }
        // Split Request Uri into parts so that prefix, controller and action can be separated
        $requestUriParts = explode("/", $requestUriCleaned);

        // Get routes
        $routes = Router::getRoutes();

        // Prefix Holder
        $prefix = "";
        // Check if key exists in routes in prefix
        if(array_key_exists($requestUriParts[1], $routes["with_prefix"])) {
            $routingPayload = $routes["with_prefix"][$requestUriParts[1]];
            $prefix = $requestUriParts[1]; // save prefix for future use
            // This means that url also has other portions apart from prefix
            if(sizeof($requestUriParts) > 2) {
                // remove prefix from uri
                unset($requestUriParts[1]);
                $requestUri = implode("/", $requestUriParts);
            } else { // if only prefix is there in url
                $requestUri = "/";
            }
        } else {
            $requestUri = $requestUriCleaned;
            $routingPayload = $routes["without_prefix"];
        }

        // Checks if route was found or not
        self::$mark = false;

        // extract data transferred from one route to other
        self::__extractRouteTransferData($requestUri);

        // Calculating controller and action to call for the given request route
        array_map(function($route) use ($requestUri, $constants, $prefix) {
            // check if route matches with any registered routes and given params
            $isRouteRegistered = self::__ifRouteExistsMakeParams($requestUri, $route);
            if($isRouteRegistered && $route['method'] == $constants["REQUEST"]["REST"]["METHOD"]) {
                // Set that route is found
                self::$mark = true;
                // if route matched then execute its controller action or if given then callback
                self::__executeRoute($route, $prefix);
            } else if(!$isRouteRegistered) { // if route didnt match with any of the registered routes then remove the parameters and check one more time because those parameters are optional
                // Remove all the route params
                $stripParamsFromConfigRoute = preg_replace("/\{{1}[a-zA-z]+\}{1}\/?/", "", $route['params_config']['full_reg_url']);
                $trimmmedStripParamsFromConfigRoute = rtrim($stripParamsFromConfigRoute, "/");
                if($trimmmedStripParamsFromConfigRoute == $requestUri){
                    // Set that route is found
                    self::$mark = true;
                    // if route matched then execute its controller action or if given then callback
                    self::__executeRoute($route, $prefix);// if route matched then execute its controller action or if given then callback
                } else if($trimmmedStripParamsFromConfigRoute != $requestUri) {
                    // If Only few parameters are passed from end and not all then consider only removing last param from url and matching
                    $routeCopy = $route;
                    $pattern = "/\/?\{{1}[a-zA-z]+\}{1}\/?$/";
                    while(($trimmed = preg_replace($pattern, "", $routeCopy['params_config']['full_reg_url'])) != $routeCopy['params_config']['full_reg_url']) {
                        $routeCopy['params_config']['full_reg_url'] = $trimmed;
                        $isRouteRegistered = self::__ifRouteExistsMakeParams($requestUri, $routeCopy);
                        if($isRouteRegistered) {
                            // Set that route is found
                            self::$mark = true;
                            self::__executeRoute($routeCopy, $prefix);// if route matched then execute its controller action or if given then callback
                            break;
                        }
                    }
                }
            }
        }, $routingPayload);
        // Throw exception if route was not found
        if(!self::$mark) {
            if(View::$enable404) {
                Response::send("404 Not Found", ["ErrorMessage" => "404 Page"]);
            } else {
                CoreException::__sendErrorResponse("Cannot find given route.", "404 Not Found");
            }
        }
    }

    // Match Route and set route params
    private static function __ifRouteExistsMakeParams(string $requestUri, array $route): bool {
        // Break request uri
        $breakRequestUri = explode("/", $requestUri);
        // Break Registered uri in registered in routes.php
        $breakConfigUri = explode("/", $route['params_config']['full_reg_url']);
        // Execute if both the request uri and registered uri are of same size so that we have some probability that two can be same
        if(sizeof($breakRequestUri) == sizeof($breakConfigUri)) {
            // Final params map holder
            $paramsConfig = array();
            array_map(function($routeparam_key) use ($breakRequestUri, $route, &$breakConfigUri, &$paramsConfig){
               // Find the route param's index in registered uris
                $index = array_search($routeparam_key, $breakConfigUri);
                // pick the value to fill in registered uri from the actual requested uri
                $indexValueInRequestedUrl = $breakRequestUri[$index];
                // replace the value passed in request uri in registered uri so that later they can be imploded and matched
                $breakConfigUri[$index] = $indexValueInRequestedUrl;
                // remove {,} from params place holder to make them keys, which will hold the values from the actual request uri
                $paramKeyPrepare = rtrim(ltrim($routeparam_key, "{"), "}");
                // set the array with key as given in registered routes config
                $paramsConfig[$paramKeyPrepare] = $indexValueInRequestedUrl;
            }, $route['params_config']['url_params_holders']);
            $finalReplacedConfigUri = implode("/", $breakConfigUri);
            // check id actual requested uri and new replaced config uri are same
            if($finalReplacedConfigUri && $requestUri && $finalReplacedConfigUri == $requestUri) {
                // updated current route params
                self::$CURRENT_ROUTE_PARAMS = $paramsConfig;
                // Set System constant if available
                c::setSystemURLConstant(self::$CURRENT_ROUTE_PARAMS);
                return true;
            }
        }
        return false;
    }

    // If route matched then call controller, action or callback
    private static function __executeRoute(array $route, string $prefix) {
        // Set Status code as 200 OK if route found
        Response::setStatusCode("200 OK");

        // If callback is given then skip everything and execute callback
        if($route['callback']) {
            $callback = $route['callback'];
            $callback();
        } else {
            if($prefix) {
                $controllerPath = self::$controllerNamespace.ucfirst($prefix)."\\".ucfirst($route["controller"])."Controller";
            } else {
                $controllerPath = self::$controllerNamespace.ucfirst($route["controller"])."Controller";
            }
            $controllerObj = null;
            try { // If class is inside controllers directly and not inside any other sub folder specified by prefix in request url
                $controllerObj = new $controllerPath;
                $action = $route["action"];
                call_user_func(array($controllerObj, $action));
                return $route;
            } catch (CoreException $ce) {
                echo $ce -> getMessage();
            } catch(\Error $e) {
                echo $e -> getMessage();
            } catch(\ErrorException $e) {
                $error_msg = $e -> getMessage();
                $error_str_pos = strpos($error_msg, "call_user_func");
                if($error_str_pos >= 0) {
                    $breakError = explode(",", $error_msg);
                    echo $breakError[1];
                }
            }
        }
    }

    // Extract data passed to route
    private static function __extractRouteTransferData(string $request_uri) {
        try{
            // create new apcu object to pull route related data
            $apcu = new Apcu();
            $payloadForRoute = $apcu -> fetch("routeForwards");
            if(!empty($payloadForRoute)) {
                // remove trailing and leading slashes from request uri
                $request_uri = ltrim($request_uri,"/");
                $request_uri = rtrim($request_uri,"/");

                // loop on request payloads to match the current route
                array_walk($payloadForRoute, function($value, $key) use ($request_uri, &$payloadForRoute, &$apcu) {
                    // check if value received from routeForwards is array and its not empty then only process it
                    if(\is_array($value) && !empty($value)) {
                        $url = ltrim(key($value), "/");
                        $url = rtrim($url, "/");

                        // if current route matches any entries in apcu route stored payload
                        if($request_uri == $url) {
                            unset($payloadForRoute[$key]);
                            $apcu -> remove("routeForwards");
                            $apcu -> store("routeForwards", $payloadForRoute);
                            Constants::_setUserConstants("transferredParams", current($value)); // store the parameter in user constant
                            throw new ce("Route Match Found. Existing", 200);
                        }
                    }
                });
            }
        } catch(\Throwable $t) {
            if($t -> getCode() == 200) {
                return true;
            } else {
                echo PHP_EOL;
                echo $t -> getMessage();
                echo PHP_EOL;
            }
        }
    }
}
RequestParser::_parse();
    <?php
/**
 * Created by PhpStorm.
 * User: root
 * Date: 26/10/17
 * Time: 7:34 PM
 */
namespace Core;

class Router {
    // Routes Holder
    private static $routes = array(
        "with_prefix" =>array(),
        "without_prefix" => array()
    );
    // Holds prefix
    private static $PREFIX = null;

    // Register Routes
    public static function registerRoute(string $method, string $url, callable $callback = null , string $controller = "index", string $action = "index") {
        $regUrl = $url;
        // check if registered route has params in route
        preg_match_all("/\{{1}[a-zA-z]+\}{1}/", $url, $matches, PREG_OFFSET_CAPTURE);
        // Holds route params if any
        $params = array();
        if(!empty($matches[0])) {
            // Change url to without params if any
            $url = substr($url, 0, $matches[0][0][1]);
            // Prepare params array
            $params = array_map(function($match) {
                return $match[0];
            }, array_values($matches[0]));
//            $params = $matches;
        }
        if(self::$PREFIX) {
            if(array_key_exists(self::$PREFIX, self::$routes["with_prefix"])) {
                array_push(self::$routes["with_prefix"][self::$PREFIX], array(
                    "method" => $method,
                    "url" => $url,
                    "controller" => $controller,
                    "action" => $action,
                    "callback" => $callback,
                    "params_config" => array(
                        "url_params_holders" => $params,
                        "full_reg_url" => $regUrl
                    )
                ));
            } else if(!array_key_exists(self::$PREFIX, self::$routes["with_prefix"])) {
                self::$routes["with_prefix"][self::$PREFIX] = array(
                    [
                        "method" => $method,
                        "url" => $url,
                        "controller" => $controller,
                        "action" => $action,
                        "callback" => $callback,
                        "params_config" => array(
                            "url_params_holders" => $params,
                            "full_reg_url" => $regUrl
                        )
                    ]
                );
            }
        } else {
            array_push(self::$routes["without_prefix"], array(
                "method" => $method,
                "url" => $url,
                "controller" => $controller,
                "action" => $action,
                "callback" => $callback,
                "params_config" => array(
                    "url_params_holders" => $params,
                    "full_reg_url" => $regUrl
                )
            ));
        }
    }

    // Register Routes with prefix
    public static function group(string $prefix, callable $callback) {
        self::$PREFIX = $prefix;
        $callback();
    }

    // Set group routing marker to true
    public static function setPrefix(string $prefix) {
        self::$PREFIX = $prefix;
    }
    public static function clearPrefix() {
        self::$PREFIX = null;
    }
    // Get all registered routes
    public static function getRoutes(): array {
        return self::$routes;
    }
}
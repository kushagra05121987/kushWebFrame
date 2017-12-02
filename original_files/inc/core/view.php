<?php
/**
 * Created by PhpStorm.
 * User: root
 * Date: 29/10/17
 * Time: 7:44 AM
 */
namespace Core;

use Core\Constants as Constants;
use Core\CoreException as CoreException;

class View {
    private static $coreViewRootPath = "inc".DIRECTORY_SEPARATOR."core".DIRECTORY_SEPARATOR."views";
    private static $userViewRootPath = "inc".DIRECTORY_SEPARATOR."user".DIRECTORY_SEPARATOR."views";
    private static $pageNotFoundViewFile = "404";
    public static $enable404 = false;

    // Set view by including the given file
    protected static function make(array $params = array(), bool $auto = true, string $viewname="default.phtml", string $load_type = "User") {
        // Initialize view include paths
        set_include_path(self::$coreViewRootPath.PATH_SEPARATOR.self::$userViewRootPath);

        // Execute if set to automatically pickup the file name and location
        if($auto) {
            self::__autLoadView($params);
        } else { // else load file with given name from given load type
            self::__loadViewByNameType($viewname, $load_type, $params);
        }
        restore_include_path();
    }

    // Auto load view file based on calling class and method
    private static function __autLoadView(array $params) {
        // make variables with names in parameter array
        extract($params);
        // Get which controller -> action called view
        $back_trace = debug_backtrace();
        $controllerClass = $back_trace[2]['class'];
        $controllerAction = $back_trace[2]['function'];
        $patternInclusionGroup = "/^[a-zA-Z]+/";
        preg_match($patternInclusionGroup, $controllerClass, $matches);

        // Get controller name to be used as directory
        $patternMatchControllerName = "/[a-zA-Z0-9]+$/";
        preg_match($patternMatchControllerName, $controllerClass, $matchesControllerName);
        $controllerName = $matchesControllerName[0];
        $directoryNameFromController = strtolower(substr($controllerName, 0, strpos($controllerName, "Controller")));

        // check which inclusion group to use User or Core
        $includeDirRootPath = "";
        if($matches[0] == "User") {
            $includeDirRootPath = self::$userViewRootPath;
        } else if($matches[0] == "Core") {
            $includeDirRootPath = self::$coreViewRootPath;
        }

        // Prepare calling class path to be checked prefix which will be used as sub folder to find views
        $controllerClassCopy = $controllerClass;

        $removeControllerNamePattern = "/\\\{1}[a-zA-Z]+$/"; // remove class name from the end of class path
        $removedControllerClass = preg_replace($removeControllerNamePattern, "", $controllerClassCopy);

        $prefixFetchPattern = "/[a-zA-Z]+$/"; // pick the portion of remaining class path string. To be treated as folder to search the view in
        preg_match($prefixFetchPattern, $removedControllerClass, $prefix);
        if(!empty($prefix)) {
            $directory = $prefix[0];
            $completeDirStruct = $includeDirRootPath.DIRECTORY_SEPARATOR.strtolower($directory).DIRECTORY_SEPARATOR.$directoryNameFromController;

            // if complete folder path till the prefix exists then search the file inside it
            if(is_dir($completeDirStruct)) {
                if(file_exists($completeDirStruct.DIRECTORY_SEPARATOR.$controllerAction.".phtml")) {
                    include_once $includeDirRootPath.DIRECTORY_SEPARATOR."commons".DIRECTORY_SEPARATOR."header.phtml";
                    include_once $completeDirStruct.DIRECTORY_SEPARATOR.$controllerAction.".phtml";
                    include_once $includeDirRootPath.DIRECTORY_SEPARATOR."commons".DIRECTORY_SEPARATOR."footer.phtml";
                } else {
                    self::__fileNotFound($completeDirStruct.DIRECTORY_SEPARATOR.$controllerAction);
                }
            } else if(file_exists($includeDirRootPath.DIRECTORY_SEPARATOR.$directoryNameFromController.DIRECTORY_SEPARATOR.$controllerAction.".phtml")) { // other wise check if include root path for views contain the file
                include_once $includeDirRootPath.DIRECTORY_SEPARATOR."commons".DIRECTORY_SEPARATOR."header.phtml";
                include_once $includeDirRootPath.DIRECTORY_SEPARATOR.$directoryNameFromController.DIRECTORY_SEPARATOR.$controllerAction.".phtml";
                include_once $includeDirRootPath.DIRECTORY_SEPARATOR."commons".DIRECTORY_SEPARATOR."footer.phtml";
            } else {
                self::__fileNotFound($controllerAction);
            }
        } else {
            self::__fileNotFound($directoryNameFromController.DIRECTORY_SEPARATOR.$controllerAction);
        }
        // Clean temporary session variables
        unset($_SESSION['error']);
        unset($_SESSION['success']);
        unset($_SESSION['notify']);
    }

    // Include the given file name from the given load type
    private static function __loadViewByNameType(string $viewname, string $load_type, array $params) {
        extract($params);
        // check which inclusion group to use User or Core
        $includeDirRootPath = "";
        if($load_type == "User") {
            $includeDirRootPath = self::$userViewRootPath;
        } else if($load_type == "Core") {
            $includeDirRootPath = self::$coreViewRootPath;
        }
        // check if file with given filename exists
        if(file_exists($includeDirRootPath.DIRECTORY_SEPARATOR.$viewname)) {
            include_once $includeDirRootPath.DIRECTORY_SEPARATOR."commons".DIRECTORY_SEPARATOR."header.phtml";
            include_once($includeDirRootPath.DIRECTORY_SEPARATOR.$viewname);
            include_once $includeDirRootPath.DIRECTORY_SEPARATOR."commons".DIRECTORY_SEPARATOR."footer.phtml";
        } else {
            self::__fileNotFound($viewname);
        }
    }

    // Throw not found exception
    private static function __fileNotFound(string $filename) {
        CoreException::__sendErrorResponse("No view with name $filename.phtml was found.", "404 Not Found");
    }

    // set 404 page
    public static function __set404Page(string $name) {
        self::$pageNotFoundViewFile = $name;
    }

    // load 404 page
    protected static function __load404Page($message) {
        self::make($message, false, "404".DIRECTORY_SEPARATOR.self::$pageNotFoundViewFile.".phtml");
    }
}
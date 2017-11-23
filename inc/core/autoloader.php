<?php
/**
 * Created by PhpStorm.
 * User: root
 * Date: 23/10/17
 * Time: 5:31 PM
 */
namespace Core;
use Core\Constants as Constants;
class Autoloader {
    private static $include_paths = "";
    public static function _register() {
        // Initialize include path with default include path available
        self::$include_paths = get_include_path();

        // Set Extensions to be searched
        spl_autoload_extensions(".php");
        $extensions = spl_autoload_extensions();

        // Set other include paths
        Autoloader::setIncludePath();

        // set the path to be include path as prepared by above methods.
        set_include_path(self::$include_paths);

        // Register autoload method for classes
        spl_autoload_register(function($classFull) use ($extensions) {
            $class = explode('\\', $classFull);
            $class = $class[sizeof($class)-1];
            spl_autoload($class, $extensions);
        });

        // Register secondary autoloader for traits and classes
        spl_autoload_register(function($traitName) {
            try {
                if(!self::autoloadBuiltIn($traitName)) {
                    self::requireFile($traitName);
                }
            } catch(\ErrorException $ee) {
                Response::setStatusCode("500 Internal Server Error");
                echo $ee -> getMessage();
            } catch(\Error $e) {
                Response::setStatusCode("500 Internal Server Error");
                echo $e -> getMessage();
            }
        });
    }

    // Autoload classes or traits using absolute path finder of file
    private static function autoloadBuiltIn($FullPath) {
        // try to resolve filename in given include path using stream_resolve_include_path
        $fileNameNoSpacesPattern = "/[a-zA-Z]+$/";
        preg_match($fileNameNoSpacesPattern, $FullPath, $matches);
        $fileName = strtolower($matches[0]).".php";
        if($filePath = stream_resolve_include_path($fileName)) {
            try {
                include_once $filePath;
            } catch(\Throwable $t) {
                echo $t -> getMessage();
            }
        } else return false;
    }
    // Include file if by normal autoloading not found
    public static function requireFile($FullPath) {
        // If trait file could not be resolved by inbuilt method in include paths then directly try to include file using the namespace
        try {
            $classIncludePath = str_replace("\\", '/', $FullPath).".php";
            $constants = Constants::getConstants('USER');
            include_once(strtolower($constants['APP_CONFIG']['default']['AUTOLOADER']['root'].DIRECTORY_SEPARATOR.$classIncludePath));
        } catch(\Throwable $t) {
            header("HTTP/1.0 500 Internal Server Error");
            echo $t -> getMessage();
        }
    }

    // Set include Paths
    private static function prepareIncludePath(array $dirContents = array(), string $path = "") {
        if(key($dirContents) <= sizeof($dirContents)-1) {
            if($path) {
                $dirContents = glob($path);
            }
            $currentPath = current($dirContents);
            if($currentPath && $currentPath != '.' && $currentPath != ".." && key($dirContents) <= sizeof($dirContents)-1) {
                if(is_dir($currentPath)) {
                    self::$include_paths.=PATH_SEPARATOR.$currentPath;
                    self::prepareIncludePath(glob($currentPath.DIRECTORY_SEPARATOR."*"));
                    if(next($dirContents)) {
                        echo "\n";
                        self::prepareIncludePath($dirContents);
                    }
                } else if(!is_dir($currentPath)) {
                    if(next($dirContents)) {
                        next($dirContents);
                        self::prepareIncludePath($dirContents);
                    }
                }
            }
        }
    }

    // Set all include paths for autoloading
    private static function setIncludePath() {
        // Prepare include path to include all the directories inside a given folder path
        self::prepareIncludePath(array(), "{$_SERVER['DOCUMENT_ROOT']}".DIRECTORY_SEPARATOR."inc".DIRECTORY_SEPARATOR."core".DIRECTORY_SEPARATOR."*");
        self::prepareIncludePath(array(), "{$_SERVER['DOCUMENT_ROOT']}".DIRECTORY_SEPARATOR."inc".DIRECTORY_SEPARATOR."user".DIRECTORY_SEPARATOR."*");
    }
}
Autoloader::_register();
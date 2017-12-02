<?php
/**
 * Created by PhpStorm.
 * User: root
 * Date: 4/9/17
 * Time: 5:23 PM
 */
namespace xola\Autoloader;

class Autoload {
    public static function register() {
        set_include_path(INCLUDE_PATH);
        spl_autoload_register(function($className) {
            $classNameSplit = explode('\\', $className);
            $class = $classNameSplit[sizeof($classNameSplit)-1];
            $className = strtolower($class);
            include $className . ".php";
        });
    }
}
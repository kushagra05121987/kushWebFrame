<?php
/**
 * Created by PhpStorm.
 * User: root
 * Date: 11/11/17
 * Time: 12:26 AM
 */
namespace Core\Helpers;

use Core\Constants as Constants;
use Core\LibApcu as Apcu;
class Functions {
    // constants holding path for resources such as js and css
    private static $pathConstants = [
        "css" => "css",
        "js" => "js",
        "img" => "img"
    ];
    // redirect to given url
    public static function redirect($url) {
        \header("Location: $url");
    }
    // Clean session and reset it
    public static function cleanSession() {
        Constants::__setSystemConstant("session", "cleansession", null);
    }

    // Validate the input fields
    public static function validate(string $input, string $matchtype): bool {
        if($input) {
            $pattern = "";
            switch ($matchtype) {
                case "required":
                    $pattern = "/(?!\s)./";
                    break;
                case "alpha":
                    $pattern = "/^[a-zA-z]+(\s[a-zA-Z]+)?$/";
                    break;
                case "email":
                    $pattern = "/^[a-zA-z0-9_\.]+(\@){1}[a-zA-z0-9_]+(\.){1}[a-zA-Z0-9]{2,3}$/";
                    break;
                case "alnum":
                    $pattern = "/^[a-zA-Z0-9]$/";
                    break;
                case "numbers":
                    $pattern = "/^[0-9]$/";
                    break;
                case "special":
                    $pattern = "/^[a-zA-Z0-9\!\@\#\$\%\^\&\*\(\)\_\-\=\+\.\[\]\/\?]$/";
                    break;
            }
            preg_match($pattern, $input, $matches);
            if(!empty($matches)) {
                return true;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

    // set route related data
    public static function routePayloadTransfer(string $route, $payload) {
        $transferRouteParams = [];
        $transferRouteParams[$route] = $payload;
        $apcu = new Apcu();
        // check if apcu is loaded
        if($apcu -> is_loaded) {
            if($apcu -> store("routeForwards", $transferRouteParams)) { // if apcu is loaded then try to save data to store otherwise return false'
                return true;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

    // prepare complete path for file
    public function resourceUrl(string $filename, string $type): string {
        if($filename){
            $constants = Constants::getConstants('USER');
            $siteRoot = $constants['APP_CONFIG']['default']['WEB']['SITE_URL'];
            if(array_key_exists($type, self::$pathConstants)) {
                return $siteRoot."/".self::$pathConstants[$type]."/".$filename;
            } else {
                return "";
            }
        }
    }
}
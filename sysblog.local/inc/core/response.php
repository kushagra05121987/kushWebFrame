<?php
/**
 * Created by PhpStorm.
 * User: root
 * Date: 29/10/17
 * Time: 8:32 PM
 */
namespace Core;

use Core\View as View;

class Response extends View {
    // Http response status code
    private static $http_status_code;
    // send response with status code
    public static function setStatusCode(string $code) {
        self::$http_status_code = $code;
        header("HTTP/1.0 ".$code);
    }

    // send response settings correct status code
    public static function send(string $httpStatusCode = "", array $params = array(), bool $auto = true, string $viewname="default", string $load_type = "User") {
        if(!$httpStatusCode) {
            self::setStatusCode(self::$http_status_code);
        } else {
            self::setStatusCode($httpStatusCode);
        }

        if($httpStatusCode == "404 Not Found") {
            self::__load404Page(["Error_Message" => "Page Not Found"]);
        } else {
            self::make($params, $auto, $viewname, $load_type);
        }
    }
}
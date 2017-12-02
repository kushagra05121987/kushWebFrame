<?php
/**
 * Created by PhpStorm.
 * User: root
 * Date: 4/9/17
 * Time: 6:28 PM
 */
namespace xola\curl;

class Curl {
    private static $curl_init;
    private static $curl_headers = array();
    private static $method;
    private static $payload;
    private static $url;
    private static $set_opts;
    public static $serverResponse;
    public static function init($url, $method, $curl_headers, $payload, $set_opts) {
        self::$url = $url;
        self::$method = $method;
        self::$curl_headers = $curl_headers;
        self::$set_opts = $set_opts;
        self::$payload = $payload;
        self::$curl_init = curl_init();
        self::prepareRequest();
        self::$serverResponse = self::fireRequest();
    }
    private static function prepareRequest() {

        if(self::$curl_headers) {
            $headers = explode(';',self::$curl_headers);
            self::$curl_headers = array_filter($headers, function($val) {
                return $val;
            });
            curl_setopt(self::$curl_init, CURLOPT_HTTPHEADER, self::$curl_headers);
        }
        curl_setopt(self::$curl_init, CURLOPT_URL, self::$url);

        if(self::$method == "POST") {
            curl_setopt(self::$curl_init, CURLOPT_POST, 1);
            curl_setopt(self::$curl_init, CURLOPT_POSTFIELDS, self::$payload);
        }
        if(self::$set_opts) {
//            array_filter(self::$set_opts, function($opt, $value){
//                curl_setopt(self::$curl_init, $opt, $value);
//            }, ARRAY_FILTER_USE_BOTH);
            curl_setopt_array(self::$curl_init, self::$set_opts);
        }
        curl_setopt(self::$curl_init, CURLOPT_RETURNTRANSFER, true);

    }
    private static function fireRequest() {
        return curl_exec(self::$curl_init);
    }
}
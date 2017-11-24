<?php
/**
 * Created by PhpStorm.
 * User: root
 * Date: 29/9/17
 * Time: 3:33 PM
 */
ini_set('session.use_strict_mode', 1);
ini_set('session.use_strict_mode', 0);
session_start();
if (!function_exists('getallheaders'))  {
    function getallheaders()
    {
        if (!is_array($_SERVER)) {
            return array();
        }

        $headers = array();
        foreach ($_SERVER as $name => $value) {
            if (substr($name, 0, 5) == 'HTTP_') {
                $headers[str_replace(' ', '-', ucwords(strtolower(str_replace('_', ' ', substr($name, 5)))))] = $value;
            }
        }
        return $headers;
    }
}
echo "<br /> ============= ALL HEADERS =============== <br />";
print_r(getallheaders());
echo "<br /> ============= SERVER DETAILS =============== <br />";
print_r($_SERVER);
echo "<br /> ============= SESSION DETAILS =============== <br />";
print_r($_SESSION);
echo "<br /> ============= REQUEST RECEIVED =============== <br />";
$fp = fopen("php://input", 'r');
var_dump(stream_get_contents($fp));
echo "<br /> ============= RESPONSE HEADERS =============== <br />";
print_r(get_headers("http://google.com")); // returns headers from a specific url. $http_response_header can be used in place also
header("Custom-header: Custom-value");
print_r(headers_list());// returns headers sent as a response to current request

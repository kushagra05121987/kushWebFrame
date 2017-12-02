<?php
/**
 * Created by PhpStorm.
 * User: root
 * Date: 4/9/17
 * Time: 5:07 PM
 */
use xola\Autoloader as Autoloader;
use xola\Curl as Curl;

require_once "include/ENV_config.php";
include_once "include/autoloader.php";
Autoloader\Autoload::register();
//Curl\Curl::init('https://sandbox.xola.com/api/users', 'POST', "Content-Type:application/json", '{"name" : "Kushagra", "email" : "kushagra.mishra05121987@gmail.com", "password" : "password12345"}');
echo "<pre>";

//print_r(Curl\Curl::$serverResponse);
//Curl\Curl::init('https://sandbox.xola.com/api/users/me', 'GET', null, null, array(
//    CURLOPT_USERPWD => 'kushagra.mishra05121987@gmail.com:password12345'
//));
//Curl\Curl::init('https://sandbox.xola.com/api/users/kushagra.mishra05121987@gmail.com/apiKey', 'GET', null, null, array(
//    CURLOPT_USERPWD => 'kushagra.mishra05121987@gmail.com:password12345'
//));

//Curl\Curl::init('https://sandbox.xola.com/api/users/me', 'GET', "X-API-KEY:W4bfo56xoQs9sYPev4pTnTQLl8vHD4uFl9nvxlLWEPI", null, array(
//    CURLOPT_USERPWD => 'kushagra.mishra05121987@gmail.com:password12345'
//));

Curl\Curl::init("https://sandbox.xola.com/api/experiences?geo=37.7756,-122.4193,20&sort=geo&price=75&category=Sailing&sort=price[asc]", 'GET', "X-API-KEY:W4bfo56xoQs9sYPev4pTnTQLl8vHD4uFl9nvxlLWEPI", null, null);

echo "<br />";
print_r(Curl\Curl::$serverResponse);
echo "</pre>";


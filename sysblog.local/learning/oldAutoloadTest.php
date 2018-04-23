<?php
/**
 * Created by PhpStorm.
 * User: root
 * Date: 1/4/18
 * Time: 6:50 PM
 */
error_reporting(E_ALL);
ini_set('display_errors', 1);
//function __autoload($classname) {
//    echo "inside __autoload method";
//    $filename = "./". $classname .".php";
//    include_once($filename);
//}
echo ini_get('include_path');
echo getcwd();
// this will class the default implementation of spl_autload.
spl_autoload_register();
new \test();
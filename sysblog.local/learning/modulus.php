<?php
/**
 * Created by PhpStorm.
 * User: root
 * Date: 24/9/17
 * Time: 12:48 PM
 */
print_r($argv); // array of arguments with first one being the current script name
print_r($argc); // gives number of arguments
$statement = "$argv[1] $argv[2] $argv[3];";
$eval = (float) eval("return ".$statement);
echo $statement."\n";
echo $eval;
echo "\n";
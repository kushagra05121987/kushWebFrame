<?php
/**
 * Created by PhpStorm.
 * User: root
 * Date: 24/9/17
 * Time: 12:48 PM
 */
$statement = "$argv[1] $argv[2] $argv[3];";
$eval = (float) eval("return ".$statement);
echo $statement."\n";
echo $eval;
echo "\n";
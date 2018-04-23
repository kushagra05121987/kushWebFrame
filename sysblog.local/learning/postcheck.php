<?php
/**
 * Created by PhpStorm.
 * User: root
 * Date: 24/9/17
 * Time: 11:38 PM
 */
//file_put_contents('checkreceived.txt', "data received");
echo "<br /> ============ POST CHECK ========== <br />";
print_r($_POST);
echo "<br />";
print_r(file_get_contents('php://input'));
echo "<br />";
print_r($_GET);
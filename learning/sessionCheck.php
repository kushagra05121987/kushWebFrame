<?php
/**
 * Created by PhpStorm.
 * User: root
 * Date: 29/9/17
 * Time: 2:07 PM
 */
ini_set('session.use_strict_mode', 1);
ini_set('session.use_strict_mode', 0);
echo "<pre>";
session_start();
echo "<br /> ============= SESSION SAVE HANDLER =============== <br />";
print_r(session_save_path());
$_SESSION["Global-Session-key"] = "Global-Session-value";
$opts = array(
    "http" => array(
        "method" => "POST",
        "header" => array("Cookie:PHPSESSID=kushagra","Content-type: application/json","Content-Length: ".strlen("{one: 1, two: 2}")),
        "content" => "{one: 1, two: 2}"
    )
);
stream_context_get_default($opts);
$fp = fopen("http://sysblog.local:8080/sessionResponse", "r");
echo "<br /> ============= STREAM CONTENTS =============== <br />";
print_r(stream_get_contents($fp));
echo "<br /> ============= SESSION CONTENTS =============== <br />";
print_r($_SESSION);
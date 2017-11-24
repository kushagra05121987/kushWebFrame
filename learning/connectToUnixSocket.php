<?php
/**
 * Created by PhpStorm.
 * User: root
 * Date: 18/11/17
 * Time: 8:17 PM
 */

// fsockopen — Open Internet or Unix domain socket connection
/**
 * $fp = fsockopen("www.example.com", 80, $errno, $errstr, 30);
if (!$fp) {
echo "$errstr ($errno)<br />\n";
} else {
$out = "GET / HTTP/1.1\r\n";
$out .= "Host: www.example.com\r\n";
$out .= "Connection: Close\r\n\r\n";
fwrite($fp, $out);
while (!feof($fp)) {
echo fgets($fp, 128);
}
fclose($fp);
}
 * So following can be done by fsockopen
 */
$socket = socket_create(AF_UNIX, SOCK_STREAM, 0);
socket_connect($socket,"/etc/php/7.0/websocket/unixwebsocket.sock", 9001);
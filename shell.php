<?php 
// echo "inside";
// $readLine = readline();
// print_r($readLine);
// $handleR = fopen("php://stdin", 'r+');
// $read = fgets($handleR);
// print_r($read);
$handleW = fopen("php://stdout", 'w+');
// print_r($handleW);
fwrite($handleW, "Hello World");
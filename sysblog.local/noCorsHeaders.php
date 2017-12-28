<?php
header("Access-Control-Allow-Origin: http://localhost:9000");
header("Access-Control-Allow-Credentials: true");
// header("Access-Control-Allow-Headers: custom-x");
header("custom-x: custom-x-val");
header("custom-y: custom-y-val");
header("Access-Control-Expose-Headers: custom-x");

echo "OK";


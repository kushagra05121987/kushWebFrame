<?php
$requestHeaders = array();
if(! function_exists('getallheaders')) {
	function getallheaders(&$requestHeaders) {
		foreach ($_SERVER as $key => $value) { 
			if(strpos($key, "HTTP_") === 0) {
				$requestHeaders[$key] = $value;
			}
		}
	}
	getallheaders($requestHeaders);
}
if($_SERVER['REQUEST_METHOD'] === "OPTIONS") {
	$allowHeaders = $requestHeaders['HTTP_ACCESS_CONTROL_REQUEST_HEADERS'];
	putenv("allowheaders = $allowHeaders");
	header("Access-Control-Allow-Headers: $allowHeaders");
	header("Access-Control-Allow-Methods: GET, POST, PUT");
} else {
	echo getenv("allowheaders");
}

header("Access-Control-Allow-Origin: http://localhost:9000");
header("Access-Control-Allow-Credentials: true");
$count = 1;
while($count < 999999999) {
	echo "running .... ";
	$count++;
}
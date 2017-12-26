<?php
session_start();

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
var_dump($_POST);
var_dump(file_get_contents("php://input"));
echo json_encode(array(1,2,3,4,5));
print_r($_FILES);
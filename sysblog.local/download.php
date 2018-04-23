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

// header('Content-disposition: attachment; filename='.urlencode('dummy.json'));
// header('Content-type: application/json');
// header("Content-Description: File Transfer");            
// header("Content-Length: " . filesize('dummy.json'));
// readfile("dummy.json");


$path = "./dummy.pdf";
$filename = "dummy.pdf";
// when this is a accessed in browser it uses the same technique in which it dumps everything on browser and because array buffer string from pdf is not supported by browser so it doesn't open it there and downloads it but while downloading it take the response headers into consideration.
header('Content-Transfer-Encoding: binary');  // For Gecko browsers mainly
header('Last-Modified: ' . gmdate('D, d M Y H:i:s', filemtime($path)) . ' GMT');
header('Accept-Ranges: bytes');  // For download resume
header('Content-Length: ' . filesize($path));  // File size
header('Content-Encoding: none');
header("Content-Type: application/octet-stream");
// header('Content-Type: application/pdf');  // Change this mime type if the file is not PDF
header('Content-Disposition: attachment; filename=' . $filename);  // Make the browser display the Save As dialog
readfile($path);

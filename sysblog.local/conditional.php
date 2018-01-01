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
$count = 2;
echo "<pre>";
// print_r($requestHeaders);
if(!empty($requestHeaders) && array_key_exists('HTTP_IF_NONE_MATCH', $requestHeaders)) {
	$etagRequest = $requestHeaders['HTTP_IF_NONE_MATCH'];
	if($count == 1) {
		echo "block 3";
		// header("Cache-Control: max-age=21600");
		// header("Expires: Wed, 21 Oct 2018 07:28:00 GMT");
		header("HTTP/1.1: 304 Not Modified");
	} else {
		echo "block 2";
		header("ETag: 675af34563dc-r35");
		header("Cache-Control: max-age=5");
		// header("Expires: Wed, 21 Oct 2018 07:28:00 GMT");
		header("HTTP/1.1: 200 OK");
	}
} else {
	echo "block 1";
	header("ETag: 675af34563dc-r34");
	header("Cache-Control: max-age=5");
	// header("Expires: Wed, 21 Oct 2018 07:28:00 GMT");
	header("HTTP/1.1: 200 OK");
}
// header("Access-Control-Allow-Origin: http://localhost:9000");
// header("Keep-Alive:timeout=0, max=0");
echo "hello1";

// 
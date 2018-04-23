<?php
	header("Access-Control-Allow-Origin: http://ui.local:8080");
	header("Access-Control-Allow-Methods: GET, HEAD");
	header("Access-Control-Expose-Headers: Custom, Accept-Ranges, Content-Disposition, Content-Length, Etag");
	header("Custom: custom-x");
    ob_end_clean();
    ini_set("output_buffering", "off");
    // ignore_user_abort(true);
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
    // print_r($requestHeaders);
    if(array_key_exists('HTTP_IF_NONE_MATCH', $requestHeaders) || array_key_exists('HTTP_IF_MATCH', $requestHeaders) || array_key_exists('HTTP_IF_MODIFIED_SINCE', $requestHeaders) || array_key_exists('HTTP_IF_UNMODIFIED_SINCE', $requestHeaders) || array_key_exists('HTTP_IF_RANGE', $requestHeaders)) {
    } else {
        
        $handle = fopen("annual_report_2009.pdf", "r+");
        $read1 = fread($handle, 10500000);
        fseek($handle, 10500000);
        $read2 = fread($handle, (10762150 - 10500000));
        fclose($handle);
        $fileContents = file_get_contents('annual_report_2009.pdf');
        $etag = md5($fileContents);
        if($_SERVER["REQUEST_METHOD"] == "HEAD") {
 			header("Etag: $etag");
			header("Content-Length: ". strlen($fileContents));
        } else {
//            header("HTTP/1.1: 206 Partial Content");
            header("HTTP/1.1: 200 OK");
            header("Etag: $etag");
			header("Content-Length: 10762150" );
        	header("Accept-Ranges: bytes");
        	 header("Content-Type: application/pdf");
        	echo gettype(filesize('annual_report_2009.pdf'));
        	echo $read1;
//        	flush();
//	        sleep(1);
//	        echo $read1;
//	        flush();
//	        sleep(1);
        }
        // header("HTTP/1.1: 200 OK");
        // header("Content-Disposition: attachment; filename=annual_report_2009.pdf");
        // header("Content-Length: ". strlen($fileContents));
        
        // $payload = ["name" => "Kushagra Mishra", "age" => 30, "gender" => "male", "location" => "india", "wife" => "Ekta Mishra"];
        // $etag = md5(json_encode($payload));
        
        
        
        // $jsonClass = ["name" => "Kushagra Mishra", "age" => 30, "gender" => "male", "location" => "india", "wife" => "Ekta Mishra"];
        // foreach($jsonClass as $key => $value) {
        //     echo $value;
        //     // ob_flush();
        //     flush();
        //     sleep(1);
        // }
        // echo "OK";
    }
?>
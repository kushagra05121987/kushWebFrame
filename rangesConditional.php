<?php
	header("Access-Control-Allow-Origin: http://localhost:9000");
	header("Access-Control-Allow-Methods: GET, HEAD");
	header("Access-Control-Expose-Headers: Custom, Accept-Ranges, Content-Disposition, Content-Length, ETag");
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
	} else {
        $requestHeaders = getallheaders();
    }
    // print_r($requestHeaders);

    $filesize = filesize("annual_report_2009.pdf");
    $handle = fopen("annual_report_2009.pdf", "r+");
    $read1 = fread($handle, ($filesize/2));
    fseek($handle, ($filesize/2));
    $read2 = fread($handle, ($filesize/2));
    fclose($handle);
    $fileContents = file_get_contents('annual_report_2009.pdf');
    $etag = md5($fileContents);
    
    if(array_key_exists('HTTP_IF_NONE_MATCH', $requestHeaders) || 
    array_key_exists('If-None-Match', $requestHeaders) || 
    array_key_exists('HTTP_IF_MATCH', $requestHeaders) || 
    array_key_exists('If-Match', $requestHeaders) || 
    array_key_exists('HTTP_IF_MODIFIED_SINCE', $requestHeaders) || 
    array_key_exists('If-Modified-Since', $requestHeaders) || 
    array_key_exists('HTTP_IF_UNMODIFIED_SINCE', $requestHeaders) || 
    array_key_exists('If-Unmodified-Since', $requestHeaders) || 
    array_key_exists('HTTP_IF_RANGE', $requestHeaders) || 
    array_key_exists('If-Range', $requestHeaders)) {
        if(array_key_exists('If-Range', $requestHeaders)) {
            $requestEtag = $requestHeaders['If-Range'];
        } else if(array_key_exists('If-Match', $requestHeaders)) {
            $requestEtag = $requestHeaders['If-Match'];
        } else if(array_key_exists('If-None-Match', $requestHeaders)) {
            $requestEtag = $requestHeaders['If-None-Match'];
        }
        if($requestEtag == $etag && array_key_exists('Range', $requestHeaders)) {
            header("HTTP/1.1: 206 Partial Content");
            header("Etag: $etag");
            $range = $requestHeaders['Range'];
            $range = explode("=", $range);
            $rangeSE = explode("-", $range[1]);
            $rangeS = $rangeSE[0];
            $rangeE = $rangeSE[1];
            header("Accept-Ranges: bytes");
            header('Content-Range: bytes ' . $range[1] . '/' . $filesize);
            header("Content-Type: application/pdf");
            $handle = fopen("annual_report_2009.pdf", "r+");
            fseek($handle, $rangeSE[0]);
            $readF = fread($handle, ($filesize - $rangeSE[0]));
            echo $readF;
        } else {
            header("Accept-Ranges: bytes");
            header("Content-Length: ".$filesize);
            header("HTTP/1.1: 200 OK");
            header("Content-Type: application/pdf");            
            echo $fileContents;
        }
    } else {
        if($_SERVER["REQUEST_METHOD"] == "HEAD") {
 			header("Etag: $etag");
            header("Content-Length: ". $filesize/2);
            header("Accept-Ranges: bytes");     
            header("Content-Encoding: none");
        } else {
        	header("Etag: $etag");
			header("Content-Length: ".$filesize);
            header("Accept-Ranges: bytes");
        	header("Content-Type: application/pdf");
            echo $fileContents;
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
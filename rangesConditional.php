<?php
    ob_end_clean();
    ini_set("output_buffering", "off");
    // ignore_user_abort(true);
    $requestHeaders = getallheaders();
    // print_r($requestHeaders);
    if(array_key_exists('HTTP_IF_NONE_MATCH', $requestHeaders) || array_key_exists('HTTP_IF_MATCH', $requestHeaders) || array_key_exists('HTTP_IF_MODIFIED_SINCE', $requestHeaders) || array_key_exists('HTTP_IF_UNMODIFIED_SINCE', $requestHeaders) || array_key_exists('HTTP_IF_RANGE', $requestHeaders)) {
    } else {
        
        header("Accept-Ranges: bytes");        
        header("HTTP/1.1: 200 OK");
        // header("Content-Disposition: attachment; filename=dummy.txt");
        // header("Content-Type: text/plain");
        $fileContents = file_get_contents('dummy.json');
        // header("Content-Length: ". strlen($fileContents));
        $payload = ["name" => "Kushagra Mishra", "age" => 30, "gender" => "male", "location" => "india", "wife" => "Ekta Mishra"];
        $etag = md5(json_encode($payload));
        header("Etag: $etag");
        $jsonClass = ["name" => "Kushagra Mishra", "age" => 30, "gender" => "male", "location" => "india", "wife" => "Ekta Mishra"];
        foreach($jsonClass as $key => $value) {
            echo $value;
            // ob_flush();
            flush();
            sleep(1);
        }
    }
?>
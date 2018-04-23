<?php
function callback($buffer)
{
  // replace all the apples with oranges
	$str = str_replace("html", "htmlns", $buffer);
	file_put_contents("obCallback2.txt", $str);
	return ($str);
}

ob_start("callback");
// ob_end_clean();
?>
<html hereismyattribute>
<cripple></cripple>
<bodyNS>
<p>It's like comparing apples to oranges.</p>
</bodyNS>
</html>
<?php
// sleep(10);
file_put_contents("obGetContents1.txt", ob_get_contents());
echo "after the contents taken";
file_put_contents("obGetContents1.1.txt", ob_get_contents());
ob_start(function($buffer) {
	$str = str_replace("there", "where", $buffer);
	file_put_contents("obCallback.txt", $str);
	return $str;
}); // this also goes to top buffer
echo "hi there";
file_put_contents("obGetContents2.txt", ob_get_contents());
// ob_end_flush(); // flushes to top buffer
// header("custom: custom");
// ob_end_clean();

?>
<?php

// sleep(10);
// var_dump(ob_get_contents());
// ob_start(function($buffer) {
// 	$str = str_replace("there", "where", $buffer);
// 	return $str;
// }); // this also goes to top buffer

// echo "hi there";
// flush();
// var_dump(ob_get_contents());
// ob_end_flush(); // flushes to top buffer
// header("custom: custom");
// ob_end_clean();
// ob_end_clean();
// ini_set('output_buffering', 'off');
// ini_set('zlib.output_compression', 0);
// header("Content-type: text/html");
// header("Content-Encoding: none"); // used with accept-encoding header from browser,
// ob_end_clean();
// ob_start();
// ob_start();
// for ($i = 0; $i<10; $i++){

//         echo "<br> Line to show.";
//         echo str_pad('-',4096, "$")."\n";    
//         ob_flush();
//         flush();
//         sleep(1);
// }

// If output buffering in not enabled then PHP will start sending the data diretly to browser but as browser uses http proto it wait for all the data to come and then presents the page.

// If tested in cli or terminal the terminal will start receiving the data when output buffering is off because it obeys tcp proto and not http.

// The Content-Encoding entity header is used to compress the media-type. When present, its value indicates which encodings were applied to the entity-body. It lets the client know, how to decode in order to obtain the media-type referenced by the Content-Type header.
/// Hence when we disable content-encoding browser doesnt have to wait to show the data by decoding.


// flush will flush the buffered data to the system buffer example to php fpm incase of php-fpm or to apache system in case of mod_php buffers.

// If working with php-fpm and apache and then we need to check if gzip compression is set in both if yes then we need to disable that before we can start doing live stream as ob_flush will flush to its parent buffer that is the buffer that is strated in php but it never flushes the output of the apache system buffers because php is connect to fpm and not apache directly so flush will only flush the data from fpm but not apache. 
// Hence the browser waits until apache level buffers are flushed.
// This works correctly in mod_php where php is directly connected to apache.

// Apache starts dumping because the buffer is full but browser doesnot show anything because it wait for full content to come and then it will decode the data at once and show.

// Ob_get_contents() gives the actual content that is within its scope thats why in above example we get correct html in for the first ob_get_contents but got only hi there for the second.
?>
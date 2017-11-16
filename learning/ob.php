<?php
/**
 * Created by PhpStorm.
 * User: root
 * Date: 24/9/17
 * Time: 11:56 AM
 */
//ob_end_flush();
//ob_end_clean();
//flush();
// starts a new buffer always . By default a new buffer is started all the time when php starts in fast-cgi or fpm which is disabled for cli for
// by default so if we use ob_end_flush and ob_end_clean together then ob_end_flush will flush the current buffer started by ob_start and
// ob_end_clean will flush the default php buffer or vice versa if order of both is changed
// Here we have started a new child buffer
ob_start();
// in order to start flushing output to parent buffer following settings are required
ini_set('zlib.output_compression', 0);
header("Content-Encoding: none");
//header( 'Content-type: text/html; charset=utf-8' );
//echo time();
setcookie("custom-x-cookies", "custom-x-value", time()+3600);
$multiplier = 4;
$size = 1024 * $multiplier;
$str = "";
$output = array();
$str = str_pad($str, $size, ".");
echo $str;
$output[1] = ob_get_contents(); // gets the contents of the current buffer
ob_flush(); // flushes php buffers to parent buffer and not directly to browser which are greater than 4KB in size
// similar to ob_flush we have ob_clean
$output[2] = ob_get_contents();
flush(); // flushes upper level wrapper buffers such as fpm and cgi
$output[3] = ob_get_contents();
ob_end_flush(); // flushes and stops further buffering sending the output to parent buffer
$output[4] = ob_get_contents(); // here we get empty instead of false because the top default buffer is still present
ob_end_clean(); // cleans and stops further buffering without sending the output
$output[5] = ob_get_contents(); // this and every output from here gets false because top default buffer is also removed
sleep(5);
echo $str;
$output[6] = ob_get_contents();
//ob_flush(); // this will generate error because we have used ob_end_flush and ob_end_clean methods which have stopped any further buffering
flush(); // This works while ob_flush does not because flush will flush any wrapper based buffers such as in fpm
$output[7] = ob_get_contents();
sleep(20);
echo "<br />Hello World";
$output[8] = ob_get_contents();
var_dump($output);


// Pair ob_get_contents() and ob_end_clean() can be replaced by a single function ob_get_clean()
// Similarly ob_get_contents() and ob_end_flush() can be replaced by a single function ob_get_flush().

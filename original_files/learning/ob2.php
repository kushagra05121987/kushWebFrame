<?php
/**
 * Created by PhpStorm.
 * User: root
 * Date: 24/9/17
 * Time: 6:29 PM
 */
//$handle = fopen('op.txt', 'a+');
ob_start(function($buffer, $phase) {
//    fwrite($handle, "BUFFER = ".$buffer);
//    fwrite($handle, "PHASE = ".$phase);
//    fwrite($handle, "\n");
    return $buffer;
}, 4096);
echo "Hello";
//ob_flush();
//flush();
//ob_clean();
//ob_end_flush();
//ob_end_flush();
ob_end_clean();
//ob_get_flush();
//ob_get_clean();
/**
 *  PHP_OUTPUT_HANDLER_CLEANABLE – you can call the function  ob_clean() and related
    PHP_OUTPUT_HANDLER_FLUSHABLE – you can call the  ob_flush()
    PHP_OUTPUT_HANDLER_REMOVABLE – buffer can be turned off
    PHP_OUTPUT_HANDLER_STDFLAGS – is a combination of all three flags, the default behavior
 */
error_reporting(E_ALL);
ini_set('display_errors', 1);
//ini_set('zlib.output_compression', 1);
ob_start('ob_gzhandler',16000, PHP_OUTPUT_HANDLER_FLUSHABLE);
echo "<div>Hello World</div>";
// For the Above case only ob_flush will work all others are blocked

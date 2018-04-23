<?php
header( 'Content-type: text/html; charset=utf-8' );
// this is the main thing to do
header( 'Content-Encoding: none' );


//    ob_end_clean();
//    ini_set("output_buffering", "off");
ini_set('zlib.output_compression', 0);
ini_set('implicit_flush',1);
for ($i = 0; $i<10; $i++) {
    echo "<br> Line to show. <div>";
    echo str_pad('-',4096, "$")."\n";
    echo "</div>";
    ob_flush();
    flush();
    sleep(1);
}
//echo "<br> Line to show. <div style='width: 100%; word-wrap: break-word'>";
//echo str_pad('-',6096, "$")."\n";
//echo "</div>";
////    ob_flush();
//    flush();
?>
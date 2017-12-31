<?php
// ob_implicit_flush(1);
ini_set('zlib.output_compression', 0);
header("Content-Encoding: none");
// ob_start();
ob_start(function($buffer) {
	return $buffer." added....";
});
$count = 0;
while($count <= 10) {
	echo PHP_EOL.$count.PHP_EOL;
	sleep(1);
	// ob_flush();
	++$count;
	if($count == 3) {
		var_dump("BUffer = ".ob_get_contents());
		flush();
	}
}
// flush();
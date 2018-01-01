<?php

header("Cache-Control: public, max-age=15");
// header("Expires: Wed, 21 Oct 2018 07:28:00 GMT");
// header("HTTP/1.1: 304 Not Modified");
echo "hello1";
echo "<a href='".$_SERVER['PHP_SELF']."'>Click</a>";

// 
<?php
	echo "<pre>";
	print_r(php_uname());

	putenv("this_is_my_var=this_is_my_var_value");
	getenv("this_is_my_var");
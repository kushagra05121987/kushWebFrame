<?php
	while(1) {
		echo "inside 1st ";
		while(1) {
			echo "inside 2nd";
			break 2;
		}
	}

	var_dump(json_decode("ping"));
?>
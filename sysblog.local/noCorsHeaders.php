<?php
header("Access-Control-Allow-Origin: http://localhost:9000");
header("Access-Control-Allow-Credentials: true");
#session_start();
// header("Access-Control-Allow-Headers: custom-x");
header("custom-x: custom-x-val");
header("custom-y: custom-y-val");
header("Access-Control-Expose-Headers: custom-x");

echo "OK";
?>
<div class="include_json">
    
</div>
<script type="text/javascript">
	fetch("http://sysblog.local:8080/echodate.php").then(function(response) {
	    console.log(response);
	    // console.log(response.json());
	    return response.text();
	}).then(function(json) {
	    var node = document.getElementsByClassName('include_json').item(0);
	    node.textContent = json;
	});
</script>
<?php

echo time();

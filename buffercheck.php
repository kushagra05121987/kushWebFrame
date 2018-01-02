<?php
    ob_end_clean();
    ini_set("output_buffering", "off");
    for ($i = 0; $i<10; $i++){
            echo "<br> Line to show.";
            echo str_pad('-',4096, "$")."\n";    
            // ob_flush();
            // flush();
            sleep(1);
    }
?>
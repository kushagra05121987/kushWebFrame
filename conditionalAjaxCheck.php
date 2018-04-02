<?php
    header("Access-Control-Allow-Origin: http://localhost:9000");
    header("Access-Control-Allow-Methods: GET, HEAD");
    header("Access-Control-Expose-Headers: Custom, Accept-Ranges, Content-Disposition, Content-Length, Etag");
    header("ETag: xyz");
    echo 'OK';
?>
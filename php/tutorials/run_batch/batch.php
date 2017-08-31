<?php
    $file = fopen("log.txt","w");
    echo fwrite($file,"Hello World. Testing!");
    fclose($file);
?>
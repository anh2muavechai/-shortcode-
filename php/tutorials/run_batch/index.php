<?php
/**
 * Cách truyền biến vào file batch là ghi ra 1 file sau đó đọc dữ liệu lên lại
 */
define("BATCH",__DIR__ . '/batch.bat' );
function _execute_batch_generate(){
    $cmd = BATCH ;
    pclose(popen("start /B ". $cmd, "r"));
}
echo "Run batch";
_execute_batch_generate();
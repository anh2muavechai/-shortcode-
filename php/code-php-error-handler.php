<?php
function errHandle($errNo, $errStr, $errFile, $errLine, $errContext) {
    $msg = "$errStr in $errFile on line $errLine";

    if ($errNo == E_NOTICE || $errNo == E_WARNING) {
        throw new ErrorException($msg, $errNo);
    } else {
        echo $msg;
        echo '<pre>';
    	print_r($errContext);
    }
}

$xmlArray=['foo'=>'bar'];
set_error_handler('errHandle');

trigger_error('test', E_USER_WARNING);
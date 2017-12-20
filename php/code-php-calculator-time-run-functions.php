<?php
$start = microtime(true);
while (...) {

}
$duration = microtime(true) - $start;
$hours    = (int)($duration/60/60);
$minutes  = (int)($duration/60)-$hours*60;
$seconds  = (int)$duration-$hours*60*60-$minutes*60;
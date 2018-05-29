<?php
define('TIME_STOP', '08:30:00'); //khai báo dang 24h
if (time() >= strtotime(self::TIME_STOP)) {
  break;
}
?>
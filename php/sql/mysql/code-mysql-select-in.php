<?php
$string = "1,2,3,4,5";
$array  = array_map('intval', explode(',', $string));
$array  = implode("','",$array);
$query  = mysqli_query($conn, "SELECT name FROM users WHERE id IN ('".$array."')");
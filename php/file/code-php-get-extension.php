<?php
if (is_file($file)) {
	$ext = pathinfo($file, PATHINFO_EXTENSION);
}
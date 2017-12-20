<?php
$file = 'D:\Desktop\New folder';
// $ext = pathinfo($file, PATHINFO_EXTENSION);
$filename = pathinfo($file, PATHINFO_FILENAME);
$dirname = pathinfo($file, PATHINFO_DIRNAME);
$new_file= $dirname.'/'.$filename.'_abcd';
rename($file,$new_file);
echo '<pre>';
// print_r( $ext );
// echo $filename;
echo $new_file;
echo '</pre>';
//exit;
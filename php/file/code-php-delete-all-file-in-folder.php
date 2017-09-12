<?php
$files = glob('path/to/temp/*'); // get all file names
foreach($files as $file){ // iterate files
  if(is_file($file))
    unlink($file); // delete file
}
$files = glob('path/to/temp/{,.}*', GLOB_BRACE);//nếu muốn xóa file ẩn
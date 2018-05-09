<?php
$zip = new ZipArchive;
$res = $zip->open('D:\Desktop\New folder (2)/logo.zip');
if ($res === TRUE) {
  $zip->extractTo('D:\Desktop\New folder (2)');
  $zip->close();
  echo 'woot!';
} else {
  echo 'doh!';
}
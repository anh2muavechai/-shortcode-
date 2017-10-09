<?php
$line = 'カテゴリ（直上）(category (ngay phía trên),シリーズ (series),項目名 (section name),タイトル (title),'.$item["filename"].', , , , ';
$fh   = fopen($resultFile, 'a+');
fwrite($fh,$line.PHP_EOL);
fclose($fh);
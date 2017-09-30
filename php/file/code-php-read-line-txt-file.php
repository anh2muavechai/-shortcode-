<?php
$datalist=file($path_to_txt_file);
		foreach($datalist as $line){
			//trim newlines at the end
			$line=chop($line);
			echo $line;

			//put your code for $line

		}
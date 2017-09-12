<!DOCTYPE html>
<html>
<head>
	<title></title>
</head>
<body>
	<?php
		$data = array( 1,2,3,4,5,6,7,8,9 );
		$i = 1;
		echo '<table>';
		foreach( $data as $v ){
			if( $i % 3 == 1 ){
				echo '<tr>';
			}
			echo "<td>$v</td>";
			if( $i % 3 == 0 ){
				echo '</tr>';
			}
			$i++;
		}
		if( $i % 3 != 0 ){
			echo '</tr>';
		}
		echo '</table>';
	?>
</body>
</html>
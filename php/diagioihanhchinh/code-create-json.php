<?php
$servername = "localhost:3360";
$username   = "root";
$password   = "";
$dbname     = "data_diagioihanhchinh";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "
	select tp.matp,tp.name as city,qh.maqh,qh.name as qh, xaa.xaid,xaa.name as tenxa
	from   moratatbl_tinh_thanhpho   as tp
	join   moratatbl_quanhuyen       as qh  on qh.matp = tp.matp
	left   join   moratatbl_xaphuongthitran as xaa on qh.maqh = xaa.maqh
	order by matp, maqh, xaid
";
$conn->query("SET NAMES 'utf8'");
$conn->query("SET CHARACTER SET utf8");
$conn->query("SET SESSION collation_connection = 'utf8_unicode_ci'");
$result = $conn->query($sql);
$file = 'D:\Desktop\diagioihanhchinh/diagioihanhchinh.js';
if ($result->num_rows > 0) {
    // output data of each row
    // while($row = $result->fetch_object()) {
    while($row = $result->fetch_assoc()) {
    	$data[$row['matp'].':'.$row['city']][$row['maqh'].':'.$row['qh']][] = $row;
    }
    echo '<pre>';
    print_r( $data );
    echo '</pre>';
    //exit;
    $data = json_encode($data);
    // file_put_contents($file, $data);
} else {
    echo "0 results";
}
$conn->close();
?>
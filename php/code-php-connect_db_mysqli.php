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
if ($result->num_rows > 0) {
    // output data of each row
    // while($row = $result->fetch_object()) {
    while($row = $result->fetch_assoc()) {

    }
} else {
    echo "0 results";
}
$conn->close();
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <title>Bootstrap 101 Template</title>

    <!-- Bootstrap -->
    <!-- <link href="css/bootstrap.min.css" rel="stylesheet"> -->
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet">

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>
  <body>
    <h1>Hello, world!</h1>

    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <!-- <script src="js/bootstrap.min.js"></script> -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css"></script>
  </body>
</html>
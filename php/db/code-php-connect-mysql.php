<?php
$conn=mysql_connect("localhost","root","root") or die("can't connect this database");
mysql_select_db("project",$conn);

$sql="select * from user where username='".$u."' and password='".$p."'";
$query=mysql_query($sql);
if(mysql_num_rows($query) == 0){
	echo "Username or password is not correct, please try again";
}else{
	$row=mysql_fetch_array($query);
}
?>
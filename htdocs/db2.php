<?php
$servername = "localhost";
$username = "root";
$password = "";

$_conn = mysqli_connect($servername,$username,$password);
if(!$_conn){
die("connection failed!".mysqli_connect_error($_conn));
}else{
echo "connection successfull";
}
echo "<br>";

$sql = "CREATE DATABASE university";
$result = mysqli_query($_conn,$sql);
if($result){
echo "database created";
}else{
echo "database not created".mysqli_error($_conn);
}
?>
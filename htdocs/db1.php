<?php
$servername = "localhost";
$username = "root";
$password = "";

$_conn = mysqli_connect($servername,$username,$password);
if(!$_conn){
die("sorry, failed to connect: ". mysqli_connect_error());
}else{
echo "connection successful!";
}
echo "<br>";

$sql = "CREATE DATABASE seminar3";
$result = mysqli_query($_conn,$sql);
if($result){
echo "database created!";
}
else{
echo "database not created".mysqli_error($_conn);
}
?>
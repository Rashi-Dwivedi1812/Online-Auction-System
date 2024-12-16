<?php
$servername = "localhost";
$username = "root";
$password = "";
$database = "university";

$_conn = mysqli_connect($servername,$username,$password,$database);
if(!$_conn){
die("connection failed!".mysqli_connect_error($_conn));
}else{
echo "connection successfull";
}
echo "<br>";

$sql = "CREATE TABLE `enrollment` (`Student_Name` VARCHAR(10) NULL , `Department` VARCHAR(10) NOT NULL , `Course_Name` VARCHAR(10) NOT NULL)";
$result = mysqli_query($_conn,$sql);
if($result){
echo "table created";
}else{
echo "table not created".mysqli_error($_conn);
}
?>
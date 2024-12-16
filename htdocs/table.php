<?php
$servername = "localhost";
$username = "root";
$password = "";
$database = "seminar1";

$_conn = mysqli_connect($servername,$username,$password,$database);
if(!$_conn){
die("connection failed".mysqli_connect_error());
}else{
echo "connection successful!";
}
echo"<br>";

$sql = "CREATE TABLE `seminarreggg` (`Participant_Name` VARCHAR(11) NULL , `email` TEXT NOT NULL ,
 `Phone_Number` INT(13) NOT NULL , `Seminar_Title` TEXT NOT NULL )";
$result = mysqli_query($_conn,$sql);
if($result){
echo "table created";
}else{
echo "table not created".mysqli_error($_conn);
}

?>
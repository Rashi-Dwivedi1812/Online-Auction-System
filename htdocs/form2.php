<?php
$servername = "localhost";
$username = "root";
$password = "";
$database = "university";

$_conn = mysqli_connect($servername,$username,$password,$database);

if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['register'])){
$student_name = $_POST['Student_name'];
$department = $_POST['Department'];
$course_Name = $_POST['Course_name'];
$sql = "INSERT INTO `enrollment` (Student_name, Department, Course_name)
            VALUES ('$student_name', '$department', '$course_Name')";   
$result = mysqli_query($_conn,$sql);
if($result){
echo "data inserted";
}else{
echo "data not inserted".mysqli_error($_conn);
}
}

if (isset($_POST['highest_course_enrollments'])) {
    $summary = "SELECT Course_name, COUNT(*) AS enrollment_count 
            FROM enrollment 
            GROUP BY Course_name 
            ORDER BY enrollment_count DESC 
            LIMIT 1";
    $result = mysqli_query($_conn, $summary);
    
    if (mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        echo "<h3>Course with highest enrollments: " . $row['Course_name'] . " with " . $row['enrollment_count'] . " enrollments.</h3>";
    } else {
        echo "No enrollments found.";
    }
}
?>

<html>
<head>
<title>registration</title>
</head>
<body>

<h2>Enrollment details</h2>
<form method = "POST" action ="">
<label for="Student_name">Student Name:</label><br>
    <input type="text" name="Student_name" required><br><br>
    
    <label for="Department">Department:</label><br>
    <input type="text" name="Department" required><br><br>
    
    <label for="Course_name">Course Name:</label><br>
    <input type="text" name="Course_name" required><br><br>

    <input type="submit" name="register" value="Register">
</form>

<h2>Check Highest Course Enrollments</h2>
<form method="POST" action="">
    <input type="submit" name="highest_course_enrollments" value="Show Highest Course Enrollments">
</form>

</body>
</html>
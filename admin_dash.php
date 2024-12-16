<?php
require 'connection.php';
session_start();

if ($_SESSION['role'] !== 'Admin') {
    echo "Access denied.";
    exit;
}

$sql = "SELECT * FROM Users";
$result = $conn->query($sql);

echo "<h1>Admin Dashboard</h1>";
echo "<table border='1'>";
echo "<tr><th>UserID</th><th>Username</th><th>Email</th><th>Role</th></tr>";
while ($row = $result->fetch_assoc()) {
    echo "<tr><td>{$row['UserID']}</td><td>{$row['Username']}</td><td>{$row['Email']}</td><td>{$row['Role']}</td></tr>";
}
echo "</table>";
?>
<?php
// Database connection parameters
$host = 'localhost';        // The database host (usually 'localhost' or an IP address)
$dbname = 'auction_system';  // The name of your database
$username = 'root';         // The MySQL username (default is 'root' on local servers)
$password = '';             // The MySQL password (default is empty for local servers)

try {
    // Create a new PDO instance and set the connection attributes
    $conn = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    
    // Set the PDO error mode to exception for better error handling
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    // Optionally, set the charset to UTF-8 to handle special characters
    $conn->exec("SET NAMES 'utf8'");
    
    // echo "Connected successfully";  // Uncomment to test the connection (for debugging purposes)
} catch (PDOException $e) {
    // If the connection fails, display an error message
    echo "Connection failed: " . $e->getMessage();
    exit();
}
$sql = "SELECT * FROM Users";
$stmt = $conn->prepare($sql);
$stmt->execute();
$users = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Display the results
foreach ($users as $user) {
    echo "Username: " . $user['Username'] . "<br>";
    echo "Email: " . $user['Email'] . "<br>";
    echo "Role: " . $user['Role'] . "<br><br>";
}
?>

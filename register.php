<?php
session_start();  // Start the session if needed

// Ensure the form was submitted via POST method
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    require('connection.php');  // Include your database connection

    // Sanitize and validate user inputs
    $username = trim($_POST['username']);
    $email = trim($_POST['email']);
    $password = $_POST['password'];
    $role = $_POST['role'];

    // Basic validation
    if (empty($username) || empty($email) || empty($password) || empty($role)) {
        echo "All fields are required.";
        exit();
    }

    // Validate email format
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo "Invalid email format.";
        exit();
    }

    // Hash the password
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // Prepare the SQL query to insert data into the users table
    $stmt = $conn->prepare("INSERT INTO users (username, email, password, role) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssss", $username, $email, $hashed_password, $role);
    
    // Execute the query and check for success
    if ($stmt->execute()) {
        echo "Registration successful! <a href='login.php'>Login</a>";
        
        // Redirect to the appropriate page based on the role
        if ($role == 'buyer') {
            header("Location: buyers.html");  // Redirect to buyer's page
        } elseif ($role == 'seller') {
            header("Location: seller.html");  // Redirect to seller's page
        }
        
        exit();
    } else {
        // Error during registration
        echo "Error: " . $stmt->error;
    }

    // Close the statement
    $stmt->close();
}
?>

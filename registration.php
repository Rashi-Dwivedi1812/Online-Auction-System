<?php
require 'db_config.php'; // Assuming db.php is the file that connects to the database

// Capture form data (email, password, etc.)
$username = $_POST['username'];
$email = $_POST['email'];
$password = password_hash($_POST['password'], PASSWORD_BCRYPT);  // Hash the password for security
$token = bin2hex(random_bytes(50));  // Generate a unique verification token

// Insert user data into the Users table
$sql = "INSERT INTO Users (Username, Email, Password, Token, is_verified) VALUES (?, ?, ?, ?, 0)";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ssss", $username, $email, $password, $token);
$stmt->execute();

// Send email with verification link
$verification_link = "http://yourwebsite.com/verify_email.php?token=" . $token;
$subject = "Please verify your email address";
$message = "Click the link below to verify your email address:\n" . $verification_link;
$headers = "From: no-reply@yourwebsite.com\r\n";

if (mail($email, $subject, $message, $headers)) {
    echo "Registration successful! Please check your email to verify your account.";
} else {
    echo "Error sending verification email.";
}
?>

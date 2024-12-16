<?php
require 'db_config.php'; // Assuming db.php connects to the database

// Check if the token exists in the URL
if (isset($_GET['token'])) {
    $token = $_GET['token'];

    // Search for the user with the provided token
    $sql = "SELECT * FROM Users WHERE Token = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $token);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 1) {
        // Token found, update the user's verification status
        $update_sql = "UPDATE Users SET is_verified = 1 WHERE Token = ?";
        $update_stmt = $conn->prepare($update_sql);
        $update_stmt->bind_param("s", $token);
        $update_stmt->execute();

        echo "Your email has been verified successfully! You can now log in.";
    } else {
        echo "Invalid or expired token.";
    }
} else {
    echo "No token provided.";
}
?>

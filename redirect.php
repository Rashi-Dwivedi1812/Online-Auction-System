<?php
session_start();  // Start session to store user data if needed

// Check if the form was submitted and the role is set
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['role'])) {
    $role = $_POST['role'];

    // Store the role in the session to track the user's role
    $_SESSION['role'] = $role;

    // Redirect to the appropriate page based on the selected role
    if ($role == 'Buyer') {
        header("Location: buyers.php");
        exit();  // Make sure to stop further execution after redirection
    } elseif ($role == 'Seller') {
        header("Location: seller.php");
        exit();
    } else {
        // Handle invalid role
        echo "Invalid role selected.";
    }
} else {
    // If no role is selected, redirect back to the role selection page
    header("Location: redirect.html");
    exit();
}
?>

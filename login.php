<?php
session_start(); // Start the session

// Check if the user is already logged in
if (isset($_SESSION['user_id'])) {
    header("Location: redirect.php"); // Redirect to the role selection page or a dashboard if logged in
    exit();
}

// Check if the login form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    require('connection.php'); // Include your database connection

    // Sanitize and retrieve form input
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Validate input fields
    if (empty($email) || empty($password)) {
        $error_message = "Please fill in all fields.";
    } else {
        // Prepare SQL query to fetch the user by email
        $stmt = $conn->prepare("SELECT UserID, username, email, password, role FROM users WHERE email = ?");
        $stmt->bind_param("s", $email);  // "s" stands for string type (email)

        if ($stmt->execute()) {
            $result = $stmt->get_result();

            if ($result->num_rows > 0) {
                $user = $result->fetch_assoc();
                
                // Verify the password with the hashed password stored in the database
                if (password_verify($password, $user['password'])) {
                    // Password is correct, set session variables
                    $_SESSION['user_id'] = $user['UserID'];
                    $_SESSION['username'] = $user['username'];
                    $_SESSION['email'] = $user['email'];
                    $_SESSION['role'] = $user['role'];

                    // Redirect the user to the appropriate dashboard based on their role
                    if ($user['role'] == 'Buyer') {
                        header("Location: buyers.php");
                    } elseif ($user['role'] == 'Seller') {
                        header("Location: seller.php");
                    } elseif ($user['role'] == 'Admin') {
                        header("Location: admin_dash.php");
                    }
                    exit();
                } else {
                    $error_message = "Invalid password.";
                }
            } else {
                $error_message = "No account found with that email address.";
            }
        } else {
            $error_message = "Error: " . $stmt->error;
        }

        $stmt->close();  // Close the prepared statement
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Online Auction System</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="container">
        <header>
            <h1>Login</h1>
        </header>

        <div class="login-container">
            <?php
            if (isset($error_message)) {
                echo "<div class='error'>$error_message</div>";
            }
            ?>

            <form action="login.php" method="POST">
                <label for="email">Email:</label>
                <input type="email" name="email" required>

                <label for="password">Password:</label>
                <input type="password" name="password" required>

                <button type="submit">Login</button>
            </form>

            <p>Don't have an account? <a href="register.html">Register here</a></p>
        </div>
    </div>
</body>
</html>

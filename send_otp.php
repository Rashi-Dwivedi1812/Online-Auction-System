<?php
// Send OTP via email
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = json_decode(file_get_contents('php://input'), true);
    $email = $data['email'];

    // Generate OTP (for example, a 6-digit random number)
    $otp = rand(100000, 999999);

    // Store OTP in session (or a database in a real application)
    session_start();
    $_SESSION['otp'] = $otp;
    $_SESSION['otp_email'] = $email;

    // Send OTP to Gmail email address
    $subject = "Your OTP for Registration";
    $message = "Your OTP for registration is: $otp";
    $headers = "From: no-reply@example.com\r\n";

    // Use PHP's mail function (you can use a real SMTP service in production)
    $mail_sent = mail($email, $subject, $message, $headers);

    // Return response
    if ($mail_sent) {
        echo json_encode(["success" => true]);
    } else {
        echo json_encode(["success" => false]);
    }
}
?>

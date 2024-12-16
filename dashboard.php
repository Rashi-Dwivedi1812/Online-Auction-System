<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.html");
    exit;
}

if ($_SESSION['role'] === 'Admin') {
    header("Location: admin_dash.php");
    exit;
} elseif ($_SESSION['role'] === 'Seller') {
    header("Location: seller.php");
    // Add seller dashboard features here
} elseif ($_SESSION['role'] === 'Buyer') {
    header("Location: buyers.php");
    // Add buyer dashboard features here
}

<?php
include '../components/connect.php';

// Check if seller_id cookie exists
if (!isset($_COOKIE['seller_id'])) {
    header('location:login.php');
    exit;
}

// Validate seller_id in the database
$seller_id = $_COOKIE['seller_id'];
$seller_check_stmt = $con->prepare("SELECT id FROM `sellers` WHERE id = ?");
$seller_check_stmt->bind_param("i", $seller_id);
$seller_check_stmt->execute();
$seller_check_result = $seller_check_stmt->get_result();

if ($seller_check_result->num_rows == 0) {
    setcookie("seller_id", "", time() - 3600, "/"); // Clear the invalid cookie
    header('location:login.php');
    exit;
}
?>

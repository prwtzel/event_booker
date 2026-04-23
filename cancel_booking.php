<?php
include 'db.php';
session_start();

if (!isset($_SESSION['customer_id'])) {
    header("Location: customer_login.php");
    exit();
}

if (isset($_GET['id'])) {

    $booking_id = $_GET['id'];
    $customer_id = $_SESSION['customer_id'];

    // Only allow cancel own booking AND only if still pending
    $stmt = $conn->prepare("
        UPDATE bookings 
        SET status = 'Cancelled'
        WHERE booking_id = ? 
        AND customer_id = ?
        AND status = 'Pending'
    ");

    $stmt->bind_param("ii", $booking_id, $customer_id);
    $stmt->execute();

}

header("Location: customer_dashboard.php?cancel=success");
exit();
?>
<?php
include 'db.php';

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
$status = isset($_GET['status']) ? $_GET['status'] : '';

if ($id > 0 && ($status == 'Approved' || $status == 'Rejected' || $status == 'Pending')) {

    $stmt = $conn->prepare("UPDATE bookings SET status=? WHERE booking_id=?");
    $stmt->bind_param("si", $status, $id);
    $stmt->execute();
}

header("Location: dashboard.php");
exit();
?>
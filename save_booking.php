<?php
session_start();
include 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // ✅ GET FROM SESSION (NOT POST)
    if (!isset($_SESSION['customer_id'])) {
        die("User not logged in");
    }

    $customer_id = $_SESSION['customer_id'];

    // FORM DATA
    $venue = $_POST['venue'] ?? '';
    $guests = $_POST['guests'] ?? 0;
    $event_date = $_POST['event_date'] ?? '';
    $event_type = $_POST['event_type'] ?? '';

    // VALIDATION
    if (!$venue || !$guests || !$event_date) {
        die("Please fill all fields");
    }

    // ✅ SAFE INSERT (PREPARED STATEMENT)
    $stmt = $conn->prepare("
        INSERT INTO bookings (customer_id, venue, guests, event_date, event_type, status)
        VALUES (?, ?, ?, ?, ?, 'Pending')
    ");

    $stmt->bind_param("isiss", $customer_id, $venue, $guests, $event_date, $event_type);

    if ($stmt->execute()) {
        header("Location: customer_dashboard.php?success=1");
        exit();
    } else {
        die("Error: " . $stmt->error);
    }
}
?>
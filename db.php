<?php
$conn = new mysqli("localhost", "root", "", "eventbookersystem");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} else {
}
?>
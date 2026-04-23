<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

/* CHANGE THIS if your session name is different */
if (!isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit();
}

/* PREVENT CACHE (fixes back button issue) */
header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");
?>
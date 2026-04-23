<?php
session_start();

/* CLEAR SESSION DATA */
$_SESSION = [];
session_unset();
session_destroy();

/* PREVENT CACHE (IMPORTANT FOR BACK BUTTON FIX) */
header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");

/* REDIRECT TO LOGIN */
header("Location: login.php");
exit();
?>
<?php

// Start session safely
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

/* Prevent browser caching (prevents back button after logout) */
header("Cache-Control: no-cache, no-store, must-revalidate");
header("Pragma: no-cache");
header("Expires: 0");

/* Check if user logged in */
if (!isset($_SESSION['id']) || !isset($_SESSION['role'])) {
    header("Location: ../login.php");
    exit();
}

/* Auto Logout After 10 Minutes Inactivity */
$timeout = 600; // seconds

if (isset($_SESSION['last_activity']) && (time() - $_SESSION['last_activity']) > $timeout) {

    session_unset();
    session_destroy();

    header("Location: ../login.php?timeout=1");
    exit();
}

/* Update last activity time */
$_SESSION['last_activity'] = time();

?>
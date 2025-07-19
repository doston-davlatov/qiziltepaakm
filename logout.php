<?php
session_start();

// Log the logout activity
if (isset($_SESSION['user_id'])) {
    require_once './includes/db_connect.php';
    require_once './includes/functions.php';
    
    logActivity('User logged out', $_SESSION['user_id']);
}

// Destroy the session
session_destroy();

// Redirect to login page
header('Location: login.php?message=logged_out');
exit();
?>
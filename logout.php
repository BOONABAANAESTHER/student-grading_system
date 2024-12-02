<?php
// Start the session
session_start();

// Destroy the session
session_unset();
session_destroy();

// Redirect to login page
header("Location: login.php"); // Adjust this path if your login page is named differently
exit();
?>

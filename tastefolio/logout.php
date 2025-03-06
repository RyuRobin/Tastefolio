<?php
session_start(); // Start the session
session_unset(); // Unset all session variables
session_destroy(); // Destroy the session

// Redirect to the home page or login page
header('Location: ../home.php');
exit;
?>

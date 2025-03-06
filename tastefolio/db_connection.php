<?php
// db_connection.php

// Database credentials
$servername = "localhost"; // Default for local development
$username = "ryuy";        // Default username for MAMP
$password = "11Yryu05!@#";        // Default password for MAMP
$dbname = "ryuy_tastefolio";   // Database name as per your SQL schema

// Create a new database connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Optional: Set character encoding to UTF-8 for proper handling of special characters
if (!$conn->set_charset("utf8mb4")) {
    die("Error loading character set utf8mb4: " . $conn->error);
}
?>

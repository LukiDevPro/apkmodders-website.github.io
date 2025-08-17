<?php
// Database configuration
$db_host = 'sql113.iceiy.com';
$db_user = 'icei_39247129';
$db_pass = '5zJ1ndsX2jV7';
$db_name = 'icei_39247129_apkmoddersdb';

// Create connection
$conn = new mysqli($db_host, $db_user, $db_pass, $db_name);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Set charset to utf8mb4
$conn->set_charset("utf8mb4");

// Maintenance mode (set to true to enable maintenance mode)
$maintenance_mode = true;

// Start session if not already started
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
?>

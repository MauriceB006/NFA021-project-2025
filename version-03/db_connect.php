<?php
// Database configuration
$host = "localhost";
$username = "root";
$password = "";          // Default XAMPP password is empty
$database = "project";

// Create connection
$conn = new mysqli($host, $username, $password, $database);

// Check connection and show status
if ($conn->connect_error) {
    die("<div style='padding: 10px; margin: 20px; border: 2px solid red; background: #ffeeee;'>
        <strong>Database Connection Failed:</strong> " . $conn->connect_error . "
        <p>Check your database credentials and make sure MySQL is running.</p>
        </div>");
} else {
    // Only show success message if we're not in a production environment
    if ($_SERVER['SERVER_NAME'] == 'localhost') {
        echo "<div style='padding: 10px; margin: 20px; border: 2px solid green; background: #eeffee;'>
            <strong>Database Connected Successfully!</strong>
            <p>Connected to database: " . $database . "</p>
            <p>Server version: " . $conn->server_info . "</p>
            </div>";
    }
}

// Set charset to UTF-8
$conn->set_charset("utf8mb4");

// Security measure - prevent direct access
if (basename($_SERVER['PHP_SELF']) == 'db_connect.php') {
    die("<div style='padding: 10px; margin: 20px; border: 2px solid red; background: #ffeeee;'>
        Access denied. This file should be included in other PHP files, not accessed directly.
        </div>");
}
?>
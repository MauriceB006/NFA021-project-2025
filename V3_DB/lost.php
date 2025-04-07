<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Debugging: Log POST data
file_put_contents('debug.log', print_r($_POST, true), FILE_APPEND);

// Database connection
$conn = new mysqli('localhost', 'root', '', 'project');
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Validate and sanitize input
$name = $conn->real_escape_string($_POST['user_name'] ?? '');
$contact = $conn->real_escape_string($_POST['contact_info'] ?? '');
$line_id = (int)($_POST['route_line'] ?? 0);
$date = $conn->real_escape_string($_POST['lost_date'] ?? '');
$description = $conn->real_escape_string($_POST['item_description'] ?? '');

// Validate required fields
if (empty($name) || empty($contact) || empty($date) || empty($description) || $line_id === 0) {
    $_SESSION['error'] = "All fields are required!";
    header("Location: lost_items_form.html"); // Redirect back to form
    exit();
}

// Insert into database
$stmt = $conn->prepare("INSERT INTO lostitems 
    (user_name, line_id, item_description, lost_date, contact_info) 
    VALUES (?, ?, ?, ?, ?)");

if (!$stmt) {
    die("Prepare failed: " . $conn->error);
}

$stmt->bind_param("sisss", $name, $line_id, $description, $date, $contact);

if ($stmt->execute()) {
    $_SESSION['success'] = "Item reported successfully!";
} else {
    $_SESSION['error'] = "Error: " . $stmt->error;
}

$stmt->close();
$conn->close();

// Redirect back to form
header("Location: lostV3.html");
exit();
?>
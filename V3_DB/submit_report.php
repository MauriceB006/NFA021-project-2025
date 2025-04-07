<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Database connection
$conn = new mysqli('localhost', 'root', '', 'project');
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
$conn = new mysqli('localhost', 'root', '', 'project');
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} else {
    echo "✅ Connected to database 'project' successfully!";
    exit(); // Stop the script here temporarily
}

// Sanitize form data
$name = $conn->real_escape_string($_POST['name'] ?? '');
$contact = $conn->real_escape_string($_POST['contact'] ?? '');
$line = $conn->real_escape_string($_POST['line'] ?? '');
$date = $conn->real_escape_string($_POST['date'] ?? '');
$time = $conn->real_escape_string($_POST['time'] ?? '');
$description = $conn->real_escape_string($_POST['description'] ?? '');
$is_public = ($_POST['public'] ?? 'no') === 'yes' ? 1 : 0;

// Convert line name to line_id
$line_id_map = [
    'Line B1' => 1,
    'Line B2' => 2,
    'Line B3' => 3
];
$line_id = $line_id_map[$line] ?? 0;

// Validate required fields
if (empty($name) || empty($contact) || empty($date) || empty($time) || empty($description)) {
    $_SESSION['error'] = "All fields are required!";
    header("Location: reportV3.html");
    exit();
}

// Insert into database
$stmt = $conn->prepare("INSERT INTO reports 
    (user_id, line_id, report_type, description, incident_date, incident_time, is_public, status, created_at) 
    VALUES (?, ?, ?, ?, ?, ?, ?, 'pending', NOW())");

if (!$stmt) {
    die("Prepare failed: " . $conn->error);
}

$user_id = 1; // Dummy user ID, replace with actual session user ID
$report_type = 'incident';

$stmt->bind_param("iissssi", $user_id, $line_id, $report_type, $description, $date, $time, $is_public);

if ($stmt->execute()) {
    $_SESSION['success'] = "Report submitted successfully!";
} else {
    $_SESSION['error'] = "Error: " . $stmt->error;
}

$stmt->close();
$conn->close();

// Redirect
header("Location: reportV3.html");
exit();
?>

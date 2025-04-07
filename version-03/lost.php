<?php
require_once __DIR__ . '/db_connect.php';

// Sanitize and validate input data
$user_id = filter_input(INPUT_POST, 'user_id', FILTER_VALIDATE_INT);
$line_id = filter_input(INPUT_POST, 'line_id', FILTER_VALIDATE_INT);
$item_description = htmlspecialchars($_POST['item_description']);
$lost_date = $_POST['lost_date'];
$contact_info = htmlspecialchars($_POST['contact_info']);
$status = in_array($_POST['status'], ['pending', 'found', 'claimed']) ? $_POST['status'] : 'pending';

// Prepare SQL statement to prevent SQL injection
$stmt = $conn->prepare("INSERT INTO lostitems 
    (user_id, line_id, item_description, lost_date, contact_info, status) 
    VALUES (?, ?, ?, ?, ?, ?)");

$stmt->bind_param("iissss", $user_id, $line_id, $item_description, $lost_date, $contact_info, $status);

// Execute and check for errors
if ($stmt->execute()) {
    echo "<h1>Report Submitted Successfully</h1>";
    echo "<p>Your lost item has been recorded. Reference ID: " . $stmt->insert_id . "</p>";
} else {
    echo "<h1>Error Submitting Report</h1>";
    echo "<p>Error: " . $stmt->error . "</p>";
}
echo("hello world");
$stmt->close();
$conn->close();
?>
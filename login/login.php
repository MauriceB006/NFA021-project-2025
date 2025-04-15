<?php
// Include database connection
require 'db_connect.php';

// Get form data
$name = $_POST['name'];
$email = $_POST['email'];
$phone = $_POST['phone'];

// Insert into specific table only (passenger table in this example)
try {
    $sql = "INSERT INTO passenger (full_name, email, phone) VALUES (:name, :email, :phone)";
    
    $stmt = $conn->prepare($sql);
    
    $stmt->bindParam(':name', $name);
    $stmt->bindParam(':email', $email);
    $stmt->bindParam(':phone', $phone);
    
    $stmt->execute();
    
    echo "Record added successfully to passenger table!";
} catch(PDOException $e) {
    echo "Error: " . $e->getMessage();
}

$conn = null; // Close connection
?>

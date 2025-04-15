<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Create debug log
file_put_contents('debug.log', "Script started\n", FILE_APPEND);
file_put_contents('debug.log', print_r($_POST, true)."\n", FILE_APPEND);

$conn = new mysqli("localhost", "root", "", "project");

if ($conn->connect_error) {
    file_put_contents('debug.log', "DB connection failed: ".$conn->connect_error."\n", FILE_APPEND);
    die("Connection failed: " . $conn->connect_error);
} else {
    file_put_contents('debug.log', "DB connected successfully\n", FILE_APPEND);
}

// Handle Registration
if (isset($_POST['register'])) {
    file_put_contents('debug.log', "Register form detected\n", FILE_APPEND);
    
    // Verify all required fields
    $required = ['full_name', 'email', 'phone', 'password'];
    foreach ($required as $field) {
        if (empty($_POST[$field])) {
            $_SESSION['errors'] = ["All fields are required"];
            header("Location: sign_in.php");
            exit();
        }
    }

    $full_name = $conn->real_escape_string($_POST['full_name']);
    $email = $conn->real_escape_string($_POST['email']);
    $phone = $conn->real_escape_string($_POST['phone']);
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    
    file_put_contents('debug.log', "Processed form data:\nName: $full_name\nEmail: $email\nPhone: $phone\n", FILE_APPEND);

    // Check if email exists
    $check = $conn->prepare("SELECT user_id FROM users WHERE email = ?");
    if (!$check) {
        file_put_contents('debug.log', "Prepare failed: ".$conn->error."\n", FILE_APPEND);
        die("Prepare failed: " . $conn->error);
    }
    
    $check->bind_param("s", $email);
    $check->execute();
    $check->store_result();
    
    if ($check->num_rows > 0) {
        file_put_contents('debug.log', "Duplicate email detected: $email\n", FILE_APPEND);
        $_SESSION['errors'] = ["This email is already registered. Please login instead."];
        $_SESSION['form_data'] = $_POST; // Save all form data
        header("Location: sign_in.php");
        exit();
    }
    
    // Insert new user
    $stmt = $conn->prepare("INSERT INTO users (full_name, email, phone, password_hash) VALUES (?, ?, ?, ?)");
    if (!$stmt) {
        file_put_contents('debug.log', "Prepare failed: ".$conn->error."\n", FILE_APPEND);
        die("Prepare failed: " . $conn->error);
    }
    
    $stmt->bind_param("ssss", $full_name, $email, $phone, $password);
    
    if ($stmt->execute()) {
        file_put_contents('debug.log', "Registration successful for $email\n", FILE_APPEND);
        $_SESSION['user_id'] = $conn->insert_id;
        $_SESSION['user_name'] = $full_name;
        header("Location: indexV3.html");
        exit();
    } else {
        file_put_contents('debug.log', "Registration failed: ".$stmt->error."\n", FILE_APPEND);
        $_SESSION['errors'] = ["Registration failed: ".$stmt->error];
        header("Location: sign_in.php");
        exit();
    }
}

file_put_contents('debug.log', "Reached end of script without processing\n", FILE_APPEND);
$_SESSION['errors'] = ["No form submission detected"];
header("Location: sign_in.php");
exit();
?>
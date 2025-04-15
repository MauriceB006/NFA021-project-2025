<?php
$host = 'localhost';
$dbname = 'actc_public_transportation';
$username = 'root'; // default XAMPP username
$password = '';     // default XAMPP password

try {
    $conn = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}
?>
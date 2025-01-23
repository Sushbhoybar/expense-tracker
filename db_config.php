<?php
$host = 'localhost';
$user = 'sggsappc_AdminSGGSapp';
$password = 'adminsggsapp@123';
$databaseName = 'sggsappc_ExpenseTracker';

try {
    $conn = new PDO("mysql:host=$host;dbname=$databaseName", $user, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}
?>

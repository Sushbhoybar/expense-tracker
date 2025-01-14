<?php
$hostName = 'localhost';
$userName = 'root';
$password = 'sushil@z23';
$databaseName = 'ExpenseTracker';

// Create a connection to the database
$conn = new mysqli($hostName, $userName, $password, $databaseName);

// Check for connection errors
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>

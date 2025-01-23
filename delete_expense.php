<?php
include 'db_config.php';
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

if (!isset($_GET['id'])) {
    header("Location: dashboard.php");
    exit();
}

$expenseId = $_GET['id'];
$userId = $_SESSION['user_id'];

$stmt = $conn->prepare("DELETE FROM expenses WHERE id = :id AND user_id = :user_id");
$stmt->bindParam(':id', $expenseId);
$stmt->bindParam(':user_id', $userId);

if ($stmt->execute()) {
    header("Location: dashboard.php");
    exit();
} else {
    echo "Failed to delete expense.";
}
?>

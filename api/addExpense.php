<?php
require_once 'config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $category = $_POST['category'];
    $amount = $_POST['amount'];
    $comments = $_POST['comments'];

    // Insert the expense into the database
    $stmt = $conn->prepare("INSERT INTO expenses (user_id, category, amount, comments, created_at, updated_at) VALUES (?, ?, ?, ?, NOW(), NOW())");
    $stmt->bind_param("issi", $user_id, $category, $amount, $comments);

    // Assuming you have session for user authentication
    $user_id = $_SESSION['user_id']; // Get user ID from session

    if ($stmt->execute()) {
        echo "Expense added successfully!";
    } else {
        echo "Error: " . $stmt->error;
    }
}
?>

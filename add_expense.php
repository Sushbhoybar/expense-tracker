<?php
include 'db_config.php';
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $category = $_POST['category'];
    $amount = $_POST['amount'];
    $comments = $_POST['comments'];
    $userId = $_SESSION['user_id'];

    $stmt = $conn->prepare("INSERT INTO expenses (user_id, category, amount, comments) VALUES (:user_id, :category, :amount, :comments)");
    $stmt->bindParam(':user_id', $userId);
    $stmt->bindParam(':category', $category);
    $stmt->bindParam(':amount', $amount);
    $stmt->bindParam(':comments', $comments);

    if ($stmt->execute()) {
        header("Location: dashboard.php");
        exit();
    } else {
        $error = "Failed to add expense.";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Expense</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <h1>Add New Expense</h1>
    <?php if (!empty($error)) echo "<p style='color:red;'>$error</p>"; ?>
    <form method="POST">
        <input type="text" name="category" placeholder="Category" required>
        <input type="number" name="amount" placeholder="Amount" required>
        <textarea name="comments" placeholder="Comments (Optional)"></textarea>
        <button type="submit">Add Expense</button>
    </form>
</body>
</html>

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

$stmt = $conn->prepare("SELECT * FROM expenses WHERE id = :id AND user_id = :user_id");
$stmt->bindParam(':id', $expenseId);
$stmt->bindParam(':user_id', $userId);
$stmt->execute();
$expense = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$expense) {
    header("Location: dashboard.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $category = $_POST['category'];
    $amount = $_POST['amount'];
    $comments = $_POST['comments'];

    $stmt = $conn->prepare("UPDATE expenses SET category = :category, amount = :amount, comments = :comments WHERE id = :id");
    $stmt->bindParam(':category', $category);
    $stmt->bindParam(':amount', $amount);
    $stmt->bindParam(':comments', $comments);
    $stmt->bindParam(':id', $expenseId);

    if ($stmt->execute()) {
        header("Location: dashboard.php");
        exit();
    } else {
        $error = "Failed to update expense.";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Expense</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <h1>Edit Expense</h1>
    <?php if (!empty($error)) echo "<p style='color:red;'>$error</p>"; ?>
    <form method="POST">
        <input type="text" name="category" placeholder="Category" value="<?= htmlspecialchars($expense['category']) ?>" required>
        <input type="number" name="amount" placeholder="Amount" value="<?= htmlspecialchars($expense['amount']) ?>" required>
        <textarea name="comments" placeholder="Comments"><?= htmlspecialchars($expense['comments']) ?></textarea>
        <button type="submit">Update Expense</button>
    </form>
</body>
</html>

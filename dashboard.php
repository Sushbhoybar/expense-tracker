<?php
include 'db_config.php';
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$userId = $_SESSION['user_id'];
$stmt = $conn->prepare("SELECT * FROM expenses WHERE user_id = :user_id ORDER BY created_at DESC");
$stmt->bindParam(':user_id', $userId);
$stmt->execute();
$expenses = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <h1>Dashboard</h1>
    <a href="add_expense.php">Add Expense</a> | <a href="logout.php">Logout</a> |
    <a href="expense_distribution.php">View Category-wise Expense Distribution</a>

    <table>
        <tr>
            <th>Category</th>
            <th>Amount</th>
            <th>Created At</th>
            <th>Updated At</th>
            <th>Comments</th>
            <th>Actions</th>
        </tr>
        <?php foreach ($expenses as $expense): ?>
        <tr>
            <td><?= htmlspecialchars($expense['category']) ?></td>
            <td><?= htmlspecialchars($expense['amount']) ?></td>
            <td><?= htmlspecialchars($expense['created_at']) ?></td>
            <td><?= htmlspecialchars($expense['updated_at']) ?></td>
            <td><?= htmlspecialchars($expense['comments']) ?></td>
            <td>
                <a href="edit_expense.php?id=<?= $expense['id'] ?>">Edit</a> |
                <a href="delete_expense.php?id=<?= $expense['id'] ?>">Delete</a>
            </td>
        </tr>
        <?php endforeach; ?>
    </table>
</body>
</html>

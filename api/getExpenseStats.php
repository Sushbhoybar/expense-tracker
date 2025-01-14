<?php
require_once 'config.php';

session_start();
$user_id = $_SESSION['user_id'];

$sql = "SELECT category, SUM(amount) AS total FROM expenses WHERE user_id = ? GROUP BY category";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();

$stats = [];
while ($row = $result->fetch_assoc()) {
    $stats[] = $row;
}

echo json_encode($stats);
?>

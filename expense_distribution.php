<?php
include 'db_config.php';
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// Fetch the expense data categorized by category
$userId = $_SESSION['user_id'];
$stmt = $conn->prepare("SELECT category, SUM(amount) as total_amount FROM expenses WHERE user_id = :user_id GROUP BY category");
$stmt->bindParam(':user_id', $userId);
$stmt->execute();
$expenses = $stmt->fetchAll(PDO::FETCH_ASSOC);

$categories = [];
$amounts = [];

foreach ($expenses as $expense) {
    $categories[] = $expense['category'];
    $amounts[] = $expense['total_amount'];
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Category-wise Expense Distribution</title>
    <link rel="stylesheet" href="styles.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script> <!-- Chart.js CDN -->
</head>
<body>
    <div class="container">
        <h1>Category-wise Expense Distribution</h1>
        <div class="chart-container">
            <canvas id="expenseChart"></canvas>
        </div>
    </div>

    <script>
        const ctx = document.getElementById('expenseChart').getContext('2d');
        const expenseChart = new Chart(ctx, {
            type: 'pie',
            data: {
                labels: <?php echo json_encode($categories); ?>,
                datasets: [{
                    label: 'Expenses',
                    data: <?php echo json_encode($amounts); ?>,
                    backgroundColor: ['#FF5733', '#33FF57', '#3357FF', '#FF33A6', '#FF8C33'],
                    borderColor: '#fff',
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        position: 'top',
                    },
                    tooltip: {
                        callbacks: {
                            label: function(tooltipItem) {
                                return tooltipItem.label + ': $' + tooltipItem.raw;
                            }
                        }
                    }
                },
                maintainAspectRatio: false // Allows the chart to take up less space
            }
        });
    </script>
</body>
</html>

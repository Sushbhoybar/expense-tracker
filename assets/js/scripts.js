// Show add expense form
document.getElementById('addExpenseBtn').addEventListener('click', function () {
    document.getElementById('addExpenseForm').style.display = 'block'; // Show the form
});

// Cancel button to hide form
document.getElementById('cancelBtn').addEventListener('click', function () {
    document.getElementById('addExpenseForm').style.display = 'none'; // Hide the form
});

// Submit expense form
document.getElementById('expenseForm').addEventListener('submit', function (e) {
    e.preventDefault(); // Prevent the form from refreshing the page

    // Get form data
    const category = document.getElementById('category').value;
    const amount = document.getElementById('amount').value;
    const comments = document.getElementById('comments').value;

    // Send the data to the backend via AJAX
    fetch('api/addExpense.php', {
        method: 'POST',
        body: JSON.stringify({
            category: category,
            amount: amount,
            comments: comments
        }),
        headers: {
            'Content-Type': 'application/json'
        }
    })
    .then(response => response.text())
    .then(data => {
        alert(data); // Display any response from the server
        document.getElementById('addExpenseForm').style.display = 'none'; // Hide the form
        loadExpenses(); // Reload expenses
    })
    .catch(error => console.error('Error:', error));
});

// Function to load expenses and populate the table
function loadExpenses() {
    fetch('api/getExpenses.php')
        .then(response => response.json())
        .then(data => {
            const table = document.getElementById('expenseTable').getElementsByTagName('tbody')[0];
            table.innerHTML = ''; // Clear existing rows

            data.forEach(expense => {
                const row = table.insertRow();
                row.innerHTML = `
                    <td>${expense.category}</td>
                    <td>${expense.amount}</td>
                    <td>${expense.created_at}</td>
                    <td><button onclick="deleteExpense(${expense.id})">Delete</button></td>
                `;
            });
        })
        .catch(error => console.error('Error:', error));
}

// Load expenses when the page loads
window.onload = loadExpenses;

// Function to delete an expense
function deleteExpense(id) {
    fetch(`api/deleteExpense.php?id=${id}`)
        .then(() => {
            alert("Expense deleted successfully");
            loadExpenses(); // Reload the expenses list
        })
        .catch(error => console.error('Error:', error));
}

// Function to render the pie chart
fetch('api/getExpenseStats.php')
    .then(response => response.json())
    .then(data => {
        const categories = data.map(expense => expense.category);
        const amounts = data.map(expense => expense.total);

        const ctx = document.getElementById('pieChart').getContext('2d');
        new Chart(ctx, {
            type: 'pie',
            data: {
                labels: categories,
                datasets: [{
                    data: amounts,
                    backgroundColor: ['red', 'blue', 'green', 'yellow'],
                }]
            }
        });
    });

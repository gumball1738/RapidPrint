<?php
session_start();

// Database credentials
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "rapidprintdb";

// Create a connection to the database
$conn = new mysqli($servername, $username, $password, $dbname);

// Check if the connection was successful
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Retrieve the username from the session
$loggedInUsername = isset($_SESSION['session_name']) ? $_SESSION['session_name'] : 'Guest';

// Fetch MembershipPoint data (assume data is monthly for simplicity)
$sql = "SELECT MembershipPoint FROM membership WHERE username = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $loggedInUsername);
$stmt->execute();
$result = $stmt->get_result();

$pointsData = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $pointsData[] = $row['MembershipPoint'];
    }
}

// Fill missing months with zero if data has fewer than 12 entries
while (count($pointsData) < 12) {
    $pointsData[] = 0;
}

// Close the connection
$stmt->close();
$conn->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css">
    <title>Customer Detail with Chart</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body>
    <div class="container my-5">
        <!-- Greeting Header -->
        <div class="text-center">
            <h1 class="mb-3">Hi <?php echo htmlspecialchars($loggedInUsername); ?></h1>
        </div>

        <!-- Main Title -->
        <div class="text-center">
            <h2>Customer Membership Point Transactions</h2>
        </div>

        <!-- Chart Section -->
        <div class="mt-5">
            <canvas id="pointsChart" class="w-100" height="400"></canvas>
        </div>
    </div>

    <!-- Chart Script -->
    <script>
        // Pass PHP data to JavaScript
        const pointsData = <?php echo json_encode($pointsData); ?>;

        // Define month labels
        const labels = [
            'January', 'February', 'March', 'April', 'May', 'June',
            'July', 'August', 'September', 'October', 'November', 'December'
        ];

        // Render the chart
        const ctx = document.getElementById('pointsChart').getContext('2d');
        const pointsChart = new Chart(ctx, {
            type: 'line', // Chart type
            data: {
                labels: labels, // X-axis labels (months)
                datasets: [
                    {
                        label: 'Membership Points',
                        data: pointsData, // Y-axis data
                        backgroundColor: 'rgba(153, 102, 255, 0.5)',
                        borderColor: 'rgba(153, 102, 255, 1)',
                        borderWidth: 2,
                        tension: 0.3 // Makes the line smoother
                    }
                ]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        position: 'top',
                    },
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            stepSize: 50 // Increment by 50
                        },
                        title: {
                            display: true,
                            text: 'Points'
                        }
                    },
                    x: {
                        title: {
                            display: true,
                            text: 'Month'
                        }
                    }
                }
            }
        });
    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

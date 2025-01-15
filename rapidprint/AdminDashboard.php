<?php
session_start();
if (!isset($_SESSION["session_name"])) {
    // Redirect to LoginForm.php if no session is found
    header("Location: LoginPage.php");
    exit();
}
// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$database = "rapidprintdb";


$connection = new mysqli($servername, $username, $password, $database);
if ($connection->connect_error) {
    die("Connection failed: " . $connection->connect_error);
}

// Fetch monthly revenue from the orders table
$orderQuery = "
    SELECT DATE_FORMAT(createdAt, '%M') AS month, SUM(totalPrice) AS totalRevenue 
    FROM orders 
    GROUP BY DATE_FORMAT(createdAt, '%Y-%m')
    ORDER BY DATE_FORMAT(createdAt, '%Y-%m') ASC";
$orderResult = $connection->query($orderQuery);

$orderMonths = [];
$orderRevenues = [];
while ($row = $orderResult->fetch_assoc()) {
    $orderMonths[] = $row['month'];
    $orderRevenues[] = $row['totalRevenue'];
}

// Fetch monthly membership points from the membership table
$membershipQuery = "
    SELECT DATE_FORMAT(createdAt, '%M') AS month, SUM(membershipPoint) AS totalPoints 
    FROM membership 
    GROUP BY DATE_FORMAT(createdAt, '%Y-%m')
    ORDER BY DATE_FORMAT(createdAt, '%Y-%m') ASC";
$membershipResult = $connection->query($membershipQuery);

$membershipMonths = [];
$membershipPoints = [];
while ($row = $membershipResult->fetch_assoc()) {
    $membershipMonths[] = $row['month'];
    $membershipPoints[] = $row['totalPoints'];
}

$connection->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="stylesheet" type="text/css" href="styles/style.css">
    <title>Admin Dashboard</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<style>
		.dashboard-container {
            display: flex;
			flex-direction: column;
            justify-content: space-between;
            align-items: flex-start;
            padding: 20px;
        }
		.graph-container {
            display: flex;
			flex-direction: column;
			align-items: center;
			padding: 20px;
			width: 50%;

        }
		 .chart-container {
        width: 100%;
        margin-bottom: 30px;
		}
		canvas {
        background-color: #fff;
        border: 1px solid #ccc;
        border-radius: 8px;
        padding: 10px;
		}
        .buttons {
            width: 30%;
        }
        .buttons table {
            width: 100%;
        }
        .buttons button {
            width: 100%;
            padding: 10px;
            margin-bottom: 10px;
            font-size: 16px;
            cursor: pointer;
        }
</style>
<body>
    <div class="navigation">
        <ul>
            <li>
                <a href="MainPage3.php">
                    <img src="images/Logo.jpg" alt="Logo">
                </a>
            </li>
            <li><a href= "AdminDashboard.php"#dashboard">DASHBOARD</a></li>
            <li><a href="OrderListPage.php">MY ORDER</a></li>
            <li><a href="Logout.php">LOGOUT</a></li>
            <div class="search-container">
                <form action="/action_page.php">
                    <input type="text" placeholder="Search.." name="search">
                    <button>Search</button>
                </form>
            </div>
        </ul>
    </div>

    <div class="dashboard-container">
        <div class="buttons" id="buttons">
            <table>
                <tr><th><button onclick="document.location='VerificationApproval.php'">Verification Approval</button></th></tr>
				<tr><th><button onclick="window.location.href='Register.php'">Register User</button></th></tr>
                <tr><th><button onclick="window.location.href='ManageBranch.php'">Manage Branch</button></th></tr>
                <tr><th><button onclick="window.location.href='ManagePrinting.php'">Manage Printing Package</button></th></tr>
            </table>
        </div>
    </div>
	 <div class="graph-container">
        <!-- Revenue Graph -->
        <div class="chart-container">
            <canvas id="revenueChart"></canvas>
        </div>

        <!-- Membership Points Graph -->
        <div class="chart-container">
            <canvas id="membershipChart"></canvas>
        </div>
    </div>

    <script>
        // Data for Revenue Chart
        const revenueLabels = <?php echo json_encode($orderMonths); ?>;
        const revenueData = <?php echo json_encode($orderRevenues); ?>;

        // Create Revenue Chart
        const revenueChartConfig = {
            type: 'line',
            data: {
                labels: revenueLabels,
                datasets: [{
                    label: 'Monthly Revenue (RM)',
                    data: revenueData,
                    borderColor: 'rgb(75, 192, 192)',
                    backgroundColor: 'rgba(75, 192, 192, 0.2)',
                    fill: true,
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    title: {
                        display: true,
                        text: 'Monthly Revenue Overview'
                    },
                    legend: {
                        position: 'top',
                    },
                },
            },
        };

        // Render Revenue Chart
        new Chart(document.getElementById('revenueChart'), revenueChartConfig);

        // Data for Membership Points Chart
        const membershipLabels = <?php echo json_encode($membershipMonths); ?>;
        const membershipData = <?php echo json_encode($membershipPoints); ?>;

        // Create Membership Points Chart
        const membershipChartConfig = {
            type: 'bar',
            data: {
                labels: membershipLabels,
                datasets: [{
                    label: 'Total Membership Points',
                    data: membershipData,
                    backgroundColor: 'rgba(153, 102, 255, 0.5)',
                    borderColor: 'rgba(153, 102, 255, 1)',
                    borderWidth: 1,
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    title: {
                        display: true,
                        text: 'Membership Points Overview'
                    },
                    legend: {
                        position: 'top',
                    },
                },
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            },
        };

        // Render Membership Points Chart
        new Chart(document.getElementById('membershipChart'), membershipChartConfig);
    </script>
</body>
</html>

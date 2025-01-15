<?php
session_start();

if (!isset($_SESSION["session_name"])) {
    header("Location: LoginPage.php");
    exit();
}

$username = $_SESSION["session_name"]; // Retrieve logged-in user's name

// Database connection details
$servername = "localhost";
$db_username = "root";
$db_password = "";
$dbname = "rapidprintdb";

// Create a connection to the database
$conn = new mysqli($servername, $db_username, $db_password, $dbname);

// Check if the connection is successful
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch the customer details and membership status using a LEFT JOIN query
$sql = "SELECT c.CustomerID, c.username, c.email, c.phoneNumber, c.status, m.membershipStatus 
        FROM customer c 
        LEFT JOIN membership m ON c.username = m.username 
        WHERE c.username = ?";

$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $username); // Bind the username to the query
$stmt->execute();
$result = $stmt->get_result();

// Check if the customer exists in the database
if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $customerID = $row['CustomerID'];
    $customerUsername = $row['username'];
    $customerEmail = $row['email'];
    $customerPhoneNumber = $row['phoneNumber'];
    $customerMembershipStatus = $row['membershipStatus'] ? $row['membershipStatus'] : 'Not Applied';
    $customerStatus = $row['status'] ? $row['status'] : 'Not Verified';
} else {
    echo "<script>alert('Customer not found!'); window.location.href = 'LoginPage.php';</script>";
    exit();
}

$stmt->close();
$conn->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Customer Detail</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container-fluid">
            <a class="navbar-brand" href="MainPage2.php">
                <img src="images/Logo.jpg" alt="Logo" height="30">
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav">
                    <li class="nav-item"><a class="nav-link" href="CustomerDashboard.php">Dashboard</a></li>
                    <li class="nav-item"><a class="nav-link" href="PackageList.php">Package List</a></li>
                    <li class="nav-item"><a class="nav-link" href="CustOrder.php">My Order</a></li>
                    <li class="nav-item"><a class="nav-link" href="Logout.php">Logout</a></li>
                </ul>
                <form class="d-flex ms-auto">
                    <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search">
                    <button class="btn btn-outline-success" type="submit">Search</button>
                </form>
            </div>
        </div>
    </nav>

    <div class="container mt-4">
        <div class="row">
            <div class="col-md-4">
                <div class="list-group">
                    <a href="CustomerPointSection.php" class="list-group-item list-group-item-action">Customer Detail</a>
                    <a href="StatusVerificationcontainer.php" class="list-group-item list-group-item-action">Status Verification</a>
                    <a href="ApplyMembershipcontainer.php" class="list-group-item list-group-item-action">Apply Membership</a>
                    <a href="MembershipBalanceSection.php" class="list-group-item list-group-item-action">Membership Balance</a>
                    <a href="UpdateProfilecontainer.php" class="list-group-item list-group-item-action">Update Profile</a>
                    <a href="Deletecontainer.php" class="list-group-item list-group-item-action">Delete Existing Account</a>
                </div>
            </div>
            <div class="col-md-8">
                <h2>Customer Detail</h2>
                <ul class="list-group">
                    <li class="list-group-item"><strong>Customer ID:</strong> <?php echo $customerID; ?></li>
                    <li class="list-group-item"><strong>Username:</strong> <?php echo $customerUsername; ?></li>
                    <li class="list-group-item"><strong>Email:</strong> <?php echo $customerEmail; ?></li>
                    <li class="list-group-item"><strong>Phone Number:</strong> <?php echo $customerPhoneNumber; ?></li>
                    <li class="list-group-item"><strong>Membership Status:</strong> <?php echo $customerMembershipStatus; ?></li>
                    <li class="list-group-item"><strong>Verification Status:</strong> <?php echo $customerStatus; ?></li>
                </ul>
                <h2 class="mt-4">Point Transaction History</h2>
                <canvas id="lineChart"></canvas>
                <h2 class="mt-4">Customer Expenses</h2>
                <canvas id="pieChart"></canvas>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Line Chart
        const ctxLine = document.getElementById('lineChart').getContext('2d');
        new Chart(ctxLine, {
            type: 'line',
            data: {
                labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun'],
                datasets: [{
                    label: 'Points Earned',
                    data: [10, 20, 15, 25, 30, 40],
                    borderColor: 'rgba(75, 192, 192, 1)',
                    backgroundColor: 'rgba(75, 192, 192, 0.2)',
                    borderWidth: 2,
                    fill: true
                }]
            },
            options: {
                responsive: true,
                plugins: { legend: { position: 'top' } },
                scales: { x: { title: { display: true, text: 'Month' } }, y: { title: { display: true, text: 'Points' } } }
            }
        });

        // Pie Chart
        const ctxPie = document.getElementById('pieChart').getContext('2d');
        new Chart(ctxPie, {
            type: 'pie',
            data: {
                labels: ['Money Balance', 'Expenses'],
                datasets: [{
                    data: [300, 150],
                    backgroundColor: ['#FF6384', '#36A2EB', '#FFCE56'],
                    hoverOffset: 4
                }]
            },
            options: {
                responsive: true,
                plugins: { legend: { position: 'top' } }
            }
        });
    </script>
</body>
</html>

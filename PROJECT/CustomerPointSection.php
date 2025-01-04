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
    $customerStatus = $row['status']; // Fetch the customer status
    $customerMembershipStatus = $row['membershipStatus'] ? $row['membershipStatus'] : 'Not Applied';
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
    <link rel="stylesheet" type="text/css" href="styles/style.css">
    <title>Customer Detail</title>
</head>
<style>
   /* Flex container for the dashboard */
        .dashboard-container {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            padding: 20px;
            flex-wrap: nowrap; /* Ensures no wrapping of items */
        }

        /* Styling for the buttons section */
        .buttons {
            width: 30%; /* Adjust the width as needed, but it shouldn't exceed 30% */
        }

        /* Styling for the content section */
        .content-container {
            width: 65%; /* Adjust to fit within the remaining space */
            padding: 20px;
            display: flex;
            flex-direction: column;
            gap: 20px;
            border: 1px solid #ccc;
            border-radius: 10px;
            background-color: #f9f9f9;
        }

.content-container img {
    width: 100%; /* Make images responsive */
    height: auto;
}



</style>
<body>
    <div class="navigation">
        <ul>
            <li><a href="#dashboard"><img src="images/Logo.jpg" alt="Logo"></a></li>
            <li><a class="active" href="#dashboard">DASHBOARD</a></li>
            <li><a href="#news">PACKAGE LIST</a></li>
            <li><a href="#contact">MY ORDER</a></li>
            <li><a href="#about">LOGIN/REGISTER</a></li>
            <div class="search-container">
                <form action="/action_page.php">
                    <input type="text" placeholder="Search.." name="search">
                    <button type="submit"><i class="fa fa-search"></i></button>
                </form>
            </div>
        </ul>
    </div>

    <div class="dashboard-container">
        <div class="buttons" id="buttons">
            <table>
                <tr><th><button onclick="document.location='CustomerPointSection.php'">Customer Detail</button></th></tr>
                <tr><th><button onclick="window.location.href='StatusVerificationcontainer.php'">Status Verification</button></th></tr>
                <tr><th><button onclick="window.location.href='ApplyMembershipcontainer.php'">Apply Membership</button></th></tr>
                <tr><th><button onclick="window.location.href='MembershipBalanceSection.php'">Membership Balance</button></th></tr>
                <tr><th><button onclick="window.location.href='UpdateProfilecontainer.php'">Update Profile</button></th></tr>
                <tr><th><button onclick="window.location.href='Deletecontainer.php'">Delete Existing Account</button></th></tr>
            </table>
        </div>

        <!-- Content Section -->
        <div class="content-container">
            <h2>Customer Detail</h2>
            <div class="customer-details">
			  <p><strong>Customer ID:</strong> <?php echo $customerID; ?></p> 
                <p><strong>Username:</strong> <?php echo $customerUsername; ?></p>
                <p><strong>Email:</strong> <?php echo $customerEmail; ?></p>
                <p><strong>Phone Number:</strong> <?php echo $customerPhoneNumber; ?></p>
                <p><strong>Membership Status:</strong> <?php echo $customerMembershipStatus; ?></p>
                <p><strong>Verification Status:</strong> <?php echo $customerStatus; ?></p> <!-- Display the status -->
            </div>

            <div class="point-item">Point Transaction History</div>
            <img src="images/chart.png" alt="Point Transaction History">
            <div class="point-item">Customer Expenses</div>
            <img src="images/ex.jpg" alt="Customer Expenses">
        </div>
    </div>
</body>
</html>

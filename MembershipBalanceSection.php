<?php
// Start session
session_start();

// Check if the user is logged in
if (!isset($_SESSION["session_name"])) {
    // Redirect to LoginPage.php if no session is found
    header("Location: LoginPage.php");
    exit();
}

// Retrieve the username from the session
$username = $_SESSION["session_name"];

// Database connection
$servername = "localhost";
$dbUsername = "root";
$password = "";
$dbname = "rapidprintdb";

// Create connection
$conn = new mysqli($servername, $dbUsername, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch user and membership details
$sql = "SELECT c.username, c.email, m.MembershipID, m.pointsEarned, m.moneyBalance 
        FROM customer c 
        INNER JOIN membership m ON c.username = m.username
        WHERE c.username = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $username);
$stmt->execute();
$result = $stmt->get_result();

// Check if user exists
if ($result->num_rows > 0) {
    // Fetch the data
    $row = $result->fetch_assoc();
    $username = $row['username'];
    $email = $row['email'];
    $membershipID = $row['MembershipID'];  // Changed to MembershipID
    $pointsEarned = $row['pointsEarned'];
    $moneyBalance = $row['moneyBalance'];
} else {
    echo "No data found for this user.";
    exit();
}

$stmt->close();
$conn->close();
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="stylesheet" type="text/css" href="styles/style.css">
    <title>Membership Balance</title>
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
.qr-code {
		text-align: center;
		flex: 1;
	}

	.qr-placeholder {
    width: 150px;
    height: 150px;
    border: 2px dashed #ccc;
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 10px auto;
    font-size: 14px;
    color: #666;
	background-color: #fff;
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

    <div class="content-container">
        <table style="width: 100%; table-layout: fixed;">
        <tr>
            <!-- QR Code Section -->
            <td style="width: 50%; vertical-align: top; text-align: center;">
                <div class="qr-code">
					<h2>Customer Membership Information</h2>
					<p>Membership Points Earned: <strong><?php echo number_format($pointsEarned, 2); ?></strong></p>
                    <div class="qr-placeholder">QR Code Placeholder</div>
                    <p><em>(Scan to check the total points)</em></p>
                    
                    <button>Membership Total Accumulated Points</button>
                </div>
            </td>

            <!-- Membership Details -->
            <td style="width: 50%; vertical-align: top;">
                <div class="membership-details">
                    <h3>Customer Membership Information</h3>
                    <p><strong>Username:</strong> <?php echo $username; ?></p>
                    <p><strong>Email:</strong> <?php echo $email; ?></p>
                    <p><strong>Membership ID:</strong> <?php echo $membershipID; ?></p>
                    <h3>Card Balance (RM): <strong><?php echo number_format($moneyBalance, 2); ?></strong></h3>
                    <button>Top-Up</button>
                </div>
            </td>
        </tr>
    </table>
    </div>
</body>
</html>

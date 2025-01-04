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

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Sanitize inputs
    $password = trim($_POST['password']);
    $agreeToTerms = isset($_POST['terms']) ? 1 : 0; // Check if the user agreed to terms

    // Validate input
    if (empty($password)) {
        echo "<script>alert('Password is required.'); window.history.back();</script>";
        exit();
    }

    // Check if the user has agreed to the terms
    if ($agreeToTerms !== 1) {
        echo "<script>alert('You must agree to the terms and conditions.'); window.history.back();</script>";
        exit();
    }

    // Check if the user has already applied for membership
    $checkSql = "SELECT * FROM membership WHERE username = ?";
    $checkStmt = $conn->prepare($checkSql);
    $checkStmt->bind_param("s", $username);
    $checkStmt->execute();
    $result = $checkStmt->get_result();

    if ($result->num_rows > 0) {
        // User has already applied for membership
        echo "<script>alert('You have already applied for membership.'); window.location.href = 'CustomerDashboard.php';</script>";
        $checkStmt->close();
        $conn->close();
        exit();
    }

    // Insert data into membership table
    $insertSql = "INSERT INTO membership (MembershipPointID, membershipStatus, pointsEarned, moneyBalance, QRid, username, password) VALUES (0, 'active', 0, 0, '', ?, ?)";
    $insertStmt = $conn->prepare($insertSql);
    $insertStmt->bind_param("ss", $username, $password);

    if ($insertStmt->execute()) {
        echo "<script>alert('Membership applied successfully.'); window.location.href = 'CustomerDashboard.php';</script>";
    } else {
        echo "<script>alert('Error applying membership.'); window.history.back();</script>";
    }

    $insertStmt->close();
    $checkStmt->close();
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="stylesheet" type="text/css" href="styles/style.css">
    <title>Apply Membership</title>
</head>
<style>
/* Flex container for the dashboard */
.dashboard-container {
    display: flex;
    justify-content: space-between;
    align-items: flex-start;
    padding: 20px;
    flex-wrap: nowrap;
}

/* Styling for the buttons section */
.buttons {
    width: 30%;
}

/* Styling for the content section */
.content-container {
    width: 65%;
    padding: 20px;
    display: flex;
    flex-direction: column;
    gap: 20px;
    border: 1px solid #ccc;
    border-radius: 10px;
    background-color: #f9f9f9;
    margin-top: 10px;
    margin-bottom: 10px;
}

/* Styling for the form labels and inputs */
.content-container label {
    font-size: 14px;
    font-weight: bold;
}

.content-container input[type="password"] {
    width: 100%;
    padding: 10px;
    margin-bottom: 10px;
    border: 1px solid #ccc;
    border-radius: 5px;
    font-size: 14px;
}

.content-container input[type="checkbox"] {
    margin-right: 10px;
}

.content-container button {
    padding: 10px 20px;
    font-size: 16px;
    background-color: #007BFF;
    color: white;
    border: none;
    border-radius: 5px;
    cursor: pointer;
}

.content-container button:hover {
    background-color: #0056b3;
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
        <h2>Apply Membership</h2>
        <form method="POST" action="">
            <label for="password">Password:</label><br>
            <input type="password" id="password" name="password" placeholder="Enter your password" required><br>

            <label for="terms">
                <input type="checkbox" id="terms" name="terms"> I agree to the <a href="#terms-content">Terms and Conditions</a>.<br>
            </label>

            <!-- Terms and Conditions -->
            <div id="terms-content" style="display: none;">
                <h3>Terms and Conditions</h3>
                <p>By applying for membership, you agree to the following:</p>
                <ul>
                    <li>You must be over the age of 12.</li>
                    <li>Your account will be subject to monitoring to ensure compliance with our terms.</li>
                    <li>Any fraudulent activity may result in suspension or termination of your membership.</li>
                    <li>We reserve the right to update our terms and conditions at any time.</li>
                </ul>
            </div>

            <div><button type="submit">Submit</button></div>
        </form>
    </div>
</div>

<script>
// Toggle the display of the Terms and Conditions
document.querySelector('a[href="#terms-content"]').addEventListener('click', function(e) {
    e.preventDefault();
    var termsContent = document.getElementById('terms-content');
    termsContent.style.display = termsContent.style.display === 'none' ? 'block' : 'none';
});
</script>

</body>
</html>

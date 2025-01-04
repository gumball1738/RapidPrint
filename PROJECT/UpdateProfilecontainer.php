<?php
session_start();

// Check if the session contains a user ID
if (!isset($_SESSION['CustomerID'])) {
    echo "<script>alert('You must be logged in to update your profile.'); window.location.href = 'LoginPage.php';</script>";
    exit();
}

// Get the CustomerID from the session
$CustomerID = $_SESSION['CustomerID'];  // Fixed missing semicolon

// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "rapidprintdb";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Sanitize inputs
    $username = trim($_POST['uname']);
    $email = trim($_POST['email']);
    $phoneNumber = trim($_POST['num']);
    $password = trim($_POST['password']);

    // Validate input
    if (empty($username) || empty($email) || empty($phoneNumber) || empty($password)) {
        echo "<script>alert('All fields are required.'); window.history.back();</script>";
        exit();
    }

    

    // Update the customer table
    $sql_update = "UPDATE customer SET username = ?, email = ?, phoneNumber = ?, password = ? WHERE CustomerID = ?";
    $stmt_update = $conn->prepare($sql_update);
    $stmt_update->bind_param("ssssi", $username, $email, $phoneNumber, $password, $CustomerID);

    if ($stmt_update->execute()) {
        echo "<script>
                alert('Profile updated successfully.');
                window.location.href = 'CustomerDashboard.php';
              </script>";
    } else {
        echo "<script>
                alert('Error updating profile.');
                window.history.back();
              </script>";
    }

    $stmt_update->close();
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="stylesheet" type="text/css" href="styles/style.css">
    <title>Update Profile</title>
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
        gap: 20px; /* Add gap between form elements */
        border: 1px solid #ccc;
        border-radius: 10px;
        background-color: #f9f9f9;
        margin-top: 10px; /* Add space above the button */
        margin-bottom: 10px; /* Add space below the button */
    }

    /* Styling for the form labels and inputs */
    .content-container label {
        font-size: 14px;
        font-weight: bold;
    }

    .content-container input[type="text"] {
        width: 100%; /* Full width input fields */
        padding: 10px;
        margin-bottom: 10px; /* Add space after each input */
        border: 1px solid #ccc;
        border-radius: 5px;
        font-size: 14px;
    }

    .content-container input[type="password"] {
        width: 100%; /* Full width input fields */
        padding: 10px;
        margin-bottom: 10px; /* Add space after each input */
        border: 1px solid #ccc;
        border-radius: 5px;
        font-size: 14px;
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
        <h2>Update Profile</h2>
        <form method="POST" action="">
            <label for="uname">Username:</label><br>
            <input type="text" id="uname" name="uname" value="" placeholder="Enter your new username" required><br>
            <label for="email">Email:</label><br>
            <input type="text" id="email" name="email" value="" placeholder="Enter your new email" required><br>
            <label for="num">Phone Number:</label><br>
            <input type="text" id="num" name="num" value="" placeholder="Enter your new phone number" required><br>
            <label for="password">Password:</label><br>
            <input type="password" id="password" name="password" value="" placeholder="Enter your new password" required><br>
            <div><button type="submit">Submit</button></div>
        </form>
    </div>
</body>
</html>

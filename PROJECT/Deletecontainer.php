<?php
session_start();

if (!isset($_SESSION['CustomerID'])) {
    header("Location: LoginPage.php");
    exit();
}

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "rapidprintdb";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $CustomerID = $_SESSION['CustomerID'];

    $sql_delete = "DELETE FROM customer WHERE CustomerID = ?";
    $stmt_delete = $conn->prepare($sql_delete);
    $stmt_delete->bind_param("i", $CustomerID);

    if ($stmt_delete->execute()) {
        session_destroy();
        echo "<script>
                alert('Account deleted successfully.');
                window.location.href = 'LoginPage.php';
              </script>";
    } else {
        echo "<script>
                alert('Error deleting account.');
                window.history.back();
              </script>";
    }

    $stmt_delete->close();
}

$conn->close();
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="stylesheet" type="text/css" href="styles/style.css">
    <title>Delete Account</title>
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
        <h2>Delete Profile</h2>
       <p>"Are you sure you want to delete your account? This action is permanent and cannot be undone. 
	All your data, including your profile, order history, membership points, and other associated information, 
	will be permanently removed from our system."</p>
        <form action="DeleteContainer.php" method="POST" onsubmit="return confirmDelete()">

    <input type="radio" id="confirm" name="argue" value="confirm">
    <label for="confirm">Confirm delete</label><br><br>

    <div>
        <button type="button" onclick="window.location.href='SignUpPage.php'">Back</button>
        <button type="submit">Submit</button>
    </div>
</form>
</form>

    </div>
</body>
<script>
function confirmDelete() {
    const userId = document.getElementById("CustomerID").value.trim();
    const confirmRadio = document.getElementById("confirm");

    if (!userId) {
        alert("Please enter your User ID.");
        return false; // Prevent form submission
    }

    if (!confirmRadio.checked) {
        alert("Please confirm by selecting 'Confirm delete' before proceeding.");
        return false; // Prevent form submission
    }

    return confirm("Are you sure you want to delete your account? This action cannot be undone.");
}


</script>
</html>
<?php
// Database credentials
$servername = "localhost";
$username = "root"; // Your database username
$password = ""; // Your database password
$dbname = "rapidprintdb"; // Your database name

// Create a connection to the database
$conn = new mysqli($servername, $username, $password, $dbname);

// Check if the connection was successful
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get form data
	$customerID = $conn->real_escape_string($_POST['id']);
    $uname = $conn->real_escape_string($_POST['uname']);
    $email = $conn->real_escape_string($_POST['email']);
    $password = $conn->real_escape_string($_POST['password']);

    // Insert data into the database
    $sql = "INSERT INTO customer (CustomerID, username, email, password) VALUES ('$customerID','$uname', '$email', '$password')";

   if ($conn->query($sql) === TRUE) {
        echo "<script>alert('New record created successfully');</script>";
    } else {
        // Check for duplicate entry error
        if ($conn->errno === 1062) {
            echo "<script>alert('Error: Customer ID already exists. Please use a unique ID.');</script>";
        } else {
            echo "<script>alert('Error: " . $conn->error . "');</script>";
        }
    }
}

// Close the connection
$conn->close();

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="stylesheet" type="text/css" href="styles/style.css">
    <title>Customer Detail</title>
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

        .content-container table {
            border-collapse: collapse; /* Ensures borders don't double up */
            width: 100%; /* Optional: Sets the table to span the container */
        }

        .content-container table td {
            border: 1px solid black; /* Adds a border to each cell */
            padding: 8px; /* Optional: Adds spacing inside the cells */
            text-align: center; /* Optional: Centers the text */
        }

        .content-container table th {
            border: 1px solid black; /* Adds borders to header cells if needed */
            padding: 8px;
            text-align: center;
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
	 .content-container input[type="id"] {
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
</head>
<body>
    <div class="navigation">
        <ul>
            <li><a href="#dashboard"><img src="images/Logo.jpg" alt="Logo"></a></li>
            <li><a class="active" href="#dashboard">DASHBOARD</a></li>
            <li><a href="#news">PACKAGE LIST</a></li>
            <li><a href="#contact">MY ORDER</a></li>
            <li><a href="#about">LOGOUT</a></li>
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
                <tr><th><button onclick="document.location='VerificationApproval.php'">Verification Approval</button></th></tr>
				<tr><th><button onclick="window.location.href='Register.php'">Register User</button></th></tr>
                <tr><th><button onclick="window.location.href='SaleInfo.php'">Sale Information</button></th></tr>
                <tr><th><button onclick="window.location.href='ManageBranch.php'">Manage Branch</button></th></tr>
                <tr><th><button onclick="window.location.href='ManagePrinting.php'">Manage Printing Package</button></th></tr>
            </table>
        </div>

        <!-- Content Section -->
        <div class="content-container">
		<h2>User Regsiteration</h2>
		<form method="POST" action="">
            <label for="uname">Username:</label><br>
            <input type="text" id="uname" name="uname" value="" placeholder="Enter user default username ( user student ID )" required><br>
            <label for="email">Email:</label><br>
            <input type="text" id="email" name="email" value="" placeholder="Enter user email ( studentID@gmail.com)" required><br>
            <label for="password">Password:</label><br>
            <input type="password" id="password" name="password" value="" placeholder="Enter user password (user studentID123)" required><br>
			<label for="id">Customer ID:</label><br>
            <input type="id" id="id" name="id" value="" placeholder="Create user customer ID" required><br>
			<br>
            <div><button type="submit">Submit</button></div>
        </form>
		
</body>
</html>
<?php
session_start();
if (!isset($_SESSION["session_name"])) {
    // Redirect to LoginForm.php if no session is found
    header("Location: LoginPage.php");
    exit();
}

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

// Process the form submission for approval or rejection
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $customerId = $_POST['customer_id'];
    $status = $_POST['status'];

    if ($status == 'verify') {
        // Update status to "verified"
        $sql = "UPDATE customer SET status = 'verified' WHERE CustomerID = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $customerId);
    } elseif ($status == 'reject') {
        // Update status to "rejected" and delete the file
        $sql = "UPDATE customer SET status = 'rejected', file = NULL WHERE CustomerID = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $customerId);
    }

    if ($stmt->execute()) {
        echo "<script>alert('Action completed successfully!');</script>";
    } else {
        echo "<script>alert('Failed to process action.');</script>";
    }
    $stmt->close();
}

// Fetch customer records, optionally filtered by CustomerID
$searchCustomerId = isset($_GET['search']) ? $_GET['search'] : '';
$sql = "SELECT CustomerID, file FROM customer";
if (!empty($searchCustomerId)) {
    $sql .= " WHERE CustomerID = ?";
}
$stmt = $conn->prepare($sql);

if (!empty($searchCustomerId)) {
    $stmt->bind_param("i", $searchCustomerId);
}
$stmt->execute();
$result = $stmt->get_result();

// Close the database connection
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
		  .dashboard-container {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            padding: 20px;
        }

        /* Button section */
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
</head>
<body>
    <div class="navigation">
        <ul>
            <li><a href="MainPage3.php"><img src="images/Logo.jpg" alt="Logo"></a></li>
            <li><a href="CustomerDashboard.php#dashboard">DASHBOARD</a></li>
            <li><a href="OrderListPage.php">MY ORDER</a></li>
            <li><a href="Logout.php">LOGOUT</a></li>
            <div class="search-container">
               
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


        <div class="content-container">
            <h2>Approve Verification</h2>
			 <form method="GET" action="">
                    <input type="text" placeholder="Search by Customer ID" name="search" value="<?= htmlspecialchars($searchCustomerId) ?>">
                    <button type="submit">Search</button>
                </form>
            <table style="width:100%">
                <tr>
                    <th>Customer ID</th>
                    <th>Attachment of copy of student card</th>
                    <th>Action</th>
                </tr>
                <?php
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        $filePath = $row['file'];
                        $customerId = $row['CustomerID'];
                        echo "<tr>
                                <td>$customerId</td>
                                <td>";
                        echo $filePath ? "<a href='$filePath' target='_blank' style='color: blue; text-decoration: underline;'>View Here</a>" : "No file available";
                        echo "</td>
                                <td>
                                    <form method='POST'>
                                        <input type='hidden' name='customer_id' value='$customerId'>
                                        <button type='submit' name='status' value='verify'>Approve</button>
                                        <button type='submit' name='status' value='reject'>Reject</button>
                                    </form>
                                </td>
                              </tr>";
                    }
                } else {
                    echo "<tr><td colspan='3'>No records found</td></tr>";
                }
                ?>
            </table>
        </div>
    </div>
</body>
</html>

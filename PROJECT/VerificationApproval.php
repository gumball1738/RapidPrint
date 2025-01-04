
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

// Process the form submission for approval or rejection
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get the CustomerID and action (status)
    $customerId = $_POST['customer_id'];
    $status = $_POST['status'];

     if ($status == 'verify') {
        // Update status to "verified"
        $sql = "UPDATE customer SET status = 'verified' WHERE CustomerID = ?";
    } elseif ($status == 'reject') {
        // Delete the record from the database
        $sql = "DELETE file FROM customer WHERE CustomerID = ?";
    }
	
	// Prepare the SQL query to update the status in the customer table
    $sql = "UPDATE customer SET status = ? WHERE CustomerID = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("si", $status, $customerId);
    
    // Execute the query and check for success
    if ($stmt->execute()) {
        echo "<script>alert('Status updated successfully!');</script>";
    } else {
        echo "<script>alert('Failed to update status.');</script>";
    }
    $stmt->close();
}

// Fetch Customer ID and file path from the customer table
$sql = "SELECT CustomerID, file FROM customer";
$result = $conn->query($sql);

// Close the database connection after the query
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
    </style>
</head>
<body>
    <div class="navigation">
        <ul>
            <li><a href="#dashboard"><img src="images/Logo.jpg" alt="Logo"></a></li>
            <li><a class="active" href="#dashboard">DASHBOARD</a></li>
            <li><a href="#news">PACKAGE LIST</a></li>
            <li><a href="#contact">MY ORDER</a></li>
            <li><a href="#about">lOGOUT</a></li>
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
            <h2>Approve Verification</h2>
            
            <table style="width:100%">
                <tr>
                    <th>Customer ID</th>
                    <th>Attachment of copy of student card</th>
                    <th>Action</th>
                </tr>
                <?php
                // Check if there are any rows to display
                if ($result->num_rows > 0) {
                    // Loop through and display each row
                    while($row = $result->fetch_assoc()) {
                        // Generate the URL dynamically based on the file path
                        $filePath = $row['file'];
                        $customerId = $row['CustomerID'];
                        echo "<tr>
                                <td>$customerId</td>
                                <td><a href='$filePath' target='_blank' style='color: blue; text-decoration: underline;'>View Here</a></td>
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

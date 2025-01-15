<?php
// Start the session
session_start();

// Check if the user is logged in
if (!isset($_SESSION["session_name"])) {
    // Redirect to LoginPage.php if no session is found
    header("Location: LoginPage.php");
    exit();
}

// Get the OrderID from the URL
if (isset($_GET['OrderID'])) {
    $orderID = $_GET['OrderID'];
} else {
    die("Order ID is missing.");
}

// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$database = "rapidprintdb";

// Create connection
$connection = new mysqli($servername, $username, $password, $database);

// Check connection
if ($connection->connect_error) {
    die("Connection failed: " . $connection->connect_error);
}


$sql = "SELECT totalPrice FROM orders WHERE OrderID = ?";
$stmt = $connection->prepare($sql);
$stmt->bind_param("i", $orderID); 
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $totalPrice = $row['totalPrice'];
} else {
    $totalPrice = 0;
    echo "No order found for this OrderID.";
}

$stmt->close();


if ($_SERVER["REQUEST_METHOD"] == "POST") {
   
    $paymentMethod = $_POST['payment-method'];
    $paymentStatus = "Paid";
    
    
    $membershipCardID = isset($_POST['membership-id']) ? $_POST['membership-id'] : '';

    if ($paymentMethod == 'membership') {
        
        $checkMembershipSql = "SELECT MembershipID, moneyBalance, membershipPoint FROM membership WHERE MembershipID = ?";
        $stmt = $connection->prepare($checkMembershipSql);
        $stmt->bind_param("s", $membershipCardID);
        $stmt->execute();
        $stmt->store_result();
        $stmt->bind_result($dbMembershipID, $moneyBalance, $membershipPoint);
        $stmt->fetch();

        
        if ($stmt->num_rows > 0) {
            if ($moneyBalance >= $totalPrice) {
               
                $newBalance = $moneyBalance - $totalPrice;
                $updateBalanceSql = "UPDATE membership SET moneyBalance = ?, membershipPoint = membershipPoint + ? WHERE MembershipID = ?";
                $updateStmt = $connection->prepare($updateBalanceSql);
                $updateStmt->bind_param("dis", $newBalance, $totalPrice, $membershipCardID);
                $updateStmt->execute();

                
                $insertSql = "INSERT INTO payment (OrderID, paymentMethod, paymentStatus) VALUES (?, ?, ?)";
                $stmt = $connection->prepare($insertSql);
                $stmt->bind_param("iss", $orderID, $paymentMethod, $paymentStatus);
                $stmt->execute();

               
                $updateStatusSql = "UPDATE orders SET orderStatus = 'Ordered' WHERE OrderID = ?";
                $updateStmt = $connection->prepare($updateStatusSql);
                $updateStmt->bind_param("i", $orderID);
                $updateStmt->execute();

               
               echo "<script>
					alert('Payment Successful. Membership points updated.');
					window.location.href = 'receipt.php?OrderID=" . $orderID . "';
				  </script>";
				exit();
            } else {
                echo "<script>alert('Insufficient balance on your Membership Card.');</script>";
            }
        } else {
            echo "<script>alert('Your Membership Card ID is invalid.');</script>";
        }

        $stmt->close();
    } else {
        
        $insertSql = "INSERT INTO payment (OrderID, paymentMethod, paymentStatus) VALUES (?, ?, ?)";
        $stmt = $connection->prepare($insertSql);
        $stmt->bind_param("iss", $orderID, $paymentMethod, $paymentStatus);
        $stmt->execute();

        $updateStatusSql = "UPDATE orders SET orderStatus = 'Ordered' WHERE OrderID = ?";
        $updateStmt = $connection->prepare($updateStatusSql);
        $updateStmt->bind_param("i", $orderID);
        $updateStmt->execute();

        
        echo "<script>
                alert('Collect and Pay at UMPSA COOP');
                window.location.href = 'receipt.php?OrderID=" . $orderID . "';  
              </script>";
        exit(); //JAVASCRIPT
    }
}


$connection->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment Page</title>
    <link rel="stylesheet" type="text/css" href="styles/style.css"> <!-- Link to external CSS -->
    <style>
        th {
            text-align: left;
        }
        table {
            width: 100%;
        }
    </style>
</head>
<body>
    <!-- Navigation Bar -->
    <div class="navigation">
        <ul>
            <li>
                <a href="MainPage2.php">
                    <img src="images/Logo.jpg" alt="Logo">
                </a>
            </li>
            <li><a href="CustomerDashboard.php" id="dashboard">DASHBOARD</a></li>
            <li><a href="PackageList.php">PACKAGE LIST</a></li>
            <li><a href="CustOrder.php">MY ORDER</a></li>
            <li><a href="logOut.php">LOGOUT</a></li>
            <div class="search-container">
                <form action="/action_page.php">
                    <input type="text" placeholder="Search.." name="search">
                    <button>Search</button>
                </form>
            </div>
        </ul>
    </div>

    <!-- Payment Form -->
    <div class="container my-5">
        <h2>Payment Details</h2>
        <form method="POST">
            <div class="payment-container">
                <div class="payment-methods">
                    <div>
                        <label>Select Payment Method:</label>
                        <label>
                            <input type="radio" name="payment-method" value="membership" checked>
                            Membership Card
                        </label>
                        <label>
                            <input type="radio" name="payment-method" value="cash">
                            Cash (transaction at UMPSA Coop Counter)
                        </label>
                    </div>

                    <div class="membership-id">
                        <label for="membership-id">Membership Card ID:</label>
                        <input type="text" name="membership-id" id="membership-id" placeholder="Enter your Membership Card ID">
                        <span style="font-size: 12px; color: #666;">(Cash payment does not require to fill this)</span>
                    </div>
                </div>

                <div class="payment-summary">
                    <div class="total">Total = RM <?php echo number_format($totalPrice, 2); ?></div>
                    <button type="submit" class="btn btn-success">Pay</button>
                </div>
            </div>
        </form>
    </div>
</body>
</html>

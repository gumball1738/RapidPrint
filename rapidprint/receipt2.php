<?php
// Start the session
session_start();

// Check if the user is logged in
if (!isset($_SESSION["session_name"])) {
    header("Location: LoginPage.php");
    exit();
}

// Get the OrderID from the URL
if (isset($_GET['OrderID'])) {
    $orderID = $_GET['OrderID'];
} else {
    die("Order ID is missing.");
}

// Fetch order details from the database
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

$sql = "SELECT * FROM orders WHERE OrderID = ?";
$stmt = $connection->prepare($sql);
$stmt->bind_param("i", $orderID);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $orderDetails = $result->fetch_assoc();
} else {
    die("Order not found.");
}

$stmt->close();
$connection->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Receipt Details</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
        }

        .receipt-container {
            max-width: 600px;
            margin: 0 auto;
            border: 1px solid #ccc;
            padding: 20px;
            border-radius: 8px;
            background-color: #f9f9f9;
        }

        h2 {
            text-align: center;
        }

        .details p {
            font-size: 18px;
        }
    </style>
</head>
<body>
    <div class="receipt-container">
        <h2>Receipt Details</h2>
        <div class="details">
            <p><strong>Order ID:</strong> <?php echo $orderDetails['OrderID']; ?></p>
            <p><strong>Total Price:</strong> RM <?php echo number_format($orderDetails['totalPrice'], 2); ?></p>
            <p><strong>Status:</strong> <?php echo $orderDetails['orderStatus']; ?></p>
            <p><strong>Order Date:</strong> <?php echo $orderDetails['createdAt']; ?></p>
        </div>
    </div>
</body>
</html>

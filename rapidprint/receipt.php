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
    die("Error: Order ID is missing. Please pass the OrderID in the URL, e.g., receipt.php?OrderID=123.");
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

$sql = "SELECT * FROM orders WHERE OrderID = ?";
$stmt = $connection->prepare($sql);
$stmt->bind_param("i", $orderID);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $orderDetails = $result->fetch_assoc();
} else {
    die("Error: Order not found for OrderID " . htmlspecialchars($orderID));
}

$stmt->close();
$connection->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Receipt</title>
    <style>

    </style>
	<link rel="stylesheet" type="text/css" href="styles/style.css">
</head>
<body>
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

    <div class="details">
        <h2>Order Details</h2>
        <p><strong>Order ID:</strong> <?php echo htmlspecialchars($orderDetails['OrderID']); ?></p>
        <p><strong>Total Price:</strong> RM <?php echo number_format($orderDetails['totalPrice'], 2); ?></p>
        <p><strong>Status:</strong> <?php echo htmlspecialchars($orderDetails['orderStatus']); ?></p>
    </div>

    <div class="qr-container">
        <h3>Scan the QR Code to view this receipt online</h3>
        <input type="hidden" id="qrText" value="http://localhost/rapidprint/receipt2.php?OrderID=<?php echo urlencode($orderDetails['OrderID']); ?>">
        <img src="" id="qrImage" alt="QR Code">
        <button onclick="generateQR()">Generate QR Code</button>
    </div>

    <script>
        let qrText = document.getElementById("qrText");
        let qrImage = document.getElementById("qrImage");

        function generateQR() {
            if (qrText.value.length > 0) {
                qrImage.src = "https://api.qrserver.com/v1/create-qr-code/?size=150x150&data=" + encodeURIComponent(qrText.value);
            }
        }
    </script>
</body>
</html>

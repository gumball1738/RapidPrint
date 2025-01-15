<?php
session_start();
if (!isset($_SESSION["session_name"])) {
    header("Location: LoginPage.php");
    exit();
}

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

// Read all rows from the `orders` table
$sql = "SELECT * FROM orders";
$result = $connection->query($sql);

if (!$result) {
    die("Invalid query: " . $connection->error);
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Orders List</title>
	<link rel="stylesheet" href="styles/style.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
</head>
<body>
    <div class="navigation">
        <ul>
            <li>
                <a href="MainPage2.php">
                    <img src="images/Logo.jpg" alt="Logo" width="100" height="60">
                </a>
            </li>
            <li><a href="CustomerDashboard.php">DASHBOARD</a></li>
            <li><a href="PackageList.php">PACKAGE LIST</a></li>
            <li><a href="CustOrder.php">MY ORDER</a></li>
            <li><a href="LogOut.php">LOGOUT</a></li>
            <div class="search-container">
                <form action="/action_page.php">
                    <input type="text" placeholder="Search.." name="search">
                    <button type="submit">Search</button>
                </form>
            </div>
        </ul>
    </div>
	
    <div class="container my-5">
        <h2>Orders List</h2>
        <table class="table">
            <thead>
                <tr>
                    <th>Order ID</th>
                    <th>Customer ID</th>
                    <th>Paper Size</th>
                    <th>Quantity</th>
                    <th>Color</th>
                    <th>Page per Sheet</th>
                    <th>Document</th>
                    <th>Request</th>
                    <th>Price</th>
                    <th>Total Price</th>
                    <th>Status</th>
                    <th>Ordered At</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $result->fetch_assoc()): ?>
                    <?php
                       
                        $createdAt = strtotime($row['createdAt']);
                        $currentTime = time();
                        $timeDifference = $currentTime - $createdAt;

                      
                        $isCancelable = ($timeDifference <= 600); // 600 seconds = 10 minutes
                    ?>
                    <tr>
                        <td><?php echo htmlspecialchars($row['OrderID'] ?? 'N/A'); ?></td>
                        <td><?php echo htmlspecialchars($row['CustomerID'] ?? 'N/A'); ?></td>
                        <td><?php echo htmlspecialchars($row['size'] ?? 'N/A'); ?></td>
                        <td><?php echo htmlspecialchars($row['quantity'] ?? 'N/A'); ?></td>
                        <td><?php echo htmlspecialchars($row['color'] ?? 'N/A'); ?></td>
                        <td><?php echo htmlspecialchars($row['pagePerSheet'] ?? 'N/A'); ?></td>
                        <td><?php echo htmlspecialchars($row['document'] ?? 'N/A'); ?></td>
                        <td><?php echo htmlspecialchars($row['request'] ?? 'N/A'); ?></td>
                        <td><?php echo htmlspecialchars($row['price'] ?? 'N/A'); ?></td>
                        <td><?php echo htmlspecialchars($row['totalPrice'] ?? 'N/A'); ?></td>
                        <td><?php echo htmlspecialchars($row['orderStatus'] ?? 'N/A'); ?></td>
                        <td>
                            <?php 
                                if (isset($row['createdAt']) && !empty($row['createdAt'])) {
                                    echo date("Y-m-d H:i:s", strtotime($row['createdAt']));
                                } else {
                                    echo 'No Date Available';
                                }
                            ?>
                        </td>
                        <td>
                            <a class='btn btn-primary btn-sm' href='/WEBE/rapidprint/UpdateCustOrder.php?OrderID=<?php echo $row['OrderID']; ?>'>Update</a>
                            
                            <!-- Cancel button only available within 10 minutes of createdAt -->
                            <?php if ($isCancelable): ?>
                                <a class='btn btn-danger btn-sm' href='/WEBE/rapidprint/CancelCustOrder.php?OrderID=<?php echo $row['OrderID']; ?>'>Cancel</a>
                            <?php else: ?>
                                <button class='btn btn-danger btn-sm' disabled>Cancel</button>
                            <?php endif; ?>
                            
                            
                            <a class='btn btn-success btn-sm' href='/WEBE/rapidprint/PaymentPage.php?OrderID=<?php echo $row['OrderID']; ?>'>Pay</a>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>
</body>
</html>

<?php
session_start();
if (!isset($_SESSION["session_name"])) {
    header("Location: LoginPage.php");
    exit();
}

$servername = "localhost"; 
$username = "root";        
$password = "";            
$dbname = "rapidprintdb"; 

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} 

$pOrderID = $_GET['OrderID'];

$query = "SELECT orders.OrderID, orders.size, orders.totalPrice, orders.quantity, orders.StaffID, orders.createdAt,
		invoice.InvoiceID, invoice.amount
          FROM orders
          LEFT JOIN invoice ON orders.OrderID = invoice.OrderID
          WHERE orders.OrderID = '$pOrderID'";

$result = mysqli_query($conn, $query);

if (mysqli_num_rows($result) > 0) {
    
    while ($row = mysqli_fetch_assoc($result)) {
        $pInvoiceID = $row["InvoiceID"];
        $pOrderID = $row["OrderID"];
        $pOrderSize = $row["size"];
        $pOrderPrice = $row["totalPrice"];
        $pOrderQuantity = $row["quantity"];
        $pAmount = $row["amount"];
        $pDate = $row["createdAt"];
        $pStaffID = $row["StaffID"];
        
        $pOrderTotalPrice = $pOrderPrice;
    }
?>

<html>
<head>
<style>
h2 {
    text-align: center;    
}
table { 
    text-align: left;
    width: 100%;
}
th {
    text-align: left;    
}
td {
    text-align: center;    
}
button {
    padding: 10px 20px;
    margin: 5px;
    border: none;
    border-radius: 5px;
    cursor: pointer;
}
</style>
<title>Staff Manage Order</title>
<link rel="stylesheet" type="text/css" href="styles/style.css"> 
</head>
<body>
<div class="navigation">
    <ul>
        <li>
            <a href="#dashboard">
                <img src="images/Logo.jpg" alt="Logo">
            </a>
        </li>
        <li><a href="StaffDashboardPage.php"#dashboard">DASHBOARD</a></li>
        <li><a href="StaffBonus.php">BONUS</a></li>
        <li><a href="StaffOrderPage.php">MY ORDER</a></li>
        <li><a href="logout.php">LOGOUT</a></li>
        <div class="search-container">
            <form action="/action_page.php">
                <input type="text" placeholder="Search.." name="search">
                <button>Search</button>
            </form>
        </div>
    </ul>
</div>

<h2>Order</h2>

<div>
<form action="StaffGetPoint.php" method="post">
<table border="1">
<tr><th><table>
<tr><th>Order Size: <?php echo $pOrderSize; ?></th><th></th></tr>
<tr><th>Order Quantity: <?php echo $pOrderQuantity; ?></th><th>Total Price: <?php echo $pOrderTotalPrice; ?></th></tr>
<th>Date: <?php echo $pDate; ?></th></tr>
</table></th></tr>
<tr>
    <td>Staff ID: <input type="text" name="staffID" value=""></td>
</tr>
</table>
<h2><tr><button type="submit" class="submit">Submit</button></tr></h2>
<input type="hidden" name="InvoiceID" value="<?php echo $pInvoiceID; ?>">
<input type="hidden" name="OrderID" value="<?php echo $pOrderID; ?>">
</form>
</div>

<?php
} else {
    echo "0 results";
}
?>
</body>
</html>

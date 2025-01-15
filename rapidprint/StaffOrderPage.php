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

$query = "SELECT *
          FROM orders
          LEFT JOIN staff ON orders.staffID = staff.staffID";

	
$result = mysqli_query($conn, $query);
if (mysqli_num_rows($result) > 0){
?>

<head>
<style>
h2 {
    text-align: center;    
}
table { 
    text-align: left;
    width: 800px;
    width: 100%;
}
th {
    text-align: center;    
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
<title>Order List Page</title>
<link rel="stylesheet" type="text/css" href="styles/style.css"> 
</head>
<body>
<div class="navigation">
    <ul>
        <li>
             <a href="MainPage4.php">
                <img src="images/Logo.jpg" alt="Logo">
            </a>
        </li>
        <li><a href="StaffDashboardPage.php"#dashboard">DASHBOARD</a></li>
        <li><a href="StaffBonus.php">BONUS</a></li>
        <li><a href="StaffOrderPage.php">MY ORDER</a></li>
        <li><a href="Logout.php">LOGOUT</a></li>
        <div class="search-container">
            <form action="/action_page.php">
                <input type="text" placeholder="Search.." name="search">
                <button>Search</button>
            </form>
        </div>
    </ul>
</div>

<div><h2>Order</h2></div>

<div>
<form action="updateStaffOrderPage.php" method="post">
<table border="1">
<tr><th colspan="6">List of Orders</th></tr>
<tr>
    <th>Customer ID</th>
    <th>Order Status</th>
    <th>Change Status</th>
    <th>Invoice</th>
    <th>Manage Order</th>
</tr>
<?php
while ($row = mysqli_fetch_assoc($result)) {
    $pOrderID = $row["OrderID"];
    $pCustomerID = $row["CustomerID"];
    $porderStatus = $row["orderStatus"];
    $pStaffUsername = $row["username"];
?>
<tr>
    <td><?php echo $pCustomerID; ?></td>
    <td><?php echo $porderStatus; ?></td>
    <td><a href="updateStaffOrderPage.php?id=<?php echo $pCustomerID; ?>">Change Status</a></td>
    <td><a href="InvoiceGenerator.php?OrderID=<?php echo $pOrderID; ?>">Invoice</a></td>
    <td>
        <?php
        if (trim(strtolower($porderStatus)) === "ordered") { 
        ?>
            <a href="StaffManageOrder.php?OrderID=<?php echo $pOrderID; ?>">View Order</a>
        <?php } else { ?>
            <?php echo $pStaffUsername; ?>
        <?php } ?>
    </td>
</tr>
<?php
}
} else {
    echo "0 results";
}
?>
</table>
</form>
</div>
</body>
</html>

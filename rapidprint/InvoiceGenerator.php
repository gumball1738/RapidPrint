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

if (isset($_GET['OrderID'])) {
    $pOrderID = intval($_GET['OrderID']);

    $sql = "SELECT * FROM orders WHERE OrderID = $pOrderID";


    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $pInvoiceID = $row['OrderID'];
        $pdate = $row['createdAt'];
        $pTotalPrice = $row['totalPrice'];
        $pSize = $row['size'];
        $pQuantity = $row['quantity'];
        $pPagePerSheet = $row['pagePerSheet'];
    } else {
        $pInvoiceID = null;
        $pamount = null;
        $pdate = null;
        $pTotalPrice = null;
        $pSize = null;
        $pQuantity = null;
        $pPagePerSheet = null;
    }
} else {
    echo "<h2>Order ID not provided</h2>";
    exit;
}
?>

<html>
<head>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
<style>
table { 
    text-align: center;
    padding: 5px;
    width: 100%;
}
th { 
    text-align: center;
    padding: 10px;
    width: 100%;
}
h2 {
    text-align: center;	
}
textarea {
    text-align: center;	
    width: 100%;
}
button {
    padding: 10px 20px;
    margin: 5px;
    border: none;
    border-radius: 5px;
    cursor: pointer;
}
a {
    text-decoration: none;
    color: white;
}
.update {
    background-color: #4CAF50;
    color: white;
}
.cancel {
    background-color: #f44336;
    color: white;
}
.create {
    background-color: #008CBA;
    color: white;
}
</style>
<title>Invoice Generator</title>
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
        <li><a href="StaffDashboardPage.php#dashboard">DASHBOARD</a></li>
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

<h2>Generated Invoice</h2>
<div>
<form>
<table border="1">
    <?php if ($pInvoiceID) { ?>
        <tr>
            <th>Date: <?php echo $pdate ?></th>
        </tr>
        
        <tr>
            <th>Quantity: <?php echo $pQuantity ?></th>
            <th>Page per Sheet: <?php echo $pPagePerSheet ?></th>
        </tr>
		<tr>
            <th>Total Price: <?php echo $pTotalPrice ?></th>
            <th>Size: <?php echo $pSize ?></th>
        </tr>
    <?php } else { ?>
        <tr>
            <th colspan="2">No invoice available for this order.</th>
        </tr>
    <?php } ?>
</table>

<h2>
    <a class='btn btn-primary btn-sm' href='UpdateInvoicePage.php?OrderID=<?php echo $pOrderID; ?>'>Update</a>
	<a class='btn btn-primary btn-sm' href='deleteInvoice.php?OrderID=<?php echo $pOrderID; ?>'>Delete</a>
</h2> 
</form>
</div>
</body>
</html>

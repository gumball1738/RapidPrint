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

 $query = "SELECT * FROM orders WHERE OrderID = $pOrderID";

$result = mysqli_query($conn, $query);

if (mysqli_num_rows($result) > 0) {
?>
<html>
<head>
<style>
table{ 
text-align: center;
padding: 10px;
width: 100%;
}
th{ 
text-align: center;
padding: 100px;
width: 100%;
}
h2{
text-align: center;	
}
textarea{
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
</style>
<title>Update Invoice Page</title>
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
<h2>Order</h2>
<?php
    while($row = mysqli_fetch_assoc($result)) {
        $pInvoiceID = $row["OrderID"];
        $pOrderID = $row["OrderID"];
        $pDate = $row["createdAt"];
        $pTotalPrice = $row["totalPrice"];
        $pSize = $row["size"];
        $pQuantity = $row["quantity"];
        $pPagePerSheet = $row["pagePerSheet"];
    }
?>
<div>
<form action="UpdateInvoicePage2.php" method="post" >
<table border="1">
<tr>
    <th>Date: <input type="text" name="dateGenerated" value="<?php echo $pDate; ?>"></th>
</tr>
<tr>
    <th>Total Price: <input type="text" name="totalPrice" value="<?php echo $pTotalPrice; ?>"></th>
    <th>Size: <input type="text" name="size" value="<?php echo $pSize; ?>"></th>
</tr>
<tr>
    <th>Quantity: <input type="text" name="quantity" value="<?php echo $pQuantity; ?>"></th>
    <th>Page per Sheet: <input type="text" name="pagePerSheet" value="<?php echo $pPagePerSheet; ?>"></th>
</tr>
</table>

<input type="hidden" name="InvoiceID" value="<?php echo $pOrderID; ?>">
<input type="hidden" name="orderID" value="<?php echo $pOrderID; ?>">

<h2><button type="submit" class="submit">Submit</button></h2>
</form>
<?php
} else {
    echo "0 results";
}
?>
</body>
</html>

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

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} 

$query = "SELECT * FROM orders"
	or die(mysqli_connect_error());
	
	$result = mysqli_query($conn, $query);
	if (mysqli_num_rows($result) > 0){
?>
<html>
<head>
<style>
h2{
text-align: center;	
}
table{ 
text-align: left;
width: 800px;
width: 100%;
}
th{
text-align: center;	
}
td{
text-align: right;	
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
                <a href="MainPage3.php">
                    <img src="images/Logo.jpg" alt="Logo">
                </a>
            </li>
            <li><a href="AdminDashboard.php"#dashboard">DASHBOARD</a></li>
            <li><a href="OrderListPage.php">MY ORDER</a></li>
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
	<table border="1">
	<tr><th colspan = "3">List of Order</th></tr>
	<?php
	while($row = mysqli_fetch_assoc($result)){
    $pOrderID = $row["OrderID"];
	$pCustomerID = $row["CustomerID"];
	$porderStatus = $row["orderStatus"];
	?>
	<tr><th>Order for <?php echo $pCustomerID ?> </th>
	<th>Status: <?php echo $porderStatus; ?>
	<th><a href="InvoiceGenerator.php?OrderID=<?php echo $pOrderID; ?>">Invoice</a></th></tr></th>
	</div>
	<?php
    }
} else {
    echo "0 results";

}?></table>
</body>
</html>
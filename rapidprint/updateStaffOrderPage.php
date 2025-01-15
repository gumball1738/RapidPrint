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

$idURL = $_GET['id'];

$query = "SELECT * from orders where CustomerID = '$idURL'"
	or die(mysqli_connect_error());
	
$result = mysqli_query($conn, $query);

$row = mysqli_fetch_assoc($result);
	$pOrderID = $row["OrderID"];
	$pCustomerID = $row["CustomerID"];
	$porderStatus = $row["orderStatus"];
?>

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
                 <a href="MainPage4.php">
                    <img src="images/Logo.jpg" alt="Logo">
                </a>
            </li>
            <li><a href= "StaffDashboardPage.php"#dashboard">DASHBOARD</a></li>
            <li><a href="#news">PACKAGE LIST</a></li>
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
	
	<div>
	<form action="StaffOrderPage2.php" method="post" >
	<table>
	<tr><th>Order for <?php echo $pCustomerID ?> </th>
	<tr><th>Status: 
	<input type ="text" name="orderStatus" value="<?php echo $porderStatus ?>"></th></tr>
	</table>
	</div>
	<input type ="hidden" name="id2" value="<?php echo $idURL; ?>">
	<input type ="submit" value="Update">
	</div>
</body>
</html>
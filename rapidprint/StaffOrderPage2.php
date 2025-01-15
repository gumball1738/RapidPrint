<?php

session_start();

$servername = "localhost"; 
$username = "root";        
$password = "";            
$dbname = "rapidprintdb"; 

$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} 

mysqli_select_db($conn, "rapidprintdb") or die(mysqli_error($conn));
	
	$pOrderID = $_POST["OrderID"];
	$pCustomerID = $_POST["CustomerID"];
	$porderStatus = $_POST["orderStatus"];
	$pid2 = $_POST["id2"];

	
	$query = "UPDATE orders SET orderStatus = '$porderStatus' WHERE CustomerID = '$pid2'";

$result = mysqli_query($conn,$query) or die ("Could not execute query in ubah.php");
if($result){
 echo "<script type = 'text/javascript'> window.location='StaffOrderPage.php' </script>";
}
?>
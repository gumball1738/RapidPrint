<?php
session_start();

$servername = "localhost"; 
$username = "root";        
$password = "";            
$dbname = "rapidprintdb"; 

// Connect to the database
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$pOrderID = intval($_GET['OrderID']);

// Update query to clear data except for OrderID
$sql2 = "UPDATE orders SET InvoiceID = NULL, createdAt = NULL, quantity = NULL, pagePerSheet = NULL, totalPrice = NULL, size = NULL WHERE OrderID = $pOrderID";

if ($conn->query($sql2) === TRUE) {
    echo "Record updated successfully in orders table";
    header("Location: StaffOrderPage.php");
    exit;
} else {
    echo "Error updating record: " . $conn->error;
}

// Close the connection
$conn->close();
?>

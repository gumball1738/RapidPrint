<?php
session_start();

$servername = "localhost"; 
$username = "root";        
$password = "";            
$dbname = "rapidprintdb"; 

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get data from the form submission
$pInvoiceID = $_POST['InvoiceID'];   // Get InvoiceID (hidden input field)
$pOrderID = $_POST['orderID'];       // Get OrderID (hidden input field)
$pDate = $_POST['dateGenerated'];    // Get updated date
$pTotalPrice = $_POST['totalPrice']; // Get updated total price
$pSize = $_POST['size'];             // Get updated size
$pQuantity = $_POST['quantity'];     // Get updated quantity
$pPagePerSheet = $_POST['pagePerSheet']; // Get updated page per sheet

// Update query to modify the data in the orders table (assuming InvoiceID is part of orders table)
$query = "UPDATE orders 
          SET createdAt = '$pDate', 
              totalPrice = '$pTotalPrice', 
              size = '$pSize', 
              quantity = '$pQuantity', 
              pagePerSheet = '$pPagePerSheet' 
          WHERE OrderID = '$pOrderID'"; // OrderID should be used as the reference to update the data

// Execute the query
if (mysqli_query($conn, $query)) {
    echo "Invoice updated successfully.";

    // Redirect back to the UpdateInvoicePage with the updated OrderID
    header("Location: StaffOrderPage.php?OrderID=$pOrderID");
} else {
    echo "Error updating invoice: " . mysqli_error($conn);
}

// Close the connection
$conn->close();
?>

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

// Check if staffID is set and not empty
$pStaffID = isset($_POST['staffID']) ? $_POST['staffID'] : null;
if ($pStaffID === null || empty($pStaffID)) {
    echo "Staff ID is required!";
    exit();
}

// Retrieve the data from the form
$pInvoiceID = $_POST['InvoiceID'];
$pOrderID = $_POST['OrderID'];

// Retrieve the order's totalPrice from the database using the OrderID
$query = "SELECT orders.totalPrice, orders.quantity 
          FROM orders 
          WHERE OrderID = '$pOrderID'";

$result = mysqli_query($conn, $query);

if ($result === false) {
    die("Error executing query: " . mysqli_error($conn));
}

if (mysqli_num_rows($result) > 0) {
    $row = mysqli_fetch_assoc($result);
    $pOrderPrice = $row["totalPrice"];
    $pOrderQuantity = $row["quantity"];
    $pOrderTotalPrice = $pOrderPrice * $pOrderQuantity; // Calculate total price
} else {
    echo "Order not found.";
    exit();
}

$queryStaff = "SELECT monthlySale FROM staff WHERE StaffID = '$pStaffID'";

$resultStaff = mysqli_query($conn, $queryStaff);

if ($resultStaff === false) {
    die("Error executing query: " . mysqli_error($conn));
}

if (mysqli_num_rows($resultStaff) > 0) {
    $rowStaff = mysqli_fetch_assoc($resultStaff);
    $currentMonthlySale = $rowStaff["monthlySale"];

    // Add the current order's total price to the staff's monthlySales
    $newMonthlySale = $currentMonthlySale + $pOrderTotalPrice;

    // Update the staff's monthlySales in the database
    $updateStaffSale = "UPDATE staff 
                         SET monthlySale = '$newMonthlySale' 
                         WHERE StaffID = '$pStaffID'";

    if (mysqli_query($conn, $updateStaffSale)) {
        echo "Staff monthly sales updated successfully.";
    } else {
        echo "Error updating staff monthly sales: " . mysqli_error($conn);
    }
} else {
    echo "Staff not found.";
}

// Now update the staffID in the orders table and set the orderStatus to 'accepted'
$updateOrder = "UPDATE orders 
                SET StaffID = '$pStaffID', 
                    orderStatus = 'accepted' 
                WHERE OrderID = '$pOrderID'";

if (mysqli_query($conn, $updateOrder)) {
    // Redirect to StaffOrderPage after successful update
    header("Location: StaffOrderPage.php");
    exit(); // Ensure no further code is executed after the redirect
} else {
    echo "Error updating order with Staff ID and status 'accepted': " . mysqli_error($conn);
}

// Close the connection
$conn->close();

?>

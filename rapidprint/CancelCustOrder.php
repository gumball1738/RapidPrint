<?php
session_start();

if (isset($_GET["OrderID"])) {
    $id = $_GET["OrderID"];
    
    $servername = "localhost";
    $username = "root";
    $password = "";
    $database = "rapidprintdb";
    
    // Create connection
    $connection = new mysqli($servername, $username, $password, $database);
    
    // Check connection
    if ($connection->connect_error) {
        die("Connection failed: " . $connection->connect_error);
    }
    
    // Prepare the SQL statement
    $stmt = $connection->prepare("DELETE FROM orders WHERE OrderID = ?");
    $stmt->bind_param("i", $id); // "i" specifies the type as integer
    $stmt->execute();
    $stmt->close();
    
    $connection->close();
}
header("Location: /WEBE/rapidprint/CustOrder.php");
exit;
?>

<?php
// Start session
session_start();

// Check if the user is logged in
if (!isset($_SESSION["session_name"])) {
    echo json_encode(["success" => false, "message" => "User not logged in."]);
    exit();
}

// Retrieve the username from the session
$username = $_SESSION["session_name"];

// Database connection
$servername = "localhost";
$dbUsername = "root";
$password = "";
$dbname = "rapidprintdb";

// Create connection
$conn = new mysqli($servername, $dbUsername, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    echo json_encode(["success" => false, "message" => "Database connection failed."]);
    exit();
}

// Prepare the DELETE query to remove the membership
$sql = "DELETE FROM membership WHERE username = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $username);

if ($stmt->execute()) {
    echo json_encode(["success" => true, "message" => "Membership successfully canceled."]);
} else {
    echo json_encode(["success" => false, "message" => "Failed to cancel membership."]);
}

$stmt->close();
$conn->close();
?>

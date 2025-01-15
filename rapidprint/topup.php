<?php
// Start session
session_start();

// Database connection
$servername = "localhost";
$dbUsername = "root";
$password = "";
$dbname = "rapidprintdb";

$conn = new mysqli($servername, $dbUsername, $password, $dbname);
if ($conn->connect_error) {
    die(json_encode(["success" => false, "message" => "Connection failed: " . $conn->connect_error]));
}

// Validate POST data
if (!isset($_POST["amount"]) || !isset($_POST["username"])) {
    echo json_encode(["success" => false, "message" => "Invalid request. Missing amount or username."]);
    exit();
}

$amount = (float)$_POST["amount"];
$username = $_POST["username"];

// Log request for debugging
error_log("Top-up request received: amount=$amount, username=$username");

// Update the moneyBalance
$sql = "UPDATE membership SET moneyBalance = moneyBalance + ? WHERE username = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ds", $amount, $username);

if (!$stmt->execute()) {
    echo json_encode([
        "success" => false,
        "message" => "Database error: " . $stmt->error
    ]);
    $stmt->close();
    $conn->close();
    exit();
}

// Fetch the updated balance
$stmt = $conn->prepare("SELECT moneyBalance FROM membership WHERE username = ?");
$stmt->bind_param("s", $username);
$stmt->execute();
$result = $stmt->get_result();
$row = $result->fetch_assoc();

echo json_encode([
    "success" => true,
    "newBalance" => (float) $row["moneyBalance"]
]);

$stmt->close();
$conn->close();
?>

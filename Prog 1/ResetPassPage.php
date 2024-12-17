<?php
// Start the session
session_start();

// Database connection
$servername = "localhost"; // Replace with your server name
$username = "root";        // Replace with your database username
$password = "";            // Replace with your database password
$dbname = "rapidprintdb"; // Replace with your database name

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if the form was submitted and the reset_password action is set
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["reset_password"])) {
    $username = trim($_POST["username"]);
    $newPassword = trim($_POST["new_password"]);
    $confirmPassword = trim($_POST["confirm_password"]);

    // Validate input
    if (!empty($username) && !empty($newPassword) && !empty($confirmPassword)) {
        if ($newPassword === $confirmPassword) {
            // Check if the username exists in any role table
            $checkSql = "
                SELECT 'customer' AS role, username FROM customer WHERE username = ? 
                UNION
                SELECT 'staff' AS role, username FROM staff WHERE username = ? 
                UNION
                SELECT 'administrator' AS role, username FROM administrator WHERE username = ?";
            $checkStmt = $conn->prepare($checkSql);
            $checkStmt->bind_param("sss", $username, $username, $username);
            $checkStmt->execute();
            $checkResult = $checkStmt->get_result();

				if ($checkResult->num_rows > 0) {
    while ($row = $checkResult->fetch_assoc()) {
        $role = $row['role'];

        if (in_array($role, ['customer', 'staff', 'administrator'])) {
            $updateSql = "UPDATE `" . $role . "` SET password = ? WHERE username = ?";
            $updateStmt = $conn->prepare($updateSql);
            $updateStmt->bind_param("ss", $newPassword, $username);

            if ($updateStmt->execute()) {
                echo "<p style='color: green;'>Password reset successful for $role.</p>";
            } else {
                echo "<p style='color: red;'>Error: " . $updateStmt->error . "</p>";
            }
        } else {
            echo "<p style='color: red;'>Invalid role: $role</p>";
        }
    }
} else {
    echo "<p style='color: red;'>Username not found. Please check your username and try again.</p>";
}

            $checkStmt->close();
        } else {
            echo "<p style='color: red;'>Passwords do not match. Please try again.</p>";
        }
    } else {
        echo "<p style='color: red;'>All fields are required.</p>";
    }
} else {
    echo "<p style='color: red;'></p>"; // Add this to catch errors
}

$conn->close();

?>


<!DOCTYPE html>
<html>
<head>
    <title>Reset Password</title>
    <style>
        body {
            font-family: Arial, sans-serif;
			background-image: url('images/umpsa.jpg');
			background-repeat: no-repeat;
			background-attachment: fixed;
			background-size: cover;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }
        .container {
            background-color: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            text-align: center;
            width: 300px;
        }
        .container h1 {
            font-size: 24px;
            margin-bottom: 20px;
        }
        .container label {
            display: block;
            text-align: left;
            margin-bottom: 5px;
            font-weight: bold;
        }
        .container input[type="text"],
        .container input[type="password"] {
            width: calc(100% - 20px);
            padding: 10px;
            margin-bottom: 20px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }
        .container button {
            padding: 10px 20px;
            margin: 5px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
        .container .reset-btn {
            background-color: #007bff;
            color: white;
        }
        .container .cancel-btn {
            background-color: #6c757d;
            color: white;
        }
		.copyright{
		font-size: 70%;
		}
    </style>
</head>
<body>
    <div class="container">
        <h1 align="justify"><img src="images/Logo.jpg" alt="RapidPrint Logo" width="100">          Reset Password</h1>
        <form method="post" action="">
            <label for="username">Username:</label>
            <input type="text" id="username" name="username" required>
            <label for="new_password">New Password:</label>
            <input type="password" id="new_password" name="new_password" required>
            <label for="confirm_password">Confirm Password:</label>
            <input type="password" id="confirm_password" name="confirm_password" required>
            <button type="submit" class="reset-btn" name="reset_password">Reset Password</button>
            <button type="button" class="cancel-btn" onclick="window.location.href='LoginPage.php'">Cancel</button>
        </form>
        <footer class="copyright">
            <p> © 2024 RapidPrint. All rights reserved.</p>
        </footer>
    </div>
</body>
</html>
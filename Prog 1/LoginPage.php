<?php
// Start the session
session_start();

// Database connection
$servername = "localhost"; // Replace with your server name
$username = "root";        // Replace with your database username
$password = "";            // Replace with your database password
$dbname = "rapidprintdb";   // Replace with your database name

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $inputUsername = $_POST["username"];
    $inputPassword = $_POST["password"];
    $selectedRole = $_POST["role"];

    // Validate input
    if (!empty($inputUsername) && !empty($inputPassword) && !empty($selectedRole)) {
        // Role-specific query
        $table = '';
        switch ($selectedRole) {
            case 'customer':
                $table = 'customer';
                break;
            case 'staff':
                $table = 'staff';
                break;
            case 'administrator':
                $table = 'administrator';
                break;
            default:
                echo "<p style='color: red;'>Invalid role selected.</p>";
                exit();
        }

        // Query to check user credentials in the specific role table
        $sql = "SELECT username, password FROM $table WHERE username = ? AND password = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ss", $inputUsername, $inputPassword);
        $stmt->execute();
        $result = $stmt->get_result();

        // Check if a user was found
        if ($result->num_rows == 1) {
            $user = $result->fetch_assoc();
            $_SESSION["session_id"] = session_id();
            $_SESSION["session_name"] = $user["username"];
            $_SESSION["session_role"] = $selectedRole;

            // Store CustomerID only for customers
            if ($selectedRole === "customer") {
                $sqlCustomer = "SELECT CustomerID FROM customer WHERE username = ?";
                $stmtCustomer = $conn->prepare($sqlCustomer);
                $stmtCustomer->bind_param("s", $inputUsername);
                $stmtCustomer->execute();
                $resultCustomer = $stmtCustomer->get_result();
                if ($resultCustomer->num_rows > 0) {
                    $userCustomer = $resultCustomer->fetch_assoc();
                    $_SESSION["CustomerID"] = $userCustomer["CustomerID"];
                }
            }

            // Redirect based on role
            if ($selectedRole === "customer") {
                header("Location: MainPage2.php");
            } elseif ($selectedRole === "administrator") {
                header("Location: MainPage3.php");
            } elseif ($selectedRole === "staff") {
                header("Location: MainPage4.php");
            }
            exit();
        } else {
            // Invalid credentials
            echo "<p style='color: red;'>Invalid username and password</p>";
        }

        $stmt->close();
    } else {
        echo "<p style='color: red;'>Both fields are required</p>";
    }
}

$conn->close();
?>


<!DOCTYPE html>
<html>
<head>
    <title>RapidPrint Login</title>
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
             font-family: 'Orbitron', sans-serif;
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
        .container .submit-btn {
            background-color: #007bff;
            color: white;
        }
        .container .signup-btn {
            background-color: #007bff;
            color: white;
        }
        .container .reset-btn {
            background-color: #6c757d;
            color: white;
        }
        .container .reset-password-btn {
            background-color: #007bff;
            color: white;
            width: 100%;
        }
        .copyright{
            font-size: 70%;
        }
    
    </style>
</head>
<body>
    <div class="container">
        <h1 align="justify"><img src="images/LogoRP.jpg" alt="RapidPrint Logo" width="100">          RapidPrint</h1>
        <form method="post" action="LoginPage.php">
            <label for="username">Username:</label>
            <input type="text" id="username" name="username">
            <label for="password">Password:</label>
            <input type="password" id="password" name="password">
            <button type="submit" class="submit-btn">Submit</button>
            <button onclick="document.location='SignUpPage.php'" type="button" class="signup-btn">Sign Up</button>
            <button type="reset" class="reset-btn">Reset</button>
            <button onclick="document.location='ResetPassPage.php'" type="button" class="reset-password-btn">Forgot Password?</button>
        </form>
        <br>
        <footer class="copyright">
            <p> © 2024 RapidPrint. All rights reserved.</p>
        </footer>
    </div>
</body>
</html>

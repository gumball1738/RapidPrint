<?php
// Start the session
session_start();

// Database connection
$servername = "localhost"; // Replace with your server name
$username = "root";        // Replace with your database username
$password = "";            // Replace with your database password
$dbname = "mydb"; // Replace with your database name

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

    // Validate input
    if (!empty($inputUsername) && !empty($inputPassword)) {
        // Query to check user credentials
        $sql = "SELECT * FROM user_login WHERE user_name = ? AND password = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ss", $inputUsername, $inputPassword);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows == 1) {
            // User exists, start session
            $user = $result->fetch_assoc();
            $_SESSION["session_id"] = session_id();
            $_SESSION["session_name"] = $user["user_name"];

            // Redirect to a welcome page or dashboard
            echo "Login successful! Welcome " . $_SESSION["session_name"];

            // Redirect to welcome page
            header("Location: ManageKoperasiPage.php");
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
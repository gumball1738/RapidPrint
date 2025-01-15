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

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $inputUsername = $_POST["username"];
    $inputPassword = $_POST["password"];
    $selectedRole = $_POST["role"];

    if (!empty($inputUsername) && !empty($inputPassword) && !empty($selectedRole)) {
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

        $sql = "SELECT username, password FROM $table WHERE username = ? AND password = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ss", $inputUsername, $inputPassword);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows == 1) {
            $user = $result->fetch_assoc();
            $_SESSION["session_id"] = session_id();
            $_SESSION["session_name"] = $user["username"];
            $_SESSION["session_role"] = $selectedRole;

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

            if ($selectedRole === "customer") {
                header("Location: MainPage2.php");
            } elseif ($selectedRole === "administrator") {
                header("Location: MainPage3.php");
            } elseif ($selectedRole === "staff") {
                header("Location: MainPage4.php");
            }
            exit();
        } else {
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
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>RapidPrint Login</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <style>
        body {
            background-image: url('images/umpsa.jpg');
            background-repeat: no-repeat;
            background-attachment: fixed;
            background-size: cover;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
            color: #333;
        }
        .container {
            background-color: white;
            padding: 40px;
            border-radius: 15px;
            box-shadow: 0 4px 30px rgba(0, 0, 0, 0.1);
            width: 50%;
            max-width: 350px;
        }
        .container h1 {
            font-size: 32px;
            margin-bottom: 20px;
            text-align: left;
        }
        .container input[type="text"],
        .container input[type="password"],
        .container select {
            width: calc(100%);
            padding: 12px;
            margin-bottom: 20px;
            border: 1px solid #ccc;
            border-radius: 5px;
            border-color: black;
            outline: none;
            font-size: 16px;
            transition: border-color 0.3s;
        }
        .container button {
            padding: 12px 20px;
            margin: 5px 0;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
            transition: background-color 0.3s, transform 0.3s;
        }
        .container .submit-btn {
            background-color: #007bff;
            color: white;
        }
        .copyright{
        font-size: 70%;
        }

    </style>
</head>
<body>
    <div class="container">
        <h1 align="justify"><img src="images/Logo.jpg" alt="RapidPrint Logo" width="100">RapidPrint</h1>
        <form method="post" action="LoginPage.php">
            <input type="text" id="username" name="username" placeholder="Username" required>
            <input type="password" id="password" name="password" placeholder="Password" required>

            <select id="role" name="role" required>
                <option value="" disabled selected>Role</option>
                <option value="customer">Customer</option>
                <option value="staff">Staff</option>
                <option value="administrator">Administrator</option>
            </select>
            <button type="submit" class="submit-btn">Submit</button>
            <br><br>
            <a href="ResetPassPage.php">Forget Password?</a>
        </form>
        <hr>
        <footer class="copyright">
            <p> © 2024 RapidPrint. All rights reserved.</p>
        </footer>
    </div>
</body>
</html>
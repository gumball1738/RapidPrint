<?php
// Start the session
session_start();

// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "rapidprintdb";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// CSRF token generation
if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}

// Handle signup form submission
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["signup"])) {
    // Validate CSRF token
    if (!hash_equals($_SESSION['csrf_token'], $_POST['csrf_token'])) {
        die("Invalid CSRF token.");
    }

    $newUsername = trim($_POST["new_username"]);
    $newEmail = trim($_POST["new_email"]);
    $newPassword = trim($_POST["new_password"]);
    $newPhoneNumber = trim($_POST["new_phoneNumber"]);

    // Validate input fields
    if (empty($newUsername) || empty($newEmail) || empty($newPassword) || empty($newPhoneNumber)) {
        echo "<p style='color: red;'>All fields are required for signup.</p>";
    } elseif (!filter_var($newEmail, FILTER_VALIDATE_EMAIL)) {
        echo "<p style='color: red;'>Invalid email format.</p>";
    } elseif (!preg_match("/^[a-zA-Z0-9]{3,20}$/", $newUsername)) {
        echo "<p style='color: red;'>Username must be alphanumeric (3-20 characters).</p>";
    } elseif (!preg_match("/^(?=.*[A-Za-z])(?=.*\d)[A-Za-z\d]{8,}$/", $newPassword)) {
        echo "<p style='color: red;'>Password must be at least 8 characters long and contain letters and numbers.</p>";
    } elseif (!preg_match("/^[a-zA-Z0-9]{3,20}$/", $newPhoneNumber)) {
        echo "<p style='color: red;'>Phone Number must be interger (3-20 characters).</p>";
    } else {
        // Check if username already exists
        $checkSql = "SELECT * FROM customer WHERE username = ?";
        $checkStmt = $conn->prepare($checkSql);
        $checkStmt->bind_param("s", $newUsername);
        $checkStmt->execute();
        $checkResult = $checkStmt->get_result();

        if ($checkResult->num_rows == 0) {

            // Insert the new user into the database
            $insertSql = "INSERT INTO customer (username, email, password, phoneNumber) VALUES (?, ?, ?, ?)";
            $insertStmt = $conn->prepare($insertSql);
            $insertStmt->bind_param("ssss", $newUsername, $newEmail, $newPassword, $newPhoneNumber );

            if ($insertStmt->execute()) {
                echo "<p style='color: green;'>Signup successful! You can now <a href='LoginPage.php'>log in</a>.</p>";
            } else {
                echo "<p style='color: red;'>Error: Unable to create account. Please try again.</p>";
            }
            $insertStmt->close();
        } else {
            echo "<p style='color: red;'>Username already exists. Please choose a different username.</p>";
        }

        $checkStmt->close();
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html>
<head>
    <title>RapidPrint Signup</title>
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
        .container .signup-btn {
            background-color: #007bff;
            color: white;
        }
        .container .cancel-btn {
            background-color: #6c757d;
            color: white;
        }
        .copyright {
            font-size: 70%;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1 align="justify">
            <img src="images/Logo.jpg" alt="RapidPrint Logo" width="100"> Sign Up
        </h1>
        <form method="post" action="">
            <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">
            <label for="new_username">Username:</label>
            <input type="text" id="new_username" name="new_username" required>
            <label for="new_email">Email:</label>
            <input type="text" id="new_email" name="new_email" required>
            <label for="new_password">Password:</label>
            <input type="password" id="new_password" name="new_password" required>
            <label for="new_phoneNumber">Phone Number:</label>
            <input type="text" id="new_phoneNumber" name="new_phoneNumber" required>
            <button type="submit" class="signup-btn" name="signup">Sign Up</button>
            <button type="button" class="cancel-btn" onclick="window.location.href='LoginPage.php'">Cancel</button>
        </form>
        <footer class="copyright">
            <p>© 2024 RapidPrint. All rights reserved.</p>
        </footer>
    </div>
</body>
</html>

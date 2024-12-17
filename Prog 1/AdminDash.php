<?php
// Start the session
session_start();

// Check if the user is logged in
if (!isset($_SESSION["session_name"])) {
    // Redirect to LoginForm.php if no session is found
    header("Location: LoginPage.php");
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>RapidPrint Main Page</title>
	<link rel="stylesheet" type="text/css" href="styles/style.css">      
    <style>

    </style>
</head>
<body>
    <div class="navigation">
        <ul>
            <li>
                <a href="MainPage3.php">
                    <img src="images/Logo.jpg" alt="Logo">
                </a>
            </li>
            <li><a href= "adminRegister.php"#dashboard">DASHBOARD</a></li>
            <li><a href="#news">PACKAGE LIST</a></li>
            <li><a href="OrderListPage.php">MY ORDER</a></li>
            <li><a href="logout.php">LOGOUT</a></li>
            <div class="search-container">
                <form action="/action_page.php">
                    <input type="text" placeholder="Search.." name="search">
                    <button>Search</button>
                </form>
            </div>
        </ul>
    </div>
	
	 <div class="dashboard-container">
        <!-- Chart Section -->
        <div class="sales-chart">
            <h3>Monthly Sales</h3>
            <img src="images/graph.png" alt="Sales Chart">
        </div>

        <!-- Sales Info Section -->
        <div class="sales-info">
            <p><strong>Total RM in sales:</strong> RMXXXX</p>
            <p><strong>Total Maintenance spent:</strong> RM XXX</p>
            <p><strong>Total resources spent:</strong> RM XXX</p>
            <p><strong>Total bonus for staff:</strong> RM XX</p>
            <p><strong>Total discount used by customer:</strong> RM XXX</p>
            <button>Edit</button>
        </div>

        <!-- User Info Section -->
        <div class="user-info">
            <img src="images/usericon.png" alt="User Profile">
            <p>Welcome, Syafiq</p>
         
        </div>
    </div>
	
</body>
</html>
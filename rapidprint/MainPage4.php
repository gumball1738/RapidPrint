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
    <title>Staff RapidPrint Main Page</title>
	<link rel="stylesheet" type="text/css" href="styles/style.css">      
    <style>

    </style>
</head>
<body>
    <div class="navigation">
        <ul>
            <li>
                <a href="MainPage4.php">
                    <img src="images/Logo.jpg" alt="Logo">
                </a>
            </li>
            <li><a href="StaffDashboardPage.php">DASHBOARD</a></li>
            <li><a href="StaffBonus.php">BONUS</a></li>
            <li><a href="StaffOrderPage.php">MY ORDER</a></li>
            <li><a href="Logout.php">LOGOUT</a></li>
            <div class="search-container">
                <form action="/action_page.php">
                    <input type="text" placeholder="Search.." name="search">
                    <button>Search</button>
                </form>
            </div>
        </ul>
    </div>
	
	<img src="images/promotion1.jpg" alt="Trulli" width="100%" height="500">
	
	
	<div class="background">
        <p>Contact Us:</p>
        <p>Email: aididyasmin22@gmail.com</p>
		<p>Email: muhammadariff@gmail.com</p>
		<p>Email: nasruladham@gmail.com</p>
		<p>Email: muhammadaiman@gmail.com</p>
		<br>
        <p>Phone: 018-3602802</p>
		<p>Phone: 018-2323543</p>
    </div>
	
</body>
</html>

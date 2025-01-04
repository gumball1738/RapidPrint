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
                <a href="MainPage2.php">
                    <img src="images/Logo.jpg" alt="Logo">
                </a>
            </li>
            <li><a href= "CustomerDashboard.php"#dashboard">DASHBOARD</a></li>
            <li><a href="#news">PACKAGE LIST</a></li>
            <li><a href="OrderListPage.php">MY ORDER</a></li>
            <li><a href="LogOut.php">LOGOUT</a></li>
            <div class="search-container">
                <form action="/action_page.php">
                    <input type="text" placeholder="Search.." name="search">
                    <button>Search</button>
                </form>
            </div>
        </ul>
    </div>
	
	<img src="images/promotion1.jpg" alt="Trulli" width="100%" height="500">
	
	<div class="mycontainer">
		<div style="background-color:transparent;">
			<a href="PlaceOrderPage.php">
                <img src="images/a5icon.png" alt="a3" width="250" height="250">
            </a>
			<h1>Package 1</h1>
			<p>A3 SIZED PAPER</p>
		</div>
  
		<div style="background-color:transparent;">
			<a href="PlaceOrderPage.php">
                <img src="images/a4icon.png" alt="a4" width="250" height="250">
            </a>
			<h1>Package 2</h1>
			<p>A4 SIZED PAPER</p>
		</div>
		<div style="background-color:transparent;">
			<a href="PlaceOrderPage.php">
                <img src="images/a3icon.png" alt="a4" width="250" height="250">
            </a>
			<h1>Package 3  </h1>
			<p>A5 SIZED PAPER</p>
		</div>
	</div>
	
	<div class="background">
		<p>Contact Us:</p>
		<p>aididyasmin22@gmail.com</p>
		<p>018-3602802</p>
	</div>
	
</body>
</html>

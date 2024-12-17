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
		th{
			text-align: left;
		}
		table{
			width: 100%;
		}
		

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
            <li><a href= "userRegister.php"#dashboard">DASHBOARD</a></li>
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
	
	 <div class="payment-container">
        <div class="payment-methods">
            <div>
                <label>Select Payment Method:</label>
                <label>
                    <input type="radio" name="payment-method" value="membership" checked>
                    Membership Card
                </label>
                <label>
                    <input type="radio" name="payment-method" value="cash">
                    Cash (transaction at UMPSA Coop Counter)
                </label>
            </div>

            <div class="membership-id">
                <label for="membership-id">Membership Card ID:</label>
                <input type="text" id="membership-id" placeholder="Enter your Membership Card ID">
                <span style="font-size: 12px; color: #666;">(Cash payment does not require to fill this)</span>
            </div>
        </div>

        <div class="payment-summary">
            <div class="total">Total = RM XX</div>
            <button type="submit">Pay</button>
        </div>
    </div>


</body>
</html>
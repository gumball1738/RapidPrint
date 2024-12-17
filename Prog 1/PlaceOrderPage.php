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
	
	<table>
	
	<table>
		<tr><th rowspan="6"> <img src="images/a4icon.png" alt="a4" ></th>
		
		<th>
			
			<label for="quantity">Quantity:</label>
			<th><input type="text" id="quantity" name="quantity" placeholder="Enter quantity" value="2"></th>
		</th>
	
		<tr><th>
			<label for="color">Color/Grayscale:</label>
			<th><select id="color" name="color">
				<option value="color" selected>Color</option>
				<option value="grayscale">Grayscale</option>
			</select></th>
		</th></tr>
		
		<tr><th>
			<label for="pages">Page per sheet:</label>
			<th><input type="text" id="pages" name="pages" placeholder="Enter pages per sheet" value="6"></th>
		</th></tr>

		<tr><th>
			<label for="file">Insert Document:</label>
				<th><img src="upload-icon.png" alt="Upload Icon" style="width: 30px;">
				<span>Click to upload</span>
				<input type="file" id="file" name="file" style="display: none;"></th>
			</div>
		</th></tr>

		<tr><th>
			<label for="request">Other request:</label>
			<th><textarea id="request" name="request" placeholder="Type here..."></textarea></th>
		</th></tr>
		
		<tr><th>
			 
			 <th><button onclick="document.location='PaymentPage.php'"type="button" class="placeorder-btn">Place Order</button></th>
		</th></tr>
		</tr>
	</table>


</body>
</html>

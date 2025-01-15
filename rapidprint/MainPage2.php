<?php
session_start();
if (!isset($_SESSION["session_name"])) {
    header("Location: LoginPage.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>RapidPrint Main Page</title>
    <link rel="stylesheet" href="styles/style.css"> 
    <style>
        /* General Body Styling */
        body {
            font-family: 'Arial', sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f9;
            color: #333;
        }

        /* Main Content Section */
        .main-content {
            text-align: center;
            margin-top: 20px;
        }

        .main-content img {
            width: 100%;
            height: auto;
            border-radius: 10px;
        }

        /* Footer Section */
        .background {
            background-color: #333;
            color: white;
            text-align: center;
            padding: 20px 0;
            margin-top: 50px;
        }

        .background p {
            margin: 5px 0;
            font-size: 14px;
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .navigation ul {
                flex-direction: column;
                align-items: center;
            }

            .navigation input[type="text"] {
                width: 80%;
                margin: 5px 0;
            }

            .navigation button {
                width: 80%;
            }

            .main-content img {
                width: 90%;
                margin: 10px auto;
            }
        }
    </style>
</head>
<body>


    <div class="navigation">
        <ul>
            <li>
                <a href="MainPage2.php">
                    <img src="images/Logo.jpg" alt="Logo" width="100" height="60"> <!-- Adjust the logo size -->
                </a>
            </li>
            <li><a href="CustomerDashboard.php" id="dashboard">DASHBOARD</a></li>
            <li><a href="PackageList.php">PACKAGE LIST</a></li>
            <li><a href="CustOrder.php">MY ORDER</a></li>
            <li><a href="Logout.php">LOGOUT</a></li>
            <div class="search-container">
                <form action="/action_page.php">
                    <input type="text" placeholder="Search.." name="search">
                    <button type="submit">Search</button>
                </form>
            </div>
        </ul>
    </div>

    <div class="main-content">
        <img src="images/promotion1.jpg" alt="Promotion Image">
    </div>

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
	
    </div>

</body>
</html>

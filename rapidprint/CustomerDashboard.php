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
    <link rel="stylesheet" type="text/css" href="Styles/style.css">  
    <title>Customer Dashboard</title>
</head>
<style>
  .dashboard-container {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            padding: 20px;
        }

        /* Button section */
        .buttons {
            width: 30%;
        }

        .buttons table {
            width: 100%;
        }

        .buttons button {
            width: 100%;
            padding: 10px;
            margin-bottom: 10px;
            font-size: 16px;
            cursor: pointer;
        }


        @media screen and (max-width: 600px) {
            .navigation {
                flex-wrap: wrap; /* Allow wrapping on small screens */
            }

            .navigation .search-container {
                margin-left: 0;
                width: 100%;
                justify-content: center;
            }

            .navigation .search-container input[type="text"],
            .navigation .search-container button {
                width: 100%;
                margin: 5px 0;
            }
        }
		
</style>
<body>
    <div class="navigation">
        <ul>
            <li>
                <a href="MainPage2.php">
                    <img src="images/Logo.jpg" alt="Logo">
                </a>
            </li>
            <li><a href= "CustomerDashboard.php"#dashboard">DASHBOARD</a></li>
            <li><a href="PackageList.php">PACKAGE LIST</a></li>
            <li><a href="CustOrder.php">MY ORDER</a></li>
            <li><a href="Logout.php">LOGOUT</a></li>
            <div class="search-container">
                <form action="/action_page.php">
                    <input type="text" placeholder="Search.." name="search">
                    <button>Search</button>
                </form>
            </div>
        </ul>
    </div>

    <div class="dashboard-container">
        <div class="buttons" id="buttons">
            <table>
                <tr><th><button onclick="document.location='CustomerPointSection.php'">Customer Detail</button></th></tr>
                <tr><th><button onclick="window.location.href='StatusVerificationcontainer.php'">Status Verification</button></th></tr>
                <tr><th><button onclick="window.location.href='ApplyMembershipcontainer.php'">Apply Membership</button></th></tr>
                <tr><th><button onclick="window.location.href='MembershipBalanceSection.php'">Membership Balance</button></th></tr>
                <tr><th><button onclick="window.location.href='UpdateProfilecontainer.php'">Update Profile</button></th></tr>
                <tr><th><button onclick="window.location.href='Deletecontainer.php'">Delete Existing Account</button></th></tr>
            </table>
        </div>
    </div>
</body>
</html>

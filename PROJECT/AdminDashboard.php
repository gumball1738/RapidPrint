
<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="stylesheet" type="text/css" href="styles/style.css">  
    <title>Admin Dashboard</title>
</head>

<body>
    <div class="navigation">
        <ul>
            <li><a href="#dashboard"><img src="images/Logo.jpg" alt="Logo"></a></li>
            <li><a class="active" href="#dashboard">DASHBOARD</a></li>
            <li><a href="#news">PACKAGE LIST</a></li>
            <li><a href="#contact">MY ORDER</a></li>
            <li><a href="#about">LOGOUT</a></li>
            <div class="search-container">
                <form action="/action_page.php">
                    <input type="text" placeholder="Search.." name="search">
                    <button type="submit"><i class="fa fa-search"></i></button>
                </form>
            </div>
        </ul>
    </div>

    <div class="dashboard-container">
        <div class="buttons" id="buttons">
            <table>
                <tr><th><button onclick="document.location='VerificationApproval.php'">Verification Approval</button></th></tr>
				<tr><th><button onclick="window.location.href='Register.php'">Register User</button></th></tr>
                <tr><th><button onclick="window.location.href='SaleInfo.php'">Sale Information</button></th></tr>
                <tr><th><button onclick="window.location.href='ManageBranch.php'">Manage Branch</button></th></tr>
                <tr><th><button onclick="window.location.href='ManagePrinting.php'">Manage Printing Package</button></th></tr>
           
            </table>
        </div>
    </div>
</body>
</html>

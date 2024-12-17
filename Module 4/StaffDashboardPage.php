<html>
<head>
<style>
table{ 
text-align: left;
width: 100%;
}
h2{
text-align: left;	
}
</style>
<title>Staff Dashboard Page</title>
<link rel="stylesheet" type="text/css" href="styles/style.css"> 
</head>
<body>
<div class="navigation">
        <ul>
            <li>
                 <a href="MainPage4.php">
                    <img src="images/Logo.jpg" alt="Logo">
                </a>
            </li>
            <li><a href= "StaffDashboardPage.php"#dashboard">DASHBOARD</a></li>
            <li><a href="#news">PACKAGE LIST</a></li>
            <li><a href="StaffOrderPage.php">MY ORDER</a></li>
            <li><a href="logout.php">LOGOUT</a></li>
            <div class="search-container">
                <form action="/action_page.php">
                    <input type="text" placeholder="Search.." name="search">
                    <button>Search</button>
                </form>
            </div>
        </ul>
    </div>


<h2>Staff Dashboard</h2>
<h2>Staff Information</h2>
<table>
<tr><th>Staff ID: </th><th>Staff Data in Graph: </th></tr>
<tr><th>Staff Name: </th><th rowspan="3"><img src="images/Sales.jpg" alt="Monthly Sales" style = "height: 180px;width: 300px;"></th></tr>
<tr><th>Staff Telephone No.: </th></tr>
<tr><th>Staff Email: </th></tr>
<tr><th>Staff total printing sales: <th>Staff Bonus: </th><tr><th>
</table>
</body>
</html>
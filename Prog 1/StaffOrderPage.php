<html>
<head>
<style>
h2{
text-align: center;	
}
table{ 
text-align: left;
width: 800px;
width: 100%;
}
th{
text-align: center;	
}
td{
text-align: right;	
}
button {
            padding: 10px 20px;
            margin: 5px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
}

</style>
<title>Order List Page</title>
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
	
	<div><h2>Order</h2></div>
	
	<div>
	<table border="1">
	<tr><th colspan = "3">List of Order</th></tr>
	<tr><th>Order No 1</th><td><select id="status" name="status"><option value="complete" selected>Complete</option><option value="collected">Collected</option></select></th></td><th><a href="InvoiceGenerator.php">invoice</a></th></tr>
	<tr><th>Order No 2</th><td><select id="status" name="status"><option value="complete" selected>Complete</option><option value="collected">Collected</option></select></th></td><th><a href="InvoiceGenerator.php">invoice</a></th></tr>
	<tr><th>Order No 3</th><td><select id="status" name="status"><option value="complete" selected>Complete</option><option value="collected">Collected</option></select></th></td><th><a href="InvoiceGenerator.php">invoice</a></th></tr>
	</table>
	</div>
</body>
</html>
<html>
<head>
<style>
table{ 
text-align: center;
padding: 10px;
width: 100%;
}
th{ 
text-align: center;
padding: 100px;
width: 100%;
}
h2{
text-align: center;	
}
textarea{
text-align: center;	
width: 100%;
}
button {
            padding: 10px 20px;
            margin: 5px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
}
.update{
background-color: #f44336;
  color: white;
  padding: 14px 25px;
  text-align: center;
  text-decoration: none;
  display: inline-block;
}
.submit{
background-color: #8B0000;
  color: white;
  padding: 14px 25px;
  text-align: center;
  text-decoration: none;
  display: inline-block;
}
</style>
<title>Check Order Page</title>
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
<h2>Order</h2>

<div>
<table border="1">
<th>invoice with date and amount</th>
</div>
</table>

<h2><tr><a class="update" href="UpdateInvoicePage.php" >Update</a> <button type="submit" class="submit">Submit</button></tr></h2>

</body>
</html>
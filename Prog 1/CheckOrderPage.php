<html>
<head>
<style>
table{ 
text-align: left;
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
</style>
<title>Check Order Page</title>
<link rel="stylesheet" type="text/css" href="styles/style.css"> 
</head>
<body>
<div class="navigation">
        <ul>
            <li>
                <a href="#dashboard">
                    <img src="images/Logo.jpg" alt="Logo">
                </a>
            </li>
            <li><a class="active" href="#dashboard">DASHBOARD</a></li>
            <li><a href="#news">PACKAGE LIST</a></li>
            <li><a href="#contact">MY ORDER</a></li>
            <li><a href="#about">LOGIN/REGISTER</a></li>
            <div class="search-container">
                <form action="/action_page.php">
                    <input type="text" placeholder="Search.." name="search">
                    <button type="submit"><i class="fa fa-search"></i></button>
                </form>
            </div>
        </ul>
    </div>
<h2>Order</h2>

<h2><a href="invoice.php">Requested File</a></h2>
<textarea rows="4" name="comment">Customer comment</textarea>

<h2><tr><button type="reject" class="reject">Reject</button><button type="accept" class="accept">Accept</button></tr></h2>

</body>
</html>
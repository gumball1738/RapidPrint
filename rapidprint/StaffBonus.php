<?php
session_start();
if (!isset($_SESSION["session_name"])) {
    header("Location: LoginPage.php");
    exit();
}

$servername = "localhost"; 
$username = "root";        
$password = "";            
$dbname = "rapidprintdb"; 

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}


$query = "SELECT 
    staff.StaffID, 
    staff.username, 
    staff.monthlySale, 
    bonus.bonusReward 
FROM 
    staff 
LEFT JOIN 
    bonus 
ON 
    staff.StaffID = bonus.StaffID;
";


$result = mysqli_query($conn, $query);

?>

<html>
<head>
<style>
h2 {
    text-align: center;    
}
table {
    width: 100%;
    border-collapse: collapse;
    text-align: center;
}
th, td {
    border: 1px solid #ddd;
    padding: 8px;
}
th {
    background-color: #f2f2f2;
    text-align: center;
}
button {
    padding: 10px 20px;
    margin: 5px;
    border: none;
    border-radius: 5px;
    cursor: pointer;
    background-color: #4CAF50;
    color: white;
}
</style>
<title>Staff Bonus Reward</title>
</head>
<body>
<title>Staff Manage Order</title>
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
        <li><a href="StaffDashboardPage.php"#dashboard">DASHBOARD</a></li>
        <li><a href="StaffBonus.php">BONUS</a></li>
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
<h2>Staff Bonus Reward</h2>
<table>
    <tr>
        <th>Staff ID</th>
        <th>Staff Name</th>
        <th>Total Sales (RM)</th>
        <th>Bonus Reward (RM)</th>
    </tr>

<?php
if (mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
        $staffID = $row["StaffID"];
        $staffName = $row["username"];
        $totalSales = $row["monthlySale"];
        $bonusReward = 0;

      
        if ($totalSales > 450) {
            $bonusReward = 150;
        } elseif ($totalSales > 350) {
            $bonusReward = 120;
        } elseif ($totalSales > 280) {
            $bonusReward = 80;
        } elseif ($totalSales >= 200) {
            $bonusReward = 50;
        }
       
	   if ($row["bonusReward"] > 0) {
            $bonusReward = $row["bonusReward"];
        }

        echo "<tr>
                <td>$staffID</td>
                <td>$staffName</td>
                <td>$totalSales</td>
                <td>$bonusReward</td>
              </tr>";
    }
} else {
    echo "<tr><td colspan='5'>No records found</td></tr>";
}
?>

</table>
</body>
</html>

<?php
$conn->close();
?>

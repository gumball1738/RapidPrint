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

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} 

$query = "SELECT staff.StaffID, staff.username, staff.email, staff.password, staff.monthlySale
          FROM staff
          LEFT JOIN bonus ON staff.StaffID = bonus.staffID";

$result = mysqli_query($conn, $query);

$data = [];
$color_palette = ["#ffdb09", "#5edb57", "#aeb1ab", "#ef864b", "#a99a98", "#1d3c84", "#f1103d", "#ead271", "#56182f"];
$pStaffID = $pusername = $pemail = $ppassword = $pmonthlySale = null; 

if (mysqli_num_rows($result) > 0) {
    $index = 0; // To assign colors
    while ($row = mysqli_fetch_assoc($result)) {
        
        if ($index === 0) {
            $pStaffID = $row["StaffID"];
            $pusername = $row["username"];
            $pemail = $row["email"];
            $ppassword = $row["password"];
            $pmonthlySale = $row["monthlySale"];
        }

       
        $data[] = [
            "Month" => $row["username"], 
            "Sales" => (float)$row["monthlySale"],
            "Color" => $color_palette[$index % count($color_palette)] 
        ];
        $index++;
    }
}
?>

<html>
<head>
	<script src="https://cdn.jsdelivr.net/gh/davidshimjs/qrcodejs/qrcode.min.js"></script>
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script type="text/javascript">
        google.charts.load("current", {packages:['corechart']});
        google.charts.setOnLoadCallback(drawChart);
        
        function drawChart() {
            var data = google.visualization.arrayToDataTable([
                ["Month", "Monthly Sale", { role: "style" }],
                <?php
                foreach ($data as $entry) {
                    echo "['{$entry['Month']}', {$entry['Sales']}, '{$entry['Color']}'],";
                }
                ?>
            ]);

            var view = new google.visualization.DataView(data);
            view.setColumns([0, 1,
                            { calc: "stringify",
                              sourceColumn: 1,
                              type: "string",
                              role: "annotation" },
                            2]);

            var options = {
                title: "Monthly Sales by Staff",
                width: 600,
                height: 400,
                bar: {groupWidth: "95%"},
                legend: { position: "none" },
            };
            var chart = new google.visualization.ColumnChart(document.getElementById("columnchart_values"));
            chart.draw(view, options);
        }
    </script>
    <style>
        table { 
            text-align: left;
            width: 100%;
        }
        h2 {
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
        <li><a href="StaffDashboardPage.php"#dashboard">DASHBOARD</a></li>
        <li><a href="StaffBonus.php">BONUS</a></li>
        <li><a href="StaffOrderPage.php">MY ORDER</a></li>
        <li><a href="Logout.php">LOGOUT</a></li>
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
<tr><th>Staff ID: <?php echo $pStaffID ?></th><th>Staff Data in Graph:</th></tr>
<tr><th>Staff Name: <?php echo $pusername ?></th><th rowspan="5"><div id="columnchart_values" style="width: 250px; height: 200px;"></div></th></tr>
<tr><th>Staff Email: <?php echo $pemail ?></th></tr>
<tr><th>Staff Bonus: <?php echo $pmonthlySale ?></th></tr>
<tr><th><div class="qr-placeholder" id="qrcode"></div></th></tr>
</table>
<script>
    // Generate the QR code
    var qrcode = new QRCode(document.getElementById("qrcode"), {
      text:  "http://localhost/WEBE/rapidprint/StaffBonus.php?StaffID=<?php echo urlencode($pStaffID); ?>",
      width: 140, // Width of the QR Code
      height: 140, // Height of the QR Code
    });
  </script>
</body>
</html>

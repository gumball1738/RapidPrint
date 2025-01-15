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
    <title>RapidPrint Package List Page</title>
    <link rel="stylesheet" type="text/css" href="Styles/style.css">
    <style>
        /* General Body Styling */
        body {
            font-family: 'Arial', sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f9;
            color: #333;
        }

      
        /* Package Container */
        .mycontainer {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
            gap: 20px;
            padding: 20px;
        }

        .package {
            background-color: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            text-align: center;
            transition: all 0.3s ease;
        }

        .package:hover {
            transform: translateY(-10px);
            box-shadow: 0 10px 15px rgba(0, 0, 0, 0.2);
        }

        .package img {
            cursor: pointer;
            border-radius: 8px;
            transition: transform 0.3s ease;
        }

        .package img:hover {
            transform: scale(1.1);
        }

        .package h1 {
            font-size: 20px;
            margin-top: 10px;
            font-weight: bold;
        }

        .package p {
            font-size: 14px;
            color: #777;
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .navigation ul {
                flex-direction: column;
                align-items: center;
            }

            .mycontainer {
                grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
            }

            .filter-container {
                font-size: 14px;
            }
        }
    </style>
</head>
<body>

    <div class="navigation">
        <ul>
            <li>
                <a href="MainPage2.php">
                    <img src="images/Logo.jpg" alt="Logo" width="100" height="60">
                </a>
            </li>
            <li><a href="CustomerDashboard.php">DASHBOARD</a></li>
            <li><a href="PackageList.php">PACKAGE LIST</a></li>
            <li><a href="CustOrder.php">MY ORDER</a></li>
            <li><a href="LogOut.php">LOGOUT</a></li>
            <div class="search-container">
                <form action="/action_page.php">
                    <input type="text" placeholder="Search.." name="search">
                    <button type="submit">Search</button>
                </form>
            </div>
        </ul>
    </div>

    <div class="filter-container">
        <label for="filter">Filter by Paper Size:</label>
        <select id="filter">
            <option value="all">All</option>
            <option value="a3">A3</option>
            <option value="a4">A4</option>
            <option value="a5">A5</option>
        </select>
    </div>

    <div class="mycontainer">
        <div class="package" data-size="a3">
            <a href="PlaceOrderPage.php">
                <img src="images/a5icon.png" alt="Package 1" width="250" height="250">
            </a>
            <h1>Package 1</h1>
            <p>A3 SIZED PAPER</p>
        </div>
  
        <div class="package" data-size="a4">
            <a href="PlaceOrderA4.php">
                <img src="images/a4icon.png" alt="Package 2" width="250" height="250">
            </a>
            <h1>Package 2</h1>
            <p>A4 SIZED PAPER</p>
        </div>

        <div class="package" data-size="a5">
            <a href="PlaceOrderA5.php">
                <img src="images/a3icon.png" alt="Package 3" width="250" height="250">
            </a>
            <h1>Package 3</h1>
            <p>A5 SIZED PAPER</p>
        </div>
    </div>

    <script>
        const filter = document.getElementById('filter');
        const packages = document.querySelectorAll('.package');

        filter.addEventListener('change', function() {
            const selectedSize = this.value;

            packages.forEach(pkg => {
                if (selectedSize === 'all' || pkg.dataset.size === selectedSize) {
                    pkg.style.display = 'block';
                } else {
                    pkg.style.display = 'none';
                }
            });
        });
    </script>

</body>
</html>

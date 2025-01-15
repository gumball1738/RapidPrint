<?php
session_start();
if (!isset($_SESSION["session_name"])) {
    header("Location: LoginPage.php");
    exit();
}

$username = $_SESSION["session_name"];

$conn = new mysqli("localhost", "root", "", "rapidprintdb");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $action = $_POST['action'];
    if ($action == "add") {
        $name = $_POST['package_name'];
        $price = $_POST['price'];
        $description = $_POST['description'];
        $conn->query("INSERT INTO printing_packages (name, price, description) VALUES ('$name', '$price', '$description')");
    } elseif ($action == "edit" && isset($_POST['PackageID'])) {
        $id = $_POST['PackageID'];
        $name = $_POST['package_name'];
        $price = $_POST['price'];
        $description = $_POST['description'];
        $conn->query("UPDATE printing_packages SET name='$name', price='$price', description='$description' WHERE PackageID='$id'");
    } elseif ($action == "delete" && isset($_POST['PackageID'])) {
        $id = $_POST['PackageID'];
        $conn->query("DELETE FROM printing_packages WHERE PackageID='$id'");
    }
}

$result = $conn->query("SELECT * FROM printing_packages");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="styles/style.css">
    <title>Manage Printing Packages</title>
    <style>
    body {
        background-color: white;
        margin: 0;
        padding: 0;
    }
    .dashboard-container {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        padding: 20px;
        gap: 20px;
    }
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
    .content-container {
        width: 65%;
        padding: 20px;
        display: flex;
        flex-direction: column;
        gap: 20px;
        border: 1px solid #ccc;
        border-radius: 10px;
        background-color: #f9f9f9;
    }
    .content-container h2 {
        margin-top: 0;
    }
    .content-container table {
        border-collapse: collapse;
        width: 100%;
    }
    .content-container table th,
    .content-container table td {
        border: 1px solid #ddd;
        padding: 10px;
        text-align: center;
    }
    .content-container table th {
        background-color: #f2f2f2;
    }
    .form-container {
        margin-top: 20px;
        padding: 15px;
        border: 1px solid #ddd;
        border-radius: 5px;
    }
    .form-container input,
    .form-container textarea,
    .form-container button {
        display: block;
        margin-bottom: 10px;
        padding: 10px;
        width: 100%;
        border: 1px solid #ccc;
        border-radius: 5px;
    }
    .form-container button {
        background-color:#28a745;
        color: white;
        border: none;
        cursor: pointer;
    }
    .form-container button:hover {
        background-color: #218838;
    }
    .navigation ul {
        list-style: none;
        padding: 0;
        margin: 0;
        display: flex;
        align-items: center;
        gap: 20px;
    }
    .navigation ul li {
        display: inline;
    }
    .navigation ul li a {
        text-decoration: none;
        padding: 10px 15px;
        border-radius: 5px;
        transition: background-color 0.3s;
    }
    .navigation ul li a.active,
    .navigation ul li a:hover {
    }
    .search-container input {
        padding: 5px;
        border: 1px solid #ccc;
        border-radius: 5px;
    }
    .search-container button {
        padding: 5px;
        background-color: #007bff;
        color: white;
        border: none;
        border-radius: 5px;
        cursor: pointer;
    }
    .search-container button:hover {
        background-color: #0056b3;
    }
    </style>
    <script>
        function editPackage(package) {
            document.getElementById('formTitle').textContent = "Edit Package";
            document.getElementById('formAction').value = "edit";
            document.getElementById('packageId').value = package.PackageID;
            document.getElementById('packageName').value = package.name;
            document.getElementById('packagePrice').value = package.price;
            document.getElementById('packageDescription').value = package.description;
        }
    </script>
</head>
<body>
    <div class="navigation">
        <ul>
            <li><a href="#dashboard"><img src="images/Logo.jpg" alt="Logo"></a></li>
            <li><a class="active" href="AdminDashboard.php">DASHBOARD</a></li>
            <li><a href="OrderListPage.php">MY ORDER</a></li>
            <li><a href="Logout.php">LOGOUT</a></li>
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
                <tr><th><button onclick="window.location.href='ManageBranch.php'">Manage Branch</button></th></tr>
                <tr><th><button onclick="window.location.href='ManagePrinting.php'">Manage Printing Package</button></th></tr>
           
            </table>
        </div>

    <div class="content-container">
        <h2>Manage Printing Packages</h2>
        <!-- Package List Table -->
        <table>
            <thead>
                <tr>
                    <th>Package ID</th>
                    <th>Package Name</th>
                    <th>Price (RM)</th>
                    <th>Description</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php if ($result->num_rows > 0): ?>
                    <?php while ($row = $result->fetch_assoc()): ?>
                        <tr>
                            <td><?= htmlspecialchars($row['PackageID']) ?></td>
                            <td><?= htmlspecialchars($row['name']) ?></td>
                            <td><?= htmlspecialchars($row['price']) ?></td>
                            <td><?= htmlspecialchars($row['description']) ?></td>
                            <td>
                                <button onclick="editPackage(<?= htmlspecialchars(json_encode($row)) ?>)">Edit</button>
                                <form method="post" action="" style="display:inline;">
                                    <input type="hidden" name="action" value="delete">
                                    <input type="hidden" name="PackageID" value="<?= htmlspecialchars($row['PackageID']) ?>">
                                    <button type="submit">Delete</button>
                                </form>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="5">No packages found.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
        <!-- Add/Edit Form -->
        <div class="form-container">
            <h3 id="formTitle">Add New Package</h3>
            <form method="post" action="">
                <input type="hidden" name="action" id="formAction" value="add">
                <input type="hidden" name="PackageID" id="packageId">
                <label for="packageName">Package Name:</label>
                <input type="text" id="packageName" name="package_name" required>
                <label for="packagePrice">Price (RM):</label>
                <input type="number" id="packagePrice" name="price" step="0.01" required>
                <label for="packageDescription">Description:</label>
                <textarea id="packageDescription" name="description" required></textarea>
                <button type="submit">Save</button>
            </form>
        </div>
    </div>
</div>
</body>
</html>

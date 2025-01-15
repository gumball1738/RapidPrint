<?php
session_start();
if (!isset($_SESSION["session_name"])) {
    header("Location: LoginPage.php");
    exit();
}

$username = $_SESSION["session_name"];
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "rapidprintdb";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $action = $_POST['action'];

    if ($action == "add") {
        $name = $_POST['name'];
        $address = $_POST['address'];
        $contact = $_POST['contact'];
        $manager = $_POST['manager'];

        $stmt = $conn->prepare("INSERT INTO branch (name, address, contact, manager) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("ssss", $name, $address, $contact, $manager);
        $stmt->execute();
        $stmt->close();
    } elseif ($action == "edit") {
        $id = $_POST['BranchID'];
        $name = $_POST['name'];
        $address = $_POST['address'];
        $contact = $_POST['contact'];
        $manager = $_POST['manager'];

        $stmt = $conn->prepare("UPDATE branch SET name = ?, address = ?, contact = ?, manager = ? WHERE BranchID = ?");
        $stmt->bind_param("ssssi", $name, $address, $contact, $manager, $id);
        $stmt->execute();
        $stmt->close();
    } elseif ($action == "delete") {
        $id = $_POST['BranchID'];

        $stmt = $conn->prepare("DELETE FROM branch WHERE BranchID = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $stmt->close();
    }

    header("Location: " . $_SERVER["PHP_SELF"]);
    exit();
}

$result = $conn->query("SELECT * FROM branch");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="styles/style.css">
    <title>Manage Branches</title>
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
        background-color: #28a745;
        color: white;
        border: none;
        cursor: pointer;
        transition: background-color 0.3s;
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
        color: white;
        background-color: #007bff;
        border: none;
        border-radius: 5px;
        cursor: pointer;
        transition: background-color 0.3s;
    }
    .search-container button:hover {
        background-color: #0056b3;
    }
</style>


</head>
<body>
    <div class="navigation">
        <ul>
            <li>
                <a href="MainPage3.php">
                    <img src="images/Logo.jpg" alt="Logo">
                </a>
            </li>
            <li><a href= "AdminDashboard.php"#dashboard">DASHBOARD</a></li>
            <li><a href="OrderListPage.php">MY ORDER</a></li>
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
                <tr><th><button onclick="document.location='VerificationApproval.php'">Verification Approval</button></th></tr>
				<tr><th><button onclick="window.location.href='Register.php'">Register User</button></th></tr>
                <tr><th><button onclick="window.location.href='ManageBranch.php'">Manage Branch</button></th></tr>
                <tr><th><button onclick="window.location.href='ManagePrinting.php'">Manage Printing Package</button></th></tr>
           
            </table>
        </div>

    <div class="content-container">
        <h2>Manage Koperasi Branch Information</h2>

<div class="Branch">
        <table id="Branch">
            <thead>
                <tr>
                    <th>Branch ID</th>
                    <th>Branch Name</th>
                    <th>Branch Address</th>
                    <th>Manager</th>
                    <th>Contact</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php if ($result->num_rows > 0): ?>
                    <?php while ($row = $result->fetch_assoc()): ?>
                        <tr>
                            <td><?= htmlspecialchars($row['BranchID']) ?></td>
                            <td><?= htmlspecialchars($row['name']) ?></td>
                            <td><?= htmlspecialchars($row['address']) ?></td>
                            <td><?= htmlspecialchars($row['manager']) ?></td>
                            <td><?= htmlspecialchars($row['contact']) ?></td>
                            <td>
                                <button onclick="editBranch(<?= htmlspecialchars(json_encode($row)) ?>)">Edit</button>
                                <form method="post" action="" style="display:inline;">
                                    <input type="hidden" name="action" value="delete">
                                    <input type="hidden" name="BranchID" value="<?= htmlspecialchars($row['BranchID']) ?>">
                                    <button type="submit">Delete</button>
                                </form>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="6">No branches found.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>

        <div class="form-container">
            <h3 id="formTitle">Add New Branch</h3>
            <form method="post" action="">
                <input type="hidden" name="action" id="formAction" value="add">
                <input type="hidden" name="BranchID" id="branchId">
                <label for="branchName">Branch Name:</label>
                <input type="text" id="branchName" name="name" required>
                <label for="branchAddress">Branch Address:</label>
                <textarea id="branchAddress" name="address" required></textarea>
                <label for="branchManager">Manager Name:</label>
                <input type="text" id="branchManager" name="manager" required>
                <label for="branchContact">Contact Number:</label>
                <input type="text" id="branchContact" name="contact" required>
                <button type="submit">Save</button>
            </form>
        </div>
    </div>
</div>

    <script>
        // Function to populate the form for editing
        function editBranch(branch) {
            document.getElementById("formTitle").textContent = "Edit Branch";
            document.getElementById("formAction").value = "edit"; // Set form action to 'edit'
            document.getElementById("branchId").value = branch.BranchID; // Populate hidden input for BranchID
            document.getElementById("branchName").value = branch.name; // Populate name input
            document.getElementById("branchAddress").value = branch.address; // Populate address input
            document.getElementById("branchManager").value = branch.manager;
            document.getElementById("branchContact").value = branch.contact; // Populate contact input
        }
    </script>
</body>
</html>
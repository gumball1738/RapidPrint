<?php
session_start();
if (!isset($_SESSION["session_name"])) {
    header("Location: LoginPage.php");
    exit();
}

$servername = "localhost";
$username = "root";
$password = "";
$database = "rapidprintdb";

// Create connection
$connection = new mysqli($servername, $username, $password, $database);

// Initialize variables
$CustomerID = "";
$size = "";
$quantity = "";
$color = "";
$pagePerSheet = "";
$document = "";
$request = "";
$price = 0.50; // Constant price
$totalPrice = "";
$orderStatus = "";

$errorMessage = "";
$successMessage = "";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get and sanitize inputs
    $CustomerID = isset($_POST["customerId"]) ? trim($_POST["customerId"]) : "";
    $size = isset($_POST["size"]) ? trim($_POST["size"]) : "";
    $quantity = isset($_POST["quantity"]) ? (int)$_POST["quantity"] : 0;
    $color = isset($_POST["color"]) ? trim($_POST["color"]) : "";
    $pagePerSheet = isset($_POST["pagePerSheet"]) ? (int)$_POST["pagePerSheet"] : 0;
    $request = isset($_POST["request"]) ? trim($_POST["request"]) : ""; // Sanitize request
    $orderStatus = isset($_POST["orderStatus"]) ? trim($_POST["orderStatus"]) : "To Pay";
    $totalPrice = $price * $quantity;

    // Debug the value of request
    error_log("Request value: " . $request);

    // Handle file upload
    if (isset($_FILES["document"]) && $_FILES["document"]["error"] == 0) {
        $document = $_FILES["document"]["name"];
        $target_dir = "uploads/";
        $target_file = $target_dir . basename($document);

        if (!is_dir($target_dir)) {
            mkdir($target_dir, 0777, true); // Create directory if it doesn't exist
        }

        if (!move_uploaded_file($_FILES["document"]["tmp_name"], $target_file)) {
            $errorMessage = "Failed to upload document.";
        }
    } else {
        $errorMessage = "No file uploaded or upload error.";
    }

    // Proceed if no errors
    if (empty($errorMessage)) {
        // Use prepared statements to prevent SQL injection
        $stmt = $connection->prepare(
            "INSERT INTO orders (customerId, size, quantity, color, pagePerSheet, document, request, price, totalPrice, orderStatus) 
             VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)"
        );
        $stmt->bind_param(
            "ssissssdss",
            $CustomerID,
            $size,
            $quantity,
            $color,
            $pagePerSheet,
            $document,
            $request,
            $price,
            $totalPrice,
            $orderStatus
        );

        if ($stmt->execute()) {
            $successMessage = "Order added successfully.";
            header("Location: /WEBE/rapidprint/CustOrder.php");
            exit;
        } else {
            $errorMessage = "Database error: " . $stmt->error;
        }

        $stmt->close();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Place New Order</title>
    <link rel="stylesheet" href="Styles/style.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <style>
        /* Flexbox Layout for Image and Form */
        .order-container {
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 20px;
            flex-wrap: wrap; /* Allows wrapping on small screens */
        }

        .order-container img {
            max-width: 100%;
            height: auto;
            border-radius: 10px;
        }

        .order-form {
            width: 50%; /* Set the form width */
            min-width: 400px;
        }

        /* Ensure the form adapts to smaller screens */
        @media (max-width: 768px) {
            .order-container {
                flex-direction: column;
                align-items: center;
            }

            .order-form {
                width: 100%;
            }
        }
    </style>
</head>
<body>
  <!-- Navigation Bar -->
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
	
    <div class="container my-5">
        <h2>Place Order</h2>

        <!-- Display error message -->
        <?php if (!empty($errorMessage)): ?>
            <div class="alert alert-warning alert-dismissible fade show" role="alert">
                <strong><?php echo $errorMessage; ?></strong>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php endif; ?>

        <!-- Display success message -->
        <?php if (!empty($successMessage)): ?>
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <strong><?php echo $successMessage; ?></strong>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php endif; ?>

        <!-- Order container with image on the left -->
        <div class="order-container">
            <div>
                <img src="images/a5icon.png" alt="A5 Icon" />
            </div>

            <!-- Order form -->
            <div class="order-form">
                <form method="post" enctype="multipart/form-data">
                    <div class="mb-3">
                        <label>Customer ID</label>
                        <input type="text" class="form-control" name="customerId" value="<?php echo htmlspecialchars($CustomerID); ?>" required>
                    </div>

                    <div class="mb-3">
                        <label>Paper Size</label>
                        <input type="text" class="form-control" name="size" value="A3" readonly>
                    </div>

                    <div class="mb-3">
                        <label>Quantity</label>
                        <input type="number" class="form-control" name="quantity" value="<?php echo htmlspecialchars($quantity); ?>" min="1" required>
                    </div>

                    <div class="mb-3">
                        <label>Color</label><br>
                        <input type="radio" name="color" value="color" <?php echo $color == 'color' ? 'checked' : ''; ?>> Color
                        <input type="radio" name="color" value="grayscale" <?php echo $color == 'grayscale' ? 'checked' : ''; ?>> Grayscale
                    </div>

                    <div class="mb-3">
                        <label>Pages Per Sheet</label>
                        <input type="number" class="form-control" name="pagePerSheet" value="<?php echo htmlspecialchars($pagePerSheet); ?>" min="1" required>
                    </div>

                    <div class="mb-3">
                        <label>Document</label>
                        <input type="file" class="form-control" name="document" accept=".pdf" required>
                    </div>

                    <div class="mb-3">
                        <label>Additional Request</label>
                        <textarea class="form-control" name="request"><?php echo htmlspecialchars($request); ?></textarea>
                    </div>

                    <div class="mb-3">
                        <label>Total Price</label>
                        <input type="text" class="form-control" name="totalPrice" value="<?php echo htmlspecialchars($totalPrice); ?>" readonly>
                    </div>

                    <div class="mb-3">
                        <label>Order Status</label>
                        <input type="text" class="form-control" name="orderStatus" value="To Pay" readonly>
                    </div>

                    <button type="submit" class="btn btn-primary">Submit</button>
                    <a href="/rapidprint/CustOrder.php" class="btn btn-outline-primary">Cancel</a>
                </form>
            </div>
        </div>
    </div>
</body>
</html>

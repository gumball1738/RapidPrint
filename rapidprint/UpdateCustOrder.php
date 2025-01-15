<?php
$servername = "localhost";
$username = "root";
$password = "";
$database = "rapidprintdb";

// Create connection
$connection = new mysqli($servername, $username, $password, $database);

$OrderID = "";
$CustomerID = "";
$size = "";
$quantity = "";
$color = "";
$pagePerSheet = "";
$document = "";
$request = "";
$price = "0.20"; // constant price
$totalPrice = "";
$orderStatus = "";

$errorMessage = "";
$successMessage = "";

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    if (!isset($_GET["OrderID"])) {
        header("location: /WEBE/rapidprint/CustOrder.php");
        exit;
    }

    $OrderID = $_GET["OrderID"];

    // Use prepared statement to safely retrieve the order by OrderID
    $sql = "SELECT * FROM orders WHERE OrderID = ?";
    $stmt = $connection->prepare($sql);
    $stmt->bind_param("i", $OrderID); // "i" means integer
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();

    if (!$row) {
        header("location: /WEBE/rapidprint/CustOrder.php");
        exit;
    }

    $CustomerID = $row["CustomerID"];
    $size = $row["size"];
    $quantity = $row["quantity"];
    $color = $row["color"];
    $pagePerSheet = $row["pagePerSheet"];
    $document = $row["document"];
    $request = $row["request"];
    $totalPrice = $row["totalPrice"];
    $orderStatus = $row["orderStatus"];
} else {
    $OrderID = $_POST["OrderID"];
    $CustomerID = $_POST["CustomerID"];
    $size = $_POST["size"];
    $quantity = $_POST["quantity"];
    $color = $_POST["color"];
    $pagePerSheet = $_POST["pagePerSheet"];
    $request = $_POST["request"];
    $orderStatus = $_POST["orderStatus"];
    $totalPrice = $price * $quantity; // Total price based on price and quantity

    if (!empty($_FILES["document"]["name"])) {
        $document = $_FILES["document"]["name"];
        $target_dir = "uploads/";
        $target_file = $target_dir . basename($document);

        if (!move_uploaded_file($_FILES["document"]["tmp_name"], $target_file)) {
            $errorMessage = "Failed to upload document.";
        }
    }

    do {
        if (
            empty($CustomerID) || empty($size) || empty($quantity) || empty($color) || 
            empty($pagePerSheet) || empty($request) || empty($orderStatus)
        ) {
            $errorMessage = "All fields are required.";
            break;
        }

        // Prepared statement for updating the order
        $sql = "UPDATE orders SET 
                    CustomerID = ?, 
                    size = ?, 
                    quantity = ?, 
                    color = ?, 
                    pagePerSheet = ?, 
                    document = ?, 
                    request = ?, 
                    totalPrice = ?, 
                    orderStatus = ? 
                WHERE OrderID = ?";

        $stmt = $connection->prepare($sql);
        
        // Here, we need to bind parameters with the correct types
        $stmt->bind_param(
            "ssissssdsd",  // Correct types for the parameters
            $CustomerID,   // string
            $size,         // string
            $quantity,     // integer
            $color,        // string
            $pagePerSheet, // integer
            $document,     // string
            $request,      // string
            $totalPrice,   // double
            $orderStatus,  // string
            $OrderID       // integer
        );

        $stmt->execute();

        if ($stmt->affected_rows == 0) {
            $errorMessage = "Failed to update order.";
            break;
        }

        // Display success message without redirect
        $successMessage = "Order updated successfully.";
    } while (false);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Order</title>
    <link rel="stylesheet" type="text/css" href="styles/style.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
</head>
<body>
    <div class="navigation">
        <ul>
            <li>
                <a href="MainPage2.php">
                    <img src="images/Logo.jpg" alt="Logo">
                </a>
            </li>
            <li><a href="CustomerDashboard.php"#dashboard">DASHBOARD</a></li>
            <li><a href="PackageList.php">PACKAGE LIST</a></li>
            <li><a href="CustOrder.php">MY ORDER</a></li>
            <li><a href="LogOut.php">LOGOUT</a></li>
            <div class="search-container">
                <form action="/action_page.php">
                    <input type="text" placeholder="Search.." name="search">
                    <button>Search</button>
                </form>
            </div>
        </ul>
    </div>
    <div class="container my-5">
        <h2>Update Order</h2>

        <?php if (!empty($errorMessage)): ?>
            <div class="alert alert-warning alert-dismissible fade show" role="alert">
                <strong><?php echo $errorMessage; ?></strong>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php endif; ?>

        <?php if (!empty($successMessage)): ?>
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <strong><?php echo $successMessage; ?></strong>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php endif; ?>

        <form method="post" enctype="multipart/form-data">
            <input type="hidden" name="OrderID" value="<?php echo $OrderID; ?>">

            <div class="mb-3">
                <label>Customer ID</label>
                <input type="text" class="form-control" name="CustomerID" value="<?php echo $CustomerID; ?>" required>
            </div>

            <div class="mb-3">
                <label>Paper Size</label>
                <select class="form-control" name="size" required>
                    <option value="A3" <?php echo $size == 'A3' ? 'selected' : ''; ?>>A3</option>
                    <option value="A4" <?php echo $size == 'A4' ? 'selected' : ''; ?>>A4</option>
                    <option value="A5" <?php echo $size == 'A5' ? 'selected' : ''; ?>>A5</option>
                </select>
            </div>

            <div class="mb-3">
                <label>Quantity</label>
                <input type="number" class="form-control" name="quantity" value="<?php echo $quantity; ?>" min="1" required>
            </div>

            <div class="mb-3">
                <label>Color</label><br>
                <input type="radio" name="color" value="color" <?php echo $color == 'color' ? 'checked' : ''; ?>> Color
                <input type="radio" name="color" value="grayscale" <?php echo $color == 'grayscale' ? 'checked' : ''; ?>> Grayscale
            </div>

            <div class="mb-3">
                <label>Pages Per Sheet</label>
                <input type="number" class="form-control" name="pagePerSheet" value="<?php echo $pagePerSheet; ?>" min="1" required>
            </div>

            <div class="mb-3">
                <label>Document</label>
                <input type="file" class="form-control" name="document" accept=".pdf">
                <small>Current File: <?php echo $document; ?></small>
            </div>

            <div class="mb-3">
                <label>Additional Request</label>
                <textarea class="form-control" name="request"><?php echo htmlspecialchars($request); ?></textarea>
            </div>

            <div class="mb-3">
                <label>Price (per unit)</label>
                <input type="text" class="form-control" value="0.20" readonly>
            </div>

            <div class="mb-3">
                <label>Total Price</label>
                <input type="text" class="form-control" value="<?php echo $totalPrice; ?>" readonly>
            </div>

            <div class="mb-3">
                <label>Order Status</label>
                <input type="text" class="form-control" name="orderStatus" value="To Pay" readonly>
            </div>

            <button type="submit" class="btn btn-primary">Update</button>
            <a href="CustOrder.php" class="btn btn-outline-primary">Cancel</a>
        </form>
    </div>
</body>
</html>

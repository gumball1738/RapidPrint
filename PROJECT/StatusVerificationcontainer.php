<?php
// Start the session
session_start();

// Check if the user is logged in
if (!isset($_SESSION["session_name"])) {
    // Redirect to LoginPage.php if no session is found
    header("Location: LoginPage.php");
    exit();
}

// Retrieve the username from the session
$username = $_SESSION["session_name"];

// Database credentials
$servername = "localhost";
$dbUsername = "root"; // Your database username
$password = ""; // Your database password
$dbname = "rapidprintdb"; // Your database name

// Create a connection to the database
$conn = new mysqli($servername, $dbUsername, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if a file is uploaded
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_FILES['verificationFile'])) {
    // Get the uploaded file
    $file = $_FILES['verificationFile'];

    // Check for any upload errors
    if ($file['error'] !== UPLOAD_ERR_OK) {
        echo "<script>
            alert('Error uploading file.');
            window.location.href = 'StatusVerificationcontainer.php';
        </script>";
        exit;
    }

    // Validate file type (only PDF, JPG, PNG)
    $allowedTypes = ['application/pdf', 'image/jpeg', 'image/png'];
    if (!in_array($file['type'], $allowedTypes)) {
        echo "<script>
            alert('Please upload a valid PDF, JPG, or PNG file.');
            window.location.href = 'StatusVerificationcontainer.php';
        </script>";
        exit;
    }

    // Validate file size (limit to 10MB)
    $maxFileSize = 10 * 1024 * 1024; // 10MB
    if ($file['size'] > $maxFileSize) {
        echo "<script>
            alert('File size exceeds the limit of 10MB.');
            window.location.href = 'StatusVerificationcontainer.php';
        </script>";
        exit;
    }

    // Generate a unique filename to avoid conflicts
    $fileName = uniqid('file_', true) . '.' . pathinfo($file['name'], PATHINFO_EXTENSION);

    // Define the upload directory (ensure this directory exists and is writable)
    $uploadDir = 'uploads/'; // Directory to store uploaded files
    if (!is_dir($uploadDir)) {
        mkdir($uploadDir, 0777, true); // Create directory if it doesn't exist
    }
    $uploadPath = $uploadDir . $fileName;

    // Move the uploaded file to the target directory
    if (!move_uploaded_file($file['tmp_name'], $uploadPath)) {
        echo "<script>
            alert('Error saving the file.');
            window.location.href = 'StatusVerificationcontainer.php';
        </script>";
        exit;
    }

    // Check if the customer already has a file uploaded
    $sqlCheck = "SELECT file FROM customer WHERE username = ?";
    $stmtCheck = $conn->prepare($sqlCheck);
    $stmtCheck->bind_param("s", $username);
    $stmtCheck->execute();
    $resultCheck = $stmtCheck->get_result();

    if ($resultCheck->num_rows > 0) {
        $row = $resultCheck->fetch_assoc();
        if (!empty($row['file'])) {
            echo "<script>
                alert('A file has already been uploaded for this user.');
                window.location.href = 'StatusVerificationcontainer.php';
            </script>";
            exit;
        }
    }

    // Insert the file info into the database (save the file path, not the file itself)
    $sql = "UPDATE customer SET file = ? WHERE username = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss", $uploadPath, $username); // Store the file path in the database

    if ($stmt->execute()) {
        echo "<script>
            alert('File uploaded and saved successfully!');
            window.location.href = 'CustomerDashboard.php';
        </script>";
    } else {
        echo "<script>
            alert('Error saving file information to the database.');
            window.location.href = 'StatusVerificationcontainer.php';
        </script>";
    }

    $stmt->close();
}

$conn->close();
?>



<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="stylesheet" type="text/css" href="styles/style.css">
    <title>Status Verification</title>
    <style>
  /* Flex container for the dashboard */
    .dashboard-container {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        padding: 20px;
        flex-wrap: nowrap; /* Ensures no wrapping of items */
    }

    /* Styling for the buttons section */
    .buttons {
        width: 30%; /* Adjust the width as needed, but it shouldn't exceed 30% */
    }

    /* Styling for the content section */
    .content-container {
        width: 65%; /* Adjust to fit within the remaining space */
        padding: 20px;
        display: flex;
        flex-direction: column;
        gap: 20px; /* Add gap between form elements */
        border: 1px solid #ccc;
        border-radius: 10px;
        background-color: #f9f9f9;
        margin-top: 10px; /* Add space above the button */
        margin-bottom: 10px; /* Add space below the button */
    }

    /* Styling for the form labels and inputs */
    .content-container label {
        font-size: 14px;
        font-weight: bold;
    }

    .content-container input[type="text"] {
        width: 100%; /* Full width input fields */
        padding: 10px;
        margin-bottom: 10px; /* Add space after each input */
        border: 1px solid #ccc;
        border-radius: 5px;
        font-size: 14px;
    }

    .content-container button {
        padding: 10px 20px;
		width: auto;
        font-size: 16px;
        background-color: #007BFF;
        color: white;
        border: none;
        border-radius: 5px;
        cursor: pointer;
    }

    .content-container button:hover {
        background-color: #0056b3;
    }

        /* Drop Zone Styling */
        #verificationDropZone {
            border: 2px dashed #ddd;
            padding: 20px;
            text-align: center;
            cursor: pointer;
            background-color: #fff;
        }

        #verificationDropZone:hover {
            border-color: #000;
            background-color: #f9f9f9;
        }

        #verificationFileName {
            margin-top: 10px;
            color: #555;
        }
    </style>
</head>
<body>
    <div class="navigation">
        <ul>
           <li><a href="#dashboard"><img src="images/Logo.jpg" alt="Logo"></a></li>
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
    <div class="dashboard-container">
        <div class="buttons" id="buttons">
            <table>
                <tr><th><button onclick="document.location='CustomerPointSection.php'">Customer Detail</button></th></tr>
                <tr><th><button onclick="window.location.href='StatusVerificationcontainer.php'">Status Verification</button></th></tr>
                <tr><th><button onclick="window.location.href='ApplyMembershipcontainer.php'">Apply Membership</button></th></tr>
                <tr><th><button onclick="window.location.href='MembershipBalanceSection.php'">Membership Balance</button></th></tr>
                <tr><th><button onclick="window.location.href='UpdateProfilecontainer.php'">Update Profile</button></th></tr>
                <tr><th><button onclick="window.location.href='Deletecontainer.php'">Delete Existing Account</button></th></tr>
            </table>
        </div>

        <div class="content-container">
            <h2>Status Verification</h2>
            <!-- The file upload form -->
            <form id="fileUploadForm" action="" method="POST" enctype="multipart/form-data">
                <div id="verificationDropZone">
                    <p>Drag & Drop Your Student Card Here or Click to Upload</p>
                    <input type="file" id="verificationFile" name="verificationFile" accept=".pdf,.jpg,.png" style="display: none;">
                </div>
                <p id="verificationFileName"></p>
                <button type="submit" id="verifyButton">Submit</button>
            </form>
        </div>
    </div>

    <script>
        // JavaScript for Dropzone functionality
        document.addEventListener('DOMContentLoaded', function () {
            const dropZone = document.getElementById('verificationDropZone');
            const fileInput = document.getElementById('verificationFile');
            const fileNameDisplay = document.getElementById('verificationFileName');

            // Handle drag and drop events
            dropZone.addEventListener('dragover', function (e) {
                e.preventDefault();
                e.stopPropagation();
                dropZone.classList.add('drag-over');
            });

            dropZone.addEventListener('dragleave', function (e) {
                e.preventDefault();
                e.stopPropagation();
                dropZone.classList.remove('drag-over');
            });

            dropZone.addEventListener('drop', function (e) {
                e.preventDefault();
                e.stopPropagation();
                dropZone.classList.remove('drag-over');

                // Get the dropped files
                const files = e.dataTransfer.files;

                if (files.length > 0) {
                    fileInput.files = files; // Assign files to the input element
                    fileNameDisplay.textContent = `Selected File: ${files[0].name}`;
                }
            });

            // Handle click event to trigger file input
            dropZone.addEventListener('click', function () {
                fileInput.click();
            });

            // Handle file selection via the input element
            fileInput.addEventListener('change', function () {
                if (fileInput.files.length > 0) {
                    fileNameDisplay.textContent = `Selected File: ${fileInput.files[0].name}`;
                }
            });
        });
    </script>
</body>
</html>
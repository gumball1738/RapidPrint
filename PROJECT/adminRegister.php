<?php
// Start session
session_start();

// Check if the user is logged in
if (!isset($_SESSION["session_name"])) {
    // Redirect to LoginPage.php if no session is found
    header("Location: LoginPage.php");
    exit();
}

// Database connection
$servername = "localhost";
$dbUsername = "root";
$password = "";
$dbname = "rapidprintdb";

// Create connection
$conn = new mysqli($servername, $dbUsername, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch all CustomerID and file_path from the customer table
$sql = "SELECT customer_id, file_path FROM customer";
$result = $conn->query($sql);

// Check if there are results
if ($result->num_rows > 0) {
    // Fetch all the rows
    $customers = $result->fetch_all(MYSQLI_ASSOC);
} else {
    $customers = [];
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <link rel="stylesheet" type="text/css" href="styles/styles2.css">  
    <title>Admin Dashboard</title>
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

    <!-- Dashboard container with buttons and sections -->
    <div class="dashboard-container">
        
        <!-- Button Section -->
        <div class="buttons" id="buttons">
            <table>
                <tr><th><button id="verification-request">Verification Request</button></th></tr>
                <tr><th><button id="sale-information">Sale Information</button></th></tr>
                <tr><th><button id="manage-branch">Manage Branch</button></th></tr>
                <tr><th><button id="manage-printing-package">Manage Printing Package</button></th></tr>
            </table>
        </div>

        <!-- Verification Request container -->
        <div class="verification-section" id="verification-request-section" style="display: none;"> 
            <h2>Approve Verification</h2>
        
            <table style="width:100%">
                <tr>
                    <td>Customer ID</td>
                    <td>Attachment of copy of student card</td>
                    <td>Action</td>
                </tr>

                <?php if (!empty($customers)): ?>
                    <?php foreach ($customers as $customer): ?>
                        <tr>
                            <!-- Display the CustomerID dynamically -->
                            <td><?php echo $customer['customer_id']; ?></td>
                            <!-- Dynamic link for viewing the uploaded document -->
                            <td>
                                <a href="<?php echo $customer['file_path']; ?>" target="_blank" style="color: blue; text-decoration: underline;">
                                    View Here
                                </a>
                            </td>
                            <td><button>Approve</button>  <button>Reject</button></td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="3">No customer data available.</td>
                    </tr>
                <?php endif; ?>
            </table>
        
        </div>
        
    </div>

    <script>
        // Get the buttons and sections
        const verificationRequestButton = document.getElementById('verification-request');
        const verificationRequestSection = document.getElementById('verification-request-section');

        // Function to show a section and hide all others
        function toggleSection(button, sectionToShow, sectionsToHide) {
            button.addEventListener('click', function() {
                // Check if the section to be shown is currently hidden
                if (sectionToShow.style.display === 'none' || sectionToShow.style.display === '') {
                    sectionToShow.style.display = 'block'; // Show the section
                    // Hide all other sections
                    sectionsToHide.forEach(section => {
                        if (section) section.style.display = 'none';
                    });
                } else {
                    sectionToShow.style.display = 'none'; // Hide the section if it's already visible
                }
            });
        }

        // Attach event listeners for the buttons
        toggleSection(verificationRequestButton, verificationRequestSection, []); // No other sections to hide here
    </script>

</body>
</html>

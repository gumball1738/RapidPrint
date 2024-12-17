<?php
// Start the session
session_start();

// Check if the user is logged in
if (!isset($_SESSION["session_name"])) {
    // Redirect to LoginForm.php if no session is found
    header("Location: LoginPage.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="stylesheet" type="text/css" href="styles/style.css">  
    <title>Customer Dashboard</title>
    <style>
      	/*  ----      ----- ------*/

		  /* Flex container for buttons and sections */
        .dashboard-container {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            padding: 20px;
        }

        /* Button section */
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

        /* Section styles (common for all sections) */
        .verification-section, 
        .membership-balance-section, 
        .point-section {
            width: 65%;
            display: none; /* Hidden by default */
            padding: 20px;
            border: 1px solid #ccc;
            border-radius: 10px;
            background-color: #f9f9f9;
        }

        .verification-section h2, 
        .membership-balance-section h2, 
        .point-section h2 {
            margin-bottom: 10px;
        }

        .verification-section input[type="text"], 
        .point-section input[type="text"] {
            width: 40%;
            padding: 10px;
            margin-bottom: 10px;
        }

        .verification-section button, 
        .membership-balance-section button, 
        .point-section button {
            padding: 10px 20px;
            font-size: 16px;
            cursor: pointer;
        }

       .membership-layout {
    display: flex;
    gap: 20px; /* Space between QR code and details */
    flex-wrap: wrap; /* Ensures responsiveness */
}

        .membership-layout > div {
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            background-color: #f0f0f0;
        }
.membership-balance-section {
    border: 1px solid #ccc;
    padding: 20px;
    width: 900px;
    margin: auto;
    text-align: center;
}

.qr-code {
    text-align: center;
    flex: 1;
}

.qr-placeholder {
    width: 150px;
    height: 150px;
    border: 2px dashed #ccc;
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 10px auto;
    font-size: 14px;
    color: #666;
}


.details {
    display: flex;
    justify-content: space-between;
    margin-top: 20px;
}
/* Membership Details */
.membership-details {
    flex: 2;
    display: flex;
    flex-direction: column;
    gap: 10px; /* Space between rows */
}

/* Align items in rows */
.detail-item {
    display: flex;
    justify-content: space-between;
    align-items: center;
    gap: 20px; /* Space between text and button */
}

/* Edit Section (Button Centered) */
.edit-section {
    text-align: center;
    margin-top: 20px;
}
button {
    padding: 10px 15px; /* Space inside the button */
    width: 250px; /* Fixed width for all buttons */
    text-align: center; /* Ensures text is centered */
}


button:hover {
    background-color:	#8B0000;
}

.membership-details p {
    margin: 0;
    font-size: 14px;
    color: #333;
}


    </style>
</head>
<body>

    <div class="navigation">
        <ul>
            <li>
                <a href="#dashboard">
                    <img src="images/Logo.jpg" alt="Logo">
                </a>
            </li>
            <li><a href= "userRegister.php"#dashboard">DASHBOARD</a></li>
            <li><a href="#news">PACKAGE LIST</a></li>
            <li><a href="OrderListPage.php">MY ORDER</a></li>
            <li><a href="logout.php">LOGOUT</a></li>
            <div class="search-container">
                <form action="/action_page.php">
                    <input type="text" placeholder="Search.." name="search">
                    <button>Search</button>
                </form>
            </div>
        </ul>
    </div>

    <!-- Dashboard container with buttons and sections -->
    <div class="dashboard-container">
        
        <!-- Button Section -->
        <div class="buttons" id="buttons">
            <table>
                <tr><th><button id="customer-detail">Customer Detail</button></th></tr>
                <tr><th><button id="status-verification">Status Verification</button></th></tr>
                <tr><th><button id="apply-membership">Apply Membership</button></th></tr>
                <tr><th><button id="membership-balance">Membership Balance</button></th></tr>
                <tr><th><button id="update-profile">Update Profile</button></th></tr>
                <tr><th><button id="create-account">Create New Account</button></th></tr>
                <tr><th><button id="delete-account">Delete Existing Account</button></th></tr>
            </table>
        </div>

        <!-- Status Verification container -->
        <div class="verification-section" id="verification-section">
            <h2>Status Verification</h2>
            <input type="text" placeholder="Drop the copy of student card">
            <button>Browse File</button>
			<div><button>Verify</button></div>
        </div>
        
        <!-- Membership Balance Section -->
      <div class="membership-balance-section" id="membership-balance-section">
    <h2>Membership Balance</h2>
    <div class="membership-layout">
        <!-- QR Code Section -->
        <div class="qr-code">
            <div class="qr-placeholder">QR Code Placeholder</div>
            <p><em>(Scan to check the total points)</em></p>
        </div>

        <!-- Membership Details -->
        <div class="membership-details">
            <div class="detail-item">
                <p>Membership Points Earned: <strong>00.00</strong></p>
                <button>Membership Total Accumulated Points</button>
            </div>
            <div class="detail-item">
                <p>Customer Membership Information</p>
				<button>Edit Information</button>
            </div>
            <div class="detail-item">
                <p>Card Balance (RM): <strong>00.00</strong></p>
                <button>Top-Up</button>
            </div>
        </div>
    </div>
</div>


        <!-- Customer Point Section -->
    <div class="point-section" id="point-section">
    <h2>Customer Membership</h2>
    <div class="point-item">Point Transaction History</div>
	 <img src="images/chart.png" alt="Point Transaction History">
    <div class="point-item">Customer Expenses</div>
	<img src="images/ex.jpg" alt="Customer Expenses">
</div>


          
    </div>

    <script>
        // Get the buttons and sections
        const customerDetailButton = document.getElementById('customer-detail');
        const statusVerificationButton = document.getElementById('status-verification');
        const membershipBalanceButton = document.getElementById('membership-balance');
        const verificationSection = document.getElementById('verification-section');
        const membershipBalanceSection = document.getElementById('membership-balance-section');
        const pointSection = document.getElementById('point-section');

        // Function to show one section and hide the other
        function toggleSection(button, sectionToShow, sectionsToHide) {
            button.addEventListener('click', function() {
                // If the section is not visible, show it, otherwise hide it
                if (sectionToShow.style.display === 'none' || sectionToShow.style.display === '') {
                    sectionToShow.style.display = 'block'; // Show the container
                    // Hide all other sections
                    sectionsToHide.forEach(section => section.style.display = 'none');
                } else {
                    sectionToShow.style.display = 'none'; // Hide the container
                }
            });
        }

        // Attach event listeners for the buttons
        toggleSection(customerDetailButton, pointSection, [verificationSection, membershipBalanceSection]);
        toggleSection(statusVerificationButton, verificationSection, [pointSection, membershipBalanceSection]);
        toggleSection(membershipBalanceButton, membershipBalanceSection, [verificationSection, pointSection]);
    </script>

</body>
</html>

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
        .point-section,
		.verification-section,
		.apply-member-section,
		.update-profile-section,
		.membership-balance-section,
		.point-sectio,
		.delete-section{
            width: 65%;
            display: none; /* Hidden by default */
            padding: 20px;
            border: 1px solid #ccc;
            border-radius: 10px;
            background-color: #f9f9f9;
        }

        .verification-section h2, 
        .membership-balance-section h2, 
		.apply-member-section h2,
		.update-profile-section h2,
        .point-section h2 
		.delete-section h2{
            margin-bottom: 10px;
        }

        .verification-section input[type="text"], 
		.membership-balance-section input[type="text"], 
		.apply-member-section input[type="text"],
		.update-profile-section input[type="text"],
        .point-section input[type="text"] ,
		.delete-section input[type="text"]{
            width: 40%;
            padding: 10px;
            margin-bottom: 10px;
        }

        .verification-section button, 
		.apply-member-section  button,
		.update-profile-section  button,
        .membership-balance-section button, 
        .point-section button,
		.delete-section {
            padding: 10px 20px;
            font-size: 16px;
            cursor: pointer;
        }

       .membership-layout {
		display: flex;
		gap: 20px; /* Space between QR code and details */
		flex-wrap: wrap; /* Ensures responsiveness */
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
/* ---*/
.apply-member-section {
    width: 65%;
    display: none; /* Hidden by default */
    padding: 20px;
    border: 1px solid #ccc;
    border-radius: 10px;
    background-color: #f9f9f9;
}

.apply-member-section h2 {
    margin-bottom: 10px;
}

.apply-member-section input[type="text"] {
    width: 90%;
    padding: 5px;
    margin-bottom: 10px;
}

.apply-member-section button {
	width: 25%;
    padding: 10px 20px;
    font-size: 16px;
    cursor: pointer;
}

.details {
    display: flex;
    justify-content: space-between;
    margin-top: 20px;
}
/*--*/

}
/* Membership Details */
.membership-details {
    flex: 2;
    display: flex;
    flex-direction: column;
    gap: 0px; /* Space between rows */
}

/* Align items in rows */
.detail-item {
    display: flex;
    justify-content: space-between;

    gap: 20px; /* Space between text and button */
}


button {
    padding: 10px 15px; /* Space inside the button */
    width: 250px; /* Fixed width for all buttons */
    text-align: center; /* Ensures text is centered */
	margin-top: 10px; /* Add space above the button */
    margin-bottom: 10px; /* Add space below the button */
}


button:hover {
    background-color: #FF0000; /* Red color */
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
        <!-- Button Section -->
        <div class="buttons" id="buttons">
            <table>
                <tr><th><button id="customer-detail">Customer Detail</button></th></tr>
                <tr><th><button id="status-verification">Status Verification</button></th></tr>
                <tr><th><button id="apply-membership">Apply Membership</button></th></tr>
                <tr><th><button id="membership-balance">Membership Balance</button></th></tr>
                <tr><th><button id="update-profile">Update Profile</button></th></tr>
                <tr><th><button id="delete-account">Delete Existing Account</button></th></tr>
            </table>
        </div>

  <!-- Customer Point Section -->
    <div class="point-section" id="point-section">
    <h2>Customer Membership</h2>
    <div class="point-item">Point Transaction History</div>
	 <img src="images/chart.png" alt="Point Transaction History">
    <div class="point-item">Customer Expenses</div>
	<img src="images/ex.jpg" alt="Customer Expenses">
</div>

    <!-- Status Verification container -->
      <div class="verification-section" id="verification-section">
            <h2>Status Verification</h2>
            <input type="text" placeholder="Drop the copy of student card">
            <button>Browse File</button>
			<div><button>Verify</button></div>
        </div>
		
	<!-- Apply Membership container -->
	<div class="apply-member-section" id="apply-member-section">
    <h2>Apply Membership</h2>
	
		<form>
			<label for="name">Customer Full Name :</label><br>
			<input type="text" id="name" name="name" value="" placeholder="Enter your full name"><br>
			<label for="Mid">Matric ID:</label><br>
			<input type="text" id="mid" name="mid" value="" placeholder="Enter your matric id"><br>
			<label for="uname">Username:</label><br>
			<input type="text" id="uname" name="uname" value="" placeholder="Enter your username"><br>
		</form>
    <div><button>Submit</button></div>
</div>


		
        <!-- Membership Balance Section -->
      <div class="membership-balance-section" id="membership-balance-section">
    <h2>Membership Balance</h2>
	
<div class="membership-layout">
    <table style="width: 100%; table-layout: fixed;">
        <tr>
            <!-- QR Code Section -->
            <td style="width: 50%; vertical-align: top; text-align: center;">
                <div class="qr-code">
                    <div class="qr-placeholder">QR Code Placeholder</div>
                    <p><em>(Scan to check the total points)</em></p>
                    <p>Membership Points Earned: <strong>00.00</strong></p>
                    <button>Membership Total Accumulated Points</button>
                </div>
            </td>

            <!-- Membership Details -->
            <td style="width: 50%; vertical-align: top;">
                <div class="membership-details">
                    <h3>Customer Membership Information</h3>
					<p>Customer name</p>
					<p>Customer username</p>
					<p>Customer email</p>
                    <button>Edit Information</button>
                    <h3>Card Balance (RM): <strong>00.00</strong></h3>
                    <button>Top-Up</button>
                </div>
            </td>
        </tr>
    </table>
</div>
</div>

    <!-- Update Profile container -->
	<div class="update-profile-section" id="update-profile-section">
    <h2>Update Profile</h2>

		<form>
			<label for="uname">Username:</label><br>
			<input type="text" id="uname" name="uname" value="" placeholder="Enter your new username"><br>
			<label for="email">Email:</label><br>
			<input type="text" id="email" name="email" value="" placeholder="Enter your new email"><br>
			<label for="num">Phone Number:</label><br>
			<input type="text" id="num" name="num" value="" placeholder="Enter your new phone number"><br>
			<label for="password">Password:</label><br>
			<input type="text" id="password" name="password" value="" placeholder="Enter your new password"><br>
		</form>
     
    <div><button>Submit</button></div>
	</div>
          
    <!-- Delete container -->
	<div class="delete-section" id="delete-section">
    <h2>Delete Profile</h2>

	<p>"Are you sure you want to delete your account? This action is permanent and cannot be undone. 
	All your data, including your profile, order history, membership points, and other associated information, 
	will be permanently removed from our system."</p>

		<form>
  		<input type="radio" id="confirm" name="argue" value="confirm">
  		<label for="confirm">Confirm delete</label><br>
 		<input type="radio" id="cancel" name="argue" value="cancel">
  		<label for="cancel">Cancel</label><br>
		</form> 
     
    <div><button>Submit</button></div>
</div>
		  
		  
    </div>

    <script>
    // Get all buttons
const customerDetailButton = document.getElementById('customer-detail');
const statusVerificationButton = document.getElementById('status-verification');
const applyMembershipButton = document.getElementById('apply-membership');
const membershipBalanceButton = document.getElementById('membership-balance');
const updateProfileButton = document.getElementById('update-profile');
const deleteAccountButton = document.getElementById('delete-account');
// Get all sections
const verificationSection = document.getElementById('verification-section');
const applyMembershipSection = document.getElementById('apply-member-section');
const membershipBalanceSection = document.getElementById('membership-balance-section');
const updateProfileSection = document.getElementById('update-profile-section');
const pointSection = document.getElementById('point-section');
const deleteSection = document.getElementById('delete-section');

// Put all sections in an array for easy management
const allSections = [
    verificationSection,
    applyMembershipSection,
    membershipBalanceSection,
    updateProfileSection,
    pointSection,
	deleteSection
];

// Function to show only the target section and hide the rest
function showSection(targetSection) {
    allSections.forEach(section => {
        section.style.display = 'none'; // Hide all sections
    });
    targetSection.style.display = 'block'; // Show the target section
}

// Attach event listeners to buttons
customerDetailButton.addEventListener('click', () => showSection(pointSection));
statusVerificationButton.addEventListener('click', () => showSection(verificationSection));
applyMembershipButton.addEventListener('click', () => showSection(applyMembershipSection));
membershipBalanceButton.addEventListener('click', () => showSection(membershipBalanceSection));
updateProfileButton.addEventListener('click', () => showSection(updateProfileSection));
deleteAccountButton.addEventListener('click', () => showSection(deleteSection));

// Initialize to hide all sections by default
document.addEventListener('DOMContentLoaded', () => {
    allSections.forEach(section => section.style.display = 'none');
});

    </script>

</body>
</html>

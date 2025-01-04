<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="stylesheet" type="text/css" href="styles/style2.css">  
    <title>Customer Dashboard</title>
    <style>
      
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
            <input type="text" placeholder="Copy of student card">
            <button>Verify</button>
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

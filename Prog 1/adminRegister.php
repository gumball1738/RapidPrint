<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="stylesheet" type="text/css" href="styles/matarep.css">    
    <title>Customer Dashboard</title>
</head>
<body>

    <div class="navigation">
        <ul>
            <li>
                <a href="MainPage3.php">
                    <img src="images/Logo.jpg" alt="Logo">
                </a>
            </li>
            <li><a href= "adminRegister.php"#dashboard">DASHBOARD</a></li>
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
                <tr><th><button id="sales-info">Sales Info</button></th></tr>
                <tr><th><button id="customer-detail">Verification Request</button></th></tr>
                <tr><th><button id="status-verification">Update Profile</button></th></tr>
                <tr><th><button id="apply-membership">Create New Account</button></th></tr>
                <tr><th><button id="delete-account">Delete Existing Account</button></th></tr>
            </table>
        </div>

        <!-- Status Verification container -->
        <div class="verification-section" id="verification-section" style="display: none;"> 
            <h2>Approve Verification</h2>
            <input type="text" placeholder="Attachment of copy of student card">
            <a href="https://docs.google.com/document/d/1iH0R3io0RHrZOQc2pBoSFZc-quwG21LnOK0ybHuPWxU/edit?usp=sharing" 
               target="_blank" 
               style="margin-left: 10px; color: blue; text-decoration: underline;">
               View here
            </a>
            <button>Approve</button>
        </div>

        <!-- Sales Info Container -->
        <div class="dashboard-container" id="sales-info-container" style="display: none;">
            <!-- Chart Section -->
            <div class="sales-chart">
                <h3>Monthly Sales</h3>
                <img src="images/graph.png" alt="Sales Chart">
            </div>

            <!-- Sales Info Section -->
            <div class="sales-info">
                <p><strong>Total RM in sales:</strong> RMXXXX</p>
                <p><strong>Total Maintenance spent:</strong> RM XXX</p>
                <p><strong>Total resources spent:</strong> RM XXX</p>
                <p><strong>Total bonus for staff:</strong> RM XX</p>
                <p><strong>Total discount used by customer:</strong> RM XXX</p>
                <button>Edit</button>
            </div>
        </div>

    </div>

    <script>
        // Get all buttons and sections
        const salesInfoButton = document.getElementById('sales-info');
        const customerDetailButton = document.getElementById('customer-detail');
        const statusVerificationButton = document.getElementById('status-verification');
        const applyMembershipButton = document.getElementById('apply-membership');
        const deleteAccountButton = document.getElementById('delete-account');

        // Sections to toggle
        const salesInfoContainer = document.getElementById('sales-info-container');
        const verificationSection = document.getElementById('verification-section');

        // Function to show a section and hide others
        function showSection(sectionToShow, sectionsToHide) {
            // Show the selected section
            sectionToShow.style.display = 'block';
            
            // Hide all other sections
            sectionsToHide.forEach(section => {
                if (section) section.style.display = 'none';
            });
        }

        // Attach event listeners to buttons
        salesInfoButton.addEventListener('click', () => showSection(salesInfoContainer, [verificationSection]));
        customerDetailButton.addEventListener('click', () => showSection(verificationSection, [salesInfoContainer]));
    </script>

</body>
</html>

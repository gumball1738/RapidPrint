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
    <td>Student ID</td>
    <td>Attachment of copy of student card</td>
    <td>Action</td>
  </tr>
  <tr>
        <td>Student ID</td>
        <td> <a href="https://docs.google.com/document/d/1iH0R3io0RHrZOQc2pBoSFZc-quwG21LnOK0ybHuPWxU/edit?usp=sharing" 
               target="_blank" 
               style="color: blue; text-decoration: underline;">
               View Here</td>
        <td><button>Approve</button>  <button>Reject</button></td>
    </tr>
</table>
  
</div>
     
	</div>


    <script>
        // Get the buttons and sections
        const verificationRequestButton = document.getElementById('verification-request');
        const saleInformationButton = document.getElementById('sale-information');
        const manageBranchButton = document.getElementById('manage-branch');
        const managePrintingPackageButton = document.getElementById('manage-printing-package');
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

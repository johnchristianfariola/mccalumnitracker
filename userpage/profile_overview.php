<?php include '../includes/session.php'; ?>
<!DOCTYPE html>
<html>

<head>
    <?php include 'includes/header.php'; ?>
    <?php
    require_once '../includes/firebaseRDB.php';
    require_once '../includes/config.php';

    $firebase = new firebaseRDB($databaseURL);

    $alumni_data = $firebase->retrieve("alumni");
    $alumni_data = json_decode($alumni_data, true);

    // Assuming you have the current user's ID stored in a session variable
    $current_user_id = $_SESSION['alumni_id'];
    $current_user = $alumni_data[$current_user_id] ?? null;

    if (!$current_user) {
        // Handle the case where the user is not found
        echo "User not found";
        exit;
    }

    function getValue($array, $key)
    {
        return isset($array[$key]) && !empty($array[$key]) ? $array[$key] : "N/A";
    }
    ?>

</head>

<body>

    <?php include 'includes/navbar.php'; ?>




    <!-----PROFILE PAGE---->
   <?php include 'includes/sidebar.php';?>

    <div class="profile-content">
        <div id="personal-info" class="profile-section">
            <h3>Personal Info</h3>



            <div class="post-col" style="width:100% !important">
                <div class="write-post-container">
                    <div class="user-profile">
                        <img src="../images/profile.jpg" alt="Profile Picture">
                        <div>
                            <p>John Doe</p>
                            <small>Public <i class="fas fa-caret-down"></i></small>
                        </div>
                    </div>

                    <div class="post-input-container">
                        <textarea rows="3" placeholder="What's on your mind, John?"></textarea>
                        <div class="add-post-links">
                            <a href="#"><img src="../images/live-video.png">Live Video</a>
                            <a href="#"><img src="../images/photo.png">Photo/Video</a>
                            <a href="#"><img src="../images/feeling.png">Feeling</a>
                        </div>
                    </div>
                </div>

                <!-- Post Section -->


                <div class="post-container">
    <div class="profile-image-container">
        <img src="<?php echo getValue($current_user, 'profile_url'); ?>" alt="Profile Picture"
            onerror="if (this.src != 'uploads/profile.jpg') this.src = 'uploads/profile.jpg';">
    </div>  
    <div class="profile-info">
        <!-- Personal Info Column -->
        <div class="personal-info">
            <h3>Personal Info</h3>
            <p><strong>Name:</strong> <?php echo getValue($current_user, 'auxiliaryname') . ' ' . getValue($current_user, 'firstname') . ' ' . getValue($current_user, 'middlename') . ' ' . getValue($current_user, 'lastname'); ?></p>
            <p><strong>Birthday:</strong> <?php echo getValue($current_user, 'birthdate'); ?></p>
            <p><strong>Gender:</strong> <?php echo getValue($current_user, 'gender'); ?></p>
            <p><strong>Address:</strong> <?php echo getValue($current_user, 'addressline1'); ?></p>
            <p><strong>Civil Status:</strong> <?php echo getValue($current_user, 'civilstatus'); ?></p>
            <p><strong>Student ID:</strong> <?php echo getValue($current_user, 'studentid'); ?></p>
        </div>

        <!-- Employment Info Column -->
        <div class="employment-info">
            <h3>Employment Info</h3>
            <p><strong>Status:</strong> <span class=" btn-warning notika-btn-warning" style="padding:5px 10px 5px 10px; border-radius:10px"><?php echo getValue($current_user, 'work_status'); ?></span> </p>
            <p><strong>Company:</strong> <?php echo getValue($current_user, 'name_company'); ?></p>
            <p><strong>Position:</strong> <?php echo getValue($current_user, 'work_position'); ?></p>
            <p><strong>Start Date:</strong> <?php echo getValue($current_user, 'first_employment_date'); ?></p>
            <p><strong>Work Status:</strong> <?php echo getValue($current_user, 'work_employment_status'); ?></p>
            <p><strong>Work Classification:</strong> <?php echo getValue($current_user, 'work_classification'); ?></p>
            <p><strong>Monthly Income:</strong> <?php echo getValue($current_user, 'current_monthly_income'); ?></p>
            <p><strong>Job Satisfaction:</strong> <?php echo getValue($current_user, 'job_satisfaction'); ?></p>
        </div>

        <!-- Contact Info Column -->
        <div class="contact-info">
            <h3>Contact Info</h3>
            <p><strong>Email:</strong> <?php echo getValue($current_user, 'email'); ?></p>
            <p><strong>Phone Number:</strong> <?php echo getValue($current_user, 'contactnumber'); ?></p>
            <p><strong>City:</strong> <?php echo getValue($current_user, 'city'); ?></p>
            <p><strong>State:</strong> <?php echo getValue($current_user, 'state'); ?></p>
            <p><strong>Zip Code:</strong> <?php echo getValue($current_user, 'zipcode'); ?></p>
        </div>
    </div>
</div>

            </div>

        </div>
        <style>
            /* Modern and GUI-friendly styles for post-container */


            .profile-info {
                display: grid;
                grid-template-columns: 1fr 1fr 1fr;
                /* 3 equal columns */
                grid-template-rows: auto 1fr;
                /* Auto row for image, remaining space for columns */
                gap: 20px;
                /* Space between columns and rows */
            }

            /* Profile Image Container */
            .profile-image-container {
                grid-column: span 3;
                /* Span across all 3 columns */
                display: flex;
                justify-content: center;
                /* Center the image horizontally */
                margin-bottom: 20px;
            }

            .profile-image-container img {
                width: 150px;
                height: 150px;
                border-radius: 50%;
                /* Make the image circular */
                object-fit: cover;
                box-shadow: 0 2px 4px rgba(0, 0, 0, 0.2);
            }

            /* Section Styles */
            .profile-info div {
                background-color: #f9f9f9;
                /* Light background for sections */
                padding: 15px;
                border-radius: 8px;
                box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            }

            .profile-info h3 {
                margin-top: 0;
                font-size: 18px;
                color: #333;
                border-bottom: 2px solid #ddd;
                /* Underline for section headers */
                padding-bottom: 10px;
                margin-bottom: 10px;
            }

            .profile-info p {
                margin: 10px 0;
                font-size: 16px;
                color: #333;
            }

            .profile-info p strong {
                font-weight: 600;
                color: #555;
            }

            /* Responsive design for smaller screens */
            @media (max-width: 768px) {
                .profile-info {
                    grid-template-columns: 1fr;
                    /* Stack all content vertically on small screens */
                }

                .profile-image-container {
                    grid-column: 1;
                    /* Adjust for single column layout */
                }
            }



            /* Sidebar Styles */
            .sidebar {
                position: fixed;
                top: 0;
                left: 0;
                width: 250px;
                height: 100%;
                background-color: #f4f4f4;
                padding: 15px;
                box-shadow: 2px 0 5px rgba(0, 0, 0, 0.1);
                overflow-y: auto;
            }

            .sidebar h2 {
                margin-top: 0;
            }

            .sidebar ul {
                list-style-type: none;
                padding: 0;
            }

            .sidebar ul li {
                margin: 10px 0;
            }

            .sidebar ul li a {
                text-decoration: none;
                color: #333;
                font-weight: bold;
            }

            /* Profile Content Styles */
            .profile-content {
                margin-left: 250px;
                /* Adjust according to sidebar width */
                padding: 20px;
                width: calc(100% - 250px);
                /* Ensure it takes the full width minus the sidebar width */
            }

            .post-col {
                width: 100%;
                /* Ensure it uses the full width of .profile-content */
                box-sizing: border-box;
                /* Include padding and border in the element's total width */
            }


            .profile-section {
                margin-bottom: 30px;
            }
        </style>
        <?php include 'includes/profile_modal.php'; ?>
</body>

</html>

<script src="js/vendor/jquery-1.12.4.min.js"></script>
<script src="js/bootstrap.min.js"></script>
<script src="js/dialog/sweetalert2.min.js"></script>
<script src="js/dialog/dialog-active.js"></script>
<script src="js/main.js"></script>
<script src="../bower_components/ckeditor/ckeditor.js"></script>
<script src="js/jquery/jquery-3.5.1.min.js"></script>
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

    $category_data = $firebase->retrieve("category");
    $category_data = json_decode($category_data, true);

    $courseData = $firebase->retrieve("course");
    $courseData = json_decode($courseData, true);

    $batchData = $firebase->retrieve("batch_yr");
    $batchData = json_decode($batchData, true);

    function getBatchYear($batchData, $batch_id)
    {
        return isset($batchData[$batch_id]['batch_yrs']) ? $batchData[$batch_id]['batch_yrs'] : "Unknown Batch";
    }

    function getCourseName($courseData, $course_id)
    {
        return isset($courseData[$course_id]['course_name']) ? $courseData[$course_id]['course_name'] : "Unknown Course";
    }

    // Assuming you have the current user's ID stored in a session variable
    $current_user_id = $_SESSION['alumni_id'];
    $current_user = $alumni_data[$current_user_id] ?? null;

    $messages = json_decode($firebase->retrieve("messages"), true);

    // Convert messages array to JSON for JavaScript
    $messages_json = json_encode($messages);

    if (!$current_user) {
        // Handle the case where the user is not found
        echo "User not found";
        exit;
    }

    function getValue($array, $key)
    {
        return isset($array[$key]) && !empty($array[$key]) ? $array[$key] : "N/A";
    }

    function getCourseCode($courseData, $course_id)
    {
        return isset($courseData[$course_id]['courCode']) ? $courseData[$course_id]['courCode'] : "Unknown";
    }

    // Get the work classification ID from the current user's data
    $work_classification_id = getValue($current_user, 'work_classification');

    // Get the readable category name using the work classification ID
    $category_name = getCourseCode($category_data, $work_classification_id);


    function generateQRCode($batchYear, $studentId, $courseCode)
    {
        $data = "MCCALUMNI-{$batchYear}-{$studentId}-{$courseCode}-{$batchYear}";
        $size = 200;
        $apiUrl = "https://api.qrserver.com/v1/create-qr-code/?size={$size}x{$size}&data=" . urlencode($data);
        return $apiUrl;
    }

    // In the main code, before the HTML, add:
    $qrCodeUrl = generateQRCode(
        getBatchYear($batchData, getValue($current_user, 'batch')),
        getValue($current_user, 'studentid'),
        getCourseCode($courseData, getValue($current_user, 'course'))
    );

    ?>

    <style>
        /* Existing styles */
        .profile-info {
            display: grid;
            grid-template-columns: 1fr 1fr 1fr;
            grid-template-rows: auto 1fr;
            gap: 20px;
        }



      
    </style>
</head>

<body>
    <?php include 'includes/navbar.php'; ?>
    <?php include 'includes/sidebar.php'; ?>

    <div class="profile-content">
        <div id="personal-info" class="profile-section">
            <h3>Personal Info</h3>
            <div class="post-col" style="width:100% !important">
                <div class="write-post-container">
                    <div class="id-card-container">
                        <!-- Front Side -->
                        <div class="id-card">
                            <div class="card-content card-front">
                                <div class="card-left">
                                    <div class="logo-card">
                                        <img src="img/logo/alumni_logo.png" alt=" Logo">
                                    </div>
                                    <div class="card-text">
                                        <h4>MCC ALUMNI</h4>
                                        <p>Madridejos Community College, Alumni Association.</p>
                                        <h3><?php echo strtoupper(getValue($current_user, 'lastname') . ', ' . getValue($current_user, 'firstname') . ' ' . substr(getValue($current_user, 'middlename'), 0, 1) . '.'); ?>
                                        </h3>
                                        <p class="id-number"><?php echo getValue($current_user, 'studentid'); ?></p>
                                        <p><?php echo getCourseName($courseData, getValue($current_user, 'course')); ?>
                                        </p>
                                        <p>BATCH
                                            <?php echo getBatchYear($batchData, getValue($current_user, 'batch')); ?>
                                        </p>
                                    </div>
                                </div>
                                <div class="card-right">
                                    <img src="../homepage/img/sir-manuel-p4eU0iHsBoU-unsplash.jpg"
                                        alt="Graduate Picture" class=""
                                        onerror="if (this.src != 'uploads/profile.jpg') this.src = 'uploads/profile.jpg';">
                                </div>

                            </div>
                        </div>

                        <!-- Back Side -->
                        <div class="id-card">
                            <div class="card-content card-back">
                                <div class="card-back-left">
                                    <div class="contact-info">
                                        <h3>Contact Information</h3>
                                        <p>Madridejos Community College</p>
                                        <p>Bunakan, Madridejos, Cebu</p>
                                        <p>Contact Number: <?php echo getValue($current_user, 'contactnumber'); ?></p>
                                        <p>Email: <?php echo getValue($current_user, 'email'); ?></p>
                                    </div>
                                    <div class="signature">
                                        <p>Signature</p>
                                        <div class="signature-line"></div>
                                    </div>
                                </div>
                                <div class="qr-code">
                                    <img src="<?php echo $qrCodeUrl; ?>" alt="QR Code">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="post-container">
                    <center>
                    <div class="profile-image-container">
                        <img src="<?php echo getValue($current_user, 'profile_url'); ?>" alt="Profile Picture"
                            onerror="if (this.src != 'uploads/profile.jpg') this.src = 'uploads/profile.jpg';">
                    </div>
                    </center>
                
                    <div class="profile-info">
                        <!-- Personal Info Column -->
                        <div class="personal-info">
                            <h3>Personal Info</h3>
                            <p><strong>Name:</strong>
                                <?php echo getValue($current_user, 'auxiliaryname') . ' ' . getValue($current_user, 'firstname') . ' ' . getValue($current_user, 'middlename') . ' ' . getValue($current_user, 'lastname'); ?>
                            </p>
                            <p><strong>Birthday:</strong><?php $birthdate = getValue($current_user, 'birthdate');
                            $formatted_date = date("F j, Y", strtotime($birthdate));
                            echo $formatted_date; ?>
                            </p>
                            <p><strong>Gender:</strong> <?php echo getValue($current_user, 'gender'); ?></p>
                            <p><strong>Address:</strong>
                                <?php echo getValue($current_user, 'barangay') . ', ' . getValue($current_user, 'city') . ',  ' . getValue($current_user, 'state'); ?>
                            </p>
                            <p><strong>Civil Status:</strong> <?php echo getValue($current_user, 'civilstatus'); ?></p>
                            <p><strong>Student ID:</strong> <?php echo getValue($current_user, 'studentid'); ?></p>
                        </div>

                        <!-- Employment Info Column -->
                        <div class="employment-info">
                            <h3>Employment Info</h3>
                            <p><strong>Status:</strong> <span class="btn-warning notika-btn-warning"
                                    style="padding:5px 10px 5px 10px; border-radius:10px"><?php echo getValue($current_user, 'work_status'); ?></span>
                            </p>
                            <p><strong>Company:</strong> <?php echo getValue($current_user, 'name_company'); ?></p>
                            <p><strong>Position:</strong> <?php echo getValue($current_user, 'work_position'); ?></p>
                            <p><strong>Start Date:</strong>
                                <?php $start_date = getValue($current_user, 'date_for_current_employment');
                                $formatted_date = date("F j, Y", strtotime($start_date));
                                echo $formatted_date; ?>
                            </p>
                            <p><strong>Work Status:</strong>
                                <?php echo getValue($current_user, 'work_employment_status'); ?></p>
                            <p><strong>Work Classification:</strong>
                                <?php echo $category_name; ?></p>
                            <p><strong>Monthly Income:</strong>
                                <?php echo getValue($current_user, 'current_monthly_income'); ?></p>
                            <p><strong>Job Satisfaction:</strong>
                                <?php echo getValue($current_user, 'job_satisfaction'); ?></p>
                        </div>

                        <!-- Contact Info Column -->
                        <div class="contact-info">
                            <h3>Contact Info</h3>
                            <p><strong>Email:</strong> <?php echo getValue($current_user, 'email'); ?></p>
                            <p><strong>Phone Number:</strong> <?php echo getValue($current_user, 'contactnumber'); ?>
                            </p>
                            <p><strong>City:</strong> <?php echo getValue($current_user, 'city'); ?></p>
                            <p><strong>State:</strong> <?php echo getValue($current_user, 'state'); ?></p>
                            <p><strong>Zip Code:</strong> <?php echo getValue($current_user, 'zipcode'); ?></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php include 'global_chatbox.php' ?>

   
</body>

</html>
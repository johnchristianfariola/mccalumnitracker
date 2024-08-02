<?php include '../includes/session.php'; ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Heebo:wght@400;500;600&family=Nunito:wght@600;700;800&display=swap" rel="stylesheet">

    <!-- Icon Font Stylesheet -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet">

    <!-- Libraries Stylesheet -->
    <link href="../homepage/lib/animate/animate.min.css" rel="stylesheet">
    <link href="../homepage/lib/owlcarousel/assets/owl.carousel.min.css" rel="stylesheet">

    <!-- Customized Bootstrap Stylesheet -->
    <link href="../homepage/css/bootstrap.min.css" rel="stylesheet">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.0.18/dist/sweetalert2.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.0.18/dist/sweetalert2.all.min.js"></script>

    <!-- Template Stylesheet -->
    <link href="../homepage/css/style.css" rel="stylesheet">
    <link href="../homepage/css/styles-merged.css" rel="stylesheet">
    <link href="alumni_profile.css" rel="stylesheet">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.0.18/dist/sweetalert2.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.0.18/dist/sweetalert2.all.min.js"></script>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.0.18/dist/sweetalert2.min.css">
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.0.18/dist/sweetalert2.all.min.js"></script>

    <link rel="stylesheet" href="custom.css">
    <title>Alumni Profile Update</title>
    <?php

    // If the user is not logged in, redirect to the main index page
    if (!isset($_SESSION['alumni'])) {
        header('location: ../index.php');
        exit();
    }

    // If forms_completed is true, redirect to the user home page
    if (isset($_SESSION['forms_completed']) && $_SESSION['forms_completed'] == true) {
        header('location: index.php');
        exit();
    }

    if (isset($_SESSION['forms_completed']) && $_SESSION['forms_completed']) {
        // Redirect to index.php if forms are completed
        header('location: index.php');
        exit();
    }


    ?>
    <?php
    // Fetch data from Firebase
    $courseKey = "course"; // Replace with your actual Firebase path or key for courses
    
    $data = $firebase->retrieve($courseKey);
    $data = json_decode($data, true); // Decode JSON data into associative arrays
    
    $batchYears = $firebase->retrieve("batch_yr");
    $batchYears = json_decode($batchYears, true); // Decode JSON data into associative arrays
    ?>
</head>

<body style="background:white; ">

    <?php include '../includes/navbar.php' ?>


        
    <div class="form-container">
        <form action="update_profile.php" method="POST" class="form" enctype="multipart/form-data">
            <!-- Hidden fields -->
            <input type="hidden" name="alumni_id" value="<?php echo htmlspecialchars($user['id']); ?>">
            <input type="hidden" name="token" value="<?php echo htmlspecialchars($_SESSION['token']); ?>">
            <input type="hidden" name="batch_id" value="<?php echo htmlspecialchars($_SESSION['user']['batch_id']); ?>">
            <input type="hidden" name="course_id"
                value="<?php echo htmlspecialchars($_SESSION['user']['course_id']); ?>">

            <div class="form-section first active">
                <h2><span class="step-icon">01</span> Personal Information</h2>
                <p>Please correct any incorrect information and proceed to the next step.</p>

                <div class="custom-profile" id="profileDisplay">
                    <label for="profileImageInput" class="custom-label">Choose Profile Image</label>
                </div>
                <input type="file" id="profileImageInput" name="profileImage" accept="image/*" required>

                <div class="fields">
                    <div class="input-field">
                        <label>First Name</label>
                        <input type="text" name="firstname" placeholder="Enter your name"
                            value="<?php echo htmlspecialchars($user['firstname']); ?>" required>
                    </div>
                    <div class="input-field">
                        <label>Middle Name</label>
                        <input type="text" name="middlename" placeholder="Enter your middle name"
                            value="<?php echo htmlspecialchars($user['middlename'] ?? ''); ?>">
                    </div>
                    <div class="input-field">
                        <label>Last Name</label>
                        <input type="text" name="lastname" placeholder="Enter your lastname"
                            value="<?php echo htmlspecialchars($user['lastname']); ?>" required>
                    </div>
                    <div class="input-field">
                        <label>Auxiliary Name</label>
                        <input type="text" name="auxiliaryname" placeholder="Enter auxiliary name"
                            value="<?php echo htmlspecialchars($user['auxiliaryname']); ?>" required>
                    </div>
                    <div class="input-field">
                        <label>Date of Birth</label>
                        <input type="date" name="birthdate" value="<?php echo htmlspecialchars($user['birthdate']); ?>"
                            required>
                    </div>
                    <div class="input-field">
                        <label>Sex</label>
                        <select name="gender" required>
                            <option disabled>Select gender</option>
                            <option value="Male" <?php echo ($user['gender'] === 'Male') ? 'selected' : ''; ?>>Male
                            </option>
                            <option value="Female" <?php echo ($user['gender'] === 'Female') ? 'selected' : ''; ?>>Female
                            </option>
                            <option value="Others" <?php echo ($user['gender'] === 'Others') ? 'selected' : ''; ?>>Others
                            </option>
                        </select>
                    </div>
                    <div class="input-field">
                        <label>Civil Status</label>
                        <input type="text" name="civilstatus" placeholder="Enter your civil status"
                            value="<?php echo htmlspecialchars($user['civilstatus']); ?>" required>
                    </div>
                </div>

                <h3>Contact Details</h3>
                <div class="fields">
                    <div class="input-field">
                        <label>Address</label>
                        <input type="text" name="addressline1" placeholder="Enter your address"
                            value="<?php echo htmlspecialchars($user['addressline1']); ?>" required>
                    </div>
                    <div class="input-field">
                        <label>City</label>
                        <input type="text" name="city" placeholder="Enter your city"
                            value="<?php echo htmlspecialchars($user['city']); ?>" required>
                    </div>
                    <div class="input-field">
                        <label>State | Province | Region</label>
                        <input type="text" name="state" placeholder="Enter your state"
                            value="<?php echo htmlspecialchars($user['state']); ?>" required>
                    </div>
                    <div class="input-field">
                        <label>Zip Code</label>
                        <input type="text" name="zipcode" placeholder="Enter your zip code"
                            value="<?php echo htmlspecialchars($user['zipcode']); ?>" required>
                    </div>
                    <div class="input-field">
                        <label>Email</label>
                        <input type="email" name="email" placeholder="Enter your email"
                            value="<?php echo htmlspecialchars($user['email']); ?>" required>
                    </div>
                    <div class="input-field">
                        <label>Contact</label>
                        <input type="text" name="contactnumber" placeholder="Enter your contact number"
                            value="<?php echo htmlspecialchars($user['contactnumber']); ?>" required>
                    </div>
                </div>

                <div class="buttons">
                    <button type="button" class="nextBtn">Next</button>
                </div>
            </div>

            <div class="form-section second">
                <h2><span class="step-icon">02</span> Additional Information</h2>

                <div class="fields">
                    <div class="input-field">
                        <label>Course</label>
                        <select class="form-control" id="course" name="course" required>
                            <option value="<?php echo htmlspecialchars($_SESSION['user']['course_id']); ?>">
                                <?php echo htmlspecialchars($_SESSION['user']['course']); ?>
                            </option>
                            <?php
                            if (is_array($data)) {
                                foreach ($data as $courseId => $details) {
                                    $courseCode = isset($details['courCode']) ? htmlspecialchars($details['courCode']) : 'Unknown';
                                    echo "<option value=\"" . htmlspecialchars($courseId) . "\">" . $courseCode . "</option>";
                                }
                            }
                            ?>
                        </select>
                    </div>
                    <div class="input-field">
                        <label>Batch</label>
                        <select class="form-control" id="batch" name="batch" required>
                            <option value="<?php echo htmlspecialchars($_SESSION['user']['batch_id']); ?>">
                                <?php echo htmlspecialchars($_SESSION['user']['batch']); ?>
                            </option>
                            <?php
                            if (!empty($batchYears) && is_array($batchYears)) {
                                foreach ($batchYears as $batchId => $batchDetails) {
                                    $batchYear = isset($batchDetails['batch_yrs']) ? htmlspecialchars($batchDetails['batch_yrs']) : 'Unknown';
                                    echo "<option value=\"" . htmlspecialchars($batchId) . "\">" . $batchYear . "</option>";
                                }
                            }
                            ?>
                        </select>
                    </div>
                    <div class="input-field">
                        <label>Current Work Status</label>
                        <select class="form-control" name="work_status" id="work-status" required>
                            <option value="">Select Status</option>
                            <option value="Employed">Employed</option>
                            <option value="Unemployed">Unemployed</option>
                        </select>
                    </div>
                    <div class="input-field">
                        <label>Date of 1st Employment</label>
                        <input type="date" class="form-control" id="first_employment_date" name="first_employment_date">
                    </div>
                    <div class="input-field">
                        <label>Date of Current Employment</label>
                        <input type="date" class="form-control" id="date_for_current_employment"
                            name="date_for_current_employment">
                    </div>
                    <div class="input-field">
                        <label>Type of Work</label>
                        <input type="text" class="form-control" id="type_of_work" name="type_of_work"
                            placeholder="Type of Work">
                    </div>
                    <div class="input-field">
                        <label>Work Position</label>
                        <input type="text" class="form-control" id="work_position" name="work_position"
                            placeholder="Work Position">
                    </div>
                    <div class="input-field">
                        <label>Current Monthly Income</label>
                        <input type="number" class="form-control" id="current_monthly_income"
                            name="current_monthly_income" placeholder="Current Monthly Income">
                    </div>
                    <div class="input-field">
                        <label>Is your job related to your undergraduate program?</label>
                        <select class="form-control" name="work_related" id="work_related">
                            <option value="Yes">Yes</option>
                            <option value="No">No</option>
                        </select>
                    </div>
                </div>

                <div class="buttons">
                    <button type="button" class="backBtn">Back</button>
                    
                    <button type="submit" class="submitBtn">Submit</button>
                </div>
            </div>
        </form>
    </div>

    <!-- Welcome Modal -->
    <div class="modal fade modern-modal" id="welcomeModal" tabindex="-1" aria-labelledby="welcomeModalLabel"
        aria-hidden="true" style="padding-right: 0px !important;">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="welcomeModalLabel">Welcome, Alumni!</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>We're excited to have you here at the Alumni Profile Update page. Your information is valuable to
                        us and helps us serve you better.</p>
                    <p>Please take a moment to review and update your details. This ensures you stay connected with our
                        alumni community and receive relevant updates.</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" data-bs-dismiss="modal">Let's Get Started</button>
                </div>
            </div>
        </div>
    </div>

    <?php include 'includes/footer.php' ?>
   
</body>

</html>

<?php include 'includes/script.php' ?>



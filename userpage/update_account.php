<?php include '../includes/session.php'; ?>
<!DOCTYPE html>
<html>

<head>
    <link rel="stylesheet" href="css/datapicker/datepicker3.css">
    <?php include 'includes/header.php'; ?>
    <?php
    require_once '../includes/firebaseRDB.php';
    require_once '../includes/config.php';

    $firebase = new firebaseRDB($databaseURL);

    $alumni_data = $firebase->retrieve("alumni");
    $alumni_data = json_decode($alumni_data, true);

    $categoriesData = $firebase->retrieve('category');
    $categories = json_decode($categoriesData, true);

    $batchYears = $firebase->retrieve("batch_yr");
    $batchYears = json_decode($batchYears, true); // Decode JSON data into associative arrays
    
    $courseKey = "course"; // Replace with your actual Firebase path or key for courses
    $data = $firebase->retrieve($courseKey);
    $data = json_decode($data, true); // Decode JSON data into associative arrays
    
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

    function formatValue($value)
    {
        // Check if the value is numeric
        if (is_numeric($value)) {
            // Convert to float and format it with 2 decimal places
            return number_format((float) $value, 2);
        } else {
            // Return a default message or value for non-numeric values
            return 'N/A';
        }
    }

    // Retrieve the birthdate from the user data
    $birthdate = getValue($current_user, 'birthdate');

    // Convert the date from YYYY-MM-DD to DD/MM/YYYY
    $birthdateFormatted = date("d/m/Y", strtotime($birthdate));

    // Retrieve the first employment date from the user data
    $firstEmploymentDate = getValue($current_user, 'first_employment_date');

    // Replace hyphens with slashes
    $firstEmploymentDateFormatted = str_replace('-', '/', $firstEmploymentDate);

    // Retrieve the date for current employment from the user data
    $currentEmploymentDate = getValue($current_user, 'date_for_current_employment');

    // Replace hyphens with slashes
    $currentEmploymentDateFormatted = str_replace('-', '/', $currentEmploymentDate);

    ?>


    <style>
        .dropup .dropdown-menu {
            top: auto;
            bottom: 100%;
            margin-bottom: 5px;
        }

        /* Modern and GUI-friendly styles for post-container */



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
</head>

<body>

    <?php include 'includes/navbar.php'; ?>




    <!-----PROFILE PAGE---->
    <?php include 'includes/sidebar.php'; ?>

    <div class="profile-content">
        <form id="updateProfileForm" action="edit_user_account.php" method="POST">
            <input type="hidden" name="user_id" value="<?php echo $current_user_id; ?>">
            <div id="personal-info" class="profile-section">
                <h3>Personal Information</h3>
                <div class="post-col" style="width:100% !important">
                    <!-- Post Section -->
                    <div class="post-container">
                        <div class="row">
                            <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                                <label for="firstname">First Name</label>
                                <div class="form-group">
                                    <div class="nk-int-st">
                                        <input type="text" id="firstname" name="firstname" class="form-control"
                                            placeholder="Firstname"
                                            value="<?php echo getValue($current_user, 'firstname'); ?>">
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                                <div class="form-group">
                                    <label for="middlename">Middle Name</label>
                                    <div class="nk-int-st">
                                        <input type="text" id="middlename" name="middlename" class="form-control"
                                            placeholder="Middlename"
                                            value="<?php echo getValue($current_user, 'middlename'); ?>">
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                                <div class="form-group">
                                    <label for="lastname">Last Name</label>
                                    <div class="nk-int-st">
                                        <input type="text" id="lastname" name="lastname" class="form-control"
                                            placeholder="Lastname"
                                            value="<?php echo getValue($current_user, 'lastname'); ?>">
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                                <div class="form-group">
                                    <label for="regionSelect">Region</label>
                                    <div class="nk-int-st">
                                        <select id="regionSelect" name="region" class="form-control selectpicker"
                                            data-live-search="true">
                                            <option value="">Loading regions...</option>

                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                                <div class="form-group">
                                    <label for="provinceSelect">Province</label>
                                    <div class="nk-int-st">
                                        <select id="provinceSelect" name="state" class="form-control selectpicker"
                                            data-live-search="true">
                                            <option value="">Select a region first</option>
                                            <?php
                                            $current_state = getValue($current_user, 'state');
                                            if (!empty($current_state)) {
                                                echo "<option value=\"$current_state\" selected>$current_state</option>";
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                                <div class="form-group">
                                    <label for="citySelect">City/Municipality</label>
                                    <div class="nk-int-st">
                                        <select id="citySelect" name="city" class="form-control selectpicker"
                                            data-live-search="true">
                                            <option value="">Select a province first</option>
                                            <?php
                                            $current_city = getValue($current_user, 'city');
                                            if (!empty($current_city)) {
                                                echo "<option value=\"$current_city\" selected>$current_city</option>";
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                                <div class="form-group">
                                    <label for="barangaySelect">Barangay</label>
                                    <div class="nk-int-st">
                                        <select id="barangaySelect" name="barangay" class="form-control selectpicker"
                                            data-live-search="true">
                                            <option value="">Select a city/municipality first</option>
                                            <?php
                                            $current_barangay = getValue($current_user, 'barangay');
                                            if (!empty($current_barangay)) {
                                                echo "<option value=\"$current_barangay\" selected>$current_barangay</option>";
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                                <div class="form-group">
                                    <label for="birthdate">Birth Date</label>
                                    <div class="nk-int-st">
                                        <input type="text" id="birthdate" name="birthdate" class="form-control"
                                            data-mask="99/99/9999" placeholder="dd/mm/yyyy"
                                            value="<?php echo $birthdateFormatted; ?>">
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                                <div class="form-group">
                                    <label for="gender">Gender</label>
                                    <div class="nk-int-st">
                                        <select id="gender" name="gender" class="form-control selectpicker">
                                            <option value="Male" <?php echo (getValue($current_user, 'gender') == 'Male') ? 'selected' : ''; ?>>Male</option>
                                            <option value="Female" <?php echo (getValue($current_user, 'gender') == 'Female') ? 'selected' : ''; ?>>Female</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                                <div class="form-group">
                                    <label for="civilstatus">Civil Status</label>
                                    <div class="nk-int-st">
                                        <select id="civilstatus" name="civilstatus" class="form-control selectpicker">
                                            <option value="Single" <?php echo (getValue($current_user, 'civilstatus') == 'Single') ? 'selected' : ''; ?>>Single</option>
                                            <option value="Married" <?php echo (getValue($current_user, 'civilstatus') == 'Married') ? 'selected' : ''; ?>>Married</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>

                <h3>Contact</h3>
                <div class="post-col" style="width:100% !important">
                    <!-- Post Section -->
                    <div class="post-container">
                        <div class="row">
                            <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                                <div class="form-group">
                                    <label for="contactnumber">Contact Number</label>
                                    <div class="nk-int-st">
                                        <input type="text" id="contactnumber" name="contactnumber" class="form-control"
                                            value="<?php echo getValue($current_user, 'contactnumber'); ?>"
                                            placeholder="Contact Number">
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                                <div class="form-group">
                                    <label for="reserve_email">Email</label>
                                    <div class="nk-int-st">
                                        <input type="text" id="reserve_email" name="reserve_email" class="form-control"
                                            value="<?php echo getValue($current_user, 'reserve_email'); ?>"
                                            placeholder="Email">
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                                <div class="form-group">
                                    <label for="addressline1">Current Address</label>
                                    <div class="nk-int-st">
                                        <input type="text" id=" " name="addressline1" class="form-control"
                                            value="<?php echo getValue($current_user, 'addressline1'); ?>"
                                            placeholder="Address">
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                                <div class="form-group">
                                    <label for="zipcode">Zip Code</label>
                                    <div class="nk-int-st">
                                        <input type="text" id="zipcode" name="zipcode" class="form-control"
                                            value="<?php echo getValue($current_user, 'zipcode'); ?>"
                                            placeholder="Zip Code">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>


                <h3>Employment Information</h3>
                <div class="post-col" style="width:100% !important">
                    <!-- Post Section -->
                    <div class="post-container">
                        <div class="row">
                            <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                                <div class="form-group">
                                    <label for="work_status">Employment Status</label>
                                    <div class="nk-int-st">
                                        <select id="work_status" name="work_status" class="form-control selectpicker">
                                            <option>Select Status</option>
                                            <option value="Employed" <?php echo (getValue($current_user, 'work_status') == 'Employed') ? 'selected' : ''; ?>>Employed</option>
                                            <option value="Unemployed" <?php echo (getValue($current_user, 'work_status') == 'Unemployed') ? 'selected' : ''; ?>>Unemployed</option>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">

                                <label for="first_employment_date">First Employment Date</label>
                                <div class="form-group nk-datapk-ctm form-elet-mg" id="data_1">
                                    <div class="input-group date nk-int-st">
                                        <span class="input-group-addon"></span>
                                        <input type="text" class="form-control" name="first_employment_date"
                                            value="<?php echo getValue($current_user, 'first_employment_date'); ?>">
                                    </div>
                                </div>

                            </div>


                            <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                                <div class="form-group nk-datapk-ctm " id="data_1">
                                    <label for="company_name">Current Employment Date</label>
                                    <div class="input-group date nk-int-st">
                                        <span class="input-group-addon"></span>
                                        <input type="text" class="form-control" name="date_for_current_employment"
                                            value="<?php echo getValue($current_user, 'date_for_current_employment'); ?>">
                                    </div>
                                </div>
                            </div>



                            <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                                <div class="form-group">
                                    <label for="company_name">Company Name</label>
                                    <div class="nk-int-st">
                                        <input type="text" id="company_name" name="name_company" class="form-control"
                                            value="<?php echo getValue($current_user, 'company_name'); ?>"
                                            placeholder="Company Name">
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                                <div class="form-group">
                                    <label for="employment_location">Employment Location</label>
                                    <div class="nk-int-st">
                                        <input type="text" id="employment_location" name="employment_location"
                                            class="form-control"
                                            value="<?php echo getValue($current_user, 'employment_location'); ?>"
                                            placeholder="Employment Location">
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                                <div class="form-group">
                                    <label for="type_of_work">Type of Work</label>
                                    <div class="nk-int-st">
                                        <input type="text" id="type_of_work" name="type_of_work" class="form-control"
                                            value="<?php echo getValue($current_user, 'type_of_work'); ?>"
                                            placeholder="Type of Work">
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                                <div class="form-group">
                                    <label for="work_position">Position</label>
                                    <div class="nk-int-st">
                                        <input type="text" id="work_position" name="work_position" class="form-control"
                                            value="<?php echo getValue($current_user, 'work_position'); ?>"
                                            placeholder="Position">
                                    </div>
                                </div>
                            </div>

                            <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                                <div class="form-group">
                                    <label for="monthly_income">Monthly Income</label>
                                    <div class="nk-int-st">
                                        <input type="text" id="monthly_income" name="current_monthly_income"
                                            class="form-control"
                                            value="<?php echo number_format(getValue($current_user, 'current_monthly_income'), 2); ?>"
                                            placeholder="Monthly Income">
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                                <div class="form-group">
                                    <label for="job_satisfaction">Job Satisfaction</label>
                                    <div class="nk-int-st">
                                        <select id="job_satisfaction" name="job_satisfaction"
                                            class="form-control selectpicker">
                                            <option value="Very Satisfied" <?php echo (getValue($current_user, 'job_satisfaction') == 'Very Satisfied') ? 'selected' : ''; ?>>Very
                                                Satisfied</option>
                                            <option value="Satisfied" <?php echo (getValue($current_user, 'job_satisfaction') == 'Satisfied') ? 'selected' : ''; ?>>Satisfied
                                            </option>
                                            <option value="Neutral" <?php echo (getValue($current_user, 'job_satisfaction') == 'Neutral') ? 'selected' : ''; ?>>Neutral</option>
                                            <option value="Dissatisfied" <?php echo (getValue($current_user, 'job_satisfaction') == 'Dissatisfied') ? 'selected' : ''; ?>>Dissatisfied
                                            </option>
                                            <option value="Very Dissatisfied" <?php echo (getValue($current_user, 'job_satisfaction') == 'Very Dissatisfied') ? 'selected' : ''; ?>>Very
                                                Dissatisfied</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                                <div class="form-group">
                                    <label for="related_to_course">Related to Course of Study?</label>
                                    <div class="nk-int-st">
                                        <select id="related_to_course" name="work_related"
                                            class="form-control selectpicker">
                                            <option value="Yes" <?php echo (getValue($current_user, 'related_to_course') == 'Yes') ? 'selected' : ''; ?>>Yes</option>
                                            <option value="No" <?php echo (getValue($current_user, 'related_to_course') == 'No') ? 'selected' : ''; ?>>No</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                                <div class="form-group">
                                    <label for="work_classification">Work Classification</label>
                                    <div class="nk-int-st">
                                        <select id="work_classification" name="work_classification"
                                            class="form-control selectpicker">
                                            <option
                                                value="<?php echo htmlspecialchars($_SESSION['user']['category_id']); ?>">
                                                <?php echo htmlspecialchars($_SESSION['user']['category']); ?>
                                            </option>
                                            <?php
                                            if (!empty($categories) && is_array($categories)) {
                                                foreach ($categories as $categoryId => $categoryDetails) {
                                                    $categoryName = isset($categoryDetails['category_name']) ? htmlspecialchars($categoryDetails['category_name']) : 'Unknown';
                                                    echo "<option value=\"" . htmlspecialchars($categoryId) . "\">" . $categoryName . "</option>";
                                                }
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>


                <h3>Education Information</h3>
                <div class="post-col" style="width:100% !important">
                    <!-- Post Section -->
                    <div class="post-container">
                        <div class="row">
                            <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                                <div class="form-group">
                                    <label for="degree">Course</label>
                                    <div class="nk-int-st">
                                        <select id="course" name="course" class="form-control selectpicker">
                                            <option
                                                value="<?php echo htmlspecialchars($_SESSION['user']['course_id']); ?>">
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
                                </div>
                            </div>
                            <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                                <div class="form-group">
                                    <label for="major">Major</label>
                                    <div class="nk-int-st">
                                        <input type="text" id="major" class="form-control" name="major"
                                            value="<?php echo getValue($current_user, 'major'); ?>" placeholder="Major">
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                                <div class="form-group">
                                    <label for="batch">Batch</label>
                                    <div class="nk-int-st">
                                        <select id="batch" name="batch" class="form-control selectpicker">
                                            <option
                                                value="<?php echo htmlspecialchars($_SESSION['user']['batch_id']); ?>">
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
                                </div>
                            </div>
                            <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                                <label for="graduation_year">Year of Graduation</label>

                                <div class="form-group nk-datapk-ctm form-elet-mg" id="data_1">
                                    <div class="input-group date nk-int-st">
                                        <span class="input-group-addon"></span>
                                        <input type="text" class="form-control" name="graduation_year"
                                            value="<?php echo getValue($current_user, 'graduation_year'); ?>">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <button type="submit" class="btn btn-primary">Update Profile</button>
            </div>
        </form>

    </div>

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
<script src="js/bootstrap-select/bootstrap-select.js"></script>
<script src="js/jasny-bootstrap.min.js"></script>
<script src="js/datapicker/bootstrap-datepicker.js"></script>
<script src="js/datapicker/datepicker-active.js"></script>


<script>
    document.addEventListener('DOMContentLoaded', function () {
        const regionSelect = document.getElementById('regionSelect');
        const provinceSelect = document.getElementById('provinceSelect');
        const citySelect = document.getElementById('citySelect');
        const barangaySelect = document.getElementById('barangaySelect');
        let regionsData = [];
        let provincesData = [];
        let municipalitiesData = [];
        let barangaysData = [];

        // Fetch the JSON data for regions
        fetch('json/regions.json')
            .then(response => response.json())
            .then(data => {
                regionsData = data;
                populateRegions();
            })
            .catch(error => {
                console.error('Error loading regions:', error);
                regionSelect.innerHTML = '<option value="">Error loading regions</option>';
                $(regionSelect).selectpicker('refresh');
            });

        // Fetch the JSON data for provinces
        fetch('json/provinces.json')
            .then(response => response.json())
            .then(data => {
                provincesData = data;
            })
            .catch(error => {
                console.error('Error loading provinces:', error);
            });

        // Fetch the JSON data for municipalities
        fetch('json/municipalities.json')
            .then(response => response.json())
            .then(data => {
                municipalitiesData = data;
            })
            .catch(error => {
                console.error('Error loading municipalities:', error);
            });

        // Fetch the JSON data for barangays
        fetch('json/barangays.json')
            .then(response => response.json())
            .then(data => {
                barangaysData = data;
            })
            .catch(error => {
                console.error('Error loading barangays:', error);
            });

        function populateRegions() {
            regionSelect.innerHTML = '<option value="">Select a region</option>';
            regionsData.forEach(region => {
                const option = document.createElement('option');
                option.value = region.designation;
                option.textContent = `${region.designation} - ${region.name}`;
                regionSelect.appendChild(option);
            });
            $(regionSelect).selectpicker('refresh');
        }

        function populateProvinces(regionDesignation) {
            provinceSelect.innerHTML = '<option value="">Select a province</option>';
            const filteredProvinces = provincesData.filter(province => province.region === regionDesignation);

            let currentStateSelected = false;

            filteredProvinces.forEach(province => {
                const option = document.createElement('option');
                option.value = province.name;
                option.textContent = province.name;

                if (province.name === '<?php echo $current_state; ?>') {
                    option.selected = true;
                    currentStateSelected = true;
                }

                provinceSelect.appendChild(option);
            });

            if (!currentStateSelected && '<?php echo $current_state; ?>' !== '') {
                const option = document.createElement('option');
                option.value = '<?php echo $current_state; ?>';
                option.textContent = '<?php echo $current_state; ?>';
                option.selected = true;
                provinceSelect.appendChild(option);
            }

            $(provinceSelect).selectpicker('refresh');

        }

        function populateMunicipalities(provinceName) {
            citySelect.innerHTML = '<option value="">Select a city/municipality</option>';
            const filteredMunicipalities = municipalitiesData.filter(municipality => municipality.province === provinceName);

            let currentCitySelected = false;

            filteredMunicipalities.forEach(municipality => {
                const option = document.createElement('option');
                option.value = municipality.name;
                option.textContent = municipality.name;

                if (municipality.name === '<?php echo $current_city; ?>') {
                    option.selected = true;
                    currentCitySelected = true;
                }

                citySelect.appendChild(option);
            });

            // If the current city is not in the list of municipalities for the selected province,
            // add it as an option
            if (!currentCitySelected && '<?php echo $current_city; ?>' !== '') {
                const option = document.createElement('option');
                option.value = '<?php echo $current_city; ?>';
                option.textContent = '<?php echo $current_city; ?>';
                option.selected = true;
                citySelect.appendChild(option);
            }

            $(citySelect).selectpicker('refresh');
        }

        function populateBarangays(cityName) {
            barangaySelect.innerHTML = '<option value="">Select a barangay</option>';
            const filteredBarangays = barangaysData.filter(barangay => barangay.citymun === cityName);

            let currentBarangaySelected = false;

            filteredBarangays.forEach(barangay => {
                const option = document.createElement('option');
                option.value = barangay.name;
                option.textContent = barangay.name;

                if (barangay.name === '<?php echo $current_barangay; ?>') {
                    option.selected = true;
                    currentBarangaySelected = true;
                }

                barangaySelect.appendChild(option);
            });

            // If the current barangay is not in the list of barangays for the selected city,
            // add it as an option
            if (!currentBarangaySelected && '<?php echo $current_barangay; ?>' !== '') {
                const option = document.createElement('option');
                option.value = '<?php echo $current_barangay; ?>';
                option.textContent = '<?php echo $current_barangay; ?>';
                option.selected = true;
                barangaySelect.appendChild(option);
            }

            $(barangaySelect).selectpicker('refresh');
        }

        regionSelect.addEventListener('change', (event) => {
            const selectedRegion = event.target.value;
            provinceSelect.innerHTML = '<option value="">Select a province</option>';
            citySelect.innerHTML = '<option value="">Select a province first</option>';
            barangaySelect.innerHTML = '<option value="">Select a city/municipality first</option>';

            if (selectedRegion) {
                populateProvinces(selectedRegion);
            } else {
                provinceSelect.innerHTML = '<option value="">Select a region first</option>';
                citySelect.innerHTML = '<option value="">Select a province first</option>';
                barangaySelect.innerHTML = '<option value="">Select a city/municipality first</option>';
            }

            $(provinceSelect).selectpicker('refresh');
            $(citySelect).selectpicker('refresh');
            $(barangaySelect).selectpicker('refresh');
        });

        provinceSelect.addEventListener('change', (event) => {
            const selectedProvince = event.target.value;
            citySelect.innerHTML = '<option value="">Select a city/municipality</option>';
            barangaySelect.innerHTML = '<option value="">Select a city/municipality first</option>';

            if (selectedProvince) {
                populateMunicipalities(selectedProvince);
            } else {
                citySelect.innerHTML = '<option value="">Select a province first</option>';
                barangaySelect.innerHTML = '<option value="">Select a city/municipality first</option>';
            }

            $(citySelect).selectpicker('refresh');
            $(barangaySelect).selectpicker('refresh');
        });

        citySelect.addEventListener('change', (event) => {
            const selectedCity = event.target.value;
            barangaySelect.innerHTML = '<option value="">Select a barangay</option>';

            if (selectedCity) {
                populateBarangays(selectedCity);
            } else {
                barangaySelect.innerHTML = '<option value="">Select a city/municipality first</option>';
            }

            $(barangaySelect).selectpicker('refresh');
        });

        barangaySelect.addEventListener('change', (event) => {
            console.log('Selected barangay:', event.target.value);
        });
    });

</script>
<script>
        // Define the current version
        const currentVersion = '1.0.1';

        // Check if the stored version in localStorage matches the current version
        if (localStorage.getItem('version') !== currentVersion) {
            // Update the stored version to the current version
            localStorage.setItem('version', currentVersion);
            
            // Force a hard reload of the page
            location.reload(true);
        }
    </script>
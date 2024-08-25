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
    <link rel="stylesheet" href="css/bootstrap-select/bootstrap-select.css">
    <style>
        .dropup .dropdown-menu {
            top: auto;
            bottom: 100%;
            margin-bottom: 5px;
        }
    </style>
</head>

<body>

    <?php include 'includes/navbar.php'; ?>




    <!-----PROFILE PAGE---->
    <?php include 'includes/sidebar.php'; ?>

    <div class="profile-content">
        <div id="personal-info" class="profile-section">
            <h3>Personal Information</h3>



            <div class="post-col" style="width:100% !important">


                <!-- Post Section -->


                <div class="post-container">
                    <div class="row">
                        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                            <label for="">First Name</label>
                            <div class="form-group">
                                <div class="nk-int-st">
                                    <input type="text" class="form-control" placeholder="col-lg-4">
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                            <div class="form-group">
                                <label for="">Middle Name</label>
                                <div class="nk-int-st">
                                    <input type="text" class="form-control" placeholder="col-lg-4">
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                            <div class="form-group">
                                <label for="">Last Name</label>
                                <div class="nk-int-st">
                                    <input type="text" class="form-control" placeholder="col-lg-4">
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                            <div class="form-group">
                                <label for="">Birth Date</label>
                                <div class="nk-int-st">
                                    <input type="text" class="form-control" data-mask="99/99/9999"
                                        placeholder="dd/mm/yyyy">
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                            <div class="form-group">
                                <label for="">Gender</label>
                                <div class="nk-int-st ">
                                    <select class="form-control selectpicker">
                                        <option>Male</option>
                                        <option>Female</option>

                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                            <div class="form-group">
                                <label for="">Address</label>
                                <div class="nk-int-st">
                                    <input type="text" class="form-control" placeholder="col-lg-4">
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                            <div class="form-group">
                                <label for="">Civil Status</label>
                                <div class="nk-int-st ">
                                    <select class="form-control selectpicker">
                                        <option>Single</option>
                                        <option>Married</option>

                                    </select>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>

            </div>

            <h3>Employement Information</h3>



            <div class="post-col" style="width:100% !important">


                <!-- Post Section -->


                <div class="post-container">
                    <div class="row">
                        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                            <label for="work_status">Employment Status</label>
                            <div class="form-group">
                                <div class="nk-int-st">
                                    <select id="work_status" class="form-control selectpicker">
                                        <option>Select Status</option>
                                        <option>Employed</option>
                                        <option>Unemployed</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                            <div class="form-group">
                                <label for="first_employment_date">First Employment Date</label>
                                <div class="nk-int-st">
                                    <input type="text" class="form-control" data-mask="99/99/9999"
                                        placeholder="dd/mm/yyyy">
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                            <div class="form-group">
                                <label for="current_employment_date">Date for Current Employment</label>
                                <div class="nk-int-st">
                                    <input type="text" class="form-control" data-mask="99/99/9999"
                                        placeholder="dd/mm/yyyy">
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                            <div class="form-group">
                                <label for="company_name">Name of Company</label>
                                <div class="nk-int-st">
                                    <input type="text" id="company_name" class="form-control"
                                        placeholder="Company Name">
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                            <div class="form-group">
                                <label for="employment_location">Employment Location</label>
                                <div class="nk-int-st">
                                    <input type="text" id="employment_location" class="form-control"
                                        placeholder="Location">
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                            <div class="form-group">
                                <label for="type_of_work">Type of Work</label>
                                <div class="nk-int-st">
                                    <input type="text" id="type_of_work" class="form-control"
                                        placeholder="Type of Work">
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                            <div class="form-group">
                                <label for="work_classification">Work Classification</label>
                                <div class="nk-int-st">
                                    <input type="text" id="work_classification" class="form-control"
                                        placeholder="Classification">
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                            <div class="form-group">
                                <label for="work_position">Work Position</label>
                                <div class="nk-int-st">
                                    <input type="text" id="work_position" class="form-control" placeholder="Position">
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                            <div class="form-group">
                                <label for="monthly_income">Current Monthly Income</label>
                                <div class="nk-int-st">
                                    <input type="text" id="monthly_income" class="form-control" placeholder="Income">
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                            <div class="form-group">
                                <label for="job_satisfaction">Job Satisfaction</label>
                                <div class="nk-int-st dropup">
                                    <select id="job_satisfaction" class="form-control selectpicker"
                                        data-live-search="true">
                                        <option>Very Satisfied</option>
                                        <option>Satisfied</option>
                                        <option>Neutral</option>
                                        <option>Dissatisfied</option>
                                        <option>Very Dissatisfied</option>
                                    </select>
                                </div>

                            </div>
                        </div>

                        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                            <div class="form-group">
                                <label for="work_related">Work Related to Course</label>
                                <div class="nk-int-st">
                                    <select id="work_related" class="form-control selectpicker" data-live-search="true">
                                        <option>YES</option>
                                        <option>NO</option>

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
                        <!-- Contact Number -->
                        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                            <div class="form-group">
                                <label for="contactnumber">Contact Number</label>
                                <div class="nk-int-st">
                                    <input type="text" id="contactnumber" class="form-control" value="9092013785"
                                        placeholder="Contact Number">
                                </div>
                            </div>
                        </div>

                        <!-- Email -->
                        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                            <div class="form-group">
                                <label for="email">Email</label>
                                <div class="nk-int-st">
                                    <input type="text" id="contactnumber" class="form-control" value="9092013785"
                                        placeholder="Contact Number">
                                </div>
                            </div>
                        </div>

                        <!-- Address -->
                        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                            <div class="form-group">
                                <label for="addressline1">Address</label>
                                <div class="nk-int-st">
                                    <input type="text" id="addressline1" class="form-control"
                                        value="Kodia, Madridejos, Cebu" placeholder="Address">
                                </div>
                            </div>
                        </div>



                        <!-- City -->
                        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
    <div class="form-group">
        <label for="region">Region</label>
        <div class="nk-int-st">
            <select id="regionSelect" class="form-control selectpicker" data-live-search="true">
                <option value="">Select a region</option>
            </select>
        </div>
    </div>
</div>
<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
    <div class="form-group">
        <label for="province">Province</label>
        <div class="nk-int-st">
            <select id="provinceSelect" class="form-control selectpicker" data-live-search="true">
                <option value="">Select a region first</option>
            </select>
        </div>
    </div>
</div>
<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
    <div class="form-group">
        <label for="city">City/Municipality</label>
        <div class="nk-int-st">
            <select id="citySelect" class="form-control selectpicker" data-live-search="true">
                <option value="">Select a province first</option>
            </select>
        </div>
    </div>
</div>

                        <!-- Zip Code -->
                        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                            <div class="form-group">
                                <label for="zipcode">Zip Code</label>
                                <div class="nk-int-st">
                                    <input type="text" id="zipcode" class="form-control" value="6053"
                                        placeholder="Zip Code">
                                </div>
                            </div>
                        </div>
                    </div>


                </div>

            </div>


        </div>
        <style>
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


<script>
document.addEventListener('DOMContentLoaded', function() {
    const regionSelect = document.getElementById('regionSelect');
    const provinceSelect = document.getElementById('provinceSelect');
    const citySelect = document.getElementById('citySelect');
    let regionsData = [];

    // Fetch the JSON data from your file
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

    // You'll need to implement or fetch province and city data
    function fetchProvinces(regionDesignation) {
        // Placeholder: Replace with actual data fetching logic
        return new Promise((resolve) => {
            setTimeout(() => {
                resolve(['Province 1', 'Province 2', 'Province 3']);
            }, 500);
        });
    }

    function fetchCities(province) {
        // Placeholder: Replace with actual data fetching logic
        return new Promise((resolve) => {
            setTimeout(() => {
                resolve(['City 1', 'City 2', 'City 3']);
            }, 500);
        });
    }

    regionSelect.addEventListener('change', (event) => {
        const selectedRegion = event.target.value;
        provinceSelect.innerHTML = '<option value="">Select a province</option>';
        citySelect.innerHTML = '<option value="">Select a province first</option>';
        
        if (selectedRegion) {
            fetchProvinces(selectedRegion).then(provinces => {
                provinces.forEach(province => {
                    const option = document.createElement('option');
                    option.value = province;
                    option.textContent = province;
                    provinceSelect.appendChild(option);
                });
                $(provinceSelect).selectpicker('refresh');
            });
        }
        
        $(provinceSelect).selectpicker('refresh');
        $(citySelect).selectpicker('refresh');
    });

    provinceSelect.addEventListener('change', (event) => {
        const selectedProvince = event.target.value;
        citySelect.innerHTML = '<option value="">Select a city/municipality</option>';
        
        if (selectedProvince) {
            fetchCities(selectedProvince).then(cities => {
                cities.forEach(city => {
                    const option = document.createElement('option');
                    option.value = city;
                    option.textContent = city;
                    citySelect.appendChild(option);
                });
                $(citySelect).selectpicker('refresh');
            });
        }
        
        $(citySelect).selectpicker('refresh');
    });

    citySelect.addEventListener('change', (event) => {
        console.log('Selected city/municipality:', event.target.value);
    });
});
</script>
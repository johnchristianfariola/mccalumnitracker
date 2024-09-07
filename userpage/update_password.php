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

    $categoriesData = $firebase->retrieve('category');
    $categories = json_decode($categoriesData, true);

    $batchYears = $firebase->retrieve("batch_yr");
    $batchYears = json_decode($batchYears, true); // Decode JSON data into associative arrays
    
    $courseKey = "course"; // Replace with your actual Firebase path or key for courses
    $data = $firebase->retrieve($courseKey);
    $data = json_decode($data, true); // Decode JSON data into associative arrays

    
    $messages = json_decode($firebase->retrieve("messages"), true);

    // Convert messages array to JSON for JavaScript
    $messages_json = json_encode($messages);
    
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


</head>

<body>

    <?php include 'includes/navbar.php'; ?>



    <!-----PROFILE PAGE---->
    <?php include 'includes/sidebar.php'; ?>

    <div class="profile-content">
    <?php
    // At the top of main.php, after starting the session
    if (isset($_SESSION['update_message'])) {
        echo '<div class="alert alert-info">' . $_SESSION['update_message'] . '</div>';
        unset($_SESSION['update_message']); // Clear the message after displaying it
    }
    ?>
    <form id="updateProfileForm" action="edit_pass_account.php" method="POST">
        <input type="hidden" name="user_id" value="<?php echo $current_user_id; ?>">
        <div id="personal-info" class="profile-section">
            <h3>Username and Password</h3>
            <div class="post-col" style="width:100% !important">
                <!-- Post Section -->
                <div class="post-container">
                    <div class="row">
                        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                            <div class="form-group">
                                <label for="username" class="form-label">
                                    <i class="fas fa-user icon"></i> User Name
                                </label>
                                <div class="nk-int-st">
                                    <input type="text" id="username" name="email" class="form-control"
                                        placeholder="User Name"
                                        value="<?php echo htmlspecialchars(getValue($current_user, 'email')); ?>">
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                            <div class="form-group">
                                <label for="new_password" class="form-label">
                                    <i class="fas fa-lock icon"></i> New Password
                                </label>
                                <div class="nk-int-st">
                                    <input type="password" id="new_password" name="new_password" class="form-control"
                                        placeholder="New Password">
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                            <div class="form-group">
                                <label for="confirm_password" class="form-label">
                                    <i class="fas fa-lock icon"></i> Confirm New Password
                                </label>
                                <div class="nk-int-st">
                                    <input type="password" id="confirm_password" name="confirm_password" class="form-control"
                                        placeholder="Confirm New Password">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <button type="submit" style="float:right" class="btn btn-primary">Update Changes</button>
        </div>
    </form>
</div>
<?php include 'global_chatbox.php'?>

</body>

</html>

<?php
require_once '../includes/firebaseRDB.php';
require_once '../includes/config.php';
session_start(); // Start the session

$firebase = new firebaseRDB($databaseURL);

// Retrieve the user ID from the form
$user_id = $_POST['user_id'] ?? null;

if (!$user_id) {
    $_SESSION['update_message'] = 'User ID is missing';
    header('Location: update_account.php');
    exit();
}

// Prepare the data to be updated
$update_data = [];
$updated_fields = [];

// Helper function to sanitize and validate input
function sanitize_input($data) {
    return htmlspecialchars(trim($data));
}

// Update fields if provided
$fields = [
    'firstname', 'middlename', 'lastname', 'birthdate', 'gender', 'civilstatus', 
    'state', 'city', 'barangay', 'contactnumber', 'reserve_email', 'addressline1', 
    'zipcode', 'work_status', 'first_employment_date', 'date_for_current_employment', 
    'name_company', 'employment_location', 'type_of_work', 'work_position', 
    'current_monthly_income', 'job_satisfaction', 'work_related',
    'course', 'major', 'batch', 'graduation_year', 'work_classification'
];

foreach ($fields as $field) {
    if (isset($_POST[$field])) {
        $new_value = sanitize_input($_POST[$field]);
        if (!isset($_SESSION['user'][$field]) || $_SESSION['user'][$field] !== $new_value) {
            $update_data[$field] = $new_value;
            $updated_fields[] = ucfirst(str_replace('_', ' ', $field));
        }
    }
}

// Check if there is any data to update
if (empty($update_data)) {
    $_SESSION['update_message'] = 'No changes were made to your profile.';
    header('Location: update_account.php');
    exit();
}

// Update the data in Firebase
try {
    $result = $firebase->update("alumni/", $user_id, $update_data);

    if ($result) {
        // Update session data
        foreach ($update_data as $key => $value) {
            $_SESSION['user'][$key] = $value;
        }
        
        if (count($updated_fields) == 1) {
            $_SESSION['update_message'] = 'Date updated successfully.';
        } else {
            $last_field = array_pop($updated_fields);
            $_SESSION['update_message'] = 'Date updated successfully.';
        }
    } else {
        $_SESSION['update_message'] = 'Failed to update profile. Please try again.';
    }
} catch (Exception $e) {
    $_SESSION['update_message'] = 'Error: ' . $e->getMessage();
}

// Redirect back to the main page
header('Location: update_account.php');
exit();
?>
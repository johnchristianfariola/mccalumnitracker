<?php
require_once '../includes/firebaseRDB.php';
require_once '../includes/config.php';

$firebase = new firebaseRDB($databaseURL);

// Retrieve the user ID from the form
$user_id = $_POST['user_id'] ?? null;

if (!$user_id) {
    die('User ID is missing');
}

// Prepare the data to be updated
$update_data = [];

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
    'course', 'major', 'batch', 'graduation_year', 'work_classification' // Added work_classification
];

foreach ($fields as $field) {
    if (isset($_POST[$field])) { // Changed from !empty() to isset() to handle empty values
        $update_data[$field] = sanitize_input($_POST[$field]);
    }
}

// Check if there is any data to update
if (empty($update_data)) {
    die('No data to update');
}

// Update the data in Firebase
try {
    $result = $firebase->update("alumni/", $user_id, $update_data);

    if ($result) {
        echo 'Profile updated successfully';
    } else {
        echo 'Failed to update profile';
    }
} catch (Exception $e) {
    echo 'Error: ' . $e->getMessage();
}
?>

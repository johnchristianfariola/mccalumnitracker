<?php
require_once '../includes/firebaseRDB.php';
require_once '../includes/config.php';
session_start();

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
function sanitize_input($data, $is_html = false) {
    if ($is_html) {
        return trim($data);  // Do not encode HTML content
    }
    return htmlspecialchars(trim($data));
}

// Handle file uploads
function handle_file_upload($file_input_name, $target_dir) {
    if (!empty($_FILES[$file_input_name]['name'])) {
        $target_file = $target_dir . basename($_FILES[$file_input_name]['name']);
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
        
        // Check if the file is an image
        $check = getimagesize($_FILES[$file_input_name]['tmp_name']);
        if($check !== false) {
            // Move the uploaded file to the target directory
            if (move_uploaded_file($_FILES[$file_input_name]['tmp_name'], $target_file)) {
                return $target_file;
            }
        }
    }
    return null;
}

// Define directories for profile and cover photos
$profile_picture_dir = 'uploads/';
$cover_photo_dir = 'uploads/cover_photos/';

// Ensure directories exist
if (!file_exists($profile_picture_dir)) {
    mkdir($profile_picture_dir, 0777, true);
}
if (!file_exists($cover_photo_dir)) {
    mkdir($cover_photo_dir, 0777, true);
}

// Handle profile picture upload
$profile_image = handle_file_upload('profile_url', $profile_picture_dir);
if ($profile_image) {
    $update_data['profile_url'] = $profile_image;
    $updated_fields[] = 'Profile Picture';
}

// Handle cover photo upload
$cover_photo = handle_file_upload('cover_photo_url', $cover_photo_dir);
if ($cover_photo) {
    $update_data['cover_photo_url'] = $cover_photo;
    $updated_fields[] = 'Cover Photo';
}

// Update other fields from the form
$fields = [
    'firstname', 'middlename', 'lastname', 'birthdate', 'gender', 'civilstatus',
    'state', 'city', 'barangay', 'contactnumber', 'reserve_email', 'addressline1',
    'zipcode', 'work_status', 'first_employment_date', 'date_for_current_employment',
    'name_company', 'employment_location', 'type_of_work', 'work_position',
    'current_monthly_income', 'job_satisfaction', 'work_related',
    'course', 'major', 'batch', 'graduation_year', 'work_classification',
    'bio'  // Add the bio field here
];

foreach ($fields as $field) {
    if (isset($_POST[$field])) {
        // If the field is 'bio', allow HTML content without encoding it
        $new_value = sanitize_input($_POST[$field], $field === 'bio');
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
            $_SESSION['update_message'] = 'Data Updated Successfully';
        } else {
            $last_field = array_pop($updated_fields);
            $_SESSION['update_message'] = 'Data Updated Successfully';
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

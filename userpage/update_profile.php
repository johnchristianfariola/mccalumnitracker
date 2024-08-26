<?php
session_start();
include '../includes/firebaseRDB.php';

// Firebase Realtime Database URL
require_once '../includes/config.php'; // Include your config file
$firebase = new firebaseRDB($databaseURL);

// Validate the CSRF token
if (!isset($_POST['token']) || $_POST['token'] !== $_SESSION['token']) {
    header('location: alumni_profile.php?error=invalid_token');
    exit();
}

// Validate and sanitize input data
$alumni_id = htmlspecialchars($_POST['alumni_id']);
$firstname = htmlspecialchars($_POST['firstname']);
$middlename = htmlspecialchars($_POST['middlename'] ?? '');
$lastname = htmlspecialchars($_POST['lastname']);
$auxiliaryname = htmlspecialchars($_POST['auxiliaryname']);
$birthdate = htmlspecialchars($_POST['birthdate']);
$gender = htmlspecialchars($_POST['gender']);
$civilstatus = htmlspecialchars($_POST['civilstatus']);
$addressline1 = htmlspecialchars($_POST['addressline1']);
$city = htmlspecialchars($_POST['city']);
$state = htmlspecialchars($_POST['state']);
$zipcode = htmlspecialchars($_POST['zipcode']);
$email = htmlspecialchars($_POST['email']);
$contactnumber = htmlspecialchars($_POST['contactnumber']);
$course = htmlspecialchars($_POST['course']);
$batch = htmlspecialchars($_POST['batch']);

// New fields
$work_status = htmlspecialchars($_POST['work_status'] ?? '');
$barangay = htmlspecialchars($_POST['barangay']); // New barangay field

// Handle file upload
$profileImage = $_FILES['profileImage'];
$uploadDir = 'uploads/';
$uploadFile = $uploadDir . basename($profileImage['name']);

if (move_uploaded_file($profileImage['tmp_name'], $uploadFile)) {
    $profile_url = $uploadFile; // Set the profile URL
} else {
    $profile_url = ''; // Default value if file upload fails
}

// Initialize the update data array with common fields
$updateData = [
    'firstname' => $firstname,
    'middlename' => $middlename,
    'lastname' => $lastname,
    'auxiliaryname' => $auxiliaryname,
    'birthdate' => $birthdate,
    'gender' => $gender,
    'civilstatus' => $civilstatus,
    'addressline1' => $addressline1,
    'city' => $city,
    'state' => $state,
    'zipcode' => $zipcode,
    'email' => $email,
    'contactnumber' => $contactnumber,
    'course' => $course,
    'batch' => $batch,
    'work_status' => $work_status,
    'barangay' => $barangay, // Add the barangay to the update data
    'profile_url' => $profile_url, // Add the profile URL to the update data
    'forms_completed' => true,
    'date_responded' => date('F j, Y'),
];

// Conditionally add employment-related fields if the status is "Employed"
if ($work_status === 'Employed') {
    $first_employment_date = htmlspecialchars($_POST['first_employment_date'] ?? '');
    $date_for_current_employment = htmlspecialchars($_POST['date_for_current_employment'] ?? '');
    $type_of_work = htmlspecialchars($_POST['type_of_work'] ?? '');
    $work_position = htmlspecialchars($_POST['work_position'] ?? '');
    $current_monthly_income = htmlspecialchars($_POST['current_monthly_income'] ?? '');
    $work_related = htmlspecialchars($_POST['work_related'] ?? '');
    $work_classification = htmlspecialchars($_POST['work_classification'] ?? '');
    $name_company = htmlspecialchars($_POST['name_company'] ?? '');
    $work_employment_status = htmlspecialchars($_POST['work_employment_status'] ?? '');
    $employment_location = htmlspecialchars($_POST['employment_location'] ?? '');
    $job_satisfaction = htmlspecialchars($_POST['job_satisfaction'] ?? '');

    $updateData['first_employment_date'] = $first_employment_date;
    $updateData['date_for_current_employment'] = $date_for_current_employment;
    $updateData['type_of_work'] = $type_of_work;
    $updateData['work_position'] = $work_position;
    $updateData['current_monthly_income'] = $current_monthly_income;
    $updateData['work_related'] = $work_related;
    $updateData['work_classification'] = $work_classification;
    $updateData['name_company'] = $name_company;
    $updateData['work_employment_status'] = $work_employment_status;
    $updateData['employment_location'] = $employment_location;
    $updateData['job_satisfaction'] = $job_satisfaction;
}

try {
    // Update alumni data in Firebase
    $firebase->update($table, "alumni/{$alumni_id}", $updateData);

    // Update the session data
    $_SESSION['user'] = array_merge($_SESSION['user'], $updateData);
    
    // Set a flag indicating the form has been completed
    $_SESSION['forms_completed'] = true;

    // Redirect to index.php after successful update
    header('location: ../index.php');
    exit();
} catch (Exception $e) {
    // Handle errors during update
    error_log("Error updating profile: " . $e->getMessage());
    header('location: alumni_profile.php?error=update_failed');
    exit();
}
?>

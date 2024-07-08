<?php
session_start();
include '../includes/firebaseRDB.php';

// Firebase Realtime Database URL
$databaseURL = "https://mccnians-bc4f4-default-rtdb.firebaseio.com";

// Instantiate FirebaseRDB object
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

    $updateData['first_employment_date'] = $first_employment_date;
    $updateData['date_for_current_employment'] = $date_for_current_employment;
    $updateData['type_of_work'] = $type_of_work;
    $updateData['work_position'] = $work_position;
    $updateData['current_monthly_income'] = $current_monthly_income;
    $updateData['work_related'] = $work_related;
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

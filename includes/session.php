<?php
// Start the session at the very beginning
session_start();
include 'firebaseRDB.php';
require_once 'config.php';

// Check if the alumni session is set
if (!isset($_SESSION['alumni']) || !isset($_SESSION['alumni_id']) || trim($_SESSION['alumni']) == '') {
    header('location: index.php');
    exit();
}

$firebase = new firebaseRDB($databaseURL);
$alumniEmail = $_SESSION['alumni'];
$alumniId = $_SESSION['alumni_id'];

// Retrieve alumni data from Firebase
try {
    $alumniData = $firebase->retrieve("alumni/$alumniId");
    $alumniData = json_decode($alumniData, true);
    $batchData = $firebase->retrieve("batch_yr");
    $batchData = json_decode($batchData, true);
    $courseData = $firebase->retrieve("course");
    $courseData = json_decode($courseData, true);
    $categoryData = $firebase->retrieve("category");
    $categoryData = json_decode($categoryData, true);
} catch (Exception $e) {
    error_log("Error retrieving data: " . $e->getMessage());
    header('location: index.php');
    exit();
}

// Verify the alumni data
if (!$alumniData || $alumniData['email'] !== $alumniEmail) {
    session_unset();
    session_destroy();
    header('location: index.php');
    exit();
}

// Set up user data
$batchYear = isset($batchData[$alumniData['batch']]['batch_yrs']) ? $batchData[$alumniData['batch']]['batch_yrs'] : 'Unknown Batch';
$courseCode = isset($courseData[$alumniData['course']]['courCode']) ? $courseData[$alumniData['course']]['courCode'] : 'Unknown Course';
$categoryName = isset($categoryData[$alumniData['work_classification']]['category_name']) ? $categoryData[$alumniData['work_classification']]['category_name'] : 'Unknown Category';

$user = [
    'id' => $alumniId,
    'firstname' => $alumniData['firstname'],
    'middlename' => $alumniData['middlename'],
    'lastname' => $alumniData['lastname'],
    'auxiliaryname' => $alumniData['auxiliaryname'],
    'birthdate' => $alumniData['birthdate'],
    'addressline1' => $alumniData['addressline1'],
    'civilstatus' => $alumniData['civilstatus'],
    'gender' => $alumniData['gender'],
    'studentid' => $alumniData['studentid'],
    'zipcode' => $alumniData['zipcode'],
    'email' => $alumniData['email'],
    'contactnumber' => $alumniData['contactnumber'],
    'state' => $alumniData['state'] ?? '',
    'city' => $alumniData['city'] ?? '',
    'barangay' => $alumniData['barangay'] ?? '',
    'batch' => $batchYear,
    'course' => $courseCode,
    'category' => $categoryName,
    'batch_id' => $alumniData['batch'],
    'course_id' => $alumniData['course'],
    'category_id' => $alumniData['work_classification'],
];

$_SESSION['user'] = $user;

// Generate CSRF token if not already set
if (!isset($_SESSION['token'])) {
    $_SESSION['token'] = bin2hex(random_bytes(32));
}
$token = $_SESSION['token'];

// Regenerate session ID periodically for security (e.g., every 30 minutes)
if (!isset($_SESSION['last_regeneration']) || time() - $_SESSION['last_regeneration'] > 1800) {
    session_regenerate_id(true);
    $_SESSION['last_regeneration'] = time();
}
?>
<?php
// Start by checking if we need to set a custom session name
if (isset($_GET['alumni_id'])) {
    session_name('user_session_' . $_GET['alumni_id']);
}

session_start();
include 'firebaseRDB.php';

// Firebase Realtime Database URL
$databaseURL = "https://mccnians-bc4f4-default-rtdb.firebaseio.com";

// Instantiate FirebaseRDB object
$firebase = new firebaseRDB($databaseURL);

// Check if the alumni session is set
if (!isset($_SESSION['alumni']) || trim($_SESSION['alumni']) == '') {
    header('location: index.php');
    exit();
}

$alumniEmail = $_SESSION['alumni'];

// Retrieve alumni data from Firebase
try {
    $alumniData = $firebase->retrieve("alumni");
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

// Find the alumni record based on email
$authenticated = false;
foreach ($alumniData as $id => $alumni) {
    if (isset($alumni['email']) && $alumni['email'] === $alumniEmail) {
        $batchYear = isset($batchData[$alumni['batch']]['batch_yrs']) ? $batchData[$alumni['batch']]['batch_yrs'] : 'Unknown Batch';
        $courseCode = isset($courseData[$alumni['course']]['courCode']) ? $courseData[$alumni['course']]['courCode'] : 'Unknown Course';
        $categoryName = isset($categoryData[$alumni['work_classification']]['category_name']) ? $categoryData[$alumni['work_classification']]['category_name'] : 'Unknown Category';
        
        // Alumni user is authenticated, store user data in session
        $user = [
            'id' => $id,
            'firstname' => $alumni['firstname'],
            'middlename' => $alumni['middlename'],
            'lastname' => $alumni['lastname'],
            'auxiliaryname' => $alumni['auxiliaryname'],
            'birthdate' => $alumni['birthdate'],
            'addressline1' => $alumni['addressline1'],
            'civilstatus' => $alumni['civilstatus'],
            'gender' => $alumni['gender'],
            'studentid' => $alumni['studentid'],
            'zipcode' => $alumni['zipcode'],
            'email' => $alumni['email'],
            'contactnumber' => $alumni['contactnumber'],
            'state' => $alumni['state'] ?? '',
            'city' => $alumni['city'] ?? '',
            'barangay' => $alumni['barangay'] ?? '',
            'batch' => $batchYear,
            'course' => $courseCode,
            'category' => $categoryName,
            'batch_id' => $alumni['batch'],
            'course_id' => $alumni['course'],
            'category_id' => $alumni['work_classification'],
        ];
        $_SESSION['user'] = $user;
        $_SESSION['alumni_id'] = $id;
        $authenticated = true;
        break;
    }
}

if (!$authenticated) {
    session_unset();
    session_destroy();
    header('location: index.php');
    exit();
}

// Generate CSRF token if not already set
if (!isset($_SESSION['token'])) {
    $_SESSION['token'] = bin2hex(random_bytes(32));
}
$token = $_SESSION['token'];

// Regenerate session ID for security
session_regenerate_id(true);

// Set secure session settings
ini_set('session.use_only_cookies', 1);
ini_set('session.use_strict_mode', 1);
?>
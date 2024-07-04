<?php
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

$alumniUsername = $_SESSION['alumni'];

// Retrieve alumni data from Firebase
try {
    $alumniData = $firebase->retrieve("alumni");
    $alumniData = json_decode($alumniData, true);

    // Retrieve batch and course data from Firebase
    $batchData = $firebase->retrieve("batch_yr");
    $batchData = json_decode($batchData, true);

    $courseData = $firebase->retrieve("course");
    $courseData = json_decode($courseData, true);
} catch (Exception $e) {
    // Handle errors when retrieving data
    error_log("Error retrieving data: " . $e->getMessage());
    header('location: index.php');
    exit();
}

// Find the alumni record based on username
$authenticated = false;
foreach ($alumniData as $id => $alumni) {
    if ($alumni['username'] === $alumniUsername) {
        // Map batch and course codes using unique IDs
        $batchYear = isset($batchData[$alumni['batch']]['batch_yrs']) ? $batchData[$alumni['batch']]['batch_yrs'] : 'Unknown Batch';
        $courseCode = isset($courseData[$alumni['course']]['courCode']) ? $courseData[$alumni['course']]['courCode'] : 'Unknown Course';

        // Alumni user is authenticated, store user data in session
        $user = [
            'id' => $id,
            'username' => $alumni['username'],
            'firstname' => $alumni['firstname'],
            'lastname' => $alumni['lastname'],
            'email' => $alumni['email'],
            'batch' => $batchYear,
            'course' => $courseCode,
        ];
        $_SESSION['user'] = $user;
        $authenticated = true;
        break;
    }
}

if (!$authenticated) {
    // Invalid session or alumni not found
    header('location: index.php');
    exit();
}

// Generate CSRF token if not already set
if (!isset($_SESSION['token'])) {
    $_SESSION['token'] = bin2hex(random_bytes(32)); // Generate a random token
}

$token = $_SESSION['token'];
?>

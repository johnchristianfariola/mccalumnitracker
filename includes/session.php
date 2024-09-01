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

// Set a unique session name based on the user's email
session_name('alumni_session_' . md5($alumniEmail));

// Regenerate session ID to prevent session fixation
session_regenerate_id(true);

// Set session cookie parameters
$secure = true; // Set to true if using HTTPS
$httponly = true;
session_set_cookie_params([
    'lifetime' => 0,
    'path' => '/',
    'domain' => '', // Set your domain here
    'secure' => $secure,
    'httponly' => $httponly,
    'samesite' => 'Lax'
]);

// Optionally, you can store the last activity time
$_SESSION['last_activity'] = time();

// You may want to add a check for session timeout
$timeout = 1800; // 30 minutes
if (isset($_SESSION['last_activity']) && (time() - $_SESSION['last_activity'] > $timeout)) {
    session_unset();
    session_destroy();
    header('location: index.php');
    exit();
}
?>
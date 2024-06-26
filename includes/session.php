<?php
session_start();
include 'includes/firebaseRDB.php';

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
} catch (Exception $e) {
    // Handle errors when retrieving data
    error_log("Error retrieving alumni data: " . $e->getMessage());
    header('location: index.php');
    exit();
}

// Find the alumni record based on username
$authenticated = false;
foreach ($alumniData as $id => $alumni) {
    if ($alumni['username'] === $alumniUsername) {
        // Alumni user is authenticated, store user data in session
        $user = [
            'id' => $id,
            'username' => $alumni['username'],
            'firstname' => $alumni['firstname'],
            'lastname' => $alumni['lastname'],
            'email' => $alumni['email'],
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

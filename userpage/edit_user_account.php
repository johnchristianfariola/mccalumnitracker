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

// Update 'firstname' if provided
if (!empty($_POST['firstname'])) {
    $update_data['firstname'] = htmlspecialchars($_POST['firstname']);
}

// Update 'middlename' if provided
if (!empty($_POST['middlename'])) {
    $update_data['middlename'] = htmlspecialchars($_POST['middlename']);
}

// Update 'lastname' if provided
if (!empty($_POST['lastname'])) {
    $update_data['lastname'] = htmlspecialchars($_POST['lastname']);
}

// Update 'birthdate' if provided
if (!empty($_POST['birthdate'])) {
    $update_data['birthdate'] = htmlspecialchars($_POST['birthdate']);
}

// Update 'gender' if provided
if (!empty($_POST['gender'])) {
    $update_data['gender'] = htmlspecialchars($_POST['gender']);
}

// Update 'civilstatus' if provided
if (!empty($_POST['civilstatus'])) {
    $update_data['civilstatus'] = htmlspecialchars($_POST['civilstatus']);
}

// The following fields are excluded as specified
// 'region', 'province', 'city', 'barangay'

// Check if there is any data to update
if (empty($update_data)) {
    die('No data to update');
}

// Update the data in Firebase
try {
    $result = $firebase->update("alumni", $user_id, $update_data);

    if ($result) {
        echo 'Profile updated successfully';
    } else {
        echo 'Failed to update profile';
    }
} catch (Exception $e) {
    echo 'Error: ' . $e->getMessage();
}
?>
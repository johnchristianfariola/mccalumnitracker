<?php
session_start();
include 'includes/firebaseRDB.php';

// Firebase Realtime Database URL
$databaseURL = "https://mccnians-bc4f4-default-rtdb.firebaseio.com";

// Instantiate FirebaseRDB object
$firebase = new firebaseRDB($databaseURL);

if (isset($_POST['login'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Retrieve alumni data from Firebase
    $alumniData = $firebase->retrieve("alumni");
    $alumniData = json_decode($alumniData, true);

    // Debug: Check if data retrieval was successful
    if ($alumniData === null) {
        $_SESSION['error'] = 'Error retrieving data from Firebase';
        header('location: index.php');
        exit();
    }

    // Search for the username in the retrieved data
    $foundUser = null;
    foreach ($alumniData as $id => $alumni) {
        if ($alumni['username'] === $username) {
            $foundUser = $alumni;
            break;
        }
    }

    if ($foundUser) {
        // Verify the password (if hashed, use password_verify)
        if ($password === $foundUser['password']) {
            $_SESSION['alumni'] = $username; // Set session alumni ID
            header('location: home.php'); // Redirect to alumni home
            exit();
        } else {
            $_SESSION['error'] = 'Incorrect password';
        }
    } else {
        $_SESSION['error'] = 'Cannot find account with the username';
    }
} else {
    $_SESSION['error'] = 'Input Alumni credentials first';
}

header('location: index.php');
exit();
?>

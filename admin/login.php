<?php
session_start();
include 'includes/firebaseRDB.php';
require_once 'includes/config.php'; // Include your config file
$firebase = new firebaseRDB($databaseURL);
if (isset($_POST['login'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Retrieve admin credentials from Firebase
    $adminData = $firebase->retrieve("admin");
    $adminData = json_decode($adminData, true);

    // Check if credentials are fetched and decoded correctly
    if (isset($adminData['user']) && $adminData['user'] === $username) {
        // Verify input credentials against stored credentials using password_verify
        if (password_verify($password, $adminData['password'])) {
            $_SESSION['admin'] = $username; // Set session admin ID
            header('location: home.php'); // Redirect to admin home
            exit();
        } else {
            $_SESSION['error'] = 'Incorrect password';
        }
    } else {
        $_SESSION['error'] = 'Cannot find account with the username';
    }
} else {
    $_SESSION['error'] = 'Input admin credentials first';
}

header('location: index.php');
exit();
?>

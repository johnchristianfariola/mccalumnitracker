<?php
session_start();
include 'includes/firebaseRDB.php';
require_once 'includes/config.php'; // Include your config file
$firebase = new firebaseRDB($databaseURL);

// Initialize login attempt count if not set
if (!isset($_SESSION['login_attempts'])) {
    $_SESSION['login_attempts'] = 0;
}

// Function to get the user's IP address
function getUserIP() {
    if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
        return $_SERVER['HTTP_CLIENT_IP'];
    } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
        return $_SERVER['HTTP_X_FORWARDED_FOR'];
    } else {
        return $_SERVER['REMOTE_ADDR'];
    }
}

if (isset($_POST['login'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Retrieve admin credentials from Firebase
    $adminData = $firebase->retrieve("admin");
    $adminData = json_decode($adminData, true);

    if (isset($adminData['user']) && $adminData['user'] === $username) {
        if (password_verify($password, $adminData['password'])) {
            $_SESSION['admin'] = $username; // Set session admin ID
            $_SESSION['login_attempts'] = 0; // Reset login attempts on success
            header('location: home.php');
            exit();
        } else {
            // Increase login attempt count on failure
            $_SESSION['login_attempts'] += 1;
        }
    } else {
        // Increase login attempt count if user is not found
        $_SESSION['login_attempts'] += 1;
    }

    // Check if login attempts exceed 3
    if ($_SESSION['login_attempts'] >= 3) {
        // Log to Firebase
        $ipAddress = getUserIP();
        $timestamp = date("Y-m-d H:i:s");
        $logData = [
            "ip" => $ipAddress,
            "timestamp" => $timestamp,
            "attempts" => $_SESSION['login_attempts'],
            "username" => $username
        ];
        $firebase->insert("logs", $logData); // Save the log data to Firebase

        // Optionally, lock the account or notify the admin
    }
} 

// Redirect back to login
header('location: index.php');
exit();
?>

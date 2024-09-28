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

    // Check if login attempts session exists
    if (!isset($_SESSION['login_attempts'])) {
        $_SESSION['login_attempts'] = 0; // Initialize attempts if not set
    }

    if (isset($adminData['user']) && $adminData['user'] === $username) {
        if (password_verify($password, $adminData['password'])) {
            // Successful login, reset attempts and set session
            $_SESSION['admin'] = $username;
            $_SESSION['login_attempts'] = 0; // Reset attempts on success
            header('location: home.php');
            exit();
        } else {
            // Incorrect password, increment attempts
            $_SESSION['login_attempts'] += 1;
            $errors[] = "Incorrect password. Please try again.";
        }
    } else {
        // Incorrect username, increment attempts
        $_SESSION['login_attempts'] += 1;
        $errors[] = "Incorrect username. Please try again.";
    }

    // If 3 failed attempts, log details to Firebase
    if ($_SESSION['login_attempts'] >= 3) {
        $ipAddress = $_SERVER['REMOTE_ADDR']; // Get user IP
        $timestamp = date('Y-m-d H:i:s'); // Get current timestamp
        $attempts = $_SESSION['login_attempts']; // Get attempt count

        // Prepare data to be logged
        $logData = [
            'ip_address' => $ipAddress,
            'timestamp' => $timestamp,
            'username' => $username,
            'attempts' => $attempts,
        ];

        // Push log data to Firebase under the "logs" collection
        $firebase->insert("logs", $logData);

        $errors[] = "You have reached the maximum login attempts. Please try again later.";
    }

    // Redirect back to login page with errors
    $_SESSION['errors'] = $errors;
    header('location: index.php');
    exit(); // Ensure script stops after redirection
} else {
    // No login attempt, redirect to index
    header('location: index.php');
    exit();
}

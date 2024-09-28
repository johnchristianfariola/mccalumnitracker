<?php
session_start();
include 'includes/firebaseRDB.php';
require_once 'includes/config.php'; // Include your config file

// Function to get user's actual IP address
function getUserIp() {
    if (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
        // The 'X-Forwarded-For' header may contain a comma-separated list of IPs
        // The first one is usually the client's real IP
        $ip = explode(',', $_SERVER['HTTP_X_FORWARDED_FOR'])[0];
    } elseif (!empty($_SERVER['HTTP_CLIENT_IP'])) {
        // Use 'HTTP_CLIENT_IP' if available
        $ip = $_SERVER['HTTP_CLIENT_IP'];
    } else {
        // Fallback to 'REMOTE_ADDR'
        $ip = $_SERVER['REMOTE_ADDR'];
    }

    // Validate that the IP is a valid IPv4 address
    return filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_IPV4) ? $ip : 'UNKNOWN';
}

// Initialize Firebase connection
$firebase = new firebaseRDB($databaseURL);

if (isset($_POST['login'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Retrieve admin credentials from Firebase
    $adminData = $firebase->retrieve("admin");
    $adminData = json_decode($adminData, true);

    // Initialize login attempts in the session if not set
    if (!isset($_SESSION['login_attempts'])) {
        $_SESSION['login_attempts'] = 0;
    }

    // Check if the credentials match
    if (isset($adminData['user']) && $adminData['user'] === $username) {
        if (password_verify($password, $adminData['password'])) {
            // Successful login
            $_SESSION['admin'] = $username;
            $_SESSION['login_attempts'] = 0; // Reset the attempts counter
            header('location: home.php');
            exit();
        } else {
            // Incorrect password
            $_SESSION['login_attempts'] += 1;
            $errors[] = "Incorrect password. Please try again.";
        }
    } else {
        // Incorrect username
        $_SESSION['login_attempts'] += 1;
        $errors[] = "Incorrect username. Please try again.";
    }

    // Check if the user has reached 3 failed attempts
    if ($_SESSION['login_attempts'] >= 3) {
        $ipAddress = getUserIp(); // Get the user's IP address
        $timestamp = date('Y-m-d H:i:s'); // Get the current timestamp
        $attempts = $_SESSION['login_attempts']; // Get the attempt count

        // Prepare data to log to Firebase
        $logData = [
            'ip_address' => $ipAddress,
            'timestamp' => $timestamp,
            'username' => $username,
            'attempts' => $attempts,
        ];

        // Insert the log data into Firebase under the "logs" collection
        $firebase->insert("logs", $logData);

        $errors[] = "You have reached the maximum login attempts. Please try again later.";
    }

    // Store error messages in the session and redirect back to the login page
    $_SESSION['errors'] = $errors;
    header('location: index.php');
    exit(); // Ensure the script stops after redirection
} else {
    // If no login attempt, redirect to the login page
    header('location: index.php');
    exit();
}
?>

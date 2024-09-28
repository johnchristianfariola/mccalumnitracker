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
        $ipList = explode(',', $_SERVER['HTTP_X_FORWARDED_FOR']);
        return trim($ipList[0]); // Return the first IP in the list
    } else {
        return $_SERVER['REMOTE_ADDR'];
    }
}

// Function to get the user's location using IPinfo
function getUserLocation($ipAddress) {
    // Replace 'YOUR_API_KEY' with your actual API token from IPinfo
    $apiToken = 'ipinfo.io/122.54.88.90?token=0af03275deb87a';
    $url = "https://ipinfo.io/{$ipAddress}/json?token={$apiToken}";
    
    // Get location data from IPinfo
    $response = file_get_contents($url);
    
    // Convert the JSON response into an array
    $locationData = json_decode($response, true);
    
    return $locationData;
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
        $ipAddress = getUserIP(); // Get the user's IP address
        $location = getUserLocation($ipAddress); // Get the user's location using IPinfo
        $timestamp = date("Y-m-d H:i:s"); // Get current timestamp
        
        // Prepare log data to store in Firebase
        $logData = [
            "ip" => $ipAddress,
            "city" => isset($location['city']) ? $location['city'] : 'N/A',
            "region" => isset($location['region']) ? $location['region'] : 'N/A',
            "country" => isset($location['country']) ? $location['country'] : 'N/A',
            "loc" => isset($location['loc']) ? $location['loc'] : 'N/A', // Latitude and Longitude
            "timestamp" => $timestamp,
            "attempts" => $_SESSION['login_attempts'],
            "username" => $username
        ];

        // Insert log data into Firebase
        $firebase->insert("logs", $logData);

        // Optionally, lock the account or notify the admin if needed
    }
} 

// Redirect back to login page
header('location: index.php');
exit();
?>

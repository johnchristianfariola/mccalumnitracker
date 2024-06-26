<?php
session_start();
include 'includes/firebaseRDB.php';

// Firebase Realtime Database URL
$databaseURL = "https://mccnians-bc4f4-default-rtdb.firebaseio.com";

// Instantiate FirebaseRDB object
$firebase = new firebaseRDB($databaseURL);

// Debugging session values
if (!isset($_SESSION['admin']) || trim($_SESSION['admin']) == '') {
    header('location: index.php');
    exit();
}

// Retrieve admin user data from Firebase
$adminId = $_SESSION['admin'];
$adminData = $firebase->retrieve("admin");
$adminData = json_decode($adminData, true);

// Check if the admin data exists and matches the session admin ID
if (!isset($adminData['user']) || $adminData['user'] !== $adminId) {
    // Invalid session or admin not found
    header('location: index.php');
    exit();
}

// Admin user is authenticated, store user data in session
$user = [
    'id' => $adminId,
    'user' => $adminData['user'],
    'password' => $adminData['password'],
    'firstname' => $adminData['firstname'],
    'lastname' => $adminData['lastname'],
    'image_url' => $adminData['image_url'],
    'created_on' => $adminData['created_on'] // Ensure this field exists in your Firebase data
];

// Generate CSRF token if not already set
if (!isset($_SESSION['token'])) {
    $_SESSION['token'] = bin2hex(random_bytes(32)); // Generate a random token
}

$token = $_SESSION['token'];

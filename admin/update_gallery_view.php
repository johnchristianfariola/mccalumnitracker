<?php
session_start();
require_once 'includes/firebaseRDB.php';

// Your Firebase Realtime Database URL
$databaseURL = "https://mccnians-bc4f4-default-rtdb.firebaseio.com/";

// Create an instance of the firebaseRDB class
$firebase = new firebaseRDB($databaseURL);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = $_POST['id'];
    $name = $_POST['name'];

    // Prepare the data to update
    $updateData = [
        'name' => $name,
        // Add other fields as necessary
    ];

    // Update the gallery item in Firebase
    $response = $firebase->update("gallery_view", $id, $updateData);

    if ($response) {
        $_SESSION['success'] = "Gallery item updated successfully.";
    } else {
        $_SESSION['error'] = "Failed to update gallery item.";
    }

    header('Location: gallery.php'); // Redirect back to the gallery page
    exit();
}
?>

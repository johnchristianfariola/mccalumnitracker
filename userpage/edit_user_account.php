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

// Helper function to sanitize and validate input
function sanitize_input($data) {
    return htmlspecialchars(trim($data));
}

// Update fields if provided
$fields = ['firstname', 'middlename', 'lastname', 'birthdate', 'gender', 'civilstatus', 'state', 'city', 'barangay'];
foreach ($fields as $field) {
    if (!empty($_POST[$field])) {
        $update_data[$field] = sanitize_input($_POST[$field]);
    }
}

// Check if there is any data to update
if (empty($update_data)) {
    die('No data to update');
}

// Update the data in Firebase
try {
    $result = $firebase->update("alumni/", $user_id, $update_data);

    if ($result) {
        echo 'Profile updated successfully';
    } else {
        echo 'Failed to update profile';
    }
} catch (Exception $e) {
    echo 'Error: ' . $e->getMessage();
}
?>

<?php
session_start(); // Start the session

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Ensure ID is provided
    if (!isset($_POST['id']) || empty($_POST['id'])) {
        $_SESSION['error'] = 'ID is required.';
        header('Location: event.php');
        exit;
    }

    // Include FirebaseRDB class and initialize
    require_once 'includes/firebaseRDB.php';
    require_once 'includes/config.php'; // Include your config file
    $firebase = new firebaseRDB($databaseURL);

    // Extract ID to delete
    $id = $_POST['id'];

    // Function to delete event data
    function deleteEventData($firebase, $id) {
        $table = 'event'; // Assuming 'event' is your Firebase database node for event data
        $result = $firebase->delete($table, $id);
        return $result;
    }

    // Perform delete
    $result = deleteEventData($firebase, $id);

    // Check result
    if ($result === null) {
        $_SESSION['error'] = 'Failed to delete event data in Firebase.';
        error_log('Firebase error: Failed to delete event data.');
    } else {
        $_SESSION['success'] = 'Event data deleted successfully!';
    }

    // Redirect to the appropriate page (event.php)
    header('Location: event.php');
    exit;
} else {
    $_SESSION['error'] = 'Invalid request method.';
}

// Redirect to the appropriate page (event.php) on error
header('Location: event.php');
exit;
?>

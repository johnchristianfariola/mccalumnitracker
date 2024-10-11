<?php
session_start(); // Start the session

header('Content-Type: application/json'); // Set the content type to JSON

// Function to send a JSON response
function sendResponse($status, $message) {
    echo json_encode(['status' => $status, 'message' => $message]);
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Ensure ID is provided
    if (!isset($_POST['id']) || empty($_POST['id'])) {
        sendResponse('error', 'ID is required.');
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
        return $firebase->delete($table, $id);
    }

    // Perform delete
    $result = deleteEventData($firebase, $id);

    // Check result
    if ($result === null) {
        sendResponse('error', 'Failed to delete event data in Firebase.');
    } else {
        sendResponse('success', 'Event data deleted successfully!');
    }
} else {
    sendResponse('error', 'Invalid request method.');
}
?>

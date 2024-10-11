<?php
session_start(); // Start the session

header('Content-Type: application/json');

$response = array('status' => 'error', 'message' => 'An unexpected error occurred.');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Ensure ID is provided
    if (!isset($_POST['id']) || empty($_POST['id'])) {
        $response['message'] = 'ID is required.';
        echo json_encode($response);
        exit;
    }

    // Include FirebaseRDB class and initialize
    require_once 'includes/firebaseRDB.php';
    require_once 'includes/config.php'; // Include your config file
    $firebase = new firebaseRDB($databaseURL);

    // Extract ID to delete
    $id = $_POST['id'];

    // Function to delete news data
    function deleteNewsData($firebase, $id) {
        $table = 'news'; // Assuming 'news' is your Firebase database node for news data
        $result = $firebase->delete($table, $id);
        return $result;
    }

    // Perform delete
    $result = deleteNewsData($firebase, $id);

    // Check result
    if ($result === null) {
        $response['message'] = 'Failed to delete news data in Firebase.';
        error_log('Firebase error: Failed to delete news data.');
    } else {
        $response['status'] = 'success';
        $response['message'] = 'News data deleted successfully!';
    }

    echo json_encode($response);
    exit;
} else {
    $response['message'] = 'Invalid request method.';
    echo json_encode($response);
    exit;
}
?>

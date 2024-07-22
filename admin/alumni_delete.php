<?php
session_start(); // Start the session

header('Content-Type: application/json'); // Set the content type to JSON

$response = array(); // Initialize response array

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Ensure ID is provided
    if (!isset($_POST['id']) || empty($_POST['id'])) {
        $response['status'] = 'error';
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

    // Function to delete alumni data
    function deleteAlumniData($firebase, $id) {
        $table = 'alumni'; // Assuming 'alumni' is your Firebase database node for alumni data
        $result = $firebase->delete($table, $id);
        return $result;
    }

    // Perform delete
    $result = deleteAlumniData($firebase, $id);

    // Check result
    if ($result === null) {
        $response['status'] = 'error';
        $response['message'] = 'Failed to delete alumni data in Firebase.';
        error_log('Firebase error: Failed to delete alumni data.');
    } else {
        $response['status'] = 'success';
        $response['message'] = 'Alumni data deleted successfully!';
    }
} else {
    $response['status'] = 'error';
    $response['message'] = 'Invalid request method.';
}

// Output JSON response
echo json_encode($response);
?>

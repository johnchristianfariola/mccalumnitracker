<?php
header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Ensure ID is provided
    if (!isset($_POST['id']) || empty($_POST['id'])) {
        echo json_encode([
            'status' => 'error',
            'message' => 'ID is required.'
        ]);
        exit;
    }

    // Include FirebaseRDB class and initialize
    require_once 'includes/firebaseRDB.php';
    require_once 'includes/config.php'; // Include your config file
    $firebase = new firebaseRDB($databaseURL);

    // Extract ID to delete
    $id = $_POST['id'];

    // Function to delete job data
    function deleteJobData($firebase, $id)
    {
        $table = 'job'; // Assuming 'job' is your Firebase database node for job data
        $result = $firebase->delete($table, $id);
        return $result;
    }

    // Perform delete
    $result = deleteJobData($firebase, $id);

    // Check result
    if ($result === null) {
        echo json_encode([
            'status' => 'error',
            'message' => 'Failed to delete job data in Firebase.'
        ]);
        error_log('Firebase error: Failed to delete job data.');
    } else {
        echo json_encode([
            'status' => 'success',
            'message' => 'Job data deleted successfully!'
        ]);
    }
} else {
    echo json_encode([
        'status' => 'error',
        'message' => 'Invalid request method.'
    ]);
}
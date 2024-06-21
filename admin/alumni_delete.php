<?php
session_start(); // Start the session

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Ensure ID is provided
    if (!isset($_POST['id']) || empty($_POST['id'])) {
        $_SESSION['error'] = 'ID is required.';
        header('Location: alumni.php');
        exit;
    }

    // Include FirebaseRDB class and initialize
    require_once 'includes/firebaseRDB.php';
    $databaseURL = "https://mccnians-bc4f4-default-rtdb.firebaseio.com/";
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
        $_SESSION['error'] = 'Failed to delete alumni data in Firebase.';
        error_log('Firebase error: Failed to delete alumni data.');
    } else {
        $_SESSION['success'] = 'Alumni data deleted successfully!';
    }

    // Redirect to the appropriate page (alumni.php)
    header('Location: alumni.php');
    exit;
} else {
    $_SESSION['error'] = 'Invalid request method.';
}

// Redirect to the appropriate page (alumni.php) on error
header('Location: alumni.php');
exit;
?>

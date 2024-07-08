<?php
session_start(); // Start the session

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Ensure ID is provided
    if (!isset($_POST['id']) || empty($_POST['id'])) {
        $_SESSION['error'] = 'ID is required.';
        header('Location: news.php');
        exit;
    }

    // Include FirebaseRDB class and initialize
    require_once 'includes/firebaseRDB.php';
    $databaseURL = "https://mccnians-bc4f4-default-rtdb.firebaseio.com/";
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
        $_SESSION['error'] = 'Failed to delete news data in Firebase.';
        error_log('Firebase error: Failed to delete news data.');
    } else {
        $_SESSION['success'] = 'News data deleted successfully!';
    }

    // Redirect to the appropriate page (news.php)
    header('Location: news.php');
    exit;
} else {
    $_SESSION['error'] = 'Invalid request method.';
}

// Redirect to the appropriate page (news.php) on error
header('Location: news.php');
exit;
?>

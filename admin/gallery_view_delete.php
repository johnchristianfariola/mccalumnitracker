<?php
session_start(); // Start the session

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Ensure ID is provided
    if (!isset($_POST['id']) || empty(trim($_POST['id']))) {
        $_SESSION['error'] = 'ID is required.';
        header('Location: gallery.php');
        exit;
    }

    // Include FirebaseRDB class and initialize
    require_once 'includes/firebaseRDB.php';
    require_once 'includes/config.php'; // Include your config file
    $firebase = new firebaseRDB($databaseURL);

    // Extract ID
    $id = htmlspecialchars($_POST['id']);

    // Function to remove gallery data
    function removeGalleryData($firebase, $id) {
        $table = 'gallery_view'; // Assuming 'gallery_view' is your Firebase database node for gallery data
        $result = $firebase->delete($table, $id);
        return $result;
    }

    // Perform removal
    $result = removeGalleryData($firebase, $id);

    // Check result
    if ($result === null) {
        $_SESSION['error'] = 'Failed to remove gallery data in Firebase.';
        error_log('Firebase error: Failed to remove gallery data.');
    } else {
        $_SESSION['success'] = 'Gallery data removed successfully!';
    }

    // Redirect to the appropriate page (gallery.php)
    header('Location: gallery.php');
    exit;
} else {
    $_SESSION['error'] = 'Invalid request method.';
    header('Location: gallery.php');
    exit;
}
?>

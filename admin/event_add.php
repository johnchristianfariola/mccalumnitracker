<?php
session_start(); // Start the session

// Generate a CSRF token if one is not present
if (!isset($_SESSION['token'])) {
    $_SESSION['token'] = bin2hex(random_bytes(32));
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Validate CSRF token
    if (!isset($_POST['token']) || $_POST['token'] !== $_SESSION['token']) {
      
        header('Location: event.php');
        exit;
    }

    // Unset the token to prevent reuse
    unset($_SESSION['token']);

    // Ensure all form fields are set and not empty
    if (
        isset($_POST['event_date']) && !empty($_POST['event_date']) &&
        isset($_POST['event_venue']) && !empty($_POST['event_venue']) &&
        isset($_POST['event_title']) && !empty($_POST['event_title']) &&
        isset($_POST['event_author']) && !empty($_POST['event_author']) &&
        isset($_POST['event_description']) && !empty($_POST['event_description']) &&
        isset($_FILES['imageUpload']['name']) && !empty($_FILES['imageUpload']['name'])
    ) {
        $event_title = $_POST['event_title'];
        $event_venue = $_POST['event_venue'];
        $event_date = $_POST['event_date'];
        $event_author = $_POST['event_author'];
        $event_description = $_POST['event_description'];

        // File upload variables
        $file_name = $_FILES['imageUpload']['name'];
        $file_tmp = $_FILES['imageUpload']['tmp_name'];
        $file_size = $_FILES['imageUpload']['size'];
        $file_type = $_FILES['imageUpload']['type'];

        // Check if file is an image
        $file_ext = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));
        $extensions = array("jpeg", "jpg", "png", "gif");

        if (in_array($file_ext, $extensions) === false) {
            $_SESSION['error'] = "Extension not allowed, please choose a JPEG, JPG, PNG, or GIF file.";
            header('Location: event.php');
            exit;
        }

        // Include Firebase RDB class and initialize
        require_once 'includes/firebaseRDB.php';
        $databaseURL = "https://mccnians-bc4f4-default-rtdb.firebaseio.com/";
        $firebase = new firebaseRDB($databaseURL);

        // Function to upload image and add event
        function addEventWithImage($firebase, $event_title, $event_venue, $event_date, $event_author, $event_description, $image_url) {
            $table = 'event'; // Assuming 'event' is your Firebase database node for even
            $data = array(
                'event_title' => $event_title,
                'event_venue' => $event_venue,
                'event_date' => $event_date,
                'event_author' => $event_author,
                'event_description' => $event_description,
                'image_url' => $image_url,
                'event_created' => date('F j, Y')
            );
            $result = $firebase->insert($table, $data);
            return $result;
        }

        // Upload image to server
        $upload_dir = 'uploads/';
        $file_name = uniqid() . '.' . $file_ext; // Unique file name to avoid conflicts
        $file_path = $upload_dir . $file_name;

        if (move_uploaded_file($file_tmp, $file_path)) {
            $image_url = $file_path; // Use $file_path as the image URL

            // Add event with image URL to Firebase
            $result = addEventWithImage($firebase, $event_title, $event_venue, $event_date, $event_author, $event_description, $image_url);

            // Check result
            if ($result === null) {
                $_SESSION['error'] = 'Failed to add event to Firebase.';
                error_log('Firebase error: Failed to insert event data.');
            } else {
                $_SESSION['success'] = 'Event added successfully!';
            }
        } else {
            $_SESSION['error'] = 'Failed to upload image.';
        }
    } else {
        $_SESSION['error'] = 'All fields are required.';
    }
} else {
    $_SESSION['error'] = 'Invalid request method.';
}

// Redirect to the appropriate page (event.php) regardless of success or failure
header('Location: event.php');
exit;

?>

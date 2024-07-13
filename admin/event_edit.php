<?php
session_start(); // Start the session

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Ensure all necessary data is provided and not empty
    $required_fields = ['id', 'edit_title', 'edit_date', 'edit_venue', 'edit_author', 'edit_description'];

    $valid = true;
    $missing_fields = [];

    foreach ($required_fields as $field) {
        if (!isset($_POST[$field]) || empty(trim($_POST[$field]))) {
            $valid = false;
            $missing_fields[] = $field;
        }
    }

    if ($valid) {
        // Include FirebaseRDB class and initialize
        require_once 'includes/firebaseRDB.php';
        require_once '../richTextEditor/autoload.php'; // Autoload HTMLPurifier if using Composer

        require_once 'includes/config.php'; // Include your config file
        $firebase = new firebaseRDB($databaseURL);

        // Configure HTMLPurifier
        $config = HTMLPurifier_Config::createDefault();
        $purifier = new HTMLPurifier($config);

        // Extract ID and data to update
        $id = htmlspecialchars($_POST['id']);
        $updateData = [
            "event_title" => htmlspecialchars($_POST['edit_title']),
            "event_date" => htmlspecialchars($_POST['edit_date']),
            "event_venue" => htmlspecialchars($_POST['edit_venue']),
            "event_author" => htmlspecialchars($_POST['edit_author']),
            "event_description" => $purifier->purify($_POST['edit_description']),
        ];

        // Handle image upload if file is provided
        if (isset($_FILES['imageUpload']) && $_FILES['imageUpload']['error'] === UPLOAD_ERR_OK) {
            $upload_dir = 'uploads/'; // Directory where images will be uploaded
            $filename = $_FILES['imageUpload']['name'];
            $tmp_name = $_FILES['imageUpload']['tmp_name'];
            $target_path = $upload_dir . basename($filename);

            // Move uploaded file to specified directory
            if (move_uploaded_file($tmp_name, $target_path)) {
                $updateData['image_url'] = $target_path; // Store image URL in update data
            } else {
                $_SESSION['error'] = 'Failed to upload image.';
                header('Location: event.php');
                exit;
            }
        }

        // Function to update event data
        function updateEventData($firebase, $id, $updateData) {
            $table = 'event'; // Assuming 'event' is your Firebase database node for event data
            $result = $firebase->update($table, $id, $updateData);
            return $result;
        }

        // Perform update
        $result = updateEventData($firebase, $id, $updateData);

        // Check result
        if ($result === null) {
            $_SESSION['error'] = 'Failed to update event data in Firebase.';
            error_log('Firebase error: Failed to update event data.');
        } else {
            $_SESSION['success'] = 'Event data updated successfully!';
        }

        // Redirect to the appropriate page (event.php) with preserved filter criteria
        header('Location: event.php');
        exit;
    } else {
        $_SESSION['error'] = 'All fields are required: ' . implode(', ', $missing_fields);
        header('Location: event.php');
        exit;
    }
} else {
    $_SESSION['error'] = 'Invalid request method.';
    header('Location: event.php');
    exit;
}
?>

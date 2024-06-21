<?php
session_start(); // Start the session

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Ensure all necessary data is provided and not empty
    $required_fields = ['id', 'edit_title', 'edit_author', 'edit_description'];

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
        require_once '../vendor/autoload.php'; // Autoload HTMLPurifier if using Composer

        $databaseURL = "https://mccnians-bc4f4-default-rtdb.firebaseio.com/";
        $firebase = new firebaseRDB($databaseURL);

        // Configure HTMLPurifier
        $config = HTMLPurifier_Config::createDefault();
        $purifier = new HTMLPurifier($config);

        // Extract ID and data to update
        $id = htmlspecialchars($_POST['id']);
        $updateData = [
            "news_title" => htmlspecialchars($_POST['edit_title']),
            "news_author" => htmlspecialchars($_POST['edit_author']),
            "news_description" => $purifier->purify($_POST['edit_description']),
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
                header('Location: news.php');
                exit;
            }
        }

        // Function to update news data
        function updateNewsData($firebase, $id, $updateData) {
            $table = 'news'; // Assuming 'news' is your Firebase database node for news data
            $result = $firebase->update($table, $id, $updateData);
            return $result;
        }

        // Perform update
        $result = updateNewsData($firebase, $id, $updateData);

        // Check result
        if ($result === null) {
            $_SESSION['error'] = 'Failed to update news data in Firebase.';
            error_log('Firebase error: Failed to update news data.');
        } else {
            $_SESSION['success'] = 'News data updated successfully!';
        }

        // Redirect to the appropriate page (news.php) with preserved filter criteria
        header('Location: news.php');
        exit;
    } else {
        $_SESSION['error'] = 'All fields are required.';
        header('Location: news.php');
        exit;
    }
} else {
    $_SESSION['error'] = 'Invalid request method.';
    header('Location: news.php');
    exit;
}
?>

<?php
session_start(); // Start the session

header('Content-Type: application/json');

// Generate a new token if one does not exist
if (empty($_SESSION['token'])) {
    $_SESSION['token'] = bin2hex(random_bytes(32));
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Verify the token


        // Ensure album_name and album_image are set and not empty
        if (
            isset($_POST['album_name']) && !empty($_POST['album_name']) &&
            isset($_FILES['album_image']) && $_FILES['album_image']['error'] === UPLOAD_ERR_OK
        ) {
            $albumName = $_POST['album_name'];

            // Handle the image upload
            $imageTmpName = $_FILES['album_image']['tmp_name'];
            $imageName = basename($_FILES['album_image']['name']);
            $imageDir = 'uploads/'; // Directory to store the uploaded images
            $imagePath = $imageDir . $imageName;

            // Ensure the uploads directory exists
            if (!is_dir($imageDir)) {
                mkdir($imageDir, 0777, true);
            }

            // Move the uploaded file to the target directory
            if (move_uploaded_file($imageTmpName, $imagePath)) {
                // Include Firebase RDB class and initialize
                require_once 'includes/firebaseRDB.php';
                require_once 'includes/config.php'; // Include your config file
                $firebase = new firebaseRDB($databaseURL);

                // Function to add an album
                function addAlbum($firebase, $albumName, $imagePath) {
                    $table = 'gallery'; // Assuming 'gallery' is your Firebase database table
                    $data = array(
                        'gallery_name' => $albumName,
                        'image_url' => $imagePath,
                        'user_id' => 1, // Default user_id
                        'delete_gallery' => 0 // Default delete_gallery
                    );
                    $result = $firebase->insert($table, $data);
                    return $result;
                }

                // Add album to Firebase
                $result = addAlbum($firebase, $albumName, $imagePath);

                // Check result
                if ($result === null) {
                    echo json_encode(['status' => 'error', 'message' => 'Failed to add album to Firebase.']);
                    error_log('Firebase error: Failed to insert album data.');
                } else {
                    echo json_encode(['status' => 'success', 'message' => 'Album added successfully!']);
                }
            } else {
                echo json_encode(['status' => 'error', 'message' => 'Failed to upload image.']);
            }
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Album name and image are required.']);
        }
   
} else {
    echo json_encode(['status' => 'error', 'message' => 'Invalid request method.']);
}
?>

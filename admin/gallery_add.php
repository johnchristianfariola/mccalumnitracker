<?php
session_start(); // Start the session

// Generate a new token if one does not exist
if (empty($_SESSION['token'])) {
    $_SESSION['token'] = bin2hex(random_bytes(32));
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Verify the token
    if (isset($_POST['token']) && $_POST['token'] === $_SESSION['token']) {
        // Invalidate the token to prevent reuse
        unset($_SESSION['token']);

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
                $databaseURL = "https://mccnians-bc4f4-default-rtdb.firebaseio.com/";
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
                    $_SESSION['error'] = 'Failed to add album to Firebase.';
                    error_log('Firebase error: Failed to insert album data.');
                } else {
                    $_SESSION['success'] = 'Album added successfully!';
                    redirectToGalleryPage();
                }
            } else {
                $_SESSION['error'] = 'Failed to upload image.';
                redirectToGalleryPage();
            }
        } else {
            $_SESSION['error'] = 'Album name and image are required.';
            redirectToGalleryPage();
        }
    } else {
       
        redirectToGalleryPage();
    }
} else {
    $_SESSION['error'] = 'Invalid request method.';
    redirectToGalleryPage();
}

// Function to handle redirection to the gallery page
function redirectToGalleryPage() {
    header('Location: gallery.php');
    exit;
}
?>

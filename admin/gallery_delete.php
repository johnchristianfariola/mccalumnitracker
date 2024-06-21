<?php
session_start(); // Start the session

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Ensure ID is provided
    if (empty($_POST['id'])) {
        $_SESSION['error'] = 'ID is required.';
        header('HTTP/1.1 400 Bad Request');
        exit;
    }

    // Include FirebaseRDB class and initialize
    require_once 'includes/firebaseRDB.php';
    $databaseURL = "https://mccnians-bc4f4-default-rtdb.firebaseio.com/";
    $firebase = new firebaseRDB($databaseURL);

    // Extract ID to delete
    $id = $_POST['id'];

    // Function to delete gallery data and related gallery_view data
    function deleteGalleryData($firebase, $id)
    {
        $galleryTable = 'gallery'; // Assuming 'gallery' is your Firebase database node for gallery data
        $viewTable = 'gallery_view'; // Assuming 'gallery_view' is your Firebase database node for gallery view data

        // Delete from gallery
        $firebase->delete($galleryTable, $id);

        // Check and delete from gallery_view
        $viewData = $firebase->get($viewTable); // Fetch all data from gallery_view
        if ($viewData) {
            foreach ($viewData as $key => $item) {
                if (isset($item['gallery_id']) && $item['gallery_id'] === $id) {
                    $firebase->delete($viewTable, $key); // Delete matching item from gallery_view
                }
            }
        }
    }

    // Perform delete
    deleteGalleryData($firebase, $id);

    // Set success message
    $_SESSION['success'] = 'Gallery data deleted successfully!';
    header('HTTP/1.1 200 OK');
    exit;

} else {
    $_SESSION['error'] = 'Invalid request method.';
    header('HTTP/1.1 405 Method Not Allowed');
    exit;
}
?>

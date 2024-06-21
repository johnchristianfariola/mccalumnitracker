<?php
// gallery.php
if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Include FirebaseRDB class
    require_once 'includes/firebaseRDB.php';

    // Firebase Realtime Database URL
    $databaseURL = "https://mccnians-bc4f4-default-rtdb.firebaseio.com";

    // Instantiate FirebaseRDB object
    $firebase = new firebaseRDB($databaseURL);

    // Retrieve specific gallery data
    $gallery = $firebase->retrieve("gallery/$id");
    $gallery = json_decode($gallery, true);

    // Output gallery data as JSON
    echo json_encode($gallery);
}
?>

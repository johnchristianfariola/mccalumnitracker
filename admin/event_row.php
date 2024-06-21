<?php
// fetch_alumni.php
if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Include FirebaseRDB class
    require_once 'includes/firebaseRDB.php';

    // Firebase Realtime Database URL
    $databaseURL = "https://mccnians-bc4f4-default-rtdb.firebaseio.com";

    // Instantiate FirebaseRDB object
    $firebase = new firebaseRDB($databaseURL);

    // Retrieve specific alumni data
    $event = $firebase->retrieve("event/$id");
    $event = json_decode($event, true);

    // Output alumni data as JSON
    echo json_encode($event);
}
?>

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
    $job = $firebase->retrieve("job/$id");
    $job = json_decode($job, true);

    // Output alumni data as JSON
    echo json_encode($job);
}
?>

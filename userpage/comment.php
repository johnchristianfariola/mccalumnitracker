<?php
require_once '../includes/firebaseRDB.php';

// Initialize Firebase URL
require_once '../includes/config.php'; // Include your config file
$firebase = new firebaseRDB($databaseURL);

if (isset($_POST['event_id']) && isset($_POST['alumni_id']) && isset($_POST['comment'])) {
    $event_id = $_POST['event_id'];
    $alumni_id = $_POST['alumni_id'];
    $comment = $_POST['comment'];

    // Create the data to be inserted
    $commentData = [
        'event_id' => $event_id,
        'alumni_id' => $alumni_id,
        'comment' => $comment,
        'date_commented' => date('F j, Y H:i:s')  // Include current date and time
    ];

    // Insert the data into the comment rule
    $insert = $firebase->insert("comment", $commentData);

    if ($insert) {
        echo 'Comment added!';
    } else {
        echo 'Error adding comment!';
    }
} else {
    echo 'All fields are required!';
}
?>

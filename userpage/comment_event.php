<?php
require_once '../includes/firebaseRDB.php';

// Initialize Firebase URL
$databaseURL = "https://mccnians-bc4f4-default-rtdb.firebaseio.com";
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
    $insert = $firebase->insert("event_comments", $commentData);

    if ($insert) {
        echo json_encode(['status' => 'success', 'message' => 'Comment added!']);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Error adding comment!']);
    }
} else {
    echo json_encode(['status' => 'error', 'message' => 'All fields are required!']);
}
?>
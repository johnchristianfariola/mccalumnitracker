<?php
require_once '../includes/firebaseRDB.php';
session_start();

$databaseURL = "https://mccnians-bc4f4-default-rtdb.firebaseio.com";
$firebase = new firebaseRDB($databaseURL);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $reply = $_POST['comment'];
    $parent_comment_id = $_POST['parent_comment_id'];
    $event_id = $_POST['event_id'];
    $alumni_id = $_POST['alumni_id'];

    // Validate input
    if (empty($reply) || empty($parent_comment_id) || empty($event_id) || empty($alumni_id)) {
        echo json_encode(['status' => 'error', 'message' => 'Missing required fields']);
        exit;
    }

    // Create reply data
    $replyData = [
        'comment' => $reply,
        'alumni_id' => $alumni_id,
        'date_replied' => date('F j, Y H:i:s'),
        'event_id' => $event_id
    ];

    // Insert reply into Firebase as a sub-comment
    $result = $firebase->insert("event_comments/{$parent_comment_id}/replies", $replyData);

    if ($result) {
        echo json_encode(['status' => 'success', 'message' => 'Reply submitted successfully']);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Error submitting reply']);
    }
} else {
    echo json_encode(['status' => 'error', 'message' => 'Invalid request method']);
}
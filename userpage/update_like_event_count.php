<?php
require_once '../includes/firebaseRDB.php';

$databaseURL = "https://mccnians-bc4f4-default-rtdb.firebaseio.com";
$firebase = new firebaseRDB($databaseURL);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $event_id = $_POST['event_id'];
    $alumni_id = $_POST['alumni_id'];

    // Retrieve current event data
    $event_data = $firebase->retrieve("event/{$event_id}");
    $event_data = json_decode($event_data, true);

    // Initialize likes array if it doesn't exist
    if (!isset($event_data['likes'])) {
        $event_data['likes'] = [];
    }

    // Check if the alumni has already liked the event
    $liked = in_array($alumni_id, $event_data['likes']);

    if ($liked) {
        // Remove like
        $event_data['likes'] = array_diff($event_data['likes'], [$alumni_id]);
    } else {
        // Add like
        $event_data['likes'][] = $alumni_id;
    }

    // Update like count
    $event_data['like_count'] = count($event_data['likes']);

    // Update event data in Firebase
    $firebase->update($table, "event/{$event_id}", $event_data);

    // Return updated data
    echo json_encode([
        'success' => true,
        'likeCount' => $event_data['like_count'],
        'liked' => !$liked
    ]);
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid request method']);
}
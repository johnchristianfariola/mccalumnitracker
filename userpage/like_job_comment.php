<?php
include '../includes/session.php';
require_once '../includes/firebaseRDB.php';
require_once '../includes/config.php';

$firebase = new firebaseRDB($databaseURL);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $commentId = $_POST['comment_id'];
    $alumniId = $_POST['alumni_id'];
    
    $commentData = $firebase->retrieve("job_comments/$commentId");
    $commentData = json_decode($commentData, true);
    
    if (!isset($commentData['liked_by'])) {
        $commentData['liked_by'] = [];
    }
    
    // Set timezone to Asia/Manila or any other desired timezone
    $timezone = new DateTimeZone('Asia/Manila');
    $current_time = new DateTime('now', $timezone);
    $formatted_time = $current_time->format('Y-m-d H:i:s');

    if (!isset($commentData['liked_by'][$alumniId])) {
        // Like the comment
        $commentData['liked_by'][$alumniId] = $formatted_time;
        $commentData['heart_count'] = isset($commentData['heart_count']) ? $commentData['heart_count'] + 1 : 1;
        $action = 'liked';
    } else {
        // Unlike the comment
        unset($commentData['liked_by'][$alumniId]);
        $commentData['heart_count'] = max(0, isset($commentData['heart_count']) ? $commentData['heart_count'] - 1 : 0);
        $action = 'unliked';
    }
    
    $result = $firebase->update("job_comments", $commentId, $commentData);
    
    if ($result) {
        echo json_encode(['status' => 'success', 'action' => $action]);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Failed to update like status']);
    }
} else {
    echo json_encode(['status' => 'error', 'message' => 'Invalid request method']);
}
?>

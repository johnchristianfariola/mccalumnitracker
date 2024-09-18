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
    
    if (!isset($commentData['liked_by'][$alumniId])) {
        // Like the comment
        $commentData['liked_by'][$alumniId] = date('Y-m-d H:i:s');
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
<?php
require_once '../includes/firebaseRDB.php';

$databaseURL = "https://mccnians-bc4f4-default-rtdb.firebaseio.com";
$firebase = new firebaseRDB($databaseURL);

if (isset($_POST['comment_id']) && isset($_POST['alumni_id']) && isset($_POST['is_liked'])) {
    $comment_id = $_POST['comment_id'];
    $alumni_id = $_POST['alumni_id'];
    $is_liked = $_POST['is_liked'] === 'true';
    
    // Retrieve current comment data
    $commentData = $firebase->retrieve("event_comments/{$comment_id}");
    $commentData = json_decode($commentData, true);
    
    if (!isset($commentData['liked_by'])) {
        $commentData['liked_by'] = [];
    }
    
    if ($is_liked) {
        // Add the user to liked_by if not already present
        if (!in_array($alumni_id, $commentData['liked_by'])) {
            $commentData['liked_by'][] = $alumni_id;
            $commentData['heart_count'] = isset($commentData['heart_count']) ? $commentData['heart_count'] + 1 : 1;
        }
    } else {
        // Remove the user from liked_by if present
        $commentData['liked_by'] = array_values(array_diff($commentData['liked_by'], [$alumni_id]));
        $commentData['heart_count'] = max((isset($commentData['heart_count']) ? $commentData['heart_count'] - 1 : 0), 0);
    }
    
    // Update the comment with new data
    $firebase->update("event_comments", $comment_id, $commentData);
    
    echo json_encode([
        'success' => true, 
        'heart_count' => $commentData['heart_count'],
        'is_liked' => in_array($alumni_id, $commentData['liked_by'])
    ]);
} else {
    echo json_encode(['success' => false, 'message' => 'Required data not provided']);
}
?>
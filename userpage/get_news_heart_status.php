<?php
require_once '../includes/firebaseRDB.php';

$databaseURL = "https://mccnians-bc4f4-default-rtdb.firebaseio.com";
$firebase = new firebaseRDB($databaseURL);

if (isset($_GET['comment_id']) && isset($_GET['alumni_id'])) {
    $comment_id = $_GET['comment_id'];
    $alumni_id = $_GET['alumni_id'];
    
    // Retrieve current comment data
    $commentData = $firebase->retrieve("news_comments/{$comment_id}");
    $commentData = json_decode($commentData, true);
    
    $isLiked = in_array($alumni_id, $commentData['liked_by'] ?? []);
    $heartCount = $commentData['heart_count'] ?? 0;
    
    echo json_encode([
        'success' => true,
        'is_liked' => $isLiked,
        'heart_count' => $heartCount
    ]);
} else {
    echo json_encode(['success' => false, 'message' => 'Required data not provided']);
}
?>
<?php
require_once '../includes/session.php';

require_once '../includes/firebaseRDB.php';
require_once '../includes/config.php';

$firebase = new firebaseRDB($databaseURL);

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['comment_id']) && isset($_POST['action'])) {
    $commentId = $_POST['comment_id'];
    $action = $_POST['action'];
    $userId = $_SESSION['user']['id']; // Assuming you have user sessions

    // Retrieve the current comment data
    $commentData = $firebase->retrieve("forum_comments/$commentId");
    $commentData = json_decode($commentData, true);

    if (!$commentData) {
        echo json_encode(['status' => 'error', 'message' => 'Comment not found']);
        exit;
    }

    // Initialize arrays if they don't exist
    $commentData['liked_by'] = $commentData['liked_by'] ?? [];
    $commentData['disliked_by'] = $commentData['disliked_by'] ?? [];
    $commentData['heart_count'] = $commentData['heart_count'] ?? 0;
    $commentData['dislike_count'] = $commentData['dislike_count'] ?? 0;

    $liked = in_array($userId, $commentData['liked_by']);
    $disliked = in_array($userId, $commentData['disliked_by']);

    if ($action === 'like') {
        if ($liked) {
            // Remove like
            $commentData['liked_by'] = array_diff($commentData['liked_by'], [$userId]);
            $commentData['heart_count']--;
            $liked = false;
        } else {
            // Add like and remove dislike if exists
            $commentData['liked_by'][] = $userId;
            $commentData['heart_count']++;
            $commentData['disliked_by'] = array_diff($commentData['disliked_by'], [$userId]);
            if ($disliked) {
                $commentData['dislike_count']--;
            }
            $liked = true;
            $disliked = false;
        }
    } elseif ($action === 'dislike') {
        if ($disliked) {
            // Remove dislike
            $commentData['disliked_by'] = array_diff($commentData['disliked_by'], [$userId]);
            $commentData['dislike_count']--;
            $disliked = false;
        } else {
            // Add dislike and remove like if exists
            $commentData['disliked_by'][] = $userId;
            $commentData['dislike_count']++;
            $commentData['liked_by'] = array_diff($commentData['liked_by'], [$userId]);
            if ($liked) {
                $commentData['heart_count']--;
            }
            $disliked = true;
            $liked = false;
        }
    }

    // Reindex the arrays
    $commentData['liked_by'] = array_values($commentData['liked_by']);
    $commentData['disliked_by'] = array_values($commentData['disliked_by']);

    // Update the comment data in Firebase
    $result = $firebase->update("forum_comments", $commentId, $commentData);

    if ($result) {
        echo json_encode([
            'status' => 'success',
            'heart_count' => $commentData['heart_count'],
            'dislike_count' => $commentData['dislike_count'],
            'liked' => $liked,
            'disliked' => $disliked
        ]);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Failed to update rating']);
    }
} else {
    echo json_encode(['status' => 'error', 'message' => 'Invalid request']);
}
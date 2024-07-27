<?php
require_once '../includes/firebaseRDB.php';
session_start();

// Initialize Firebase URL
$databaseURL = "https://mccnians-bc4f4-default-rtdb.firebaseio.com";
$firebase = new firebaseRDB($databaseURL);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $news_id = htmlspecialchars($_POST['news_id'], ENT_QUOTES, 'UTF-8');
    $alumni_id = htmlspecialchars($_POST['alumni_id'], ENT_QUOTES, 'UTF-8');
    $comment = htmlspecialchars($_POST['comment'], ENT_QUOTES, 'UTF-8');
    $parent_comment_id = htmlspecialchars($_POST['parent_comment_id'], ENT_QUOTES, 'UTF-8');

    // Validate input
    if (empty($news_id) || empty($alumni_id) || empty($comment) || empty($parent_comment_id)) {
        echo json_encode(['status' => 'error', 'message' => 'Missing required fields']);
        exit;
    }

    // Create reply data
    $replyData = [
        'alumni_id' => $alumni_id,
        'comment' => $comment,
        'date_replied' => date('c') // Using ISO 8601 date format
    ];

    // Insert reply into Firebase as a sub-comment
    try {
        $result = $firebase->insert("news_comments/{$parent_comment_id}/replies", $replyData);

        if ($result) {
            echo json_encode(['status' => 'success', 'message' => 'Reply submitted successfully']);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Error submitting reply']);
        }
    } catch (Exception $e) {
        echo json_encode(['status' => 'error', 'message' => 'Error submitting reply: ' . $e->getMessage()]);
    }
} else {
    echo json_encode(['status' => 'error', 'message' => 'Invalid request method']);
}
?>

<?php
session_start();
require_once '../includes/firebaseRDB.php';
require_once '../includes/config.php';

header('Content-Type: application/json');

function sendResponse($status, $message = '', $action = '') {
    echo json_encode([
        'status' => $status,
        'message' => $message,
        'action' => $action
    ]);
    exit;
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    sendResponse('error', 'Invalid request method');
}

$commentId = $_POST['comment_id'] ?? '';
$alumniId = $_POST['alumni_id'] ?? '';

if (empty($commentId) || empty($alumniId)) {
    sendResponse('error', 'Missing required data');
}

try {
    $firebase = new firebaseRDB($databaseURL);
    $commentData = $firebase->retrieve("job_comments/$commentId");
    $commentData = json_decode($commentData, true);

    if (!$commentData) {
        sendResponse('error', 'Comment not found');
    }

    if (!isset($commentData['liked_by'])) {
        $commentData['liked_by'] = [];
    }

    $timezone = new DateTimeZone('Asia/Manila');
    $current_time = new DateTime('now', $timezone);
    $formatted_time = $current_time->format('Y-m-d H:i:s');

    if (!isset($commentData['liked_by'][$alumniId])) {
        // Like the comment
        $commentData['liked_by'][$alumniId] = $formatted_time;
        $commentData['heart_count'] = ($commentData['heart_count'] ?? 0) + 1;
        $action = 'liked';
    } else {
        // Unlike the comment
        unset($commentData['liked_by'][$alumniId]);
        $commentData['heart_count'] = max(0, ($commentData['heart_count'] ?? 1) - 1);
        $action = 'unliked';
    }

    $result = $firebase->update("job_comments", $commentId, $commentData);

    if ($result === null) {
        sendResponse('error', 'Failed to update like status');
    }

    sendResponse('success', 'Like status updated successfully', $action);

} catch (Exception $e) {
    sendResponse('error', 'An error occurred: ' . $e->getMessage());
}
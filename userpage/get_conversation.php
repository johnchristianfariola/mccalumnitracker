<?php
// get_conversation.php

require_once '../includes/firebaseRDB.php';
require_once '../includes/config.php';

// Start session if not already started
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Check if user is logged in
if (!isset($_SESSION['alumni'])) {
    echo json_encode(['error' => 'User not logged in']);
    exit;
}

// Get the current user's ID
$currentUserId = $_SESSION['alumni'];

// Get the other user's ID from the GET parameter
$otherUserId = isset($_GET['userId']) ? $_GET['userId'] : '';

if (empty($otherUserId)) {
    echo json_encode(['error' => 'Invalid user ID']);
    exit;
}

// Initialize Firebase
$firebase = new firebaseRDB($databaseURL);

// Retrieve all messages
$allMessages = $firebase->retrieve("messages");
$allMessages = json_decode($allMessages, true);

// Filter and process messages
$conversation = [];
foreach ($allMessages as $id => $message) {
    if (($message['senderId'] == $currentUserId && $message['receiverId'] == $otherUserId) ||
        ($message['senderId'] == $otherUserId && $message['receiverId'] == $currentUserId)) {
        $conversation[] = [
            'id' => $id,
            'content' => $message['content'],
            'timestamp' => $message['timestamp'],
            'senderId' => $message['senderId'],
            'isCurrentUser' => ($message['senderId'] == $currentUserId)
        ];
    }
}

// Sort messages by timestamp
usort($conversation, function($a, $b) {
    return strtotime($a['timestamp']) - strtotime($b['timestamp']);
});

// Return messages as JSON
echo json_encode($conversation);

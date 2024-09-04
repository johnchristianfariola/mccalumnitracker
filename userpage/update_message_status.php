<?php
session_start();

if (!isset($_SESSION['user']) || !isset($_SESSION['user']['id'])) {
    echo json_encode(['error' => 'User not logged in']);
    exit;
}

$current_user_id = $_SESSION['user']['id'];

require_once '../includes/firebaseRDB.php';
require_once '../includes/config.php';

$firebase = new firebaseRDB($databaseURL);

// Fetch all messages where the current user is the receiver and the message_active is 0 (unread)
$messages = $firebase->retrieve("messages");
$messages = json_decode($messages, true);

if (is_array($messages) && !empty($messages)) {
    foreach ($messages as $message_id => $message) {
        if ($message['receiverId'] == $current_user_id && $message['message_active'] == 0) {
            // Update the message_active status to 1 (read)
            $firebase->update("messages" , $message_id, ["message_active" => 1]);
        }
    }
}

echo json_encode(['success' => true]);
?>

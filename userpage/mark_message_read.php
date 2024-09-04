<?php
session_start();

if (!isset($_SESSION['user']) || !isset($_SESSION['user']['id'])) {
    echo json_encode(['success' => false, 'error' => 'User not logged in']);
    exit;
}

require_once '../includes/firebaseRDB.php';
require_once '../includes/config.php';

$firebase = new firebaseRDB($databaseURL);
$current_user_id = $_SESSION['user']['id'];

if (isset($_POST['message_id'])) {
    $message_id = $_POST['message_id'];

    // Retrieve the message from Firebase
    $message_data = json_decode($firebase->retrieve("messages/$message_id"), true);

    if ($message_data && $message_data['receiverId'] === $current_user_id) {
        // Update the message's 'message_active' status to 1
        $message_data['message_active'] = 1;
        $firebase->update("messages" , $message_id, $message_data);

        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false, 'error' => 'Message not found or unauthorized']);
    }
} else {
    echo json_encode(['success' => false, 'error' => 'Invalid request']);
}

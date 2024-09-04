<?php
require_once '../includes/firebaseRDB.php';
require_once '../includes/config.php';
require_once 'navbar_php_script.php'; // Reuse the existing logic

$firebase = new firebaseRDB($databaseURL);
$current_user_id = $_SESSION['user']['id'];
$messages = json_decode($firebase->retrieve("messages"), true);

// Get the unread message count
$message_count = countUnreadMessages($messages, $current_user_id);

// Return the count as JSON
echo json_encode(['message_count' => $message_count]);
?>

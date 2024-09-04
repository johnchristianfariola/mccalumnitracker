<?php
require_once '../includes/firebaseRDB.php';
require_once '../includes/config.php';

$firebase = new firebaseRDB($databaseURL);

// Set the timezone to the Philippines
date_default_timezone_set('Asia/Manila');

$data = json_decode(file_get_contents('php://input'), true);
$user_id = $data['user_id'];

// Get the current timestamp in the Philippines timezone
$timestamp = date('Y-m-d H:i:s');

$firebase->update($table, "alumni/" . $user_id, ["last_notification_check" => $timestamp]);

echo json_encode(['success' => true]);
?>

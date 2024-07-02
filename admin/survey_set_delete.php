<?php
session_start(); // Start session if not already started
require_once 'includes/firebaseRDB.php';

$databaseURL = "https://mccnians-bc4f4-default-rtdb.firebaseio.com";
$firebase = new firebaseRDB($databaseURL);

$id = isset($_POST['id']) ? $_POST['id'] : '';

if ($id) {
    $firebase->delete($table, "questions/$id");
    $_SESSION['success'] = 'Question deleted successfully.';
    echo json_encode(['status' => 'success']);
} else {
    $_SESSION['error'] = 'Invalid ID'; // Setting session error message
    echo json_encode(['status' => 'error', 'message' => 'Invalid ID']);
}
?>

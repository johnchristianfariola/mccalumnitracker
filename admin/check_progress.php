<?php
session_start();
header('Content-Type: application/json');

$response = array('status' => 'error', 'message' => 'Invalid processing ID.');

if (isset($_GET['token']) && isset($_SESSION['processing'][$_GET['token']])) {
    $processing = $_SESSION['processing'][$_GET['token']];
    $response = array(
        'status' => 'processing',
        'progress' => $processing['progress']
    );

    if ($processing['progress'] >= 100) {
        $response['status'] = 'complete';
        unset($_SESSION['processing'][$_GET['token']]);
    }
}

echo json_encode($response);
?>

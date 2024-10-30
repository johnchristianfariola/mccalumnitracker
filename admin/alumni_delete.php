<?php
session_start();
header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!isset($_POST['id']) || empty($_POST['id'])) {
        echo json_encode(['status' => 'error', 'message' => 'ID is required.']);
        exit;
    }

    require_once 'includes/firebaseRDB.php';
    require_once 'includes/config.php';

    $firebase = new firebaseRDB($databaseURL);
    $id = $_POST['id'];

    // Move data to deleted_alumni and delete from alumni
    function moveAndDeleteAlumni($firebase, $id) {
        $alumniData = $firebase->get('alumni', $id);
        if ($alumniData === null) {
            return false;
        }

        $result = $firebase->insert('deleted_alumni', $id, $alumniData);
        if ($result === null) {
            return false;
        }

        $deleteResult = $firebase->delete('alumni', $id);
        return $deleteResult !== null;
    }

    if (moveAndDeleteAlumni($firebase, $id)) {
        echo json_encode(['status' => 'success', 'message' => 'Alumni data deleted successfully.']);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Failed to delete alumni data.']);
    }
} else {
    echo json_encode(['status' => 'error', 'message' => 'Invalid request method.']);
}
?>
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

    // Function to move data to deleted_alumni and delete from alumni
    function moveAndDeleteAlumni($firebase, $id) {
        // Retrieve the alumni data
        $alumniData = $firebase->get('alumni', $id);
        if ($alumniData === null) {
            return false;
        }

        // Insert the data into deleted_alumni
        $result = $firebase->insert('deleted_alumni', $id, $alumniData);
        if ($result === null) {
            return false;
        }

        // Delete the data from alumni
        $deleteResult = $firebase->delete('alumni', $id);
        return $deleteResult !== null;
    }

    // Execute the move and delete operation
    if (moveAndDeleteAlumni($firebase, $id)) {
        echo json_encode(['status' => 'success', 'message' => 'Alumni data deleted successfully.']);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Failed to delete alumni data.']);
    }
} else {
    echo json_encode(['status' => 'error', 'message' => 'Invalid request method.']);
}
?>
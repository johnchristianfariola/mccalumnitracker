<?php
session_start();

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $required_fields = ['id', 'edit_job_title', 'edit_company_name', 'edit_job_description', 'edit_status', 'edit_work_status'];

    $valid = true;
    foreach ($required_fields as $field) {
        if (!isset($_POST[$field]) || empty($_POST[$field])) {
            $valid = false;
            break;
        }
    }

    if ($valid) {
        require_once 'includes/firebaseRDB.php';
        require_once 'includes/config.php';
        $firebase = new firebaseRDB($databaseURL);

        $id = $_POST['id'];
        $updateData = [
            "job_title" => $_POST['edit_job_title'],
            "company_name" => $_POST['edit_company_name'],
            "job_description" => $_POST['edit_job_description'],
            "status" => $_POST['edit_status'],
            "work_time" => $_POST['edit_work_status']
        ];

        // Fetch current data
        $table = 'job';
        $currentData = $firebase->retrieve($table, $id);

        // Check if there are any changes
        $changes = false;
        foreach ($updateData as $key => $value) {
            if (!isset($currentData[$key]) || $currentData[$key] !== $value) {
                $changes = true;
                break;
            }
        }

        if (!$changes) {
            echo json_encode(['status' => 'info', 'message' => 'No changes detected. Data remains unchanged.']);
        } else {
            function updateJobData($firebase, $id, $updateData) {
                $table = 'job';
                $result = $firebase->update($table, $id, $updateData);
                return $result;
            }

            $result = updateJobData($firebase, $id, $updateData);

            if ($result === null) {
                echo json_encode(['status' => 'error', 'message' => 'Failed to update job data in database.']);
                error_log('Firebase error: Failed to update job data.');
            } else {
                echo json_encode(['status' => 'success', 'message' => 'Job data updated successfully!']);
            }
        }
    } else {
        echo json_encode(['status' => 'error', 'message' => 'All fields are required.']);
    }
} else {
    echo json_encode(['status' => 'error', 'message' => 'Invalid request method.']);
}

exit;
?>
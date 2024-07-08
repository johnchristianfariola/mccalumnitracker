<?php
session_start(); // Start the session

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Ensure all necessary data is provided and not empty
    $required_fields = ['id', 'edit_job_title', 'edit_company_name', 'edit_job_description', 'edit_status', 'edit_work_status'];

    $valid = true;
    foreach ($required_fields as $field) {
        if (!isset($_POST[$field]) || empty($_POST[$field])) {
            $valid = false;
            break;
        }
    }

    if ($valid) {
        // Include FirebaseRDB class and initialize
        require_once 'includes/firebaseRDB.php';
        $databaseURL = "https://mccnians-bc4f4-default-rtdb.firebaseio.com/";
        $firebase = new firebaseRDB($databaseURL);

        // Extract ID and data to update
        $id = $_POST['id'];
        $updateData = [
            "job_title" => $_POST['edit_job_title'],
            "company_name" => $_POST['edit_company_name'],
            "job_description" => $_POST['edit_job_description'],
            "status" => $_POST['edit_status'],
            "work_time" => $_POST['edit_work_status']
        ];

        // Function to update alumni data
        function updateJobData($firebase, $id, $updateData) {
            $table = 'job'; // Assuming 'alumni' is your Firebase database node for alumni data
            $result = $firebase->update($table, $id, $updateData);
            return $result;
        }

        // Perform update
        $result = updateJobData($firebase, $id, $updateData);

        // Check result
        if ($result === null) {
            $_SESSION['error'] = 'Failed to update job data in database.';
            error_log('Firebase error: Failed to update job data.');
        } else {
            $_SESSION['success'] = 'Job data updated successfully!';
        }
		header('Location: job.php');
        exit;
    } else {
        $_SESSION['error'] = 'All fields are required.';
    }
} else {
    $_SESSION['error'] = 'Invalid request method.';
}

// Redirect to the appropriate page (alumni.php) on error

exit;
?>

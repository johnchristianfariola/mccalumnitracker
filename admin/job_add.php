<?php
session_start(); // Start the session

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Ensure all form fields are set and not empty
    if (
        isset($_POST['job_title']) && !empty($_POST['job_title']) &&
        isset($_POST['company_name']) && !empty($_POST['company_name']) &&
        isset($_POST['job_description']) && !empty($_POST['job_description']) &&
        isset($_POST['status']) && !empty($_POST['status']) &&
        isset($_POST['work_status']) && !empty($_POST['work_status'])
    ) {
        $job_title = $_POST['job_title'];
        $company_name = $_POST['company_name'];
        $job_description = $_POST['job_description'];
        $status = $_POST['status'];
        $work_time = $_POST['work_status']; // Correctly capture the value of work_status

        // Include Firebase RDB class and initialize
        require_once 'includes/firebaseRDB.php';
        require_once 'includes/config.php'; // Include your config file
        $firebase = new firebaseRDB($databaseURL);

        // Function to add job
        function addJob($firebase, $job_title, $company_name, $job_description, $status, $work_time) {
            $table = 'job'; // Assuming 'jobs' is your Firebase database node for job postings
            $data = array(
                'job_title' => $job_title,
                'company_name' => $company_name,
                'job_description' => $job_description,
                'status' => $status,
                'work_time' => $work_time,
                'job_created' => date('F j, Y')
            );
            $result = $firebase->insert($table, $data);
            return $result;
        }

        // Add job to Firebase
        $result = addJob($firebase, $job_title, $company_name, $job_description, $status, $work_time);

        // Check result
        if ($result === null) {
            $response = array('status' => 'error', 'message' => 'Failed to add job to Firebase.');
            echo json_encode($response);
            exit;
        } else {
            $response = array('status' => 'success', 'message' => 'Job added successfully!');
            echo json_encode($response);
            exit;
        }
    } else {
        $response = array('status' => 'error', 'message' => 'All fields are required.');
        echo json_encode($response);
        exit;
    }
} else {
    $response = array('status' => 'error', 'message' => 'Invalid request method.');
    echo json_encode($response);
    exit;
}
?>

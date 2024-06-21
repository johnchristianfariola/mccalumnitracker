<?php
session_start(); // Start the session

// Generate a new token if one does not exist
if (empty($_SESSION['token'])) {
    $_SESSION['token'] = bin2hex(random_bytes(32));
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Verify the token
    if (isset($_POST['token']) && $_POST['token'] === $_SESSION['token']) {
        // Invalidate the token to prevent reuse
        unset($_SESSION['token']);
        
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
            $databaseURL = "https://mccnians-bc4f4-default-rtdb.firebaseio.com/";
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
                $_SESSION['error'] = 'Failed to add job to Firebase.';
                error_log('Firebase error: Failed to insert job data.');
            } else {
                $_SESSION['success'] = 'Job added successfully!';
            }
        } else {
            $_SESSION['error'] = 'All fields are required.';
        }
    } 
} else {
    $_SESSION['error'] = 'Invalid request method.';
}

// Function to handle redirection
function redirectToJobPage() {
    header('Location: job.php');
    exit;
}

// Redirect to the job page
redirectToJobPage();
?>

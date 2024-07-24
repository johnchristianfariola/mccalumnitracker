<?php
session_start(); // Start the session

header('Content-Type: application/json'); // Set the content type to JSON

$response = array('status' => 'error', 'message' => 'An unknown error occurred');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Ensure all form fields are set and not empty
    if (
        isset($_POST['survey_title']) && !empty($_POST['survey_title']) &&
        isset($_POST['survey_desc']) && !empty($_POST['survey_desc']) &&
        isset($_POST['survey_start']) && !empty($_POST['survey_start']) &&
        isset($_POST['survey_end']) && !empty($_POST['survey_end'])
    ) {
        $survey_title = $_POST['survey_title'];
        $survey_desc = $_POST['survey_desc'];
        $survey_start = $_POST['survey_start'];
        $survey_end = $_POST['survey_end'];

        // Include Firebase RDB class and initialize
        require_once 'includes/firebaseRDB.php';
        require_once 'includes/config.php'; // Include your config file
        $firebase = new firebaseRDB($databaseURL);

        // Function to add surveys
        function addsurveys($firebase, $survey_title, $survey_desc, $survey_start, $survey_end) {
            $table = 'survey_set'; // Assuming 'surveys' is your Firebase database node for surveys postings
            $data = array(
                'survey_title' => $survey_title,
                'survey_desc' => $survey_desc,
                'survey_start' => $survey_start,
                'survey_end' => $survey_end,
                'surveys_created' => date('F j, Y')
            );
            $result = $firebase->insert($table, $data);
            return $result;
        }

        // Add surveys to Firebase
        $result = addsurveys($firebase, $survey_title, $survey_desc, $survey_start, $survey_end);

        // Check result
        if ($result === null) {
            $response['message'] = 'Failed to add Survey to Firebase.';
            error_log('Firebase error: Failed to insert survey data.');
        } else {
            $response['status'] = 'success';
            $response['message'] = 'Survey added successfully!';
        }
    } else {
        $response['message'] = 'All fields are required.';
    }
} else {
    $response['message'] = 'Invalid request method.';
}

echo json_encode($response); // Return JSON response
?>

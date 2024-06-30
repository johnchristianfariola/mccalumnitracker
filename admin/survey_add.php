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
            $databaseURL = "https://mccnians-bc4f4-default-rtdb.firebaseio.com/";
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
                $_SESSION['error'] = 'Failed to add Survey to Firebase.';
                error_log('Firebase error: Failed to insert survey data.');
            } else {
                $_SESSION['success'] = 'Survey added successfully!';
            }
        } else {
            $_SESSION['error'] = 'All fields are required.';
        }
    } 
} else {
    $_SESSION['error'] = 'Invalid request method.';
}

// Function to handle redirection
function redirectToSurveyPage() {
    header('Location: survey.php');
    exit;
}

// Redirect to the surveys page
redirectToSurveyPage();
?>

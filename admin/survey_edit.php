<?php
session_start(); // Start the session

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Ensure all necessary data is provided and not empty
    $required_fields = ['id', 'edit_survey_title', 'edit_survey_desc', 'edit_survey_start', 'edit_survey_end'];

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
        require_once 'includes/config.php'; // Include your config file
        $firebase = new firebaseRDB($databaseURL);
        // Extract ID and data to update
        $id = $_POST['id'];
        $updateData = [
            "survey_title" => $_POST['edit_survey_title'],
            "survey_desc" => $_POST['edit_survey_desc'],
            "survey_start" => $_POST['edit_survey_start'],
            "survey_end" => $_POST['edit_survey_end'],
     
        ];

        // Function to update alumni data
        function updateSurveyData($firebase, $id, $updateData) {
            $table = 'survey_set'; // Assuming 'alumni' is your Firebase database node for alumni data
            $result = $firebase->update($table, $id, $updateData);
            return $result;
        }

        // Perform update
        $result = updateSurveyData($firebase, $id, $updateData);

        // Check result
        if ($result === null) {
            $_SESSION['error'] = 'Failed to update survey data in database.';
            error_log('Firebase error: Failed to update survey data.');
        } else {
            $_SESSION['success'] = 'survey data updated successfully!';
        }
		header('Location: survey.php');
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

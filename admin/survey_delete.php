<?php
session_start(); // Start the session

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Ensure ID is provided
    if (!isset($_POST['id']) || empty($_POST['id'])) {
        $_SESSION['error'] = 'ID is required.';
        header('Location: survey.php');
        exit;
    }

    // Sanitize ID input
    $id = filter_var($_POST['id'], FILTER_SANITIZE_STRING);

    // Include FirebaseRDB class and initialize
    require_once 'includes/firebaseRDB.php';
    $databaseURL = "https://mccnians-bc4f4-default-rtdb.firebaseio.com/";
    $firebase = new firebaseRDB($databaseURL);

    // Function to delete survey data
    function deleteSurveyData($firebase, $id) {
        $table = 'survey_set'; // Assuming 'survey_set' is your Firebase database node for survey data
        $result = $firebase->delete($table, $id);
        return $result;
    }

    // Function to delete questions associated with the survey
    function deleteQuestions($firebase, $surveyId) {
        $questions = $firebase->retrieve('questions');
        $questions = json_decode($questions, true);

        foreach ($questions as $questionId => $questionData) {
            if ($questionData['survey_set_unique_id'] === $surveyId) {
                $firebase->delete('questions', $questionId);
            }
        }
    }

    // Perform delete for survey data
    $result = deleteSurveyData($firebase, $id);

    // Check result for survey deletion
    if ($result === null) {
        $_SESSION['error'] = 'Failed to delete survey data in Firebase.';
        error_log('Firebase error: Failed to delete survey data.');
    } else {
        // Perform delete for associated questions
        deleteQuestions($firebase, $id);
        $_SESSION['success'] = 'Survey data deleted successfully!';
    }

    // Redirect to the appropriate page (survey.php)
    header('Location: survey.php');
    exit;
} else {
    $_SESSION['error'] = 'Invalid request method.';
    header('Location: survey.php');
    exit;
}
?>

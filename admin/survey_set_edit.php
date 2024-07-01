<?php
session_start(); // Start the session
require_once 'includes/firebaseRDB.php';

$databaseURL = "https://mccnians-bc4f4-default-rtdb.firebaseio.com";
$firebase = new firebaseRDB($databaseURL);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get form data
    $question_id = isset($_POST['question_id']) ? $_POST['question_id'] : '';
    $survey_set_unique_id = isset($_POST['survey_set_unique_id']) ? $_POST['survey_set_unique_id'] : '';
    $question = isset($_POST['question']) ? $_POST['question'] : '';
    $type = isset($_POST['type']) ? $_POST['type'] : '';
    $labels = isset($_POST['label']) ? $_POST['label'] : [];
    
    // Validate the data
    if ($question_id && $survey_set_unique_id && $question && $type) {
        // Create formatted options
        $frm_option = [];
        foreach ($labels as $label) {
            $frm_option[uniqid()] = $label; // Using uniqid() for unique IDs
        }
        $frm_option_json = json_encode($frm_option);

        // Create data array
        $update_data = [
            'question' => $question,
            'frm_option' => $frm_option_json,
            'type' => $type,
            'survey_set_unique_id' => $survey_set_unique_id,
            'date_create' => date('Y-m-d H:i:s') // Update creation date
        ];

        // Update data in Firebase
        $response = $firebase->update($table, "questions/$question_id", $update_data);

        if ($response) {
            $_SESSION['success'] = 'Question updated successfully.';
        } else {
            $_SESSION['error'] = 'Failed to update question.';
        }
    } else {
        $_SESSION['error'] = 'Invalid data.';
    }
} else {
    $_SESSION['error'] = 'Invalid request method.';
}

// Redirect back to the form page or any other desired page
header('Location: survey_set.php?id=' . $survey_set_unique_id);
exit;
?>

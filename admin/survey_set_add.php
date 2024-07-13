<?php
session_start(); // Start the session
require_once 'includes/firebaseRDB.php';

require_once 'includes/config.php'; // Include your config file
$firebase = new firebaseRDB($databaseURL);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get form data
    $survey_set_id = $_POST['survey_set_id'];
    $question = $_POST['question'];
    $type = $_POST['type'];
    $labels = isset($_POST['label']) ? $_POST['label'] : [];
    
    // Create formatted options
    $frm_option = [];
    foreach ($labels as $label) {
        $frm_option[uniqid()] = $label; // Using uniqid() for unique IDs
    }
    $frm_option_json = json_encode($frm_option);

    // Create data array
    $data = [
        'question' => $question,
        'frm_option' => $frm_option_json,
        'type' => $type,
        'survey_set_unique_id' => $survey_set_id,
        'date_create' => date('Y-m-d H:i:s')
    ];

    // Insert data into Firebase
    $response = $firebase->insert("questions", $data);
    if ($response) {
        $_SESSION['success'] = 'Question added successfully.';
    } else {
        $_SESSION['error'] = 'Failed to add question.';
    }
} else {
    $_SESSION['error'] = 'Invalid request method.';
}

// Redirect back to the form page or any other desired page
header('Location: survey_set.php?id=' . $_POST['survey_set_id']);
exit;
?>

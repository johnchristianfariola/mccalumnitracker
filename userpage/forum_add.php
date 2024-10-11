<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);

include '../includes/firebaseRDB.php';

header('Content-Type: application/json');

$databaseURL = "https://mccalumniapp-default-rtdb.firebaseio.com";
$firebase = new firebaseRDB($databaseURL);

date_default_timezone_set('Asia/Manila');

$response = array('status' => 'error', 'message' => '');

// Debug: Log received data
error_log('Received POST data: ' . print_r($_POST, true));

if (!isset($_SESSION['alumni_id'])) {
    $response['message'] = 'User not authenticated. Session data: ' . json_encode($_SESSION);
    echo json_encode($response);
    exit;
}

$alumniId = $_SESSION['alumni_id'];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['forumName']) && !empty($_POST['forumName']) && isset($_POST['editor1'])) {
        $forumName = $_POST['forumName'];
        $forumDescription = $_POST['editor1'];

        // Debug: Log forum data
        error_log('Forum Name: ' . $forumName);
        error_log('Forum Description: ' . $forumDescription);

        // Function to check if forum already exists
        function forumExists($firebase, $forumName)
        {
            $existingData = $firebase->retrieve("forum");
            $existingData = json_decode($existingData, true);
            if (is_array($existingData)) {
                foreach ($existingData as $key => $value) {
                    if ($value['forumName'] == $forumName) {
                        return true;
                    }
                }
            }
            return false;
        }

        // Check if the forum already exists
        if (forumExists($firebase, $forumName)) {
            $response['message'] = 'This Forum Name Already Exists';
        } else {
            $data = [
                'forumName' => $forumName,
                'forumDescription' => $forumDescription,
                'createdAt' => date('Y-m-d H:i:s'),
                'alumniId' => $alumniId
            ];

            try {
                $result = $firebase->insert("forum", $data);
                if ($result) {
                    $response['status'] = 'success';
                    $response['message'] = 'Forum added successfully!';
                } else {
                    throw new Exception('Error adding forum. Firebase insert returned false.');
                }
            } catch (Exception $e) {
                $response['message'] = 'Error: ' . $e->getMessage();
                error_log('Forum add error: ' . $e->getMessage());
            }
        }
    } else {
        $response['message'] = 'Forum name and description are required.';
    }
} else {
    $response['message'] = 'Invalid request method.';
}

// Debug: Log the response
error_log('Forum add response: ' . json_encode($response));

echo json_encode($response);
exit;
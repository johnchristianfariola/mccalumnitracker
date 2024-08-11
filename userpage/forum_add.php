<?php
include '../includes/firebaseRDB.php';

header('Content-Type: application/json');

$databaseURL = "https://mccnians-bc4f4-default-rtdb.firebaseio.com";
$firebase = new firebaseRDB($databaseURL);

date_default_timezone_set('Asia/Manila');

$response = array('status' => 'error', 'message' => '');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['forumName']) && !empty($_POST['forumName']) && isset($_POST['editor1'])) {
        $forumName = $_POST['forumName'];
        $forumDescription = $_POST['editor1'];

        // Function to check if forum already exists
        function forumExists($firebase, $forumName) {
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
                'createdAt' => date('Y-m-d H:i:s')
            ];

            $result = $firebase->insert("forum", $data);

            if ($result) {
                $response['status'] = 'success';
                $response['message'] = 'Forum added successfully!';
            } else {
                $response['message'] = 'Error adding forum.';
            }
        }
    } else {
        $response['message'] = 'Forum name and description are required.';
    }
} else {
    $response['message'] = 'Invalid request method.';
}

echo json_encode($response);
exit;
?>
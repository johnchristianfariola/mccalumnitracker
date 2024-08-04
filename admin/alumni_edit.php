<?php
session_start(); // Start the session

header('Content-Type: application/json'); // Set the response format to JSON

$response = array('status' => 'error', 'message' => 'An unexpected error occurred.');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Ensure the necessary data (studentid) is provided and not empty
    if (!isset($_POST['edit_studentid']) || empty($_POST['edit_studentid'])) {
        $response['message'] = 'Alumni ID is required.';
        echo json_encode($response);
        exit;
    }

    // Validate Alumni ID format
    $studentid = $_POST['edit_studentid'];
    if (!preg_match('/^\d{4}-\d{4}$/', $studentid)) {
        $response['message'] = 'Alumni ID must be in the format 1234-5678';
        echo json_encode($response);
        exit;
    }

    // Include FirebaseRDB class and initialize
    require_once 'includes/firebaseRDB.php';
    require_once 'includes/config.php'; // Include your config file
    $firebase = new firebaseRDB($databaseURL);

    // Extract ID and data to update
    $id = $_POST['id'];
    $updateData = [
        "firstname" => $_POST['edit_firstname'] ?? '',
        "lastname" => $_POST['edit_lastname'] ?? '',
        "middlename" => $_POST['edit_middlename'] ?? '',
        "auxiliaryname" => $_POST['edit_auxiliaryname'] ?? '',
        "birthdate" => $_POST['edit_birthdate'] ?? '',
        "civilstatus" => $_POST['edit_civilstatus'] ?? '',
        "gender" => $_POST['edit_gender'] ?? '',
        "addressline1" => $_POST['edit_addressline1'] ?? '',
        "city" => $_POST['edit_city'] ?? '',
        "state" => $_POST['edit_state'] ?? '',
        "zipcode" => $_POST['edit_zipcode'] ?? '',
        "contactnumber" => $_POST['edit_contactnumber'] ?? '',
        "email" => $_POST['edit_email'] ?? '',
        "course" => $_POST['edit_course'] ?? '',
        "batch" => $_POST['edit_batch'] ?? '',
        "studentid" => $studentid
    ];

    // Function to check if Alumni ID already exists
    function isStudentIdExists($firebase, $studentid, $excludeId) {
        $table = 'alumni';
        $result = $firebase->retrieve($table);
        $result = json_decode($result, true);
        if ($result) {
            foreach ($result as $key => $record) {
                if ($key !== $excludeId && isset($record['studentid']) && $record['studentid'] === $studentid) {
                    return true;
                }
            }
        }
        return false;
    }

    // Function to get existing data
    function getExistingData($firebase, $id) {
        $table = 'alumni';
        $result = $firebase->retrieve($table . '/' . $id);
        return json_decode($result, true);
    }

    // Get existing data
    $existingData = getExistingData($firebase, $id);

    // Check if the Alumni ID is changing and if the new Alumni ID already exists
    if ($existingData['studentid'] !== $updateData['studentid']) {
        if (isStudentIdExists($firebase, $updateData['studentid'], $id)) {
            $response['message'] = 'Cannot update. The new Alumni ID already exists.';
            echo json_encode($response);
            exit;
        }
    }

    // Check if there are actual changes
    $isChanged = false;
    foreach ($updateData as $key => $value) {
        if (!isset($existingData[$key]) || $existingData[$key] !== $value) {
            $isChanged = true;
            break;
        }
    }

    if (!$isChanged) {
        $response['status'] = 'info';
        $response['message'] = 'You have not made any changes';
    } else {
        // Function to update alumni data
        function updateAlumniData($firebase, $id, $updateData) {
            $table = 'alumni'; // Assuming 'alumni' is your Firebase database node for alumni data
            $result = $firebase->update($table, $id, $updateData);
            return $result;
        }

        // Perform update
        $result = updateAlumniData($firebase, $id, $updateData);

        // Check result
        if ($result === null) {
            $response['message'] = 'Failed to update alumni data in Firebase.';
            error_log('Firebase error: Failed to update alumni data.');
        } else {
            $response['status'] = 'success';
            $response['message'] = 'Alumni data updated successfully!';
        }
    }
} else {
    $response['message'] = 'Invalid request method.';
}

// Return the JSON response
echo json_encode($response);
?>
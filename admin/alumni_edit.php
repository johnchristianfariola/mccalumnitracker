<?php
session_start();

header('Content-Type: application/json');

$response = array('status' => 'error', 'message' => 'An unexpected error occurred.');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!isset($_POST['edit_studentid']) || empty($_POST['edit_studentid'])) {
        $response['message'] = 'Alumni ID is required.';
        echo json_encode($response);
        exit;
    }

    $studentid = $_POST['edit_studentid'];
    if (!preg_match('/^\d{4}-\d{4}$/', $studentid)) {
        $response['message'] = 'Alumni ID must be in the format 1234-5678';
        echo json_encode($response);
        exit;
    }

    // Validate the year in the student ID
    $currentYear = date('Y');
    $idYear = substr($studentid, 0, 4);
    if ($currentYear - $idYear < 4) {
        $response['message'] = 'Alumni ID year must be at least 4 years ago';
        echo json_encode($response);
        exit;
    }

    require_once 'includes/firebaseRDB.php';
    require_once 'includes/config.php';
    $firebase = new firebaseRDB($databaseURL);

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

    // Get existing data
    $existingData = $firebase->retrieve('alumni/' . $id);
    $existingData = json_decode($existingData, true);

    if (!$existingData) {
        $response['message'] = 'Alumni record not found.';
        echo json_encode($response);
        exit;
    }

    // Check if the Alumni ID or email is changing and if they already exist
    $allAlumni = $firebase->retrieve('alumni');
    $allAlumni = json_decode($allAlumni, true);

    foreach ($allAlumni as $key => $alumni) {
        if ($key !== $id) {
            if ($alumni['studentid'] === $updateData['studentid'] && $updateData['studentid'] !== $existingData['studentid']) {
                $response['message'] = 'Cannot update. The new Alumni ID already exists.';
                echo json_encode($response);
                exit;
            }
            if ($alumni['email'] === $updateData['email'] && $updateData['email'] !== $existingData['email']) {
                $response['message'] = 'Cannot update. The new email already exists.';
                echo json_encode($response);
                exit;
            }
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
        // Perform update in Firebase
        $firebaseResult = $firebase->update('alumni', $id, $updateData);

        // Perform update in MySQL
        $mysqlConn = getMySQLConnection();

        if (!$mysqlConn) {
            $response['message'] = 'Failed to connect to MySQL database.';
            echo json_encode($response);
            exit;
        }

        $mysqlUpdateData = [
            'firstname' => $updateData['firstname'],
            'lastname' => $updateData['lastname'],
            'middlename' => $updateData['middlename'],
            'studentid' => $updateData['studentid']
        ];

        $mysqlQuery = "UPDATE alumni_verified SET ";
        $updateParts = [];
        foreach ($mysqlUpdateData as $key => $value) {
            $updateParts[] = "$key = '" . $mysqlConn->real_escape_string($value) . "'";
        }
        $mysqlQuery .= implode(", ", $updateParts);
        $mysqlQuery .= " WHERE id = '" . $mysqlConn->real_escape_string($id) . "'";

        $mysqlResult = $mysqlConn->query($mysqlQuery);

        $mysqlConn->close();

        if ($firebaseResult === null || !$mysqlResult) {
            $response['message'] = 'Failed to update alumni data in one or both databases.';
            error_log('Firebase error: ' . ($firebaseResult === null ? 'Failed to update' : 'Updated successfully'));
            error_log('MySQL error: ' . ($mysqlResult ? 'Updated successfully' : $mysqlConn->error));
        } else {
            $response['status'] = 'success';
            $response['message'] = 'Alumni data updated successfully in both databases!';
        }
    }
} else {
    $response['message'] = 'Invalid request method.';
}

echo json_encode($response);
?>
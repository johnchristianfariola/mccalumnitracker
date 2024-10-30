<?php
session_start();
header('Content-Type: application/json');
$response = array();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!isset($_POST['id']) || empty($_POST['id'])) {
        $response['status'] = 'error';
        $response['message'] = 'ID is required.';
        echo json_encode($response);
        exit;
    }

    require_once 'includes/firebaseRDB.php';
    require_once 'includes/config.php';

    $firebase = new firebaseRDB($databaseURL);
    $id = $_POST['id'];

    // Function to move alumni data to deleted_alumni node
    function moveAlumniDataToDeleted($firebase, $id) {
        $table = 'alumni';
        $deletedTable = 'deleted_alumni';

        // Retrieve the data from the alumni node
        $alumniData = $firebase->get($table, $id);
        if ($alumniData === null) {
            return false;
        }

        // Insert the data into the deleted_alumni node
        $result = $firebase->insert($deletedTable, $id, $alumniData);
        if ($result === null) {
            return false;
        }

        // Delete the data from the alumni node
        $deleteResult = $firebase->delete($table, $id);
        return $deleteResult !== null;
    }

    // Function to delete alumni data from MySQL
    function deleteAlumniDataFromMySQL($id) {
        $mysqlConn = getMySQLConnection();
        if (!$mysqlConn) {
            return false;
        }

        $query = "DELETE FROM applicant WHERE unique_id = ?";
        $stmt = $mysqlConn->prepare($query);
        $stmt->bind_param("s", $id);
        $result = $stmt->execute();

        $stmt->close();
        $mysqlConn->close();

        return $result;
    }

    // Move data to deleted_alumni and delete from alumni
    $firebaseResult = moveAlumniDataToDeleted($firebase, $id);

    // Perform delete in MySQL
    $mysqlResult = deleteAlumniDataFromMySQL($id);

    // Check results
    if (!$firebaseResult && !$mysqlResult) {
        $response['status'] = 'error';
        $response['message'] = 'Failed to delete alumni data from both Firebase and MySQL.';
        error_log('Firebase error: Failed to move/delete alumni data.');
        error_log('MySQL error: Failed to delete alumni data.');
    } elseif (!$firebaseResult) {
        $response['status'] = 'partial_success';
        $response['message'] = 'Alumni data deleted from MySQL but failed to move/delete from Firebase.';
        error_log('Firebase error: Failed to move/delete alumni data.');
    } elseif (!$mysqlResult) {
        $response['status'] = 'partial_success';
        $response['message'] = 'Alumni data moved/deleted from Firebase but failed to delete from MySQL.';
        error_log('MySQL error: Failed to delete alumni data.');
    } else {
        $response['status'] = 'success';
        $response['message'] = 'Alumni data moved to deleted_alumni and deleted successfully from both Firebase and MySQL!';
    }
} else {
    $response['status'] = 'error';
    $response['message'] = 'Invalid request method.';
}

echo json_encode($response);
?>
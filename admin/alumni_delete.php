<?php
session_start(); // Start the session
header('Content-Type: application/json'); // Set the content type to JSON
$response = array(); // Initialize response array

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Ensure ID is provided
    if (!isset($_POST['id']) || empty($_POST['id'])) {
        $response['status'] = 'error';
        $response['message'] = 'ID is required.';
        echo json_encode($response);
        exit;
    }

    // Include FirebaseRDB class and initialize
    require_once 'includes/firebaseRDB.php';
    require_once 'includes/config.php'; // Include your updated config file

    $firebase = new firebaseRDB($databaseURL);

    // Extract ID to delete
    $id = $_POST['id'];

    // Function to delete alumni data from Firebase
    function deleteAlumniDataFromFirebase($firebase, $id) {
        $table = 'alumni'; // Assuming 'alumni' is your Firebase database node for alumni data
        $result = $firebase->delete($table, $id);
        return $result;
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

    // Perform delete in Firebase
    $firebaseResult = deleteAlumniDataFromFirebase($firebase, $id);

    // Perform delete in MySQL
    $mysqlResult = deleteAlumniDataFromMySQL($id);

    // Check results
    if ($firebaseResult === null && !$mysqlResult) {
        $response['status'] = 'error';
        $response['message'] = 'Failed to delete alumni data from both Firebase and MySQL.';
        error_log('Firebase error: Failed to delete alumni data.');
        error_log('MySQL error: Failed to delete alumni data.');
    } elseif ($firebaseResult === null) {
        $response['status'] = 'partial_success';
        $response['message'] = 'Alumni data deleted from MySQL but failed to delete from Firebase.';
        error_log('Firebase error: Failed to delete alumni data.');
    } elseif (!$mysqlResult) {
        $response['status'] = 'partial_success';
        $response['message'] = 'Alumni data deleted from Firebase but failed to delete from MySQL.';
        error_log('MySQL error: Failed to delete alumni data.');
    } else {
        $response['status'] = 'success';
        $response['message'] = 'Alumni data deleted successfully from both Firebase and MySQL!';
    }
} else {
    $response['status'] = 'error';
    $response['message'] = 'Invalid request method.';
}

// Output JSON response
echo json_encode($response);
?>
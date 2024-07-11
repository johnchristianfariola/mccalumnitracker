<?php
session_start(); // Start the session

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Ensure the necessary data (lastname and studentid) is provided and not empty
    $required_fields = ['edit_lastname', 'edit_studentid'];

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
        $databaseURL = "https://mccnians-bc4f4-default-rtdb.firebaseio.com/";
        $firebase = new firebaseRDB($databaseURL);

        // Extract ID and data to update
        $id = $_POST['id'];
        $updateData = [
            "firstname" => $_POST['edit_firstname'] ?? '',
            "lastname" => $_POST['edit_lastname'],
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
            "studentid" => $_POST['edit_studentid']
        ];

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
            $_SESSION['error'] = 'Failed to update alumni data in Firebase.';
            error_log('Firebase error: Failed to update alumni data.');
        } else {
            $_SESSION['success'] = 'Alumni data updated successfully!';
        }

        // Redirect to the appropriate page (alumni.php) with preserved filter criteria
        header('Location: alumni.php?course=' . urlencode($_POST['edit_course']) . '&batch=' . urlencode($_POST['edit_batch']));
        exit;
    } else {
        $_SESSION['error'] = 'Last name and student ID are required.';
    }
} else {
    $_SESSION['error'] = 'Invalid request method.';
}

// Redirect to the appropriate page (alumni.php) on error
header('Location: alumni.php');
exit;
?>

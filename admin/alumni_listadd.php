<?php
session_start(); // Start the session

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Ensure all form fields are set and not empty
    if (
        isset($_POST['firstname']) && !empty($_POST['firstname']) &&
        isset($_POST['lastname']) && !empty($_POST['lastname']) &&
        isset($_POST['middlename']) && !empty($_POST['middlename']) &&
        isset($_POST['auxiliaryname']) && !empty($_POST['auxiliaryname']) &&
        isset($_POST['birthdate']) && !empty($_POST['birthdate']) &&
        isset($_POST['civilstatus']) && !empty($_POST['civilstatus']) &&
        isset($_POST['gender']) && !empty($_POST['gender']) &&
        isset($_POST['addressline1']) && !empty($_POST['addressline1']) &&
        isset($_POST['city']) && !empty($_POST['city']) &&
        isset($_POST['state']) && !empty($_POST['state']) &&
        isset($_POST['zipcode']) && !empty($_POST['zipcode']) &&
        isset($_POST['contactnumber']) && !empty($_POST['contactnumber']) &&
        isset($_POST['email']) && !empty($_POST['email']) &&
        isset($_POST['course']) && !empty($_POST['course']) &&
        isset($_POST['batch']) && !empty($_POST['batch']) &&
        isset($_POST['studentid']) && !empty($_POST['studentid'])
    ) {
        // Assign form data to variables
        $firstname = $_POST['firstname'];
        $lastname = $_POST['lastname'];
        $middlename = $_POST['middlename'];
        $auxiliaryname = $_POST['auxiliaryname'];
        $birthdate = $_POST['birthdate'];
        $civilstatus = $_POST['civilstatus'];
        $gender = $_POST['gender'];
        $addressline1 = $_POST['addressline1'];
        $city = $_POST['city'];
        $state = $_POST['state'];
        $zipcode = $_POST['zipcode'];
        $contactnumber = $_POST['contactnumber'];
        $email = $_POST['email'];
        $course = $_POST['course'];
        $batch = $_POST['batch']; // Corrected to 'batch' instead of 'batch_yr'
        $studentid = $_POST['studentid'];

        // Include Firebase RDB class and initialize
        require_once 'includes/firebaseRDB.php';
        $databaseURL = "https://mccnians-bc4f4-default-rtdb.firebaseio.com/";
        $firebase = new firebaseRDB($databaseURL);

        // Function to check if alumni data already exists
        function isAlumniDataExists($firebase, $firstname, $lastname, $studentid) {
            $table = 'alumni'; // Assuming 'alumni' is your Firebase database node for alumni data
            $result = $firebase->retrieve($table);
            $result = json_decode($result, true);
            if ($result) {
                foreach ($result as $record) {
                    if (
                        isset($record['firstname']) && $record['firstname'] === $firstname &&
                        isset($record['lastname']) && $record['lastname'] === $lastname &&
                        isset($record['studentid']) && $record['studentid'] === $studentid
                    ) {
                        return true;
                    }
                }
            }
            return false;
        }

        // Function to add alumni data
        function addAlumniData($firebase, $firstname, $lastname, $middlename, $auxiliaryname, $birthdate, $civilstatus, $gender, $addressline1, $city, $state, $zipcode, $contactnumber, $email, $course, $batch, $studentid) {
            $table = 'alumni'; // Assuming 'alumni' is your Firebase database node for alumni data
            $data = array(
                'firstname' => $firstname,
                'lastname' => $lastname,
                'middlename' => $middlename,
                'auxiliaryname' => $auxiliaryname,
                'birthdate' => $birthdate,
                'civilstatus' => $civilstatus,
                'gender' => $gender,
                'addressline1' => $addressline1,
                'city' => $city,
                'state' => $state,
                'zipcode' => $zipcode,
                'contactnumber' => $contactnumber,
                'email' => $email,
                'course' => $course,
                'batch' => $batch,
                'studentid' => $studentid
            );
            $result = $firebase->insert($table, $data);
            return $result;
        }

        // Check if alumni data already exists
        if (isAlumniDataExists($firebase, $firstname, $lastname, $studentid)) {
            $_SESSION['error'] = 'Alumni data already exists.';
        } else {
            // Add alumni data
            $result = addAlumniData($firebase, $firstname, $lastname, $middlename, $auxiliaryname, $birthdate, $civilstatus, $gender, $addressline1, $city, $state, $zipcode, $contactnumber, $email, $course, $batch, $studentid);

            // Check result
            if ($result === null) {
                $_SESSION['error'] = 'Failed to add alumni data to Firebase.';
                error_log('Firebase error: Failed to insert alumni data.');
            } else {
                $_SESSION['success'] = 'Alumni data added successfully!';
            }
        }

        // Redirect to the appropriate page (alumni.php) with preserved filter criteria
        header('Location: alumni.php?course=' . urlencode($course) . '&batch=' . urlencode($batch));
        exit;
    } else {
        $_SESSION['error'] = 'All fields are required.';
    }
} else {
    $_SESSION['error'] = 'Invalid request method.';
}

// Redirect to the appropriate page (alumni.php) on error
header('Location: alumni.php');
exit;
?>

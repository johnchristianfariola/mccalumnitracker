<?php
session_start(); // Start the session

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Check for CSRF token in the form submission
    if (isset($_POST['token']) && isset($_SESSION['token']) && $_POST['token'] === $_SESSION['token']) {
        // Invalidate the token after form submission to prevent double submission
        unset($_SESSION['token']);

        // Ensure last name and student ID fields are set and not empty
        if (isset($_POST['lastname']) && !empty($_POST['lastname']) && isset($_POST['studentid']) && !empty($_POST['studentid'])) {
            $studentid = $_POST['studentid'];

            // Validate the student ID format
            if (!preg_match('/^\d{4}-\d{4}$/', $studentid)) {
                $_SESSION['error'] = 'Student ID must be in the format 9033-1499.';
                header('Location: alumni.php');
                exit;
            }

            // Assign form data to variables
            $firstname = $_POST['firstname'] ?? '';
            $lastname = $_POST['lastname'];
            $middlename = $_POST['middlename'] ?? '';
            $auxiliaryname = $_POST['auxiliaryname'] ?? '';
            $birthdate = $_POST['birthdate'] ?? '';
            $civilstatus = $_POST['civilstatus'] ?? '';
            $gender = $_POST['gender'] ?? '';
            $addressline1 = $_POST['addressline1'] ?? '';
            $city = $_POST['city'] ?? '';
            $state = $_POST['state'] ?? '';
            $zipcode = $_POST['zipcode'] ?? '';
            $contactnumber = $_POST['contactnumber'] ?? '';
            $email = $_POST['email'] ?? '';
            $course = $_POST['course'] ?? '';
            $batch = $_POST['batch'] ?? '';

            // Include Firebase RDB class and initialize
            require_once 'includes/firebaseRDB.php';
            require_once 'includes/config.php'; // Include your config file
            $firebase = new firebaseRDB($databaseURL);

            // Function to check if alumni data already exists
            function isAlumniDataExists($firebase, $lastname, $studentid) {
                $table = 'alumni';
                $result = $firebase->retrieve($table);
                $result = json_decode($result, true);
                if ($result) {
                    foreach ($result as $record) {
                        if (
                            isset($record['lastname']) && $record['lastname'] === $lastname &&
                            isset($record['studentid']) && $record['studentid'] === $studentid
                        ) {
                            return true;
                        }
                    }
                }
                return false;
            }

            // Check if alumni data already exists
            if (isAlumniDataExists($firebase, $lastname, $studentid)) {
                $_SESSION['error'] = 'Alumni already exists.';
            } else {
                // Function to add alumni data
                function addAlumniData($firebase, $data) {
                    $table = 'alumni';
                    $result = $firebase->insert($table, $data);
                    return $result;
                }

                // Prepare alumni data
                $alumniData = array(
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
                    'studentid' => $studentid,
                    'forms_completed' => false
                );

                // Add alumni data
                $result = addAlumniData($firebase, $alumniData);

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
            $_SESSION['error'] = 'Last name and student ID are required.';
        }
    } else {
        $_SESSION['error'] = 'CSRF token validation failed.';
    }
} else {
    $_SESSION['error'] = 'Invalid request method.';
}

// Redirect to the appropriate page (alumni.php) on error
header('Location: alumni.php');
exit;
?>

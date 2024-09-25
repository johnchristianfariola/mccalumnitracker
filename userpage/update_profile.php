<?php
session_start();
include '../includes/firebaseRDB.php';
include '../includes/config.php';

$firebase = new firebaseRDB($databaseURL);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Validate the CSRF token
    if (!isset($_POST['token']) || $_POST['token'] !== $_SESSION['token']) {
        echo json_encode(['status' => 'error', 'message' => 'Invalid token']);
        exit();
    }

    // Validate and sanitize input data
    $alumni_id = htmlspecialchars($_POST['alumni_id'] ?? '');
    $firstname = htmlspecialchars($_POST['firstname'] ?? '');
    $middlename = htmlspecialchars($_POST['middlename'] ?? '');
    $lastname = htmlspecialchars($_POST['lastname'] ?? '');
    $auxiliaryname = htmlspecialchars($_POST['auxiliaryname'] ?? '');
    $birthdate = htmlspecialchars($_POST['birthdate'] ?? '');
    $gender = htmlspecialchars($_POST['gender'] ?? '');
    $civilstatus = htmlspecialchars($_POST['civilstatus'] ?? '');
    $addressline1 = htmlspecialchars($_POST['addressline1'] ?? '');
    $city = htmlspecialchars($_POST['city'] ?? '');
    $state = htmlspecialchars($_POST['state'] ?? '');
    $zipcode = htmlspecialchars($_POST['zipcode'] ?? '');
    $email = htmlspecialchars($_POST['email'] ?? '');
    $contactnumber = htmlspecialchars($_POST['contactnumber'] ?? '');
    $course = htmlspecialchars($_POST['course'] ?? '');
    $batch = htmlspecialchars($_POST['batch'] ?? '');
    $studentid = htmlspecialchars($_POST['studentid'] ?? '');
    $work_status = htmlspecialchars($_POST['work_status'] ?? '');
    $barangay = htmlspecialchars($_POST['barangay'] ?? '');

    $currentYear = date('Y');
    $idYear = substr($studentid, 0, 4);

    if ($currentYear - $idYear < 4) {
        echo json_encode(['status' => 'error', 'message' => 'Alumni ID year must be at least 4 years ago.']);
        exit();
    }

    // Handle file upload
    $profileImage = $_FILES['profileImage'] ?? null;
    $uploadDir = 'uploads/';
    $profile_url = '';

    if ($profileImage && $profileImage['error'] === UPLOAD_ERR_OK) {
        $uploadFile = $uploadDir . basename($profileImage['name']);
        if (move_uploaded_file($profileImage['tmp_name'], $uploadFile)) {
            $profile_url = $uploadFile;
        }
    }

    // Initialize the update data array for Firebase
    $firebaseUpdateData = [
        'firstname' => $firstname,
        'middlename' => $middlename,
        'lastname' => $lastname,
        'auxiliaryname' => $auxiliaryname,
        'birthdate' => $birthdate,
        'gender' => $gender,
        'civilstatus' => $civilstatus,
        'addressline1' => $addressline1,
        'city' => $city,
        'state' => $state,
        'zipcode' => $zipcode,
        'email' => $email,
        'contactnumber' => $contactnumber,
        'course' => $course,
        'batch' => $batch,
        'work_status' => $work_status,
        'barangay' => $barangay,
        'profile_url' => $profile_url,
        'forms_completed' => true,
        'date_responded' => date('F j, Y'),
        'studentid' => $studentid
    ];

    // Conditionally add employment-related fields if the status is "Employed"
    if ($work_status === 'Employed') {
        $employmentFields = [
            'first_employment_date', 'date_for_current_employment', 'type_of_work',
            'work_position', 'current_monthly_income', 'work_related',
            'work_classification', 'name_company', 'work_employment_status',
            'employment_location', 'job_satisfaction'
        ];

        foreach ($employmentFields as $field) {
            $firebaseUpdateData[$field] = htmlspecialchars($_POST[$field] ?? '');
        }
    }

    // Initialize the update data array for MySQL
    $mysqlUpdateData = [
        'firstname' => $firstname,
        'lastname' => $lastname,
        'middlename' => $middlename,
        'studentid' => $studentid,
        'forms_completed' => 1
    ];

    try {
        // Update alumni data in Firebase
        $firebase->update('alumni', $alumni_id, $firebaseUpdateData);

        // Update alumni data in MySQL
        $mysqlConn = getMySQLConnection();
        if (!$mysqlConn) {
            throw new Exception('Failed to connect to MySQL database.');
        }

        $mysqlQuery = "UPDATE alumni_verified SET ";
        $updateParts = [];
        foreach ($mysqlUpdateData as $key => $value) {
            $updateParts[] = "$key = '" . $mysqlConn->real_escape_string($value) . "'";
        }
        $mysqlQuery .= implode(", ", $updateParts);
        $mysqlQuery .= " WHERE id = '" . $mysqlConn->real_escape_string($alumni_id) . "'";

        $mysqlResult = $mysqlConn->query($mysqlQuery);

        if (!$mysqlResult) {
            throw new Exception('Failed to update MySQL database: ' . $mysqlConn->error);
        }

        $mysqlConn->close();

        // Update the session data
        $_SESSION['user'] = array_merge($_SESSION['user'], $firebaseUpdateData);
        
        // Set a flag indicating the form has been completed
        $_SESSION['forms_completed'] = true;

        echo json_encode(['status' => 'success', 'message' => 'Profile updated successfully']);
        exit();
    } catch (Exception $e) {
        error_log("Error updating profile: " . $e->getMessage());
        echo json_encode(['status' => 'error', 'message' => 'Failed to update profile. Please try again.']);
        exit();
    }
}
?>
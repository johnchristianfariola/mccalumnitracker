<?php
session_start();
require_once '../includes/firebaseRDB.php';
require_once '../includes/config.php';

$firebase = new firebaseRDB($databaseURL);

// Debug: Print all POST data
echo "<pre>POST data: ";
print_r($_POST);
echo "</pre>";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $alumni_id = $_SESSION['alumni_id'];
    
    // Collect form data with default values
    $updateData = [
        'firstname' => $_POST['firstname'] ?? '',
        'middlename' => $_POST['middlename'] ?? '',
        'lastname' => $_POST['lastname'] ?? '',
        'addressline1' => $_POST['addressline1'] ?? '',
        'zipcode' => $_POST['zipcode'] ?? '',
        'birthdate' => !empty($_POST['birthdate']) ? date('Y-m-d', strtotime($_POST['birthdate'])) : '',
        'gender' => $_POST['gender'] ?? '',
        'civilstatus' => $_POST['civilstatus'] ?? '',
        'contactnumber' => $_POST['contactnumber'] ?? '',
        'reserve_email' => $_POST['reserve_email'] ?? '',
        'work_status' => $_POST['work_status'] ?? '',
        'first_employment_date' => !empty($_POST['first_employment_date']) ? date('d-m-Y', strtotime($_POST['first_employment_date'])) : '',
        'date_for_current_employment' => !empty($_POST['current_employment_date']) ? date('d-m-Y', strtotime($_POST['current_employment_date'])) : '',
        'name_company' => $_POST['company_name'] ?? '',
        'employment_location' => $_POST['employment_location'] ?? '',
        'type_of_work' => $_POST['type_of_work'] ?? '',
        'work_position' => $_POST['work_position'] ?? '',
        'work_employment_status' => $_POST['employment_status'] ?? '',
        'current_monthly_income' => $_POST['monthly_income'] ?? '',
        'job_satisfaction' => $_POST['job_satisfaction'] ?? '',
        'work_related' => $_POST['related_to_course'] ?? '',
        'degree' => $_POST['degree'] ?? '',
        'major' => $_POST['major'] ?? '',
        'university' => $_POST['university'] ?? '',
        'graduation_year' => $_POST['graduation_year'] ?? ''
    ];

    // Update location data if provided
    if (!empty($_POST['regionSelect'])) {
        $updateData['region'] = $_POST['regionSelect'];
    }
    if (!empty($_POST['provinceSelect'])) {
        $updateData['state'] = $_POST['provinceSelect'];
    }
    if (!empty($_POST['citySelect'])) {
        $updateData['city'] = $_POST['citySelect'];
    }
    if (!empty($_POST['barangaySelect'])) {
        $updateData['barangay'] = $_POST['barangaySelect'];
    }

    // Debug: Print update data
    echo "<pre>Update data: ";
    print_r($updateData);
    echo "</pre>";

    // Update the data in Firebase
    $result = $firebase->update("alumni", $alumni_id, $updateData);

    if ($result) {
        $_SESSION['success'] = "Profile updated successfully!";
    } else {
        $_SESSION['error'] = "Error updating profile. Please try again.";
    }

    // Comment out the redirect for now
    // header("Location: profile.php");
    // exit();
} else {
    echo "Form not submitted via POST method.";
}
?>
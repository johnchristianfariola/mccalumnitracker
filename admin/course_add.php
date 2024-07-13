<?php
session_start(); // Start the session

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Ensure all form fields are set and not empty
    if (
        isset($_POST['course_name']) && !empty($_POST['course_name']) &&
        isset($_POST['courCode']) && !empty($_POST['courCode']) &&
        isset($_POST['department']) && !empty($_POST['department'])
    ) {
        $courseName = $_POST['course_name'];
        $courCode = $_POST['courCode'];
        $department = $_POST['department'];
 
        // Include Firebase RDB class and initialize
        require_once 'includes/firebaseRDB.php';
        require_once 'includes/config.php'; // Include your config file
        $firebase = new firebaseRDB($databaseURL);

        // Function to add a Course
        function addCourse($firebase, $courseName, $courCode, $department) {
            $table = 'course'; // Assuming 'Courses' is your Firebase database node for courses
            $data = array(
                'course_name' => $courseName,
                'courCode' => $courCode,
                'department' => $department
            );
            $result = $firebase->insert($table, $data);
            return $result;
        }

        // Add Course
        $result = addCourse($firebase, $courseName, $courCode, $department);

        // Check result
        if ($result === null) {
            $_SESSION['error'] = 'Failed to add Course to Firebase.';
            error_log('Firebase error: Failed to insert course data.');
        } else {
            $_SESSION['success'] = 'Course added successfully!';
        }
    } else {
        $_SESSION['error'] = 'All fields are required.';
    }
} else {
    $_SESSION['error'] = 'Invalid request method.';
}

// Redirect to the appropriate page (alumni.php) regardless of success or failure
header('Location: alumni.php');
exit;
?>

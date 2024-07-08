<?php
session_start(); // Start the session

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Ensure departmentName is set and not empty
    if (isset($_POST['departmentName']) && !empty($_POST['departmentName'])) {
        $departmentName = $_POST['departmentName'];

        // Process the data further (e.g., save to database, interact with Firebase, etc.)
        // Example: Connect to Firebase and add the department
        require_once 'includes/firebaseRDB.php';
        
        // Your Firebase Realtime Database URL
        $databaseURL = "https://mccnians-bc4f4-default-rtdb.firebaseio.com/";

        // Create an instance of the firebaseRDB class
        $firebase = new firebaseRDB($databaseURL);

        // Function to add a department
        function addDepartment($firebase, $departmentName) {
            $table = 'departments';
            $data = array('Department Name' => $departmentName);
            $result = $firebase->insert($table, $data);
            return $result;
        }

        // Add department
        $result = addDepartment($firebase, $departmentName);

        // Check result (you can handle errors or success as needed)
        if ($result === 'null') {
            $_SESSION['error'] = 'Failed to add department.';
        } else {
            $_SESSION['success'] = 'Department added successfully!';
            // Redirect back to the form page or any other desired page
            header('Location: alumni.php');
            exit; // Ensure that code below is not executed after redirection
        }
    } else {
        $_SESSION['error'] = 'Department name is required.';
    }
} else {
    $_SESSION['error'] = 'Invalid request method.';
}

// Redirect to the appropriate page (department_form.php) if there was an error
header('Location: alumni.php');
exit;
?>

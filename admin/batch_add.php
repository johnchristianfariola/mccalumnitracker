<?php
session_start(); // Start the session
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Ensure Batch is set and not empty
    if (isset($_POST['bacthName']) && !empty($_POST['bacthName'])) {
        $batchName = $_POST['bacthName'];

        // Process the data further (e.g., save to database, interact with Firebase, etc.)
        // Example: Connect to Firebase and add the department
        require_once 'includes/firebaseRDB.php';
        
        // Your Firebase Realtime Database URL
        $databaseURL = "https://mccnians-bc4f4-default-rtdb.firebaseio.com/";

        // Create an instance of the firebaseRDB class
        $firebase = new firebaseRDB($databaseURL);

        // Function to add a Batch
        function addBatch($firebase, $batchName) {
            $table = 'batch_yr';
            $data = array('batch_yrs' => $batchName);
            $result = $firebase->insert($table, $data);
            return $result;
        }

        // Add Batch
        $result = addBatch($firebase, $batchName);

        // Check result (you can handle errors or success as needed)
        if ($result === 'null') {
            $_SESSION['error'] = 'Failed to add Batch.';
        } else {
            $_SESSION['success'] = 'Batch added successfully!';
            // Redirect back to the form page or any other desired page
            header('Location: alumni.php');
            exit; // Ensure that code below is not executed after redirection
        }
    } else {
        $_SESSION['error'] = 'Batch name is required.';
    }
} else {
    $_SESSION['error'] = 'Invalid request method.';
}

// Redirect to the appropriate page (batch_form.php) if there was an error
header('Location: alumni.php');
exit;
?>

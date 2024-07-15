<?php
session_start(); // Start the session
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Ensure Batch is set and not empty
    if (isset($_POST['bacthName']) && !empty($_POST['bacthName'])) {
        $batchName = $_POST['bacthName'];

        // Process the data further (e.g., save to database, interact with Firebase, etc.)
        // Example: Connect to Firebase and add the department
        require_once 'includes/firebaseRDB.php';
        require_once 'includes/config.php'; // Include your config file
        $firebase = new firebaseRDB($databaseURL);

        // Function to check if Batch already exists
        function batchExists($firebase, $batchName) {
            $table = 'batch_yr';
            $existingBatches = $firebase->retrieve($table);
            $batches = json_decode($existingBatches, true);
            foreach ($batches as $batch) {
                if ($batch['batch_yrs'] === $batchName) {
                    return true;
                }
            }
            return false;
        }

        // Function to add a Batch
        function addBatch($firebase, $batchName) {
            $table = 'batch_yr';
            $data = array('batch_yrs' => $batchName);
            $result = $firebase->insert($table, $data);
            return $result;
        }

        // Check if the Batch already exists
        if (batchExists($firebase, $batchName)) {
            $_SESSION['error'] = 'Batch year already exists.';
        } else {
            // Add Batch
            $result = addBatch($firebase, $batchName);

            // Check result (you can handle errors or success as needed)
            if ($result === 'null') {
                $_SESSION['error'] = 'Failed to add Batch.';
            } else {
                $_SESSION['success'] = 'Batch added successfully!';
                // Redirect back to the form page or any other desired page
                header('Location: alumni.php');
                exit;
            }
        }
    } else {
        $_SESSION['error'] = 'Batch name is required.';
    }
} else {
    $_SESSION['error'] = 'Invalid request method.';
}

header('Location: alumni.php');
exit;
?>

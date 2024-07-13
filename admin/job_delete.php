<?php
session_start(); // Start the session

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
	// Ensure ID is provided
	if (!isset($_POST['id']) || empty($_POST['id'])) {
		$_SESSION['error'] = 'ID is required.';
		header('Location: job.php'); // Corrected redirect URL
		exit;
	}

	// Include FirebaseRDB class and initialize
	require_once 'includes/firebaseRDB.php';
	require_once 'includes/config.php'; // Include your config file
	$firebase = new firebaseRDB($databaseURL);

	// Extract ID to delete
	$id = $_POST['id'];

	// Function to delete job data
	function deleteJobData($firebase, $id)
	{
		$table = 'job'; // Assuming 'job' is your Firebase database node for job data
		$result = $firebase->delete($table, $id);
		return $result;
	}

	// Perform delete
	$result = deleteJobData($firebase, $id);

	// Check result
	if ($result === null) {
		$_SESSION['error'] = 'Failed to delete job data in Firebase.';
		error_log('Firebase error: Failed to delete job data.');
	} else {
		$_SESSION['success'] = 'Job data deleted successfully!';
	}

	// Redirect to the appropriate page (job.php)
	header('Location: job.php');
	exit;
} else {
	$_SESSION['error'] = 'Invalid request method.';
	header('Location: job.php'); // Redirect to job.php on invalid request method
	exit;
}
?>
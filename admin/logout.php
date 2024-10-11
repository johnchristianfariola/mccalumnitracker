<?php
session_start();

// Unset admin-specific session variables
unset($_SESSION['admin']);

// Redirect to the desired page after logging out
header('location: index.php');
exit();
?>

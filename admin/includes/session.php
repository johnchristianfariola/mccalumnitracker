<?php
session_start();
include 'includes/conn.php';

if (!isset($_SESSION['admin']) || trim($_SESSION['admin']) == '') {
	header('location: index.php');
}


$sql = "SELECT * FROM admin WHERE id = '" . $_SESSION['admin'] . "'";
$query = $conn->query($sql);
$user = $query->fetch_assoc();



if (!isset($_SESSION['token'])) {
	$_SESSION['token'] = bin2hex(random_bytes(32)); // Generate a random token
}

$token = $_SESSION['token'];
?>
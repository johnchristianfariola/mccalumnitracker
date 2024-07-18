<?php
session_name('admin_session');
session_start();
include 'includes/firebaseRDB.php';
require_once 'config.php';

$firebase = new firebaseRDB($databaseURL);

if (!isset($_SESSION['admin']) || trim($_SESSION['admin']) == '') {
    header('location: index.php');
    exit();
}

$adminId = $_SESSION['admin'];
$adminData = $firebase->retrieve("admin");
$adminData = json_decode($adminData, true);

if (!isset($adminData['user']) || $adminData['user'] !== $adminId) {
    header('location: index.php');
    exit();
}

$user = [
    'id' => $adminId,
    'user' => $adminData['user'],
    'password' => $adminData['password'],
    'firstname' => $adminData['firstname'],
    'lastname' => $adminData['lastname'],
    'image_url' => $adminData['image_url'],
    'created_on' => $adminData['created_on']
];

if (!isset($_SESSION['token'])) {
    $_SESSION['token'] = bin2hex(random_bytes(32));
}

$token = $_SESSION['token'];
?>

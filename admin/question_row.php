<?php
require_once 'includes/firebaseRDB.php';

$databaseURL = "https://mccnians-bc4f4-default-rtdb.firebaseio.com";
$firebase = new firebaseRDB($databaseURL);

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $question = $firebase->retrieve("questions/$id");
    echo $question;
} else {
    echo json_encode(['error' => 'Invalid request']);
}
?>

<?php
require_once '../includes/firebaseRDB.php';
require_once '../includes/config.php';

$firebase = new firebaseRDB($databaseURL);

if (isset($_POST['id'])) {
    $alumniId = $_POST['id'];
    $alumniData = $firebase->retrieve("alumni/$alumniId");
    echo $alumniData;
} else {
    echo json_encode(['error' => 'No ID provided']);
}
?>  
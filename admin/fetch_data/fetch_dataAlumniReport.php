<?php
require_once 'includes/firebaseRDB.php';

$databaseURL = "https://mccnians-bc4f4-default-rtdb.firebaseio.com";
$firebase = new firebaseRDB($databaseURL);

function getFirebaseData($firebase, $path) {
    $data = $firebase->retrieve($path);
    return json_decode($data, true);
}

function sanitizeInput($data) {
    return htmlspecialchars(strip_tags($data));
}

$alumniData = getFirebaseData($firebase, "alumni");
$batchData = getFirebaseData($firebase, "batch_yr");
$courseData = getFirebaseData($firebase, "course");

$filterCourse = isset($_GET['course']) ? sanitizeInput($_GET['course']) : '';
$filterBatch = isset($_GET['batch']) ? sanitizeInput($_GET['batch']) : '';

// Check if alumniData is an array before looping through it
if (is_array($alumniData) && count($alumniData) > 0) {
    foreach ($alumniData as $id => $alumni) {
        if (!isset($alumni['forms_completed']) || $alumni['forms_completed'] !== true) {
            continue;
        }

        $courseId = $alumni['course'];
        $batchId = $alumni['batch'];

        if ($filterCourse && $filterCourse != $courseId) {
            continue;
        }
        if ($filterBatch && $filterBatch != $batchId) {
            continue;
        }

        $batchName = isset($batchData[$batchId]['batch_yrs']) ? $batchData[$batchId]['batch_yrs'] : 'Unknown Batch';
        $courseName = isset($courseData[$courseId]['courCode']) ? $courseData[$courseId]['courCode'] : 'Unknown Course';

        echo "<tr>
        <td style='display:none;'><input type='checkbox' class='modal-checkbox'  data-id='$id'></td>
        <td>{$alumni['studentid']}</td>
        <td>{$alumni['firstname']} {$alumni['middlename']} {$alumni['lastname']}</td>
        <td>{$courseName}</td>
        <td>{$batchName}</td>
        <td>{$alumni['work_status']}</td>
        <td>{$alumni['date_responded']}</td>
        <td>
        <a class='btn btn-warning btn-sm btn-flat open-modal' data-id='$id'>VIEW</a>

        </td>
        </tr>";
    } 
} 
?>

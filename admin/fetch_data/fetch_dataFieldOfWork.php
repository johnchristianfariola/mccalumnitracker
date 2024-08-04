<?php
require_once 'includes/firebaseRDB.php';
require_once 'includes/config.php'; // Include your config file

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
$filterStatus = isset($_GET['work_status']) ? sanitizeInput($_GET['work_status']) : '';

// Initialize counters
$employedCount = 0;
$unemployedCount = 0;
$totalCount = 0;


// Check if alumniData is an array before looping through it
if (is_array($alumniData) && count($alumniData) > 0) {
    foreach ($alumniData as $id => $alumni) {
        if (!isset($alumni['forms_completed']) || $alumni['forms_completed'] !== true) {
            continue;
        }

        $courseId = $alumni['course'];
        $batchId = $alumni['batch'];
        $workStatus = $alumni['work_status'];

        if ($filterCourse && $filterCourse != $courseId) {
            continue;
        }
        if ($filterBatch && $filterBatch != $batchId) {
            continue;
        }
        if ($filterStatus && $filterStatus != $workStatus) {
            continue;
        }

        // Count based on work status
        if ($workStatus === 'Employed') {
            $employedCount++;
        } elseif ($workStatus === 'Unemployed') {
            $unemployedCount++;
        }
        $totalCount++;

        $batchName = isset($batchData[$batchId]['batch_yrs']) ? $batchData[$batchId]['batch_yrs'] : 'Unknown Batch';
        $courseName = isset($courseData[$courseId]['courCode']) ? $courseData[$courseId]['courCode'] : 'Unknown Course';

        echo "<tr>
        <td style='display:none;'><input type='checkbox' class='modal-checkbox' data-id='$id'></td>
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

// Close tabllts, display a message
?>
<?php
require_once 'includes/firebaseRDB.php';

$databaseURL = "https://mccnians-bc4f4-default-rtdb.firebaseio.com";
$firebase = new firebaseRDB($databaseURL);

$eventParticipationData = $firebase->retrieve("event_participation");
$eventParticipationData = json_decode($eventParticipationData, true);

$alumniData = $firebase->retrieve("alumni");
$alumniData = json_decode($alumniData, true);

$eventData = $firebase->retrieve("event");
$eventData = json_decode($eventData, true);

$batchData = $firebase->retrieve("batch_yr");
$batchData = json_decode($batchData, true);

$courseData = $firebase->retrieve("course");
$courseData = json_decode($courseData, true);

$filterEventId = $_GET['event_id'] ?? '';
$filterCourse = $_GET['course'] ?? '';
$filterBatch = $_GET['batch'] ?? '';

if (is_array($eventParticipationData) && is_array($alumniData) && is_array($eventData)) {
    foreach ($eventParticipationData as $id => $eventParticipation) {
        $alumniId = $eventParticipation['alumni_id'];
        $eventId = $eventParticipation['event_id'];
        $participation = $eventParticipation['participation'];

        if ($participation === "Participated") {
            $participation_html = '<span class="label label-success" style="font-size: 12px !important; padding: 5px 20px !important; background: gold !important; color:black !important; border: 1px solid black !important">PARTICIPATED</span>';
        }

        if (isset($alumniData[$alumniId]) && isset($eventData[$eventId])) {
            $alumni = $alumniData[$alumniId];
            $eventTitle = $eventData[$eventId]['event_title'];

            $alumniName = $alumni['firstname'] . " " . $alumni['lastname'];
            $courseId = $alumni['course'];
            $batchId = $alumni['batch'];
            $dateResponded = $alumni['date_responded'];

            $courseName = isset($courseData[$courseId]) ? $courseData[$courseId]['courCode'] : 'Unknown Course';
            $batchYear = isset($batchData[$batchId]) ? $batchData[$batchId]['batch_yrs'] : 'Unknown Batch';

            if ((!$filterEventId || $eventId == $filterEventId) && (!$filterCourse || $filterCourse == $courseId) && (!$filterBatch || $filterBatch == $batchId)) {
                echo "<tr>
                        <td style='display:none;'></td>
                        <td>{$alumni['studentid']}</td>
                        <td>{$alumniName}</td>
                        <td>{$courseName}</td>
                        <td>{$batchYear}</td>
                        <td>{$participation_html}</td>
                        <td>{$dateResponded}</td>
                        <td>{$eventTitle}</td>
                      </tr>";
            }
        }
    }
} else {
    echo "<tr><td colspan='8'>No data found.</td></tr>";
}
?>

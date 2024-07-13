<?php
require_once 'includes/firebaseRDB.php';


require_once 'config.php'; // Include your config file

$firebase = new firebaseRDB($databaseURL);

$coursesData = $firebase->retrieve("course");
$batchYearsData = $firebase->retrieve("batch_yr");
$alumniData = $firebase->retrieve("alumni");
$eventsData = $firebase->retrieve("event");
$eventParticipationData = $firebase->retrieve("event_participation");

$courses = json_decode($coursesData, true) ?: [];
$batchYears = json_decode($batchYearsData, true) ?: [];
$alumni = json_decode($alumniData, true) ?: [];
$events = json_decode($eventsData, true) ?: [];
$eventParticipations = json_decode($eventParticipationData, true) ?: [];

// Group participants by event, batch year, and course
$groupedParticipants = [];

foreach ($eventParticipations as $participationId => $participationDetails) {
    $eventId = $participationDetails['event_id'];
    $alumniId = $participationDetails['alumni_id'];
    
    if (isset($events[$eventId]) && isset($alumni[$alumniId])) {
        $alumniDetails = $alumni[$alumniId];
        $batchId = $alumniDetails['batch'];
        $courseId = $alumniDetails['course'];

        if (!isset($groupedParticipants[$eventId])) {
            $groupedParticipants[$eventId] = [];
        }

        if (!isset($groupedParticipants[$eventId][$batchId])) {
            $groupedParticipants[$eventId][$batchId] = [];
        }

        if (!in_array($courseId, $groupedParticipants[$eventId][$batchId])) {
            $groupedParticipants[$eventId][$batchId][] = $courseId;
        }
    }
}
?>
<div>
    <div class="alumni-count-container" style="padding-top: 20px">
        <span class="all-alumni"><a href="event_report.php">All Respondents</a></span>
    </div>
</div>
<hr>
<?php
foreach ($groupedParticipants as $eventId => $batches) {
    $event = $events[$eventId];
    echo '<button class="collapsible transparent">' . htmlspecialchars($event['event_title']) . '<i class="fa fa-angle-right arrow"></i></button>';
    echo '<div class="contents">';

    foreach ($batches as $batchId => $courseIds) {
        foreach ($courseIds as $courseId) {
            if (isset($courses[$courseId]) && isset($batchYears[$batchId])) {
                $batchYear = $batchYears[$batchId]['batch_yrs'];
                $courseCode = $courses[$courseId]['courCode'];
                $url = "event_report.php?event_id={$eventId}&course={$courseId}&batch={$batchId}";
                echo '<button class="collaps-department transparent"><a href="' . htmlspecialchars($url) . '">' . htmlspecialchars($courseCode) . ' - Batch ' . htmlspecialchars($batchYear) . '</a></button>';
            }
        }
    }

    echo '</div>';
}
?>
<script>
    document.addEventListener("DOMContentLoaded", function () {
        function closeAllExcept(current, className) {
            var coll = document.getElementsByClassName(className);
            for (var i = 0; i < coll.length; i++) {
                if (coll[i] !== current) {
                    coll[i].classList.remove("active");
                    var content = coll[i].nextElementSibling;
                    if (content) {
                        content.classList.remove("active");
                    }
                }
            }
        }

        function toggleContent(className) {
            var coll = document.getElementsByClassName(className);
            for (var i = 0; i < coll.length; i++) {
                coll[i].addEventListener("click", function () {
                    closeAllExcept(this, className);
                    this.classList.toggle("active");
                    var content = this.nextElementSibling;
                    if (content) {
                        content.classList.toggle("active");
                    }
                });
            }
        }

        toggleContent("collapsible");
    });
</script>

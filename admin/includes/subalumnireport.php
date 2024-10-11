<?php
require_once 'includes/firebaseRDB.php';


require_once 'config.php'; // Include your config file

$firebase = new firebaseRDB($databaseURL);

// Fetch courses, departments, batch years, and alumni data from Firebase
$coursesData = $firebase->retrieve("course");
$batchYearsData = $firebase->retrieve("batch_yr");
$alumniData = $firebase->retrieve("alumni");

// Decode JSON data into associative arrays
$courses = json_decode($coursesData, true) ?: [];
$batchYears = json_decode($batchYearsData, true) ?: [];
$alumni = json_decode($alumniData, true) ?: [];

// Prepare an array to store alumni grouped by batch year
$alumniByBatch = [];

// Count the total number of alumni with forms_completed set to true
$totalAlumniCount = 0;

// Iterate through alumni and group by batch year
foreach ($alumni as $alumniId => $alumniDetails) {
    // Check if forms_completed is true
    if (isset($alumniDetails['forms_completed']) && $alumniDetails['forms_completed']) {
        $totalAlumniCount++;
        
        $batchId = $alumniDetails['batch'];
        $courseId = $alumniDetails['course'];

        // Initialize the batch year array if it doesn't exist
        if (!isset($alumniByBatch[$batchId])) {
            $alumniByBatch[$batchId] = [];
        }

        // Add the course to the batch year if not already added
        if (!in_array($courseId, $alumniByBatch[$batchId])) {
            $alumniByBatch[$batchId][] = $courseId;
        }
    }
}
?>
<div>
    <div class="alumni-count-container" style="padding-top: 20px">
        <span class="all-alumni"><a href="alumni_report.php">All Respondent</a></span>
        <div class="count"><?php echo $totalAlumniCount; ?></div>
    </div>
</div>
<hr>
<?php
// Output alumni grouped by batch year
foreach ($alumniByBatch as $batchId => $courseIds) {
    $batchYear = isset($batchYears[$batchId]['batch_yrs']) ? $batchYears[$batchId]['batch_yrs'] : 'Unknown Batch Year';
    echo '<button class="collapsible transparent">'. 'BATCH' . ' ' . htmlspecialchars($batchYear) . '<i class="fa fa-angle-right arrow"></i></button>';
    echo '<div class="contents">';

    // Output courses within the batch year
    foreach ($courseIds as $courseId) {
        if (isset($courses[$courseId])) {
            $courseCode = $courses[$courseId]['courCode'];
            $courseName = $courses[$courseId]['course_name'];
            echo '<button class="collaps-department transparent" data-course-id="' . htmlspecialchars($courseId) . '" data-batch-id="' . htmlspecialchars($batchId) . '">' . htmlspecialchars($courseCode) . '</button>';
        }
    }

    echo '</div>';
}
?>
<script>
    document.querySelectorAll('.collaps-department').forEach(button => {
        button.addEventListener('click', function () {
            const courseId = this.getAttribute('data-course-id');
            const batchId = this.getAttribute('data-batch-id');
            window.location.href = `alumni_report.php?course=${courseId}&batch=${batchId}`;
        });
    });
</script>
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
                    // Close all other collapsibles of the same class
                    closeAllExcept(this, className);

                    // Toggle the clicked collapsible
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

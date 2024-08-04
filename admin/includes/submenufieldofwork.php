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
    <div class="alumni-count-container">
        <span class="all-alumni"><a href="field_of_work.php">All Respondent</a></span>
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
            echo '<div class="course-container">';
            echo '<button class="collaps-department transparent" data-course-id="' . htmlspecialchars($courseId) . '" data-batch-id="' . htmlspecialchars($batchId) . '">' . htmlspecialchars($courseCode) . '</button>';
            echo '<select class="work-status-dropdown" style="display:none;">';
            echo '<option value="">Select Status</option>';
            echo '<option value="Unemployed">Unemployed</option>';
            echo '<option value="Employed">Employed</option>';
            echo '</select>';
            echo '</div>';
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

        // New functionality for course buttons and dropdowns
        document.querySelectorAll('.collaps-department').forEach(button => {
            button.addEventListener('click', function (event) {
                event.preventDefault(); // Prevent default link behavior
                const courseId = this.getAttribute('data-course-id');
                const batchId = this.getAttribute('data-batch-id');
                const dropdown = this.nextElementSibling;

                // Toggle dropdown visibility
                dropdown.style.display = dropdown.style.display === 'none' ? 'inline-block' : 'none';

                // If dropdown is hidden, navigate to the report page
                if (dropdown.style.display === 'none') {
                    window.location.href = `field_of_work.php?course=${courseId}&batch=${batchId}`;
                }
            });
        });

        // Handle dropdown selection
        document.querySelectorAll('.work-status-dropdown').forEach(dropdown => {
            dropdown.addEventListener('change', function() {
                const courseId = this.previousElementSibling.getAttribute('data-course-id');
                const batchId = this.previousElementSibling.getAttribute('data-batch-id');
                const workStatus = this.value;
                if (workStatus) {
                    window.location.href = `field_of_work.php?course=${courseId}&batch=${batchId}&work_status=${workStatus}`;
                }
            });
        });
    });
</script>

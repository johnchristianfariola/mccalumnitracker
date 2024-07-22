<?php
require_once 'includes/firebaseRDB.php';
require_once 'config.php'; // Include your config file

$firebase = new firebaseRDB($databaseURL);

// Fetch courses, departments, batch years, and alumni data from Firebase
$coursesData = $firebase->retrieve("course");
$departmentsData = $firebase->retrieve("departments");
$batchYearsData = $firebase->retrieve("batch_yr");
$alumniData = $firebase->retrieve("alumni");

// Decode JSON data into associative arrays
$courses = json_decode($coursesData, true) ?: [];
$departments = json_decode($departmentsData, true) ?: [];
$batchYears = json_decode($batchYearsData, true) ?: [];
$alumni = json_decode($alumniData, true) ?: [];

// Prepare an array to store courses filtered by department ID
$filteredCourses = [];

// Count the total number of alumni
$totalAlumniCount = count($alumni);

// Iterate through courses and filter by department ID
foreach ($courses as $courseId => $course) {
    $departmentId = isset($course['department']) ? $course['department'] : null;

    if ($departmentId && isset($departments[$departmentId])) {
        $departmentName = isset($departments[$departmentId]['Department Name']) ? $departments[$departmentId]['Department Name'] : 'Unknown';

        // Initialize array to store batch years
        $courseBatchYears = [];

        // Find batch years for current course
        foreach ($batchYears as $batchId => $batch) {
            $courseBatchYears[$batchId] = $batch['batch_yrs'];
        }

        // Sort batch years in ascending order
        asort($courseBatchYears);

        // Build the filtered course data
        $filteredCourses[$departmentName][] = [
            'courseId' => $courseId,
            'courseCode' => isset($course['courCode']) ? $course['courCode'] : 'Unknown',
            'courseName' => isset($course['course_name']) ? $course['course_name'] : 'Unknown',
            'batchYears' => $courseBatchYears
        ];
    }
}
?>

<div class="manage-alumni">
    <button type="button" class="btn-gradient-info btn-fw" id="toggle-button">
        <span class="menu-title">Manage Alumni</span>
        <i class="fa fa-cog menu-icon"></i>
    </button>
    <center>
        <ul id="dropdown-menu">
            <br>
            <li><a class="sub-side-modal" data-toggle="modal" data-target="#addDepartment"><i class="fa fa-building"></i>&nbsp; Add Department</a></li>
            <li><a class="sub-side-modal" data-toggle="modal" data-target="#course-modal"><i class="fa fa-laptop"></i>&nbsp; Add Course</a></li>
            <li><a class="sub-side-modal" data-toggle="modal" data-target="#batch-modal"><i class="fa fa-laptop"></i>&nbsp; Add Batch</a></li>
        </ul>
    </center>
</div>
<div>
    <div class="alumni-count-container">
        <span class="all-alumni"><a href="alumni.php">All Alumni</a></span>
        <div class="count"><?php echo $totalAlumniCount; ?></div>
    </div>
</div>
<hr>
<?php
// Output courses grouped by department
foreach ($filteredCourses as $departmentName => $courses) {
    echo '<button class="collapsible transparent">' . htmlspecialchars($departmentName) . '<i class="fa fa-angle-right arrow"></i></button>';
    echo '<div class="contents">';
    foreach ($courses as $course) {
        echo '<button class="collaps-department transparent" data-course-id="' . htmlspecialchars($course['courseId']) . '">' . htmlspecialchars($course['courseCode']) . '<i class="fa fa-angle-right arrow"></i></button>';
        echo '<div class="content-batch">';
        foreach ($course['batchYears'] as $batchId => $batchYear) {
            echo '<button class="collaps-year transparent" data-course-id="' . htmlspecialchars($course['courseId']) . '" data-batch-id="' . htmlspecialchars($batchId) . '">' . htmlspecialchars($batchYear) . '</button>';
        }
        echo '</div>';
    }
    echo '</div>';
}
?>
<script>
    document.querySelectorAll('.collaps-year').forEach(button => {
        button.addEventListener('click', function () {
            const courseId = this.getAttribute('data-course-id');
            const batchId = this.getAttribute('data-batch-id');
            window.location.href = `alumni.php?course=${courseId}&batch=${batchId}`;
        });
    });
</script>
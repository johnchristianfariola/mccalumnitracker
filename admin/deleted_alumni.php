<?php include 'includes/session.php'; ?>
<?php include 'includes/header.php'; ?>

<head>
<?php
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
</head>

<body class="hold-transition skin-blue sidebar-mini">
<div class="wrapper">
    <?php include 'includes/navbar.php'; ?>
    <?php include 'includes/menubar.php'; ?>

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper content-flex">
        <!-- Main container -->
        <div class="main-container">
            <!-- Content Header (Page header) -->
            <section class="content-header box-header-background">
                <h1>Alumni List</h1>
                <div class="box-inline">
                    <div class="search-container">
                        <input type="text" class="search-input" id="search-input" placeholder="Search...">
                        <button class="search-button" onclick="filterTable()">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round" class="feather feather-search">
                                <circle cx="11" cy="11" r="8"></circle>
                                <line x1="21" y1="21" x2="16.65" y2="16.65"></line>
                            </svg>
                        </button>
                    </div>
                </div>

                <ol class="breadcrumb">
                    <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
                    <li>Archive</li>
                    <li class="active" style="color:white; !important">Deleted Alumni List</li>
                </ol>
            </section>

            <!-- Main content -->
            <section class="content">
                <?php
                if (isset($_SESSION['error'])) {
                    $errorMessage = addslashes($_SESSION['error']);
                    echo "<script>
                    document.addEventListener('DOMContentLoaded', function() {
                        showAlert('error', '{$errorMessage}');
                    });
                    </script>";
                    unset($_SESSION['error']);
                }
                if (isset($_SESSION['success'])) {
                    $successMessage = addslashes($_SESSION['success']);
                    echo "<script>
                    document.addEventListener('DOMContentLoaded', function() {
                        showAlert('success', '{$successMessage}');
                    });
                    </script>";
                    unset($_SESSION['success']);
                }
                ?>

                <div class="row">
                    <div class="table-container col-xs-12">
                        <div class="box">
                            <div class="box-header"></div>
                            <div class="box-body">
                                <div class="table-responsive"> <!-- Add this div for responsive behavior -->
                                    <table id="example1" class="table table-bordered printable-table">
                                        <thead>
                                            <tr>
                                                <th style="display:none;"></th>
                                                <th>Alumni ID</th>
                                                <th>First Name</th>
                                                <th>Middle Name</th>
                                                <th>Last Name</th>
                                                <th>Email</th>
                                                <th>Gender</th>
                                                <th>Course</th>
                                                <th>Batch</th>
                                                <th>Tools</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php include 'fetch_data/fetch_deletedAlumni.php' ?>
                                        </tbody>
                                    </table>
                                    <!-- Modal -->
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </div>

    <?php include 'includes/deleted_alumni_modal.php'; ?>
</div>

<?php include 'includes/scripts.php'; ?>
</body>

<script>
$(document).ready(function () {
    // Use event delegation to handle delete modal
    $(document).on('click', '.open-delete', function () {
        var id = $(this).data('id');
        $.ajax({
            url: 'deleted_alumni_row.php',
            type: 'GET',
            data: { id: id },
            dataType: 'json',
            success: function (response) {
                // Populate modal with alumni name
                $('.deleteId').val(id);
                var fullName = response.firstname + ' ' + response.middlename + ' ' + response.lastname;
                $('.editFirstname, .editMiddlename, .editLastname').text(fullName);
                $('.editStudentid').text(response.studentid);

                // Show the delete confirmation modal
                $('#deleteModal').modal('show');
            },
            error: function (xhr, status, error) {
                console.error('AJAX Error: ' + status + ' ' + error);
            }
        });
    });

    // Handle alumni delete form submission
    $('#deleteModal form').on('submit', function (event) {
        event.preventDefault(); // Prevent the default form submission

        var formData = $(this).serialize(); // Serialize form data

        $.ajax({
            type: 'POST',
            url: 'deleted_alumni_delete.php', // The URL of your PHP script for deleting alumni
            data: formData,
            dataType: 'json',
            success: function (response) {
                $('#deleteModal').modal('hide'); // Hide the modal after the operation
                if (response.status === 'success') {
                    showAlert('success', response.message);
                } else {
                    showAlert('error', response.message);
                }
            },
            error: function () {
                $('#deleteModal').modal('hide'); // Hide the modal in case of error
                showAlert('error', 'An unexpected error occurred.');
            }
        });
    });

    // Use event delegation to handle retrieve modal
    $(document).on('click', '.open-retrieve', function () {
        var id = $(this).data('id');
        $.ajax({
            url: 'deleted_alumni_row.php',
            type: 'GET',
            data: { id: id },
            dataType: 'json',
            success: function (response) {
                // Populate modal with alumni name
                $('.retrieveId').val(id);
                var fullName = response.firstname + ' ' + response.middlename + ' ' + response.lastname;
                $('.editFirstname, .editMiddlename, .editLastname').text(fullName);
                $('.editStudentid').text(response.studentid);

                // Show the retrieve confirmation modal
                $('#retrieveModal').modal('show');
            },
            error: function (xhr, status, error) {
                console.error('AJAX Error: ' + status + ' ' + error);
            }
        });
    });

    // Handle alumni retrieve form submission
    $('#retrieveModal form').on('submit', function (event) {
        event.preventDefault(); // Prevent the default form submission

        var formData = $(this).serialize(); // Serialize form data

        $.ajax({
            type: 'POST',
            url: 'deleted_alumni_retrieve.php', // The URL of your PHP script for retrieving alumni
            data: formData,
            dataType: 'json',
            success: function (response) {
                $('#retrieveModal').modal('hide'); // Hide the modal after the operation
                if (response.status === 'success') {
                    showAlert('success', response.message);
                } else {
                    showAlert('error', response.message);
                }
            },
            error: function () {
                $('#retrieveModal').modal('hide'); // Hide the modal in case of error
                showAlert('error', 'An unexpected error occurred.');
            }
        });
    });

    // Function to display SweetAlert messages
    function showAlert(type, message) {
        Swal.fire({
            position: 'top-end',
            icon: type,
            title: message,
            showConfirmButton: false,
            timer: 2500,
            willClose: () => {
                if (type === 'success') {
                    location.reload(); // Reload the page after the success message
                }
            }
        });
    }
});
</script>

</html>
<?php include 'includes/session.php'; ?>
<?php include 'includes/header.php'; ?>

<head>
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
                    <h1>Deleted Survey List</h1>
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
                        <li class="active" style="color:white; !important">Deleted Survey List</li>
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
                                                    <th>Title</th>
                                                    <th>Description</th>
                                                    <th width="15%">Start Date</th>
                                                    <th width="15%">End Date</th>
                                                    <th width="15%">Tools</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php include 'fetch_data/fetch_deleteSurvey.php' ?>
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

        <?php include 'includes/archive_modal.php'; ?>
    </div>

    <?php include 'includes/scripts.php'; ?>
</body>
<script>
$(document).ready(function () {
    // Handle restore button click
    $(document).on('click', '.open-retrieve', function () {
        var id = $(this).data('id');
        
        // Fetch survey details using AJAX
        $.ajax({
            url: 'deleted_survey_row.php', // Ensure this URL is correct
            type: 'GET',
            data: { id: id },
            dataType: 'json',
            success: function (response) {
                if (response) {
                    // Populate restore modal with survey details
                    $('.retrieveId').val(id);
                    $('.restoreSurveyTitle').text(response.survey_title);
                    $('#restoreSurveyModal').modal('show');
                } else {
                    showAlert('error', 'Failed to fetch survey details.');
                }
            },
            error: function (xhr, status, error) {
                console.error('AJAX Error: ' + status + ' ' + error);
                showAlert('error', 'Failed to fetch survey details.');
            }
        });
    });

    // Handle restore form submission
    $('#restoreSurveyForm').on('submit', function (event) {
        event.preventDefault();
        var formData = $(this).serialize();
        
        $.ajax({
            type: 'POST',
            url: 'deleted_survey_retrieve.php', // Ensure this URL is correct
            data: formData,
            dataType: 'json',
            success: function (response) {
                $('#restoreSurveyModal').modal('hide');
                if (response.status === 'success') {
                    showAlert('success', response.message);
                } else {
                    showAlert('error', response.message);
                }
            },
            error: function () {
                $('#restoreSurveyModal').modal('hide');
                showAlert('error', 'An unexpected error occurred.');
            }
        });
    });

    // Handle delete button click
    $(document).on('click', '.open-delete', function () {
        var id = $(this).data('id');
        
        // Fetch survey details using AJAX
        $.ajax({
            url: 'deleted_survey_row.php', // Ensure this URL is correct
            type: 'GET',
            data: { id: id },
            dataType: 'json',
            success: function (response) {
                if (response) {
                    // Populate delete modal with survey details
                    $('.deleteId').val(id);
                    $('.deleteSurveyTitle').text(response.survey_title);
                    $('#deleteSurveyModal').modal('show');
                } else {
                    showAlert('error', 'Failed to fetch survey details.');
                }
            },
            error: function (xhr, status, error) {
                console.error('AJAX Error: ' + status + ' ' + error);
                showAlert('error', 'Failed to fetch survey details.');
            }
        });
    });

    // Handle delete form submission
    $('#deleteSurveyForm').on('submit', function (event) {
        event.preventDefault();
        var formData = $(this).serialize();
        
        $.ajax({
            type: 'POST',
            url: 'deleted_survey_delete.php', // Ensure this URL is correct
            data: formData,
            dataType: 'json',
            success: function (response) {
                $('#deleteSurveyModal').modal('hide');
                if (response.status === 'success') {
                    showAlert('success', response.message);
                } else {
                    showAlert('error', response.message);
                }
            },
            error: function () {
                $('#deleteSurveyModal').modal('hide');
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
                    location.reload();
                }
            }
        });
    }
});
</script>

</html>
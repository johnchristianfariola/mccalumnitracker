<?php include 'includes/session.php'; ?>
<?php include 'includes/header.php'; ?>

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
          <h1>
            Alumni List
          </h1>
          <div class="box-inline">
            <a href="#addnew" data-toggle="modal" class="btn-add-class btn btn-primary btn-sm btn-flat">
              <i class="fa fa-plus-circle"></i>&nbsp;&nbsp; New
            </a>

            <a href="#exportnew" data-toggle="modal" class="btn-add-class btn btn-primary btn-sm btn-flat">
              <i class="fa fa-plus-circle"></i>&nbsp;&nbsp; Import
            </a>

            <!-- <a href="#print" data-toggle="modal" id="showModalButton"
              class="btn-add-class btn btn-primary btn-sm btn-flat">
              <i class="fa fa-print"></i>&nbsp;&nbsp; Print
            </a>-->

            <div class="search-container">
              <input type="text" class="search-input" id="search-input" placeholder="Search...">
              <button class="search-button" onclick="filterTable()">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                  stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                  class="feather feather-search">
                  <circle cx="11" cy="11" r="8"></circle>
                  <line x1="21" y1="21" x2="16.65" y2="16.65"></line>
                </svg>
              </button>
            </div>
          </div>

          <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
            <li>Alumni</li>
            <li class="active">Alumni List</li>
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
                          <th>Student ID</th>
                          <th>Name</th>
                          <th>Email</th>
                          <th>Gender</th>
                          <th>Course</th>
                          <th>Batch</th>
                          <th>Tools</th>
                        </tr>
                      </thead>
                      <tbody>

                        <?php include 'fetch_data/fetch_dataAlumni.php' ?>


                      </tbody>
                    </table>


                    <!-- Modal -->

                  </div>
                </div>

              </div>
            </div>
        </section>
      </div>

      <!-- Sidebar -->
      <div class="left-div">
        <?php include 'includes/submenubar.php' ?>
      </div>
    </div>


    <?php include 'includes/footer.php'; ?>
    <?php include 'includes/alumniAddModal.php'; ?>
    <?php include 'includes/addDepartmentModal.php' ?>
    <?php include 'includes/addCourseModal.php' ?>
    <?php include 'includes/addBatchModal.php' ?>
    <?php include 'includes/import_excelModal.php' ?>


  </div>
  <?php include 'includes/scripts.php'; ?>
  <script>

    $(document).ready(function () {
      // Use event delegation to handle edit modal
      $(document).on('click', '.open-modal', function () {
        var id = $(this).data('id');
        $.ajax({
          url: 'alumni_row.php',
          type: 'GET',
          data: { id: id },
          dataType: 'json',
          success: function (response) {
            $('#editId').val(id);
            $('#editFirstname').val(response.firstname);
            $('#editLastname').val(response.lastname);
            $('#editMiddlename').val(response.middlename);
            $('#editAuxiliaryname').val(response.auxiliaryname);
            $('#editBirthdate').val(response.birthdate);
            $('#editCivilstatus').val(response.civilstatus);
            $('#editMale').prop('checked', response.gender === 'Male');
            $('#editMemale').prop('checked', response.gender === 'Female');
            $('#editAddressline1').val(response.addressline1);
            $('#editCity').val(response.city);
            $('#editState').val(response.state);
            $('#editZipcode').val(response.zipcode);
            $('#editContactnumber').val(response.contactnumber);
            $('#editEmail').val(response.email);
            $('#editCourse').val(response.course);
            $('#editBatch').val(response.batch);
            $('#editStudentid').val(response.studentid);

            // Show the edit modal
            $('#editModal').modal('show');
          },
          error: function (xhr, status, error) {
            console.error('AJAX Error: ' + status + ' ' + error);
          }
        });
      });

      // Use event delegation to handle delete modal
      $(document).on('click', '.open-delete', function () {
        var id = $(this).data('id');
        $.ajax({
          url: 'alumni_row.php',
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

            // Store the ID in a data attribute of the delete button
            $('.btn-confirm-delete').data('id', id);
          },
          error: function (xhr, status, error) {
            console.error('AJAX Error: ' + status + ' ' + error);
          }
        });
      });
    });


    // Toggle dropdown menu
    document.getElementById('toggle-button').addEventListener('click', function () {
      var dropdownMenu = document.getElementById('dropdown-menu');
      dropdownMenu.classList.toggle('show');
    });

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
      toggleContent("collaps-department");
      toggleContent("collaps-year");
    });




  </script>
  <script>
  $(document).ready(function() {
    // Handle department form submission
    $('#addDepartmentForm').on('submit', function(event) {
        event.preventDefault(); // Prevent the default form submission

        var formData = $(this).serialize(); // Serialize form data

        $.ajax({
            type: 'POST',
            url: 'department_add.php', // The URL of your PHP script for department
            data: formData,
            dataType: 'json',
            success: function(response) {
                if (response.status === 'success') {
                    showAlert('success', response.message);
                } else {
                    showAlert('error', response.message);
                }
            },
            error: function() {
                showAlert('error', 'An unexpected error occurred.');
            }
        });
    });

    // Handle course form submission
    $('#addCourseForm').on('submit', function(event) {
        event.preventDefault(); // Prevent the default form submission

        var formData = $(this).serialize(); // Serialize form data

        $.ajax({
            type: 'POST',
            url: 'course_add.php', // The URL of your PHP script for course
            data: formData,
            dataType: 'json',
            success: function(response) {
                if (response.status === 'success') {
                    showAlert('success', response.message);
                } else {
                    showAlert('error', response.message);
                }
            },
            error: function() {
                showAlert('error', 'An unexpected error occurred.');
            }
        });
    });

    // Handle batch form submission
    $('#addBatchForm').on('submit', function(event) {
        event.preventDefault(); // Prevent the default form submission

        var formData = $(this).serialize(); // Serialize form data

        $.ajax({
            type: 'POST',
            url: 'batch_add.php', // The URL of your PHP script for batch
            data: formData,
            dataType: 'json',
            success: function(response) {
                if (response.status === 'success') {
                    showAlert('success', response.message);
                } else {
                    showAlert('error', response.message);
                }
            },
            error: function() {
                showAlert('error', 'An unexpected error occurred.');
            }
        });
    });

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

</body>

</html>
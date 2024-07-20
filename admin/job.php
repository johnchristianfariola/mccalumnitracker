<?php include 'includes/session.php'; ?>
<?php include 'includes/header.php'; ?>

<body class="hold-transition skin-blue sidebar-mini">
  <div class="wrapper">

    <?php include 'includes/navbar.php'; ?>
    <?php include 'includes/menubar.php'; ?>

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
      <!-- Content Header (Page header) -->
      <section class="content-header box-header-background">
        <h1>
          Content <i class="fa fa-angle-right"></i> Job
        </h1>
        <div class="box-inline ">

          <a href="#addnew" data-toggle="modal" class="btn-add-class btn btn-primary btn-sm btn-flat"><i
              class="fa fa-plus-circle"></i>&nbsp;&nbsp; New</a>

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
          <li>Content</li>
          <li class="active">News</li>
        </ol>
      </section>
      <!-- Main content -->
      <section class="content">
        <?php
        if (isset($_SESSION['error'])) {
          echo "
            <div class='alert alert-danger alert-dismissible'>
              <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
              <h4><i class='icon fa fa-warning'></i> Reminder</h4>
              " . $_SESSION['error'] . "
            </div>
          ";
          unset($_SESSION['error']);
        }
        if (isset($_SESSION['success'])) {
          echo "
            <div class='alert alert-success alert-dismissible'>
              <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
              <h4><i class='icon fa fa-check'></i> Success!</h4>
              " . $_SESSION['success'] . "
            </div>
          ";
          unset($_SESSION['success']);
        }
        ?>
        <div class="row">
          <div class="col-xs-12">
            <div class="box">
              <div class="box-header with-border"></div>
              <div class="box-body">
                <div class="table-responsive"> <!-- Add this div for responsive behavior -->
                  <table id="example1" class="table table-bordered">
                    <thead>

                      <th>Status</th>
                      <th width="15%">Work Type</th>
                      <th>Job Title</th>
                      <th>Company</th>
                      <th>Description</th>
                      <th>Date Posted</th>
                      <th width="10%">Tools</th>
                    </thead>
                    <tbody>
                      <?php include 'fetch_data/fetch_dataJob.php'; ?>
                    </tbody>
                  </table>
                </div>
              </div>
            </div>
          </div>
        </div>
      </section>
    </div>

    <?php include 'includes/footer.php'; ?>
    <?php include 'includes/job_modal.php'; ?>
  </div>
  <?php include 'includes/scripts.php'; ?>
  <script>
    $(document).ready(function () {
      // Function to fetch content from the server
      function fetcheventData(id, successCallback, errorCallback) {
        $.ajax({
          url: 'job_row.php',
          type: 'GET',
          data: { id: id },
          dataType: 'json',
          success: successCallback,
          error: errorCallback
        });
      }

      // Function to initialize CKEditor
      function initializeCKEditor(elementId) {
        if (window.CKEDITOR && CKEDITOR.replace) {
          CKEDITOR.replace(elementId);
        } else {
          console.error('CKEditor is not defined or replace method is missing.');
        }
      }

      // Open edit modal when edit button is clicked
      $('.open-modal').click(function () {
        var id = $(this).data('id');

        // Fetch event data via AJAX
        fetcheventData(id, function (response) {
          $('#editId').val(id);
          $('#edit_job_title').val(response.job_title);
          $('#edit_company_name').val(response.company_name);
          $('#edit_parttime').prop('checked', response.work_time === 'Part-Time');
          $('#edit_fulltime').prop('checked', response.work_time === 'Full-Time');
          $('#edit_statusActive').prop('checked', response.status === 'Active');
          $('#edit_statusArchive').prop('checked', response.status === 'Archive');
          $('#edit_description').val(response.job_description);


          // Show the edit modal after setting the form fields
          $('#editModal').modal('show');

          // Initialize CKEditor after modal is shown
          initializeCKEditor('edit_description');
        }, function (xhr, status, error) {
          console.error('AJAX Error: ' + status + ' ' + error);
        });
      });


      // Open delete modal when delete button is clicked
      $(document).ready(function () {
        // Open delete confirmation modal
        $('.open-delete').click(function () {
          var id = $(this).data('id');

          // Make an AJAX request to fetch job details

          $.ajax({
            url: 'job_row.php',
            type: 'GET',
            data: { id: id },
            dataType: 'json',

            success: function (response) {
              // Populate modal with alumni name
              $('.deleteId').val(id); // Update value of deleteId input field

              $('.deleteTitle').text(response.job_title);

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

    });
  </script>
</body>

</html>


<style>
  table {
    width: 100% !important;
    border-collapse: collapse !important;
  }


  td {
    padding: 8px !important;

    vertical-align: middle !important;
    max-width: 200px !important;
    /* Adjust maximum width as needed */
    overflow: hidden !important;
    text-overflow: ellipsis !important;
    white-space: nowrap !important;
  }
</style>
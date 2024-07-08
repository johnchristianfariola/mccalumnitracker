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
          Content <i class="fa fa-angle-right"></i> Event
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
          <li class="active">Event</li>
        </ol>
      </section>
      <!-- Main content -->
      <section class="content">
        <?php
        if (isset($_SESSION['error'])) {
          echo "
            <div class='alert alert-danger alert-dismissible'>
              <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
              <h4><i class='icon fa fa-warning'></i> Error!</h4>
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
              <div class="box-header with-border">

              </div>
              <div class="box-body">
                <div class="table-responsive"> <!-- Add this div for responsive behavior -->
                  <table id="example1" class="table table-bordered">
                    <thead>
                      <th>Thumnails</th>
                      <th>Title</th>
                      <th>Author</th>
                      <th width="30%">Description</th>
                      <th width="10%">Date Posted</th>

                      <th width="10%">Tools</th>
                    </thead>
                    <tbody>
                      <?php include 'fetch_data/fetch_dataEvent.php'; ?>
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
    <?php include 'includes/event_modal.php'; ?>
  </div>
  <?php include 'includes/scripts.php'; ?>
  <script>
    $(document).ready(function () {
      // Function to fetch content from the server
      function fetcheventData(id, successCallback, errorCallback) {
        $.ajax({
          url: 'event_row.php',
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

      // Function to destroy CKEditor instance
      function destroyCKEditor(elementId) {
        if (window.CKEDITOR && CKEDITOR.instances[elementId]) {
          CKEDITOR.instances[elementId].destroy(true);
        }
      }

      // Open edit modal when edit button is clicked
      $('.open-modal').click(function () {
        var id = $(this).data('id');

        // Fetch event data via AJAX
        fetcheventData(id, function (response) {
          $('#editId').val(id);
          $('#editTitle').val(response.event_title);
          $('#editAuthor').val(response.event_author);
          $('#editDesc').val(response.event_description);

          // Display the fetched image in the edit modal
          if (response.image_url) {
            $('#imagePreviewImg2').attr('src', response.image_url);
            $('#imagePreviewImg2').css('display', 'block'); // Ensure the image is displayed
          } else {
            $('#imagePreviewImg2').attr('src', ''); // Clear the image src if no image URL is returned
            $('#imagePreviewImg2').css('display', 'none'); // Hide the image if no image URL is returned
          }

          // Show the edit modal after setting the form fields
          $('#editModal').modal('show');

          // Destroy any existing CKEditor instance before initializing a new one
          destroyCKEditor('editDesc');

          // Initialize CKEditor after modal is shown
          $('#editModal').on('shown.bs.modal', function () {
            initializeCKEditor('editDesc');
          });

        }, function (xhr, status, error) {
          console.error('AJAX Error: ' + status + ' ' + error);
        });
      });

      // Destroy CKEditor instance when modal is hidden
      $('#editModal').on('hidden.bs.modal', function () {
        destroyCKEditor('editDesc');
      });


      $(document).ready(function () {
        // Example of retrieving data from event_row.php
        $('.open-delete').click(function () {
          var id = $(this).data('id');

          // Make an AJAX request to fetch event details
          $.ajax({
            url: 'event_row.php',
            type: 'GET',
            data: { id: id },
            dataType: 'json',

            success: function (response) {
              // Update the description-container with the retrieved HTML content
              $('.description-container').html(response.event_description);

              // Optionally, update other elements with data from response
              $('.deleteId').val(id);
              $('.title').text(response.event_title);

              if (response.image_url) {
                $('#imagePreviewImg3').attr('src', response.image_url);
                $('#imageLink').attr('href', response.image_url);
                $('#imagePreviewImg3').css('display', 'block'); // Ensure the image is displayed
              } else {
                $('#imagePreviewImg3').attr('src', ''); // Clear the image src if no image URL is returned
                $('#imagePreviewImg3').css('display', 'none'); // Hide the image if no image URL is returned
              }

              // Show the modal or perform other actions
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
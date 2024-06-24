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

            <a href="#print" data-toggle="modal" id="showModalButton"
              class="btn-add-class btn btn-primary btn-sm btn-flat">
              <i class="fa fa-print"></i>&nbsp;&nbsp; Print
            </a>

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
            echo "
            <div class='alert alert-danger alert-dismissible'>
              <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
              <h4><i class='icon fa fa-bell'></i> Reminder!</h4>
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
      // Open edit modal when edit button is clicked
      $('.open-modal').click(function () {
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

      // Open delete modal when delete button is clicked
      $('.open-delete').click(function () {
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


    /*=========Table Modal=============*/

    document.addEventListener('DOMContentLoaded', function () {
      const modalTableBody = document.getElementById('modalTableBody');
      const outsideTableBody = document.querySelector('#example1 tbody');
      const showModalButton = document.getElementById('showModalButton');
      const printModalButton = document.getElementById('printModalButton');
      const removeSelectedButton = document.getElementById('removeSelectedButton');

      showModalButton.addEventListener('click', function () {
        // Clear previous data
        modalTableBody.innerHTML = '';
        // Clone rows from outside table and append to modal table
        Array.from(outsideTableBody.rows).forEach(row => {
          // Clone the row without the last cell (actions cell)
          const clonedRow = row.cloneNode(true);
          clonedRow.deleteCell(-1); // Remove the last cell (actions cell)
          // Remove any existing checkbox if mistakenly added
          clonedRow.querySelector('td:first-child input[type="checkbox"]').remove();
          // Add checkbox to the first cell
          const checkboxCell = document.createElement('td');
          const checkbox = document.createElement('input');
          checkbox.type = 'checkbox';
          checkbox.className = 'modal-checkbox';
          checkbox.dataset.id = row.cells[1].textContent.trim(); // Assuming student ID is in the second cell
          checkboxCell.appendChild(checkbox);
          clonedRow.insertBefore(checkboxCell, clonedRow.cells[0]);
          // Append the modified row to modal table
          modalTableBody.appendChild(clonedRow);
        });
        // Show the modal
        $('#dataModal').modal('show');
      });

      removeSelectedButton.addEventListener('click', function () {
        // Remove selected rows from modal table
        const checkboxes = document.querySelectorAll('.modal-checkbox:checked');
        checkboxes.forEach(checkbox => {
          const row = checkbox.closest('tr');
          row.parentNode.removeChild(row);
        });
      });

      printModalButton.addEventListener('click', function () {
        // Temporarily hide checkboxes
        const checkboxes = modalTableBody.querySelectorAll('.modal-checkbox');
        checkboxes.forEach(checkbox => {
          checkbox.style.display = 'none';
        });

        // Collect data to be printed
        const dataToPrint = [];
        const batchYears = new Set();

        Array.from(modalTableBody.rows).forEach(row => {
          // Clone the row to manipulate without the first column
          const clonedRow = row.cloneNode(true);
          clonedRow.deleteCell(0); // Remove the first cell (first column)
          const batchYear = row.cells[7].textContent.trim(); // Assuming the batch year is in the 7th cell
          batchYears.add(batchYear);
          dataToPrint.push({
            content: clonedRow.innerHTML,
            batchYear: batchYear
          });
        });

        // Determine if there are mixed batches
        const isMixedBatch = batchYears.size > 1;

        // Encode the data to be sent via URL
        const encodedData = encodeURIComponent(JSON.stringify({
          dataToPrint: dataToPrint,
          isMixedBatch: isMixedBatch
        }));

        // Redirect to the print page with the encoded data
        window.open(`alumni_print.php?data=${encodedData}`, '_blank');

        // Show checkboxes again after the print dialog is opened (optional)
        checkboxes.forEach(checkbox => {
          checkbox.style.display = ''; // Restore default display (could be 'block', 'inline', etc.)
        });
      });



    });

  </script>
</body>

</html>
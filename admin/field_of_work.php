<?php include 'includes/session.php'; ?>
<?php include 'includes/header.php'; ?>
<?php
require_once 'includes/firebaseRDB.php';
require_once 'includes/config.php'; // Include your config file

$firebase = new firebaseRDB($databaseURL);

function getFirebaseData($firebase, $path)
{
    $data = $firebase->retrieve($path);
    return json_decode($data, true);
}

function sanitizeInput($data)
{
    return htmlspecialchars(strip_tags($data));
}

$alumniData = getFirebaseData($firebase, "alumni");
$batchData = getFirebaseData($firebase, "batch_yr");
$courseData = getFirebaseData($firebase, "course");
$categoryData = getFirebaseData($firebase, "category");

$filterCourse = isset($_GET['course']) ? sanitizeInput($_GET['course']) : '';
$filterBatch = isset($_GET['batch']) ? sanitizeInput($_GET['batch']) : '';
$filterStatus = isset($_GET['work_status']) ? sanitizeInput($_GET['work_status']) : '';
$filterWorkClassification = isset($_GET['work_classification']) ? sanitizeInput($_GET['work_classification']) : '';

// Initialize counters
$employedCount = 0;
$unemployedCount = 0;
$totalCount = 0;


?>
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
           Alumni Status
          </h1>
          <div class="box-inline">

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
            <li class="active">Alumni Status</li>
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
                <div class="box-header">
                  <div class="box-tools pull-right">
                    <form class="form-inline">
                    <form class="form-inline">
                      <div class="form-group">
                        <label style="color:white;">Select Status: </label>
                        <select  class="form-control input-sm" style="height:25px; font-size:10px" id="select_work_classification">
                          <option value="">All</option>
                          <?php
                          $categoryData = getFirebaseData($firebase, "category");
                          if (!empty($categoryData) && is_array($categoryData)) {
                            foreach ($categoryData as $categoryId => $categoryDetails) {
                              $categoryName = isset($categoryDetails['category_name']) ? htmlspecialchars($categoryDetails['category_name']) : 'Unknown';
                              echo "<option value=\"" . htmlspecialchars($categoryId) . "\">" . $categoryName . "</option>";
                            }
                          }
                          ?>
                        </select>
                      </div>
                    </form>
                    <script>
                      $(function () {
                        $('#select_work_classification').change(function () {
                          var url = new URL(window.location.href);
                          url.searchParams.set('work_classification', $(this).val());
                          window.location.href = url.toString();
                        });

                        // Add your existing JavaScript here
                      });
                    </script>



                  </div>
                </div>
                <div class="box-body">
                  <div class="table-responsive"> <!-- Add this div for responsive behavior -->
                    <table id="example1" class="table table-bordered printable-table">
                      <thead>
                        <tr>
                          <th style="display:none;"></th>
                          <th>Profile </th>
                          <th>Alumni ID</th>
                          <th>Name</th>
                          <th>Course</th>
                          <th>Batch</th>
                          <th>Status</th>
                          <th>Field of Work</th>
                          <th>Tools</th>
                        </tr>
                      </thead>
                      <tbody>
                    
                      <?php include 'fetch_data/fetch_dataFieldOfWork.php'?>



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
        <?php include 'includes/submenufieldofwork.php' ?>
      </div>
    </div>


    <?php include 'includes/footer.php'; ?>
    <?php include 'includes/alumni_report_modal.php'; ?>



  </div>
  <?php include 'includes/scripts.php'; ?>
  <script>
    $(document).ready(function () {
      // Open edit modal when edit button is clicked
      $('.open-modal').click(function () {
        var id = $(this).data('id');
        $.ajax({
          url: 'alumni_report_row.php',
          type: 'GET',
          data: { id: id },
          dataType: 'json',
          success: function (response) {
            $('#reporttId').val(id);
            $('#displayFirstname').text(response.firstname || 'N/A');
            $('#displayLastname').text(response.lastname || 'N/A');
            $('#displayMiddlename').text(response.middlename || 'N/A');
            $('#displayAuxiliaryname').text(response.auxiliaryname || 'N/A');
            $('#displayBirthdate').text(response.birthdate || 'N/A');
            $('#displayCivilstatus').text(response.civilstatus || 'N/A');
            $('#displayMale').text(response.gender || 'N/A');
            $('#displayAddressline1').text(response.addressline1 || 'N/A');
            $('#displayCity').text(response.city || 'N/A');
            $('#displayState').text(response.state || 'N/A');
            $('#displayZipcode').text(response.zipcode || 'N/A');
            $('#displayContactnumber').text(response.contactnumber || 'N/A');
            $('#displayEmail').text(response.email || 'N/A');
            $('#date_responded').text(response.date_responded || 'N/A');
            $('#displayCourse').text(response.course_name || 'N/A'); // Display course name
            $('#displayBatch').text(response.batch_year || 'N/A');
            $('#displayStudentid').text(response.studentid || 'N/A');
            $('#work_status').text(response.work_status || 'N/A');
            $('#first_employment_date').text(response.first_employment_date || 'N/A');
            $('#date_for_current_employment').text(response.date_for_current_employment || 'N/A');
            $('#type_of_work').text(response.type_of_work || 'N/A');
            $('#work_position').text(response.work_position || 'N/A');
            $('#current_monthly_income').text(response.current_monthly_income || 'N/A');
            $('#work_related').text(response.work_related || 'N/A');
            $('#work_classification').text(response.work_classification || 'N/A');
            $('#name_company').text(response.name_company || 'N/A');
            $('#work_employment_status').text(response.work_employment_status || 'N/A');
            $('#employment_location').text(response.employment_location || 'N/A');
            $('#job_satisfaction').text(response.job_satisfaction || 'N/A');


            // Show the edit modal
            $('#reportModal').modal('show');
          },
          error: function (xhr, status, error) {
            console.error('AJAX Error: ' + status + ' ' + error);
          }
        });
      });

      // Toggle dropdown menu
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
          const batchYear = row.cells[5].textContent.trim(); // Assuming the batch year is in the 7th cell
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
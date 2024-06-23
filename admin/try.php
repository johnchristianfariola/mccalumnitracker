<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Modal Form Example</title>
  <!-- Include Bootstrap CSS -->
  <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" rel="stylesheet">
  <style>
    /* Custom styles for printing */
    @media print {
      body {

        margin: 1in;
      }

      .printable-table {
        width: 90%;
        border-collapse: collapse;
        page-break-inside: auto;
      }

      .printable-table th,
      .printable-table td {
        border: 1px solid #000;
        padding: 8px;
        text-align: left;
      }

      .printable-table th {
        background-color: #f2f2f2;
      }

      .modal {
        display: none;
        /* Hide modal when printing */
      }
    }
  </style>
</head>

<body>
  <div class="container">
    <h2 class="mt-5">Alumni Data</h2>

    <!-- Outside Table -->
    <table id="outsideTable" class="table table-bordered">
      <thead>
        <tr>
          <th>Student ID</th>
          <th>Name</th>
          <th>Email</th>
          <th>Gender</th>
          <th>Course</th>
          <th>Batch</th>
          <th>Actions</th>
        </tr>
      </thead>
      <tbody>
        <?php
        require_once 'includes/firebaseRDB.php';

        $databaseURL = "https://mccnians-bc4f4-default-rtdb.firebaseio.com";
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

        $filterCourse = isset($_GET['course']) ? sanitizeInput($_GET['course']) : '';
        $filterBatch = isset($_GET['batch']) ? sanitizeInput($_GET['batch']) : '';

        if (is_array($alumniData) && count($alumniData) > 0) {
          foreach ($alumniData as $id => $alumni) {
            $courseId = $alumni['course'];
            $batchId = $alumni['batch'];

            if ($filterCourse && $filterCourse != $courseId) {
              continue;
            }
            if ($filterBatch && $filterBatch != $batchId) {
              continue;
            }

            $batchName = isset($batchData[$batchId]['batch_yrs']) ? $batchData[$batchId]['batch_yrs'] : 'Unknown Batch';
            $courseName = isset($courseData[$courseId]['courCode']) ? $courseData[$courseId]['courCode'] : 'Unknown Course';

            echo "<tr>
                        <td>{$alumni['studentid']}</td>
                        <td>{$alumni['firstname']} {$alumni['middlename']} {$alumni['lastname']}</td>
                        <td>{$alumni['email']}</td>
                        <td>{$alumni['gender']}</td>
                        <td>{$courseName}</td>
                        <td>{$batchName}</td>
                        <td>
                        <a class='btn btn-success btn-sm btn-flat open-modal' data-id='$id'>EDIT</a>
                        <a class='btn btn-danger btn-sm btn-flat open-delete' data-id='$id'>DELETE</a>
                        </td>
                        </tr>";
          }
        }
        ?>
      </tbody>
    </table>

    <!-- New Button to Open Modal -->
    <button type="button" class="btn btn-primary" id="showModalButton">Show Data in Modal</button>

    <!-- Modal -->
    <div class="modal fade" id="dataModal" tabindex="-1" role="dialog" aria-labelledby="dataModalLabel"
      aria-hidden="true">
      <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="dataModalLabel">Alumni Data</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <table id="printTable" class="printable-table">
              <thead>
                <tr>
                  <th>Student ID</th>
                  <th>Name</th>
                  <th>Email</th>
                  <th>Gender</th>
                  <th>Course</th>
                  <th>Batch</th>
                </tr>
              </thead>
              <tbody id="modalTableBody">
                <!-- Data will be copied here -->
              </tbody>
            </table>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            <button type="button" class="btn btn-primary" id="printModalButton">Print</button>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Include Bootstrap JS and dependencies -->
  <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
  <script>
    document.addEventListener('DOMContentLoaded', function () {
      const modalTableBody = document.getElementById('modalTableBody');
      const outsideTableBody = document.querySelector('#outsideTable tbody');
      const showModalButton = document.getElementById('showModalButton');
      const printModalButton = document.getElementById('printModalButton');

      showModalButton.addEventListener('click', function () {
        // Clear previous data
        modalTableBody.innerHTML = '';
        // Clone rows from outside table and append to modal table
        Array.from(outsideTableBody.rows).forEach(row => {
          // Clone the row without the last cell (actions cell)
          const clonedRow = row.cloneNode(true);
          clonedRow.deleteCell(-1); // Remove the last cell (actions cell)
          // Append the modified row to modal table
          modalTableBody.appendChild(clonedRow);
        });
        // Show the modal
        $('#dataModal').modal('show');
      });

      printModalButton.addEventListener('click', function () {
        // Print the content of the modal table
        const printContents = document.getElementById('printTable').outerHTML;
        const originalContents = document.body.innerHTML;
        document.body.innerHTML = printContents;
        window.print();
        document.body.innerHTML = originalContents;
      });
    });
  </script>
</body>

</html>
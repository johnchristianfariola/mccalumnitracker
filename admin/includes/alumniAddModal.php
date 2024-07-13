<?php
// Include the FirebaseRDB class file
require_once 'includes/firebaseRDB.php';

require_once 'config.php'; // Include your config file

$firebase = new firebaseRDB($databaseURL);

// Fetch data from Firebase
$courseKey = "course"; // Replace with your actual Firebase path or key for courses

$data = $firebase->retrieve($courseKey);
$data = json_decode($data, true); // Decode JSON data into associative arrays

$batchYears = $firebase->retrieve("batch_yr");
$batchYears = json_decode($batchYears, true); // Decode JSON data into associative arrays
?>

<div class="modal fade" id="addnew">
  <div class="modal-dialog modal-dialog-centered modal-lg"> <!-- Adjust 'modal-lg' for different screen sizes -->
    <div class="modal-content">
      <div class="box-headerModal"></div>
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
        <h2 class="modal-title"><b>Alumni <i class="fa fa-angle-right"></i> Manage Alumni <i
              class="fa fa-angle-right"></i> Add</b></h2>
        <hr>
      </div>
      <div class="modal-body">
        <form class="form-horizontal" method="POST" action="alumni_listadd.php">
          <input type="hidden" name="token" value="<?php echo $_SESSION['token']; ?>">
          <div class="personal_information">
            <div class="form-group row" style="border-bottom: 1px solid silver !important;">
              <label for="firstname" class="col-sm-3 col-form-label text-sm-end">
                <h4>Personal Information</h4>
              </label>
              <div class="col-sm-6">
                <div class="row">
                  <div class="col-sm-6 mb-3">
                    <label for="firstname" class="col-form-label">Firstname</label>
                    <input type="text" class="form-control" id="firstname" name="firstname">
                  </div>
                  <div class="col-sm-6 mb-3">
                    <label for="lastname" class="col-form-label">Lastname</label>
                    <input type="text" class="form-control" id="lastname" name="lastname" required>
                  </div>

                  <div class="col-sm-6 mb-3">
                    <label for="middlename" class="col-form-label">Middle Name</label>
                    <input type="text" class="form-control" id="middlename" name="middlename">
                  </div>

                  <div class="col-sm-6 mb-3">
                    <label for="auxillaryname" class="col-form-label">Auxiliary Name</label>
                    <input type="text" class="form-control" id="auxiliaryname" name="auxiliaryname">
                  </div>

                  <div class="col-sm-6 mb-3">
                    <label for="birthdate" class="col-form-label">Birthdate</label>
                    <input type="date" class="form-control" id="birthdate" name="birthdate">
                  </div>

                  <div class="col-sm-6 mb-3">
                    <label for="civilstatus" class="col-form-label">Civil Status</label>
                    <input type="text" class="form-control" id="civilstatus" name="civilstatus">
                  </div>

                  <div class="col-sm-6 mb-3">
                    <label for="gender" class="col-form-label">Sex</label><br>
                    <input type="radio" id="male" name="gender" value="Male" class="gender-radio">
                    <label for="male" class="radio-label">Male</label>

                    <input type="radio" id="female" name="gender" value="Female" class="gender-radio">
                    <label for="female" class="radio-label">Female</label>
                  </div>

                </div>
              </div>
            </div>

            <div class="form-group row" style="border-bottom: 1px solid silver !important;">
              <label for="address" class="col-sm-3 col-form-label text-sm-end">
                <h4>Contact Information</h4>
              </label>
              <div class="col-sm-6">
                <div class="row">
                  <div class="col-sm-6 mb-3">
                    <label for="addressline1" class="col-form-label">Address Line 1</label>
                    <input type="text" class="form-control" id="addressline1" name="addressline1">
                  </div>
                  <div class="col-sm-6 mb-3">
                    <label for="city" class="col-form-label">City</label>
                    <input type="text" class="form-control" id="city" name="city">
                  </div>

                  <div class="col-sm-6 mb-3">
                    <label for="state" class="col-form-label">Province</label>
                    <input type="text" class="form-control" id="state" name="state">
                  </div>

                  <div class="col-sm-6 mb-3">
                    <label for="zipcode" class="col-form-label">Zip Code</label>
                    <input type="text" class="form-control" id="zipcode" name="zipcode">
                  </div>

                  <div class="col-sm-6 mb-3">
                    <label for="contactnumber" class="col-form-label">Contact Number</label>
                    <input type="text" class="form-control" id="contactnumber" name="contactnumber" pattern="\d{11}"
                      maxlength="11" title="Contact number must be 11 digits">
                  </div>

                  <div class="col-sm-6 mb-3">
                    <label for="email" class="col-form-label">Email</label>
                    <input type="email" class="form-control" id="email" name="email">
                  </div>
                </div>
              </div>
            </div>

            <div class="form-group row">
              <label for="course" class="col-sm-3 col-form-label text-sm-end">
                <h4>Alumni Information</h4>
              </label>
              <div class="col-sm-6">
                <div class="row">
                  <div class="col-sm-6 mb-3">
                    <label for="course" class="col-form-label">Course</label>
                    <select class="form-control" id="course" name="course">
                      <option value="">Select Course</option>
                      <?php
                      if (is_array($data)) {
                        foreach ($data as $courseId => $details) {
                          $courseCode = isset($details['courCode']) ? htmlspecialchars($details['courCode']) : 'Unknown';
                          echo "<option value=\"" . htmlspecialchars($courseId) . "\">" . $courseCode . "</option>";
                        }
                      }
                      ?>
                    </select>
                  </div>

                  <div class="col-sm-6 mb-3">
                    <label for="batch" class="col-form-label">Batch Year</label>
                    <select class="form-control" id="batch" name="batch">
                      <option value="">Select Batch Year</option>
                      <?php
                      if (!empty($batchYears) && is_array($batchYears)) {
                        foreach ($batchYears as $batchId => $batchDetails) {
                          $batchYear = isset($batchDetails['batch_yrs']) ? $batchDetails['batch_yrs'] : 'Unknown';
                          echo "<option value=\"" . htmlspecialchars($batchId) . "\">" . htmlspecialchars($batchYear) . "</option>";
                        }
                      }
                      ?>
                    </select>
                  </div>


                  <div class="col-sm-6 mb-3">
                    <label for="studentid" class="col-form-label">Student ID</label>
                    <input type="text" class="form-control" id="studentid" name="studentid" required>
                    <small id="studentidHelp" class="form-text text-muted">Format: 1234-5678</small>
                  </div>
                </div>
              </div>
            </div>
          </div>


      </div>
      <div class="modal-footer">

        <button type="submit" class="btn btn-flat pull-right btn-class" name="add"
          style="background:linear-gradient(to right, #90caf9, #047edf 99%); color:white;"><i class="fa fa-save"></i>
          Save</button>
        <button type="button" class="btn btn-default btn-flat btn-class" data-dismiss="modal"><i
            class="fa fa-close"></i> Close</button>
        </form>
      </div>
    </div>
  </div>
</div>



<!-- Edit
<div class="modal fade" id="editModal">
    <div class="modal-dialog" style="width: 80%;">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Edit Alumni Information</h5>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <form id="editForm" action="alumni_edit.php" method="POST">
                     Form fields for editing alumni data 
                    <input type="hidden" id="editId" name="id">
                    <div class="form-group">
                        <label for="editFirstname">Firstname</label>
                        <input type="text" class="form-control" id="editFirstname" name="edit_firstname" required>
                    </div>
                    <div class="form-group">
                        <label for="editLastname">Lastname</label>
                        <input type="text" class="form-control" id="editLastname" name="edit_lastname" required>
                    </div>
                     Add more fields as per your requirements 
                    <button type="submit" class="btn btn-primary">Save Changes</button>
                </form>
            </div>
        </div>
    </div>
</div> -->


<div class='modal fade' id='editModal' tabindex='-1' role='dialog' aria-labelledby='editModalLabel' aria-hidden='true'>
  <div class="modal-dialog modal-dialog-centered modal-lg"> <!-- Adjust 'modal-lg' for different screen sizes -->
    <div class="modal-content">
      <div class="box-headerModal"></div>
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
        <h2 class="modal-title"><b>Alumni <i class="fa fa-angle-right"></i> Manage Alumni <i
              class="fa fa-angle-right"></i> Edit</b></h2>
        <hr>
      </div>
      <div class="modal-body">
        <form class="form-horizontal" method="POST" action="alumni_edit.php">
          <!-- Form fields for editing alumni data -->
          <input type="hidden" id="editId" name="id">

          <div class="personal_information">
            <div class="form-group row" style="border-bottom: 1px solid silver !important;">
              <label for="edit_firstname" class="col-sm-3 col-form-label text-sm-end">
                <h4>Personal Information</h4>
              </label>
              <div class="col-sm-6">
                <div class="row">
                  <div class="col-sm-6 mb-3">
                    <label for="edit_firstname" class="col-form-label">Firstname</label>
                    <input type="text" class="form-control" id="editFirstname" name="edit_firstname">
                  </div>
                  <div class="col-sm-6 mb-3">
                    <label for="edit_lastname" class="col-form-label">Lastname</label>
                    <input type="text" class="form-control" id="editLastname" name="edit_lastname" required>
                  </div>

                  <div class="col-sm-6 mb-3">
                    <label for="edit_middlename" class="col-form-label">Middle Name</label>
                    <input type="text" class="form-control" id="editMiddlename" name="edit_middlename">
                  </div>

                  <div class="col-sm-6 mb-3">
                    <label for="edit_auxiliaryname" class="col-form-label">Auxiliary Name</label>
                    <input type="text" class="form-control" id="editAuxiliaryname" name="edit_auxiliaryname">
                  </div>

                  <div class="col-sm-6 mb-3">
                    <label for="edit_birthdate" class="col-form-label">Birthdate</label>
                    <input type="date" class="form-control" id="editBirthdate" name="edit_birthdate">
                  </div>

                  <div class="col-sm-6 mb-3">
                    <label for="edit_civilstatus" class="col-form-label">Civil Status</label>
                    <input type="text" class="form-control" id="editCivilstatus" name="edit_civilstatus">
                  </div>

                  <div class="col-sm-6 mb-3">
                    <label for="edit_gender" class="col-form-label">Gender</label><br>
                    <input type="radio" id="editMale" name="edit_gender" value="Male" class="gender-radio">
                    <label for="edit_male" class="radio-label">Male</label>

                    <input type="radio" id="editMemale" name="edit_gender" value="Female" class="gender-radio">
                    <label for="edit_female" class="radio-label">Female</label>
                  </div>

                </div>
              </div>
            </div>

            <div class="form-group row" style="border-bottom: 1px solid silver !important;">
              <label for="edit_address" class="col-sm-3 col-form-label text-sm-end">
                <h4>Contact Information</h4>
              </label>
              <div class="col-sm-6">
                <div class="row">
                  <div class="col-sm-6 mb-3">
                    <label for="edit_addressline1" class="col-form-label">Address Line 1</label>
                    <input type="text" class="form-control" id="editAddressline1" name="edit_addressline1">
                  </div>
                  <div class="col-sm-6 mb-3">
                    <label for="edit_city" class="col-form-label">City</label>
                    <input type="text" class="form-control" id="editCity" name="edit_city">
                  </div>

                  <div class="col-sm-6 mb-3">
                    <label for="edit_state" class="col-form-label">State | Province | Region</label>
                    <input type="text" class="form-control" id="editState" name="edit_state" >
                  </div>

                  <div class="col-sm-6 mb-3">
                    <label for="edit_zipcode" class="col-form-label">Zip Code</label>
                    <input type="text" class="form-control" id="editZipcode" name="edit_zipcode">
                  </div>

                  <div class="col-sm-6 mb-3">
                    <label for="edit_contactnumber" class="col-form-label">Contact Number</label>
                    <input type="tel" class="form-control" id="editContactnumber" name="edit_contactnumber">
                  </div>

                  <div class="col-sm-6 mb-3">
                    <label for="edit_email" class="col-form-label">Email</label>
                    <input type="email" class="form-control" id="editEmail" name="edit_email" >
                  </div>
                </div>
              </div>
            </div>

            <div class="form-group row">
              <label for="edit_course" class="col-sm-3 col-form-label text-sm-end">
                <h4>Alumni Information</h4>
              </label>
              <div class="col-sm-6">
                <div class="row">
                  <div class="col-sm-6 mb-3">
                    <label for="edit_course" class="col-form-label">Course</label>
                    <select class="form-control" id="editCourse" name="edit_course">
                      <option value="">Select Course</option>
                      <?php
                      if (is_array($data)) {
                        foreach ($data as $courseId => $details) {
                          $courseCode = isset($details['courCode']) ? htmlspecialchars($details['courCode']) : 'Unknown';
                          echo "<option value=\"" . htmlspecialchars($courseId) . "\">" . $courseCode . "</option>";
                        }
                      }
                      ?>
                    </select>
                  </div>

                  <div class="col-sm-6 mb-3">
                    <label for="edit_batch" class="col-form-label">Batch Year</label>
                    <select class="form-control" id="editBatch" name="edit_batch">
                      <option value="">Select Batch Year</option>
                      <?php
                      if (!empty($batchYears) && is_array($batchYears)) {
                        foreach ($batchYears as $batchId => $batchDetails) {
                          $batchYear = isset($batchDetails['batch_yrs']) ? $batchDetails['batch_yrs'] : 'Unknown';
                          echo "<option value=\"" . htmlspecialchars($batchId) . "\">" . htmlspecialchars($batchYear) . "</option>";
                        }
                      }
                      ?>
                    </select>
                  </div>

                  <div class="col-sm-6 mb-3">
                    <label for="edit_studentid" class="col-form-label">Student ID</label>
                    <input type="text" class="form-control" id="editStudentid" name="edit_studentid" required>
                  </div>
                </div>
              </div>
            </div>
          </div>
      </div>
      <div class="modal-footer">
        <button type="submit" class="btn btn-flat pull-right btn-class" name="edit_add"
          style="background:linear-gradient(to right, #90caf9, #047edf 99%); color:white;">
          <i class="fa fa-save"></i> Save
        </button>
        <button type="button" class="btn btn-default btn-flat btn-class" data-dismiss="modal">
          <i class="fa fa-close"></i> Close
        </button>
        </form>
      </div>
    </div>
  </div>
</div>





<!-- Delete -->
<div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel"
  aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="box-headerModal"></div>
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
        <h4 class="modal-title"><b>Deleting...</b></h4>
      </div>
      <div class="modal-body">
        <form class="form-horizontal" method="POST" action="alumni_delete.php">
          <input type="hidden" class="deleteId" name="id">
          <div class="text-center">
            <p>School ID: <span class="editStudentid"></span></p>
            <h2 class="editFirstname editMiddlename editLastname"></h2>
          </div>
      </div>
      <div class="modal-footer">



        <button type="submit" class="btn btn-default pull-right btn-flat btn-class" name="delete"
          style="background:linear-gradient(to right, #90caf9, #047edf 99%); color:white;">
          <i class="fa fa-trash"></i> Delete
        </button>
        <button type="button" class="btn btn-flat  btn-class" data-dismiss="modal">
          <i class="fa fa-close"></i> Close
        </button>
      </div>

      </form>
    </div>
  </div>
</div>

<!--==============Import File=================-->

<div class="modal fade" id="exportnew">
  <div class="modal-dialog modal-dialog-centered modal-lg">
    <div class="modal-content">
      <div class="box-headerModal"></div>
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
        <h2 class="modal-title"><b>Alumni <i class="fa fa-angle-right"></i> Manage Alumni <i
              class="fa fa-angle-right"></i> Import</b></h2>
        <hr>
      </div>

      <div class="modal-body">
        <form class="form-horizontal" method="POST" action="import_file.php" enctype="multipart/form-data">
          <input type="hidden" name="token" value="<?php echo $_SESSION['token']; ?>">
          <div class="personal_information">
            <div class="form-group row">
              <label for="firstname" class="col-sm-3 col-form-label text-sm-end">
                <h4>Import Information</h4>
              </label>
              <div class="col-sm-6">
                <div class="row">
                  <div class="col-sm-12">
                    <input type="file" name="import_file" class="form-control" required />
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="modal-footer" style="margin-top:30px">
            <button type="submit" class="btn btn-flat pull-right btn-class" name="import_excel_btn"
              style="background:linear-gradient(to right, #90caf9, #047edf 99%); color:white;">
              <i class="fa fa-save"></i> Save
            </button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>

<!--==============Print File=================-->

<div class="modal fade" id="dataModal" tabindex="-1" role="dialog" aria-labelledby="dataModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="dataModalLabel">Alumni Data</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <table id="printTable" class="table table-bordered">
          <thead>
            <tr>
              <th></th> <!-- Checkbox column -->
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
        <button type="button" class="btn btn-danger mb-2" id="removeSelectedButton">Remove Selected</button>
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary" id="printModalButton">Print</button>
      </div>
    </div>
  </div>
</div>

<style>
  .gender-radio {
    display: none;
    /* Hide the actual radio buttons */
  }

  .radio-label {
    display: inline-block;
    cursor: pointer;
    padding: 8px 20px;
    margin-right: 10px;
    border-radius: 5px;
    background-color: #e0e0e0;
    /* Default background color */
  }

  /* Styling when radio button is checked */
  .gender-radio:checked+.radio-label {
    background-color: #ff5252 !important;
    /* Change background color when checked */
    color: white;
    /* Change text color when checked */
  }

  .right-div {
    float: right;
    /* Float the div to the right */
    width: 30%;
    /* Adjust width as needed */
    padding: 10px;
    /* Add padding for spacing */
    border-left: 1px solid #ccc;
    /* Example border */
    height: 100%;
    /* Ensure it covers the full height if needed */
  }

  .mb-3 {
    margin-bottom: 30px;
  }

  .error {
    border-color: red;
  }
</style>

<script>
  $(document).ready(function () {
    $('.datepicker-year').datepicker({
      format: 'yyyy',
      viewMode: 'years',
      minViewMode: 'years',
      autoclose: true
    });
  });

  const studentIdInput = document.getElementById('studentid');

  studentIdInput.addEventListener('input', function () {
    let value = studentIdInput.value.replace(/\D/g, ''); // Remove all non-digit characters

    if (value.length > 8) {
      value = value.substring(0, 8); // Limit to 8 digits
    }

    // Format with dash in the middle
    if (value.length > 4) {
      value = value.slice(0, 4) + '-' + value.slice(4);
    }

    studentIdInput.value = value;

    // Add or remove error class based on validation
    const isValid = /^\d{4}-\d{4}$/.test(value);
    if (isValid) {
      studentIdInput.classList.remove('error');
    } else {
      studentIdInput.classList.add('error');
    }

  });
  document.getElementById('contactnumber').addEventListener('input', function (e) {
        const input = e.target;
        input.value = input.value.replace(/\D/g, ''); // Remove non-digit characters
    });

</script>
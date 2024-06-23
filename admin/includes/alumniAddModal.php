<?php
// Include the FirebaseRDB class file
require_once 'includes/firebaseRDB.php';

// Your Firebase Realtime Database URL
$databaseURL = "https://mccnians-bc4f4-default-rtdb.firebaseio.com";

// Create an instance of the firebaseRDB class
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
                    <input type="text" class="form-control" id="firstname" name="firstname" required>
                  </div>
                  <div class="col-sm-6 mb-3">
                    <label for="lastname" class="col-form-label">Lastname</label>
                    <input type="text" class="form-control" id="lastname" name="lastname" required>
                  </div>

                  <div class="col-sm-6 mb-3">
                    <label for="middlename" class="col-form-label">Middle Name</label>
                    <input type="text" class="form-control" id="middlename" name="middlename" required>
                  </div>

                  <div class="col-sm-6 mb-3">
                    <label for="auxillaryname" class="col-form-label">Auxiliary Name</label>
                    <input type="text" class="form-control" id="auxiliaryname" name="auxiliaryname" required>
                  </div>

                  <div class="col-sm-6 mb-3">
                    <label for="birthdate" class="col-form-label">Birthdate</label>
                    <input type="date" class="form-control" id="birthdate" name="birthdate" required>
                  </div>

                  <div class="col-sm-6 mb-3">
                    <label for="civilstatus" class="col-form-label">Civil Status</label>
                    <input type="text" class="form-control" id="civilstatus" name="civilstatus" required>
                  </div>

                  <div class="col-sm-6 mb-3">
                    <label for="gender" class="col-form-label">Gender</label><br>
                    <input type="radio" id="male" name="gender" value="Male" class="gender-radio" required>
                    <label for="male" class="radio-label">Male</label>

                    <input type="radio" id="female" name="gender" value="Female" class="gender-radio" required>
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
                    <input type="text" class="form-control" id="addressline1" name="addressline1" required>
                  </div>
                  <div class="col-sm-6 mb-3">
                    <label for="city" class="col-form-label">City</label>
                    <input type="text" class="form-control" id="city" name="city" required>
                  </div>

                  <div class="col-sm-6 mb-3">
                    <label for="state" class="col-form-label">State | Province | Region</label>
                    <input type="text" class="form-control" id="state" name="state" required>
                  </div>

                  <div class="col-sm-6 mb-3">
                    <label for="zipcode" class="col-form-label">Zip Code</label>
                    <input type="text" class="form-control" id="zipcode" name="zipcode" required>
                  </div>

                  <div class="col-sm-6 mb-3">
                    <label for="contactnumber" class="col-form-label">Contact Number</label>
                    <input type="tel" class="form-control" id="contactnumber" name="contactnumber" required>
                  </div>

                  <div class="col-sm-6 mb-3">
                    <label for="email" class="col-form-label">Email</label>
                    <input type="email" class="form-control" id="email" name="email" required>
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
                    <select class="form-control" id="course" name="course" required>
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
                    <select class="form-control" id="batch" name="batch" required>
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
              class="fa fa-angle-right"></i> Add</b></h2>
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
                    <input type="text" class="form-control" id="editFirstname" name="edit_firstname" required>
                  </div>
                  <div class="col-sm-6 mb-3">
                    <label for="edit_lastname" class="col-form-label">Lastname</label>
                    <input type="text" class="form-control" id="editLastname" name="edit_lastname" required>
                  </div>

                  <div class="col-sm-6 mb-3">
                    <label for="edit_middlename" class="col-form-label">Middle Name</label>
                    <input type="text" class="form-control" id="editMiddlename" name="edit_middlename" required>
                  </div>

                  <div class="col-sm-6 mb-3">
                    <label for="edit_auxiliaryname" class="col-form-label">Auxiliary Name</label>
                    <input type="text" class="form-control" id="editAuxiliaryname" name="edit_auxiliaryname" required>
                  </div>

                  <div class="col-sm-6 mb-3">
                    <label for="edit_birthdate" class="col-form-label">Birthdate</label>
                    <input type="date" class="form-control" id="editBirthdate" name="edit_birthdate" required>
                  </div>

                  <div class="col-sm-6 mb-3">
                    <label for="edit_civilstatus" class="col-form-label">Civil Status</label>
                    <input type="text" class="form-control" id="editCivilstatus" name="edit_civilstatus" required>
                  </div>

                  <div class="col-sm-6 mb-3">
                    <label for="edit_gender" class="col-form-label">Gender</label><br>
                    <input type="radio" id="editMale" name="edit_gender" value="Male" class="gender-radio" required>
                    <label for="edit_male" class="radio-label">Male</label>

                    <input type="radio" id="editMemale" name="edit_gender" value="Female" class="gender-radio" required>
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
                    <input type="text" class="form-control" id="editAddressline1" name="edit_addressline1" required>
                  </div>
                  <div class="col-sm-6 mb-3">
                    <label for="edit_city" class="col-form-label">City</label>
                    <input type="text" class="form-control" id="editCity" name="edit_city" required>
                  </div>

                  <div class="col-sm-6 mb-3">
                    <label for="edit_state" class="col-form-label">State | Province | Region</label>
                    <input type="text" class="form-control" id="editState" name="edit_state" required>
                  </div>

                  <div class="col-sm-6 mb-3">
                    <label for="edit_zipcode" class="col-form-label">Zip Code</label>
                    <input type="text" class="form-control" id="editZipcode" name="edit_zipcode" required>
                  </div>

                  <div class="col-sm-6 mb-3">
                    <label for="edit_contactnumber" class="col-form-label">Contact Number</label>
                    <input type="tel" class="form-control" id="editContactnumber" name="edit_contactnumber" required>
                  </div>

                  <div class="col-sm-6 mb-3">
                    <label for="edit_email" class="col-form-label">Email</label>
                    <input type="email" class="form-control" id="editEmail" name="edit_email" required>
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
                    <select class="form-control" id="editCourse" name="edit_course" required>
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
                    <select class="form-control" id="editBatch" name="edit_batch" required>
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
                <h2 class="modal-title"><b>Alumni <i class="fa fa-angle-right"></i> Manage Alumni <i class="fa fa-angle-right"></i> Import</b></h2>
                <hr>
            </div>

            <div class="modal-body">
                <form class="form-horizontal" method="POST" action="import_file.php" enctype="multipart/form-data">
                    <input type="hidden" name="token" value="<?php echo $_SESSION['token']; ?>">
                    <div class="personal_information">
                        <div class="form-group row" >
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
                        <button type="submit" class="btn btn-flat pull-right btn-class" name="import_excel_btn" style="background:linear-gradient(to right, #90caf9, #047edf 99%); color:white;">
                            <i class="fa fa-save"></i> Save
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!--==============Print File=================-->

<div class="modal fade" id="print">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="box-headerModal"></div>
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h2 class="modal-title"><b>Alumni <i class="fa fa-angle-right"></i> Manage Alumni <i class="fa fa-angle-right"></i> Print</b></h2>
                <hr>
            </div>

            <div class="modal-body">
                <form class="form-horizontal" method="POST" action="import_file.php" enctype="multipart/form-data">
                    <input type="hidden" name="token" value="<?php echo $_SESSION['token']; ?>">
                    <div class="personal_information">
                        <div class="form-group row" >
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
                        <button type="submit" class="btn btn-flat pull-right btn-class" name="import_excel_btn" style="background:linear-gradient(to right, #90caf9, #047edf 99%); color:white;">
                            <i class="fa fa-save"></i> Save
                        </button>
                    </div>
                </form>
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
</script>
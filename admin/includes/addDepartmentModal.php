

<!-- Edit -->

<?php
require_once 'firebaseRDB.php';

// Initialize Firebase URL
$databaseURL = "https://mccnians-bc4f4-default-rtdb.firebaseio.com";
$firebase = new firebaseRDB($databaseURL);

$adminData = $firebase->retrieve("departments");
$adminData = json_decode($adminData, true);

echo '<script>';
echo 'var existingDepartments = ' . json_encode($adminData) . ';';
echo '</script>';
?>
<!-- Modal -->
<div class="modal fade" id="addDepartment">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="box-headerModal"></div>
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title"><b>Add New Department</b></h4>
      </div>
      <div class="modal-body">
        <form id="addDepartmentForm"  class="form-horizontal" method="POST" action="department_add.php">
          <div class="form-group">
            <label for="departmentName" class="col-sm-3 control-label">Department Name</label>
            <div class="col-sm-9">
              <input type="text" class="form-control" id="departmentName" name="departmentName" required>
              <small  id="errorMessage" style="display:none; color:red;"><i class="fa fa-info-circle"></i> This Department Already Exists</small>
            </div>  
          </div>
          <div class="modal-footer">
          <button type="submit" class="btn btn-flat pull-right btn-class" name="add"
          style="background:linear-gradient(to right, #90caf9, #047edf 99%); color:white;"><i class="fa fa-save"></i>
          Save</button>
        <button type="button" class="btn btn-default btn-flat btn-class" data-dismiss="modal"><i
            class="fa fa-close"></i> Close</button>
          </div>
        </form>

      </div> 
    </div>
  </div>
</div>


<script>
document.getElementById('addDepartmentForm').addEventListener('submit', function(event) {
  var departmentName = document.getElementById('departmentName').value.trim();
  var isExisting = false;

  for (var key in existingDepartments) {
    if (existingDepartments.hasOwnProperty(key)) {
      if (existingDepartments[key]['Department Name'].toLowerCase() === departmentName.toLowerCase()) {
        isExisting = true;
        break;
      }
    }
  }

  if (isExisting) {
    event.preventDefault();
    document.getElementById('errorMessage').style.display = 'block';
  }
});
</script>


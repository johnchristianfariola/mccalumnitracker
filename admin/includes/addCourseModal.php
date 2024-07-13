<!-- Add -->
<?php
require_once 'includes/firebaseRDB.php';

// Your Firebase Realtime Database URL
require_once 'config.php'; // Include your config file

$firebase = new firebaseRDB($databaseURL);

// Fetch departments data from Firebase
$data = $firebase->retrieve("departments");
$data = json_decode($data, true); // Decode JSON data into associative arrays


?>


<div class="modal fade" id="course-modal">
  
    <div class="modal-dialog" >

        <div class="modal-content">
        <div class="box-headerModal"></div>
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span></button>
              <h4 class="modal-title"><b>Add Course</b></h4>
            </div>
            <div class="modal-body">
              <form class="form-horizontal" method="POST" action="course_add.php">
                <div class="form-group">
                    <label for="course_name" class="col-sm-3 control-label">Course</label>

                    <div class="col-sm-9">
                      <input type="text" class="form-control" id="course_name" name="course_name" required>
                    </div>
                </div>

                <div class="form-group">
                    <label for="courCode" class="col-sm-3 control-label">Course Code</label>

                    <div class="col-sm-9">
                      <input type="text" class="form-control" id="courCode" name="courCode" required>
                    </div>
                </div>

                <div class="form-group">
                    <label for="department" class="col-sm-3 control-label">Department</label>
                    <div class="col-sm-9">
                    <select class="form-control" id="department" name="department">
                        <option value="">Select a department</option>
                        <?php
                        if (is_array($data)) {
                            foreach ($data as $departmentId => $details) {
                                $departmentName = isset($details['Department Name']) ? $details['Department Name'] : 'Unknown';
                                echo "<option value=\"" . htmlspecialchars($departmentId) . "\">" . htmlspecialchars($departmentName) . "</option>";
                            }
                        }
                        ?>
                    </select>
                </div>
                </div>
            </div>
            <div class="modal-footer">
            <button type="submit" class="btn btn-flat pull-right btn-class" name="add" style="background:#EE4E4E; color:white;"><i class="fa fa-save"></i> Save</button>
            <button type="button" class="btn btn-default btn-flat btn-class" data-dismiss="modal"><i class="fa fa-close"></i> Close</button>
              </form>
            </div>
        </div>
    </div>
</div>

<!-- Edit -->



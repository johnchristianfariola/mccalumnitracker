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
        <form class="form-horizontal" method="POST" action="department_add.php">
          <div class="form-group">
            <label for="departmentName" class="col-sm-3 control-label">Department Name</label>
            <div class="col-sm-9">
              <input type="text" class="form-control" id="departmentName" name="departmentName" required>
            </div>

                
          </div>
          <div class="modal-footer">
            <button type="submit" class="btn btn-flat pull-right btn-class" style="background:#EE4E4E; color:white;">
              <i class="fa fa-save"></i> Save
            </button>
            <button type="button" class="btn btn-default btn-flat btn-class" data-dismiss="modal">
              <i class="fa fa-close"></i> Close
            </button>
          </div>
        </form>

      </div> 
    </div>
  </div>
</div>

<!-- Edit -->
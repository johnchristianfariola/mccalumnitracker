<!-- Add -->
<div class="modal fade" id="batch-modal">
    <div class="modal-dialog">
        <div class="modal-content">
        <div class="box-headerModal"></div>
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span></button>
              <h4 class="modal-title"><b>New Batch</b></h4>
            </div>
            <div class="modal-body">
              <form class="form-horizontal" method="POST" action="batch_add.php">
                <div class="form-group">
                    <label for="bacthName" class="col-sm-3 control-label">Batch Yr</label>

                    <div class="col-sm-9">
                      <input type="text" class="form-control datepicker-year" id="bacthName" name="bacthName" required autocomplete="off">
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
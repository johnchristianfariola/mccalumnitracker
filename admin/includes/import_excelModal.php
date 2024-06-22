<div class="modal fade" id="exportnew">
    <div class="modal-dialog" style="width:80%;">
        <div class="modal-content">
            <div class="box-headerModal"></div>
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span></button>
                <h2 class="modal-title"><b>Alumni <i class="fa fa-angle-right"></i> Manage Alumni <i
                            class="fa fa-angle-right"></i>
                        Add</b></h2>
                <hr>
            </div>

            <div class="modal-body">
                <form class="form-horizontal" method="POST" action="import_file.php" enctype="multipart/form-data">
                    <input type="hidden" name="token" value="<?php echo $_SESSION['token']; ?>">
                    <div class="personal_information">
                        <div class="form-group row" style="border-bottom: 1px solid silver !important;">
                            <label for="firstname" class="col-sm-3 col-form-label text-sm-end">
                                <h4>Import Information</h4>
                            </label>
                            <div class="col-sm-6">
                                <div class="row">
                                    <div class="col-sm-6 mb-3">
                                        <input type="file" name="import_file" class="form-control" required />
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" name="import_excel_btn" class="btn btn-primary mt-3">Import</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

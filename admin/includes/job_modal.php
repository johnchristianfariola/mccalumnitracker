<!-- Add -->

<script>
    document.addEventListener("DOMContentLoaded", function () {
        if (typeof CKEDITOR !== 'undefined' && CKEDITOR.replace) {
            CKEDITOR.replace('job_description');
        } else {
            console.error('CKEditor is not defined or replace method is missing.');
        }
    });

    function previewImage(event) {
        var reader = new FileReader();
        reader.onload = function () {
            var output = document.getElementById('imagePreviewImg');
            output.src = reader.result;
            output.style.display = 'block';
        };
        reader.readAsDataURL(event.target.files[0]);
    }
</script>

<div class="modal fade" id="addnew">
    <div class="modal-dialog" style="width:80%;">
        <div class="modal-content">
            <div class="box-headerModal"></div>
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span></button>
                <h2 class="modal-title"><b>Content <i class="fa fa-angle-right"></i> Job <i
                            class="fa fa-angle-right"></i>
                        Add</b></h2>
                <hr>
            </div>
            <div class="modal-body">

                <form class="form-horizontal" method="POST" action="job_add.php" enctype="multipart/form-data">
                    <input type="hidden" name="token" value="<?php echo $_SESSION['token']; ?>">
                    <div class="personal_information">
                        <div class="form-group row" style="border-bottom: 1px solid silver !important;">
                            <label for="firstname" class="col-sm-3 col-form-label text-sm-end">
                                <h4>Primary Details</h4>
                            </label>
                            <div class="col-sm-7">
                                <div class="row">
                                    <div class="col-sm-12 mb-3">
                                        <label for="job_title" class="col-form-label">Job Title</label>
                                        <input type="text" class="form-control" id="job_title" name="job_title"
                                            required>
                                    </div>
                                    <div class="col-sm-12 mb-3">
                                        <label for="company_name" class="col-form-label">Company Name</label>
                                        <input type="text" class="form-control" id="company_name" name="company_name"
                                            required>
                                    </div>

                                    <div class="col-sm-6 mb-3">
                                        <label for="work_time" class="col-form-label">Work Time</label><br>
                                        <input type="radio" id="part_time" name="work_status" value="Part-Time"
                                            class="partime-radio" required>
                                        <label for="part_time" class="radio-label">Part Time</label>

                                        <input type="radio" id="full_time" name="work_status" value="Full-Time"
                                            class="partime-radio" required>
                                        <label for="full_time" class="radio-label">Full Time</label>
                                    </div>

                                    <div class="col-sm-6 mb-3">
                                        <label for="status" class="col-form-label">Status</label><br>
                                        <input type="radio" id="archive" name="status" value="Archive"
                                            class="status-radio" required>
                                        <label for="archive" class="radio-label">Archive</label>

                                        <input type="radio" id="active" name="status" value="Active"
                                            class="status-radio" required>
                                        <label for="active" class="radio-label">Active</label>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="form-group row" style="border-bottom: 1px solid silver !important;">
                            <label for="address" class="col-sm-3 col-form-label text-sm-end">
                                <h4>Other Details</h4>
                            </label>
                            <div class="col-sm-7">
                                <div class="row">
                                    <div class="col-sm-12 mb-3">
                                        <label for="job_title" class="col-form-label">Description</label>
                                        <textarea class="form-control" id="job_description"
                                            name="job_description"></textarea>
                                    </div>

                                    <div class="col-sm-6"></div>
                                </div>
                            </div>
                        </div>
                    </div>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-flat pull-right btn-class" name="add"
                    style="background:linear-gradient(to right, #90caf9, #047edf 99%); color:white;"><i class="fa fa-save"></i> Save</button>
                <button type="button" class="btn btn-default btn-flat btn-class" data-dismiss="modal"><i
                        class="fa fa-close"></i> Close</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Edit -->


<div class='modal fade' id='editModal' tabindex='-1' role='dialog' aria-labelledby='editModalLabel' aria-hidden='true'>
    <div class="modal-dialog" style="width:80%;">
        <div class="modal-content">
            <div class="box-headerModal"></div>
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span></button>
                <h2 class="modal-title"><b>Content <i class="fa fa-angle-right"></i> Job <i
                            class="fa fa-angle-right"></i>
                        Update</b></h2>
                <hr>
            </div>
            <div class="modal-body">
                <form class="form-horizontal" method="POST" action="job_edit.php" enctype="multipart/form-data">
                    <input type="hidden" id="editId" name="id">
                    <input type="hidden" name="token" value="<?php echo $_SESSION['token']; ?>">
                    <div class="personal_information">
                        <div class="form-group row" style="border-bottom: 1px solid silver !important;">
                            <label for="firstname" class="col-sm-3 col-form-label text-sm-end">
                                <h4>Primary Details</h4>
                            </label>
                            <div class="col-sm-7">
                                <div class="row">
                                    <div class="col-sm-12 mb-3">
                                        <label for="edit_job_title" class="col-form-label">Job Title</label>
                                        <input type="text" class="form-control" id="edit_job_title"
                                            name="edit_job_title" required>
                                    </div>
                                    <div class="col-sm-12 mb-3">
                                        <label for="edit_company_name" class="col-form-label">Company Name</label>
                                        <input type="text" class="form-control" id="edit_company_name"
                                            name="edit_company_name" required>
                                    </div>

                                    <div class="col-sm-6 mb-3">
                                        <label for="work_time" class="col-form-label">Work Time</label><br>
                                        <input type="radio" id="edit_parttime" name="edit_work_status" value="Part-Time"
                                            class="partime-radio" required>
                                        <label for="edit_parttime" class="radio-label">Part Time</label>

                                        <input type="radio" id="edit_fulltime" name="edit_work_status" value="Full-Time"
                                            class="partime-radio" required>
                                        <label for="edit_fulltime" class="radio-label">Full Time</label>
                                    </div>

                                    <div class="col-sm-6 mb-3">
                                        <label for="status" class="col-form-label">Status</label><br>
                                        <input type="radio" id="edit_statusArchive" name="edit_status" value="Archive"
                                            class="status-radio" required>
                                        <label for="edit_statusArchive" class="radio-label">Archive</label>

                                        <input type="radio" id="edit_statusActive" name="edit_status" value="Active"
                                            class="status-radio" required>
                                        <label for="edit_statusActive" class="radio-label">Active</label>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="form-group row" style="border-bottom: 1px solid silver !important;">
                            <label for="address" class="col-sm-3 col-form-label text-sm-end">
                                <h4>Other Details</h4>
                            </label>
                            <div class="col-sm-7">
                                <div class="row">
                                    <div class="col-sm-12 mb-3">
                                        <label for="job_title" class="col-form-label">Description</label>
                                        <textarea class="form-control" id="edit_description"
                                            name="edit_job_description"></textarea>
                                    </div>

                                    <div class="col-sm-6"></div>
                                </div>
                            </div>
                        </div>
                    </div>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-flat pull-right btn-class" name="add"
                    style="background:linear-gradient(to right, #90caf9, #047edf 99%); color:white;"><i class="fa fa-save"></i> Save</button>
                <button type="button" class="btn btn-default btn-flat btn-class" data-dismiss="modal"><i
                        class="fa fa-close"></i> Close</button>
                </form>
            </div>
        </div>
    </div>
</div>
>

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
                <form class="form-horizontal" method="POST" action="job_delete.php">
                    <input type="hidden" class="deleteId" name="id">
                    <div class="text-center">
                        <p>Are you sure you want to delete this Job?</p>
                        <h2 class="deleteTitle"></h2>
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



<style>
    .mb-3 {
        margin-bottom: 30px;
    }

    .partime-radio,
    .status-radio {
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
    .partime-radio:checked+.radio-label,
    .status-radio:checked+.radio-label {
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
</style>
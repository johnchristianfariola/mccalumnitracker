<script>
    function validateForm() {
    let isValid = true;

    // Survey Title validation
    const surveyTitle = document.getElementById("survey_title");
    const titleError = document.getElementById("add_title_error");
    if (surveyTitle.value.trim() === "") {
        titleError.style.display = "block";
        isValid = false;
    } else {
        titleError.style.display = "none";
    }

    // Survey Description validation
    const surveyDesc = document.getElementById("survey_desc");
    const descError = document.getElementById("add_desc_error");
    if (surveyDesc.value.trim() === "") {
        descError.style.display = "block";
        isValid = false;
    } else {
        descError.style.display = "none";
    }

    // Survey Start Date validation
    const surveyStart = document.getElementById("survey_start");
    const startDateError = document.getElementById("add_startdate_error");
    if (surveyStart.value.trim() === "") {
        startDateError.style.display = "block";
        isValid = false;
    } else {
        startDateError.style.display = "none";
    }

    // Survey End Date validation
    const surveyEnd = document.getElementById("survey_end");
    const endDateError = document.getElementById("add_enddate_error");
    if (surveyEnd.value.trim() === "") {
        endDateError.style.display = "block";
        isValid = false;
    } else {
        endDateError.style.display = "none";
    }

    return isValid;
}

function validateEditForm() {
    let isValid = true;

    // Survey Title validation
    const editSurveyTitle = document.getElementById("edit_survey_title");
    const editTitleError = document.getElementById("edit_title_error");
    if (editSurveyTitle.value.trim() === "") {
        editTitleError.style.display = "block";
        isValid = false;
    } else {
        editTitleError.style.display = "none";
    }

    // Survey Description validation
    const editSurveyDesc = document.getElementById("edit_survey_desc");
    const editDescError = document.getElementById("edit_desc_error");
    if (editSurveyDesc.value.trim() === "") {
        editDescError.style.display = "block";
        isValid = false;
    } else {
        editDescError.style.display = "none";
    }

    // Survey Start Date validation
    const editSurveyStart = document.getElementById("edit_survey_start");
    const editStartDateError = document.getElementById("edit_startdate_error");
    if (editSurveyStart.value.trim() === "") {
        editStartDateError.style.display = "block";
        isValid = false;
    } else {
        editStartDateError.style.display = "none";
    }

    // Survey End Date validation
    const editSurveyEnd = document.getElementById("edit_survey_end");
    const editEndDateError = document.getElementById("edit_enddate_error");
    if (editSurveyEnd.value.trim() === "") {
        editEndDateError.style.display = "block";
        isValid = false;
    } else {
        editEndDateError.style.display = "none";
    }

    return isValid;
}
</script>
<div class="modal fade" id="addnew">
    <div class="modal-dialog" style="width:80%;">
        <div class="modal-content">
            <div class="box-headerModal"></div>
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span></button>
                <h2 class="modal-title"><b>Survey <i class="fa fa-angle-right"></i> Survey Set <i class="fa fa-angle-right"></i> Add</b></h2>
                <hr>
            </div>
            <div class="modal-body">
                <form id="addSurveyForm" class="form-horizontal" method="POST" action="survey_add.php" enctype="multipart/form-data" onsubmit="return validateForm()">
                    <input type="hidden" name="token" value="<?php echo $_SESSION['token']; ?>">
                    <div class="personal_information">
                        <div class="form-group row" style="border-bottom: 1px solid silver !important;">
                            <label for="firstname" class="col-sm-3 col-form-label text-sm-end">
                                <h4>Primary Details</h4>
                            </label>
                            <div class="col-sm-7">
                                <div class="row">
                                    <div class="col-sm-12 mb-3">
                                        <label for="type" class="col-form-label">Type</label>
                                        <select class="form-control" name="type" id="type">
                                            <option value="Built in survey">Built in survey</option>
                                        </select>
                                    </div>
                                    <div class="col-sm-12 mb-3">
                                        <label for="survey_title" class="col-form-label">Survey Title</label>
                                        <input type="text" class="form-control" id="survey_title" name="survey_title" >
                                        <small class="error-message" id="add_title_error" style="color:red; display:none;"><i class="fa fa-info-circle"></i> This field is required.</small>
                                    </div>
                                    <div class="col-sm-12 mb-3">
                                        <label for="survey_desc" class="col-form-label">Survey Description</label>
                                        <textarea class="form-control" id="survey_desc" name="survey_desc" style="height: 200px;"></textarea>
                                        <small class="error-message" id="add_desc_error" style="color:red; display:none;"><i class="fa fa-info-circle"></i> This field is required.</small>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group row" style="border-bottom: 1px solid silver !important;">
                            <label for="edit_address" class="col-sm-3 col-form-label text-sm-end">
                                <h4>Timeframe</h4>
                            </label>
                            <div class="col-sm-6">
                                <div class="row">
                                    <div class="col-sm-6 mb-3">
                                        <label for="survey_start" class="col-form-label">Start Date</label>
                                        <input type="date" class="form-control" id="survey_start" name="survey_start"  value="<?php echo date('Y-m-d'); ?>" min="<?php echo date('Y-m-d'); ?>">
                                        <small class="error-message" id="add_startdate_error" style="color:red; display:none;"><i class="fa fa-info-circle"></i> This field is required.</small>
                                    </div>
                                    <div class="col-sm-6 mb-3">
                                        <label for="survey_end" class="col-form-label">End Date</label>
                                        <input type="date" class="form-control" id="survey_end" name="survey_end"  min="<?php echo date('Y-m-d'); ?>">
                                        <small class="error-message" id="add_enddate_error" style="color:red; display:none;"><i class="fa fa-info-circle"></i> This field is required.</small>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-flat pull-right btn-class" name="add" style="background:linear-gradient(to right, #90caf9, #047edf 99%); color:white;"><i class="fa fa-save"></i> Save</button>
                        <button type="button" class="btn btn-default btn-flat btn-class" data-dismiss="modal"><i class="fa fa-close"></i> Close</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>


<div class="modal fade" id="editModal">
    <div class="modal-dialog" style="width:80%;">
        <div class="modal-content">
            <div class="box-headerModal"></div>
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span></button>
                    <h2 class="modal-title"><b>Survey <i class="fa fa-angle-right"></i> Survey Set <i class="fa fa-angle-right"></i>
                        Edit</b></h2>
                <hr>
            </div>
            <div class="modal-body">
                <form id="editSurveyForm" class="form-horizontal" method="POST" action="survey_edit.php" enctype="multipart/form-data" onsubmit="return validateEditForm()">
                    <input type="hidden" name="token" value="<?php echo $_SESSION['token']; ?>">
                    <input type="hidden" name="id" id="editId" value="">
                    <div class="personal_information">
                        <div class="form-group row" style="border-bottom: 1px solid silver !important;">
                            <label for="firstname" class="col-sm-3 col-form-label text-sm-end">
                                <h4>Primary Details</h4>
                            </label>
                            <div class="col-sm-7">
                                <div class="row">
                                    <div class="col-sm-12 mb-3">
                                        <label for="edit_type" class="col-form-label">Type</label>
                                        <select class="form-control" name="edit_type" id="edit_type">
                                            <option value="Built in survey">Built in survey</option>
                                        </select>
                                    </div>
                                    <div class="col-sm-12 mb-3">
                                        <label for="edit_survey_title" class="col-form-label">Survey Title</label>
                                        <input type="text" class="form-control" id="edit_survey_title" name="edit_survey_title">
                                        <small class="error-message" id="edit_title_error" style="color:red; display:none;"><i class="fa fa-info-circle"></i> This field is required.</small>
                                    </div>
                                    <div class="col-sm-12 mb-3">
                                        <label for="edit_survey_desc" class="col-form-label">Survey Description</label>
                                        <textarea class="form-control" id="edit_survey_desc" name="edit_survey_desc" style="height: 200px;"></textarea>
                                        <small class="error-message" id="edit_desc_error" style="color:red; display:none;"><i class="fa fa-info-circle"></i> This field is required.</small>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group row" style="border-bottom: 1px solid silver !important;">
                            <label for="edit_address" class="col-sm-3 col-form-label text-sm-end">
                                <h4>Timeframe</h4>
                            </label>
                            <div class="col-sm-6">
                                <div class="row">
                                    <div class="col-sm-6 mb-3">
                                        <label for="edit_survey_start" class="col-form-label">Start Date</label>
                                        <input type="date" class="form-control" id="edit_survey_start" name="edit_survey_start">
                                        <small class="error-message" id="edit_startdate_error" style="color:red; display:none;"><i class="fa fa-info-circle"></i> This field is required.</small>
                                    </div>
                                    <div class="col-sm-6 mb-3">
                                        <label for="edit_survey_end" class="col-form-label">End Date</label>
                                        <input type="date" class="form-control" id="edit_survey_end" name="edit_survey_end" min="<?php echo date('Y-m-d'); ?>">
                                        <small class="error-message" id="edit_enddate_error" style="color:red; display:none;"><i class="fa fa-info-circle"></i> This field is required.</small>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-flat pull-right btn-class" name="add" style="background:linear-gradient(to right, #90caf9, #047edf 99%); color:white;"><i class="fa fa-save"></i> Save</button>
                <button type="button" class="btn btn-default btn-flat btn-class" data-dismiss="modal"><i class="fa fa-close"></i> Close</button>
                </form>
            </div>
        </div>
    </div>
</div>


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
                <form id="deleteSurveyForm" class="form-horizontal" method="POST" action="survey_delete.php">
                    <input type="hidden" class="deleteId" name="id">
                    <div class="text-center">
                        <p>Are you sure you want to delete this Survey?</p>
                        <h2 class="edit_survey_title"></h2>
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

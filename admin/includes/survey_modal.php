<div class="modal fade" id="addnew">
    <div class="modal-dialog" style="width:80%;">
        <div class="modal-content">
            <div class="box-headerModal"></div>
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span></button>
                <h2 class="modal-title"><b>Survey <i class="fa fa-angle-right"></i> 
                        Add</b></h2>
                <hr>
            </div>
            <div class="modal-body">

                <form class="form-horizontal" method="POST" action="survey_add.php" enctype="multipart/form-data">
                    <input type="hidden" name="token" value="<?php echo $_SESSION['token']; ?>">
                    <div class="personal_information">
                        <div class="form-group row" style="border-bottom: 1px solid silver !important;">
                            <label for="firstname" class="col-sm-3 col-form-label text-sm-end">
                                <h4>Primary Details</h4>
                            </label>
                            <div class="col-sm-7">
                                <div class="row">
                                    <div class="col-sm-12 mb-3">
                                        <label for="" class="col-form-label">Type</label>
                                        <select class="form-control" name="" id="">
                                            <option value="Built in survey">Built in survey</option>
                                        </select>
                                    </div>
                                    <div class="col-sm-12 mb-3">
                                        <label for="survey_title" class="col-form-label">Survey Title</label>
                                        <input type="text" class="form-control" id="survey_title" name="survey_title"
                                            required>
                                    </div>

                                    <div class="col-sm-12 mb-3">
                                        <label for="survey_desc" class="col-form-label">Survey Description</label>
                                        <textarea class="form-control" id="survey_desc" name="survey_desc"
                                            style="height: 200px;"></textarea>

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
                                        <input type="date" class="form-control" id="survey_start"
                                            name="survey_start" required value="<?php echo date('Y-m-d'); ?>"
                                            min="<?php echo date('Y-m-d'); ?>">

                                    </div>
                                    <div class="col-sm-6 mb-3">
                                        <label for="survey_end" class="col-form-label">End Date</label>
                                        <input type="date" class="form-control" id="survey_end" name="survey_end" required
                                            min="<?php echo date('Y-m-d'); ?>">
                                    </div>


                                </div>
                            </div>
                        </div>
                    </div>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-flat pull-right btn-class" name="add"
                    style="background:linear-gradient(to right, #90caf9, #047edf 99%); color:white;"><i
                        class="fa fa-save"></i> Save</button>
                <button type="button" class="btn btn-default btn-flat btn-class" data-dismiss="modal"><i
                        class="fa fa-close"></i> Close</button>
                </form>
            </div>
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
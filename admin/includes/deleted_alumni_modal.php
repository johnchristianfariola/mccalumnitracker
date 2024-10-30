<div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title"><b>Deleting...</b></h4>
            </div>
            <div class="modal-body">
                <form class="form-horizontal" id="deleteAlumniForm" method="POST">
                    <input type="hidden" class="deleteId" name="id">
                    <div class="text-center">
                        <p>School ID: <span class="editStudentid"></span></p>
                        <h2 class="editFirstname editMiddlename editLastname"></h2>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-default pull-right btn-flat btn-class" form="deleteAlumniForm"
                    style="background:linear-gradient(to right, #90caf9, #047edf 99%); color:white;">
                    <i class="fa fa-trash"></i> Delete
                </button>
                <button type="button" class="btn btn-flat btn-class" data-dismiss="modal">
                    <i class="fa fa-close"></i> Close
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Modal for Retrieve Confirmation -->
<div class="modal fade" id="retrieveModal" tabindex="-1" role="dialog" aria-labelledby="retrieveModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title"><b>Retrieving...</b></h4>
            </div>
            <div class="modal-body">
                <form class="form-horizontal" id="retrieveAlumniForm" method="POST">
                    <input type="hidden" class="retrieveId" name="id">
                    <div class="text-center">
                        <p>School ID: <span class="editStudentid"></span></p>
                        <h2 class="editFirstname editMiddlename editLastname"></h2>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-default pull-right btn-flat btn-class" form="retrieveAlumniForm"
                    style="background:linear-gradient(to right, #90caf9, #047edf 99%); color:white;">
                    <i class="fa fa-recycle"></i> Retrieve
                </button>
                <button type="button" class="btn btn-flat btn-class" data-dismiss="modal">
                    <i class="fa fa-close"></i> Close
                </button>
            </div>
        </div>
    </div>
</div>
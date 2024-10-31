<div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel"
    aria-hidden="true">
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
<div class="modal fade" id="retrieveModal" tabindex="-1" role="dialog" aria-labelledby="retrieveModalLabel"
    aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title"><b>Restoring...</b></h4>
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
                    <i class="fa fa-recycle"></i> Restore
                </button>
                <button type="button" class="btn btn-flat btn-class" data-dismiss="modal">
                    <i class="fa fa-close"></i> Close
                </button>
            </div>
        </div>
    </div>
</div>



<!-- Delete News Modal -->
<div class="modal fade" id="deleteNewsModal" tabindex="-1" role="dialog" aria-labelledby="deleteNewsModalLabel"
    aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title"><b>Deleting...</b></h4>
            </div>
            <div class="modal-body">
                <form class="form-horizontal" id="deleteNewsForm" method="POST">
                    <input type="hidden" class="deleteId" name="id">
                    <div class="text-center">
                        <h4>News Title</h4>
                        <h2 class="deleteNewsTitle"></h2>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-default pull-right btn-flat btn-class" form="deleteNewsForm"
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

<!-- Restore News Modal -->
<div class="modal fade" id="restoreNewsModal" tabindex="-1" role="dialog" aria-labelledby="restoreNewsModalLabel"
    aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title"><b>Restoring...</b></h4>
            </div>
            <div class="modal-body">
                <form class="form-horizontal" id="restoreNewsForm" method="POST">
                    <input type="hidden" class="retrieveId" name="id">
                    <div class="text-center">
                        <h4>News Title</h4>
                        <h2 class="restoreNewsTitle"></h2>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-default pull-right btn-flat btn-class" form="restoreNewsForm"
                    style="background:linear-gradient(to right, #90caf9, #047edf 99%); color:white;">
                    <i class="fa fa-recycle"></i> Restore
                </button>
                <button type="button" class="btn btn-flat btn-class" data-dismiss="modal">
                    <i class="fa fa-close"></i> Close
                </button>
            </div>
        </div>
    </div>
</div>



<!-- Delete News Modal -->
<div class="modal fade" id="deleteEventModal" tabindex="-1" role="dialog" aria-labelledby="deleteNewsModalLabel"
    aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title"><b>Deleting...</b></h4>
            </div>
            <div class="modal-body">
                <form class="form-horizontal" id="deleteEventForm" method="POST">
                    <input type="hidden" class="deleteId" name="id">
                    <div class="text-center">
                        <h4>Event Title</h4>
                        <h2 class="deleteEventTitle"></h2>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-default pull-right btn-flat btn-class" form="deleteEventForm"
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

<!-- Restore News Modal -->
<div class="modal fade" id="restoreEventModal" tabindex="-1" role="dialog" aria-labelledby="restoreNewsModalLabel"
    aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title"><b>Restoring...</b></h4>
            </div>
            <div class="modal-body">
                <form class="form-horizontal" id="restoreEventForm" method="POST">
                    <input type="hidden" class="retrieveId" name="id">
                    <div class="text-center">
                        <h4>Event Title</h4>
                        <h2 class="restoreEventTitle"></h2>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-default pull-right btn-flat btn-class" form="restoreEventForm"
                    style="background:linear-gradient(to right, #90caf9, #047edf 99%); color:white;">
                    <i class="fa fa-recycle"></i> Restore
                </button>
                <button type="button" class="btn btn-flat btn-class" data-dismiss="modal">
                    <i class="fa fa-close"></i> Close
                </button>
            </div>
        </div>
    </div>
</div>



<!-- Delete Job Modal -->
<div class="modal fade" id="deleteJobModal" tabindex="-1" role="dialog" aria-labelledby="deleteJobModalLabel"
    aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title"><b>Deleting...</b></h4>
            </div>
            <div class="modal-body">
                <form class="form-horizontal" id="deleteJobForm" method="POST">
                    <input type="hidden" class="deleteId" name="id">
                    <div class="text-center">
                        <h4>Job Title</h4>
                        <h2 class="deleteJobTitle"></h2>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-default pull-right btn-flat btn-class" form="deleteJobForm"
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

<!-- Restore Job Modal -->
<div class="modal fade" id="restoreJobModal" tabindex="-1" role="dialog" aria-labelledby="restoreJobModalLabel"
    aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title"><b>Restoring...</b></h4>
            </div>
            <div class="modal-body">
                <form class="form-horizontal" id="restoreJobForm" method="POST">
                    <input type="hidden" class="retrieveId" name="id">
                    <div class="text-center">
                        <h4>Job Title</h4>
                        <h2 class="restoreJobTitle"></h2>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-default pull-right btn-flat btn-class" form="restoreJobForm"
                    style="background:linear-gradient(to right, #90caf9, #047edf 99%); color:white;">
                    <i class="fa fa-recycle"></i> Restore
                </button>
                <button type="button" class="btn btn-flat btn-class" data-dismiss="modal">
                    <i class="fa fa-close"></i> Close
                </button>
            </div>
        </div>
    </div>
</div>
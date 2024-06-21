<!-- Add -->

<div class="modal fade" id="addnew">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="box-headerModal"></div>
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span></button>
                <h3 class="modal-title"><b>Content <i class="fa fa-angle-right"></i> Gallery <i
                            class="fa fa-angle-right"></i>
                        Add</b></h>
            </div>
            <div class="modal-body">
                <form class="form-horizontal" method="POST" action="gallery_view_add.php" enctype="multipart/form-data">
                    <input type="hidden" name="token" value="<?php echo $_SESSION['token']; ?>">
                    <input type="hidden" name="gallery_id" value="<?php echo htmlspecialchars($_GET['id']); ?>">
                    <div class="form-group">
                        <label for="album_images" class="col-sm-3 control-label">Select Images</label>
                        <div class="col-sm-9">
                            <input type="file" class="form-control" id="album_images" name="album_images[]" multiple
                                accept="image/*" required>
                        </div>
                    </div>

            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-flat pull-right btn-class" name="addImages"
                    style="background:#EE4E4E; color:white;"><i class="fa fa-save"></i> Save</button>
                <button type="button" class="btn btn-default btn-flat btn-class" data-dismiss="modal"><i
                        class="fa fa-close"></i> Close</button>

                </form>
            </div>
        </div>
    </div>
</div>


<!-- Edit -->

<div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="editModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editModalLabel">Edit Gallery Item</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <!-- Form for editing gallery item -->
                <form id="editForm" action="gallery_view_edit.php" method="post" enctype="multipart/form-data">
                    <input type="hidden" id="editId" name="id">

                    <div class="form-group">
                        <label for="edit_album_image_url">Current Image URL</label>
                        <input type="text" class="form-control" id="edit_album_image_url" name="image_url" readonly>
                    </div>

                    <div class="form-group">
                        <label for="imageFile">Change Image</label>
                        <input type="file" class="form-control" id="imageFile" name="imageFile">
                    </div>

                    <div class="form-group">
                        <label for="newFileName">New File Name</label>
                        <input type="text" class="form-control" id="newFileName" name="newFileName"
                            placeholder="Enter new file name">
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" id="saveChanges">Save changes</button>
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

                <input type="hidden" id="deleteAlbumId" value="">
                <div class="text-center">
                    <p>Are you sure you want to delete this Photo?</p>
                    <h2 class="deleteTitle"></h2>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-danger btn-confirm-delete">Delete</button>
            </div>
        </div>
    </div>
</div>
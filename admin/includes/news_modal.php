<!-- Add -->

<script>
    document.addEventListener("DOMContentLoaded", function () {
        if (typeof CKEDITOR !== 'undefined' && CKEDITOR.replace) {
            CKEDITOR.replace('description');
        } else {
            console.error('CKEditor is not defined or replace method is missing.');
        }
    });



    function previewImage(event, previewId) {
        var reader = new FileReader();
        reader.onload = function () {
            var output = document.getElementById(previewId);
            output.src = reader.result;
            output.style.display = 'block';
        };
        reader.readAsDataURL(event.target.files[0]);
    }

</script>


<div class="modal fade" id="addnew">
    <div class="modal-dialog custom-modal-width">
        <div class="modal-content">
            <div class="box-headerModal"></div>
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h2 class="modal-title"><b>Content <i class="fa fa-angle-right"></i> News <i
                            class="fa fa-angle-right"></i> Add</b></h2>
            </div>
            <div class="modal-body" style="padding: 0 !important;">
                <form class="form-horizontal flex-container" method="POST" action="news_add.php"
                    enctype="multipart/form-data">
                    <div class="form-container">
                        <div class="form-group">
                            <label for="news_title" class="col-sm-2 control-label">New Title</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="news_title" name="news_title" required>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="news_author" class="col-sm-2 control-label">Author</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="news_author" name="news_author" required>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="description" class="col-sm-2 control-label">Description</label>
                            <div class="col-sm-10">
                                <textarea class="form-control" id="description" name="news_description"></textarea>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-flat pull-right btn-class"
                                style="background:#EE4E4E; color:white;"><i class="fa fa-save"></i> Save</button>
                            <button type="button" class="btn btn-default btn-flat btn-class" data-dismiss="modal"><i
                                    class="fa fa-close"></i> Close</button>
                        </div>
                    </div>
                    <div class="right-div">
                        <div class="image-upload-container">
                            <div class="image-preview" id="imagePreviewAdd">
                                <img id="imagePreviewImg" src="" alt="Image Preview" style="display:none;">
                                <div class="upload-controls">
                                    <label for="imageUploadAdd" class="image-upload-label">Edit</label>
                                    <input type="file" id="imageUploadAdd" name="imageUpload" accept="image/*"
                                        onchange="previewImage(event, 'imagePreviewImg')" style="display:none;">
                                </div>
                            </div>
                            <h5 class="h5">Thumbnail</h5>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>




<!-- Edit -->
<div class='modal fade' id='editModal' tabindex='-1' role='dialog' aria-labelledby='editModalLabel' aria-hidden='true'>
    <div class="modal-dialog custom-modal-width">
        <div class="modal-content">
            <div class="box-headerModal"></div>
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h2 class="modal-title"><b>Content <i class="fa fa-angle-right"></i> News <i
                            class="fa fa-angle-right"></i> Edit</b></h2>
            </div>
            <div class="modal-body" style="padding: 0 !important;">
                <form class="form-horizontal flex-container" method="POST" action="news_edit.php"
                    enctype="multipart/form-data">
                    <div class="form-container">
                        <input type="hidden" name="id" id="editId" value=""> <!-- Hidden input for ID -->
                        <div class="form-group">
                            <label for="editTitle" class="col-sm-2 control-label">New Title</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="editTitle" name="edit_title" required>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="editAuthor" class="col-sm-2 control-label">Author</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="editAuthor" name="edit_author" required>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="editDesc" class="col-sm-2 control-label">Description</label>
                            <div class="col-sm-10">
                                <textarea class="form-control" id="editDesc" name="edit_description"
                                    required></textarea>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-flat pull-right btn-class"
                                style="background:#EE4E4E; color:white;"><i class="fa fa-save"></i> Save</button>
                            <button type="button" class="btn btn-default btn-flat btn-class" data-dismiss="modal"><i
                                    class="fa fa-close"></i> Close</button>
                        </div>
                    </div>
                    <div class="right-div">
                        <div class="image-upload-container">
                            <div class="image-preview" id="imagePreviewEdit">
                                <img id="imagePreviewImg2" src="" alt="Image Preview" style="display:none;">
                                <div class="upload-controls">
                                    <label for="imageUploadEdit" class="image-upload-label">Edit</label>
                                    <input type="file" id="imageUploadEdit" name="imageUpload" accept="image/*"
                                        onchange="previewImage(event, 'imagePreviewImg2')" style="display:none;">
                                </div>
                            </div>
                            <h5 class="h5">Thumbnail</h5>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>



<!-- Delete -->
<div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" style="width:60%;">
        <div class="modal-content">
            <div class="box-headerModal"></div>
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title"><b>Deleting...</b></h4>
            </div>
            <div class="modal-body">
                <form class="form-horizontal" method="POST" action="news_delete.php">
                    <input type="hidden" class="deleteId" name="id">
                    <div class="text-center">
                        <!-- News Image -->

                        <div class="img-container">
                            <div class="overlay">
                                <a id="imageLink" href="#" target="_blank" class="btn btn-danger btn-flat">View
                                    Image</a>
                            </div>
                            <img id="imagePreviewImg3" src="" alt="Image Preview" style="display:none;">
                        </div>


                        <br><br>

                        <h3 class="title"></h3>
                        <!-- News Content -->
                        <div class="description-container">
                            <!-- Description content will be inserted here -->
                        </div>
                    </div>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-default pull-right btn-flat btn-class" name="delete"
                    style="background:#EE4E4E; color:white;">
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


<!--========FOR DELETE=========-->
<style>
    .img-container {
        position: relative;
        width: 100%;
        height: 200px;

        overflow: hidden;
    }

    .overlay {
        position: absolute;
        top: 100%;
        left: 0;
        width: 100%;
        height: 100%;
        display: flex;
        justify-content: center;
        align-items: center;
        background-color: #333;
        transition: top 0.3s ease;
        opacity: 0.5;
    }

    .img-container:hover .overlay {
        top: 0;
    }

    .img-container img {
        width: 100%;
        height: auto;
        display: block;
    }

    .overlay-text {
        color: #ffffff;
        /* Text color */
        font-size: 18px;
        /* Font size */
        text-align: center;
        /* Center text */
        padding: 10px;
        /* Padding around text */
    }

    .title,
    .description-container h1 {
        text-align: left;
        margin-right: 90px;
    }

    .description-container p {
        text-align: justify;
        margin-right: 90px;
    }

    .title,
    .description-container {
        font-family: Arial, Helvetica, sans-serif;


        padding: 40px;
    }
</style>
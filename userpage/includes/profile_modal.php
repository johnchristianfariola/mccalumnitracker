<div class="modal fade" id="myModalone" role="dialog">
    <div class="modal-dialog modals-default">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <!-- Profile Picture Section -->
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <label class="profile-label mb-0">Profile Picture</label>
                    <button type="button" class="edit-button">Edit</button>
                </div>
                <div class="text-center">
                    <img src="../images/profile.jpg" alt="Profile Picture" class="profile-picture">
                </div>
                <br><br><br>

                <!-- Cover Photo Section -->
                <div class="d-flex justify-content-between align-items-center mt-4">
                    <label class="cover-label mb-0">Cover Photo</label>
                    <button type="button" class="edit-button-cover">Edit</button>
                </div>
                <div class="text-center">
                    <img src="../images/background_copy1.png" alt="Cover Photo" class="cover-photo">
                </div>
                <br><br><br>

                <!-- Bio Section -->
                <div class="d-flex justify-content-between align-items-center mt-4">
                    <label class="bio-label mb-0">Bio</label>
                    <button type="button" class="edit-bio-button">Edit Bio</button>
                    <p class="bio-content">
                        Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor incididunt ut
                        labore et dolore magna aliqua.
                    </p>
                </div>
                <br><br><br>

                <!-- Customize Your Info Section -->
                <div class="customize-info">
                    <h4>Customize your info</h4>
                    <!-- Inside your modal body -->
                    <div class="info-item">
                        <span class="info-label">Name:</span>
                        <span class="info-value"></span>
                        <button type="button" class="edit-info-button">Edit</button>
                    </div>
                    <div class="info-item">
                        <span class="info-label">Email:</span>
                        <span class="info-value"></span>
                        <button type="button" class="edit-info-button">Edit</button>
                    </div>
                    <div class="info-item">
                        <span class="info-label">Phone:</span>
                        <span class="info-value"></span>
                        <button type="button" class="edit-info-button">Edit</button>
                    </div>
                </div>
            </div>
        </div>
        <br><br><br>
        <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">Save changes</button>
            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
    </div>
</div>
</div>
<style>
    .modal-body {
        padding: 20px;
        position: relative;
    }

    .profile-label,
    .cover-label,
    .bio-label {
        font-weight: bold;
        font-size: 16px;
    }

    .edit-button,
    .edit-button-cover,
    .edit-bio-button,
    .edit-info-button {
        position: absolute;
        right: 20px;
    }

    .profile-picture {
        width: 150px;
        height: 150px;
        border-radius: 50%;
        object-fit: cover;
        margin-top: 10px;
    }

    .cover-photo {
        width: 100%;
        height: 200px;
        border-radius: 10px;
        object-fit: cover;
        margin-top: 10px;
    }

    .bio-section {
        margin-top: 50px;
    }

    .bio-content {
        font-size: 14px;
        color: #333;
        text-align: left;
        margin: 50px;
    }

    .customize-info {
        margin-top: 30px;
    }

    .customize-info h4 {
        font-weight: bold;
        font-size: 18px;
        color: #333;
        margin-bottom: 20px;
    }

    .info-item {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 15px;
    }

    .info-label {
        font-weight: bold;
        font-size: 16px;
    }

    .info-value {
        font-size: 16px;
        margin-right: 10px;
    }

    .edit-info-button {
        font-size: 14px;
        cursor: pointer;
    }
</style>
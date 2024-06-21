<?php include 'includes/session.php'; ?>
<?php include 'includes/header.php'; ?>
<?php
require_once 'includes/firebaseRDB.php';

// Your Firebase Realtime Database URL
$databaseURL = "https://mccnians-bc4f4-default-rtdb.firebaseio.com/";

// Create an instance of the firebaseRDB class
$firebase = new firebaseRDB($databaseURL);

// Fetch gallery data from Firebase
$galleryData = $firebase->retrieve("gallery");

// Decode JSON data into associative arrays
$galleries = json_decode($galleryData, true) ?: [];
?>

<body class="hold-transition skin-blue sidebar-mini">
    <div class="wrapper">

        <?php include 'includes/navbar.php'; ?>
        <?php include 'includes/menubar.php'; ?>

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <!-- Content Header (Page header) -->
            <section class="content-header box-header-background">
                <h1>
                    Content <i class="fa fa-angle-right"></i> Gallery
                </h1>
                <div class="box-inline ">

                    <a href="#addnew" data-toggle="modal" class="btn-add-class btn btn-primary btn-sm btn-flat"><i
                            class="fa fa-plus-circle"></i>&nbsp;&nbsp; New</a>

                    <div class="search-container">
                        <input type="text" class="search-input" id="search-input" placeholder="Search...">
                        <button class="search-button" onclick="filterDivs()">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round" class="feather feather-search">
                                <circle cx="11" cy="11" r="8"></circle>
                                <line x1="21" y1="21" x2="16.65" y2="16.65"></line>
                            </svg>
                        </button>
                    </div>
                </div>

                <ol class="breadcrumb">
                    <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
                    <li>Content</li>
                    <li class="active">Gallery</li>
                </ol>
            </section>
            <!-- Main content -->
            <section class="content">
                <?php
                if (isset($_SESSION['error'])) {
                    echo "
            <div class='alert alert-danger alert-dismissible'>
              <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
              <h4><i class='icon fa fa-warning'></i> Error!</h4>
              " . $_SESSION['error'] . "
            </div>
          ";
                    unset($_SESSION['error']);
                }
                if (isset($_SESSION['success'])) {
                    echo "
            <div class='alert alert-success alert-dismissible'>
              <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
              <h4><i class='icon fa fa-check'></i> Success!</h4>
              " . $_SESSION['success'] . "
            </div>
          ";
                    unset($_SESSION['success']);
                }
                ?>
                <div class="row">
                    <div class="col-xs-12">
                        <div class="box" style="min-height:20px">
                            <div class="box-header with-border">
                                <!-- Any header content you might want to add -->
                            </div>
                            <div class="box-body" style="padding:30px">
                                <div class="album">
                                    <?php foreach ($galleries as $id => $gallery): ?>
                                        <?php if (isset($gallery['gallery_name'], $gallery['image_url'])): ?>
                                            <div class="album-item">
                                                <div class="album-box"
                                                    style="background-image: url('<?php echo htmlspecialchars($gallery['image_url']); ?>'); background-size: cover; background-position: center;">
                                                    <div class="circle"
                                                        onclick="toggleDropdown(event, 'album<?php echo $id; ?>')">
                                                        <svg viewBox="0 0 24 24" width="16" height="16">
                                                            <path d="M3 6h18M3 12h18M3 18h18" stroke="currentColor"
                                                                stroke-width="2" stroke-linecap="round" />
                                                        </svg>
                                                    </div>
                                                    <div class="dropdown-menu" id="album<?php echo $id; ?>">

                                                        <div class="dropdown-item open-modal"
                                                            data-id="<?php echo htmlspecialchars($id); ?>"
                                                            onclick="event.stopPropagation(); openEditModal('<?php echo $id; ?>')">
                                                            <svg viewBox="0 0 24 24" width="16" height="16" fill="none"
                                                                stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                                                stroke-linejoin="round">
                                                                <path d="M12 20h9" />
                                                                <path
                                                                    d="M16.5 3.5a2.121 2.121 0 113 3L7 19l-4 1 1-4L16.5 3.5z" />
                                                            </svg>
                                                            Change Cover
                                                        </div>
                                                        <div class="dropdown-item open-delete"
                                                            data-id="<?php echo htmlspecialchars($id); ?>"
                                                            onclick="event.stopPropagation(); openDeleteModal('<?php echo $id; ?>')">
                                                            <svg viewBox="0 0 24 24" width="16" height="16" fill="none"
                                                                stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                                                stroke-linejoin="round">
                                                                <path d="M3 6h18M3 6l1 16H2l1-16zM8 6v12M16 6v12" />
                                                            </svg>
                                                            Delete
                                                        </div>
                                                    </div>
                                                    <div class="overlay" style="background-color: rgba(0, 0, 0, 0.5);">
                                                        <a href="gallery_view.php?id=<?php echo urlencode($id); ?>"
                                                            class='btn btn-default btn-class'
                                                            style="opacity: 1; background:linear-gradient(to right, #90caf9, #047edf 99%); color:white; width: 100px; border: none;">View
                                                            Album</a>
                                                    </div>
                                                </div>
                                                <div class="album-title">
                                                    <?php echo htmlspecialchars($gallery['gallery_name']); ?>
                                                </div>
                                            </div>
                                        <?php endif; ?>
                                    <?php endforeach; ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Delete Modal -->


                <!-- Delete Modal -->



            </section>
        </div>

        <?php include 'includes/footer.php'; ?>
        <?php include 'includes/album_modal.php'; ?>
    </div>
    <?php include 'includes/scripts.php'; ?>

</body>

</html>
<script>
    $(document).ready(function () {
        // Function to fetch content from the server
        function fetcheventData(id, successCallback, errorCallback) {
            $.ajax({
                url: 'gallery_row.php',
                type: 'GET',
                data: { id: id },
                dataType: 'json',
                success: successCallback,
                error: errorCallback
            });
        }

        // Open edit modal when edit button is clicked
        $('.open-modal').click(function () {
            var id = $(this).data('id');

            // Fetch event data via AJAX
            fetcheventData(id, function (response) {
                $('#editId').val(id);
                $('#edit_album_name').val(response.gallery_name);
                $('#edit_album_image_url').val(response.image_url);
                // Display the fetched image in the edit modal
                if (response.image_url) {
                    $('#edit_album_image').attr('src', response.image_url);
                    $('#edit_album_image').css('display', 'block'); // Ensure the image is displayed
                } else {
                    $('#edit_album_image').attr('src', ''); // Clear the image src if no image URL is returned
                    $('#edit_album_image').css('display', 'none'); // Hide the image if no image URL is returned
                }

                // Show the edit modal after setting the form fields
                $('#editModal').modal('show');

            }, function (xhr, status, error) {
                console.error('AJAX Error: ' + status + ' ' + error);
            });
        });

        // Open delete modal when delete button is clicked
        $('.open-delete').click(function () {
            var id = $(this).data('id');
            $('#deleteAlbumId').val(id);
            $('#deleteModal').modal('show');
        });

        // Confirm delete
        $('.btn-confirm-delete').click(function () {
            var id = $('#deleteAlbumId').val();
            $.ajax({
                url: 'gallery_delete.php',
                type: 'POST',
                data: { id: id },
                success: function () {
                    $('#deleteModal').modal('hide');
                    location.reload(); // Reload the page to see the changes
                },
                error: function (xhr, status, error) {
                    $('#deleteModal').modal('hide');
                    // Display session error message if any
                    var errorMessage = xhr.status === 400 ? 'ID is required.' :
                        xhr.status === 500 ? 'Failed to delete gallery data in Firebase.' :
                            'Invalid request method.';
                    console.error('AJAX Error: ' + errorMessage);
                    $('#errorMessage').text(errorMessage).show();
                }
            });
        });
    });







    function toggleDropdown(event, dropdownId) {
        event.stopPropagation();
        const dropdown = document.getElementById(dropdownId);
        const otherDropdowns = document.querySelectorAll('.dropdown-menu');

        // Hide all other dropdowns except the one clicked
        otherDropdowns.forEach(dropdown => {
            if (dropdown.id !== dropdownId) {
                dropdown.style.display = 'none';
            }
        });

        // Toggle the display of the clicked dropdown
        dropdown.style.display = dropdown.style.display === 'block' ? 'none' : 'block';
    }

    document.addEventListener('click', () => {
        const dropdowns = document.querySelectorAll('.dropdown-menu');
        dropdowns.forEach(dropdown => {
            dropdown.style.display = 'none';
        });
    });


</script>
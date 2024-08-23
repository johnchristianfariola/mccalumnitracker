<?php include '../includes/session.php'; ?>

<!doctype html>
<html class="no-js" lang="">

<head>
    <?php include 'includes/header.php'; ?>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="css/jquery.fancybox.css">

    <?php
    require_once '../includes/firebaseRDB.php';
    require_once '../includes/config.php';

    $firebase = new firebaseRDB($databaseURL);

    // Retrieve the gallery_id from the query string
    $gallery_id = $_GET['gallery_id'];

    // Retrieve the gallery data from the "gallery" node
    $gallery_data = $firebase->retrieve("gallery/" . $gallery_id);
    $gallery_data = json_decode($gallery_data, true);

    // Retrieve the gallery view data from the "gallery_view" node
    $gallery_view_data = $firebase->retrieve("gallery_view");
    $gallery_view_data = json_decode($gallery_view_data, true);

    // Filter the gallery view data to only include the items with the current gallery_id
    $filtered_gallery_view_data = array_filter($gallery_view_data, function($item) use ($gallery_id) {
        return $item['gallery_id'] == $gallery_id;
    });
    ?>

</head>

<body>
    <!-- Start Header Top Area -->
    <?php include 'includes/navbar.php'; ?>
    <!-- End Header Top Area -->
    <!-- Mobile Menu start -->
 
    <!-- Mobile Menu end -->
    <!-- Main Menu area start-->


    <?php include 'includes/forum_modal.php'; ?>

    <div class="main-content" style="margin-top:30px;  margin-bottom:30px">
        <div class="sale-statistic-area">
            <div class="container">
                <div class="full_container">
                    <div class="inner_container">
                        <!-- Gallery View Content -->
                        <div class="midde_cont">
                            <div class="container-fluid">
                                <div class="row column4 graph">
                                    <div class="col-md-12">
                                        <div class="white_shd full margin_bottom_30">
                                            <div class="full graph_head">
                                                <div class="heading1 margin_0">
                                                    <h2><i class="fa fa-image"></i> <?php echo $gallery_data['gallery_name']; ?></h2>
                                                </div>
                                            </div>
                                            <div class="full gallery_section_inner">
                                                <div class="row">
                                                    <?php
                                                    foreach ($filtered_gallery_view_data as $gallery_view_item) {
                                                        ?>
                                                        <div class="col-sm-4 col-md-3 margin_bottom_30">
                                                            <div class="column">
                                                                <a data-fancybox="gallery" href="../admin/<?php echo $gallery_view_item['image_url']; ?>">
                                                                    <img class="img-responsive" src="../admin/<?php echo $gallery_view_item['image_url']; ?>" alt="Gallery Image" />
                                                                </a>
                                                            </div>
                                                            <div class="heading_section">
                                                                <h4 title="<?php echo basename($gallery_view_item['image_url']); ?>"><?php echo basename($gallery_view_item['image_url']); ?></h4>
                                                            </div>
                                                        </div>
                                                        <?php
                                                    }
                                                    ?>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Scripts -->
    <script src="js/vendor/jquery-1.12.4.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/plugins.js"></script>
    <script src="js/jquery.fancybox.js"></script>
    <script src="js/main.js"></script>
    <script src="../bower_components/ckeditor/ckeditor.js"></script>
</body>

</html>
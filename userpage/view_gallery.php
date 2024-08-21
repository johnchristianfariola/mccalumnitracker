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

    $album_data = $firebase->retrieve("gallery");
    $album_data = json_decode($album_data, true);


    ?>

    <style>
        /* Modernized Gallery Section */
        .gallery_section_inner {
            padding: 20px;
            background-color: white;
        }

        .gallery_section_inner .column {
            position: relative;
            overflow: hidden;
            border-radius: 8px;
            background: #fff;
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .gallery_section_inner .column:hover {
            transform: scale(1.05);
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.2);
        }

        .gallery_section_inner img {
            width: 100%;
            height: 200px;
            /* Set a fixed height */
            object-fit: cover;
            /* Ensure images are scaled and cropped to fit */
            display: block;
            border-bottom: 2px solid #ddd;
        }

        .heading_section {
            padding: 10px;
            background: #1ed085;
            color: #fff;
            text-align: center;
            font-size: 16px;
            border-radius: 0 0 8px 8px;
            margin-bottom: 20px;
        }

        .heading_section h4 {
            margin: 0;
            font-weight: 400;
        }

        .container-fluid {
            padding: 0 15px;
        }

        @media screen (max-width: 767px) {
            .gallery_section_inner {
                padding: 10px;
            }

            .heading_section {
                font-size: 14px;
            }
        }

        .white_shd {
            background: #fff;
            border-radius: 8px;
            box-shadow: 2px 2px 5px rgba(0, 0, 0, 0.3);
            overflow: hidden;
        }

        .graph_head {
            padding: 15px;
            border-bottom: 1px solid #ddd;
        }

        .heading1 h2 {
            margin: 0;
            font-size: 24px;
            font-weight: 600;
        }
    </style>

</head>

<body>
    <!--[if lt IE 8]>
        <p class="browserupgrade">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> to improve your experience.</p>
    <![endif]-->
    <!-- Start Header Top Area -->
    <?php include 'includes/navbar.php'; ?>
    <!-- End Header Top Area -->
    <!-- Mobile Menu start -->
    <?php include 'includes/mobile_view.php'; ?>
    <!-- Mobile Menu end -->
    <!-- Main Menu area start-->
    <?php include 'includes/main_menu.php'; ?>

    <?php include 'includes/forum_modal.php'; ?>

    <div class="main-content" style="margin-top:30px;  margin-bottom:30px">
        <div class="sale-statistic-area">
            <div class="container">
                <div class="full_container">
                    <div class="inner_container">
                        <!-- Media Gallery Content -->
                        <div class="midde_cont">
                            <div class="container-fluid">
                                <!-- Gallery section -->
                                <div class="row column4 graph">
                                    <div class="col-md-12">
                                        <div class="white_shd full margin_bottom_30">
                                            <div class="full graph_head">
                                                <div class="heading1 margin_0">
                                                    <h2> <i class="fa fa-image"></i> Media Gallery</h2>
                                                </div>
                                            </div>
                                            <div class="full gallery_section_inner">
                                                <div class="row">
                                                    <?php
                                                    if (!empty($album_data)) {
                                                        foreach ($album_data as $gallery_id => $gallery) {
                                                            ?>
                                                            <div class="col-sm-4 col-md-3 margin_bottom_30">
                                                                <div class="column">
                                                                    <a href="">
                                                                        <img class="img-responsive"
                                                                            src="../admin/<?php echo $gallery['image_url']; ?>"
                                                                            alt="Gallery Image" />
                                                                    </a>
                                                                </div>
                                                                <div class="heading_section">
                                                                    <h4><?php echo $gallery['gallery_name']; ?></h4>
                                                                </div>
                                                            </div>
                                                            <?php
                                                        }
                                                    } else {
                                                        echo "No galleries found.";
                                                    }
                                                    ?>
                                                </div>
                                                <!-- Add more gallery items as needed -->
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- End Gallery section -->
                            </div>
                        </div>
                        <!-- end content -->
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
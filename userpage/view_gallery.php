<?php include '../includes/session.php'; ?>
<!doctype html>
<html class="no-js" lang="">

<head>
    <?php include 'includes/header.php' ?>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="css/jquery.fancybox.css">
    <style>
        /*------------------------------------------------------------------
    17. Gallery Section   
-------------------------------------------------------------------*/

        .gallery_section_inner .column {
            background: #fff;
            box-shadow: 0 0 13px -10px #000;
            overflow: hidden;
        }

        .heading_section {
            border-top: solid #1ed085 2px;
            background: #15283c;
        }

        .heading_section h4 {
            color: #fff;
            margin: 0;
            font-weight: 200;
            text-align: center;
            padding: 16px 0 16px;
            font-size: 15px;
        }

        .margin_bottom_30 {
            margin-bottom: 30px;
        }
    </style>
</head>

<body>
    <!--[if lt IE 8]>
        <p class="browserupgrade">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> to improve your experience.</p>
    <![endif]-->
    <!-- Start Header Top Area -->
    <?php include 'includes/navbar.php' ?>
    <!-- End Header Top Area -->
    <!-- Mobile Menu start -->
    <?php include 'includes/mobile_view.php' ?>
    <!-- Mobile Menu end -->
    <!-- Main Menu area start-->
    <?php include 'includes/main_menu.php' ?>

    <?php include 'includes/forum_modal.php' ?>

    <div class="main-content" style="margin-top:30px;">
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
                                                    <h2>Media Gallery </h2>
                                                </div>
                                            </div>
                                            <div class="full gallery_section_inner padding_infor_info">
                                                <div class="row">
                                                    <div class="col-sm-4 col-md-3 margin_bottom_30">
                                                        <div class="column">
                                                            <a data-fancybox="gallery" href="img/g1.jpg"><img
                                                                    class="img-responsive" src="img/g1.jpg"
                                                                    alt="#" /></a>
                                                        </div>
                                                        <div class="heading_section">
                                                            <h4>Sed ut perspiciatis</h4>
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-4 col-md-3 margin_bottom_30">
                                                        <div class="column">
                                                            <a data-fancybox="gallery" href="img/g1.jpg"><img
                                                                    class="img-responsive" src="img/g1.jpg"
                                                                    alt="#" /></a>
                                                        </div>
                                                        <div class="heading_section">
                                                            <h4>Sed ut perspiciatis</h4>
                                                        </div>
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
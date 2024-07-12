<?php include '../includes/session.php'; ?>
<style>
    
</style>

<!doctype html>
<html class="no-js" lang="">

<head>
    <?php include 'includes/header.php' ?>
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


    <?php
    // Include Firebase database handling class
    require_once '../includes/firebaseRDB.php';

    // Initialize Firebase URL
    $databaseURL = "https://mccnians-bc4f4-default-rtdb.firebaseio.com";
    $firebase = new firebaseRDB($databaseURL);

    // Get the news ID from the URL
    if (isset($_GET['id'])) {
        $news_id = $_GET['id'];

        // Retrieve the specific news item using the ID
        $news_data = $firebase->retrieve("event/{$news_id}");
        $news_data = json_decode($news_data, true);

        $adminData = $firebase->retrieve("admin/admin");
        $adminData = json_decode($adminData, true);

        // Extract admin profile image URL
        $admin_image_url = $adminData['image_url'];
        $adminFirstName = $adminData['firstname'];
        $adminLastName = $adminData['lastname'];

        if ($news_data) {
            // Display news details
            $image_url = htmlspecialchars($news_data['image_url']);
            $event_author = htmlspecialchars($news_data['event_author']);
            $event_created = htmlspecialchars($news_data['event_created']);
            // Ensure HTML content in event_description is displayed correctly
            $event_description = $news_data['event_description'];
            $event_title = htmlspecialchars($news_data['event_title']);
            $event_date = htmlspecialchars($news_data['event_date']);
            $event_venue = htmlspecialchars($news_data['event_venue']);

            ?>

            <div class="breadcomb-area wow fadeInUp" data-wow-delay="0.1">
                <div class="container">
                    <div class="row">
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <div class="breadcomb-list">
                                <div class="row">
                                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                        <div class="breadcomb-wp">
                                            <div class="breadcomb-icon">
                                                <img class="profile" src="../admin/<?php echo $admin_image_url; ?>" alt="">
                                            </div>
                                            <div class="breadcomb-ctn">
                                                <h2><?php echo $event_title; ?></h2>
                                                <div class="visited-content">
                                                    <i class="uploader">Posted by: <?php echo $adminFirstName . ' ' . $adminLastName; ?></i>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                    <p class="date-uploaded"><b>Event Date: <?php echo $event_date; ?></b> </p>
                                        <p class="date-uploaded">Date Posted: <?php echo $event_created; ?></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div style="background:white; padding: 20px 190px 20px 20px; text-align: justify;">
                    <p><b>Event Venue: <?php echo $event_venue; ?></b></p>

                        <?php echo $event_description; ?>
                    </div>
                    <div class="background">
                        <img style="width:100%; height: 500px; object-fit: cover;" src="../admin/<?php echo $image_url; ?>"
                            alt="">
                    </div>
                </div>
            </div>

            <?php
        } else {
            echo "News item not found.";
        }
    } else {
        echo "No news ID provided.";
    }
    ?>




    <!-- Start Footer area-->

    <!-- End Footer area-->
    <!-- jquery
        ============================================ -->
    <script src="js/vendor/jquery-1.12.4.min.js"></script>
    <!-- bootstrap JS
        ============================================ -->
    <script src="js/bootstrap.min.js"></script>
    <!-- wow JS
        ============================================ -->
    <script src="js/wow.min.js"></script>
    <!-- price-slider JS
        ============================================ -->
    <script src="js/jquery-price-slider.js"></script>
    <!-- owl.carousel JS
        ============================================ -->
    <script src="js/owl.carousel.min.js"></script>
    <!-- scrollUp JS
        ============================================ -->
    <script src="js/jquery.scrollUp.min.js"></script>
    <!-- meanmenu JS
        ============================================ -->
    <script src="js/meanmenu/jquery.meanmenu.js"></script>
    <!-- counterup JS
        ============================================ -->
    <script src="js/counterup/jquery.counterup.min.js"></script>
    <script src="js/counterup/waypoints.min.js"></script>
    <script src="js/counterup/counterup-active.js"></script>
    <!-- mCustomScrollbar JS
        ============================================ -->
    <script src="js/scrollbar/jquery.mCustomScrollbar.concat.min.js"></script>
    <!-- jvectormap JS
        ============================================ -->
    <script src="js/jvectormap/jquery-jvectormap-2.0.2.min.js"></script>
    <script src="js/jvectormap/jquery-jvectormap-world-mill-en.js"></script>
    <script src="js/jvectormap/jvectormap-active.js"></script>
    <!-- sparkline JS
        ============================================ -->
    <script src="js/sparkline/jquery.sparkline.min.js"></script>
    <script src="js/sparkline/sparkline-active.js"></script>
    <!-- sparkline JS
        ============================================ -->
    <script src="js/flot/jquery.flot.js"></script>
    <script src="js/flot/jquery.flot.resize.js"></script>
    <script src="js/flot/curvedLines.js"></script>
    <script src="js/flot/flot-active.js"></script>
    <!-- knob JS
        ============================================ -->
    <script src="js/knob/jquery.knob.js"></script>
    <script src="js/knob/jquery.appear.js"></script>
    <script src="js/knob/knob-active.js"></script>
    <!--  wave JS
        ============================================ -->
    <script src="js/wave/waves.min.js"></script>
    <script src="js/wave/wave-active.js"></script>
    <!--  todo JS
        ============================================ -->
    <script src="js/todo/jquery.todo.js"></script>
    <!-- plugins JS
        ============================================ -->
    <script src="js/plugins.js"></script>
    <!--  Chat JS
        ============================================ -->
    <script src="js/chat/moment.min.js"></script>
    <script src="js/chat/jquery.chat.js"></script>
    <!-- main JS
        ============================================ -->
    <script src="js/main.js"></script>
    <!-- tawk chat JS
        ============================================ -->
    <script src="js/tawk-chat.js"></script>
    <!--Dialog JS ============================================ -->
    <script src="js/dialog/sweetalert2.min.js"></script>
    <script src="js/dialog/dialog-active.js"></script>
    <!--  Custom JS-->
    <script>
        $('#log').on('click', function () {
            swal({
                title: "Are you sure?",
                text: "You will be directed to the main page!",
                type: "warning",
                showCancelButton: true,
                confirmButtonText: "Yes, Logout!",
                cancelButtonText: "No, cancel!",
            }).then(function (isConfirm) {
                if (isConfirm) {
                    swal("Logout!", "Logging out", "success").then(function () {
                        window.location.href = '../logout.php';
                    });
                } else {
                    swal("Cancelled", "Your Logout is Cancelled :)", "error");
                }
            });
        });

    </script>



</body>

</html>
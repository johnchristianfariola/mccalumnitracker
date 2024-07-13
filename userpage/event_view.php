<?php include '../includes/session.php'; ?>


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


    <div class="container-xxl py-5" style="margin-top:50px; margin-bottom:90px">
        <div class="container">
            <div class="text-center wow fadeInUp" data-wow-delay="0.1s">

                <h1 class="mb-5">EVENT</h1>
            </div>
            <?php
            require_once '../includes/firebaseRDB.php';

            require_once '../includes/config.php'; // Include your config file
            $firebase = new firebaseRDB($databaseURL);

            $data = $firebase->retrieve("event");
            $data = json_decode($data, true);

            foreach ($data as $eventID => $event) {
                $eventTitle = $event['event_title'];
                $eventDate = $event['event_date'];
                $eventDescription = $event['event_description'];
                $imageUrl = $event['image_url'];
                ?>

                <div class="col-lg-4 col-md-6 wow fadeInUp" data-wow-delay="0.1s">
                    <div class="item">
                        <center>
                            <a href="visit_event.php?id=<?php echo $eventID; ?>" class="probootstrap-featured-news-box">
                                <figure class="probootstrap-media">
                                    <img src="../admin/<?php echo $imageUrl; ?>" alt="Event Image" class="img-responsive">
                                </figure>
                                <div class="probootstrap-text">
                                    <h3><?php echo $eventTitle; ?></h3>
                                    <div class="description"><?php echo $eventDescription; ?></div>
                                    <div class="probootstrap-date">
                                        <i class="icon-calendar"></i><?php echo $eventDate; ?>
                                    </div>
                                </div>
                            </a>
                        </center>
                    </div>
                </div>

                <?php
            }
            ?>





        </div>
    </div>



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
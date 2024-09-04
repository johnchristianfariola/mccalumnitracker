<?php include '../includes/session.php'; ?>

<?php

// If the user is not logged in, redirect to the main index page
if (!isset($_SESSION['alumni'])) {
    header('location: ../index.php');
    exit();
}

// If forms_completed is false, redirect to the alumni profile page
if (isset($_SESSION['forms_completed']) && $_SESSION['forms_completed'] == false) {
    header('location: alumni_profile.php');
    exit();
}

?>
<!doctype html>
<html class="no-js" lang="">

<head>
    <?php include 'includes/header.php' ?>
    <?php
    require_once '../includes/firebaseRDB.php';
    require_once '../includes/config.php';

    $firebase = new firebaseRDB($databaseURL);

    function sortByDate($a, $b)
    {
        $dateA = strtotime($a['news_created']);
        $dateB = strtotime($b['news_created']);
        return $dateB - $dateA;
    }

    // Retrieve admin data
    $adminData = $firebase->retrieve("admin");
    $adminData = json_decode($adminData, true);

    // Fetch all messages once from Firebase
    $messages = json_decode($firebase->retrieve("messages"), true);

    // Convert messages array to JSON for JavaScript
    $messages_json = json_encode($messages);

    // Extract admin profile image URL
    $admin_image_url = $adminData['image_url'];
    $admin_firstname = $adminData['firstname'];
    $admin_lastmame = $adminData['lastname'];

    // Retrieve news data
    $data = $firebase->retrieve("news");
    $data = json_decode($data, true);

    if (is_array($data)) {
        usort($data, 'sortByDate');
    }

    // Retrieve event data
    $eventData = $firebase->retrieve("event");
    $eventData = json_decode($eventData, true);

    // Retrieve job data
    $jobData = $firebase->retrieve("job");
    $jobData = json_decode($jobData, true);

    function sortByDateJob($a, $b)
    {
        $dateA = strtotime($a['job_created']);
        $dateB = strtotime($b['job_created']);
        return $dateB - $dateA;
    }

    if (is_array($jobData)) {
        usort($jobData, 'sortByDateJob');
    }
    ?>

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


    <!-- End Sale Statistic area-->
    <div class="main-content">
        <div class="sale-statistic-area">
            <div class="container">
                <div class="row">
                    <div class="col-lg-8 col-md-8 col-sm-7 col-xs-12">
                        <?php foreach ($data as $id => $news) { ?>
                            <div class="sale-statistic-inner notika-shadow mg-tb-30" style="border-radius: 1rem">
                                <div class="curved-inner-pro">
                                    <div class="curved-ctn">
                                        <div class="image-section">
                                            <img class="profile" src="../admin/<?php echo $admin_image_url; ?>"
                                                alt="news image"
                                                onerror="if (this.src != 'uploads/profile.jpg') this.src = 'uploads/profile.jpg';">
                                        </div>
                                        <div class="info-section">
                                            <h2><?php echo $admin_firstname . ' ' . $admin_lastmame; ?></h2>
                                            <span><?php echo $news['news_created']; ?></span>
                                        </div>
                                    </div>
                                </div>
                                <div class="content">
                                    <h1><?php echo $news['news_title']; ?></h1>
                                    <p class="news-description">
                                        <?php echo nl2br(preg_replace('/\n{2,}/', '<br><br>', strip_tags($news['news_description']))); ?>
                                    </p>
                                    <button class="toggle-button">Show More...</button>
                                </div>
                                <img style="border-radius: 1rem" src="../admin/<?php echo $news['image_url']; ?>"
                                    class="news_post" alt="news image">
                            </div>
                        <?php } ?>
                    </div>
                    <div class="col-lg-4 col-md-4 col-sm-5 col-xs-12">
                        <div class="right-section">
                            <div class="notika-shadow mg-tb-30 sm-res-mg-t-0 full-height wow fadeInRight"
                                data-wow-delay="0.2s">

                                <?php foreach ($eventData as $id => $event) { ?>
                                    <div class="card">
                                        <img src="../admin/<?php echo $event['image_url']; ?>" alt="Event Image"
                                            class="event_image">
                                        <div class="card-content">
                                            <hr>
                                            <div class="card-title"><?php echo $event['event_title']; ?></div>
                                            <div class="card-date">Posted on <?php echo $event['event_created']; ?></div>
                                            <a href="visit_event.php?id=<?php echo $id; ?>"
                                                class="btn btn-default btn-icon-notika waves-effect"><i
                                                    class="notika-icon notika-menu"> More</i></a>
                                        </div>
                                    </div>

                                <?php } ?>
                            </div>
                            <a href="event_view.php" class="btn btn-primary btn-icon-notika waves-effect">Show More</a>

                            <div class="job-section" style="margin-top:60px">
                                <h3><i class="fa fa-briefcase"></i> Active Job Post</h3>
                                <?php foreach ($jobData as $id => $job) { ?>
                                    <?php if (isset($job['status']) && $job['status'] == 'Active') { ?>
                                        <div class="notika-shadow mg-tb-30 sm-res-mg-t-0 full-height wow fadeInRight"
                                            data-wow-delay="0.3">
                                            <div class="card">
                                                <div class="card-content">
                                                    <div class="job-container">
                                                        <div class="job-title"><?php echo $job['job_title']; ?></div>
                                                        <div class="job-timesced"
                                                            style="background-color: <?php echo ($job['work_time'] == 'Full-Time') ? 'rgb(255, 105, 105)' : 'gold'; ?>; color: <?php echo ($job['work_time'] == 'Full-Time') ? 'white' : 'black'; ?>;">
                                                            <?php echo $job['work_time']; ?>
                                                        </div>
                                                    </div>
                                                    <hr>
                                                    <div class="card-date"><?php echo $job['company_name']; ?></div>
                                                    <div class="card-date">Posted on <?php echo $job['job_created']; ?></div>
                                                </div>
                                            </div>
                                        </div>
                                    <?php } ?>
                                <?php } ?>
                            </div>

                            <div class="forum-section" style="margin-top:60px">
                                <h3><i class="fa fa-wechat"></i> Forum</h3>
                                <div class="notika-shadow mg-tb-30 sm-res-mg-t-0 full-height wow fadeInRight"
                                    data-wow-delay="0.3">
                                    <div class="card">
                                        <div class="card-content">
                                            <a href=""><i class="fa fa-info-circle"></i>&nbsp;&nbsp;Forum Link</a>
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

    <?php include 'global_chatbox.php'?>


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
        ============================================ 
       <!-- <script src="js/tawk-chat.js"></script> -->
-->
    <!--Dialog JS ============================================ -->
    <script src="js/dialog/sweetalert2.min.js"></script>
    <script src="js/dialog/dialog-active.js"></script>

    <!--  Custom JS-->
    <script>
        $('#logoutBtn').on('click', function () {
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

        document.addEventListener("DOMContentLoaded", function () {
            const toggleButtons = document.querySelectorAll(".toggle-button");

            toggleButtons.forEach(button => {
                button.addEventListener("click", function () {
                    const description = this.previousElementSibling;
                    if (description.classList.contains("expanded")) {
                        description.classList.remove("expanded");
                        this.textContent = "Show More...";
                    } else {
                        description.classList.add("expanded");
                        this.textContent = "Show Less";
                    }
                });

                // Check if description needs expanding
                const description = button.previousElementSibling;
                if (description.scrollHeight > description.clientHeight) {
                    button.style.display = "block";
                } else {
                    button.style.display = "none";
                }
            });
        });
    </script>




</body>

</html>
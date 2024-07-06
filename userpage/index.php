<?php include '../includes/session.php'; ?>

<?php

// If the user is not logged in, redirect to the main index page
if (!isset($_SESSION['alumni'])) {
    header('location: ../index.php');
    exit();
}

?>
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

    <!-- End Sale Statistic area-->

        <div class="sale-statistic-area">
        <div class="container">
            <div class="row">
                <div class="col-lg-8 col-md-8 col-sm-7 col-xs-12">
                    <?php
                    require_once '../includes/firebaseRDB.php';

                    $databaseURL = "https://mccnians-bc4f4-default-rtdb.firebaseio.com";
                    $firebase = new firebaseRDB($databaseURL);

                    function sortByDate($a, $b)
                    {
                        $dateA = strtotime($a['news_created']);
                        $dateB = strtotime($b['news_created']);
                        return $dateB - $dateA;
                    }

                    // Retrieve admin data
                    $adminData = $firebase->retrieve("admin/admin");
                    $adminData = json_decode($adminData, true);

                    // Extract admin profile image URL
                    $admin_image_url = $adminData['image_url'];

                    $data = $firebase->retrieve("news");
                    $data = json_decode($data, true);

                    if (is_array($data)) {
                        usort($data, 'sortByDate'); // 
                        foreach ($data as $id => $news) {
                            // Strip HTML tags from news_description and convert newlines to <br> tags
                            $news_description = nl2br(preg_replace('/\n{2,}/', '<br><br>', strip_tags($news['news_description'])));
                            $news_title = strip_tags($news['news_title']);
                            $news_author = strip_tags($news['news_author']);
                            $news_created = strip_tags($news['news_created']);
                            $image_url = strip_tags($news['image_url']);
                            ?>

                            <div class="sale-statistic-inner notika-shadow mg-tb-30" style="border-radius: 1rem">
                                <div class="curved-inner-pro">
                                    <div class="curved-ctn">
                                        <div class="image-section" >
                                            <img class="profile" src="../admin/<?php echo $admin_image_url; ?>"
                                                alt="news image">
                                        </div>
                                        <div class="info-section">
                                            <h2><?php echo $news_author; ?></h2>
                                            <i><?php echo $news_created; ?></i>
                                        </div>
                                    </div>
                                </div>
                                <div class="content">
                                    <h1><?php echo $news_title; ?></h1>
                                    <p class="news-description"><?php echo $news_description; ?></p>
                                    <button class="toggle-button">Show More...</button>
                                </div>
                                <img style="border-radius: 1rem" src="../admin/<?php echo $image_url; ?>" class="news_post" alt="news image">
                            </div>

                            <?php
                        }
                    }
                    ?>

                </div>


                <?php

                $data = $firebase->retrieve("event");
                $data = json_decode($data, true);

                if (is_array($data)) {
                    
                    foreach ($data as $id => $event) {
                        // Retrieve and sanitize event data
                        $eventTitle = htmlspecialchars($event['event_title']);
                        $eventDate = htmlspecialchars($event['event_created']);
                        $eventDescription = strip_tags($event['event_description']); // Strip HTML tags
                        $eventImage = htmlspecialchars($event['image_url']);

                        echo '
                        <div class="col-lg-4 col-md-4 col-sm-5 col-xs-12">
                            <div class="notika-shadow mg-tb-30 sm-res-mg-t-0 full-height wow fadeInRight" data-wow-delay="0.2s">
                                <div class="card">
                                    <img src="../admin/' . $eventImage . '" alt="Event Image" class="event_image">
                                    <div class="card-content">
                                        <hr>
                                        <div class="card-title">' . $eventTitle . '</div>
                                        <div class="card-date">Posted on ' . $eventDate . '</div>
                                       
                                        <div class="btn btn-default btn-icon-notika waves-effect"><i class="notika-icon notika-menu">More</i></div>
                                    </div>
                                </div>
                            </div>
                            
                        </div>
                        ';
                    }
                }
                ?>

                <div class="col-lg-4 col-md-4 col-sm-5 col-xs-12" style="margin-top:60px">
                    <h3><i class="fa fa-briefcase"></i> Active Job Post</h3>
                    <?php


                    $data = $firebase->retrieve("job");
                    $data = json_decode($data, true);

                    function sortByDateJob($a, $b)
                    {
                        $dateA = strtotime($a['job_created']);
                        $dateB = strtotime($b['job_created']);
                        return $dateB - $dateA;
                    }

                    if (is_array($data)) {
                        usort($data, 'sortByDateJob'); // 
                        foreach ($data as $id => $job) {
                            // Check if status is Active
                            if (isset($job['status']) && $job['status'] == 'Active') {
                                // Ensure that all required fields are available and strip HTML tags
                                $jobTitle = isset($job['job_title']) ? strip_tags($job['job_title']) : 'N/A';
                                $workTime = isset($job['work_time']) ? strip_tags($job['work_time']) : 'N/A';
                                $company = isset($job['company_name']) ? strip_tags($job['company_name']) : 'N/A';
                                $jobDate = isset($job['job_created']) ? strip_tags($job['job_created']) : 'N/A';

                                // Set background color based on work time
                                $backgroundColor = ($workTime == 'Full-Time') ? 'rgb(255, 105, 105)' : 'gold';
                                $color = ($workTime == 'Full-Time') ? 'white' : 'black';

                                echo '
                    
                        <div class="notika-shadow mg-tb-30 sm-res-mg-t-0 full-height wow fadeInRight" data-wow-delay="0.3">
                            <div class="card">
                                <div class="card-content">
                                    <div class="job-container">
                                        <div class="job-title">' . $jobTitle . '</div>
                                        <div class="job-timesced" style="background-color: ' . $backgroundColor . '; color: ' . $color . ';">' . $workTime . '</div>
                                    </div>
                                    <hr>
                                    <div class="card-date">' . $company . '</div>
                                    <div class="card-date">Posted on ' . $jobDate . '</div>
                                    
                                </div>
                            </div>
                        </div>
                   ';
                            }
                        }
                    }
                    ?>

                    <div class="" style="margin-top:60px">
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
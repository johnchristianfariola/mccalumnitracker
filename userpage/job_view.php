<?php include '../includes/session.php'; ?>

<!doctype html>
<html class="no-js" lang="">

<head>
    <?php include 'includes/header.php' ?>
    <style>
        .breadcomb-area {
            padding: 20px 0;
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 15px;
        }

        .rows {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 20px;
            justify-content: center;
        }

        .card {
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            padding: 20px;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .card:hover {
            transform: translateY(-10px);
            box-shadow: 0 8px 12px rgba(0, 0, 0, 0.2);
        }

        .card h3 {
            margin-top: 0;
            font-size: 1.5em;
            color: #333;
        }

        .card p {
            color: #777;
            line-height: 1.6;
        }
    </style>
</head>

<body>
    <!--[if lt IE 8]>
            <p class="browsserupgrade">You are using an <strong>outdated</strong> browsser. Please <a href="http://browssehappy.com/">upgrade your browsser</a> to improve your experience.</p>
        <![endif]-->
    <!-- Start Header Top Area -->
    <?php include 'includes/navbar.php' ?>
    <!-- End Header Top Area -->
    <!-- Mobile Menu start -->
    <?php include 'includes/mobile_view.php' ?>
    <!-- Mobile Menu end -->
    <!-- Main Menu area start-->
    <?php include 'includes/main_menu.php' ?>

    <!-- News items would be dynamically inserted here -->
    <div class="breadcomb-area wow fadeInUp" data-wow-delay="0.1s">
    <center><h3>ACTIVE JOB</h3></center>

        <div class="container">
            <div class="rows">
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
                    usort($data, 'sortByDateJob');
                    foreach ($data as $id => $job) {
                        if (isset($job['status']) && $job['status'] == 'Active') {
                            $jobTitle = isset($job['job_title']) ? strip_tags($job['job_title']) : 'N/A';
                            $workTime = isset($job['work_time']) ? strip_tags($job['work_time']) : 'N/A';
                            $company = isset($job['company_name']) ? strip_tags($job['company_name']) : 'N/A';
                            $jobDate = isset($job['job_created']) ? strip_tags($job['job_created']) : 'N/A';

                            $backgroundColor = ($workTime == 'Full-Time') ? 'rgb(255, 105, 105)' : 'gold';
                            $color = ($workTime == 'Full-Time') ? 'white' : 'black';

                            echo '
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
                            </div>';
                        }
                    }
                }
                ?>
            </div>
        </div>
    </div>


    <div class="breadcomb-area wow fadeInUp" data-wow-delay="0.1s">
        <center><h3>ARCHIVE JOB</h3></center>
        <div class="container">
            <div class="rows">
                <?php
                $data = $firebase->retrieve("job");
                $data = json_decode($data, true);

                function sortByDatesJob($a, $b)
                {
                    $dateA = strtotime($a['job_created']);
                    $dateB = strtotime($b['job_created']);
                    return $dateB - $dateA;
                }

                if (is_array($data)) {
                    usort($data, 'sortByDatesJob');
                    foreach ($data as $id => $job) {
                        if (isset($job['status']) && $job['status'] == 'Active') {
                            $jobTitle = isset($job['job_title']) ? strip_tags($job['job_title']) : 'N/A';
                            $workTime = isset($job['work_time']) ? strip_tags($job['work_time']) : 'N/A';
                            $company = isset($job['company_name']) ? strip_tags($job['company_name']) : 'N/A';
                            $jobDate = isset($job['job_created']) ? strip_tags($job['job_created']) : 'N/A';

                            $backgroundColor = ($workTime == 'Full-Time') ? 'rgb(255, 105, 105)' : 'gold';
                            $color = ($workTime == 'Full-Time') ? 'white' : 'black';

                            echo '
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
                            </div>';
                        }
                    }
                }
                ?>
            </div>
        </div>
    </div>

    <!-- Start Footer area-->
    <!-- Include your footer HTML here -->
    <!-- End Footer area-->

    <!-- Include your JS files here -->
    <script src="js/vendor/jquery-1.12.4.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/wow.min.js"></script>
    <script src="js/jquery-price-slider.js"></script>
    <script src="js/owl.carousel.min.js"></script>
    <script src="js/jquery.scrollUp.min.js"></script>
    <script src="js/meanmenu/jquery.meanmenu.js"></script>
    <script src="js/counterup/jquery.counterup.min.js"></script>
    <script src="js/counterup/waypoints.min.js"></script>
    <script src="js/counterup/counterup-active.js"></script>
    <script src="js/scrollbar/jquery.mCustomScrollbar.concat.min.js"></script>
    <script src="js/jvectormap/jquery-jvectormap-2.0.2.min.js"></script>
    <script src="js/jvectormap/jquery-jvectormap-world-mill-en.js"></script>
    <script src="js/jvectormap/jvectormap-active.js"></script>
    <script src="js/sparkline/jquery.sparkline.min.js"></script>
    <script src="js/sparkline/sparkline-active.js"></script>
    <script src="js/flot/jquery.flot.js"></script>
    <script src="js/flot/jquery.flot.resize.js"></script>
    <script src="js/flot/curvedLines.js"></script>
    <script src="js/flot/flot-active.js"></script>
    <script src="js/knob/jquery.knob.js"></script>
    <script src="js/knob/jquery.appear.js"></script>
    <script src="js/knob/knob-active.js"></script>
    <script src="js/wave/waves.min.js"></script>
    <script src="js/wave/wave-active.js"></script>
    <script src="js/todo/jquery.todo.js"></script>
    <script src="js/plugins.js"></script>
    <script src="js/chat/moment.min.js"></script>
    <script src="js/chat/jquery.chat.js"></script>
    <script src="js/main.js"></script>
    <script src="js/tawk-chat.js"></script>
    <script src="js/dialog/sweetalert2.min.js"></script>
    <script src="js/dialog/dialog-active.js"></script>
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

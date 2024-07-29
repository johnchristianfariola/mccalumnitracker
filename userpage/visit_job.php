<?php include '../includes/session.php'; ?>
<!doctype html>
<html class="no-js" lang="">

<head>
    <!-- Include header -->
    <?php include 'includes/header.php'; ?>
    <?php
require_once '../includes/firebaseRDB.php';
require_once '../includes/config.php';

$firebase = new firebaseRDB($databaseURL);

// Get the job ID from the URL
$jobId = $_GET['id'] ?? '';

if ($jobId) {
    // Retrieve the specific job data
    $jobData = $firebase->retrieve("job/" . $jobId);
    $job = json_decode($jobData, true);

    if ($job) {
        $jobTitle = $job['job_title'] ?? 'N/A';
        $workTime = $job['work_time'] ?? 'N/A';
        $company = $job['company_name'] ?? 'N/A';
        $jobDescription = $job['job_description'] ?? 'No description available.';
        $image_path = $job['image_path'] ?? 'N/A';

        // Determine background color and text color based on work time
        $backgroundColor = ($workTime == 'Full-Time') ? '#e6f7ff' : '#fff0f5';
        $color = ($workTime == 'Full-Time') ? '#0066cc' : '#cc0066';

        // Create an array to store the job details
        $jobDetails = [
            'title' => $jobTitle,
            'workTime' => $workTime,
            'company' => $company,
            'description' => $jobDescription,
            'imagePath' => $image_path,
            'backgroundColor' => $backgroundColor,
            'color' => $color,
        ];

        // Encode the job details as JSON
        $jobDetailsJson = json_encode($jobDetails);
    } else {
        $jobDetailsJson = null;
    }
} else {
    $jobDetailsJson = null;
}
?>
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

    <!-- Main Menu area start -->
    <?php include 'includes/main_menu.php'; ?>

    <style>
        li {
            list-style: circle;
            margin-left: 20px;
        }
    </style>

    <!-- End Sale Statistic area -->
    <div class="main-content"></div>
    <div class="sale-statistic-area">
        <div class="container">
            <div class="row">
                <div class="col-lg-8 col-md-8 col-sm-7 col-xs-12">
                    <!-- Job Articles -->
                    <div class="sale-statistic-inner notika-shadow mg-tb-30" style="border-radius: 1rem">
                        <!-- Example job item -->
                        <div class="curved-inner-pro">
                            <div class="curved-ctn">
                                <div class="image-section">
                                    <img class="profile" src="../admin/image_url.jpg" alt="Job image">
                                </div>
                                <div class="info-section">
                                    <h2>Admin FirstName Admin LastName</h2>
                                    <i>Job Created Date</i>
                                </div>
                            </div>
                        </div>
                        <?php if ($jobDetailsJson): ?>
        <?php $jobDetails = json_decode($jobDetailsJson, true); ?>
        <div class="content">
            <h3><?= htmlspecialchars($jobDetails['title']) ?></h3>
            <div class="job-timesced" style="background-color: <?= $jobDetails['backgroundColor'] ?>; color: <?= $jobDetails['color'] ?>"><?= htmlspecialchars($jobDetails['workTime']) ?></div>
            <br>
            <h4><?= htmlspecialchars($jobDetails['company']) ?></h4>
            <div class="Job-description"><?= htmlspecialchars_decode($jobDetails['description']) ?></div>
        </div>
        <br><br>
        <img style="border-radius: 1rem" src="../admin/<?= htmlspecialchars($jobDetails['imagePath']) ?>" class="news_post" alt="news image">
    <?php else: ?>
        <p>Job not found.</p>
    <?php endif; ?>

                    </div>

                    <!-- More Job items can be added similarly -->
                </div>

                <div class="col-lg-4 col-md-4 col-sm-5 col-xs-12">
                    <div class="right-section">
                        <!-- Event Item Example -->
                        <div class="notika-shadow mg-tb-30 sm-res-mg-t-0 full-height wow fadeInRight"
                            data-wow-delay="0.2s">
                            <div class="card">
                                <img src="path/to/event_image.jpg" alt="Event Image" class="event_image">
                                <div class="card-content">
                                    <hr>
                                    <div class="card-title">Event Title</div>
                                    <div class="card-date">Posted on Event Date</div>
                                    <a href="visit_event.php?id=event_id"
                                        class="btn btn-default btn-icon-notika waves-effect">
                                        <i class="notika-icon notika-menu"> More</i>
                                    </a>
                                </div>
                            </div>
                        </div>
                        <!-- End Event Item Example -->

                        <a href="event_view.php" class="btn btn-primary btn-icon-notika waves-effect">Show More</a>

                        <div class="job-section" style="margin-top:60px">
                            <h3><i class="fa fa-briefcase"></i> Active Job Post</h3>
                            <!-- Job Item Example -->
                            <div class="notika-shadow mg-tb-30 sm-res-mg-t-0 full-height wow fadeInRight"
                                data-wow-delay="0.3">
                                <div class="card">
                                    <div class="card-content">
                                        <div class="job-container">
                                            <div class="job-title">Job Title</div>
                                            <div class="job-timesced"
                                                style="background-color: rgb(255, 105, 105); color: white;">Full-Time
                                            </div>
                                        </div>
                                        <hr>
                                        <div class="card-date">Company Name</div>
                                        <div class="card-date">Posted on Job Date</div>
                                    </div>
                                </div>
                            </div>
                            <!-- End Job Item Example -->
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

    <!-- Start Footer area -->
    <footer>
        <!-- Include your footer content here -->
    </footer>
    <!-- End Footer area -->

    <!-- JavaScript -->
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

    <!-- Custom JS -->
    <script>
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
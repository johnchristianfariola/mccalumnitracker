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
    usort($data, 'sortByDate');
    $delay = 0.1; // Starting delay
    foreach ($data as $news) {
        // Strip HTML tags from news_description and convert newlines to <br> tags
        $news_description = nl2br(preg_replace('/\n{2,}/', '<br><br>', strip_tags($news['news_description'])));
        $news_title = strip_tags($news['news_title']);
        $news_author = strip_tags($news['news_author']);
        $news_created = strip_tags($news['news_created']);
        $image_url = strip_tags($news['image_url']);
        ?>
        <div class="breadcomb-area wow fadeInUp" data-wow-delay="<?php echo number_format($delay, 1); ?>s">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                       
                            <div class="main_card">
                                <div class="news_card">
                                    <div class="news_image">
                                        <img src="../admin/<?php echo htmlspecialchars($image_url); ?>" alt="News Image">
                                    </div>
                                    <div class="news_content">
                                        <h3><?php echo htmlspecialchars($news_title); ?></h3>
                                        <div class="post_info">
                                            <p>Posted By <?php echo htmlspecialchars($news_author); ?></p>
                                            <p class="date_posted"><?php echo htmlspecialchars($news_created); ?></p>
                                        </div>
                                        <div class="news-description" style="margin-top:20px;">
                                            <p><?php echo $news_description; ?></p>
                                          
                                        </div>
                                        <div style="margin-top:20px">
                                        <button class="btn btn-default btn-icon-notika"><i class="notika-icon notika-next"></i> READ...</button>
                                        </div>
                                    </div>
                                </div>
                                
                        </div>
                    </div>
                </div>
            </div>
            
        </div>
        <?php
        $delay += 0.1; // Increment the delay for the next item
    }
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
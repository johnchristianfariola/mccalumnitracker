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


    <!-- Main Main Content area start-->
    <?php
    require_once '../includes/firebaseRDB.php';

    // Initialize Firebase URL
    $databaseURL = "https://mccnians-bc4f4-default-rtdb.firebaseio.com";
    $firebase = new firebaseRDB($databaseURL);

    // Function to calculate time difference in a human-readable format
    function timeAgo($timestamp)
    {
        $currentTime = time();
        $commentTime = strtotime($timestamp);
        $difference = $currentTime - $commentTime;

        if ($difference < 60) {
            return 'Just now';
        } elseif ($difference >= 60 && $difference < 3600) {
            $time = round($difference / 60);
            return $time . ' minute' . ($time > 1 ? 's' : '') . ' ago';
        } elseif ($difference >= 3600 && $difference < 86400) {
            $time = round($difference / 3600);
            return $time . ' hour' . ($time > 1 ? 's' : '') . ' ago';
        } else {
            $time = round($difference / 86400);
            return $time . ' day' . ($time > 1 ? 's' : '') . ' ago';
        }
    }

    // Get the news ID from the URL
    if (isset($_GET['id'])) {
        $news_id = $_GET['id'];

        // Retrieve the specific news item using the ID
        $event_data = $firebase->retrieve("event/{$news_id}");
        $event_data = json_decode($event_data, true);

        $adminData = $firebase->retrieve("admin/admin");
        $adminData = json_decode($adminData, true);

        // Extract admin profile image URL
        $admin_image_url = $adminData['image_url'];
        $adminFirstName = $adminData['firstname'];
        $adminLastName = $adminData['lastname'];

        if ($event_data) {
            // Display news details
            $image_url = htmlspecialchars($event_data['image_url']);
            $event_author = htmlspecialchars($event_data['event_author']);
            $event_created = htmlspecialchars($event_data['event_created']);
            $event_description = $event_data['event_description']; // Ensure HTML content in event_description is displayed correctly
            $event_title = htmlspecialchars($event_data['event_title']);
            $event_date = htmlspecialchars($event_data['event_date']);
            $event_venue = htmlspecialchars($event_data['event_venue']);

            // Get logged in alumni ID from session
            $alumni_id = isset($_SESSION['user']['id']) ? $_SESSION['user']['id'] : null;

            // Retrieve alumni profile information
            $alumniData = $firebase->retrieve("alumni/{$alumni_id}");
            $alumniData = json_decode($alumniData, true);
            $alumniProfileUrl = $alumniData['profile_url'];
            $alumniFirstName = $alumniData['firstname']; // Assuming the email is used as the name
            $alumniLastName = $alumniData['lastname']; // Assuming the email is used as the name
            // Check if the alumni has already participated
            $participationExists = false;
            if ($alumni_id) {
                $participationData = $firebase->retrieve("event_participation");
                $participationData = json_decode($participationData, true);

                if (is_array($participationData)) {
                    foreach ($participationData as $participation) {
                        if ($participation['event_id'] === $news_id && $participation['alumni_id'] === $alumni_id) {
                            $participationExists = true;
                            break;
                        }
                    }
                }
            }

            // Retrieve existing comments for the event
            $commentData = $firebase->retrieve("comment");
            $commentData = json_decode($commentData, true);
            $eventComments = [];
            if (is_array($commentData)) {
                foreach ($commentData as $comment) {
                    if ($comment['event_id'] === $news_id) {
                        $comment['date_ago'] = timeAgo($comment['date_commented']);
                        $eventComments[] = $comment;
                    }
                }
            }
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
                                                    <i class="uploader">Posted by:
                                                        <?php echo $adminFirstName . ' ' . $adminLastName; ?></i>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                        <p class="date-uploaded"><b>Event Date: <?php echo $event_date; ?></b></p>
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
                    <div class="additional-content" style="width: 100%; background: white; padding: 20px;">
                        <div style="margin-top:20px pull">
                            <a id="participateBtn" href="javascript:void(0);" data-event-id="<?php echo $news_id; ?>"
                                data-alumni-id="<?php echo $alumni_id; ?>" class="btn btn-success notika-btn-success" <?php echo $participationExists ? 'disabled' : ''; ?>>
                                <i class="notika-icon notika-next"></i>
                                <?php echo $participationExists ? 'Already Participated' : 'Participate'; ?>
                            </a>
                        </div>
                        <br><br>

                        <div class="comments-container">
                            <h1>Comments</h1>
                            <ul id="comments-list" class="comments-list">
                                <?php if (empty($eventComments)): ?>
                                    <li id="no-comments-message" class="center-message">Be the First to Comment</li>
                                <?php else: ?>
                                    <?php foreach ($eventComments as $comment): ?>
                                        <?php
                                        // Retrieve commenter profile information
                                        $commenterData = $firebase->retrieve("alumni/{$comment['alumni_id']}");
                                        $commenterData = json_decode($commenterData, true);
                                        $commenterProfileUrl = $commenterData['profile_url'];
                                        $commenterFirstName = $commenterData['firstname']; // Assuming the email is used as the name
                                        $commenterLasrName = $commenterData['lastname']; // Assuming the email is used as the name
                                        ?>
                                        <li>
                                            <div class="comment-main-level">
                                                <div class="comment-avatar"><img src="<?php echo $commenterProfileUrl; ?>" alt=""></div>
                                                <div class="comment-box">
                                                    <div class="comment-head">
                                                        <h6 class="comment-name by-author"><a
                                                                href="#"><?php echo $commenterFirstName . ' ' . $commenterLasrName; ?></a>
                                                        </h6>

                                                        <span><?php echo $comment['date_ago']; ?></span>
                                                        <i class="fa fa-reply"></i>
                                                        <i class="fa fa-heart"></i>
                                                    </div>
                                                    <div class="comment-content">
                                                        <?php echo htmlspecialchars($comment['comment']); ?>
                                                    </div>
                                                </div>
                                            </div>
                                        </li>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </ul>
                        </div>

                        <div class="container pb-cmnt-container">
                            <div class="row">
                                <div class="col-md-10 col-md-offset-0">
                                    <div class="panel panel-info">
                                        <div class="panel-body">
                                            <form id="commentForm">
                                                <textarea name="comment" placeholder="Write your comment here!"
                                                    class="pb-cmnt-textarea"></textarea>
                                                <button class="btn btn-primary pull-right" type="submit">Share</button>
                                                <input type="hidden" name="event_id" value="<?php echo $news_id; ?>">
                                                <input type="hidden" name="alumni_id" value="<?php echo $alumni_id; ?>">
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
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

    <style>
        * {
            margin: 0;
            padding: 0;
            -webkit-box-sizing: border-box;
            -moz-box-sizing: border-box;
            box-sizing: border-box;
        }

        a {
            color: #03658c;
            text-decoration: none;
        }

        ul {
            list-style-type: none;
        }

        body {
            font-family: 'Roboto', Arial, Helvetica, Sans-serif, Verdana;
            background: #dee1e3;
        }

        .comments-container {

            width: 768px;
        }

        .comments-container h1 {
            font-size: 36px;
            color: #283035;
            font-weight: 400;
        }

        .comments-container h1 a {
            font-size: 18px;
            font-weight: 700;
        }

        .comments-list {
            margin-top: 30px;
            position: relative;
        }

        .comments-list:before {
            content: '';
            width: 2px;
            height: 100%;
            background: #c7cacb;
            position: absolute;
            left: 32px;
            top: 0;
        }

        .comments-list:after {
            content: '';
            position: absolute;
            background: #c7cacb;
            bottom: 0;
            left: 27px;
            width: 7px;
            height: 7px;
            border: 3px solid #dee1e3;
            -webkit-border-radius: 50%;
            -moz-border-radius: 50%;
            border-radius: 50%;
        }

        .reply-list:before,
        .reply-list:after {
            display: none;
        }

        .reply-list li:before {
            content: '';
            width: 60px;
            height: 2px;
            background: #c7cacb;
            position: absolute;
            top: 25px;
            left: -55px;
        }


        .comments-list li {
            margin-bottom: 15px;
            /* display: block;*/
            position: relative;
        }

        .comments-list li:after {
            content: '';
            display: block;
            clear: both;
            height: 0;
            width: 0;
        }

        .reply-list {
            padding-left: 88px;
            clear: both;
            margin-top: 15px;
        }

        .comments-list .comment-avatar {
            width: 65px;
            height: 65px;
            position: relative;
            z-index: 99;
            float: left;
            border: 3px solid #FFF;
            -webkit-border-radius: 4px;
            -moz-border-radius: 4px;
            border-radius: 4px;
            -webkit-box-shadow: 0 1px 2px rgba(0, 0, 0, 0.2);
            -moz-box-shadow: 0 1px 2px rgba(0, 0, 0, 0.2);
            box-shadow: 0 1px 2px rgba(0, 0, 0, 0.2);
            overflow: hidden;
        }

        .comments-list .comment-avatar img {
            width: 100%;
            height: 100%;
            background: white;
        }

        .reply-list .comment-avatar {
            width: 50px;
            height: 50px;
        }

        .comment-main-level:after {
            content: '';
            width: 0;
            height: 0;
            display: block;
            clear: both;
        }

        .comments-list .comment-box {
            width: 680px;
            float: right;
            position: relative;
            -webkit-box-shadow: 0 1px 1px rgba(0, 0, 0, 0.15);
            -moz-box-shadow: 0 1px 1px rgba(0, 0, 0, 0.15);
            box-shadow: 0 1px 1px rgba(0, 0, 0, 0.15);
        }

        .comments-list .comment-box:before,
        .comments-list .comment-box:after {
            content: '';
            height: 0;
            width: 0;
            position: absolute;
            display: block;
            border-width: 10px 12px 10px 0;
            border-style: solid;
            border-color: transparent #EEEDEB;
            top: 8px;
            left: -11px;

        }

        .comments-list .comment-box:before {
            border-width: 11px 13px 11px 0;
            border-color: transparent rgba(0, 0, 0, 0.05);
            left: -12px;

        }

        .reply-list .comment-box {
            width: 610px;

        }

        .comment-box .comment-head {
            background: #EEEDEB;
            padding: 10px 12px;
            border-bottom: 1px solid red;
            overflow: hidden;
            -webkit-border-radius: 4px 4px 0 0;
            -moz-border-radius: 4px 4px 0 0;
            border-radius: 4px 4px 0 0;
        }

        .comment-box .comment-head i {
            float: right;
            margin-left: 14px;
            position: relative;
            top: 2px;
            color: #A6A6A6;
            cursor: pointer;
            -webkit-transition: color 0.3s ease;
            -o-transition: color 0.3s ease;
            transition: color 0.3s ease;
        }

        .comment-box .comment-head i:hover {
            color: #03658c;
        }

        .comment-box .comment-name {
            color: #283035;
            font-size: 14px;
            font-weight: 700;
            float: left;
            margin-right: 10px;
        }

        .comment-box .comment-name a {
            color: #283035;
        }

        .comment-box .comment-head span {
            float: left;
            color: #999;
            font-size: 13px;
            position: relative;
            top: 1px;
        }

        .comment-box .comment-content {
            background: #FFF;
            padding: 12px;
            font-size: 15px;
            color: #595959;
            -webkit-border-radius: 0 0 4px 4px;
            -moz-border-radius: 0 0 4px 4px;
            border-radius: 0 0 4px 4px;
        }

        .comment-box .comment-name.by-author,
        .comment-box .comment-name.by-author a {
            color: #03658c;
        }

        .comment-box .comment-name.by-author:after {
            content: 'autor';
            background: #03658c;
            color: #FFF;
            font-size: 12px;
            padding: 3px 5px;
            font-weight: 700;
            margin-left: 10px;
            -webkit-border-radius: 3px;
            -moz-border-radius: 3px;
            border-radius: 3px;
        }

        /** =====================
* Responsive
========================*/
        @media only screen and (max-width: 766px) {
            .comments-container {
                width: 480px;
            }

            .comments-list .comment-box {
                width: 390px;
            }

            .reply-list .comment-box {
                width: 320px;
            }
        }

        .pb-cmnt-container {
            font-family: Lato;
            margin-top: 100px;
        }

        .pb-cmnt-textarea {
            resize: none;
            padding: 20px;
            height: 130px;
            width: 100%;
            border: 1px solid #F2F2F2;
        }

        .center-message {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100px;
            font-size: 20px;
            color:
        }
    </style>



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
        // JavaScript for handling participation and commenting
        document.getElementById('participateBtn').addEventListener('click', function () {
            var eventId = this.getAttribute('data-event-id');
            var alumniId = this.getAttribute('data-alumni-id');

            var xhr = new XMLHttpRequest();
            xhr.open('POST', 'participate.php', true);
            xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
            xhr.onreadystatechange = function () {
                if (xhr.readyState === 4 && xhr.status === 200) {
                    if (xhr.responseText === 'Participation successful!') {
                        document.getElementById('participateBtn').innerText = 'Already Participated';
                        document.getElementById('participateBtn').setAttribute('disabled', 'disabled');
                    } else {
                        alert(xhr.responseText);
                    }
                }
            };
            xhr.send('event_id=' + eventId + '&alumni_id=' + alumniId);
        });

        document.getElementById('commentForm').addEventListener('submit', function (event) {
            event.preventDefault();

            var formData = new FormData(this);

            var xhr = new XMLHttpRequest();
            xhr.open('POST', 'comment.php', true);
            xhr.onreadystatechange = function () {
                if (xhr.readyState === 4 && xhr.status === 200) {
                    if (xhr.responseText === 'Comment added!') {
                        var commentsList = document.getElementById('comments-list');
                        var noCommentsMessage = document.getElementById('no-comments-message');
                        if (noCommentsMessage) {
                            noCommentsMessage.remove();
                        }

                        var newComment = document.createElement('li');
                        var now = new Date();
                        var timestamp = now.toISOString();
                        newComment.innerHTML = `
                                <div class="comment-main-level">
                                    <div class="comment-avatar"><img src="<?php echo $alumniProfileUrl; ?>" alt=""></div>
                                    <div class="comment-box">
                                        <div class="comment-head">
                                        <h6 class="comment-name by-author"><a href="#"><?php echo $alumniFirstName . ' ' . $alumniLastName; ?></a></h6>
                                            <span>${timeAgo(timestamp)}</span>
                                            <i class="fa fa-reply"></i>
                                            <i class="fa fa-heart"></i>
                                        </div>
                                        <div class="comment-content">
                                            ${document.querySelector('.pb-cmnt-textarea').value}
                                        </div>
                                    </div>
                                </div>
                            `;
                        commentsList.appendChild(newComment);
                        document.querySelector('.pb-cmnt-textarea').value = '';
                    } else {
                        alert(xhr.responseText);
                    }
                }
            };
            xhr.send(formData);
        });

        // Function to calculate time ago
        function timeAgo(timestamp) {
            var now = new Date();
            var commentTime = new Date(timestamp);
            var difference = now - commentTime;

            if (difference < 60000) {
                return 'Just now';
            } else if (difference < 3600000) {
                return Math.floor(difference / 60000) + ' minutes ago';
            } else if (difference < 86400000) {
                return Math.floor(difference / 3600000) + ' hours ago';
            } else {
                var days = Math.floor(difference / 86400000);
                return days + (days === 1 ? ' day ago' : ' days ago');
            }
        }
    </script>



</body>

</html>
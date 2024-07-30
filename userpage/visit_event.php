<?php include "../includes/session.php"; ?>

<!doctype html>
<html class="no-js" lang="">

<head>
    <?php include "includes/header.php"; ?>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/lottie-web/5.7.14/lottie.min.js"></script>
    <?php
    require_once "../includes/firebaseRDB.php";

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
            return "Just now";
        } elseif ($difference >= 60 && $difference < 3600) {
            $time = round($difference / 60);
            return $time . " minute" . ($time > 1 ? "s" : "") . " ago";
        } elseif ($difference >= 3600 && $difference < 86400) {
            $time = round($difference / 3600);
            return $time . " hour" . ($time > 1 ? "s" : "") . " ago";
        } else {
            $time = round($difference / 86400);
            return $time . " day" . ($time > 1 ? "s" : "") . " ago";
        }
    }

    // Get the news ID from the URL
    if (isset($_GET["id"])) {
        $event_id = $_GET["id"];

        // Retrieve the specific news item using the ID
        $event_data = $firebase->retrieve("event/{$event_id}");
        $event_data = json_decode($event_data, true);

        $adminData = $firebase->retrieve("admin/admin");
        $adminData = json_decode($adminData, true);

        // Extract admin profile image URL
        $admin_image_url = $adminData["image_url"];
        $adminFirstName = $adminData["firstname"];
        $adminLastName = $adminData["lastname"];

        if ($event_data) {

            // Display news details
            $image_url = htmlspecialchars($event_data["image_url"]);
            $event_author = htmlspecialchars($event_data["event_author"]);
            $event_created = htmlspecialchars($event_data["event_created"]);
            $event_description = $event_data["event_description"]; // Ensure HTML content in event_description is displayed correctly
            $event_title = htmlspecialchars($event_data["event_title"]);
            $event_date = htmlspecialchars($event_data["event_date"]);
            $event_venue = htmlspecialchars($event_data["event_venue"]);
           

            // Get logged in alumni ID from session
            $alumni_id = isset($_SESSION["user"]["id"])
                ? $_SESSION["user"]["id"]
                : null;

                $isLiked = false;
                if ($alumni_id && isset($event_data['likes']) && is_array($event_data['likes'])) {
                    $isLiked = in_array($alumni_id, $event_data['likes']);
                }
        

            // Retrieve alumni profile information
            $alumniData = $firebase->retrieve("alumni/{$alumni_id}");
            $alumniData = json_decode($alumniData, true);
            $alumniProfileUrl = $alumniData["profile_url"];
            $alumniFirstName = $alumniData["firstname"];
            $alumniLastName = $alumniData["lastname"];

            // Check if the alumni has already participated
            $participationExists = false;
            if ($alumni_id) {
                $participationData = $firebase->retrieve("event_participation");
                $participationData = json_decode($participationData, true);

                if (is_array($participationData)) {
                    foreach ($participationData as $participation) {
                        if (
                            $participation["event_id"] === $event_id &&
                            $participation["alumni_id"] === $alumni_id
                        ) {
                            $participationExists = true;
                            break;
                        }
                    }
                }
            }

            // Retrieve existing comments for the event
            $commentData = $firebase->retrieve("event_comments");
            $commentData = json_decode($commentData, true);
            $eventComments = [];
            if (is_array($commentData)) {
                foreach ($commentData as $comment) {
                    if ($comment["event_id"] === $event_id) {
                        $comment["date_ago"] = timeAgo(
                            $comment["date_commented"],
                        );
                        $eventComments[] = $comment;
                        $isLiked = in_array(
                            $alumni_id,
                            $comment["liked_by"] ?? [],
                        );
                    }
                }
            }
            ?>
</head>

<body>
    <!--[if lt IE 8]>
        <p class="browserupgrade">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> to improve your experience.</p>
    <![endif]-->

    <!-- Start Header Top Area -->
    <?php include "includes/navbar.php"; ?>
    <!-- End Header Top Area -->

    <!-- Mobile Menu start -->
    <?php include "includes/mobile_view.php"; ?>
    <!-- Mobile Menu end -->

    <!-- Main Menu area start-->
    <?php include "includes/main_menu.php"; ?>
    <!-- Main Menu area end -->

    <!-- Main Main Content area start-->
    

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
                                            <span class="uploader">Posted by: <?php echo $adminFirstName .
                                                " " .
                                                $adminLastName; ?></>
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
                <img style="width:100%; height: 500px; object-fit: cover;" src="../admin/<?php echo $image_url; ?>" alt="">
            </div>
            <div id="lottie-container" style="position: fixed; top: 50%; left: 50%; transform: translate(-50%, -50%); z-index: 9999; display: none;"></div>
            <div class="post">
                <div class="reactions">
                <button class="btn btn-like <?php echo $isLiked ? 'liked' : ''; ?>" data-event-id="<?php echo $event_id; ?>" data-alumni-id="<?php echo $alumni_id; ?>">
    <i class="fa fa-thumbs-up"></i> Like
</button>
    <span class="like-count"><?php echo isset($event_data["like_count"])
        ? $event_data["like_count"]
        : 0; ?></span>
                </div>
                <div class="comment-count"><i class="fa fa-comment"></i> <span><?php echo count($eventComments); ?></span></div>
            </div>


<!-- Include FontAwesome for icons -->

            <div class="additional-content" style="width: 100%; background: white; padding: 20px;">
                <?php
                // Get the alumni's batch ID and course ID
                $alumni_batch_id = isset($alumniData["batch"])
                    ? $alumniData["batch"]
                    : null;
                $alumni_course_id = isset($alumniData["course"])
                    ? $alumniData["course"]
                    : null;

                // Check if the alumni's batch ID is in the event's invited array
                $is_batch_invited = false;
                $is_course_invited = false;

                if (isset($event_data["event_invited"])) {
                    // Parse the event_invited string into an array
                    $invited_batches = json_decode(
                        $event_data["event_invited"],
                        true,
                    );

                    // Check if parsing was successful and the result is an array
                    if (
                        json_last_error() === JSON_ERROR_NONE &&
                        is_array($invited_batches)
                    ) {
                        $is_batch_invited = in_array(
                            $alumni_batch_id,
                            $invited_batches,
                        );
                    } else {
                        error_log(
                            "Error parsing event_invited JSON or it's not an array",
                        );
                    }
                }

                if (isset($event_data["course_invited"])) {
                    // Parse the course_invited string into an array
                    $invited_courses = json_decode(
                        $event_data["course_invited"],
                        true,
                    );

                    // Check if parsing was successful and the result is an array
                    if (
                        json_last_error() === JSON_ERROR_NONE &&
                        is_array($invited_courses)
                    ) {
                        $is_course_invited = in_array(
                            $alumni_course_id,
                            $invited_courses,
                        );
                    } else {
                        error_log(
                            "Error parsing course_invited JSON or it's not an array",
                        );
                    }
                }

                // Only show the participation button if both batch and course are invited
                if ($is_batch_invited && $is_course_invited) { ?>
                <div style="margin-top:20px pull">
                    <a id="participateBtn" href="javascript:void(0);" 
                       data-event-id="<?php echo $event_id; ?>"
                       data-alumni-id="<?php echo $alumni_id; ?>" 
                       class="btn btn-success notika-btn-success" 
                       <?php echo $participationExists ? "disabled" : ""; ?>>
                        <i class="notika-icon notika-next"></i>
                        <?php echo $participationExists
                            ? "Already Participated"
                            : "Participate"; ?>
                    </a>
                </div>
                <?php }
                ?>
                <br><br>

                <div class="comments-container">
                    <h1><i class="fa fa-wechat"></i> Comments</h1>
                    <ul id="comments-list" class="comments-list">
                        <?php if (empty($eventComments)): ?>
                            <li id="no-comments-message" class="center-message">Be the First to Comment</li>
                        <?php else: ?>
                            <?php foreach (
                                $commentData
                                as $commentId => $comment
                            ): ?>
                                <?php if (
                                    $comment["event_id"] === $event_id
                                ): ?>
                                    <?php
                                    $commenterData = $firebase->retrieve(
                                        "alumni/{$comment["alumni_id"]}",
                                    );
                                    $commenterData = json_decode(
                                        $commenterData,
                                        true,
                                    );
                                    $commenterProfileUrl =
                                        $commenterData["profile_url"];
                                    $commenterFirstName =
                                        $commenterData["firstname"];
                                    $commenterLastName =
                                        $commenterData["lastname"];
                                    ?>
                                    <li data-comment-id="<?php echo $commentId; ?>">
                                        <div class="comment-main-level">
                                            <div class="comment-avatar"><img src="<?php echo $commenterProfileUrl; ?>" alt=""></div>
                                            <div class="comment-box">
                                                <div class="comment-head">
                                                    <h6 class="comment-name by-author">
                                                        <a href="#"><?php echo $commenterFirstName .
                                                            " " .
                                                            $commenterLastName; ?></a>
                                                    </h6>
                                                    <span><?php echo timeAgo(
                                                        $comment[
                                                            "date_commented"
                                                        ],
                                                    ); ?></span>
                                                    <i class="fa fa-reply reply-button"></i>
                                                    <i class="fa fa-heart <?php echo $isLiked
                                                        ? "liked"
                                                        : ""; ?>" data-comment-id="<?php echo $commentId; ?>"></i>
                                                    <span style="float:right" class="heart-count"><?php echo isset(
                                                        $comment["heart_count"],
                                                    )
                                                        ? $comment[
                                                            "heart_count"
                                                        ]
                                                        : 0; ?></span>
                                                </div>
                                                <div class="comment-content">
                                                    <?php echo htmlspecialchars(
                                                        $comment["comment"],
                                                    ); ?>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="reply-container" style="display: none;"></div>
                                        <ul class="comments-list reply-list">
                                            <?php if (
                                                isset($comment["replies"])
                                            ): ?>
                                                <?php foreach (
                                                    $comment["replies"]
                                                    as $replyId => $reply
                                                ): ?>
                                                    <?php
                                                    $replyAuthorData = $firebase->retrieve(
                                                        "alumni/{$reply["alumni_id"]}",
                                                    );
                                                    $replyAuthorData = json_decode(
                                                        $replyAuthorData,
                                                        true,
                                                    );
                                                    ?>
                                                    <li>
                                                        <div class="comment-avatar"><img src="<?php echo $replyAuthorData[
                                                            "profile_url"
                                                        ]; ?>" alt=""></div>
                                                        <div class="comment-box">
                                                            <div class="comment-head">
                                                                <h6 class="comment-name by-author">
                                                                    <a href="#"><?php echo $replyAuthorData[
                                                                        "firstname"
                                                                    ] .
                                                                        " " .
                                                                        $replyAuthorData[
                                                                            "lastname"
                                                                        ]; ?></a>
                                                                </h6>
                                                                <span><?php echo timeAgo(
                                                                    $reply[
                                                                        "date_replied"
                                                                    ],
                                                                ); ?></span>
                                                            </div>
                                                            <div class="comment-content">
                                                                <?php echo htmlspecialchars(
                                                                    $reply[
                                                                        "comment"
                                                                    ],
                                                                ); ?>
                                                            </div>
                                                        </div>
                                                    </li>
                                                <?php endforeach; ?>
                                            <?php endif; ?>
                                        </ul>
                                    </li>
                                <?php endif; ?>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </ul>
                </div>

                <div class="container pb-cmnt-container">
                    <div class="row">
                        <div class="col-md-10 col-md-offset-0">
                            <div id="uniquePanelInfo" class="panel panel-info">
                                <div id="uniquePanelBody" class="panel-body">
                                    <form id="commentForm" method="POST" action="comment_event.php">
                                        <textarea name="comment" placeholder="Write your comment here!" class="pb-cmnt-textarea" id="uniqueCommentTextarea"></textarea>
                                        <button class="btn btn-primary pull-right" type="button" id="submitComment">Share</button>
                                        <input type="hidden" name="event_id" value="<?php echo $event_id; ?>">
                                        <input type="hidden" name="alumni_id" value="<?php echo $alumni_id; ?>">
                                    </form>
                                    <!-- Comment list (for display purposes) -->
                                    <ul id="uniqueCommentList"></ul>
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
            echo "Event item not found.";
        }
    } else {
        echo "No Event ID provided.";
    }
    ?>
</body>

</html>


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

    </script>
  <script>
$(document).ready(function() {
    var isReplyBoxOpen = false;
    var heartedComments = new Set(); // Store IDs of comments that have been hearted

    $('#submitComment').click(function() {
        var $submitButton = $(this);
        var formData = $('#commentForm').serialize();
        var commentContent = $('.pb-cmnt-textarea').val().trim();

        if (commentContent === "") {
            swal({
                title: 'Oops...',
                text: 'Please enter a comment before sharing.',
                type: 'warning',
                timer: 5000,
                onOpen: function () {
                    swal.showLoading()
                }
            }).then(
                function () {},
                function (dismiss) {
                    if (dismiss === 'timer') {
                        console.log('I was closed by the timer')
                    }
                }
            )
            return;
        }

        $submitButton.prop('disabled', true).text('Submitting...');

        $.ajax({
            type: 'POST',
            url: 'comment_event.php',
            data: formData,
            dataType: 'json',
            success: function(response) {
                if (response.status === 'success') {
                    var commentsList = $('#comments-list');
                    var noCommentsMessage = $('#no-comments-message');
                    if (noCommentsMessage.length) {
                        noCommentsMessage.remove();
                    }

                    var now = new Date();
                    var timestamp = now.toISOString();
                    var newComment = `
                        <li>
                            <div class="comment-main-level">
                                <div class="comment-avatar"><img src="<?php echo $alumniProfileUrl; ?>" alt=""></div>
                                <div class="comment-box">
                                    <div class="comment-head">
                                        <h6 class="comment-name by-author"><a href="#"><?php echo $alumniFirstName .
                                            " " .
                                            $alumniLastName; ?></a></h6>
                                        <span>${timeAgo(timestamp)}</span>
                                        <i class="fa fa-reply reply-button"></i>
                                        <i class="fa fa-heart"></i>
                                    </div>
                                    <div class="comment-content">
                                        ${commentContent}
                                    </div>
                                </div>
                            </div>
                        </li>
                    `;
                    commentsList.append(newComment);
                    $('#commentForm')[0].reset();
                } else {
                    alert(response.message);
                }
            },
            error: function() {
                alert('Error submitting comment!');
            },
            complete: function() {
                $submitButton.prop('disabled', false).text('Share');
            }
        });
    });

    function timeAgo(dateString) {
        const date = new Date(dateString);
        const now = new Date();
        const secondsPast = (now.getTime() - date.getTime()) / 1000;

        if (secondsPast < 60) {
            return 'just now';
        }
        if (secondsPast < 3600) {
            return Math.round(secondsPast / 60) + 'm ago';
        }
        if (secondsPast <= 86400) {
            return Math.round(secondsPast / 3600) + 'h ago';
        }
        if (secondsPast > 86400) {
            const day = date.getDate();
            const month = date.toDateString().match(/ [a-zA-Z]*/)[0].replace(" ", "");
            const year = date.getFullYear() == now.getFullYear() ? "" : " " + date.getFullYear();
            return day + " " + month + year;
        }
    }

    $(document).on('click', '.reply-button', function() {
        var $commentItem = $(this).closest('li');
        var commentId = $commentItem.data('comment-id');
        var $replyContainer = $commentItem.find('.reply-container');
        
        if ($replyContainer.is(':empty')) {
            var replyForm = `
                <form class="reply-form">
                    <textarea class="reply-textarea" placeholder="Write your reply here..."></textarea>
                    <button type="submit" class="btn btn-primary submit-reply">Reply</button>
                    <input type="hidden" name="parent_comment_id" value="${commentId}">
                </form>
            `;
            $replyContainer.html(replyForm).show();
            isReplyBoxOpen = true;
        } else {
            $replyContainer.toggle();
            isReplyBoxOpen = $replyContainer.is(':visible');
        }
    });

    $(document).on('submit', '.reply-form', function(e) {
        e.preventDefault();
        var $form = $(this);
        var replyContent = $form.find('.reply-textarea').val().trim();
        var parentCommentId = $form.find('input[name="parent_comment_id"]').val();

        if (replyContent === "") {
            alert('Please enter a reply before submitting.');
            return;
        }

        $.ajax({
            type: 'POST',
            url: 'reply_event.php',
            data: {
                comment: replyContent,
                parent_comment_id: parentCommentId,
                event_id: '<?php echo $event_id; ?>',
                alumni_id: '<?php echo $alumni_id; ?>'
            },
            dataType: 'json',
            success: function(response) {
                if (response.status === 'success') {
                    var newReply = `
                        <li>
                            <div class="comment-avatar"><img src="<?php echo $alumniProfileUrl; ?>" alt=""></div>
                            <div class="comment-box">
                                <div class="comment-head">
                                    <h6 class="comment-name by-author"><a href="#"><?php echo $alumniFirstName .
                                        " " .
                                        $alumniLastName; ?></a></h6>
                                    <span>Just now</span>
                                </div>
                                <div class="comment-content">
                                    ${replyContent}
                                </div>
                            </div>
                        </li>
                    `;
                    $form.closest('li').find('.reply-list').append(newReply);
                    $form.find('.reply-textarea').val('');
                    $form.parent().hide();
                    isReplyBoxOpen = false;
                } else {
                    alert(response.message);
                }
            },
            error: function() {
                alert('Error submitting reply!');
            }
        });
    });

    $(document).on('click', '.cancel-reply', function() {
        $(this).closest('.reply-container').hide();
        isReplyBoxOpen = false;
    });

   
    function refreshComments() {
        if (!isReplyBoxOpen) {
            $.ajax({
                url: 'refresh_event.php',
                type: 'GET',
                data: { event_id: '<?php echo $event_id; ?>',   alumni_id: '<?php echo $alumni_id; ?>'},
                success: function(response) {
                    var openReplyForms = $('.reply-form:visible');
                    var savedInputs = openReplyForms.find('textarea').map(function() {
                        return $(this).val();
                    }).get();

                    var $newCommentsList = $(response);

                    // Preserve heart counts and liked status for hearted comments
                    heartedComments.forEach(function(commentId) {
                        var $oldComment = $('#comments-list').find('li[data-comment-id="' + commentId + '"]');
                        var $newComment = $newCommentsList.find('li[data-comment-id="' + commentId + '"]');
                        
                        if ($oldComment.length && $newComment.length) {
                            var $oldHeart = $oldComment.find('.fa-heart');
                            var $oldHeartCount = $oldComment.find('.heart-count');
                            var $newHeart = $newComment.find('.fa-heart');
                            var $newHeartCount = $newComment.find('.heart-count');

                            $newHeart.addClass('liked');
                            $newHeartCount.text($oldHeartCount.text());
                        }
                    });

                    $('#comments-list').html($newCommentsList);

                    if (savedInputs.length > 0) {
                        $('.reply-form:visible').each(function(index) {
                            $(this).find('textarea').val(savedInputs[index]);
                        });
                    }
                },
                error: function() {
                    console.log('Error refreshing comments');
                }
            });
        }
    }


  
    // Set interval to refresh comments every 5 seconds
    setInterval(refreshComments, 5000);

});



</script>
<script>
    $(document).ready(function() {
    // Existing click handler
    $(document).on('click', '.fa-heart', function() {
        var $heart = $(this);
        var commentId = $heart.data('comment-id');
        var isLiked = $heart.hasClass('liked');

        $.ajax({
            url: 'update_heart_event.php',
            method: 'POST',
            data: { 
                comment_id: commentId,
                alumni_id: '<?php echo $alumni_id; ?>',
                is_liked: !isLiked
            },
            success: function(response) {
                var data = JSON.parse(response);
                if (data.success) {
                    $heart.toggleClass('liked', data.is_liked);
                    $heart.next('.heart-count').text(data.heart_count);
                }
            }
        });
    });

    // Function to update hearts on page load or refresh
    function updateHearts() {
        $('.fa-heart').each(function() {
            var $heart = $(this);
            var commentId = $heart.data('comment-id');
            
            $.ajax({
                url: 'get_event_heart_status.php',
                method: 'GET',
                data: { 
                    comment_id: commentId,
                    alumni_id: '<?php echo $alumni_id; ?>'
                },
                success: function(response) {
                    var data = JSON.parse(response);
                    $heart.toggleClass('liked', data.is_liked);
                    $heart.next('.heart-count').text(data.heart_count);
                }
            });
        });
    }

    // Call updateHearts on page load
    updateHearts();
});

var eventId = $('.btn-like').data('event-id');
    var alumniId = $('.btn-like').data('alumni-id');

    var animation = lottie.loadAnimation({
  container: document.getElementById('lottie-container'),
  renderer: 'svg',
  loop: false,
  autoplay: false,
  path: 'js/lottie/check.json',
  rendererSettings: {
    preserveAspectRatio: 'xMidYMid slice'
  }
});

// Set the size of the animation
animation.resize();

function resizeLottieAnimation() {
  var container = document.getElementById('lottie-container');
  var desiredWidth = 500; // Set your desired width
  var desiredHeight = 500; // Set your desired height

  // You can make this responsive, for example:
  // var desiredWidth = window.innerWidth * 0.5; // 50% of window width
  // var desiredHeight = window.innerHeight * 0.5; // 50% of window height

  container.style.width = desiredWidth + 'px';
  container.style.height = desiredHeight + 'px';
  
  if (animation) {
    animation.resize();
  }
}

// Call this function when the window is resized
window.addEventListener('resize', resizeLottieAnimation);

// Call it once at the beginning to set initial size
resizeLottieAnimation();

    function updateLikeCount() {
        $.ajax({
            url: 'get_event_like_count.php',
            method: 'GET',
            data: {
                event_id: eventId,
                alumni_id: alumniId // Add this line
            },
            success: function(response) {
                var data = JSON.parse(response);
                if (data.success) {
                    $('.like-count').text(data.likeCount);
                    if (data.liked) {
                        $('.btn-like').addClass('liked');
                    } else {
                        $('.btn-like').removeClass('liked');
                    }
                }
            },
            error: function() {
                console.log('An error occurred while updating the like count.');
            }
        });
    }

    // Set interval to update like count every 5 seconds
    setInterval(updateLikeCount, 5000);

    $(document).on('click', '.btn-like', function() {
        var $button = $(this);
        
        $.ajax({
            url: 'update_like_event_count.php',
            method: 'POST',
            data: {
                event_id: eventId,
                alumni_id: alumniId
            },
            success: function(response) {
                var data = JSON.parse(response);
                if (data.success) {
                    $('.like-count').text(data.likeCount);
                    if (data.liked) {
                        $button.addClass('liked');
                        
                        // Show and play Lottie animation
                        $('#lottie-container').show();
                        animation.goToAndPlay(0);
                        
                        // Hide animation after it completes
                        animation.addEventListener('complete', function() {
                            $('#lottie-container').hide();
                        });
                    } else {
                        $button.removeClass('liked');
                    }
                }
            },
            error: function() {
                alert('An error occurred. Please try again.');
            }
        });

});


</script>
<style>
.fa-heart {
    color: #ccc !important; /* Default color */
    cursor: pointer;
}

.fa-heart.liked {
    color: red !important; /* Color when liked */
}
.btn-like.liked {
        background-color: blue;
        color: white;
    }
</style>
</body>

</html>
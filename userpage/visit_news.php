<?php include '../includes/session.php'; ?>
<!doctype html>
<html class="no-js" lang="">

<head>
    <?php include 'includes/header.php' ?>
    <style>
        /* Add your custom styles here */
    </style>
</head>

<body>
    <?php include 'includes/navbar.php' ?>
    <?php include 'includes/mobile_view.php' ?>
    <?php include 'includes/main_menu.php' ?>

    <?php
    require_once '../includes/firebaseRDB.php';
    require_once '../includes/config.php';
    $firebase = new firebaseRDB($databaseURL);

    function timeAgo($timestamp) {
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

    if (isset($_GET['id'])) {
        $news_id = $_GET['id'];
        $news_data = $firebase->retrieve("news/{$news_id}");
        $news_data = json_decode($news_data, true);

        $adminData = $firebase->retrieve("admin/admin");
        $adminData = json_decode($adminData, true);

        if ($news_data) {
            $image_url = htmlspecialchars($news_data['image_url']);
            $news_author = htmlspecialchars($news_data['news_author']);
            $news_created = htmlspecialchars($news_data['news_created']);
            $news_description = $news_data['news_description'];
            $news_title = htmlspecialchars($news_data['news_title']);

            $alumni_id = isset($_SESSION['user']['id']) ? $_SESSION['user']['id'] : null;

            $alumniData = $firebase->retrieve("alumni/{$alumni_id}");
            $alumniData = json_decode($alumniData, true);
            $alumniProfileUrl = $alumniData['profile_url'];
            $alumniFirstName = $alumniData['firstname'];
            $alumniLastName = $alumniData['lastname'];

            $commentData = $firebase->retrieve("news_comments");
            $commentData = json_decode($commentData, true);
            $newsComments = [];
            if (is_array($commentData)) {
                foreach ($commentData as $commentId => $comment) {
                    if ($comment['news_id'] === $news_id) {
                        $comment['date_ago'] = timeAgo($comment['date_commented']);
                        $newsComments[$commentId] = $comment;
                    }
                }
            }
    ?>
            <!-- Your existing news display code here -->
            <div class="breadcomb-area">
                <div class="container">
                    <div class="row">
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <div class="breadcomb-list">
                                <div class="row">
                                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                        <div class="breadcomb-wp">
                                            <div class="breadcomb-icon">
                                                <img class="profile" src="../admin/<?php echo $adminData['image_url']; ?>" alt="">
                                            </div>
                                            <div class="breadcomb-ctn">
                                                <h2><?php echo $news_title; ?></h2>
                                                <div class="visited-content">
                                                    <i class="uploader">Posted by: <?php echo $adminData['firstname'] . ' ' . $adminData['lastname']; ?></i>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                        <p class="date-uploaded">Date Posted: <?php echo $news_created; ?></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div style="background:white; padding: 20px 190px 20px 20px; text-align: justify;">
                        <?php echo $news_description; ?>
                    </div>
                    <div class="background">
                        <img style="width:100%; height: 500px; object-fit: cover;" src="../admin/<?php echo $image_url; ?>" alt="">
                    </div>

                    <div class="additional-content" style="width: 100%; background: white; padding: 20px;">
                    <br><br>

            <div class="comments-container">
                <h1><i class="fa fa-wechat"></i> Comments</h1>
                <ul id="comments-list" class="comments-list">
                    <?php if (empty($newsComments)): ?>
                        <li id="no-comments-message" class="center-message">Be the First to Comment</li>
                    <?php else: ?>
                        <?php foreach ($newsComments as $commentId => $comment): ?>
                            <?php
                            $commenterData = $firebase->retrieve("alumni/{$comment['alumni_id']}");
                            $commenterData = json_decode($commenterData, true);
                            $commenterProfileUrl = $commenterData['profile_url'];
                            $commenterFirstName = $commenterData['firstname'];
                            $commenterLastName = $commenterData['lastname'];
                            ?>
                            <li data-comment-id="<?php echo $commentId; ?>">
                                <div class="comment-main-level">
                                    <div class="comment-avatar"><img src="<?php echo $commenterProfileUrl; ?>" alt=""></div>
                                    <div class="comment-box">
                                        <div class="comment-head">
                                            <h6 class="comment-name by-author">
                                                <a href="#"><?php echo $commenterFirstName . ' ' . $commenterLastName; ?></a>
                                            </h6>
                                            <span><?php echo $comment['date_ago']; ?></span>
                                            <i class="fa fa-reply reply-button"></i>
                                            <i class="fa fa-heart"></i>
                                        </div>
                                        <div class="comment-content">
                                            <?php echo htmlspecialchars($comment['comment']); ?>
                                        </div>
                                    </div>
                                </div>
                                <div class="reply-container" style="display: none;">
                                    <form class="reply-form">
                                        <textarea class="reply-textarea" placeholder="Write your reply here..."></textarea>
                                        <button type="submit" class="btn btn-primary submit-reply">Reply</button>
                                        <input type="hidden" name="parent_comment_id" value="<?php echo $commentId; ?>">
                                    </form>
                                </div>
                                <ul class="comments-list reply-list">
                                    <?php if (isset($comment['replies'])): ?>
                                        <?php foreach ($comment['replies'] as $replyId => $reply): ?>
                                            <?php
                                            $replyAuthorData = $firebase->retrieve("alumni/{$reply['alumni_id']}");
                                            $replyAuthorData = json_decode($replyAuthorData, true);
                                            ?>
                                            <li>
                                                <div class="comment-avatar"><img src="<?php echo $replyAuthorData['profile_url']; ?>" alt=""></div>
                                                <div class="comment-box">
                                                    <div class="comment-head">
                                                        <h6 class="comment-name by-author">
                                                            <a href="#"><?php echo $replyAuthorData['firstname'] . ' ' . $replyAuthorData['lastname']; ?></a>
                                                        </h6>
                                                        <span><?php echo timeAgo($reply['date_replied']); ?></span>
                                                    </div>
                                                    <div class="comment-content">
                                                        <?php echo htmlspecialchars($reply['comment']); ?>
                                                    </div>
                                                </div>
                                            </li>
                                        <?php endforeach; ?>
                                    <?php endif; ?>
                                </ul>
                            </li>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </ul>
            </div>

            <div class="container pb-cmnt-container">
                <div class="row">
                    <div class="col-md-10 col-md-offset-0">
                        <div id="uniquePanelInfo" class="panel panel-info">
                            <div id="uniquePanelBody" class="panel-body">
                                <form id="commentForm" method="POST" action="comment_news.php">
                                    <textarea name="comment" placeholder="Write your comment here!" class="pb-cmnt-textarea" id="uniqueCommentTextarea"></textarea>
                                    <button class="btn btn-primary pull-right" type="button" id="submitComment">Share</button>
                                    <input type="hidden" name="news_id" value="<?php echo $news_id; ?>">
                                    <input type="hidden" name="alumni_id" value="<?php echo $alumni_id; ?>">
                                </form>
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
        echo "Invalid request.";
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
  <script>
    $(document).ready(function() {
        var isReplyBoxOpen = false;

        $('#submitComment').click(function() {
            var $submitButton = $(this);
            var formData = $('#commentForm').serialize();
            var commentContent = $('.pb-cmnt-textarea').val().trim();

            if (commentContent === "") {
                Swal.fire({
                    title: 'Oops...',
                    text: 'Please enter a comment before sharing.',
                    icon: 'warning',
                    timer: 5000,
                    timerProgressBar: true
                });
                return;
            }

            $submitButton.prop('disabled', true).text('Submitting...');

            $.ajax({
                type: 'POST',
                url: 'comment_news.php',
                data: formData,
                dataType: 'json',
                success: function(response) {
                    if (response.status === 'success') {
                        var commentsList = $('#comments-list');
                        var noCommentsMessage = $('#no-comments-message');
                        if (noCommentsMessage.length) {
                            noCommentsMessage.remove();
                        }

                        var newComment = `
                            <li>
                                <div class="comment-main-level">
                                    <div class="comment-avatar"><img src="<?php echo $alumniProfileUrl; ?>" alt=""></div>
                                    <div class="comment-box">
                                        <div class="comment-head">
                                            <h6 class="comment-name by-author"><a href="#"><?php echo $alumniFirstName . ' ' . $alumniLastName; ?></a></h6>
                                            <span>Just now</span>
                                            <i class="fa fa-reply reply-button"></i>
                                            <i class="fa fa-heart"></i>
                                        </div>
                                        <div class="comment-content">
                                            ${commentContent}
                                        </div>
                                    </div>
                                </div>
                                <div class="reply-container" style="display: none;">
                                    <form class="reply-form">
                                        <textarea class="reply-textarea" placeholder="Write your reply here..."></textarea>
                                        <button type="submit" class="btn btn-primary submit-reply">Reply</button>
                                        <input type="hidden" name="parent_comment_id" value="${response.commentId}">
                                    </form>
                                </div>
                            </li>
                        `;
                        commentsList.append(newComment);
                        $('#commentForm')[0].reset();
                        Swal.fire({
                            title: 'Success!',
                            text: 'Your comment has been added.',
                            icon: 'success',
                            timer: 2000,
                            timerProgressBar: true
                        });
                    } else {
                        Swal.fire({
                            title: 'Error',
                            text: response.message,
                            icon: 'error'
                        });
                    }
                },
                error: function() {
                    Swal.fire({
                        title: 'Error',
                        text: 'An error occurred while submitting your comment.',
                        icon: 'error'
                    });
                },
                complete: function() {
                    $submitButton.prop('disabled', false).text('Share');
                }
            });
        });

        function refreshComments() {
        if (!isReplyBoxOpen) {
            $.ajax({
                url: 'refresh_news.php',
                type: 'GET',
                data: { news_id: '<?php echo $news_id; ?>' },
                success: function(response) {
                    var $commentsList = $('#comments-list');
                    var $currentComments = $commentsList.children('li');
                    var newComments = $(response).filter('li');

                    // Update existing comments and add new ones
                    newComments.each(function() {
                        var commentId = $(this).data('comment-id');
                        var $existingComment = $currentComments.filter('[data-comment-id="' + commentId + '"]');

                        if ($existingComment.length) {
                            // Update existing comment
                            $existingComment.replaceWith($(this));
                        } else {
                            // Add new comment
                            $commentsList.append($(this));
                        }
                    });

                    // Remove comments that no longer exist
                    $currentComments.each(function() {
                        var commentId = $(this).data('comment-id');
                        if (!newComments.filter('[data-comment-id="' + commentId + '"]').length) {
                            $(this).remove();
                        }
                    });

                    // Reattach event listeners
                    attachEventListeners();
                },
                error: function() {
                    console.log('Error refreshing comments');
                }
            });
        }
    }

    function attachEventListeners() {
        // Remove existing event listeners
        $(document).off('click', '.reply-button');
        $(document).off('submit', '.reply-form');

        // Reattach reply button event listener
        $(document).on('click', '.reply-button', function() {
            var $replyContainer = $(this).closest('li').find('.reply-container');
            $replyContainer.toggle();
            isReplyBoxOpen = !isReplyBoxOpen;

            // Add reply form if it doesn't exist
            if (!$replyContainer.find('.reply-form').length) {
                var parentCommentId = $(this).closest('li').data('comment-id');
                var replyForm = `
                    <form class="reply-form">
                        <textarea class="reply-textarea" placeholder="Write your reply here..."></textarea>
                        <button type="submit" class="btn btn-primary submit-reply">Reply</button>
                        <input type="hidden" name="parent_comment_id" value="${parentCommentId}">
                    </form>
                `;
                $replyContainer.html(replyForm);
            }
        });

        // Reattach reply form submit event listener
        $(document).on('submit', '.reply-form', function(e) {
            e.preventDefault();
            var $form = $(this);
            var replyContent = $form.find('.reply-textarea').val().trim();
            var parentCommentId = $form.find('input[name="parent_comment_id"]').val();

            if (replyContent === "") {
                Swal.fire({
                    title: 'Oops...',
                    text: 'Please enter a reply before submitting.',
                    icon: 'warning',
                    timer: 5000,
                    timerProgressBar: true
                });
                return;
            }

            $.ajax({
                type: 'POST',
                url: 'reply_news.php',
                data: {
                    comment: replyContent,
                    parent_comment_id: parentCommentId,
                    news_id: '<?php echo $news_id; ?>',
                    alumni_id: '<?php echo $alumni_id; ?>'
                },
                dataType: 'json',
                success: function(response) {
                    if (response.status === 'success') {
                        $form.find('.reply-textarea').val('');
                        $form.closest('.reply-container').hide();
                        isReplyBoxOpen = false;
                        Swal.fire({
                            title: 'Success!',
                            text: 'Your reply has been added.',
                            icon: 'success',
                            timer: 2000,
                            timerProgressBar: true
                        });
                        refreshComments(); // Refresh comments after successful reply
                    } else {
                        Swal.fire({
                            title: 'Error',
                            text: response.message,
                            icon: 'error'
                        });
                    }
                },
                error: function() {
                    Swal.fire({
                        title: 'Error',
                        text: 'An error occurred while submitting your reply.',
                        icon: 'error'
                    });
                }
            });
        });
    }

    // Initial attachment of event listeners
    attachEventListeners();

    // Set interval to refresh comments every 5 seconds
    setInterval(refreshComments, 5000);
    });
    </script>
</body>

</html>
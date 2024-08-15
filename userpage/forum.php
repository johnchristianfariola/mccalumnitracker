<?php include '../includes/session.php'; ?>
<!doctype html>
<html class="no-js" lang="">
<?php
require_once '../includes/firebaseRDB.php';
require_once '../includes/config.php';

$firebase = new firebaseRDB($databaseURL);

$forum_data = $firebase->retrieve("forum");
$forum_data = json_decode($forum_data, true);

$alumni_data = $firebase->retrieve("alumni");
$alumni_data = json_decode($alumni_data, true);

function time_elapsed_string($datetime, $full = false)
{
    $now = new DateTime('now', new DateTimeZone('Asia/Manila')); // Adjust to your local timezone
    $ago = new DateTime($datetime, new DateTimeZone('Asia/Manila')); // Adjust to your local timezone
    $diff = $now->diff($ago);

    $diff->w = floor($diff->d / 7);
    $diff->d -= $diff->w * 7;

    $string = array(
        'y' => 'year',
        'm' => 'month',
        'w' => 'week',
        'd' => 'day',
        'h' => 'hour',
        'i' => 'minute',
        's' => 'second',
    );

    foreach ($string as $k => &$v) {
        if ($diff->$k) {
            $v = $diff->$k . ' ' . $v . ($diff->$k > 1 ? 's' : '');
        } else {
            unset($string[$k]);
        }
    }

    if (!$full)
        $string = array_slice($string, 0, 1);
    return $string ? implode(', ', $string) . ' ago' : 'just now';
}

// Set the default timezone to your local timezone
date_default_timezone_set('Asia/Manila'); // Adjust this to your local timezone

?>

<head>
    <?php include 'includes/header.php' ?>
    <!-- Bootstrap CSS -->
    <style>

    </style>



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

    <?php include 'includes/forum_modal.php' ?>

    <div class="main-content">
        <div class="sale-statistic-area">
            <div class="container">
                <div class="row">
                    <div class="col-lg-8 col-md-8 col-sm-7 col-xs-12">
                        <!-- News content will be loaded here -->
                        <div class="sale-statistic-inner notika-shadow mg-tb-30" style="border-radius: 1rem">
                            <button type="button" class="btn btn-primary"
                                style="position: absolute; top: 10px; right: 10px; border-radius: 50%;"
                                data-toggle="modal" data-target="#forumModal">
                                +
                            </button>
                        </div>
                        <?php
                        if (!empty($forum_data)) {
                            $forum_data_with_id = [];
                            foreach ($forum_data as $forum_id => $forum_post) {
                                $forum_data_with_id[] = array_merge(['forum_id' => $forum_id], $forum_post);
                            }

                            usort($forum_data_with_id, function ($a, $b) {
                                return strtotime($b['createdAt']) - strtotime($a['createdAt']);
                            });

                            foreach ($forum_data_with_id as $forum_post) {
                                $forum_id = $forum_post['forum_id'];
                                $alumni_id = $forum_post['alumniId'] ?? null;
                                $current_alumni = $alumni_data[$alumni_id] ?? null;

                                $alumni_name = 'Unknown Alumni';
                                $profile_url = '../images/profile.png';

                                if ($current_alumni) {
                                    $alumni_name = $current_alumni['firstname'] . ' ' . $current_alumni['lastname'];
                                    $profile_url = $current_alumni['profile_url'] ?? '../images/profile.png';
                                }

                                $created_at = $forum_post['createdAt'] ?? null;
                                $formatted_date = 'Unknown Date';
                                $time_ago = '';

                                if ($created_at) {
                                    $date = new DateTime($created_at);
                                    $formatted_date = $date->format('F j, Y');
                                    $time_ago = time_elapsed_string($created_at);
                                }
                                ?>

                                <div class="sale-statistic-inner notika-shadow mg-tb-30" style="border-radius: 1rem">
                                    <div class="curved-inner-pro">
                                        <div class="image-section">
                                            <img class="profile" src="<?php echo htmlspecialchars($profile_url); ?>"
                                                alt="profile image">
                                        </div>
                                        <div class="info-section">
                                            <h2><?php echo htmlspecialchars($alumni_name); ?></h2>
                                            <span style="font-size:11px"><?php echo htmlspecialchars($formatted_date); ?> &bull;
                                                <?php echo $time_ago; ?></span>
                                        </div>
                                        <div class="dropdown">
                                            <button class="btn btn-default btn-icon-notika dropdown-toggle" type="button"
                                                id="dropdownMenu<?php echo $forum_id; ?>" data-toggle="dropdown"
                                                aria-haspopup="true" aria-expanded="false">
                                                <i class="notika-icon notika-menu"></i>
                                            </button>
                                            <div class="dropdown-menu" aria-labelledby="dropdownMenu<?php echo $forum_id; ?>">
                                                <a class="dropdown-item" href="#">Edit</a>
                                                <a class="dropdown-item" href="#">Delete</a>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="content">
                                        <h1><?php echo htmlspecialchars($forum_post['forumName'] ?? 'Untitled'); ?></h1>
                                        <div class="description">
                                            <?php echo $forum_post['forumDescription'] ?? 'No description available'; ?>
                                        </div>
                                        <div class="comments-section">
                                            <div class="add-comment">
                                                <input type="text" class="comment-input" placeholder="Add a comment..."
                                                    data-forum-id="<?php echo $forum_id; ?>">
                                                <button class="add-comment-btn"
                                                    data-forum-id="<?php echo $forum_id; ?>">Post</button>
                                            </div>
                                            <div class="comment-list" id="comment-list-<?php echo $forum_id; ?>">
                                                <?php
                                                $all_comments = $firebase->retrieve("forum_comments");

                                                if ($all_comments === null) {
                                                    echo '<div class="no-comments">Unable to retrieve comments at this time.</div>';
                                                } else {
                                                    $all_comments = json_decode($all_comments, true);

                                                    if (!is_array($all_comments)) {
                                                        echo '<div class="no-comments">Error processing comments data.</div>';
                                                    } else {
                                                        $forum_comments = array_filter($all_comments, function ($comment) use ($forum_id) {
                                                            return isset($comment['forum_id']) && $comment['forum_id'] === $forum_id;
                                                        });

                                                        if ($forum_comments) {
                                                            foreach ($forum_comments as $comment_id => $comment) {
                                                                $commenter = $alumni_data[$comment['alumni_id']] ?? null;
                                                                $commenter_name = $commenter ? $commenter['firstname'] . ' ' . $commenter['lastname'] : 'Unknown Alumni';
                                                                $commenter_profile = $commenter['profile_url'] ?? '../images/profile.png';
                                                                ?>
                                                               <div class="comment" data-comment-id="<?php echo $comment_id; ?>">
                                                                    <div class="comment-author">
                                                                        <img src="<?php echo htmlspecialchars($commenter_profile); ?>"
                                                                            class="comment-avatar" alt="author">
                                                                        <span><?php echo htmlspecialchars($commenter_name); ?></span>
                                                                        &nbsp;&nbsp;&nbsp;
                                                                        <span
                                                                            class="comment-time"><?php echo time_elapsed_string($comment['date_commented']); ?></span>
                                                                    </div>
                                                                    <div class="comment-content">
                                                                        <?php echo htmlspecialchars($comment['comment']); ?>
                                                                    </div>
                                                                    <div class="reply-section">
                                                                        <button class="reply-btn"
                                                                            data-comment-id="<?php echo $comment_id; ?>">Reply</button>
                                                                        <div class="reply-input-area" style="display: none;">
                                                                            <input type="text" class="reply-input"
                                                                                placeholder="Write a reply...">
                                                                            <button class="submit-reply-btn"
                                                                                data-comment-id="<?php echo $comment_id; ?>">Submit</button>
                                                                        </div>
                                                                        <div class="reply-list">
                                                                            <!-- Replies go here -->
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <?php
                                                            }
                                                        } else {
                                                            echo '<div class="no-comments">No comments yet. Be the first to comment!</div>';
                                                        }
                                                    }
                                                }
                                                ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <?php
                            }
                        } else {
                            echo '<div class="no-forum-message" style="text-align:center; padding:20px; font-size:18px;">NO FORUM AVAILABLE AT THE MOMENT</div>';
                        }
                        ?>


                    </div>

                    <div class="col-lg-4 col-md-4 col-sm-5 col-xs-12">
                        <div class="right-section">
                            <!-- Event, Job, and Forum sections will be loaded here -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>





    <!-- Start Footer area-->
    <!-- End Footer area-->
    <!-- Scripts -->
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
    <script src="bootsrap/js/bootstrap.min.js"></script>
    <script src="../bower_components/ckeditor/ckeditor.js"></script>
    <script src="js/jquery/jquery-3.5.1.min.js"></script>

<script>
  $(document).ready(function () {
    initializeEventListeners();

    // Refresh comments for all forums every 5 seconds
    setInterval(function () {
        $('.sale-statistic-inner').each(function () {
            var forumId = $(this).find('.add-comment-btn').data('forum-id');
            if (forumId) {
                refreshComments(forumId);
            }
        });
    }, 5000);
});

function initializeEventListeners() {
    $(document).on('click', '.add-comment-btn', addComment);
    $(document).on('click', '.reply-btn', toggleReplyInput);
    $(document).on('click', '.submit-reply-btn', submitReply);
    $('#addForumForm').on('submit', addForumPost);
    $('#logoutBtn').on('click', handleLogout);
}

function refreshComments(forumId) {
    $.ajax({
        url: 'get_forum_comment.php',
        method: 'GET',
        data: { forum_id: forumId },
        success: function (response) {
            var $commentList = $('#comment-list-' + forumId);
            var $addCommentSection = $commentList.find('.add-comment').detach();
            
            // Store the state of reply input areas
            var replyStates = {};
            $commentList.find('.reply-input-area').each(function() {
                var commentId = $(this).closest('.comment').data('comment-id');
                replyStates[commentId] = $(this).is(':visible');
            });

            $commentList.html(response);
            $commentList.prepend($addCommentSection);

            // Restore the state of reply input areas
            $commentList.find('.reply-input-area').each(function() {
                var commentId = $(this).closest('.comment').data('comment-id');
                if (replyStates[commentId]) {
                    $(this).show();
                }
            });
        },
        error: function (xhr, status, error) {
            console.error('Error refreshing comments:', error);
        }
    });
}

function toggleReplyInput() {
    $(this).siblings('.reply-input-area').toggle();
}

function addComment() {
    var forumId = $(this).data('forum-id');
    var $input = $('.comment-input[data-forum-id="' + forumId + '"]');
    var commentContent = $input.val().trim();

    if (commentContent === "") {
        Swal.fire({
            title: 'Oops...',
            text: 'Please enter a comment before posting.',
            icon: 'warning',
            timer: 5000,
            showConfirmButton: false
        });
        return;
    }

    $.ajax({
        type: 'POST',
        url: 'comment_forum.php',
        data: {
            comment: commentContent,
            forum_id: forumId,
            alumni_id: '<?php echo $_SESSION['user']['id']; ?>'
        },
        dataType: 'json',
        success: function (response) {
            if (response.status === 'success') {
                $input.val('');
                refreshComments(forumId);
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
        error: function () {
            Swal.fire({
                title: 'Error',
                text: 'An error occurred while submitting your comment.',
                icon: 'error'
            });
        }
    });
}

function submitReply() {
    var commentId = $(this).data('comment-id');
    var replyContent = $(this).siblings('.reply-input').val().trim();
    var forumId = $(this).closest('.sale-statistic-inner').find('.add-comment-btn').data('forum-id');

    if (replyContent === "") {
        Swal.fire({
            title: 'Oops...',
            text: 'Please enter a reply before submitting.',
            icon: 'warning',
            timer: 3000,
            showConfirmButton: false
        });
        return;
    }

    $.ajax({
        url: 'reply_forum.php',
        method: 'POST',
        data: {
            forum_id: forumId,
            comment_id: commentId,
            reply: replyContent
        },
        success: function (response) {
            refreshComments(forumId);
            Swal.fire({
                title: 'Success!',
                text: 'Your reply has been added.',
                icon: 'success',
                timer: 2000,
                timerProgressBar: true
            });
        },
        error: function (xhr, status, error) {
            Swal.fire({
                title: 'Error',
                text: 'An error occurred while submitting your reply.',
                icon: 'error'
            });
        }
    });
}

function addForumPost(e) {
    e.preventDefault();

    $.ajax({
        url: 'forum_add.php',
        type: 'POST',
        data: $(this).serialize(),
        dataType: 'json',
        success: function (response) {
            if (response.status === 'success') {
                Swal.fire({
                    title: "Success!",
                    text: response.message,
                    icon: "success",
                    timer: 1500,
                    showConfirmButton: false
                });

                setTimeout(function () {
                    window.location.reload();
                }, 1500);
            } else {
                Swal.fire({
                    title: "Oops...",
                    text: response.message,
                    icon: "error",
                    timer: 3000,
                    showConfirmButton: true
                });
            }
        },
        error: function (jqXHR, textStatus, errorThrown) {
            console.error('AJAX error:', textStatus, errorThrown);
            Swal.fire({
                title: "Oops...",
                text: "Something went wrong! Error: " + textStatus,
                icon: "error",
                timer: 3000,
                showConfirmButton: true
            });
        }
    });
}

function handleLogout() {
    Swal.fire({
        title: "Are you sure?",
        text: "You will be directed to the main page!",
        icon: "warning",
        showCancelButton: true,
        confirmButtonText: "Yes, Logout!",
        cancelButtonText: "No, cancel!",
    }).then((result) => {
        if (result.isConfirmed) {
            Swal.fire("Logout!", "Logging out", "success").then(function () {
                window.location.href = '../logout.php';
            });
        } else {
            Swal.fire("Cancelled", "Your Logout is Cancelled :)", "error");
        }
    });
}
</script>
</body>

</html>
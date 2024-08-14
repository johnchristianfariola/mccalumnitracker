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
                    <img class="profile" src="<?php echo htmlspecialchars($profile_url); ?>" alt="profile image">
                </div>
                <div class="info-section">
                    <h2><?php echo htmlspecialchars($alumni_name); ?></h2>
                    <span style="font-size:11px"><?php echo htmlspecialchars($formatted_date); ?> &bull; <?php echo $time_ago; ?></span>
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
                        <button class="add-comment-btn" data-forum-id="<?php echo $forum_id; ?>">Post</button>
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
                                        <div class="comment">
                                            <div class="comment-author">
                                                <img src="<?php echo htmlspecialchars($commenter_profile); ?>"
                                                    class="comment-avatar" alt="author">
                                                <span><?php echo htmlspecialchars($commenter_name); ?></span>
                                                <span class="comment-time"><?php echo time_elapsed_string($comment['date_commented']); ?></span>
                                            </div>
                                            <div class="comment-content">
                                                <?php echo htmlspecialchars($comment['comment']); ?>
                                            </div>
                                            <div class="reply-section">
                                                <button class="reply-btn" data-comment-id="<?php echo $comment_id; ?>">Reply</button>
                                                <div class="reply-input-area" style="display: none;">
                                                    <input type="text" class="reply-input" placeholder="Write a reply...">
                                                    <button class="submit-reply-btn" data-comment-id="<?php echo $comment_id; ?>">Submit</button>
                                                </div>
                                                <div class="reply-list">
                                                    <?php 
                                                    if (isset($comment['replies'])) {
                                                        $replies = is_array($comment['replies']) ? $comment['replies'] : [$comment['replies']];
                                                        foreach ($replies as $reply_id => $reply):
                                                            $replier = $alumni_data[$reply['alumni_id']] ?? null;
                                                            $replier_name = $replier ? $replier['firstname'] . ' ' . $replier['lastname'] : 'Unknown Alumni';
                                                            ?>
                                                            <div class="reply">
                                                                <div class="reply-author">
                                                                    <span><?php echo htmlspecialchars($replier_name); ?></span>
                                                                    <span class="reply-time"><?php echo time_elapsed_string($reply['date_replied']); ?></span>
                                                                </div>
                                                                <div class="reply-content">
                                                                    <?php echo htmlspecialchars($reply['reply']); ?>
                                                                </div>
                                                            </div>
                                                        <?php 
                                                        endforeach;
                                                    }
                                                    ?>
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
        function submitForm() {
            // Sync CKEditor content before form submission
            for (var instanceName in CKEDITOR.instances) {
                CKEDITOR.instances[instanceName].updateElement();
            }
            return true;
        }

        $(function () {
            // Replace the <textarea id="editor1"> with a CKEditor instance
            CKEDITOR.replace('editor1');

            // Optional: If you want to prevent the form from submitting when pressing Enter in the CKEditor
            CKEDITOR.on('instanceReady', function (evt) {
                evt.editor.on('contentDom', function () {
                    evt.editor.document.on('keydown', function (event) {
                        if (event.data.getKeystroke() == 13) {
                            event.cancel();
                        }
                    });
                });
            });
        });

    </script>
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
    <script>
        $(document).ready(function () {
            $('#addForumForm').on('submit', function (e) {
                e.preventDefault();

                $.ajax({
                    url: 'forum_add.php',
                    type: 'POST',
                    data: $(this).serialize(),
                    dataType: 'json',
                    success: function (response) {
                        if (response.status === 'success') {
                            swal({
                                title: "Success!",
                                text: response.message,
                                type: "success",
                                timer: 1500,
                                showConfirmButton: false
                            });

                            // Refresh the page after the timer
                            setTimeout(function () {
                                window.location.reload();
                            }, 1500);
                        } else {
                            swal({
                                title: "Oops...",
                                text: response.message,
                                type: "error",
                                timer: 3000,
                                showConfirmButton: true
                            });

                            // Optional: Refresh the page after the error alert (comment out if not needed)
                            // setTimeout(function() {
                            //     window.location.reload();
                            // }, 3000);
                        }
                    },
                    error: function (jqXHR, textStatus, errorThrown) {
                        console.error('AJAX error:', textStatus, errorThrown);
                        swal({
                            title: "Oops...",
                            text: "Something went wrong! Error: " + textStatus,
                            type: "error",
                            timer: 3000,
                            showConfirmButton: true
                        });

                        // Optional: Refresh the page after the error alert (comment out if not needed)
                        // setTimeout(function() {
                        //     window.location.reload();
                        // }, 3000);
                    }
                });
            });
        });
    </script>


    <script>
        $(document).ready(function () {
            $('.add-comment-btn').click(function () {
                var forumId = $(this).data('forum-id');
                var $input = $('.comment-input[data-forum-id="' + forumId + '"]');
                var commentContent = $input.val().trim();

                if (commentContent === "") {
                    swal({
                        title: 'Oops...',
                        text: 'Please enter a comment before posting.',
                        type: 'warning',
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
            });


        });

        $(document).ready(function () {
            $('.reply-btn').click(function () {
                $(this).siblings('.reply-input-area').toggle();
            });

            $('.submit-reply-btn').click(function () {
    var commentId = $(this).data('comment-id');
    var replyContent = $(this).siblings('.reply-input').val();
    var forumId = $(this).closest('.sale-statistic-inner').find('.add-comment-btn').data('forum-id');

    $.ajax({
        url: 'reply_forum.php',
        method: 'POST',
        data: {
            forum_id: forumId,
            comment_id: commentId,
            reply: replyContent
        },
        success: function (response) {
            location.reload(); // Reload the page to show the new reply
        },
        error: function (xhr, status, error) {
            alert('Error: ' + error);
        }
    });
});
        });


    </script>

</body>

</html>
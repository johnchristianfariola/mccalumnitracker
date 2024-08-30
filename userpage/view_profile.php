<?php include '../includes/session.php'; ?>
<!DOCTYPE html>
<html>

<head>
    <?php include 'includes/header.php'; ?>

    <?php
    require_once '../includes/firebaseRDB.php';
    require_once '../includes/config.php';

    $firebase = new firebaseRDB($databaseURL);

    $alumni_data = $firebase->retrieve("alumni");
    $alumni_data = json_decode($alumni_data, true);

    $batchData = $firebase->retrieve("batch_yr");
    $batchData = json_decode($batchData, true);

    $forum_data = $firebase->retrieve("forum");
    $forum_data = json_decode($forum_data, true);

    $current_user_id = $_SESSION['alumni_id'];
    $current_user = $alumni_data[$current_user_id] ?? null;

    if (!$current_user) {
        echo "User not found";
        exit;
    }

    function getBatchYear($batchId, $batchData)
    {
        return $batchData[$batchId]['batch_yrs'] ?? 'Unknown';
    }

    function time_elapsed_string($datetime, $full = false)
    {
        $now = new DateTime('now', new DateTimeZone('Asia/Manila'));
        $ago = new DateTime($datetime, new DateTimeZone('Asia/Manila'));
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

    date_default_timezone_set('Asia/Manila');
    ?>
    <style>
        .post-row {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 15px;
        }

        .user-profile {
            display: flex;
            align-items: center;
        }

        .user-profile img {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            margin-right: 10px;
        }

        .post-content h3 {
            margin-bottom: 10px;
        }

        .activity-icons {
            display: flex;
            justify-content: space-around;
            padding: 10px 0;
            border-top: 1px solid #eee;
            border-bottom: 1px solid #eee;
        }

        .activity-icons div {
            display: flex;
            align-items: center;
            font-size: 14px;
            margin-right: 10px;
        }

        .activity-icons i {
            margin-right: 5px;
        }

        .comment-box {
            display: flex;
            align-items: center;
            margin-top: 10px;
        }

        .comment-box img {
            width: 35px;
            height: 35px;
            border-radius: 50%;
            margin-right: 10px;
        }

        .comment-box input {
            flex-grow: 1;
            border: none;
            padding: 10px;
            border-radius: 30px;
            background-color: #f0f2f5;
        }

        .comment-btn {
            border: none;
            background: none;
            color: #1877f2;
            font-size: 18px;
            cursor: pointer;
        }
    </style>
</head>

<body>

    <?php include 'includes/navbar.php'; ?>




    <!-----PROFILE PAGE---->
    <div class="profile-container">
        <div class="cover-img-container">
            <img id="coverPhoto" src="<?php echo htmlspecialchars($current_user['cover_photo_url']); ?>"
                alt="Profile Picture" class="cover-img"
                onerror="if (this.src != 'img/dafault_cover.jpg') this.src = 'img/dafault_cover.jpg';">


        </div>
        <div class="profile-details">
            <div class="pd-left">
                <div class="pd-row">
                    <!---PROFILE PICTURE-->

                    <img id="profileImage" class="pd-image"
                        src="<?php echo htmlspecialchars($current_user['profile_url']); ?>" alt="Profile Picture"
                        onerror="if (this.src != 'uploads/profile.jpg') this.src = 'uploads/profile.jpg';">


                    <div>

                        <h3><?php echo htmlspecialchars($current_user['firstname'] . ' ' . $current_user['middlename'] . ' ' . $current_user['lastname']); ?>
                        </h3>

                        <p>1.8K Followers - 120 Following</p>
                        <img src="../images/profile.jpg" alt="Joann">
                        <img src="../images/profile.jpg" alt="Jagdon">
                        <img src="../images/profile.jpg" alt="Alvie">
                        <img src="../images/profile.jpg" alt="Fredrick">

                    </div>


                </div>


            </div>
            <div class="pd-right">
                <a href="#"><i class="fas fa-ellipsis-v"></i></a>

            </div>

        </div>

        <div class="profile-info">
            <div class="info-col">
                <div class="profile-intro">
                    <h3>Bio</h3>
                    <p class="intro-text">
                        <?php echo html_entity_decode(htmlspecialchars($current_user['bio'], ENT_QUOTES, 'UTF-8'), ENT_QUOTES, 'UTF-8'); ?>
                    </p>
                    <button class="btn notika-btn-lightblue" style="width:100%">Edit Bio</button>
                    <hr>
                    <ul>
                        <li>
                            <h5>EDUCATION</h5>
                        </li>
                        <li><img src="../images/profile-study.png" alt="Study"> Studied At Madridejos Community College
                        <li><img src="../images/profile-study.png" alt="Study"> Alumni ID:
                            <?php echo htmlspecialchars($current_user['studentid']) ?>
                        <li><img src="../images/profile-study.png" alt="Study"> Batch Year:
                            <?php echo htmlspecialchars(getBatchYear($current_user['batch'], $batchData)) ?>
                        </li>

                        <li>
                            <h5>ABOUT</h5>
                        </li>
                        <li><img src="../images/profile-home.png" alt="Home">Currently Lives in
                            <?php echo htmlspecialchars($current_user['addressline1']) ?>
                        </li>
                        <li><img src="../images/profile-location.png" alt="Location"> From
                            <?php echo htmlspecialchars($current_user['barangay']) . ', ' . htmlspecialchars($current_user['city']) . ', ' . htmlspecialchars($current_user['state']) ?>
                        </li>
                        <li><img src="../images/confetti.png" alt="Birthday"> Birthday:
                            <?php $birthdate = htmlspecialchars($current_user['birthdate']);
                            $formatted_date = date("F j, Y", strtotime($birthdate));
                            echo $formatted_date; ?>
                        </li>
                        <li><img src="../images/gender.png" alt="Gender"> Gender:
                            <?php echo htmlspecialchars($current_user['gender']) ?>
                        </li>
                        <li>
                            <h5>Work Details </h5>
                        </li>
                        <li><i class="fas fa-briefcase icon"></i>&nbsp;&nbsp;&nbsp; Employment Status:&nbsp;<button
                                class="btn notika-btn-primary btn-sm"
                                style="background:gold; "><b><?php echo htmlspecialchars($current_user['work_status']) ?></b></button>
                        <li><i class="fas fa-briefcase icon"></i>&nbsp;&nbsp;&nbsp; Type of Work:&nbsp;
                            <?php echo htmlspecialchars($current_user['type_of_work']) ?></button>
                        <li><i class="fas fa-briefcase icon"></i>&nbsp;&nbsp;&nbsp; Work Postion:&nbsp;
                            <?php echo htmlspecialchars($current_user['work_position']) ?></button>

                    </ul>
                </div>

                <!------PHOTOS------->
                <!--  <div class="profile-intro">
                    <div class="title-box">
                        <h3>Photos</h3>
                        <a href="#">All Photos</a>
                    </div>
                    <div class="photo-box">
                        <div><img src="../images/profile.jpg" alt="Photo"></div>
                        <div><img src="../images/profile.jpg" alt="Photo"></div>
                        <div><img src="../images/profile.jpg" alt="Photo"></div>
                        <div><img src="../images/profile.jpg" alt="Photo"></div>
                        <div><img src="../images/profile.jpg" alt="Photo"></div>
                        <div><img src="../images/profile.jpg" alt="Photo"></div>
                    </div>
                </div>-->

                <!------FRIENDS-
                <div class="profile-intro">
                    <div class="title-box">
                        <h3>Friends</h3>
                        <a href="#">All Friends</a>
                    </div>
                    <p>120 (10 mutual)</p>
                    <div class="friends-box">
                        <div><img src="../images/profile.jpg" alt="Joann">
                            <p>Joann Rebamonte</p>
                        </div>
                        <div><img src="../images/profile.jpg" alt="John Carlo Jagdon">
                            <p>John Carlo Jagdon</p>
                        </div>
                        <div><img src="../images/profile.jpg" alt="Joann">
                            <p>Joann Rebamonte II</p>
                        </div>
                        <div><img src="../images/profile.jpg" alt="Fredrick">
                            <p>Fredrick Allan</p>
                        </div>
                        <div><img src="../images/profile.jpg" alt="Alvie">
                            <p>Alvie Thompson</p>
                        </div>
                        <div><img src="../images/profile.jpg" alt="Alex">
                            <p>Alex Smith</p>
                        </div>
                    </div>
                </div>------>
            </div>

            <div class="post-col">
                <div class="write-post-container">
                    <div class="user-profile">
                        <img src="../images/profile.jpg" alt="Profile Picture">
                        <div>
                            <p><?php echo htmlspecialchars($current_user['firstname'] . ' ' . $current_user['middlename'] . ' ' . $current_user['lastname']); ?>
                            </p>
                            <small><i class="fas fa-globe icon"></i> Public </small>
                        </div>
                    </div>

                    <div class="post-input-container">
                        <form method="POST" action="forum_add.php" onsubmit="return submitForm();">

                            <textarea rows="3" placeholder="What's on your mind, John?"></textarea>
                            <div class="add-post-links">

                                <button class="btn notika-btn-lightblue" href="#"><i
                                        class="fa fa-send"></i>&nbsp;&nbsp;Post</button>


                            </div>
                        </form>
                    </div>
                </div>

                <!-------POST SECTION----------->
                <?php
                $current_user_id = $_SESSION['alumni_id'];

                if (!empty($forum_data)) {
                    $user_forums = array_filter($forum_data, function ($forum, $forum_id) use ($current_user_id) {
                        return isset($forum['alumniId']) && $forum['alumniId'] === $current_user_id;
                    }, ARRAY_FILTER_USE_BOTH);

                    uasort($user_forums, function ($a, $b) {
                        return strtotime($b['createdAt']) - strtotime($a['createdAt']);
                    });

                    foreach ($user_forums as $forum_id => $forum) {
                        $created_at = isset($forum['createdAt']) ? new DateTime($forum['createdAt']) : new DateTime();
                        $formatted_date = $created_at->format('F j, Y, H:i A');
                        $time_ago = time_elapsed_string($created_at->format('Y-m-d H:i:s'));
                        ?>
                <div class="post-container" data-forum-id="<?php echo $forum_id; ?>">
                    <div class="post-row">
                        <div class="user-profile">
                            <img src="<?php echo htmlspecialchars($current_user['profile_url']); ?>"
                                alt="Profile Picture" onerror="this.src='uploads/profile.jpg';">
                            <div>
                                <p>
                                    <?php echo htmlspecialchars($current_user['firstname'] . ' ' . $current_user['lastname']); ?>
                                </p>
                                <span>
                                    <?php echo $formatted_date; ?> &bull;
                                    <?php echo $time_ago; ?>
                                </span>
                            </div>
                        </div>
                        <a href="#" class="post-options"><i class="fas fa-ellipsis-v"></i></a>
                    </div>

                    <div class="post-content">
                        <h3>
                            <?php echo htmlspecialchars($forum['forumName']); ?>
                        </h3>
                        <?php echo $forum['forumDescription']; ?>
                    </div>

                    <div class="post-row">
                        <div class="reaction-buttons">
                            <span class="reaction-btn" data-reaction="like">
                                <i class="fa fa-thumbs-up"></i> Like <span class="reaction-count">0</span>
                            </span>
                            <span class="reaction-btn" data-reaction="love">
                                <i class="fa fa-heart"></i> Love <span class="reaction-count">0</span>
                            </span>
                            <span class="reaction-btn" data-reaction="laugh">
                                <i class="fa fa-smile-o"></i> Haha <span class="reaction-count">0</span>
                            </span>
                            <span class="reaction-btn" data-reaction="wow">
                                <i class="fa fa-surprise"></i> Wow <span class="reaction-count">0</span>
                            </span>
                            <span class="reaction-btn" data-reaction="sad">
                                <i class="fa fa-sad-tear"></i> Sad <span class="reaction-count">0</span>
                            </span>
                            <span class="reaction-btn" data-reaction="angry">
                                <i class="fa fa-angry"></i> Angry <span class="reaction-count">0</span>
                            </span>
                        </div>
                    </div>

                    <div class="comments-section">
                        <div class="add-comment">
                            <input type="text" class="comment-input" placeholder="Add a comment..."
                                data-forum-id="<?php echo $forum_id; ?>">
                            <button class="add-comment-btn" data-forum-id="<?php echo $forum_id; ?>">Post</button>
                        </div>
                        <div class="comment-list" id="comment-list-<?php echo $forum_id; ?>">
                            <!-- Comments will be loaded here -->
                                </div>
                            </div>
                        </div>
                        <?php
                    }
                } else {
                    echo "<div class='post-container'><div class='post-content'><center><h4><i class='fa fa-wechat'></i> YOU DON'T HAVE DISCUSSION YET</h4></center></div></div>";
                }
                ?>



            </div>
        </div>
    </div>
    <?php include 'includes/profile_modal.php'; ?>
</body>

</html>

<script src="js/vendor/jquery-1.12.4.min.js"></script>
<script src="js/bootstrap.min.js"></script>
<script src="js/dialog/sweetalert2.min.js"></script>
<script src="js/dialog/dialog-active.js"></script>
<script src="js/main.js"></script>
<script src="../bower_components/ckeditor/ckeditor.js"></script>
<script src="js/jquery/jquery-3.5.1.min.js"></script>


<script>
    $(document).ready(function () {
        // Load initial reactions and comments
        $('.post-container').each(function () {
            var forumId = $(this).data('forum-id');
            loadReactions(forumId);
            loadComments(forumId);
        });

        // Handle reaction button clicks
        $(document).on('click', '.reaction-btn', function () {
            var $this = $(this);
            var forumId = $this.closest('.post-container').data('forum-id');
            var reactionType = $this.data('reaction');

            $.ajax({
                url: 'update_reaction_forum.php',
                method: 'POST',
                data: {
                    forum_id: forumId,
                    reaction_type: reactionType
                },
                success: function (response) {
                    var data = JSON.parse(response);
                    if (data.status === 'success') {
                        loadReactions(forumId);
                    }
                }
            });
        });

        // Handle comment submission
        $(document).on('click', '.add-comment-btn', function () {
            var $this = $(this);
            var forumId = $this.data('forum-id');
            var $input = $this.siblings('.comment-input');
            var commentContent = $input.val().trim();

            if (commentContent === "") {
                alert('Please enter a comment before posting.');
                return;
            }

            $.ajax({
                url: 'comment_forum.php',
                method: 'POST',
                data: {
                    comment: commentContent,
                    forum_id: forumId,
                    alumni_id: '<?php echo $_SESSION['alumni_id']; ?>'
                },
                success: function (response) {
                    var data = JSON.parse(response);
                    if (data.status === 'success') {
                        $input.val('');
                        loadComments(forumId);
                    }
                }
            });
        });

        // Handle reply button clicks
        $(document).on('click', '.reply-btn', function () {
            $(this).siblings('.reply-input-area').toggle();
        });

        // Handle reply submission
        $(document).on('click', '.submit-reply-btn', function () {
            var $this = $(this);
            var commentId = $this.data('comment-id');
            var $replyInput = $this.siblings('.reply-input');
            var replyContent = $replyInput.val().trim();
            var forumId = $this.closest('.post-container').data('forum-id');

            if (replyContent === "") {
                alert('Please enter a reply before submitting.');
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
                    var data = JSON.parse(response);
                    if (data.status === 'success') {
                        $replyInput.val('');
                        loadComments(forumId);
                    }
                }
            });
        });

        // Handle heart and dislike button clicks
        $(document).on('click', '.heart-btn, .dislike-btn', function () {
            var $this = $(this);
            var commentId = $this.data('comment-id');
            var action = $this.hasClass('heart-btn') ? 'like' : 'dislike';
            var forumId = $this.closest('.post-container').data('forum-id');

            $.ajax({
                url: 'update_heart_forum.php',
                method: 'POST',
                data: {
                    comment_id: commentId,
                    action: action
                },
                success: function (response) {
                    var data = JSON.parse(response);
                    if (data.status === 'success') {
                        loadComments(forumId);
                    }
                }
            });
        });

        function loadReactions(forumId) {
            $.ajax({
                url: 'get_forum_like_count.php',
                method: 'GET',
                data: { forum_id: forumId },
                success: function (response) {
                    var data = JSON.parse(response);
                    if (data.status === 'success') {
                        var $reactionButtons = $('.post-container[data-forum-id="' + forumId + '"] .reaction-buttons');
                        $.each(data.reaction_counts, function (reaction, count) {
                            $reactionButtons.find('[data-reaction="' + reaction + '"] .reaction-count').text(count);
                        });
                        $reactionButtons.find('.reaction-btn').removeClass('active');
                        if (data.user_reaction) {
                            $reactionButtons.find('[data-reaction="' + data.user_reaction + '"]').addClass('active');
                        }
                    }
                }
            });
        }

        function loadComments(forumId) {
            $.ajax({
                url: 'get_forum_comment.php',
                method: 'GET',
                data: { forum_id: forumId },
                success: function (response) {
                    var $commentList = $('#comment-list-' + forumId);

                    // Store the state of reply inputs and their visibility
                    var replyStates = {};
                    $commentList.find('.reply-input-area').each(function () {
                        var commentId = $(this).data('comment-id');
                        replyStates[commentId] = {
                            isVisible: $(this).is(':visible'),
                            content: $(this).find('.reply-input').val()
                        };
                    });

                    // Update the comment list
                    $commentList.html(response);

                    // Restore the state of reply inputs and their visibility
                    $commentList.find('.reply-input-area').each(function () {
                        var commentId = $(this).data('comment-id');
                        if (replyStates[commentId]) {
                            if (replyStates[commentId].isVisible) {
                                $(this).show();
                            } else {
                                $(this).hide();
                            }
                            $(this).find('.reply-input').val(replyStates[commentId].content);
                        }
                    });
                }
            });
        }

        function refreshAllComments() {
            $('.post-container').each(function () {
                var forumId = $(this).data('forum-id');
                loadComments(forumId);
            });
        }

        // Use a variable to store the interval ID
        var refreshInterval;

        // Function to start the refresh interval
        function startRefreshInterval() {
            refreshInterval = setInterval(refreshAllComments, 10000);
        }

        // Function to stop the refresh interval
        function stopRefreshInterval() {
            clearInterval(refreshInterval);
        }

        // Start the refresh interval initially
        startRefreshInterval();

        // Pause refresh when user is typing in any input
        $(document).on('focus', '.comment-input, .reply-input', function () {
            stopRefreshInterval();
        });

        // Resume refresh when user is done typing (input loses focus)
        $(document).on('blur', '.comment-input, .reply-input', function () {
            startRefreshInterval();
        });
    });
</script>
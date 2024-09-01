<?php
require_once '../includes/firebaseRDB.php';
require_once '../includes/config.php';

$firebase = new firebaseRDB($databaseURL);

$alumni_data = $firebase->retrieve("alumni");
$alumni_data = json_decode($alumni_data, true);

// Extract alumni names and IDs
$alumni_info = [];
foreach ($alumni_data as $id => $alumni) {
    if (isset($alumni['status']) && $alumni['status'] === 'verified') {
        $alumni_info[] = [
            'id' => $id,
            'name' => $alumni['firstname'] . ' ' . $alumni['lastname'],
            'profile_url' => isset($alumni['profile_url']) ? $alumni['profile_url'] : '../images/profile.jpg',
            'status' => $alumni['status']
        ];
    }
}

// Convert alumni info to JSON for JavaScript use
$alumni_info_json = json_encode($alumni_info);

// Fetch notifications
$current_user_id = $_SESSION['user']['id']; // Assuming you have the user's ID in the session
$notifications = getNotifications($firebase, $current_user_id);
$notification_count = count($notifications);

function getNotifications($firebase, $current_user_id)
{
    $notifications = [];

    // Fetch news comments
    $news_comments = $firebase->retrieve("news_comments");
    $news_comments = json_decode($news_comments, true);

    // Fetch event comments
    $event_comments = $firebase->retrieve("event_comments");
    $event_comments = json_decode($event_comments, true);

    // Fetch job comments
    $job_comments = $firebase->retrieve("job_comments");
    $job_comments = json_decode($job_comments, true);

    // Fetch forum posts
    $forum_posts = $firebase->retrieve("forum");
    $forum_posts = json_decode($forum_posts, true);

    // Fetch forum comments
    $forum_comments = $firebase->retrieve("forum_comments");
    $forum_comments = json_decode($forum_comments, true);

    // Process news comments
    processComments($firebase, $current_user_id, $news_comments, $notifications, 'news');

    // Process event comments
    processComments($firebase, $current_user_id, $event_comments, $notifications, 'event');

    // Process job comments
    processComments($firebase, $current_user_id, $job_comments, $notifications, 'job');

    // Process forum posts and comments
    processForumNotifications($firebase, $current_user_id, $forum_posts, $forum_comments, $notifications);

    // Sort notifications by date, most recent first
    usort($notifications, function ($a, $b) {
        return strtotime($b['date']) - strtotime($a['date']);
    });

    return $notifications;
}

function processComments($firebase, $current_user_id, $comments, &$notifications, $type)
{
    if (!is_array($comments)) {
        return; // Exit the function if $comments is not an array
    }

    foreach ($comments as $comment_id => $comment) {
        // Notifications for replies
        if (isset($comment['alumni_id']) && $comment['alumni_id'] == $current_user_id && isset($comment['replies']) && is_array($comment['replies'])) {
            foreach ($comment['replies'] as $reply_id => $reply) {
                if (isset($reply['alumni_id']) && $reply['alumni_id'] != $current_user_id) {
                    $replier_data = $firebase->retrieve("alumni/" . $reply['alumni_id']);
                    $replier_data = json_decode($replier_data, true);
                    if ($replier_data) {
                        $replier_name = $replier_data['firstname'] . ' ' . $replier_data['lastname'];
                        $replier_profile = isset($replier_data['profile_url']) ? $replier_data['profile_url'] : '../images/profile.jpg';

                        $notifications[] = [
                            'type' => 'reply',
                            'content_type' => $type,
                            'replier_name' => $replier_name,
                            'replier_profile' => $replier_profile,
                            'date' => $reply['date_replied'],
                            'comment_id' => $comment_id,
                            $type . '_id' => $comment[$type . '_id']
                        ];
                    }
                }
            }
        }

        // Notifications for reactions
        if (isset($comment['alumni_id']) && $comment['alumni_id'] == $current_user_id && isset($comment['liked_by']) && is_array($comment['liked_by'])) {
            foreach ($comment['liked_by'] as $reactor_id) {
                if ($reactor_id != $current_user_id) {
                    $reactor_data = $firebase->retrieve("alumni/" . $reactor_id);
                    $reactor_data = json_decode($reactor_data, true);
                    if ($reactor_data) {
                        $reactor_name = $reactor_data['firstname'] . ' ' . $reactor_data['lastname'];
                        $reactor_profile = isset($reactor_data['profile_url']) ? $reactor_data['profile_url'] : '../images/profile.jpg';

                        $notifications[] = [
                            'type' => 'reaction',
                            'content_type' => $type,
                            'reactor_name' => $reactor_name,
                            'reactor_profile' => $reactor_profile,
                            'date' => date('Y-m-d H:i:s'),
                            'comment_id' => $comment_id,
                            $type . '_id' => $comment[$type . '_id']
                        ];
                    }
                }
            }
        }
    }
}

function processForumNotifications($firebase, $current_user_id, $forum_posts, $forum_comments, &$notifications)
{
    // Process forum post reactions
    if (is_array($forum_posts)) {
        foreach ($forum_posts as $post_id => $post) {
            if (isset($post['alumniId']) && $post['alumniId'] == $current_user_id && isset($post['reactions']) && is_array($post['reactions'])) {
                foreach ($post['reactions'] as $reaction_type => $reactors) {
                    if (is_array($reactors)) {
                        foreach ($reactors as $reactor_id => $reaction_date) {
                            if ($reactor_id != $current_user_id) {
                                $reactor_data = $firebase->retrieve("alumni/" . $reactor_id);
                                $reactor_data = json_decode($reactor_data, true);
                                if ($reactor_data) {
                                    $reactor_name = $reactor_data['firstname'] . ' ' . $reactor_data['lastname'];
                                    $reactor_profile = isset($reactor_data['profile_url']) ? $reactor_data['profile_url'] : '../images/profile.jpg';

                                    $notifications[] = [
                                        'type' => 'forum_post_reaction',
                                        'content_type' => 'forum',
                                        'reactor_name' => $reactor_name,
                                        'reactor_profile' => $reactor_profile,
                                        'date' => $reaction_date,
                                        'post_id' => $post_id,
                                        'reaction_type' => $reaction_type
                                    ];
                                }
                            }
                        }
                    }
                }
            }
        }
    }

    // Process forum comments and replies
    if (is_array($forum_comments)) {
        foreach ($forum_comments as $comment_id => $comment) {
            // Notifications for comments on user's posts
            if (isset($forum_posts[$comment['forum_id']]) && 
                isset($forum_posts[$comment['forum_id']]['alumniId']) && 
                $forum_posts[$comment['forum_id']]['alumniId'] == $current_user_id && 
                isset($comment['alumni_id']) && 
                $comment['alumni_id'] != $current_user_id) {
                $commenter_data = $firebase->retrieve("alumni/" . $comment['alumni_id']);
                $commenter_data = json_decode($commenter_data, true);
                if ($commenter_data) {
                    $commenter_name = $commenter_data['firstname'] . ' ' . $commenter_data['lastname'];
                    $commenter_profile = isset($commenter_data['profile_url']) ? $commenter_data['profile_url'] : '../images/profile.jpg';

                    $notifications[] = [
                        'type' => 'forum_comment',
                        'content_type' => 'forum',
                        'commenter_name' => $commenter_name,
                        'commenter_profile' => $commenter_profile,
                        'date' => $comment['date_commented'],
                        'post_id' => $comment['forum_id'],
                        'comment_id' => $comment_id
                    ];
                }
            }

            // Notifications for replies to user's comments
            if (isset($comment['alumni_id']) && $comment['alumni_id'] == $current_user_id && isset($comment['replies']) && is_array($comment['replies'])) {
                foreach ($comment['replies'] as $reply_id => $reply) {
                    if (isset($reply['alumni_id']) && $reply['alumni_id'] != $current_user_id) {
                        $replier_data = $firebase->retrieve("alumni/" . $reply['alumni_id']);
                        $replier_data = json_decode($replier_data, true);
                        if ($replier_data) {
                            $replier_name = $replier_data['firstname'] . ' ' . $replier_data['lastname'];
                            $replier_profile = isset($replier_data['profile_url']) ? $replier_data['profile_url'] : '../images/profile.jpg';

                            $notifications[] = [
                                'type' => 'forum_reply',
                                'content_type' => 'forum',
                                'replier_name' => $replier_name,
                                'replier_profile' => $replier_profile,
                                'date' => $reply['date_replied'],
                                'post_id' => $reply['forum_id'],
                                'comment_id' => $comment_id,
                                'reply_id' => $reply_id
                            ];
                        }
                    }
                }
            }

            // Notifications for reactions to user's comments
            if (isset($comment['alumni_id']) && $comment['alumni_id'] == $current_user_id && isset($comment['liked_by']) && is_array($comment['liked_by'])) {
                foreach ($comment['liked_by'] as $reactor_id) {
                    if ($reactor_id != $current_user_id) {
                        $reactor_data = $firebase->retrieve("alumni/" . $reactor_id);
                        $reactor_data = json_decode($reactor_data, true);
                        if ($reactor_data) {
                            $reactor_name = $reactor_data['firstname'] . ' ' . $reactor_data['lastname'];
                            $reactor_profile = isset($reactor_data['profile_url']) ? $reactor_data['profile_url'] : '../images/profile.jpg';

                            $notifications[] = [
                                'type' => 'forum_comment_reaction',
                                'content_type' => 'forum',
                                'reactor_name' => $reactor_name,
                                'reactor_profile' => $reactor_profile,
                                'date' => date('Y-m-d H:i:s'),
                                'post_id' => $comment['forum_id'],
                                'comment_id' => $comment_id
                            ];
                        }
                    }
                }
            }
        }
    }
}

function getTimeAgo($date)
{
    $time_ago = strtotime($date);
    $current_time = time();
    $time_difference = $current_time - $time_ago;
    $seconds = $time_difference;

    $minutes = round($seconds / 60);
    $hours = round($seconds / 3600);
    $days = round($seconds / 86400);
    $weeks = round($seconds / 604800);
    $months = round($seconds / 2629440);
    $years = round($seconds / 31553280);

    if ($seconds <= 60) {
        return "Just now";
    } else if ($minutes <= 60) {
        return ($minutes == 1) ? "1 minute ago" : "$minutes minutes ago";
    } else if ($hours <= 24) {
        return ($hours == 1) ? "1 hour ago" : "$hours hours ago";
    } else if ($days <= 7) {
        return ($days == 1) ? "1 day ago" : "$days days ago";
    } else if ($weeks <= 4.3) {
        return ($weeks == 1) ? "1 week ago" : "$weeks weeks ago";
    } else if ($months <= 12) {
        return ($months == 1) ? "1 month ago" : "$months months ago";
    } else {
        return ($years == 1) ? "1 year ago" : "$years years ago";
    }
}

$current_page = $_SERVER['PHP_SELF'];

function isActive($page)
{
    global $current_page;
    if ($page == 'index.php') {
        return $current_page == '/index.php';
    } else {
        return strpos($current_page, $page) !== false;
    }
}
?>


<nav>
    <div class="nav-left">
        <img src="../images/logo/alumni_logo.png" class="logo">
        <div class="search-box">
            <img src="../images/search.png">
            <input type="text" id="myInput" placeholder="Search">
            <div id="autocomplete-list" class="autocomplete-items"></div>
        </div>
    </div>

    <div class="nav-center">
        <ul>
            <a href="index.php" class="<?php echo isActive('index.php') ? 'line-bottom-visited' : ''; ?>">
                <li class="line1 <?php echo isActive('index.php') ? 'border-line-bottom' : ''; ?>">
                    <img src="../images/logo/home1.png" alt="">
                </li>
            </a>
            <a href="view_news.php" class="<?php echo isActive('view_news') ? 'line-bottom-visited' : ''; ?>">
                <li class="line1 <?php echo isActive('view_news') ? 'border-line-bottom' : ''; ?>">
                    <img src="../images/logo/newspaper.png" alt="">
                </li>
            </a>
            <a href="event_view.php" class="<?php echo isActive('event') ? 'line-bottom-visited' : ''; ?>">
                <li class="line1 <?php echo isActive('event') ? 'border-line-bottom' : ''; ?>">
                    <img src="../images/logo/calendar.png" alt="">
                </li>
            </a>
            <a href="job_view.php" class="<?php echo isActive('job') ? 'line-bottom-visited' : ''; ?>">
                <li class="line1 <?php echo isActive('job') ? 'border-line-bottom' : ''; ?>">
                    <img src="../images/logo/suitcase.png" alt="">
                </li>
            </a>
            <a href="forum.php" class="<?php echo isActive('forum') ? 'line-bottom-visited' : ''; ?>">
                <li class="line1 <?php echo isActive('forum') ? 'border-line-bottom' : ''; ?>">
                    <img src="../images/logo/chat.png" alt="">
                </li>
            </a>
            <a href="view_gallery.php" class="<?php echo isActive('gallery') ? 'line-bottom-visited' : ''; ?>">
                <li class="line1 <?php echo isActive('gallery') ? 'border-line-bottom' : ''; ?>">
                    <img src="../images/logo/photo-gallery.png" alt="">
                </li>
            </a>
        </ul>
    </div>
    <div class="nav-right">
        <ul>
            <div class="background-circle">
                <a href="home.php">
                    <li class=""><img src="../images/logo/messenger_black.png" alt=""></li>
                </a>
            </div>
            <div class="background-circle">
                <div class="notification-icon" onclick="notificationMenuToggle()">
                    <img src="../images/logo/bell_black.png" alt="">
                    <span class="notification-count"><?php echo $notification_count; ?></span>
                </div>
            </div>
            <div class="background-circle">
            </div>
        </ul>

        <div class="nav-user-icon online" onclick="settingsMenuToggle()">
            <?php
            if (isset($_SESSION['user']) && isset($_SESSION['user']['id'])) {
                $user_id = $_SESSION['user']['id'];
                $user_data = $alumni_data[$user_id];
                $profile_url = isset($user_data['profile_url']) ? $user_data['profile_url'] : '../images/profile.jpg';
                echo '<img src="' . $profile_url . '" alt="Profile Picture" onerror="if (this.src != \'uploads/profile.jpg\') this.src = \'uploads/profile.jpg\';">';
            }
            ?>
        </div>
    </div>

    <!------------------SETTINGS MENU------------------>
    <div class="settings-menu">
        <div id="dark-btn">
            <span></span>
        </div>

        <div class="settings-menu-inner">
            <div class="user-profile">
                <?php
                if (isset($_SESSION['user']) && isset($_SESSION['user']['id'])) {
                    $user_id = $_SESSION['user']['id'];
                    $user_data = $alumni_data[$user_id];
                    $profile_url = isset($user_data['profile_url']) ? $user_data['profile_url'] : 'upload/profile.jpg';
                    $full_name = $user_data['firstname'] . ' ' . $user_data['lastname'];
                    echo '<img src="' . $profile_url . '" alt="Profile Picture" onerror="if (this.src != \'uploads/profile.jpg\') this.src = \'uploads/profile.jpg\';">';

                    echo '<div class="">';
                    echo '<p>' . $full_name . '</p>';
                    echo '<a href="view_profile.php">See your profile</a>';
                    echo '</div>';
                } else {
                    echo '<img src="upload/default-pp.png" alt="Default Profile Picture">';
                    echo '<div class="">';
                    echo '<p>Guest User</p>';
                    echo '<a href="login.php">Login to see your profile</a>';
                    echo '</div>';
                }
                ?>
            </div>
            <hr>
            <div class="settings-links">
                <img src="../images/setting.png" class="settings-icon">
                <a href="profile_overview.php">Settings & Privacy <img src="../images/arrow.png" width="10px"></a>
            </div>
            <div class="settings-links">
                <img src="../images/help.png" class="settings-icon">
                <a href="">Help & Support <img src="../images/arrow.png" width="10px"></a>
            </div>
            <div class="settings-links">
                <img src="../images/display.png" class="settings-icon">
                <a href="">Display & Access <img src="../images/arrow.png" width="10px"></a>
            </div>
            <div class="settings-links">
                <img src="../images/logout.png" class="settings-icon">
                <a href="../logout.php">Logout <img src="../images/arrow.png" width="10px"></a>
            </div>
        </div>
    </div>

    <!------------NOTIFICATION-------------------->
    <div class="notification-menu">
        <div class="notification-menu-inner">
            <h3>Notifications</h3>
            <?php if (!empty($notifications)): ?>
                <?php foreach ($notifications as $notification): ?>
                    <div class="notification-item">
                        <?php switch ($notification['type']):
                            case 'reply': ?>
                                <img src="<?php echo $notification['replier_profile']; ?>" alt="User Avatar">
                                <div class="notification-info">
                                    <p><strong><?php echo $notification['replier_name']; ?></strong> replied to your comment on a
                                        <?php echo $notification['content_type']; ?></p>
                                    <span class="notification-time"><?php echo getTimeAgo($notification['date']); ?></span>
                                </div>
                                <?php break;
                            case 'reaction': ?>
                                <img src="<?php echo $notification['reactor_profile']; ?>" alt="User Avatar">
                                <div class="notification-info">
                                    <p><strong><?php echo $notification['reactor_name']; ?></strong> reacted to your comment on a
                                        <?php echo $notification['content_type']; ?></p>
                                    <span class="notification-time"><?php echo getTimeAgo($notification['date']); ?></span>
                                </div>
                                <?php break;
                            case 'forum_post_reaction': ?>
                                <img src="<?php echo $notification['reactor_profile']; ?>" alt="User Avatar">
                                <div class="notification-info">
                                    <p><strong><?php echo $notification['reactor_name']; ?></strong> reacted with
                                        <?php echo $notification['reaction_type']; ?> to your forum post</p>
                                    <span class="notification-time"><?php echo getTimeAgo($notification['date']); ?></span>
                                </div>
                                <?php break;
                            case 'forum_comment': ?>
                                <img src="<?php echo $notification['commenter_profile']; ?>" alt="User Avatar">
                                <div class="notification-info">
                                    <p><strong><?php echo $notification['commenter_name']; ?></strong> commented on your forum post</p>
                                    <span class="notification-time"><?php echo getTimeAgo($notification['date']); ?></span>
                                </div>
                                <?php break;
                            case 'forum_reply': ?>
                                <img src="<?php echo $notification['replier_profile']; ?>" alt="User Avatar">
                                <div class="notification-info">
                                    <p><strong><?php echo $notification['replier_name']; ?></strong> replied to your comment in a forum
                                    </p>
                                    <span class="notification-time"><?php echo getTimeAgo($notification['date']); ?></span>
                                </div>
                                <?php break;
                            case 'forum_comment_reaction': ?>
                                <img src="<?php echo $notification['reactor_profile']; ?>" alt="User Avatar">
                                <div class="notification-info">
                                    <p><strong><?php echo $notification['reactor_name']; ?></strong> reacted to your comment in a forum
                                    </p>
                                    <span class="notification-time"><?php echo getTimeAgo($notification['date']); ?></span>
                                </div>
                                <?php break;
                        endswitch; ?>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <p>No new notifications</p>
            <?php endif; ?>
            <a href="all_notifications.php" class="view-all-notifications">View All Notifications</a>
        </div>
    </div>

</nav>

<script>
    var settingsmenu = document.querySelector(".settings-menu");
    var darkBtn = document.getElementById("dark-btn");

    function settingsMenuToggle() {
        settingsmenu.classList.toggle("settings-menu-height");
    }
    darkBtn.onclick = function () {
        darkBtn.classList.toggle("dark-btn-on");
        document.body.classList.toggle("dark-theme");

        if (localStorage.getItem("theme") == "light") {
            localStorage.setItem("theme", "dark");
        } else {
            localStorage.setItem("theme", "light");
        }
    }

    if (localStorage.getItem("theme") == "light") {
        darkBtn.classList.remove("dark-btn-on");
        document.body.classList.remove("dark-theme");
    } else if (localStorage.getItem("theme") == "dark") {
        darkBtn.classList.add("dark-btn-on");
        document.body.classList.add("dark-theme");
    } else {
        localStorage.setItem("theme", "dark");
    }
</script>


<script>
    // Use PHP to inject alumni info into JavaScript
    const alumniInfo = <?php echo $alumni_info_json; ?>;

    const input = document.getElementById("myInput");
    const autocompleteList = document.getElementById("autocomplete-list");

    input.addEventListener("input", function () {
        const value = this.value.toLowerCase();
        autocompleteList.innerHTML = "";

        if (!value) return;

        const matchingAlumni = alumniInfo.filter(alumni =>
            alumni.name.toLowerCase().includes(value)
        ).slice(0, 5); // Limit to 5 results

        matchingAlumni.forEach(alumni => {
            const div = document.createElement("div");
            div.className = "autocomplete-item";
            div.innerHTML = `
            <img src="${alumni.profile_url}" alt="${alumni.name}" >
            <div class="autocomplete-item-info">
                <span class="autocomplete-item-name">${alumni.name}</span>
                <span class="autocomplete-item-details">Alumni</span>
            </div>
        `;
            div.addEventListener("click", function () {
                input.value = alumni.name;
                autocompleteList.innerHTML = "";
                // Redirect to the alumni's profile
                window.location.href = `view_alumni_details.php?id=${alumni.id}`;
            });
            autocompleteList.appendChild(div);
        });
    });

    document.addEventListener("click", function (e) {
        if (e.target !== input) {
            autocompleteList.innerHTML = "";
        }
    });

    // Add event listener for Enter key press
    input.addEventListener("keypress", function (event) {
        if (event.key === "Enter") {
            event.preventDefault();
            const searchQuery = input.value.trim();
            if (searchQuery) {
                window.location.href = `search_results.php?query=${encodeURIComponent(searchQuery)}`;
            }
        }
    });
</script>
<script>
    var notificationMenu = document.querySelector(".notification-menu");

    function notificationMenuToggle() {
        notificationMenu.classList.toggle("notification-menu-height");
    }

    // Close the notification menu when clicking outside
    document.addEventListener("click", function (event) {
        if (!event.target.closest('.notification-icon') && !event.target.closest('.notification-menu')) {
            notificationMenu.classList.remove("notification-menu-height");
        }
    });

    function updateNotificationCount() {
        const count = document.querySelectorAll('.notification-item').length;
        const countElement = document.querySelector('.notification-count');
        countElement.textContent = count;
        countElement.style.display = count > 0 ? 'block' : 'none';
    }

    // Call this function after loading notifications
    updateNotificationCount();

</script>
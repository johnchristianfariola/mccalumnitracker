<?php require_once 'navbar_php_script.php'; ?>
<?php require_once 'navbar_js_script.php'; ?>




<nav>
    <div class="nav-left">
        <img src="../images/logo/alumni_logo.png" class="logo">
        <div class="search-box">
            <img src="../images/search.png">
            <input type="text" id="myInput" placeholder="Search" autocomplete="off">
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
                <div class="message-icon" onclick="messageMenuToggle(event)">
                    <img src="../images/logo/messenger_black.png" alt="">
                    <div class="message-count"></div>
                </div>
            </div>


            <div class="background-circle">
                <div class="notification-icon" onclick="notificationMenuToggle()">
                    <img src="../images/logo/bell_black.png" alt="">
                    <div class="notification-count" style="display: none;">0</div>
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
                    <div class="notification-item" data-href="<?php
                    switch ($notification['type']):
                        case 'reply':
                        case 'reaction':
                            switch ($notification['content_type']):
                                case 'news':
                                    echo htmlspecialchars('visit_news.php?id=' . $notification['news_id'] . '#comment-' . $notification['comment_id']);
                                    break;
                                case 'job':
                                    echo htmlspecialchars('visit_job.php?id=' . $notification['job_id'] . '#comment-' . $notification['comment_id']);
                                    break;
                                case 'event':
                                    echo htmlspecialchars('visit_event.php?id=' . $notification['event_id'] . '#comment-' . $notification['comment_id']);
                                    break;
                                default:
                                    echo htmlspecialchars($notification['content_type'] . '.php?id=' . $notification[$notification['content_type'] . '_id'] . '#comment-' . $notification['comment_id']);
                            endswitch;
                            break;
                        case 'forum_post_reaction':
                            echo htmlspecialchars('forum.php?id=' . $notification['post_id']);
                            break;
                        case 'forum_comment':
                        case 'forum_reply':
                        case 'forum_comment_reaction':
                            echo htmlspecialchars('forum.php?id=' . $notification['post_id'] . '#comment-' . $notification['comment_id']);
                            break;
                        case 'admin_job':
                            echo htmlspecialchars('visit_job.php?id=' . $notification['id']);
                            break;
                        case 'admin_event':
                        case 'event_invitation':
                            echo htmlspecialchars('visit_event.php?id=' . $notification['id']);
                            break;
                        case 'admin_news':
                            echo htmlspecialchars('visit_news.php?id=' . $notification['id']);
                            break;
                        case 'admin_gallery':
                            echo htmlspecialchars('view_gallery.php?id=' . $notification['id']);
                            break;
                        default:
                            echo '#';
                    endswitch;
                    ?>">
                        <?php
                        // Determine image source based on notification type
                        switch ($notification['type']):
                            case 'reply':
                                $imageSrc = $notification['replier_profile'] ?? '../images/logo/notification.png';
                                break;
                            case 'reaction':
                            case 'forum_post_reaction':
                            case 'forum_comment_reaction':
                                $imageSrc = $notification['reactor_profile'] ?? '../images/logo/notification.png';
                                break;
                            case 'forum_comment':
                                $imageSrc = $notification['commenter_profile'] ?? '../images/logo/notification.png';
                                break;
                            case 'forum_reply':
                                $imageSrc = $notification['replier_profile'] ?? '../images/logo/notification.png';
                                break;
                            case 'admin_job':
                                $imageSrc = '../images/logo/suitcase.png';
                                break;
                            case 'admin_event':
                            case 'event_invitation':
                                $imageSrc = '../images/logo/calendar.png';
                                break;
                            case 'admin_news':
                                $imageSrc = '../images/logo/newspaper.png';
                                break;
                            case 'admin_gallery':
                                $imageSrc = '../images/logo/photo-gallery.png';
                                break;
                            default:
                                $imageSrc = '../images/logo/notification.png';
                        endswitch;
                        ?>
                        <img src="<?php echo htmlspecialchars($imageSrc); ?>" alt="Notification Icon">

                        <div class="notification-info">
                            <p>
                                <?php
                                switch ($notification['type']):
                                    case 'reply':
                                        echo '<strong>' . htmlspecialchars($notification['replier_name']) . '</strong> replied to your comment on a ' . htmlspecialchars($notification['content_type']);
                                        break;
                                    case 'reaction':
                                        echo '<strong>' . htmlspecialchars($notification['reactor_name']) . '</strong> reacted to your comment on a ' . htmlspecialchars($notification['content_type']);
                                        break;
                                    case 'forum_post_reaction':
                                        echo '<strong>' . htmlspecialchars($notification['reactor_name']) . '</strong> reacted with ' . htmlspecialchars($notification['reaction_type']) . ' to your forum post';
                                        break;
                                    case 'forum_comment':
                                        echo '<strong>' . htmlspecialchars($notification['commenter_name']) . '</strong> commented on your forum post';
                                        break;
                                    case 'forum_reply':
                                        echo '<strong>' . htmlspecialchars($notification['replier_name']) . '</strong> replied to your comment in a forum';
                                        break;
                                    case 'forum_comment_reaction':
                                        echo '<strong>' . htmlspecialchars($notification['reactor_name']) . '</strong> reacted to your comment in a forum';
                                        break;
                                    case 'admin_job':
                                        echo 'New job posting: <strong>' . htmlspecialchars($notification['title']) . '</strong>';
                                        break;
                                    case 'admin_event':
                                        echo 'New event: <strong>' . htmlspecialchars($notification['title']) . '</strong>';
                                        break;
                                    case 'admin_news':
                                        echo 'New news article: <strong>' . htmlspecialchars($notification['title']) . '</strong>';
                                        break;
                                    case 'admin_gallery':
                                        echo 'New gallery album: <strong>' . htmlspecialchars($notification['title']) . '</strong>';
                                        break;
                                    case 'event_invitation':
                                        echo 'You\'re invited to the event: <strong>' . htmlspecialchars($notification['title']) . '</strong>';
                                        break;
                                    default:
                                        echo 'New notification: <strong>' . htmlspecialchars($notification['title']) . '</strong>';
                                endswitch;
                                ?>
                            </p>
                            <span
                                class="notification-time"><?php echo htmlspecialchars(getTimeAgo($notification['date'])); ?></span>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <p class="no-notifications">No new notifications</p>
            <?php endif; ?>
            <a href="all_notifications.php" class="view-all-notifications">View All Notifications</a>
        </div>
    </div>


    <!----------MESSAGE-------------->


    <div class="message-menu" id="messageMenu">
        <div class="message-menu-inner">
            <div class="message-header">
                <h3>Messages</h3>
            </div>
            <hr>
            <div class="message-items-container" id="messageItemsContainer">
                <!-- Messages will be dynamically loaded here -->
            </div>
            <a href="view_all_messages.php" class="view-all-messages">View All Messages</a>
        </div>
    </div>

</nav>

<?php include 'navbar_php_script.php';?>


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
                            case 'admin_job': ?>
                                <img src="../images/logo/suitcase.png" alt="Job Icon">
                                <div class="notification-info">
                                    <p>New job posting: <strong><?php echo $notification['title']; ?></strong></p>
                                    <span class="notification-time"><?php echo getTimeAgo($notification['date']); ?></span>
                                </div>
                                <?php break;
                            case 'admin_event': ?>
                                <img src="../images/logo/calendar.png" alt="Event Icon">
                                <div class="notification-info">
                                    <p>New event: <strong><?php echo $notification['title']; ?></strong></p>
                                    <span class="notification-time"><?php echo getTimeAgo($notification['date']); ?></span>
                                </div>
                                <?php break;
                            case 'admin_news': ?>
                                <img src="../images/logo/newspaper.png" alt="News Icon">
                                <div class="notification-info">
                                    <p>New news article: <strong><?php echo $notification['title']; ?></strong></p>
                                    <span class="notification-time"><?php echo getTimeAgo($notification['date']); ?></span>
                                </div>
                                <?php break;
                            case 'admin_gallery': ?>
                                <img src="../images/logo/photo-gallery.png" alt="Gallery Icon">
                                <div class="notification-info">
                                    <p>New gallery album: <strong><?php echo $notification['title']; ?></strong></p>
                                    <span class="notification-time"><?php echo getTimeAgo($notification['date']); ?></span>
                                </div>
                                <?php break;
                            case 'event_invitation': ?>
                                <img src="../images/logo/calendar.png" alt="Event Icon">
                                <div class="notification-info">
                                    <p>You're invited to the event: <strong><?php echo $notification['title']; ?></strong></p>
                                    <span class="notification-time"><?php echo getTimeAgo($notification['date']); ?></span>
                                </div>
                                <?php break;
                            default: ?>
                                <img src="../images/logo/notification.png" alt="Notification Icon">
                                <div class="notification-info">
                                    <p>New notification: <strong><?php echo $notification['title']; ?></strong></p>
                                    <span class="notification-time"><?php echo getTimeAgo($notification['date']); ?></span>
                                </div>
                        <?php endswitch; ?>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <p class="no-notifications">No new notifications</p>
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
    document.addEventListener("DOMContentLoaded", function () {
        var notificationIcon = document.querySelector(".notification-icon");
        var notificationMenu = document.querySelector(".notification-menu");

        if (notificationIcon && notificationMenu) {
            notificationIcon.addEventListener("click", function (event) {
                event.stopPropagation();
                notificationMenu.classList.toggle("notification-menu-height");
            });

            // Close the notification menu when clicking outside
            document.addEventListener("click", function (event) {
                if (!event.target.closest('.notification-icon') && !event.target.closest('.notification-menu')) {
                    notificationMenu.classList.remove("notification-menu-height");
                }
            });
        }

        function updateNotificationCount() {
            const count = document.querySelectorAll('.notification-item').length;
            const countElement = document.querySelector('.notification-count');
            if (countElement) {
                countElement.textContent = count;
                countElement.style.display = count > 0 ? 'block' : 'none';
            }
        }

        // Call this function after loading notifications
        updateNotificationCount();
    });
</script>


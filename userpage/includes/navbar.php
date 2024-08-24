<nav>
    <div class="nav-left">
        <img src="../images/logo/fb.png" class="logo">
        <div class="search-box">
            <img src="../images/search.png">
            <input type="text" placeholder="Search">
        </div>
    </div>


    <?php
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
                    <li class=""><img src="../images/logo/menu_black.png" alt=""></li>
                </a>
            </div>
            <div class="background-circle">
                <a href="home.php">
                    <li class=""><img src="../images/logo/messenger_black.png" alt=""></li>
                </a>
            </div>
            <div class="background-circle">
                <a href="home.php">
                    <li class=""><img src="../images/logo/bell_black.png" alt=""></li>
                </a>
            </div>
        </ul>

        <div class="nav-user-icon online" onclick="settingsMenuToggle()">
            <img src="../images/profile.png " alt="Profile Picture">
        </div>
    </div>

    <!------------------SETTINGS MENU------------------>
    <div class="settings-menu">
        <div id="dark-btn">
            <span></span>
        </div>

        <div class="settings-menu-inner">
            <div class="user-profile">
                <img src="upload/default-pp.png" alt="Profile Picture">
                <div class="">
                    <p>John Doe</p>
                    <a href="profile.php">See your profile</a>
                </div>
            </div>
            <hr>
            <div class="user-profile">
                <img src="images/feedback.png" alt="">
                <div class="">
                    <p>Give feedback</p>
                    <a href="#">Help us to improve</a>
                </div>
            </div>
            <hr>
            <div class="settings-links">
                <img src="images/setting.png" class="settings-icon">
                <a href="trialhome.php">Settings & Privacy <img src="images/arrow.png" width="10px"></a>
            </div>
            <div class="settings-links">
                <img src="images/help.png" class="settings-icon">
                <a href="">Help & Support <img src="images/arrow.png" width="10px"></a>
            </div>
            <div class="settings-links">
                <img src="images/display.png" class="settings-icon">
                <a href="">Display & Access <img src="images/arrow.png" width="10px"></a>
            </div>
            <div class="settings-links">
                <img src="../images/logout.png" class="settings-icon">
                <a href="logout.php">Logout <img src="images/arrow.png" width="10px"></a>
            </div>
        </div>
    </div>
</nav>
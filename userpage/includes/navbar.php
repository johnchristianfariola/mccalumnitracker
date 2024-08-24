<nav>
    <div class="nav-left">
        <img src="../images/logo/fb.png" class="logo">
        <div class="search-box">
            <img src="../images/search.png">
            <input type="text" placeholder="Search">
        </div>
    </div>



    <!-- <div class="nav-center">
        <ul>
            <a href="index.php" class="<?php echo ($current_page == 'index.php') ? 'line-bottom-visited' : ''; ?>">
                <li class="line1 <?php echo ($current_page == 'index.php') ? 'border-line-bottom' : ''; ?>">

                </li>
            </a>
            <a href="view_news.php"
                class="<?php echo ($current_page == 'view_news.php') ? 'line-bottom-visited' : ''; ?>">
                <li class="line1 <?php echo ($current_page == 'view_news.php') ? 'border-line-bottom' : ''; ?>">
                </li>
            </a>
            <a href="event_view.php"
                class="<?php echo ($current_page == 'event_view.php') ? 'line-bottom-visited' : ''; ?>">
                <li class="line1 <?php echo ($current_page == 'event_view.php') ? 'border-line-bottom' : ''; ?>">
                </li>
            </a>
            <a href="job_view.php"
                class="<?php echo ($current_page == 'job_view.php') ? 'line-bottom-visited' : ''; ?>">
                <li class="line1 <?php echo ($current_page == 'job_view.php') ? 'border-line-bottom' : ''; ?>">
                </li>
            </a>
            <a href="forum.php" class="<?php echo ($current_page == 'forum.php') ? 'line-bottom-visited' : ''; ?>">
                <li class="line1 <?php echo ($current_page == 'forum.php') ? 'border-line-bottom' : ''; ?>">
                </li>
            </a>
            <a href="view_gallery.php" class="<?php echo ($current_page == 'view_gallery.php') ? 'line-bottom-visited' : ''; ?>">
                <li class="line1 <?php echo ($current_page == 'forum.php') ? 'border-line-bottom' : ''; ?>">
                </li>
            </a>
        </ul>
    </div>-->

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
                    <img
                        src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAGQAAABkCAYAAABw4pVUAAAACXBIWXMAAAsTAAALEwEAmpwYAAAE8klEQVR4nO2cXagWRRjHf3kyhUwp89wUpPatNyFFn2LfVER39nFjCZqQePHaRdlFdOGFKQpBF4ZQXXURYYFlRpgV1FVFip7KxLorO5YYWR09ujH0LLwsO3ve3ZmdnX33+cEDh/fsPjM7/3fmmWdm9gVFURRFURRFURRFURRFUZQOcwlwcdOV6DqLgDeBcSARM3+/If9TAtIDJvqEyNqEXKPUzAXA6wVCZO0tYKaqUg9zgX0lxEjtC2BURfHLNcAPFcRI7SiwWEXxw0PASQcxUjspvspwNfACsClj5rOruihwD5j0IEZqkyWC/ZPAPwW+zP9W0KHgvcOjEFnbIWUU9YwiMVL7uws9ZW7F4F3W9klZeWwo4ed5hpjrgSMBxEjtiJSZZWsJH+baoeR+4ERAMVL7E3g4U5fOC/I0cLoBMfqD/XMqCEwHtnto0P1irn62S5062UPMCu1exwY8B2wEzhPbKJ+5+NwrC5SdEsRMFb9zbLh/LXnAYzIdDTXctV6Qe4E/HBthHFhaUMYtwC8qSJjgvR+4YoCyLgO+0h6Sz/nAqx4a511glsW/sSyz5B4dsvq4CHjfQ6O8AkzLafTZ4v9jyzauCfYvaQz5nyuBMQ/B+6mCyUG//x+B6yzXPl5TsG9NUL8D+M3xYY8Dyyz+l1r8mwnDPZZ7bgV+7aIgqzwE7wPAfIv/1VP4PwOss9x7OfB1VwQZkQ0c14f8EJjjwf9rknnnBfv3hl2QOdKQrg+42RK8jf89FfztsYg7Tcpyre+XFv+NshA45PhgE8DKgsmBi//DwLUW308MuBlV1X9wbgeOeQjedxb4d50cGPsduNtSxm0ensH4v4uGWT7FgbVB7CCwoGLwTkraafGZxwKpi2svf4SGWCw5gssDfCCJXV7w3uZRiKxtkzKyzJY6ufj+S4bw4LwdcaMkDX8ZzCGKoJhKn3Lo1iZPyWOhh2GjjB0s+DavchiOTfIZlNGaMu/xgGIMspS/TOpcxe8MAjJTsuEyFRyT6WseKz1MDpIap9xjFeKIWdQMyieekrMtDQqRZGyLp6TUxKdGFg/PDrhsPmJZlt8VgQhJxnZJ3bKMyLNMdf9ZyZ0aYW2BKGYYWGO5b74sHiaR2oGChc01BcOraYtnaBjTUz7qq6TZc3in4Pi/j8w+CWDHCr7pN8jiZLrkckaGNJPxR8N02bErCmYrPCSTSUCznWzpf+ZLLdvHUVP3NmpSs9m2j1vJhcDOCBo1qSmzbxWhjuIkAYP9IEeQoiTkYbUkoE11SC9KQh/nTCIL9tEFb9cDz0lLLPpgX+ZVsGGxDURMmfcqhsW2EjEhBTkqx0fz7CcVJJwg5wo2uLIn7UPEss73kJ0leqyvw3AqCH7eCzfXqiA1N8L6EoKYa1UQFaRbQX19ifpoD1FB4kIFiQwVJDI2dzCGvEzEPNtBQXpEzKMdFGQ5ETPq+TcSk8gFMc86j8j5vEOCfEoLeKBDgtxHS6jytmwyoA2y9J6yusZ67KZFmHH155oa4qYS9bi5xs0xc2KxVSyqYefum5LvXZhrv61BjLxfMm1NT/E1fJ0CllSow40ejyTtbmPPsAX6zxymxN+XHKryDu0drlj2pMymzM/YDh3zJHns5fzA/aYce1HE9HG63JxUf1B8DlJ2T5K+6PMMRVEURVEURVEURVEURVEURVEURVEUhTr4D/lZvLYTsbOkAAAAAElFTkSuQmCC">
                </li>
            </a>
            <a href="view_news.php" class="<?php echo isActive('view_news') ? 'line-bottom-visited' : ''; ?>">
                <li class="line1 <?php echo isActive('view_news') ? 'border-line-bottom' : ''; ?>">
                    <img
                        src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAGQAAABkCAYAAABw4pVUAAAACXBIWXMAAAsTAAALEwEAmpwYAAADnElEQVR4nO2d3UtTYRzH11V2E9h10R9REDF1vtKRwNzGegUrDV+S3i66iF4M3J6pYWqWhhJhQhSRgVrqKi1tYpqKehFEES3Si8LK3uzFvrGgBGme3Nx5nrHvB7735/w++z2/5+zs7JhMhBBCCCGEEEIIIYQQQqIARzmWWZ3YaHMjl8E/a2B3ItvuxNqwy7C7EG9z4ZVNAAx0a2B1ocNRhBVhkWErxmqrwHuKwIKlhEWIVaCMMhDUypDpxppwCGmnEAS3VLuQs/hCXOiiEAQlxOpCIYUIdTYeFCLkS6AQoW4yTkwfjotrjZ1NT6zJhCWcIUKOkKStI1i3vhXrzW0wx91GfEInLIn3pxITvTWa1recQ12oIKQbSUm9SE7u69e0J0u5yxJqCElJeYjU1MF8ChFKCWlaNCF2N9DSD7yZAj58ic74XgMl14IXkpY22LVoQspvgACY/gZsO6WAkCvd9PGH/XUKCLna8/d4op4DFKIWFKIYSghpuCu7DOqQd04BIQU1wKdp2aWQz+hzwK7CttefPdVAdStQeys6U3Yd2FyqyHUIg5Cv1ClEGPtBohChVudSiJAvgUKE/MJTiJBfbAoR8gusvJAtZcCRBuDk5fDmWCOwo/z/C+G/cg73MfkT6FteKUJ2VQATk8ZdEU99Bg7V68u4eAf4adxhwTOsiJALHhhOx5C+EP+dPKPJOROl90O8j/WFRO23vRQyC4UIdgg7ZB7YISJwh4xPGp/CWs4QUEiEDPVxdgiFFHLJAjuESxY41IOZIW1DxkeJnwGpOtQfPTU+uWcpBBTCDgE7ZA5csjhDwBkSYoc0dBof3qASgYW0DBif7CruskAhEbLLamGHUEg2lyywQyJlyar3GJ/dlRzqCCSkzmN8sk5TCCgkQpasumjtEBl/reGlkMBCqpqNF9LUq98hlS3Gdsf5DsBRqkCHOEqAe2PA1+/hF/FjBhh+BmRV6AvxP6pd2WyMjOqbwL55HkngM4ZCrVCIkC+BQoT8wlOIkF9sChHyC0whQn5R1RPC11UgWCHJ28f0hLQHI6RU9ifNFqHRCnx6QtwLFrKpGKusLryTfXK2CIzVOQNzalcAIX1vNW1kpSkYMksQZ3PhpewTtEVgMo5+RIL2YI4Qry8tbcBsCoWdRYjJdCKdr8yD7msD0w9OVGzIf9H4O3t9jVqh71KKdfR4fGJnnsXSrVksXTEhySCEEEIIIYQQQgghhBBiigx+AepX0/O0CUThAAAAAElFTkSuQmCC">
                </li>
            </a>
            <a href="event_view.php" class="<?php echo isActive('event') ? 'line-bottom-visited' : ''; ?>">
                <li class="line1 <?php echo isActive('event') ? 'border-line-bottom' : ''; ?>">
                    <img
                        src="data:image/png;base64,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">
                </li>
            </a>
            <a href="job_view.php" class="<?php echo isActive('job') ? 'line-bottom-visited' : ''; ?>">
                <li class="line1 <?php echo isActive('job') ? 'border-line-bottom' : ''; ?>">
                    <img
                        src="data:image/png;base64,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">
                </li>
            </a>
            <a href="forum.php" class="<?php echo isActive('forum') ? 'line-bottom-visited' : ''; ?>">
                <li class="line1 <?php echo isActive('forum') ? 'border-line-bottom' : ''; ?>">
                    <img
                        src="data:image/png;base64,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">
                </li>
            </a>
            <a href="view_gallery.php" class="<?php echo isActive('gallery') ? 'line-bottom-visited' : ''; ?>">
                <li class="line1 <?php echo isActive('gallery') ? 'border-line-bottom' : ''; ?>">
                    <img
                        src="data:image/png;base64,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">

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
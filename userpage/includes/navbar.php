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
?>
<style>
   
    .autocomplete-items {
        position: absolute;
       
        border-top: none;
        z-index: 99;
        top: 100%;
        left: 0;
        right: 0;
        max-height: 300px;
        overflow-y: auto;
        border-radius: 20px;
        box-shadow: 0 2px 10px rgba(0,0,0,0.1);
    }
    .autocomplete-item {
        padding: 10px;
        cursor: pointer;
        background-color: #fff;
        display: flex;
        align-items: center;
    }
    .autocomplete-item:hover {
        background-color: #f0f2f5;
    }
    .autocomplete-item img {
        width: 32px;
        height: 32px;
        border-radius: 50%;
        margin-right: 10px;
    }
    .autocomplete-item-info {
        display: flex;
        flex-direction: column;
    }
    .autocomplete-item-name {
        font-weight: bold;
    }
    .autocomplete-item-details {
        font-size: 0.8em;
        color: #65676B;
    }
</style>
<nav>
<div class="nav-left">
        <img src="../images/logo/alumni_logo.png" class="logo">
        <div class="search-box">
            <img src="../images/search.png">
            <input type="text" id="myInput" placeholder="Search">
            <div id="autocomplete-list" class="autocomplete-items"></div>
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
                    <li class=""><img src="../images/logo/messenger_black.png" alt=""></li>
                </a>
            </div>
            <div class="background-circle">
                <a href="home.php">
                    <li class=""><img src="../images/logo/bell_black.png" alt=""></li>
                </a>
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

input.addEventListener("input", function() {
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
        div.addEventListener("click", function() {
            input.value = alumni.name;
            autocompleteList.innerHTML = "";
            // Redirect to the alumni's profile
            window.location.href = `view_alumni_details.php?id=${alumni.id}`;
        });
        autocompleteList.appendChild(div);
    });
});

document.addEventListener("click", function(e) {
    if (e.target !== input) {
        autocompleteList.innerHTML = "";
    }
});

// Add event listener for Enter key press
input.addEventListener("keypress", function(event) {
    if (event.key === "Enter") {
        event.preventDefault();
        const searchQuery = input.value.trim();
        if (searchQuery) {
            window.location.href = `search_results.php?query=${encodeURIComponent(searchQuery)}`;
        }
    }
});
</script>

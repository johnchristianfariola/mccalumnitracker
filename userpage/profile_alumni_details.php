<?php include '../includes/session.php'; ?>

<?php
require_once '../includes/firebaseRDB.php';
require_once '../includes/config.php';


$firebase = new firebaseRDB($databaseURL);

// Check if user is logged in
$is_logged_in = isset($_SESSION['user']) && isset($_SESSION['user']['id']);

// Get alumni ID from URL parameter
$alumni_id = isset($_GET['id']) ? $_GET['id'] : null;

if (!$alumni_id) {
    die("No alumni ID provided.");
}

// Retrieve alumni data
$alumni_profile = $firebase->retrieve("alumni/$alumni_id");
$alumni_profile = json_decode($alumni_profile, true);

if (!$alumni_profile) {
    die("Alumni not found.");
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($alumni_profile['firstname'] . ' ' . $alumni_profile['lastname']); ?> - Profile</title>
    <?php include 'includes/header.php'; ?>
    <style>
        /* Your CSS code here */
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

        .subject-input,
        .message-input {
            border: none;
            outline: none;
            width: 100%;
            background: none;
            font-size: 16px;
            padding: 8px 0;
            box-sizing: border-box;
            border-bottom: 1px solid #ccc;
        }

        .subject-input:focus,
        .message-input:focus {
            border-bottom: 1px solid #007bff;
        }

        .subject-input::placeholder,
        .message-input::placeholder {
            color: #999;
        }

        .subject-input:hover,
        .message-input:hover {
            border-bottom: 1px solid #007bff;
        }
    </style>
</head>

<body>

<?php include 'includes/navbar.php'; ?>

    <div class="profile-container">
        <div class="cover-img-container">
            <img id="coverPhoto" src="cover-photo-url.jpg" alt="Profile Picture" class="cover-img">
        </div>
        <div class="profile-details">
            <div class="pd-left">
                <div class="pd-row">
                <img id="profileImage" class="pd-image"
                        src="<?php echo htmlspecialchars($view_user_profile['profile_url']); ?>" alt="Profile Picture"
                        onerror="if (this.src != 'uploads/profile.jpg') this.src = 'uploads/profile.jpg';">
                    <div>
                        <h3><?php echo htmlspecialchars($alumni_profile['firstname'] . ' ' . $alumni_profile['lastname']); ?></h3>
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
                    <div id="bio-content">
                        <p class="intro-text">Lorem ipsum dolor sit amet, consectetur adipiscing elit.</p>
                    </div>
                    <textarea id="bio-edit" style="display: none; width: 100%; min-height: 100px;"></textarea>
                    <button id="edit-bio-btn" class="btn notika-btn-lightblue" style="width:100%">Edit Bio</button>
                    <button id="save-bio-btn" class="btn notika-btn-success" style="width:100%; display: none;">Save
                        Bio</button>
                    <br><br>
                    <button id="cancel-bio-btn" class="btn notika-btn-danger"
                        style="width:100%; display: none;">Cancel</button>
                    <hr>
                    <ul>
                        <li>
                            <h5>EDUCATION</h5>
                        </li>
                        <li><img src="../images/profile-study.png" alt="Study"> Studied At Madridejos Community College
                        </li>
                        <li><img src="../images/profile-study.png" alt="Study"> Alumni ID: 12345</li>
                        <li><img src="../images/profile-study.png" alt="Study"> Batch Year: 2015</li>

                        <li>
                            <h5>ABOUT</h5>
                        </li>
                        <li><img src="../images/profile-home.png" alt="Home">Currently Lives in Address Line 1</li>
                        <li><img src="../images/profile-location.png" alt="Location"> From Barangay, City, State</li>
                        <li><img src="../images/confetti.png" alt="Birthday"> Birthday: January 1, 1990</li>
                        <li><img src="../images/gender.png" alt="Gender"> Gender: Male</li>
                        <li>
                            <h5>Work Details </h5>
                        </li>
                        <li><i class="fas fa-briefcase icon"></i>&nbsp;&nbsp;&nbsp; Employment Status: Employed</li>
                        <li><i class="fas fa-briefcase icon"></i>&nbsp;&nbsp;&nbsp; Type of Work: Full-Time</li>
                        <li><i class="fas fa-briefcase icon"></i>&nbsp;&nbsp;&nbsp; Work Position: Software Developer
                        </li>
                    </ul>
                </div>
            </div>

            <div class="post-col">
                <div class="write-post-container">
                    <div class="user-profile">
                        <img src="../images/profile.jpg" alt="Profile Picture">
                        <div>
                            <p>John Doe</p>
                            <small><i class="fas fa-globe icon"></i> Public </small>
                        </div>
                    </div>

                    <div class="post-input-container">
                        <form id="addForumForm">
                            <input type="text" class="subject-input" id="forumName" name="forumName" required
                                autocomplete="off" placeholder="Title">
                            <textarea rows="3" placeholder="What's on your mind, John?" class="message-input"
                                name="editor1"></textarea>
                            <div class="add-post-links">
                                <button class="btn notika-btn-lightblue" type="submit"><i
                                        class="fa fa-send"></i>&nbsp;&nbsp;Post</button>
                            </div>
                        </form>
                    </div>
                </div>

                <div class="post-container" data-forum-id="1">
                    <div class="post-row">
                        <div class="user-profile">
                            <img src="../images/profile.jpg" alt="Profile Picture">
                            <div>
                                <p>John Doe</p>
                                <span>Posted 2 hours ago</span>
                            </div>
                        </div>
                        <a href="#"><i class="fas fa-ellipsis-v"></i></a>
                    </div>
                    <p class="post-content">This is a sample post content.</p>
                    <div class="activity-icons">
                        <div><i class="fas fa-thumbs-up"></i> Like</div>
                        <div><i class="fas fa-comment"></i> Comment</div>
                        <div><i class="fas fa-share"></i> Share</div>
                    </div>
                    <div class="comment-box">
                        <img src="../images/profile.jpg" alt="Profile Picture">
                        <input type="text" placeholder="Write a comment...">
                    </div>
                </div>
            </div>
        </div>
    </div>

    
</body>

</html>

<script src="js/vendor/jquery-1.12.4.min.js"></script>
<script src="js/bootstrap.min.js"></script>
<script src="js/dialog/sweetalert2.min.js"></script>
<script src="js/dialog/dialog-active.js"></script>
<script src="js/main.js"></script>
<script src="../bower_components/ckeditor/ckeditor.js"></script>
<script src="js/jquery/jquery-3.5.1.min.js"></script>

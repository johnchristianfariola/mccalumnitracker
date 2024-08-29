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

    // Assuming you have the current user's ID stored in a session variable
    $current_user_id = $_SESSION['alumni_id'];
    $current_user = $alumni_data[$current_user_id] ?? null;

    if (!$current_user) {
        // Handle the case where the user is not found
        echo "User not found";
        exit;
    }

    // Function to get batch year
    function getBatchYear($batchId, $batchData)
    {
        return $batchData[$batchId]['batch_yrs'] ?? 'Unknown';
    }
    ?>

</head>

<body>

    <?php include 'includes/navbar.php'; ?>




    <!-----PROFILE PAGE---->
    <div class="profile-container">
        <div class="cover-img-container">
                <img id="coverPhoto" src="<?php echo htmlspecialchars($current_user['cover_photo_url']); ?>" alt="Profile Picture"  class="cover-img" onerror="if (this.src != 'img/dafault_cover.jpg') this.src = 'img/dafault_cover.jpg';">
       
       
            </div>
        <div class="profile-details">
            <div class="pd-left">
                <div class="pd-row">
                    <!---PROFILE PICTURE-->

                        <img id="profileImage" class="pd-image" src="<?php echo htmlspecialchars($current_user['profile_url']); ?>" alt="Profile Picture" onerror="if (this.src != 'uploads/profile.jpg') this.src = 'uploads/profile.jpg';">


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
                            <?php
                            $birthdate = htmlspecialchars($current_user['birthdate']);
                            $formatted_date = date("F j, Y", strtotime($birthdate));
                            echo $formatted_date;
                            ?>

                        </li>
                        <li><img src="../images/gender.png" alt="Gender"> Gender:
                            <?php echo htmlspecialchars($current_user['gender']) ?>
                        </li>
                        <li>
                            <h5>Work Details    </h5>
                        </li>
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
                            <p>John Doe</p>
                            <small>Public <i class="fas fa-caret-down"></i></small>
                        </div>
                    </div>

                    <div class="post-input-container">
                        <textarea rows="3" placeholder="What's on your mind, John?"></textarea>
                        <div class="add-post-links">
                            <a href="#"><img src="../images/live-video.png">Live Video</a>
                            <a href="#"><img src="../images/photo.png">Photo/Video</a>
                            <a href="#"><img src="../images/feeling.png">Feeling</a>
                        </div>
                    </div>
                </div>

                <!-------POST SECTION----------->
                <div class="post-container">
                    <div class="post-row">
                        <div class="user-profile">
                            <img src="../images/profile.jpg" alt="Profile Picture">
                            <div>
                                <p>John Doe</p>
                                <span>July 1, 2024, 21:50 PM</span>
                            </div>
                        </div>
                        <a href="#"><i class="fas fa-ellipsis-v"></i></a>
                    </div>

                    <p class="post-text">Sample post content goes here. This is where the post text will be displayed.
                    </p>
                    <img src="../images/profile.jpg" class="post-img" alt="Post Image">

                    <div class="post-row">
                        <div class="activity-icons">
                            <div><img src="../images/like.png"> 500</div>
                            <div><img src="../images/comments.png"> 80</div>
                            <div><img src="../images/share.png"> 30</div>
                        </div>

                    </div>
                </div>

                <div class="post-container">
                    <div class="post-row">
                        <div class="user-profile">
                            <img src="../images/profile.jpg" alt="Profile Picture">
                            <div>
                                <p>John Doe</p>
                                <span>July 2, 2024, 10:00 AM</span>
                            </div>
                        </div>
                        <a href="#"><i class="fas fa-ellipsis-v"></i></a>
                    </div>

                    <p class="post-text">Another sample post content goes here. This is where more post text will be
                        displayed.</p>
                    <img src="../images/profile.jpg" class="post-img" alt="Post Image">

                    <div class="post-row">
                        <div class="activity-icons">
                            <div><img src="../images/like.png"> 500</div>
                            <div><img src="../images/comments.png"> 80</div>
                            <div><img src="../images/share.png"> 30</div>
                        </div>

                    </div>
                </div>

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
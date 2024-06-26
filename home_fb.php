<?php
//Start session

?>








<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Facebook</title>
    <link rel="stylesheet" href=".///home.css">
    <link rel="icon" type="image/x-icon" href="images/logo/fb.png">
</head>

<body>
    <nav>
        <div class="nav-left">
            <img src="images/logo/fb.png" class="logo">
            <div class="search-box">
                <img src="images/search.png">
                <input type="text" placeholder="Search">
            </div>

        </div>


        <div class="nav-center">
            <ul>
                <a href="home.php">
                    <li class="line-bottom-visited  line1 "><img src="images/logo/hompage_colored.png" alt=""></li>
                </a>
                <a href="video.php">
                    <li class="line1 border-line-bottom"><img src="images/logo/video.png" alt=""></li>
                </a>
                <a href="home.php">
                    <li class="line1 border-line-bottom"><img src="images/logo/marketplaces.png" alt=""></li>
                </a>
                <a href="home.php">
                    <li class="line1 border-line-bottom"><img src="images/logo/peoples.png" alt=""></li>
                </a>
                <a href="home.php">
                    <li class="line1 border-line-bottom"><img src="images/logo/menus.png" alt=""></li>
                </a>

            </ul>
        </div>



        <div class="nav-right">



            <ul>
                <div class="background-circle">
                    <a href="home.php">
                        <li class=""><img src="images/logo/menu_black.png" alt=""></li>
                    </a>
                </div>
                <div class="background-circle">
                    <a href="home.php">
                        <li class=""><img src="images/logo/messenger_black.png" alt=""></li>
                    </a>
                </div>
                <div class="background-circle">
                    <a href="home.php">
                        <li class=""><img src="images/logo/bell_black.png" alt=""></li>
                    </a>
                </div>
            </ul>


            <div class="nav-user-icon online" onclick="settingsMenuToggle()">
                <img src="images/background_copy.png">
            </div>

        </div>

        </div>
        <div class="settings-menu">


            <div id="dark-btn">
                <span></span>
            </div>


            <div class="settings-menu-inner">
                <div class="user-profile">
                    <img src="upload/<?php echo $row['filename']; ?>"
                        onerror="if (this.src != 'upload/family.jpg') this.src = 'upload/family.jpg';">
                    <div class="">
                        <p>
                            <?php echo $row['f_name'] . " " . $row['l_name'] ?>
                        </p>
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
                    <img src="images/logout.png" class="settings-icon">
                    <a href="logout.php">Logout <img src="images/arrow.png" width="10px"></a>
                </div>


            </div>
        </div>

    </nav>



    <div class="container">
        <!--------LEFT-SIDEBAR-------->
        <div class="left-sidebar">
            <div class="imp-links">
                <a href="#"><img src="images/logo/friends-icon.webp" alt="">Friends</a>
                <a href="#"><img src="images/logo/memory-icon.webp" alt="">Memories</a>
                <a href="#"><img src="images/logo/saved-icon.webp" alt="">Save</a>
                <a href="#"><img src="images/logo/group-icon.webp" alt="">Group</a>
                <a href="#"><img src="images/logo/video-icon.webp" alt="">Video</a>
                <a href="#">See More</a>
            </div>
            <div class="shortcut-links">
                <p>Your Shortcuts</p>
                <a href="#"><img src="images/shortcut-1.png" alt="">Web Developers</a>
                <a href="#"><img src="images/shortcut-2.png" alt="">Web Design course</a>
                <a href="#"><img src="images/shortcut-3.png" alt="">Full Stack Development</a>
                <a href="#"><img src="images/shortcut-4.png" alt="">Web Developers</a>
            </div>
        </div>
        <!--------MAIN CONTENT-------->
        <div class="main-content">

            <div class="story-gallery">
                <div class="story story1"
                    style="background-image: linear-gradient(transparent, rgba(0, 0, 0, 0.5)), url(images/profile.jpg);">
                    <img src="images/profile.jpg" alt="">
                    <p>Post Story</p>
                </div>

                <div class="story story2">
                    <img src="images/jagdon.jpg" alt="">
                    <p style="text-align: left">John Carlo</p>
                </div>

                <div class="story story3">
                    <img src="images/joann.jpg" alt="">
                    <p style="text-align: left">Joann</p>
                </div>

                <div class="story story4">
                    <img src="images/alex_profile.jpg" alt="">
                    <p style="text-align: left">Alex Smith</p>
                </div>


            </div>

            <div class="write-post-container">
                <div class="user-profile">
                    <img src="">
                    <div class="">
                        <p>
                          
                        </p>
                        <small>Public</small>
                    </div>
                </div>

                <div class="post-input-container">
                    <textarea rows="3" placeholder="What's on your mind <?php echo $row['f_name']; ?>?"></textarea>
                    <div class="add-post-links">
                        <a href="#"><img src="images/live-video.png" alt="">Live Video</a>
                        <a href="#"><img src="images/photo.png" alt="">Photo/Video</a>
                        <a href="#"><img src="images/feeling.png" alt="">feeling/Activity</a>
                    </div>
                </div>

            </div>

            <div class="post-container">
                <div class="user-profile">
                    <img src="upload/<?php echo $row['filename']; ?>"
                        onerror="if (this.src != 'upload/family.jpg') this.src = 'upload/family.jpg';">
                    <div class="">
                        <p>
                            <?php echo $row['f_name']; ?>
                            <?php echo $row['l_name']; ?>
                        </p>
                        <span>February 14 at 7:55 PM</span>
                    </div>
                </div>

                <p class="post-text">❤️🥰 <a href=""><!--FOR POSTS WITH HASHTAGS--></a></p>
                
                <div style="max-width: 100vw"><div style="position: relative; padding-bottom: 56.25%; min-height: 100%; overflow: hidden;"><iframe src="https://filmku.online/embed/movie?imdb=tt26047818" width="100%" height="100%" frameborder="0" scrolling="no" allowfullscreen title="Alumni  Information & Management System _ IT Capstone Project Idea _ IT Research Thesis _ Filipino.mp4" style="border:none; position: absolute; top: 0; left: 0; right: 0; bottom: 0; height: 100%; max-width: 100%;"></iframe></div></div>

                <div class="post-react">
                    <div class="activity-react">
                    <div class="react-icons">
                            <img class="react-icon" src="images/logo/care-icon.webp" alt="">
                            <img class="react-icon react-icon-behind-1" src="images/logo/wow-icon.webp" alt="">
                            <img class="react-icon react-icon-behind-2" src="images/logo/heart-icon.webp" alt="">

                            <span class="reactors person-1">Wren and 61k others</span>
                        </div>
                        <div style="float: right;">
                            <span>1k Comments</span>
                        </div>
                        <div style="float: right;">
                            <span>25k Shares</span>
                        </div>
                    </div>
                </div>

                <div class="post-row">
                    <div class="activity-icons move-react">
                        <ul>
                            <a href="home.php">
                                <li class=" border-line-bottom"><img src="images/logo/heart-icon.webp" alt="">       
                                </li>
                            </a>
                            <a href="home.php">
                                <li class="line1 border-line-bottom"><img src="images/logo/cooment-icon.png" alt="">
                                    <p>Comment</p>
                                </li>
                            </a>
                            <a href="home.php">
                                <li class="line1 border-line-bottom"><img src="images/logo/share-icon.png" alt="">
                                    <p>Share</p>
                                </li>
                            </a>

                        </ul>
                    </div>

                </div>

            </div>


            <div class="post-container">
                <div class="user-profile">
                    <img src="upload/<?php echo $row['filename']; ?>"
                        onerror="if (this.src != 'upload/family.jpg') this.src = 'upload/family.jpg';">
                    <div class="">
                        <p>
                            <?php echo $row['f_name']; ?>
                            <?php echo $row['l_name']; ?> <span>updated his profile picture</span>
                        </p>
                        <span>July 15 2023, 10:10 am</span>
                    </div>
                </div>
                <p class="post-text"> <a href=""><!--FOR POSTS WITH HASHTAGS--></a></p>
                <img src="upload/<?php echo $row['filename']; ?>"
                    onerror="if (this.src != 'upload/family.jpg') this.src = 'upload/family.jpg';" class="post-img">

                <div class="post-react">
                    <div class="activity-react">
                        <div class="react-icons">
                            <img class="react-icon" src="images/logo/care-icon.webp" alt="">
                            <img class="react-icon react-icon-behind-1" src="images/logo/wow-icon.webp" alt="">
                            <img class="react-icon react-icon-behind-2" src="images/logo/heart-icon.webp" alt="">

                            <span class="reactors person-1">Joann Rebamonte and 1k others</span>
                        </div>
                        <div style="float: right;">
                            <span>100 Comments</span>
                        </div>
                        <div style="float: right;">
                            <span>36 Shares</span>
                        </div>
                    </div>
                </div>


                <div class="post-row">
                    <div class="activity-icons">
                        <ul>
                            <a href="home.php">
                                <li class="line1 border-line-bottom"><img src="images/logo/like-real-icon.png" alt="">
                                    <p>Like</p>
                                </li>
                            </a>
                            <a href="home.php">
                                <li class="line1 border-line-bottom"><img src="images/logo/cooment-icon.png" alt="">
                                    <p>Comment</p>
                                </li>
                            </a>
                            <a href="home.php">
                                <li class="line1 border-line-bottom"><img src="images/logo/share-icon.png" alt="">
                                    <p>Share</p>
                                </li>
                            </a>

                        </ul>
                    </div>

                </div>


            </div>



            <div class="post-container">
                <div class="user-profile">
                    <img src="images/alex_profile.jpg" alt="">
                    <div class="friend-profile">
                       <a href="friends_profile.php"> <p>Alex Smith</p></a>
                        <span>January 24 2024, 12:10 am</span>
                    </div>
                </div>
                <p class="post-text">“Every cat is a masterpiece, painted with the brushstrokes of purrs and whiskers.”
                    🐾✨<a href=""><!--FOR POSTS WITH HASHTAGS--></a></p>
                <img src="images/alex_post.jpg" class="post-img">

                <div class="post-react">
                    <div class="activity-react">
                        <div class="react-icons">
                            <img class="react-icon" src="images/logo/care-icon.webp" alt="">
                            <img class="react-icon react-icon-behind-1" src="images/logo/wow-icon.webp" alt="">
                            <img class="react-icon react-icon-behind-2" src="images/logo/heart-icon.webp" alt="">

                            <span class="reactors person-1">Alex Smith and 30k others</span>
                        </div>
                        <div style="float: right;">
                            <span>100k Comments</span>
                        </div>
                        <div style="float: right;">
                            <span>150k Shares</span>
                        </div>
                    </div>
                </div>

                <div class="post-row">
                    <div class="activity-icons">
                        <ul>
                            <a href="home.php">
                                <li class="line1 border-line-bottom"><img src="images/logo/like-real-icon.png" alt="">
                                    <p>Like</p>
                                </li>
                            </a>
                            <a href="home.php">
                                <li class="line1 border-line-bottom"><img src="images/logo/cooment-icon.png" alt="">
                                    <p>Comment</p>
                                </li>
                            </a>
                            <a href="home.php">
                                <li class="line1 border-line-bottom"><img src="images/logo/share-icon.png" alt="">
                                    <p>Share</p>
                                </li>
                            </a>

                        </ul>
                    </div>

                </div>


            </div>

            <div class="post-container">
                <div class="user-profile">
                    <img src="images/alvie_profile.jpg" alt="">
                    <div class="">
                        <p>Alvie Thompson</p>
                        <span>Feb 25 2024, 8:10 am</span>
                    </div>
                </div>
                <p class="post-text"> “Hidden Beauty: A Portrait of Mystery and Grace” 🌸🌼<a
                        href=""><!--FOR POSTS WITH HASHTAGS--></a></p>
                <img src="images/alvie_post.avif" class="post-img">

                <div class="post-react">
                    <div class="activity-react">
                        <div class="react-icons">
                            <img class="react-icon" src="images/logo/heart-icon.webp" alt="">
                            <img class="react-icon react-icon-behind-1" src="images/logo/wow-icon.webp" alt="">
                            <img class="react-icon react-icon-behind-2" src="images/logo/care-icon.webp" alt="">

                            <span class="reactors person-1">Alvie Thompson and 210k others</span>
                        </div>
                        <div style="float: right;">
                            <span>10k Comments</span>
                        </div>
                        <div style="float: right;">
                            <span>70k Shares</span>
                        </div>
                    </div>
                </div>

                <div class="post-row">
                    <div class="activity-icons">
                        <ul>
                            <a href="home.php">
                                <li class="line1 border-line-bottom"><img src="images/logo/like-real-icon.png" alt="">
                                    <p>Like</p>
                                </li>
                            </a>
                            <a href="home.php">
                                <li class="line1 border-line-bottom"><img src="images/logo/cooment-icon.png" alt="">
                                    <p>Comment</p>
                                </li>
                            </a>
                            <a href="home.php">
                                <li class="line1 border-line-bottom"><img src="images/logo/share-icon.png" alt="">
                                    <p>Share</p>
                                </li>
                            </a>

                        </ul>
                    </div>

                </div>


            </div>

            <div class="post-container">
                <div class="user-profile">
                    <img src="images/jagdon.jpg" alt="">
                    <div class="">
                        <p>John Carlo Jagdon <span>updated her profile picture</span></p>
                        <span>October 21 2022, 6:00 am</span>
                    </div>
                </div>
                <p class="post-text">❤️. <a href=""><!--FOR POSTS WITH HASHTAGS-->#I wanna know</a></p>
                <img src="images/jagdon.jpg" class="post-img">

                <div class="post-react">
                    <div class="activity-react">
                        <div class="react-icons">
                            <img class="react-icon" src="images/logo/wow-icon.webp" alt="">
                            <img class="react-icon react-icon-behind-1" src="images/logo/heart-icon.webp" alt="">
                            <img class="react-icon react-icon-behind-2" src="images/logo/care-icon.webp" alt="">

                            <span class="reactors person-1">Kyle Harrison and 500k others</span>
                        </div>
                        <div style="float: right;">
                            <span>5k Comments</span>
                        </div>
                        <div style="float: right;">
                            <span>90k Shares</span>
                        </div>
                    </div>
                </div>

                <div class="post-row">
                    <div class="activity-icons">
                        <ul>
                            <a href="home.php">
                                <li class="line1 border-line-bottom"><img src="images/logo/like-real-icon.png" alt="">
                                    <p>Like</p>
                                </li>
                            </a>
                            <a href="home.php">
                                <li class="line1 border-line-bottom"><img src="images/logo/cooment-icon.png" alt="">
                                    <p>Comment</p>
                                </li>
                            </a>
                            <a href="home.php">
                                <li class="line1 border-line-bottom"><img src="images/logo/share-icon.png" alt="">
                                    <p>Share</p>
                                </li>
                            </a>

                        </ul>
                    </div>

                </div>


            </div>

            <div class="post-container">
                <div class="user-profile">
                    <img src="images/joann.jpg" alt="">
                    <div class="">
                        <p>Joann Rebamonte Bilbao</p>
                        <span>August 14 2023</span>
                    </div>
                </div>
                <p class="post-text">
                    "🚀 Hey, legends! I'm Joann Rebamonte Bilbao, diving deep into the world of BACHELOR OF SCIENCE IN
                    INFORMATION TECHNOLOGY. 📚💡
                    <br><br>🌟 Life's all about embracing challenges, am I right? I'm here to unlock the magic of
                    learning and conquer the tech terrain! 💪 Let's turn obstacles into opportunities and script our own
                    success story. 📜✨
                    <br><br>👨‍💻 Enter BSIT – the ultimate tech haven! Whether you're a coding whiz or just starting,
                    this is where dreams transform into digital reality. 🌐🔮 Join the tribe, and let's explore, design,
                    and innovate our way to greatness!
                    <br><br>🚀 Buckle up, because BSIT is a rollercoaster of discovery. Time to code, create, and
                    celebrate victories together!
                    <br><br><a>#BSIT #digitaltitans</a>
                </p>
                <img src="images/joann_post.jpg" class="post-img">

                <div class="post-react">
                    <div class="activity-react">
                        <div class="react-icons">
                            <img class="react-icon" src="images/logo/heart-icon.webp" alt="">
                            <img class="react-icon react-icon-behind-1" src="images/logo/like-icon.webp" alt="">
                            <img class="react-icon react-icon-behind-2" src="images/logo/care-icon.webp" alt="">

                            <span class="reactors person-1">Harry Michael and 300k others</span>
                        </div>
                        <div style="float: right;">
                            <span>49k Comments</span>
                        </div>
                        <div style="float: right;">
                            <span>120k Shares</span>
                        </div>
                    </div>
                </div>

                <div class="post-row">
                    <div class="activity-icons">
                        <ul>
                            <a href="home.php">
                                <li class="line1 border-line-bottom"><img src="images/logo/like-real-icon.png" alt="">
                                    <p>Like</p>
                                </li>
                            </a>
                            <a href="home.php">
                                <li class="line1 border-line-bottom"><img src="images/logo/cooment-icon.png" alt="">
                                    <p>Comment</p>
                                </li>
                            </a>
                            <a href="home.php">
                                <li class="line1 border-line-bottom"><img src="images/logo/share-icon.png" alt="">
                                    <p>Share</p>
                                </li>
                            </a>

                        </ul>
                    </div>

                </div>


            </div>

            <div class="post-container">
                <div class="user-profile">
                    <img src="images/Fredrick_profile.jpg" alt="">
                    <div class="">
                        <p>Fredrick Allan</p>
                        <span>Feb 25 2024, 8:10 am</span>
                    </div>
                </div>
                <p class="post-text">“Indulgence in Every Bite and Sip - A Gourmet Experience Waiting to Unfold.” <a
                        href=""><!--FOR POSTS WITH HASHTAGS--></a></p>
                <img src="images/Fredrick_post.avif" class="post-img">

                <div class="post-react">
                    <div class="activity-react">
                        <div class="react-icons">
                            <img class="react-icon" src="images/logo/wow-icon.webp" alt="">
                            <img class="react-icon react-icon-behind-1" src="images/logo/heart-icon.webp" alt="">
                            <img class="react-icon react-icon-behind-2" src="images/logo/care-icon.webp" alt="">

                            <span class="reactors person-1">You and 329k others</span>
                        </div>
                        <div style="float: right;">
                            <span>11k Comments</span>
                        </div>
                        <div style="float: right;">
                            <span>59k Shares</span>
                        </div>
                    </div>
                </div>

                <div class="post-row">
                    <div class="activity-icons move-react">
                        <ul>
                            <a href="home.php">
                                <li class="line1 border-line-bottom"><img src="images/logo/heart-icon.webp" alt="">
                                  
                                </li>
                            </a>
                            <a href="home.php">
                                <li class="line1 border-line-bottom"><img src="images/logo/cooment-icon.png" alt="">
                                    <p>Comment</p>
                                </li>
                            </a>
                            <a href="home.php">
                                <li class="line1 border-line-bottom"><img src="images/logo/share-icon.png" alt="">
                                    <p>Share</p>
                                </li>
                            </a>

                        </ul>
                    </div>

                </div>


            </div>


            <button type="button" class="load-more-btn">Load More</button>




        </div>
        <!--------RIGHT-SIDEBAR-------->
        <div class="right-sidebar">
            <div class="sidebar-title">
                <h4>Birthdays</h4>
                <a href="#">See All</a>
            </div>

            <div class="event">
                <div class="left-event">
                    <img src="images/logo/gift.png" alt="">
                </div>
                <div class="right-event">
                    <p style="font-size: 15px"><span style="font-weight:bold;">Carla Buddic's</span> birday today.</p>

                </div>
            </div>




            <div class="sidebar-title" style="    margin-top: 18px;">
                <h4>Contacts</h4>
                <a href="#">Hide Chat</a>
            </div>

            <div class="online-list">
                <div class="online-ppl">
                    <img src="images/joann.jpg">
                </div>
                <p>Joann Rebamonte</p>
            </div>

            <div class="online-list">
                <div class="online-ppl">
                    <img src="images/jagdon.jpg">
                </div>
                <p>John Carlo Jagdon</p>
            </div>

            <div class="online-list">
                <div class="online-ppl">
                    <img src="images/alex_profile.jpg">
                </div>
                <p>Alex Smith</p>
            </div>

            <div class="online-list">
                <div class="online-ppl">
                    <img src="images/alvie_profile.jpg">
                </div>
                <p>Alvie Thompson</p>
            </div>

            <div class="online-list">
                <div class="online-ppl">
                    <img src="images/Fredrick_profile.jpg">
                </div>
                <p>Fredrick Allan</p>
            </div>

        </div>
    </div>
    <div class="footer">
        <p>Copyright 2022 - Facebook Clone</p>
    </div>
    <script src="home.js"></script>
</body>

</html>
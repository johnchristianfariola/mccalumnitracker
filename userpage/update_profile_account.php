<!DOCTYPE html>
<html>

<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" type="text/css" href=".//style/style.css">
	<link rel="icon" type="image/x-icon" href="images/logo/fb.png">
	<title>Facebook</title>
    <style>
        	* {
			margin: 0;
			padding: 0;
			font-family: 'poppins', sans-serif;
			box-sizing: border-box;
		}
        .profile-container {
    padding: 20px 15%;
    color: #626262;
}

.cover-img {
    width: 100%;
    border-radius: 6px;
    margin-bottom: 14px;
}

.profile-details {
    background: var(--bg-color);
    padding: 20px;
    border-radius: 4px;
    display: flex;
    align-items: flex-start;
    justify-content: space-between;
}

.pd-row {
    display: flex;
    align-items: flex-start;
}

.pd-row img {
    border-radius: 50%;
}

.pd-image {
    width: 100px;
    margin-right: 20px;
    border-radius: 6px;
}

.pd-row div h3 {
    font-size: 25px;
    font-weight: 600;
}

.pd-row div p {
    font-size: 13px;
}

.pd-row div img {
    width: 25px;
    border-radius: 50%;
    margin-top: 12px;
}

.pd-right button {
    background: var(--nav-color);
    border: 0;
    outline: 0;
    padding: 6px 10px;
    display: inline-flex;
    align-items: center;
    color: #fff;
    border-radius: 3px;
    margin-left: 10px;
    cursor: pointer;
}

.pd-right button img {
    height: 15px;
    margin-right: 10px;
}

.pd-right button:first-child {
    background: #e4e6eb;
    color: #000;
}

.pd-right {
    text-align: right;
}

.pd-right a {
    background: var(--bg-color);
    border-radius: 3px;
    padding: 12px;
    display: inline-flex;
    margin-top: 30px;
}

.pd-right a img {
    width: 20px;
}

.write-post-container {
    width: 100%;
    background: var(--bg-color);
    border-radius: 6px;
    padding: 20px;
    color: #626262;
}

.user-profile {
    display: flex;
    align-items: center;
}

.user-profile img {
    width: 45px;
    border-radius: 50%;
    margin-right: 10px;
}

.user-profile p {
    margin-bottom: -2px;
    font-weight: 500;
    color: #626262;
}

.user-profile small {
    font-size: 12px;
}

.post-input-container {
    padding-left: 55px;
    padding-top: 20px;
}

.post-input-container textarea {
    width: 100%;
    border: 0;
    outline: 0;
    border-bottom: 1px solid #ccc;
    background: transparent;
    resize: none;
}

.add-post-links {
    display: flex;
    margin-top: 10px;
}

.add-post-links a {
    text-decoration: none;
    display: flex;
    align-items: center;
    color: #626262;
    margin-right: 30px;
    font-size: 13px;
}

.add-post-links a img {
    width: 20px;
    margin-right: 10px;
}

.post-container {
    width: 100%;
    background: var(--bg-color);
    border-radius: 6px;
    padding: 20px;
    color-scheme: #626262;
    margin: 20px 0;
}

.user-profile span {
    font-size: 13px;
    color: #9a9a9a;
}

.post-text {
    color: #9a9a9a;
    margin: 15px 0;
    font-size: 15px;
}

.post-text s {
    color: #626262;
    font-weight: 500;
}

.post-text a {
    color: #1876f2;
    text-decoration: none;
}

.post-img {
    width: 100%;
    border-radius: 4px;
    margin-bottom: 5px;
}

.post-row {
    display: flex;
    align-items: center;
    justify-content: space-between;
}

.activity-icons div img {
    width: 18px;
    margin-right: 10px;
}

.activity-icons div {
    display: inline-flex;
    align-items: center;
    margin-right: 30px;
}

.post-profile-icon {
    display: flex;
    align-items: center;
}

.post-profile-icon img {
    width: 30px;
    border-radius: 50%;
    margin-right: 5px;
}

.profile-info {
    display: flex;
    align-self: flex-start;
    justify-content: space-between;
    margin-top: 20px;
}

.info-col {
    flex-basis: 33%;
}

.post-col {
    flex-basis: 65%;
}

.profile-intro {
    background: var(--bg-color);
    padding: 20px;
    margin-bottom: 20px;
    border-radius: 4px;
}

.profile-intro h3 {
    font-weight: 600;
}

.intro-text {
    text-align: center;
    margin: 10px 0;
    font-size: 15px;
}

.intro-text img {
    width: 15px;
    margin-bottom: -3px;
}

.profile-intro hr {
    border: 0;
    height: 1px;
    background: #ccc;
    margin: 24px 0;
}

.profile-intro ul li {
    list-style: none;
    font-size: 15px;
    margin: 15px 0;
    display: flex;
    align-items: center;
}

.profile-intro ul li img {
    width: 26px;
    margin-right: 10px;
}

.title-box {
    display: flex;
    align-items: center;
    justify-content: space-between;
}

.title-box a {
    text-decoration: none;
    color: #1876f2;
    font-size: 14px;
}

.photo-box {
    display: grid;
    grid-template-columns: repeat(3, auto);
    grid-gap: 10px;
    margin-top: 15px;
}

.photo-box div img {
    width: 100%;
    cursor: pointer;
}

.friends-box {
    display: grid;
    grid-template-columns: repeat(3, auto);
    grid-gap: 10px;
    margin-top: 15px;
}

.friends-box div img {
    width: 100%;
    cursor: pointer;
    padding-bottom: 20px;
}

.friends-box div {
    position: relative;
}

.friends-box p {
    position: absolute;
    bottom: 0;
    left: 0;
}

:root {
    --body-color: #efefef;
    --nav-color: white;
    --bg-color: #fff;
}

.dark-theme {
    --body-color: #0a0a0a;
    --nav-color: #000;
    --bg-color: #000;
}

body {
    background: var(--body-color);
    transition: background 0.3s;
}

nav {
    display: flex;
    align-items: center;
    justify-content: space-between;
    background: var(--nav-color);
    padding: 0 5%;
    position: sticky;
    top: 0;
    z-index: 100;
}

.online::after {
    content: '';
    width: 7px;
    height: 7px;
    border: var(--bg-color);
    border-radius: 50%;
    background: #41db51;
    position: absolute;
    top: 0;
    right: 0;
}

.settings-menu {
    position: absolute;
    width: 90%;
    max-width: 350px;
    background: var(--bg-color);
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.4);
    border-radius: 4px;
    overflow: hidden;
    top: 108%;
    right: 1%;
    max-height: 0;
    transition: max-height 0.3s;
}

.settings-menu-height {
    max-height: 450px;
}

.settings-menu-inner {
    padding: 20px;
}

.settings-menu hr {
    border: 0;
    height: 1px;
    background: #9a9a9a;
    margin: 15px 0;
}

.settings-links {
    display: flex;
    align-items: center;
    margin: 15px 0;
}

.settings-links .settings-icon {
    width: 38px;
    margin-right: 10px;
    border-radius: 50%;
}

.settings-links a {
    display: flex;
    flex: 1;
    align-items: center;
    justify-content: space-between;
    text-decoration: none;
    color: #626262;
}

#dark-btn {
    position: absolute;
    top: 20px;
    right: 20px;
    background: #ccc;
    width: 45px;
    border-radius: 15px;
    padding: 2px 3px;
    cursor: pointer;
    display: flex;
    transition: padding-left 0.5s, background 0.5s;
}

#dark-btn span {
    width: 18px;
    height: 18px;
    background: #fff;
    border-radius: 50%;
    display: inline-block;
}

#dark-btn.dark-btn-on {
    padding-left: 23px;
    background: #0a0a0a;
}

    </style>
</head>

<body>

	<!------------HEADER-------------->
	

	<!-----PROFILE PAGE---->
	<div class="profile-container">
		<img src="../images/background_copy3.png" class="cover-img">
		<div class="profile-details">
			<div class="pd-left">
				<div class="pd-row">
					<!---PROFILE PICTURE-->
					<img src="../images/profile.png" alt="Profile Picture" class="pd-image">
					<div>
						<h3>John Doe</h3>
						<p>1.8K Followers - 120 Following</p>
						<img src="../images/profile.jpg" alt="Joann">
						<img src="../images/profile.jpg" alt="Jagdon">
						<img src="../images/profile.jpg" alt="Alvie">
						<img src="../images/profile.jpg" alt="Fredrick">
					</div>
				</div>
			</div>
			<div class="pd-right">
				<button type="button"> <img src="../images/logo/add-friends.png" alt="Add Friends"> Friends</button>
				<button type="button"> <img src="../images/logo/message.png" alt="Message"> Message</button>
				<br>
				<a href=""><img src="../images/logo/more.png" alt="More"></a>
			</div>
		</div>

		<div class="profile-info">
			<div class="info-col">
				<div class="profile-intro">
					<h3>Intro</h3>
					<p class="intro-text">Finding solace in the pages of books and the whispers of thoughts✨📚
						<img src="../images/feeling.png" alt="Feeling">
					</p>
					<hr>
					<ul>
						<li><img src="../images/profile-study.png" alt="Study"> Bantayan Cebu</li>
						<li><img src="../images/profile-home.png" alt="Home"> Lives in Sample Address</li>
						<li><img src="../images/profile-location.png" alt="Location"> From Sample Address</li>
						<li><img src="../images/confetti.png" alt="Birthday"> Birthday: MM / DD / YYYY</li>
						<li><img src="../images/gender.png" alt="Gender"> Gender: Male</li>
					</ul>
				</div>

				<!------PHOTOS------->
				<div class="profile-intro">
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
				</div>

				<!------FRIENDS------->
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
				</div>
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

					<p class="post-text">Sample post content goes here. This is where the post text will be displayed.</p>
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

					<p class="post-text">Another sample post content goes here. This is where more post text will be displayed.</p>
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

</body>

</html>

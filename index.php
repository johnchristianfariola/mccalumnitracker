<?php
require_once 'controllerUserData.php';

if (isset($_SESSION['alumni'])) {
    if ($_SESSION['forms_completed'] == false) {
        header('location: userpage/alumni_profile.php');
    } else {
        header('location: userpage/index.php');
    }
    exit();
}
?>
<?php

/*
// Get current date
$date = date('Y-m-d');
//
// Check if an entry for today exists
$existingData = $firebase->retrieve("track_visitors/$date");
$existingData = json_decode($existingData, true);

if ($existingData) {
    // Increment visitor count
    $newCount = $existingData['count'] + 1;
    $firebase->update("track_visitors", $date, ['count' => $newCount]);
} else {
    // Create new entry for today
    $firebase->insert("track_visitors", [$date => ['count' => 1]]);
}
*/



$data = $firebase->retrieve("news");
$data = json_decode($data, true);

$eventData = $firebase->retrieve("event");
$eventData = json_decode($eventData, true);

$jobData = $firebase->retrieve("job");
$jobData = json_decode($jobData, true);

// Sort job data by creation date in descending order
usort($jobData, function ($a, $b) {
    return strtotime($b['job_created']) - strtotime($a['job_created']);
});


// Sort data by date in descending order
usort($data, function ($a, $b) {
    return strtotime($b['news_created']) - strtotime($a['news_created']);
});

// Slice to get only the first 5 items
$data = array_slice($data, 0, 5);

?>


<script>

    document.addEventListener('DOMContentLoaded', function () {
        var urlParams = new URLSearchParams(window.location.search);
        var error = urlParams.get('error');
        if (error) {
            var decodedError = decodeURIComponent(error);
            var title, footer;

            if (decodedError.includes("No matching alumni found")) {
                title = "No Match Found";

            } else if (decodedError.includes("already verified")) {
                title = "Already Verified";
                footer = '<a href="#">Forgot your password?</a>';
            } else {
                title = "Oppps..";

            }

            Swal.fire({
                icon: "error",
                title: title,
                text: decodedError,
                footer: footer
            });

            // Remove the error parameter from the URL
            window.history.replaceState({}, document.title, window.location.pathname);
        }
    });
</script>

<!DOCTYPE html>
<html lang="en">

<style>
    .swal2-shown,
    .swal2-height-auto {
        padding: 0 !important;
    }
</style>
<?php include 'includes/header.php' ?>


<body>


    <?php
    if (count($errors) > 0) {
        foreach ($errors as $error) {
            echo "<div class='alert alert-danger text-center'>$error</div>";
        }
    }
    if (isset($_SESSION['info'])) {
        echo "<div class='alert alert-success text-center'>" . $_SESSION['info'] . "</div>";
        unset($_SESSION['info']);
    }
    ?>

    <!-- Navbar Start -->
    <?php include 'includes/navbar.php' ?>
    <!-- Navbar End -->

    <!-- Carousel Start -->
    <div class="container-fluid p-0 mb-5">
        <div class="owl-carousel header-carousel position-relative">
            <div class="owl-carousel-item position-relative">
                <img class="img-fluid" src="homepage/img/carousel-1.png" alt="">
                <div class="position-absolute top-0 start-0 w-100 h-100 d-flex align-items-center"
                    style="background: rgba(24, 29, 56, .7);">
                    <div class="container">
                        <div class="row justify-content-start">
                            <div class="col-sm-10 col-lg-8">
                                <h5 class="text-primary text-uppercase mb-3 animated slideInDown">Welcome Back
                                </h5>
                                <h1 class="display-3 text-white animated slideInDown">Reconnect. Reimagine. Rediscover.
                                </h1>
                                <p class="fs-5 text-white mb-4 pb-2">Welcome to the MCC Alumni Network! We are thrilled
                                    to have you back and eager to help you reconnect with old friends, reimagine your
                                    future, and rediscover the spirit of our beloved institution.</p>
                                <button
                                    class="popup_form btn btn-primary py-md-3 px-md-5 me-3 animated slideInLeft openFormButton">Signin</button>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="owl-carousel-item position-relative">
                <img class="img-fluid" src="homepage/img/graduation_carousel_1.png" alt="">
                <div class="position-absolute top-0 start-0 w-100 h-100 d-flex align-items-center"
                    style="background: rgba(24, 29, 56, .7);">
                    <div class="container">
                        <div class="row justify-content-start">
                            <div class="col-sm-10 col-lg-8">
                                </h5>
                                <h1 class="display-3 text-white animated slideInDown">Exclusive Events & Career
                                    Opportunities
                                </h1>
                                <p class="fs-5 text-white mb-4 pb-2">Gain access to alumni-only events. Explore
                                    exclusive job listings, mentorship programs, and career development resources
                                    tailored just for you. Whether it’s professional networking or social gatherings,
                                    there’s always something exciting happening. Your success is our pride.</p>
                                <button
                                    class="popup_form btn btn-primary py-md-3 px-md-5 me-3 animated slideInLeft openFormButton">Signin</button>

                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="owl-carousel-item position-relative">
                <img class="img-fluid" src="homepage/img/graduation_carousel.png" alt="">
                <div class="position-absolute top-0 start-0 w-100 h-100 d-flex align-items-center"
                    style="background: rgba(24, 29, 56, .7);">
                    <div class="container">
                        <div class="row justify-content-start">
                            <div class="col-sm-10 col-lg-8">
                                </h5>
                                <h1 class="display-3 text-white animated slideInDown">Give Back & Stay Informed
                                </h1>
                                <p class="fs-5 text-white mb-4 pb-2">Share your experience, volunteer, or contribute to
                                    our various programs. Receive updates on the latest news, research breakthroughs,
                                    and achievements from our community. Celebrate the milestones that keep our legacy
                                    alive. Your involvement can inspire current students and shape the future of our
                                    institution.</p>
                                <button
                                    class="popup_form btn btn-primary py-md-3 px-md-5 me-3 animated slideInLeft openFormButton">Signin</button>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Carousel End -->


    <!-- Service Start -->

    <div class="container-xxl py-5">
        <div class="container">
            <div class="row g-4">
                <div class="col-lg-3 col-sm-6 wow fadeInUp" data-wow-delay="0.1s">
                    <div class="service-item text-center pt-3">
                        <div class="p-2" style="height: 250px;"> <!-- Adjust height as needed -->
                            <i class="fa fa-3x fa-newspaper text-primary mb-4"></i>
                            <h5 class="mb-3">News</h5>
                            <p>Explore our comprehensive news section to stay informed about the latest events, and
                                updates</p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-sm-6 wow fadeInUp" data-wow-delay="0.3s">
                    <div class="service-item text-center pt-3">
                        <div class="p-2" style="height: 250px;"> <!-- Adjust height as needed -->
                            <i class="fa fa-3x fa-calendar text-primary mb-4"></i>
                            <h5 class="mb-3">Event</h5>
                            <p>Stay engaged with Madridejos Community College's vibrant alumni network. </p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-sm-6 wow fadeInUp" data-wow-delay="0.5s">
                    <div class="service-item text-center pt-3">
                        <div class="p-2" style="height: 250px;"> <!-- Adjust height as needed -->
                            <i class="fa fa-3x fa-briefcase text-primary mb-4"></i>
                            <h5 class="mb-3">Job Opportunities</h5>
                            <p>Find the latest job openings tailored for our alumni. </p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-sm-6 wow fadeInUp" data-wow-delay="0.7s">
                    <div class="service-item text-center pt-3">
                        <div class="p-2" style="height: 250px;"> <!-- Adjust height as needed -->
                            <i class="fa fa-3x fa-book-open text-primary mb-4"></i>
                            <h5 class="mb-3">Gallery Library</h5>
                            <p>Discover photos, videos, and more from our alumni events and achievements.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Service End -->


    <!-- About Start -->
    <div class="container-xxl py-5">
        <div class="container">
            <div class="row g-5">
                <div class="col-lg-6 wow fadeInUp" data-wow-delay="0.1s" style="min-height: 400px;">
                    <div class="position-relative h-100">
                        <img class="img-fluid position-absolute w-100 h-100"
                            src="homepage/img/Community-College-Madridejos-ee8b60f4.jpeg" alt=""
                            style="object-fit: cover;">
                    </div>
                </div>
                <div class="col-lg-6 wow fadeInUp" data-wow-delay="0.3s">
                    <h6 class="section-title bg-white text-start  pe-3">About Us</h6>
                    <h1 class="mb-4">Welcome to MCC ALUMNI </h1>
                    <p class="mb-4">Welcome to the Madridejos Community College (MCC) Alumni Network! Our community is
                        built on the shared experiences and achievements of our graduates, fostering lifelong
                        connections and supporting each other's professional and personal growth.</p>
                    <div class="row gy-2 gx-4 mb-4">
                        <div class="col-sm-6">
                            <p class="mb-0"><i class="fa fa-arrow-right text-primary me-2"></i>Celebrating Achievements:
                            </p>
                        </div>
                        <div class="col-sm-6">
                            <p class="mb-0"><i class="fa fa-arrow-right text-primary me-2"></i>Lifelong Learning</p>
                        </div>
                        <div class="col-sm-6">
                            <p class="mb-0"><i class="fa fa-arrow-right text-primary me-2"></i>Community Engagement
                            </p>
                        </div>
                        <div class="col-sm-6">
                            <p class="mb-0"><i class="fa fa-arrow-right text-primary me-2"></i>Connecting Graduates</p>
                        </div>
                        <div class="col-sm-6">
                            <p class="mb-0"><i class="fa fa-arrow-right text-primary me-2"></i>Networking Opportunities
                            </p>
                        </div>
                        <div class="col-sm-6">
                            <p class="mb-0"><i class="fa fa-arrow-right text-primary me-2"></i>Career Development
                            </p>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
    <!-- About End -->


    <!-- DEPARTMENT Start -->
    <div class="container-xxl py-5 category">
        <div class="container">
            <div class="text-center wow fadeInUp" data-wow-delay="0.1s">
                <h6 class="section-title bg-white text-center  px-3">DEPARTMENT</h6>
                <h1 class="mb-5">DEPARTMENT</h1>
            </div>
            <div class="row g-3">
                <div class="col-lg-7 col-md-6">
                    <div class="row g-3">
                        <div class="col-lg-6 col-md-12 wow zoomIn" data-wow-delay="0.1s">
                            <a class="position-relative d-block overflow-hidden" href="">
                                <img class="img-fluid" src="homepage/img/bsit.png" alt="">
                                <div class="bg-white text-center position-absolute bottom-0 end-0 py-2 px-3"
                                    style="margin: 1px;">
                                    <h5 class="m-0">IT Department</h5>
                                </div>
                            </a>
                        </div>
                        <div class="col-lg-6 col-md-12 wow zoomIn" data-wow-delay="0.3s">
                            <a class="position-relative d-block overflow-hidden" href="">
                                <img class="img-fluid" src="homepage/img/education.png" alt="">
                                <div class="bg-white text-center position-absolute bottom-0 end-0 py-2 px-3"
                                    style="margin: 1px;">
                                    <h5 class="m-0">Education Department</h5>
                                </div>
                            </a>
                        </div>
                        <div class="col-lg-6 col-md-12 wow zoomIn" data-wow-delay="0.3s">
                            <a class="position-relative d-block overflow-hidden" href="">
                                <img class="img-fluid" src="homepage/img/bshm.png" alt="">
                                <div class="bg-white text-center position-absolute bottom-0 end-0 py-2 px-3"
                                    style="margin: 1px;">
                                    <h5 class="m-0">HM Department</h5>
                                </div>
                            </a>
                        </div>
                        <div class="col-lg-6 col-md-12 wow zoomIn" data-wow-delay="0.5s">
                            <a class="position-relative d-block overflow-hidden" href="">
                                <img class="img-fluid" src="homepage/img/bsba.png" alt="">
                                <div class="bg-white text-center position-absolute bottom-0 end-0 py-2 px-3"
                                    style="margin: 1px;">
                                    <h5 class="m-0">BSBA Department</h5>
                                </div>
                            </a>
                        </div>
                    </div>
                </div>
                <div class="col-lg-5 col-md-6 wow zoomIn" data-wow-delay="0.7s" style="min-height: 350px;">
                    <a class="position-relative d-block h-100 overflow-hidden" href="">
                        <img class="img-fluid position-absolute w-100 h-100"
                            src="homepage/img/sir-manuel-p4eU0iHsBoU-unsplash.jpg" alt="" style="object-fit: cover;">

                    </a>
                </div>
            </div>
        </div>
    </div>
    <!-- DEPARTMENT End -->


    <!-- News Start -->

    </style>


    <div class="container-xxl py-5">
        <div class="container">
            <div class="text-center wow fadeInUp" data-wow-delay="0.2s">
                <h6 class="section-title bg-white text-center px-3">News</h6>
                <h1 class="mb-5">News</h1>
            </div>
            <div class="owl-carousel testimonial-carousel position-relative">
                <?php foreach ($data as $key => $news): ?>
                    <div class="testimonial-item">
                        <div class="item">
                            <a class="openFormButton probootstrap-featured-news-box">
                                <figure class="probootstrap-media">
                                    <img src="admin/<?php echo $news['image_url']; ?>" alt="News Image"
                                        class="img-responsive fixed-dimension-img">
                                </figure>
                                <div class="probootstrap-text">
                                    <h3 class="news-title"><?php echo $news['news_title']; ?></h3>
                                    <p class="news-description"><?php echo strip_tags($news['news_description']); ?></p>
                                    <span class="probootstrap-date"><i
                                            class="icon-calendar"></i><?php echo $news['news_created']; ?></span>
                                </div>
                            </a>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
            <button class="btn openFormButton" style="float:right">View All</button>
        </div>
    </div>
    <!-- News End -->


    <!-- Event Start -->

    <div class="container-xxl py-5">
        <div class="container">
            <div class="text-center wow fadeInUp" data-wow-delay="0.1s">
                <h6 class="section-title bg-white text-center px-3">EVENT</h6>
                <h1 class="mb-5">EVENT</h1>
            </div>
            <div class="row g-4 justify-content-center">
                <?php foreach ($eventData as $key => $event): ?>
                    <div class="col-lg-4 col-md-6 wow fadeInUp" data-wow-delay="0.1s">
                        <div class="item">
                            <center>
                                <a class="openFormButton probootstrap-featured-news-box">
                                    <figure class="probootstrap-media">
                                        <img src="admin/<?php echo $event['image_url']; ?>" alt="Event Image"
                                            class="img-responsive fixed-dimension-img">
                                    </figure>
                                    <div class="probootstrap-text"
                                        style="border-top: 1px solid silver; border-left: 1px solid silver; border-right: 1px solid silver; box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2);">
                                        <h3 class="event-title"><?php echo $event['event_title']; ?></h3>
                                        <p class="event-description"><?php echo strip_tags($event['event_description']); ?>
                                        </p>
                                        <span class="probootstrap-date" style="font-size:14px"><i
                                                class="icon-calendar"></i><b>Date Posted:</b>
                                            <?php echo $event['event_created']; ?> | <b>Date of Event:</b>
                                            <?php echo $event['event_date']; ?></span>
                                    </div>
                                </a>
                            </center>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
            <button class="btn openFormButton" style="float:right">View All</button>
        </div>
    </div>


    <!-- Event End -->


    <div class="container-xxl py-5">
        <div class="container">
            <div class="text-center wow fadeInUp" data-wow-delay="0.1s">
                <h6 class="section-title bg-white text-center px-3">JOBS</h6>
                <h1 class="mb-5">Available Job Listings</h1>
            </div>
            <div class="row g-4 justify-content-center">
                <?php foreach ($jobData as $key => $job): ?>
                    <div class="col-lg-4 col-md-6 wow fadeInUp" data-wow-delay="0.1s">
                        <div class="item">
                            <center>
                                <a class="openFormButton probootstrap-featured-news-box">
                                    <figure class="probootstrap-media">
                                        <img src="admin/<?php echo $job['image_path']; ?>" alt="Job Image"
                                            class="img-responsive fixed-dimension-img">
                                    </figure>
                                    <div class="probootstrap-text"
                                        style="border-top: 1px solid silver; border-left: 1px solid silver; border-right: 1px solid silver; box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2);">
                                        <h3 class="job-title"><?php echo $job['job_title']; ?></h3>
                                        <p class="event-description"><?php echo strip_tags($job['job_description']); ?></p>
                                        <span class="probootstrap-date" style="font-size:14px"><i
                                                class="icon-calendar"></i><b>Date Posted:</b>
                                            <?php echo $job['job_created']; ?> | <b>Company:</b>
                                            <?php echo $job['company_name']; ?> | <b>Work Time:</b>
                                            <?php echo $job['work_time']; ?></span>
                                    </div>
                                </a>
                            </center>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>


    <!-- Team Start
    <div class="container-xxl py-5">
        <div class="container">
            <div class="text-center wow fadeInUp" data-wow-delay="0.1s">
                <h6 class="section-title bg-white text-center  px-3">Instructors</h6>
                <h1 class="mb-5">Expert Instructors</h1>
            </div>
            <div class="row g-4">
                <div class="col-lg-3 col-md-6 wow fadeInUp" data-wow-delay="0.1s">
                    <div class="team-item bg-light">
                        <div class="overflow-hidden">
                            <img class="img-fluid" src="homepage/img/profile.jpg" alt="">
                        </div>
                        <div class="position-relative d-flex justify-content-center" style="margin-top: -23px;">
                            <div class="bg-light d-flex justify-content-center pt-2 px-1">
                                <a class="btn btn-sm-square btn-primary mx-1" href=""><i
                                        class="fab fa-facebook-f"></i></a>
                                <a class="btn btn-sm-square btn-primary mx-1" href=""><i class="fab fa-twitter"></i></a>
                                <a class="btn btn-sm-square btn-primary mx-1" href=""><i
                                        class="fab fa-instagram"></i></a>
                            </div>
                        </div>
                        <div class="text-center p-4">
                            <h5 class="mb-0">Instructor Name</h5>
                            <small>Designation</small>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 wow fadeInUp" data-wow-delay="0.3s">
                    <div class="team-item bg-light">
                        <div class="overflow-hidden">
                            <img class="img-fluid" src="homepage/img/profile.jpg" alt="">
                        </div>
                        <div class="position-relative d-flex justify-content-center" style="margin-top: -23px;">
                            <div class="bg-light d-flex justify-content-center pt-2 px-1">
                                <a class="btn btn-sm-square btn-primary mx-1" href=""><i
                                        class="fab fa-facebook-f"></i></a>
                                <a class="btn btn-sm-square btn-primary mx-1" href=""><i class="fab fa-twitter"></i></a>
                                <a class="btn btn-sm-square btn-primary mx-1" href=""><i
                                        class="fab fa-instagram"></i></a>
                            </div>
                        </div>
                        <div class="text-center p-4">
                            <h5 class="mb-0">Instructor Name</h5>
                            <small>Designation</small>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 wow fadeInUp" data-wow-delay="0.5s">
                    <div class="team-item bg-light">
                        <div class="overflow-hidden">
                            <img class="img-fluid" src="homepage/img/profile.jpg" alt="">
                        </div>
                        <div class="position-relative d-flex justify-content-center" style="margin-top: -23px;">
                            <div class="bg-light d-flex justify-content-center pt-2 px-1">
                                <a class="btn btn-sm-square btn-primary mx-1" href=""><i
                                        class="fab fa-facebook-f"></i></a>
                                <a class="btn btn-sm-square btn-primary mx-1" href=""><i class="fab fa-twitter"></i></a>
                                <a class="btn btn-sm-square btn-primary mx-1" href=""><i
                                        class="fab fa-instagram"></i></a>
                            </div>
                        </div>
                        <div class="text-center p-4">
                            <h5 class="mb-0">Instructor Name</h5>
                            <small>Designation</small>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 wow fadeInUp" data-wow-delay="0.7s">
                    <div class="team-item bg-light">
                        <div class="overflow-hidden">
                            <img class="img-fluid" src="homepage/img/profile.jpg" alt="">
                        </div>
                        <div class="position-relative d-flex justify-content-center" style="margin-top: -23px;">
                            <div class="bg-light d-flex justify-content-center pt-2 px-1">
                                <a class="btn btn-sm-square btn-primary mx-1" href=""><i
                                        class="fab fa-facebook-f"></i></a>
                                <a class="btn btn-sm-square btn-primary mx-1" href=""><i class="fab fa-twitter"></i></a>
                                <a class="btn btn-sm-square btn-primary mx-1" href=""><i
                                        class="fab fa-instagram"></i></a>
                            </div>
                        </div>
                        <div class="text-center p-4">
                            <h5 class="mb-0">Instructor Name</h5>
                            <small>Designation</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
        Team End -->


    <!-- Testimonial Start
    <div class="container-xxl py-5 wow fadeInUp" data-wow-delay="0.1s">
        <div class="container">
            <div class="text-center">
                <h6 class="section-title bg-white text-center px-3">Testimonial</h6>
                <h1 class="mb-5">Our Students Say!</h1>
            </div>
            <div class="owl-carousel testimonial-carousel position-relative">
                <div class="testimonial-item text-center">
                    <img class="border rounded-circle p-2 mx-auto mb-3" src="homepage/img/profile.jpg"
                        style="width: 80px; height: 80px;">
                    <h5 class="mb-0">Student Name</h5>
                    <p>Profession</p>
                    <div class="testimonial-text bg-light text-center p-4">
                        <p class="mb-0">My experience at Madridejos Community College has been exceptional. The
                            instructors are highly knowledgeable and approachable, always ready to provide extra help
                            when needed. The college's facilities are well-maintained and equipped with the necessary
                            resources, which enhances the learning experience. Being part of this community has given me
                            a sense of belonging and has motivated me to excel in my studies.</p>
                    </div>
                </div>
                <div class="testimonial-item text-center">
                    <img class="border rounded-circle p-2 mx-auto mb-3" src="homepage/img/profile.jpg"
                        style="width: 80px; height: 80px;">
                    <h5 class="mb-0">Student Name</h5>
                    <p>Profession</p>
                    <div class="testimonial-text bg-light text-center p-4">
                        <p class="mb-0">While the education at Madridejos Community College is of high quality, I feel
                            there could be more extracurricular activities and clubs available for students. Engaging in
                            various interests outside the classroom would help us develop a well-rounded skill set and
                            build stronger connections with our peers. Additionally, expanding the library's resources
                            and incorporating more digital materials would be beneficial for our academic research</p>
                    </div>
                </div>
                <div class="testimonial-item text-center">
                    <img class="border rounded-circle p-2 mx-auto mb-3" src="homepage/img/profile.jpg"
                        style="width: 80px; height: 80px;">
                    <h5 class="mb-0">Student Name</h5>
                    <p>Profession</p>
                    <div class="testimonial-text bg-light text-center p-4">
                        <p class="mb-0">Studying at Madridejos Community College has been a rewarding experience. The
                            campus atmosphere is peaceful, and the small class sizes allow for more personalized
                            attention from the instructors. However, I believe there is room for improvement in terms of
                            updating the technology used in some of the classrooms. Overall, I am pleased with my
                            education here and confident it will serve me well in my future career</p>
                    </div>
                </div>
                <div class="testimonial-item text-center">
                    <img class="border rounded-circle p-2 mx-auto mb-3" src="homepage/img/profile.jpg"
                        style="width: 80px; height: 80px;">
                    <h5 class="mb-0">Student Name</h5>
                    <p>Profession</p>
                    <div class="testimonial-text bg-light text-center p-4">
                        <p class="mb-0">As an alumnus of Madridejos Community College, I can confidently say that the
                            education and experiences I gained here have been instrumental in shaping my career. The
                            college not only provided a solid academic foundation but also emphasized practical skills
                            and real-world applications, particularly in my BSIT course. The support from the faculty
                            and the strong sense of community among students and alumni have been invaluable. I would
                            recommend MCC to anyone looking for a nurturing and effective learning environment</p>
                    </div>
                </div>
            </div>
        </div>
         Testimonial End  -->


    <!-- Footer Start -->
    <?php include 'includes/footer.php' ?>
    <!-- Footer End -->


    <!-- Back to Top -->
    <a href="#" class="btn btn-lg btn-primary btn-lg-square back-to-top"><i class="bi bi-arrow-up"></i></a>
    
    <!-- JavaScript Libraries -->
    <script nonce="<random-nonce>" src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script nonce="<random-nonce>" src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>
    <script nonce="<random-nonce>"  src="homepage/lib/wow/wow.min.js"></script>
    <script nonce="<random-nonce>" src="homepage/lib/easing/easing.min.js"></script>
    <script nonce="<random-nonce>" src="homepage/lib/waypoints/waypoints.min.js"></script>
    <script nonce="<random-nonce>"  src="homepage/lib/owlcarousel/owl.carousel.min.js"></script>

    <!-- Template Javascript -->
    <script nonce="<random-nonce>" src="homepage/js/main.js"></script>

    <script>
        // Disable right-click
        document.addEventListener('contextmenu', function (e) {
            e.preventDefault();
        });

        // Disable F12, Ctrl+Shift+I, Ctrl+Shift+J, Ctrl+U
        document.onkeydown = function (e) {
            if (
                e.key === 'F12' ||
                (e.ctrlKey && e.shiftKey && (e.key === 'I' || e.key === 'J')) ||
                (e.ctrlKey && e.key === 'U')
            ) {
                e.preventDefault();
            }
        };

        // Disable developer tools
        function disableDevTools() {
            if (window.devtools.isOpen) {
                window.location.href = "about:blank";
            }
        }

        // Check for developer tools every 100ms
        setInterval(disableDevTools, 100);

        // Disable selecting text
        document.onselectstart = function (e) {
            e.preventDefault();
        };
    </script>
    <!-- Modal -->
    <?php include 'includes/auth.php' ?>

</body>

</html>
<?php include 'includes/session.php'; ?>

<!DOCTYPE html>
<html lang="en">


<?php include 'includes/header.php' ?>


<body>
    <!-- Spinner Start -->
    <div id="spinner"
        class="show bg-white position-fixed translate-middle w-100 vh-100 top-50 start-50 d-flex align-items-center justify-content-center">
        <div class="spinner-border text-primary" style="width: 3rem; height: 3rem;" role="status">
            <span class="sr-only">Loading...</span>
        </div>
    </div>
    <!-- Spinner End -->

 
    <!-- Navbar Start -->
    <?php include 'includes/navbar.php' ?>
    <!-- Navbar End -->


    <!-- Carousel Start -->
    <div class="container-fluid p-0 mb-5" style="height: 40%">
    <div class="position-relative">
        <img class="img-fluid" src="homepage/img/carousel-1.png" alt="" style="height: 150px; width: 100%; object-fit: cover;">
        <div class="position-absolute top-0 start-0 w-100 h-100 d-flex align-items-center"
            style="background: rgba(24, 29, 56, .7);">
            <div class="container">
                <div class="row justify-content-start">
                    <!-- Your content here -->
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
                        <div class="p-4">
                            <i class="fa fa-3x  fa-newspaper text-primary mb-4"></i>
                            <h5 class="mb-3">News</h5>
                            <p>Diam elitr kasd sed at elitr sed ipsum justo dolor sed clita amet diam</p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-sm-6 wow fadeInUp" data-wow-delay="0.3s">
                    <div class="service-item text-center pt-3">
                        <div class="p-4">
                            <i class="fa fa-3x fa-calendar text-primary mb-4"></i>
                            <h5 class="mb-3">Event</h5>
                            <p>Diam elitr kasd sed at elitr sed ipsum justo dolor sed clita amet diam</p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-sm-6 wow fadeInUp" data-wow-delay="0.5s">
                    <div class="service-item text-center pt-3">
                        <div class="p-4">
                            <i class="fa fa-3x fa-briefcase text-primary mb-4"></i>
                            <h5 class="mb-3">Job Opportunities</h5>
                            <p>Diam elitr kasd sed at elitr sed ipsum justo dolor sed clita amet diam</p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-sm-6 wow fadeInUp" data-wow-delay="0.7s">
                    <div class="service-item text-center pt-3">
                        <div class="p-4">
                            <i class="fa fa-3x fa-book-open text-primary mb-4"></i>
                            <h5 class="mb-3">Gallery Library</h5>
                            <p>Diam elitr kasd sed at elitr sed ipsum justo dolor sed clita amet diam</p>
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
                            src="homepage/img/Community-College-Madridejos-ee8b60f4.jpeg" alt="" style="object-fit: cover;">
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
    <!-- DEPARTMENT Start -->


    <!-- News Start -->
    <div class="container-xxl py-5">
        <div class="container">
            <div class="text-center wow fadeInUp" data-wow-delay="0.2s">
                <h6 class="section-title bg-white text-center px-3">News</h6>
                <h1 class="mb-5">News</h1>
            </div>
            <div class="owl-carousel testimonial-carousel position-relative">


                <div class="testimonial-item">

                    <div class="item">
                        <a href="#" class="probootstrap-featured-news-box">
                            <center>
                                <figure class="probootstrap-media">
                                    <img src="homepage/img/carousel-1.png" alt="Free Bootstrap Template by ProBootstrap.com"
                                        class="img-responsive fixed-dimension-img">
                                </figure>
                            </center>
                            <div class="probootstrap-text">
                                <h3>Tempora consectetur unde nisi</h3>
                                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Minima, ut.</p>
                                <span class="probootstrap-date"><i class="icon-calendar"></i>July 9, 2017</span>
                            </div>
                        </a>
                    </div>
                </div>

                <div class="testimonial-item">

                    <div class="item">
                        <a href="#" class="probootstrap-featured-news-box">
                            <center>
                                <figure class="probootstrap-media">
                                    <img src="user\img\graduation_carousel.png"
                                        alt="Free Bootstrap Template by ProBootstrap.com"
                                        class="img-responsive fixed-dimension-img">
                                </figure>
                            </center>
                            <div class="probootstrap-text">
                                <h3>Tempora consectetur unde nisi</h3>
                                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Minima, ut.</p>
                                <span class="probootstrap-date"><i class="icon-calendar"></i>July 9, 2017</span>
                            </div>
                        </a>
                    </div>
                </div>

                <div class="testimonial-item">

                    <div class="item">
                        <a href="#" class="probootstrap-featured-news-box">
                            <center>
                                <figure class="probootstrap-media">
                                    <img src="homepage/img/graduation_carousel_1.png"
                                        alt="Free Bootstrap Template by ProBootstrap.com"
                                        class="img-responsive fixed-dimension-img">
                                </figure>
                            </center>
                            <div class="probootstrap-text">
                                <h3>Tempora consectetur unde nisi</h3>
                                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Minima, ut.</p>
                                <span class="probootstrap-date"><i class="icon-calendar"></i>July 9, 2017</span>
                            </div>
                        </a>
                    </div>
                </div>

            </div>
            <button class="btn" style="float:right" data-toggle="modal" data-target="#signInModal">View All</button>

        </div>
    </div>
    <!-- News End -->

    <!--Event Start -->
    <div class="container-xxl py-5">
        <div class="container">
            <div class="text-center wow fadeInUp" data-wow-delay="0.1s">
                <h6 class="section-title bg-white text-center px-3">EVENT</h6>
                <h1 class="mb-5">EVENT</h1>
            </div>
            <div class="row g-4 justify-content-center">
                <div class="col-lg-4 col-md-6 wow fadeInUp" data-wow-delay="0.1s">

                    <div class="item">
                        <center>
                            <a href="#" class="probootstrap-featured-news-box">
                                <figure class="probootstrap-media"><img
                                        src="homepage/img/sir-manuel-p4eU0iHsBoU-unsplash.jpg"
                                        alt="Free Bootstrap Template by ProBootstrap.com" class="img-responsive">
                                </figure>
                                <div class="probootstrap-text">
                                    <h3>Tempora consectetur unde nisi</h3>
                                    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Minima, ut.</p>
                                    <span class="probootstrap-date"><i class="icon-calendar"></i>July 9, 2017</span>

                                </div>
                            </a>
                        </center>
                    </div>

                </div>
                <div class="col-lg-4 col-md-6 wow fadeInUp" data-wow-delay="0.2s">

                    <div class="item">
                        <center>
                            <a href="#" class="probootstrap-featured-news-box">
                                <figure class="probootstrap-media"><img
                                        src="homepage/img/sir-manuel-p4eU0iHsBoU-unsplash.jpg"
                                        alt="Free Bootstrap Template by ProBootstrap.com" class="img-responsive">
                                </figure>
                                <div class="probootstrap-text">
                                    <h3>Tempora consectetur unde nisi</h3>
                                    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Minima, ut.</p>
                                    <span class="probootstrap-date"><i class="icon-calendar"></i>July 9, 2017</span>

                                </div>
                            </a>
                        </center>
                    </div>

                </div>
                <div class="col-lg-4 col-md-6 wow fadeInUp" data-wow-delay="0.3s">

                    <div class="item">
                        <center>
                            <a href="#" class="probootstrap-featured-news-box">
                                <figure class="probootstrap-media"><img
                                        src="homepage/img/sir-manuel-p4eU0iHsBoU-unsplash.jpg"
                                        alt="Free Bootstrap Template by ProBootstrap.com" class="img-responsive">
                                </figure>
                                <div class="probootstrap-text">
                                    <h3>Tempora consectetur unde nisi</h3>
                                    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Minima, ut.</p>
                                    <span class="probootstrap-date"><i class="icon-calendar"></i>July 9, 2017</span>

                                </div>
                            </a>
                        </center>
                    </div>

                </div>
                <div class="col-lg-4 col-md-6 wow fadeInUp" data-wow-delay="0.4s">

                    <div class="item">
                        <center>
                            <a href="#" class="probootstrap-featured-news-box">
                                <figure class="probootstrap-media"><img
                                        src="homepage/img/sir-manuel-p4eU0iHsBoU-unsplash.jpg"
                                        alt="Free Bootstrap Template by ProBootstrap.com" class="img-responsive">
                                </figure>
                                <div class="probootstrap-text">
                                    <h3>Tempora consectetur unde nisi</h3>
                                    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Minima, ut.</p>
                                    <span class="probootstrap-date"><i class="icon-calendar"></i>July 9, 2017</span>

                                </div>
                            </a>
                        </center>
                    </div>

                </div>
                <div class="col-lg-4 col-md-6 wow fadeInUp" data-wow-delay="0.5s">

                    <div class="item">
                        <center>
                            <a href="#" class="probootstrap-featured-news-box">
                                <figure class="probootstrap-media"><img
                                        src="homepage/img/sir-manuel-p4eU0iHsBoU-unsplash.jpg"
                                        alt="Free Bootstrap Template by ProBootstrap.com" class="img-responsive">
                                </figure>
                                <div class="probootstrap-text">
                                    <h3>Tempora consectetur unde nisi</h3>
                                    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Minima, ut.</p>
                                    <span class="probootstrap-date"><i class="icon-calendar"></i>July 9, 2017</span>

                                </div>
                            </a>
                        </center>
                    </div>

                </div>
                <div class="col-lg-4 col-md-6 wow fadeInUp" data-wow-delay="0.6s">

                    <div class="item">
                        <center>
                            <a href="#" class="probootstrap-featured-news-box">
                                <figure class="probootstrap-media"><img
                                        src="homepage/img/sir-manuel-p4eU0iHsBoU-unsplash.jpg"
                                        alt="Free Bootstrap Template by ProBootstrap.com" class="img-responsive">
                                </figure>
                                <div class="probootstrap-text">
                                    <h3>Tempora consectetur unde nisi</h3>
                                    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Minima, ut.</p>
                                    <span class="probootstrap-date"><i class="icon-calendar"></i>July 9, 2017</span>

                                </div>
                            </a>
                        </center>
                    </div>

                </div>

            </div>
            <button class="btn" style="float:right" data-toggle="modal" data-target="#signInModal">View All</button>

        </div>
    </div>
    <!-- Event End -->



    <!-- Team Start -->
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
    <!-- Team End -->


    <!-- Testimonial Start -->
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
                    <h5 class="mb-0">Client Name</h5>
                    <p>Profession</p>
                    <div class="testimonial-text bg-light text-center p-4">
                        <p class="mb-0">Tempor erat elitr rebum at clita. Diam dolor diam ipsum sit diam amet diam et
                            eos. Clita erat ipsum et lorem et sit.</p>
                    </div>
                </div>
                <div class="testimonial-item text-center">
                    <img class="border rounded-circle p-2 mx-auto mb-3" src="homepage/img/profile.jpg"
                        style="width: 80px; height: 80px;">
                    <h5 class="mb-0">Client Name</h5>
                    <p>Profession</p>
                    <div class="testimonial-text bg-light text-center p-4">
                        <p class="mb-0">Tempor erat elitr rebum at clita. Diam dolor diam ipsum sit diam amet diam et
                            eos. Clita erat ipsum et lorem et sit.</p>
                    </div>
                </div>
                <div class="testimonial-item text-center">
                    <img class="border rounded-circle p-2 mx-auto mb-3" src="homepage/img/profile.jpg"
                        style="width: 80px; height: 80px;">
                    <h5 class="mb-0">Client Name</h5>
                    <p>Profession</p>
                    <div class="testimonial-text bg-light text-center p-4">
                        <p class="mb-0">Tempor erat elitr rebum at clita. Diam dolor diam ipsum sit diam amet diam et
                            eos. Clita erat ipsum et lorem et sit.</p>
                    </div>
                </div>
                <div class="testimonial-item text-center">
                    <img class="border rounded-circle p-2 mx-auto mb-3" src="homepage/img/profile.jpg"
                        style="width: 80px; height: 80px;">
                    <h5 class="mb-0">Client Name</h5>
                    <p>Profession</p>
                    <div class="testimonial-text bg-light text-center p-4">
                        <p class="mb-0">Tempor erat elitr rebum at clita. Diam dolor diam ipsum sit diam amet diam et
                            eos. Clita erat ipsum et lorem et sit.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Testimonial End -->


    <!-- Footer Start -->
    <?php include 'includes/footer.php' ?>
    <!-- Footer End -->


    <!-- Back to Top -->
    <a href="#" class="btn btn-lg btn-primary btn-lg-square back-to-top"><i class="bi bi-arrow-up"></i></a>
    <!-- JavaScript Libraries -->
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="homepage/lib/wow/wow.min.js"></script>


  
    <!-- Template Javascript -->
    <script src="homepage/js/main.js"></script>


    <!-- Modal -->
    <?php include 'includes/auth.php' ?>
</body>

</html>
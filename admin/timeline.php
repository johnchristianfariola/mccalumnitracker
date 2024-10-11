<?php include 'includes/session.php'; ?>
<?php include 'includes/header.php'; ?>
<?php
require_once 'includes/firebaseRDB.php';

require_once 'includes/config.php'; // Include your config file
$firebase = new firebaseRDB($databaseURL);
// Fetch gallery data from Firebase
$surveyData = $firebase->retrieve("survey_set");

// Decode JSON data into associative arrays
$survey = json_decode($surveyData, true) ?: [];
?>




<body class="hold-transition skin-blue sidebar-mini">
    <div class="wrapper">

        <?php include 'includes/navbar.php'; ?>
        <?php include 'includes/menubar.php'; ?>

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <!-- Content Header (Page header) -->
            <section class="content-header box-header-background">
                <h1>
                    Account Activity
                </h1>
                <div class="box-inline ">


                    <div class="search-container">
                        <input type="text" class="search-input" id="search-input" placeholder="Search...">
                        <button class="search-button" onclick="filterTable()">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round" class="feather feather-search">
                                <circle cx="11" cy="11" r="8"></circle>
                                <line x1="21" y1="21" x2="16.65" y2="16.65"></line>
                            </svg>
                        </button>
                    </div>
                </div>


            </section>
            <!-- Main content -->
            <section class="content">
                <?php
                if (isset($_SESSION['error'])) {
                    echo "
            <div class='alert alert-danger alert-dismissible'>
              <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
              <h4><i class='icon fa fa-warning'></i> Reminder</h4>
              " . $_SESSION['error'] . "
            </div>
          ";
                    unset($_SESSION['error']);
                }
                if (isset($_SESSION['success'])) {
                    echo "
            <div class='alert alert-success alert-dismissible'>
              <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
              <h4><i class='icon fa fa-check'></i> Success!</h4>
              " . $_SESSION['success'] . "
            </div>
          ";
                    unset($_SESSION['success']);
                }
                ?>



                <div class="row">
                    <div class="col-xs-12">
                        <div class="box"
                            style="min-height:20px; background: transparent !important; border:none; box-shadow:none">

                            <div class="box-body" style="padding:30px; ">
                                <div class="col-md-9">
                                    <div class="nav-tabs-custom">
                                        <ul class="nav nav-tabs">
                                           
                                            <li><a href="#timeline" data-toggle="tab">Timeline</a></li>
                                           
                                        </ul>
                                        <div class="tab-content">
                                            <div class="active tab-pane" id="activity">
                                            </div>
                                            <!-- /.tab-pane -->
                                            <div class="tab-pane" id="timeline">
                                                <!-- The timeline -->
                                                <ul class="timeline timeline-inverse">
                                                    <!-- timeline time label -->
                                                    <li class="time-label">
                                                        <span class="bg-red">
                                                            10 Feb. 2014
                                                        </span>
                                                    </li>
                                                    <!-- /.timeline-label -->
                                                    <!-- timeline item -->
                                                    <li>
                                                        <i class="fa fa-envelope bg-blue"></i>

                                                        <div class="timeline-item">
                                                            <span class="time"><i class="fa fa-clock-o"></i>
                                                                12:05</span>

                                                            <h3 class="timeline-header"><a href="#">Support Team</a>
                                                                sent you an email</h3>

                                                            <div class="timeline-body">
                                                                Etsy doostang zoodles disqus groupon greplin oooj voxy
                                                                zoodles,
                                                                weebly ning heekya handango imeem plugg dopplr jibjab,
                                                                movity
                                                                jajah plickers sifteo edmodo ifttt zimbra. Babblely odeo
                                                                kaboodle
                                                                quora plaxo ideeli hulu weebly balihoo...
                                                            </div>
                                                            <div class="timeline-footer">
                                                                <a class="btn btn-primary btn-xs">Read more</a>
                                                                <a class="btn btn-danger btn-xs">Delete</a>
                                                            </div>
                                                        </div>
                                                    </li>
                                                    <!-- END timeline item -->
                                                    <!-- timeline item -->
                                                    <li>
                                                        <i class="fa fa-user bg-aqua"></i>

                                                        <div class="timeline-item">
                                                            <span class="time"><i class="fa fa-clock-o"></i> 5 mins
                                                                ago</span>

                                                            <h3 class="timeline-header no-border"><a href="#">Sarah
                                                                    Young</a> accepted your friend request
                                                            </h3>
                                                        </div>
                                                    </li>
                                                    <!-- END timeline item -->
                                                    <!-- timeline item -->
                                                    <li>
                                                        <i class="fa fa-comments bg-yellow"></i>

                                                        <div class="timeline-item">
                                                            <span class="time"><i class="fa fa-clock-o"></i> 27 mins
                                                                ago</span>

                                                            <h3 class="timeline-header"><a href="#">Jay White</a>
                                                                commented on your post</h3>

                                                            <div class="timeline-body">
                                                                Take me to your leader!
                                                                Switzerland is small and neutral!
                                                                We are more like Germany, ambitious and misunderstood!
                                                            </div>
                                                            <div class="timeline-footer">
                                                                <a class="btn btn-warning btn-flat btn-xs">View
                                                                    comment</a>
                                                            </div>
                                                        </div>
                                                    </li>
                                                    <!-- END timeline item -->
                                                    <!-- timeline time label -->
                                                    <li class="time-label">
                                                        <span class="bg-green">
                                                            3 Jan. 2014
                                                        </span>
                                                    </li>
                                                    <!-- /.timeline-label -->
                                                    <!-- timeline item -->
                                                    <li>
                                                        <i class="fa fa-camera bg-purple"></i>

                                                        <div class="timeline-item">
                                                            <span class="time"><i class="fa fa-clock-o"></i> 2 days
                                                                ago</span>

                                                            <h3 class="timeline-header"><a href="#">Mina Lee</a>
                                                                uploaded new photos</h3>

                                                            <div class="timeline-body">
                                                                <img src="http://placehold.it/150x100" alt="..."
                                                                    class="margin">
                                                                <img src="http://placehold.it/150x100" alt="..."
                                                                    class="margin">
                                                                <img src="http://placehold.it/150x100" alt="..."
                                                                    class="margin">
                                                                <img src="http://placehold.it/150x100" alt="..."
                                                                    class="margin">
                                                            </div>
                                                        </div>
                                                    </li>
                                       
                                                    <li>
                                                        <i class="fa fa-clock-o bg-gray"></i>
                                                    </li>
                                                </ul>
                                            </div>
                                          
                                        </div>
                                
                                    </div>
                                  
                                </div>
                            </div>
                        </div>
                    </div>
                </div>


            </section>
        </div>

        <?php include 'includes/footer.php'; ?>
        <?php include 'includes/survey_modal.php'; ?>
    </div>
    <?php include 'includes/scripts.php'; ?>
    <script>

    </script>
</body>

</html>
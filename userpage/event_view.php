<?php include '../includes/session.php'; ?>


<!doctype html>
<html class="no-js" lang="">

<head>
    <?php include 'includes/header.php' ?>
</head>

<body>

    <?php include 'includes/navbar.php' ?>



    <div class="container-xxl py-5" style="margin-top:50px; margin-bottom:90px">
        <div class="container">
            <div class="text-center wow fadeInUp" data-wow-delay="0.1s">

                <h1 class="mb-5">EVENT</h1>
            </div>
            <?php
            require_once '../includes/firebaseRDB.php';

            require_once '../includes/config.php'; // Include your config file
            $firebase = new firebaseRDB($databaseURL);

            $data = $firebase->retrieve("event");
            $data = json_decode($data, true);

            $messages = json_decode($firebase->retrieve("messages"), true);

            // Convert messages array to JSON for JavaScript
            $messages_json = json_encode($messages);

            foreach ($data as $eventID => $event) {
                $eventTitle = $event['event_title'];
                $eventDate = $event['event_date'];
                $eventDescription = $event['event_description'];
                $imageUrl = $event['image_url'];
                ?>

                <div class="col-lg-4 col-md-6 wow fadeInUp" data-wow-delay="0.1s">
                    <div class="item">
                        <center>
                            <a href="visit_event.php?id=<?php echo $eventID; ?>" class="probootstrap-featured-news-box">
                                <figure class="probootstrap-media">
                                    <img src="../admin/<?php echo $imageUrl; ?>" alt="Event Image" class="img-responsive">
                                </figure>
                                <div class="probootstrap-text">
                                    <h3><?php echo $eventTitle; ?></h3>
                                    <div class="description"><?php echo $eventDescription; ?></div>
                                    <div class="probootstrap-date">
                                        <i class="icon-calendar"></i><?php echo $eventDate; ?>
                                    </div>
                                </div>
                            </a>
                        </center>
                    </div>
                </div>

                <?php
            }
            ?>





        </div>
    </div>

   <?php include 'global_chatbox.php'?>


</body>

</html>
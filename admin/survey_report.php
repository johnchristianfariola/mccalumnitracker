<?php include 'includes/session.php'; ?>
<?php include 'includes/header.php'; ?>
<?php
require_once 'includes/firebaseRDB.php';

// Your Firebase Realtime Database URL
$databaseURL = "https://mccnians-bc4f4-default-rtdb.firebaseio.com/";

// Create an instance of the firebaseRDB class
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
                    Survey <i class="fa fa-angle-right"></i> Survey List
                </h1>
                <div class="box-inline ">

                    <a href="#addnew" data-toggle="modal" class="btn-add-class btn btn-primary btn-sm btn-flat"><i
                            class="fa fa-plus-circle"></i>&nbsp;&nbsp; New</a>

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
              <h4><i class='icon fa fa-warning'></i> Error!</h4>
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
                    <div class="col-md-3 py-1 px-1 survey-item">
                        <div class="card card-outline card-primary">
                            <div class="container">
                                <div class="survey-card">
                                    <div class="cars-detail">
                                    <div class="survey_title">
                                    <h3>TITLE</h3>
                                    </div>
                                    <p>DESCRIIPTION</p>
                                    </div>
                                    <div class="overlay" style="background-color: rgba(0, 0, 0, 0.5);">
                                        <a href="" target="_parent" class='btn btn-default btn-class'
                                            style="opacity: 1; background:linear-gradient(to right, #90caf9, #047edf 99%); color:white; width: 100px; border: none; ">View</a>
                                    </div>
                                </div>
                                <div class="survey-card">
                                    <div class="cars-detail">
                                    <div class="survey_title">
                                    <h3>TITLE</h3>
                                    </div>
                                   
                                    <p>TITLE</p>
                                    </div>
                                    <div class="overlay" style="background-color: rgba(0, 0, 0, 0.5);">
                                        <a href="" target="_parent" class='btn btn-default btn-class'
                                            style="opacity: 1; background:linear-gradient(to right, #90caf9, #047edf 99%); color:white; width: 100px; border: none; ">View</a>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                    <!-- Repeat the above structure for each survey item -->
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


<style>
    .container {
        display: flex;
        flex-wrap: wrap;
        justify-content: flex-start;
        gap: 28px;
        /* Adjust the gap between items */
    }

    .survey-card {
        position: relative;
        width: 300px;
        height: 250px;
        overflow: hidden;
        background-color: white;
        

    }

    .survey_title{
        border-bottom: 4px solid silver;
        margin-bottom: 5px;
    }
    .cars-detail{
        padding: 20px;
    }
    .overlay {
        position: absolute;
        top: 100%;
        left: 0;
        width: 100%;
        height: 100%;
        display: flex;
        justify-content: center;
        align-items: center;

        transition: top 0.3s ease;
    }

    .survey-card:hover .overlay {
        top: 0;
        background-color: #333;
    }

    .overlay a {
        text-decoration: none;
        color: white;
        background: linear-gradient(to right, #90caf9, #047edf 99%);
        padding: 10px 20px;
        border-radius: 5px;
    }
</style>
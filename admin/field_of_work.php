<?php include 'includes/session.php'; ?>
<?php include 'includes/header.php'; ?>
<?php
require_once 'includes/firebaseRDB.php';
require_once 'includes/config.php'; // Include your config file

$firebase = new firebaseRDB($databaseURL);

function getFirebaseData($firebase, $path)
{
  $data = $firebase->retrieve($path);
  return json_decode($data, true);
}

function sanitizeInput($data)
{
  return htmlspecialchars(strip_tags($data));
}

$alumniData = getFirebaseData($firebase, "alumni");
$batchData = getFirebaseData($firebase, "batch_yr");
$courseData = getFirebaseData($firebase, "course");
$categoryData = getFirebaseData($firebase, "category");

$filterCourse = isset($_GET['course']) ? sanitizeInput($_GET['course']) : '';
$filterBatch = isset($_GET['batch']) ? sanitizeInput($_GET['batch']) : '';
$filterStatus = isset($_GET['work_status']) ? sanitizeInput($_GET['work_status']) : '';
$filterWorkClassification = isset($_GET['work_classification']) ? sanitizeInput($_GET['work_classification']) : '';

// Initialize counters
$employedCount = 0;
$unemployedCount = 0;
$totalCount = 0;


?>

<body class="hold-transition skin-blue sidebar-mini">
  <div class="wrapper">

    <?php include 'includes/navbar.php'; ?>
    <?php include 'includes/menubar.php'; ?>

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper content-flex">
      <!-- Main container -->
      <div class="main-container">
        <!-- Content Header (Page header) -->
        <section class="content-header box-header-background">
          <h1>
            Alumni Status
          </h1>
          <div class="box-inline">

            <!--  <a href="#print" data-toggle="modal" id="showModalButton"
              class="btn-add-class btn btn-primary btn-sm btn-flat">
              <i class="fa fa-print"></i>&nbsp;&nbsp; Print
            </a>-->

            <div class="search-container">
              <input type="text" class="search-input" id="search-input" placeholder="Search...">
              <button class="search-button" onclick="filterTable()">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                  stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                  class="feather feather-search">
                  <circle cx="11" cy="11" r="8"></circle>
                  <line x1="21" y1="21" x2="16.65" y2="16.65"></line>
                </svg>
              </button>
            </div>
          </div>

          <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
            <li>Alumni</li>
            <li class="active">Alumni Status</li>
          </ol>
        </section>

        <!-- Main content -->
        <section class="content">
          <?php
          if (isset($_SESSION['error'])) {
            echo "
            <div class='alert alert-danger alert-dismissible'>
              <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
              <h4><i class='icon fa fa-bell'></i> Reminder!</h4>
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
            <div class="table-container col-xs-12">
              <div class="box">
                <div class="box-header">
                  <div class="box-tools pull-right">
                    <form class="form-inline">
                      <form class="form-inline">
                        <div class="form-group">
                          <label style="color:white;">Select Status: </label>
                          <select class="form-control input-sm" style="height:25px; font-size:10px"
                            id="select_work_classification">
                            <option value="">All</option>
                            <?php
                            $categoryData = getFirebaseData($firebase, "category");
                            if (!empty($categoryData) && is_array($categoryData)) {
                              foreach ($categoryData as $categoryId => $categoryDetails) {
                                $categoryName = isset($categoryDetails['category_name']) ? htmlspecialchars($categoryDetails['category_name']) : 'Unknown';
                                echo "<option value=\"" . htmlspecialchars($categoryId) . "\">" . $categoryName . "</option>";
                              }
                            }
                            ?>
                          </select>
                        </div>
                      </form>
                      <script>
                        $(function () {
                          $('#select_work_classification').change(function () {
                            var url = new URL(window.location.href);
                            url.searchParams.set('work_classification', $(this).val());
                            window.location.href = url.toString();
                          });

                          // Add your existing JavaScript here
                        });
                      </script>



                  </div>
                </div>
                <div class="box-body">
                  <div class="table-responsive"> <!-- Add this div for responsive behavior -->
                    <table id="example1" class="table table-bordered">
                      <thead>
                        <th>Job Category</th>
                        <th>Actions</th>
                      </thead>
                      <tbody>
                        <?php include 'fetch_data/fetch_dataFieldOfWork.php'; ?>
                      </tbody>
                    </table>


                    <!-- Modal -->

                  </div>
                </div>

              </div>
            </div>

        </section>
      </div>

      <!-- Sidebar -->
      <div class="left-div">
        <?php include 'includes/submenufieldofwork.php' ?>
      </div>
    </div>


    <?php include 'includes/footer.php'; ?>



  </div>
  <?php include 'includes/scripts.php'; ?>

</body>

</html>
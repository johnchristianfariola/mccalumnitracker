

<?php
session_name('admin_session');
include 'includes/session.php'; 
include 'includes/timezone.php';
$today = date('Y-m-d');
$year = date('Y');
if (isset($_GET['year'])) {
  $year = $_GET['year'];
}

require_once 'includes/firebaseRDB.php';


require_once 'includes/config.php'; // Include your config file
$firebase = new firebaseRDB($databaseURL);

// Fetch course and alumni data from Firebase
$courseData = $firebase->retrieve("course");
$alumniData = $firebase->retrieve("alumni");
$batchYrData = $firebase->retrieve("batch_yr");
$forumData = $firebase->retrieve("forum");
$jobData = $firebase->retrieve("job");
$eventData = $firebase->retrieve("event");

// Decode JSON data into associative arrays
$courses = json_decode($courseData, true) ?: [];
$alumni = json_decode($alumniData, true) ?: [];
$batchYr = json_decode($batchYrData, true) ?: [];
$forum = json_decode($forumData, true) ?: [];
$jobData = json_decode($jobData, true) ?: [];
$event = json_decode($eventData, true) ?: [];


$alumniCount = 0;
if (is_array($alumni)) {
  $alumniCount = count($alumni);
}


$jobCount = 0;
if (is_array($jobData)) {
  foreach ($jobData as $job) {
    if (isset($job['status']) && $job['status'] === 'Active') {
      $jobCount++;
    }
  }
}

$eventCount = 0;
if (is_array($event)) {
  $eventCount = count($event);
}

$forumCount = 0;
if (is_array($forum)) {
  $forumCount = count($forum);
}

// Get the selected year from the query parameter
$year = isset($_GET['year']) ? $_GET['year'] : date('Y');

// Filter alumni data for the selected batch year
$filteredAlumni = [];
if (is_array($alumni)) {
  foreach ($alumni as $alumId => $alum) {
    if (isset($alum['batch']) && isset($batchYr[$alum['batch']]['batch_yrs']) && $batchYr[$alum['batch']]['batch_yrs'] == $year) {
      $filteredAlumni[$alumId] = $alum;
    }
  }
}

// Count the number of alumni for each course
$courseMap = [];
if (is_array($courses)) {
  foreach ($courses as $courseId => $course) {
    if (isset($course['courCode'])) {
      $courseMap[$courseId] = $course['courCode'];
    }
  }
}

$courseCounts = array_fill_keys(array_values($courseMap), 0);
if (is_array($filteredAlumni)) {
  foreach ($filteredAlumni as $alum) {
    if (isset($alum['course']) && isset($courseMap[$alum['course']])) {
      $courseCode = $courseMap[$alum['course']];
      $courseCounts[$courseCode]++;
    }
  }
}

// Convert the course counts array to a JSON string for JavaScript
$courseCountsJson = json_encode(array_values($courseCounts));
$courseCodesJson = json_encode(array_keys($courseCounts));

?>
<?php include 'includes/header.php'; ?>

<body class="hold-transition skin-blue sidebar-mini">
  <div class="wrapper">

    <?php include 'includes/navbar.php'; ?>
    <?php include 'includes/menubar.php'; ?>

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
      <!-- Content Header (Page header) -->
      <section class="content-header box-header-background box-padding">
        <h1>
          Dashboard
        </h1>


        <ol class="breadcrumb">
          <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
          <li class="active">Dashboard</li>
        </ol>
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
        <!-- Small boxes (Stat box) -->
        <div class="row">
          <div class="col-lg-3 col-xs-6">
            <!-- small box -->
            <div class="small-box" style="background: linear-gradient(to right, #ffbf96, #fe7096) !important;">
              <div class="inner">
                <h3><?php echo $alumniCount; ?></h3>
                <p>Total Alumni</p>
              </div>
              <div class="icon">
                <i class="fa fa-graduation-cap"></i>
              </div>
              <a href="book.php" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
            </div>
          </div>
          <!-- ./col -->
          <div class="col-lg-3 col-xs-6">
            <!-- small box -->
            <div class="small-box" style="background: linear-gradient(to right, #90caf9, #047edf 99%) !important;">
              <div class="inner">
                <h3><?php echo $forumCount; ?></h3>

                <p>Forum Topic</p>
              </div>
              <div class="icon">
                <i class="fa fa-weixin"></i>
              </div>
              <a href="student.php" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
            </div>
          </div>
          <!-- ./col -->
          <div class="col-lg-3 col-xs-6">
            <!-- small box -->
            <div class="small-box" style="background: linear-gradient(to right, #84d9d2, #07cdae) !important">
              <div class="inner">
                <h3><?php echo $jobCount; ?></h3>
                <p>Active Job</p>
              </div>
              <div class="icon">
                <i class="fa fa-tasks"></i>
              </div>
              <a href="return.php" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
            </div>
          </div>
          <!-- ./col -->
          <div class="col-lg-3 col-xs-6">
            <!-- small box -->
            <div class="small-box" style="background: linear-gradient(to right, #f6e384, #ffd500) !important;">
              <div class="inner">
                <h3><?php echo $eventCount; ?></h3>
                <p>Event</p>
              </div>
              <div class="icon">
                <i class="fa fa-clock-o"></i>
              </div>
              <a href="borrow.php" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
            </div>
          </div>
          <!-- ./col -->
        </div>
        <!-- /.row -->
        <div class="row">
          <div class="col-xs-12">
            <div class="box">
              <div class="box-header with-border">
                <h3 class="box-title" style="color:white;">Alumni Report </h3>
                <div class="box-tools pull-right">
                  <form class="form-inline">
                    <div class="form-group">
                      <label style="color:white;">Select Year: </label>
                      <select class="form-control input-sm" style="height:25px; font-size:10px" id="select_year">
                        <?php
                        for ($i = 2001; $i <= 2065; $i++) {
                          $selected = ($i == $year) ? 'selected' : '';
                          echo "
                            <option value='" . $i . "' " . $selected . ">" . $i . "</option>
                          ";
                        }
                        ?>
                      </select>
                    </div>
                  </form>
                  <script>
                    $(function () {
                      $('#select_year').change(function () {
                        window.location.href = 'home.php?year=' + $(this).val();
                      });
                    });
                  </script>
                </div>
              </div>
              <div class="box-body">
                <div class="chart">
                  <br>
                  <div id="legend" class="text-center"></div>
                  <canvas id="barChart" style="height:550px"></canvas>
                </div>
              </div>
            </div>
          </div>
        </div>

      </section>
      <!-- right col -->
    </div>
    <?php include 'includes/footer.php'; ?>

  </div>
  <!-- ./wrapper -->

  <!-- Chart Data -->

  <!-- End Chart Data -->
  <?php include 'includes/scripts.php'; ?>
  <script>
    'use strict';
    var courseLabels = <?php echo $courseCodesJson; ?>;
    var courseData = <?php echo $courseCountsJson; ?>;
    var data = {
      labels: courseLabels,
      datasets: [{
        label: 'Number of Alumni',
        data: courseData,
        backgroundColor: [
          'rgba(255, 99, 132, 0.2)',
          'rgba(54, 162, 235, 0.2)',
          'rgba(255, 206, 86, 0.2)',
          'rgba(75, 192, 192, 0.2)',
          'rgba(153, 102, 255, 0.2)',
          'rgba(255, 159, 64, 0.2)'
        ],
        borderColor: [
          'rgba(255,99,132,1)',
          'rgba(54, 162, 235, 1)',
          'rgba(255, 206, 86, 1)',
          'rgba(75, 192, 192, 1)',
          'rgba(153, 102, 255, 1)',
          'rgba(255, 159, 64, 1)'
        ],
        borderWidth: 1,
        fill: false
      }]
    };

    var ctx = document.getElementById('myChart').getContext('2d');
    var myChart = new Chart(ctx, {
      type: 'bar',
      data: data,
      options: {
        scales: {
          y: {
            beginAtZero: true
          }
        }
      }
    });

  </script>
</body>

</html>


<script src="../plugins/chart/Chart.min.js"></script>
<script src="../plugins/chart/chart.js"></script>
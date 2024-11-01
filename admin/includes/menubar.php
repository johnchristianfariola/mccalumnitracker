<?php
// Include FirebaseRDB class and config
require_once 'includes/firebaseRDB.php';
require_once 'includes/config.php';

// Firebase Realtime Database URL
$databaseURL = "https://mccalumniapp-default-rtdb.firebaseio.com";

// Instantiate FirebaseRDB object
$firebase = new firebaseRDB($databaseURL);

// Function to count unique keys in a node
function countUniqueKeys($firebase, $node)
{
  $data = $firebase->retrieve($node);
  $data = json_decode($data, true);

  return is_array($data) ? count(array_keys($data)) : 0;
}

// Count unique keys in each node
$newsCount = countUniqueKeys($firebase, "deleted_news");
$alumniCount = countUniqueKeys($firebase, "deleted_alumni");
$jobCount = countUniqueKeys($firebase, "deleted_job");
$galleryCount = countUniqueKeys($firebase, "deleted_gallery");
$surveyCount = countUniqueKeys($firebase, "deleted_survey_set"); // Updated line
$eventCount = countUniqueKeys($firebase, "deleted_event");
// Sum the counts
$totalCount = $newsCount + $alumniCount + $jobCount + $galleryCount + $surveyCount + $eventCount;

// Display the count in the HTML
?>

<aside class="main-sidebar">
  <!-- sidebar: style can be found in sidebar.less -->
  <section class="sidebar">
    <!-- Sidebar user panel -->
    <div class="user-panel">
      <div class="pull-left image">
        <img src="<?php echo (!empty($user['image_url'])) ? $user['image_url'] : 'uploads/profile.png'; ?>"
          class="img-circle" alt="User Image">
      </div>
      <div class="pull-left info">
        <p><?php echo $user['firstname'] . ' ' . $user['lastname']; ?></p>
        <a><i class="fa fa-circle text-success"></i> Online</a>
      </div>
    </div>
    <!-- sidebar menu: : style can be found in sidebar.less -->
    <ul class="sidebar-menu" data-widget="tree">
      <li class="header">REPORTS</li>
      <li class=""><a href="home.php"><i class="fa fa-dashboard"></i> <span>Dashboard</span></a></li>
      <li class="header">MANAGE</li>
      <li class="treeview">
        <a href="#">
          <i class="fa fa-graduation-cap "></i>
          <span>Alumni</span>
          <span class="pull-right-container">

            <i class="fa fa-angle-left pull-right"></i>

          </span>
        </a>
        <ul class="treeview-menu">
          <li><a href="alumni.php"><i class="fa fa-angle-right"></i> Manage Alumni</a></li>
          <li><a href="field_of_work.php"><i class="fa fa-angle-right"></i> Alumni Status</a></li>
          <li><a href="category.php"><i class="fa fa-angle-right"></i> Category</a></li>

        </ul>
      </li>
      <li class="treeview">
        <a href="#">
          <i class="fa fa-newspaper-o "></i>
          <span>Contents</span>

          <span class="pull-right-container">

            <i class="fa fa-angle-left pull-right "></i>

          </span>
        </a>
        <ul class="treeview-menu">
          <li><a href="news.php"><i class="fa fa fa-angle-right"></i> News</a></li>
          <li><a href="event.php"><i class="fa fa-angle-right"></i> Events</a></li>
          <li><a href="gallery.php"><i class="fa fa-angle-right"></i> Gallery</a></li>
          <li><a href="job.php"><i class="fa fa-angle-right"></i> Job Offer</a></li>

        </ul>
      </li>
      <li class="treeview">
        <a href="#">
          <i class="fa fa-check-square-o "></i>
          <span>Survey</span>
          <span class="pull-right-container">

            <i class="fa fa-angle-left pull-right"></i>
          </span>
        </a>
        <ul class="treeview-menu">
          <li><a href="survey.php"><i class="fa fa-angle-right"></i> Survey List</a></li>
        </ul>
      </li>
      <li class="treeview">
        <a href="#">
          <i class="fa fa-book"></i>
          <span>Report</span>
          <span class="pull-right-container">

            <i class="fa fa-angle-left pull-right"></i>
          </span>
        </a>
        <ul class="treeview-menu">
          <li><a href="survey_report.php"><i class="fa fa-angle-right"></i> Surve Report</a></li>
          <li><a href="alumni_report.php"><i class="fa fa-angle-right"></i> Alumni Report</a></li>
          <li><a href="event_report.php"><i class="fa fa-angle-right"></i> Event Report</a></li>

        </ul>
      </li>

      <!--   <li class="treeview">
        <a href="#">
        <i class="fa fa-envelope"></i>
          <span>MailBox</span>
          <span class="pull-right-container">
          
            <i class="fa fa-angle-left pull-right"></i>
          </span>
        </a>
        <ul class="treeview-menu">
        <li><a href="inbox.php"><i class="fa fa-angle-right"></i> Inbox</a></li>
          <li><a href="compose.php"><i class="fa fa-angle-right"></i> Compose</a></li>

        </ul>
      -->

      <li class="treeview">
        <a href="#">
          <i class="fa fa-trash"></i>
          <span>Trash</span>
          <span class="pull-right-container">

            <i class="fa fa-angle-left pull-right"></i> &nbsp; &nbsp; &nbsp;
            <span class="pull-right-container">
              <small class="label pull-right bg-red"><?php echo $totalCount; ?></small>
            </span>

          </span>
        </a>
        <ul class="treeview-menu">
          <li>
            <a href="deleted_alumni.php">
              <i class="fa fa-angle-right"></i> <small class="label bg-red"><?php echo $alumniCount; ?></small> Alumni
            </a>
          </li>
          <li>
            <a href="deleted_news.php">
              <i class="fa fa-angle-right"></i> <small class="label bg-red"><?php echo $newsCount; ?></small> News
            </a>
          </li>
          <li>
            <a href="deleted_event.php">
              <i class="fa fa-angle-right"></i> <small class="label bg-red"><?php echo $eventCount; ?></small> Event
            </a>
          </li>
          <li>
            <a href="deleted_gallery.php">
              <i class="fa fa-angle-right"></i> <small class="label bg-red"><?php echo $galleryCount; ?></small> Gallery
            </a>
          </li>
          <li>
            <a href="deleted_job.php">
              <i class="fa fa-angle-right"></i> <small class="label bg-red"><?php echo $jobCount; ?></small> Job
            </a>
          </li>
          <li>
            <a href="deleted_survey.php">
              <i class="fa fa-angle-right"></i> <small class="label bg-red"><?php echo $surveyCount; ?></small> Survey
            </a>
          </li>
        </ul>

      </li>
    </ul>
  </section>
  <!-- /.sidebar -->
</aside>

<!-- Control Sidebar -->
<aside class="control-sidebar control-sidebar-dark">
  <!-- Create the tabs -->
  <ul class="nav nav-tabs nav-justified control-sidebar-tabs">
    <li><a href="#control-sidebar-home-tab" data-toggle="tab"><i class="fa fa-home"></i></a></li>
    <li><a href="#control-sidebar-settings-tab" data-toggle="tab"><i class="fa fa-gears"></i></a></li>
  </ul>
  <!-- Tab panes -->
  <div class="tab-content">
    <!-- Home tab content -->
    <div class="tab-pane" id="control-sidebar-home-tab">
      <h3 class="control-sidebar-heading">Recent Activity</h3>
      <ul class="control-sidebar-menu">
        <li>
          <a href="javascript:void(0)">
            <i class="menu-icon fa fa-birthday-cake bg-red"></i>

            <div class="menu-info">
              <h4 class="control-sidebar-subheading">Langdon's Birthday</h4>

              <p>Will be 23 on April 24th</p>
            </div>
          </a>
        </li>
        <li>
          <a href="javascript:void(0)">
            <i class="menu-icon fa fa-user bg-yellow"></i>

            <div class="menu-info">
              <h4 class="control-sidebar-subheading">Frodo Updated His Profile</h4>

              <p>New phone +1(800)555-1234</p>
            </div>
          </a>
        </li>
        <li>
          <a href="javascript:void(0)">
            <i class="menu-icon fa fa-envelope-o bg-light-blue"></i>

            <div class="menu-info">
              <h4 class="control-sidebar-subheading">Nora Joined Mailing List</h4>

              <p>nora@example.com</p>
            </div>
          </a>
        </li>
        <li>
          <a href="javascript:void(0)">
            <i class="menu-icon fa fa-file-code-o bg-green"></i>

            <div class="menu-info">
              <h4 class="control-sidebar-subheading">Cron Job 254 Executed</h4>

              <p>Execution time 5 seconds</p>
            </div>
          </a>
        </li>
      </ul>
      <!-- /.control-sidebar-menu -->

      <h3 class="control-sidebar-heading">Tasks Progress</h3>
      <ul class="control-sidebar-menu">
        <li>
          <a href="javascript:void(0)">
            <h4 class="control-sidebar-subheading">
              Custom Template Design
              <span class="label label-danger pull-right">70%</span>
            </h4>

            <div class="progress progress-xxs">
              <div class="progress-bar progress-bar-danger" style="width: 70%"></div>
            </div>
          </a>
        </li>
        <li>
          <a href="javascript:void(0)">
            <h4 class="control-sidebar-subheading">
              Update Resume
              <span class="label label-success pull-right">95%</span>
            </h4>

            <div class="progress progress-xxs">
              <div class="progress-bar progress-bar-success" style="width: 95%"></div>
            </div>
          </a>
        </li>
        <li>
          <a href="javascript:void(0)">
            <h4 class="control-sidebar-subheading">
              Laravel Integration
              <span class="label label-warning pull-right">50%</span>
            </h4>

            <div class="progress progress-xxs">
              <div class="progress-bar progress-bar-warning" style="width: 50%"></div>
            </div>
          </a>
        </li>
        <li>
          <a href="javascript:void(0)">
            <h4 class="control-sidebar-subheading">
              Back End Framework
              <span class="label label-primary pull-right">68%</span>
            </h4>

            <div class="progress progress-xxs">
              <div class="progress-bar progress-bar-primary" style="width: 68%"></div>
            </div>
          </a>
        </li>
      </ul>
      <!-- /.control-sidebar-menu -->

    </div>
    <!-- /.tab-pane -->

    <!-- Settings tab content -->
    <div class="tab-pane" id="control-sidebar-settings-tab">
      <form method="post">
        <h3 class="control-sidebar-heading">General Settings</h3>

        <div class="form-group">
          <label class="control-sidebar-subheading">
            Report panel usage
            <input type="checkbox" class="pull-right" checked>
          </label>

          <p>
            Some information about this general settings option
          </p>
        </div>
        <!-- /.form-group -->

        <div class="form-group">
          <label class="control-sidebar-subheading">
            Allow mail redirect
            <input type="checkbox" class="pull-right" checked>
          </label>

          <p>
            Other sets of options are available
          </p>
        </div>
        <!-- /.form-group -->

        <div class="form-group">
          <label class="control-sidebar-subheading">
            Expose author name in posts
            <input type="checkbox" class="pull-right" checked>
          </label>

          <p>
            Allow the user to show his name in blog posts
          </p>
        </div>
        <!-- /.form-group -->

        <h3 class="control-sidebar-heading">Chat Settings</h3>

        <div class="form-group">
          <label class="control-sidebar-subheading">
            Show me as online
            <input type="checkbox" class="pull-right" checked>
          </label>
        </div>
        <!-- /.form-group -->

        <div class="form-group">
          <label class="control-sidebar-subheading">
            Turn off notifications
            <input type="checkbox" class="pull-right">
          </label>
        </div>
        <!-- /.form-group -->

        <div class="form-group">
          <label class="control-sidebar-subheading">
            Delete chat history
            <a href="javascript:void(0)" class="text-red pull-right"><i class="fa fa-trash-o"></i></a>
          </label>
        </div>
        <!-- /.form-group -->
      </form>
    </div>
    <!-- /.tab-pane -->
  </div>
</aside>
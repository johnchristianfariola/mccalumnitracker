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
          <li><a href="gallery.php"><i class="fa fa-angle-right"></i> Galary</a></li>
          <li><a href="job.php"><i class="fa fa-angle-right"></i> Job Offer</a></li>

        </ul>
      </li>
      <li class="treeview">
        <a href="#">
        <i class="fa fa-check-square-o "></i>
          <span>Survery</span>
          <span class="pull-right-container">
          
            <i class="fa fa-angle-left pull-right"></i>
          </span>
        </a>
        <ul class="treeview-menu">
          <li><a href="survey.php"><i class="fa fa-angle-right"></i> Survey List</a></li>
          <li><a href="survey_report.php"><i class="fa fa-angle-right"></i> Survey Report</a></li>
          <li><a href="alumni.php"><i class="fa fa-angle-right"></i> Alumni Report</a></li>
        </ul>
      </li>
    </ul>
  </section>
  <!-- /.sidebar -->
</aside>

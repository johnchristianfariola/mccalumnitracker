<style>
  .scrollable-menu {
    max-height: 250px;  /* Set maximum height */
    overflow-y: auto;   /* Enable vertical scrolling */
}

</style>

<header class="main-header">
  <!-- Logo -->
  <a href="index2.html" class="logo">
    <!-- mini logo for sidebar mini 50x50 pixels -->
    <span class="logo-mini"><b>A</b>LT</span>
    <!-- logo for regular state and mobile devices -->
    <span class="logo-lg"><b>Admin</b>LTE</span>
  </a>
  <!-- Header Navbar: style can be found in header.less -->
  <nav class="navbar navbar-static-top">
    <!-- Sidebar toggle button-->
    <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
      <span class="sr-only">Toggle navigation</span>
    </a>

    <div class="navbar-custom-menu">
      <ul class="nav navbar-nav">
        <!-- Messages: style can be found in dropdown.less-->
        <li class="dropdown messages-menu">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown">
            <i class="fa fa-envelope-o"></i>
            <span class="label label-success">4</span>
          </a>
          <ul class="dropdown-menu">
            <li class="header">You have 4 messages</li>
            <li>
              <!-- inner menu: contains the actual data -->
              <ul class="menu">
                <li><!-- start message -->
                  <a href="#">
                    <div class="pull-left">
                      <img src="../dist/img/user2-160x160.jpg" class="img-circle" alt="User Image">
                    </div>
                    <h4>
                      Support Team
                      <small><i class="fa fa-clock-o"></i> 5 mins</small>
                    </h4>
                    <p>Why not buy a new awesome theme?</p>
                  </a>
                </li>
                <!-- end message -->
                <li>
                  <a href="#">
                    <div class="pull-left">
                      <img src="../dist/img/user3-128x128.jpg" class="img-circle" alt="User Image">
                    </div>
                    <h4>
                      AdminLTE Design Team
                      <small><i class="fa fa-clock-o"></i> 2 hours</small>
                    </h4>
                    <p>Why not buy a new awesome theme?</p>
                  </a>
                </li>
                <li>
                  <a href="#">
                    <div class="pull-left">
                      <img src="../dist/img/user4-128x128.jpg" class="img-circle" alt="User Image">
                    </div>
                    <h4>
                      Developers
                      <small><i class="fa fa-clock-o"></i> Today</small>
                    </h4>
                    <p>Why not buy a new awesome theme?</p>
                  </a>
                </li>
                <li>
                  <a href="#">
                    <div class="pull-left">
                      <img src="../dist/img/user3-128x128.jpg" class="img-circle" alt="User Image">
                    </div>
                    <h4>
                      Sales Department
                      <small><i class="fa fa-clock-o"></i> Yesterday</small>
                    </h4>
                    <p>Why not buy a new awesome theme?</p>
                  </a>
                </li>
                <li>
                  <a href="#">
                    <div class="pull-left">
                      <img src="../dist/img/user4-128x128.jpg" class="img-circle" alt="User Image">
                    </div>
                    <h4>
                      Reviewers
                      <small><i class="fa fa-clock-o"></i> 2 days</small>
                    </h4>
                    <p>Why not buy a new awesome theme?</p>
                  </a>
                </li>
              </ul>
            </li>
            <li class="footer"><a href="#">See All Messages</a></li>
          </ul>
        </li>
        <!-- Notifications: style can be found in dropdown.less -->
        <li class="dropdown notifications-menu">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown">
            <i class="fa fa-bell-o"></i>
            <span class="label label-warning">10</span>
          </a>
          <ul class="dropdown-menu">
            <li class="header">You have 10 notifications</li>
            <li>
              <!-- inner menu: contains the actual data -->
              <div id="recent-comments-list" class="recent-comments-list scrollable-menu">
                <!-- Fetched notifications will be inserted here dynamically -->
              </div>
            </li>

        </li>
        <li class="footer"><a href="#">View all</a></li>
      </ul>
      </li>
      <!-- Tasks: style can be found in dropdown.less -->
      <li class="dropdown tasks-menu">
        <a href="#" class="dropdown-toggle" data-toggle="dropdown">
          <i class="fa fa-flag-o"></i>
          <span class="label label-danger">9</span>
        </a>
        <ul class="dropdown-menu">
          <li class="header">You have 9 tasks</li>
          <li>
            <!-- inner menu: contains the actual data -->
            <ul class="menu">
              <li><!-- Task item -->
                <a href="#">
                  <h3>
                    Design some buttons
                    <small class="pull-right">20%</small>
                  </h3>
                  <div class="progress xs">
                    <div class="progress-bar progress-bar-aqua" style="width: 20%" role="progressbar" aria-valuenow="20"
                      aria-valuemin="0" aria-valuemax="100">
                      <span class="sr-only">20% Complete</span>
                    </div>
                  </div>
                </a>
              </li>
              <!-- end task item -->
              <li><!-- Task item -->
                <a href="#">
                  <h3>
                    Create a nice theme
                    <small class="pull-right">40%</small>
                  </h3>
                  <div class="progress xs">
                    <div class="progress-bar progress-bar-green" style="width: 40%" role="progressbar"
                      aria-valuenow="20" aria-valuemin="0" aria-valuemax="100">
                      <span class="sr-only">40% Complete</span>
                    </div>
                  </div>
                </a>
              </li>
              <!-- end task item -->
              <li><!-- Task item -->
                <a href="#">
                  <h3>
                    Some task I need to do
                    <small class="pull-right">60%</small>
                  </h3>
                  <div class="progress xs">
                    <div class="progress-bar progress-bar-red" style="width: 60%" role="progressbar" aria-valuenow="20"
                      aria-valuemin="0" aria-valuemax="100">
                      <span class="sr-only">60% Complete</span>
                    </div>
                  </div>
                </a>
              </li>
              <!-- end task item -->
              <li><!-- Task item -->
                <a href="#">
                  <h3>
                    Make beautiful transitions
                    <small class="pull-right">80%</small>
                  </h3>
                  <div class="progress xs">
                    <div class="progress-bar progress-bar-yellow" style="width: 80%" role="progressbar"
                      aria-valuenow="20" aria-valuemin="0" aria-valuemax="100">
                      <span class="sr-only">80% Complete</span>
                    </div>
                  </div>
                </a>
              </li>
              <!-- end task item -->
            </ul>
          </li>
          <li class="footer">
            <a href="#">View all tasks</a>
          </li>
        </ul>
      </li>
      <!-- User Account: style can be found in dropdown.less -->
      <li class="dropdown user user-menu">
        <a href="#" class="dropdown-toggle" data-toggle="dropdown">
          <img src="<?php echo (!empty($user['image_url'])) ? $user['image_url'] : 'uploads/profile.png'; ?>"
            class="user-image" alt="User Image">
          <span class="hidden-xs"><?php echo $user['firstname'] . ' ' . $user['lastname']; ?></span>
        </a>
        <ul class="dropdown-menu">
          <!-- User image -->
          <li class="user-header">
            <img src="<?php echo (!empty($user['image_url'])) ? $user['image_url'] : 'uploads/profile.png'; ?>"
              class="img-circle" alt="User Image">


            <p>
              <?php echo $user['firstname'] . ' ' . $user['lastname']; ?>
              <!-- Assuming 'created_on' is part of the admin data -->
              <small>Member since <?php echo date('M. Y', strtotime($user['created_on'])); ?></small>
            </p>
          </li>
          <!-- Menu Body -->
          <li class="user-body">
            <div class="row">
              <div class="col-xs-4 text-center">
                <a href="#">Followers</a>
              </div>
              <div class="col-xs-4 text-center">
                <a href="#">Sales</a>
              </div>
              <div class="col-xs-4 text-center">
                <a href="#">Friends</a>
              </div>
            </div>
            <!-- /.row -->
          </li>
          <!-- Menu Footer-->
          <li class="user-footer">
            <div class="pull-left">
              <a href="#profile" data-toggle="modal" class="btn btn-default btn-flat" id="admin_profile">Update</a>
            </div>
            <div class="pull-right">
              <a href="#" class="btn btn-default btn-flat" id="signout_button">Sign out</a>
            </div>
          </li>
        </ul>
      </li>
      <!-- Control Sidebar Toggle Button -->
      <li>
        <a href="#" data-toggle="control-sidebar"><i class="fa fa-gears"></i></a>
      </li>
      </ul>
    </div>
  </nav>
</header>

<?php include 'includes/profile_modal.php'; ?>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
  let lastReadTimestamp = parseInt(localStorage.getItem('lastReadTimestamp')) || 0;

  function updateActivities() {
    $.ajax({
      url: 'get_recent_notification.php',
      type: 'GET',
      data: { last_read_timestamp: lastReadTimestamp },
      dataType: 'json',
      success: function (data) {
        let activitiesHtml = '';

        // Display all recent activities
        data.activities.forEach(function (activity) {
          let newClass = activity.timestamp > lastReadTimestamp ? 'new-comment' : '';

          let activityContent = activity.action === 'commented on'
            ? `<div class="comment-text"><p><i class="fa fa-wechat"></i> ${activity.comment}</p></div>`
            : `<div class="comment-text"><p><i class="fa fa-thumbs-o-up"></i> Liked this ${activity.item_type}</p></div>`;

          activitiesHtml += `
          <div class="recent-comment-item ${newClass}">
            <a href="#">
              <div class="comment-flex">
                <div class="comment-img">
                  <img src="../userpage/${activity.profile_url}" alt="${activity.alumni_name}" />
                </div>
                <div class="comment-content">
                  <div class="comment-header">
                    <h3>${activity.alumni_name} <span class="comment-time">${activity.time_elapsed}</span></h3>
                    <span>on ${activity.item_title}</span>
                  </div>
                  ${activityContent}
                </div>
              </div>
            </a>
          </div>
        `;
        });

        $('#recent-comments-list').html(activitiesHtml);
        updateNotificationCount(data.new_activity_count);
        updateNotificationHeader(data.new_activity_count);
      },
      error: function (xhr, status, error) {
        console.error("Error fetching activities:", error);
      }
    });
  }


  function updateNotificationCount(count) {
    const notificationCount = $('.notification-count');
    if (count > 0) {
      notificationCount.text(count).show();
    } else {
      notificationCount.hide();
    }
  }

  function updateNotificationHeader(count) {
    const header = $('.dropdown.notifications-menu .header');
    header.html(`You have ${count} notifications`);
  }

  $('.read-all-btn').on('click', function (e) {
    e.preventDefault();
    lastReadTimestamp = Math.floor(Date.now() / 1000); // Current timestamp in seconds
    localStorage.setItem('lastReadTimestamp', lastReadTimestamp);
    updateNotificationCount(0);
    $('.new-comment').removeClass('new-comment');
  });

  // Update activities immediately and then every 5 seconds
  updateActivities();
  setInterval(updateActivities, 5000);

</script>
<header class="main-header" id="myHeader">
  <style>
    .sticky {
  position: fixed;
  top: 0;
  width: 100%;
  z-index: 1000;
}
  </style>
  <!-- Logo -->
  <a href="index.php" class="logo">
    <!-- mini logo for sidebar mini 50x50 pixels -->
    <span class="logo-mini"><b>A</b>P</span>
    <!-- logo for regular state and mobile devices -->
    <span class="logo-lg"><b>ADMIN</b> PANEL</span>
  </a>
  <!-- Header Navbar: style can be found in header.less -->
  <nav class="navbar navbar-static-top">
    <!-- Sidebar toggle button-->
    <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
      <span class="sr-only">Toggle navigation</span>
    </a>

    <div class="navbar-custom-menu">
      <ul class="nav navbar-nav">
        <!-- User Account: style can be found in dropdown.less -->
        <li class="dropdown user user-menu">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown">
            <img src="<?php echo (!empty($user['image_url'])) ? $user['image_url'] : 'uploads/profile.png'; ?>" class="user-image" alt="User Image">
            <span class="hidden-xs"><?php echo $user['firstname'].' '.$user['lastname']; ?></span>
          </a>
          <ul class="dropdown-menu">
            <!-- User image -->
            <li class="user-header">
              <img src="<?php echo (!empty($user['image_url'])) ? $user['image_url'] : 'uploads/profile.png'; ?>" class="img-circle" alt="User Image">

              <p>
                <?php echo $user['firstname'].' '.$user['lastname']; ?>
                <!-- Assuming 'created_on' is part of the admin data -->
                <small>Member since <?php echo date('M. Y', strtotime($user['created_on'])); ?></small>
              </p>
            </li>
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
      </ul>
    </div>
  </nav>
</header>
<?php include 'includes/profile_modal.php'; ?>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
// Get the header
var header = document.getElementById("myHeader");

// Get the offset position of the navbar
var sticky = header.offsetTop;

// Add the sticky class to the header when you reach its scroll position. Remove "sticky" when you leave the scroll position
function makeSticky() {
  if (window.pageYOffset > sticky) {
    header.classList.add("sticky");
  } else {
    header.classList.remove("sticky");
  }
}

// When the user scrolls the page, execute makeSticky
window.onscroll = function() {makeSticky()};

// Your existing script
document.getElementById('signout_button').addEventListener('click', function(e) {
  e.preventDefault();
  Swal.fire({
    title: 'Are you sure you want to leave this page?',
    icon: 'warning',
    showCancelButton: true,
    confirmButtonText: 'Yes, sign out',
    cancelButtonText: 'No, stay here'
  }).then((result) => {
    if (result.isConfirmed) {
      window.location.href = 'logout.php';
    }
  });
});
</script>
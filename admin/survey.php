<?php include 'includes/session.php'; ?>
<?php include 'includes/header.php'; ?>

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
          <li>Content</li>
          <li class="active">News</li>
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
        <div class="row">
          <div class="col-xs-12">
            <div class="box">
              <div class="box-header with-border"></div>
              <div class="box-body">
                <div class="table-responsive"> <!-- Add this div for responsive behavior -->
                  <table id="example1" class="table table-bordered">
                    <thead>

                      <th>Title</th>
                      <th>Description</th>
                      <th  width="15%">Start Date</th>
                      <th  width="15%">End Date</th>
                      <th  width="15%">Tools</th>
                    </thead>
                    <tbody>
                    <?php include 'fetch_data/fetch_dataSurvey.php'; ?>
                    </tbody>
                  </table>
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


<style>
  table {
    width: 100% !important;
    border-collapse: collapse !important;
  }


  td {
    padding: 8px !important;

    vertical-align: middle !important;
    max-width: 200px !important;
    /* Adjust maximum width as needed */
    overflow: hidden !important;
    text-overflow: ellipsis !important;
    white-space: nowrap !important;
  }
</style>
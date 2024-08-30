<?php include '../includes/session.php'; ?>
<!doctype html>
<html class="no-js" lang="">
<?php
require_once '../includes/firebaseRDB.php';
require_once '../includes/config.php';

$firebase = new firebaseRDB($databaseURL);

$alumni_data = $firebase->retrieve("alumni");
$alumni_data = json_decode($alumni_data, true);

$query = isset($_GET['query']) ? $_GET['query'] : '';

// Filter alumni based on the search query
$filtered_alumni = array_filter($alumni_data, function ($alumni) use ($query) {
    $full_name = strtolower($alumni['firstname'] . ' ' . $alumni['lastname']);
    return strpos($full_name, strtolower($query)) !== false;
});

date_default_timezone_set('Asia/Manila'); // Adjust this to your local timezone
?>

<head>
    <?php include 'includes/header.php' ?>
    <!-- Bootstrap CSS -->
    <style>
        .search-result-item {
            display: flex;
            align-items: center;
            padding: 15px;
            border-bottom: 1px solid #eee;
        }

        .search-result-item img {
            width: 60px;
            height: 60px;
            border-radius: 50%;
            margin-right: 15px;
        }

        .search-result-item-info {
            flex-grow: 1;
        }

        .search-result-item-name {
            font-weight: bold;
            font-size: 18px;
        }

        .search-result-item-details {
            font-size: 14px;
            color: #65676B;
        }
    </style>
</head>

<body>
    <?php include 'includes/navbar.php' ?>

    <div class="main-content">
        <div class="sale-statistic-area">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        <div class="sale-statistic-inner notika-shadow mg-tb-30" style="border-radius: 1rem">
                            <h2>Search Results for "<?php echo htmlspecialchars($query); ?>"</h2>
                            <?php if (empty($filtered_alumni)): ?>
                                <p>No results found.</p>
                            <?php else: ?>
                                <?php foreach ($filtered_alumni as $id => $alumni): ?>
                                    <div class="search-result-item">
                                        <img src="<?php echo isset($alumni['profile_url']) ? $alumni['profile_url'] : 'uploads/profile.jpg'; ?>"
                                            alt="<?php echo $alumni['firstname'] . ' ' . $alumni['lastname']; ?>" onerror="if (this.src != 'uploads/profile.jpg') this.src = 'uploads/profile.jpg';">
                                        <div class="search-result-item-info">
                                            <div class="search-result-item-name">
                                                <?php echo $alumni['firstname'] . ' ' . $alumni['lastname']; ?>
                                            </div>
                                            <div class="search-result-item-details">Alumni</div>
                                        </div>
                                        <a href="view_alumni_details.php?id=<?php echo $id; ?>" class="btn btn-primary">View Profile</a>
                                    </div>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </div>
                    </div>


                </div>
            </div>
        </div>
    </div>

    <!-- Scripts -->
    <?php include 'includes/script.php' ?>
    <script src="js/vendor/jquery-1.12.4.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/dialog/sweetalert2.min.js"></script>
    <script src="js/dialog/dialog-active.js"></script>
    <script src="js/main.js"></script>
    <script src="../bower_components/ckeditor/ckeditor.js"></script>
    <script src="js/jquery/jquery-3.5.1.min.js"></script>
</body>

</html>
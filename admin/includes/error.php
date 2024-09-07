<!DOCTYPE html>
<html lang="en">

<head>
    <title>Error</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" href="../vendor/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="../bower_components/fontawesome-pro-5.15.3-web/css/all.min.css">
    <link rel="stylesheet" type="text/css" href="../dist/css/login_util.css">
    <link rel="stylesheet" type="text/css" href="../dist/css/login_main.css">
    <style>
        body, html {
            height: 100%;
        }

        .container-center {
            height: 100%;
            display: flex;
            align-items: center;
            justify-content: center;
            text-align: center;
        }

        .error-message {
            font-size: 1.5rem;
            color: #d9534f;
            font-weight: bold;
        }
    </style>
</head>

<body>
    <div class="container-center">
        <div>
            <i class="fas fa-exclamation-triangle fa-3x text-danger"></i>
            <p class="error-message">
                <?php echo htmlspecialchars($_GET['error']); ?>
            </p>
            <a href="index.php" class="btn btn-primary">Go Back</a>
        </div>
    </div>

    <script src="../vendor/jquery/jquery-3.2.1.min.js"></script>
    <script src="../vendor/bootstrap/js/bootstrap.min.js"></script>
</body>

</html>

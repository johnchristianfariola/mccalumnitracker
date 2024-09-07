<!DOCTYPE html>
<html lang="en">

<head>
    <title>Error</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Bootstrap 5 -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/5.3.0/css/bootstrap.min.css">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">
    <!-- Custom CSS -->
    <style>
        body, html {
            height: 100%;
            font-family: 'Nunito', sans-serif;
            background-color: #f8f9fa;
            margin: 0;
        }

        .container-center {
            height: 100%;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
            text-align: center;
            background: linear-gradient(135deg, #fdfbfb 0%, #ebedee 100%);
        }

        .error-box {
            background-color: #ffffff;
            padding: 30px;
            border-radius: 12px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .error-box:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 40px rgba(0, 0, 0, 0.15);
        }

        .error-icon {
            color: #e74c3c;
            margin-bottom: 20px;
        }

        .error-message {
            font-size: 1.5rem;
            color: #333333;
            font-weight: 600;
            margin-bottom: 20px;
        }

        .btn-primary {
            background-color: #3498db;
            border: none;
            padding: 10px 20px;
            border-radius: 50px;
            transition: background-color 0.3s ease, transform 0.3s ease;
        }

        .btn-primary:hover {
            background-color: #2980b9;
            transform: translateY(-2px);
        }
    </style>
</head>

<body>
    <div class="container-center">
        <div class="error-box">
            <i class="fas fa-exclamation-triangle fa-4x error-icon"></i>
            <p class="error-message">
                <?php echo htmlspecialchars($_GET['error']); ?>
            </p>
            <a href="index.php" class="btn btn-primary">Go Back</a>
        </div>
    </div>

    <!-- Bootstrap JS and dependencies -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/5.3.0/js/bootstrap.min.js"></script>
    <!-- FontAwesome -->
    <script src="https://kit.fontawesome.com/a076d05399.js"></script>
</body>

</html>

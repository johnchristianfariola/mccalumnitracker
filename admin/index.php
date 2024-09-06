<?php
session_start();
if (isset($_SESSION['admin'])) {
    header('location: home.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title>Login V1</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!--===============================================================================================-->
    <link rel="icon" type="image/png" href="images/icons/favicon.ico" />
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="../vendor/bootstrap/css/bootstrap.min.css">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="../bower_components/fontawesome-pro-5.15.3-web/css/all.min.css">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="../vendor/animate/animate.css">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="../vendor/css-hamburgers/hamburgers.min.css">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="../vendor/select2/select2.min.css">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="../dist/css/login_util.css">
    <link rel="stylesheet" type="text/css" href="../dist/css/login_main.css">
    <!--===============================================================================================-->
    <style>
        .form-container {
            min-height: 450px;
            display: flex;
            flex-direction: column;
            justify-content: flex-start;
        }

        .login100-form-btn {
            pointer-events: auto;
        }

        .text-center {
            text-align: center;
        }

        .p-t-12 {
            padding-top: 12px;
        }

        .txt2 {
            font-family: Poppins-Regular;
            font-size: 13px;
            line-height: 1.5;
            color: #666666;
        }

        @media (max-width: 992px) {
            .wrap-login100 {
                flex-direction: column;
                align-items: center;
                padding: 50px 15px 50px 15px;
            }

            .login100-pic {
                position: static;
                margin-bottom: 50px;
            }

            .login100-form {
                width: 100%;
            }
        }
    </style>
</head>

<body>
    <div class="limiter">
        <div class="container-login100">
            <div class="wrap-login100">
                <div class="login100-pic js-tilt" data-tilt>
                    <img src="../images/logo.png" alt="IMG">
                </div>
                <div id="form-container" class="form-container">
                    <!-- Forms will be dynamically inserted here -->
                </div>
            </div>
        </div>
    </div>

    <!--===============================================================================================-->
    <script src="../vendor/jquery/jquery-3.2.1.min.js"></script>
    <!--===============================================================================================-->
    <script src="../vendor/bootstrap/js/popper.js"></script>
    <script src="../vendor/bootstrap/js/bootstrap.min.js"></script>
    <!--===============================================================================================-->
    <script src="../vendor/select2/select2.min.js"></script>
    <!--===============================================================================================-->
    <script src="../vendor/tilt/tilt.jquery.min.js"></script>
    <script>
        $('.js-tilt').tilt({
            scale: 1.1
        })
    </script>
    <!--===============================================================================================-->
    <script src="../dist/js/login.js"></script>

    <script>

        document.addEventListener('DOMContentLoaded', function () {
            const formContainer = document.getElementById('form-container');

            const loginFormHTML = `
                <form class="login100-form validate-form" id="login-form" action="login.php" method="POST">
                    <span class="login100-form-title">
                        Admin Login
                    </span>

                    <div class="wrap-input100 validate-input" data-validate="Valid email is required: ex@abc.xyz">
                        <input class="input100" type="text" name="username" placeholder="Input Username" required autofocus autocomplete="off">
                        <span class="focus-input100"></span>
                        <span class="symbol-input100">
                            <i class="fa fa-envelope" aria-hidden="true"></i>
                        </span>
                    </div>

                    <div class="wrap-input100 validate-input" data-validate="Password is required">
                        <input class="input100" type="password" name="password" placeholder="Input Password">
                        <span class="focus-input100"></span>
                        <span class="symbol-input100">
                            <i class="fa fa-lock" aria-hidden="true"></i>
                        </span>
                    </div>

             

                    <div class="container-login100-form-btn">
                        <button class="login100-form-btn" name="login">
                            Login
                        </button>
                    </div>

                    <div class="text-center p-t-12">
                        <span class="txt1">
                            Forgot
                        </span>
                        <a class="txt2" href="#" id="forgot-password-link">
                            Username / Password?
                        </a>
                    </div>

                    <div class="text-center p-t-136">
                    </div>
                </form>
            `;

            const forgotPasswordFormHTML = `
                <form class="login100-form validate-form" id="forgot-password-form"  action="forgot-password.php" method="POST" autocomplete="">
                    <span class="login100-form-title">
                        Forgot Password
                    </span>

                    <div class="wrap-input100 validate-input" data-validate="Valid email is required: ex@abc.xyz">
                        <input class="input100" type="text" name="email" placeholder="Email" required value="<?php echo $email ?>>
                        <span class="focus-input100"></span>
                        <span class="symbol-input100">
                            <i class="fa fa-envelope" aria-hidden="true"></i>
                        </span>
                    </div>

                    <div class="container-login100-form-btn">
                        <button class="login100-form-btn"  type="submit" name="check-email">
                            Reset Password
                        </button>
                    </div>

                    <div class="text-center p-t-12">
                        <a class="txt2" href="#" id="back-to-login">
                            Back to Login
                        </a>
                    </div>
                </form>
            `;

            function showLoginForm() {
                formContainer.innerHTML = loginFormHTML;
                document.getElementById('forgot-password-link').addEventListener('click', function (e) {
                    e.preventDefault();
                    showForgotPasswordForm();
                });
            }

            function showForgotPasswordForm() {
                formContainer.innerHTML = forgotPasswordFormHTML;
                document.getElementById('back-to-login').addEventListener('click', function (e) {
                    e.preventDefault();
                    showLoginForm();
                });
            }

            // Initially show the login form
            showLoginForm();
        });

    </script>

</body>

</html>
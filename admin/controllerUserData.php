<?php

require_once 'includes/firebaseRDB.php';
require_once 'includes/config.php'; // Include the config file

// Initialize Firebase
$firebase = new firebaseRDB($databaseURL);

$email = "";
$errors = array();

function debug_log($message) {
    error_log(print_r($message, true));
}

if (isset($_POST['check-email'])) {
    debug_log("Form submitted");
    $email = $_POST['email'];
    debug_log("Email submitted: " . $email);

    // Validate email format
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors['email'] = "Invalid email format!";
    } else {
        // Fetch user data from Firebase
        $data = $firebase->retrieve("admin");
        debug_log("Data retrieved from Firebase:");
        debug_log($data);

        $admin = json_decode($data, true);

        if ($admin && isset($admin['email']) && $admin['email'] === $email) {
            $token = bin2hex(random_bytes(16));
            $token_hash = hash("sha256", $token);
            $expiry = date("Y-m-d H:i:s", time() + 60 * 30); // 30 minutes expiry

            // Update the user's reset token and expiration in Firebase
            $admin["reset_token_hash"] = $token_hash;
            $admin["reset_token_expires_at"] = $expiry;

            $updateResult = $firebase->update("admin", null, $admin);
            debug_log("Update result:");
            debug_log($updateResult);

            // Send email with reset link
            $subject = "Password Reset";
            $message = <<<END
            <html>
            <head>
                <style>
                    body {
                        font-family: Arial, sans-serif;
                        background-color: #f9f9f9;
                        margin: 0;
                        padding: 0;
                        color: #333;
                    }
                    .container {
                        width: 100%;
                        max-width: 600px;
                        margin: 0 auto;
                        background-color: #ffffff;
                        padding: 20px;
                        border: 1px solid #ddd;
                        border-radius: 8px;
                    }
                    .header {
                        text-align: center;
                        padding: 20px 0;
                        background-color: #f2f2f2;
                        border-bottom: 1px solid #ddd;
                    }
                    .header img {
                        max-width: 150px;
                    }
                    .content {
                        padding: 20px;
                        text-align: center;
                    }
                    .content h1 {
                        font-size: 24px;
                        color: #333;
                    }
                    .content p {
                        font-size: 16px;
                        line-height: 1.5;
                        color: #666;
                    }
                    .button {
                        display: inline-block;
                        padding: 15px 25px;
                        font-size: 16px;
                        color: #ffffff;
                        background-color: #007BFF;
                        text-decoration: none;
                        border-radius: 5px;
                        margin: 20px 0;
                    }
                    .footer {
                        padding: 20px;
                        text-align: center;
                        font-size: 14px;
                        color: #777;
                        border-top: 1px solid #ddd;
                    }
                    .footer a {
                        color: #007BFF;
                        text-decoration: none;
                    }
                    .social-icons {
                        margin-top: 10px;
                    }
                    .social-icons img {
                        width: 24px;
                        margin: 0 5px;
                    }
                </style>
            </head>
            <body>
                <div class="container">
                    <div class="header">
                        <img src="https://mccalumnitracker.com/images/logo/alumni_logo.png" alt="Company Logo">
                    </div>
                    <div class="content">
                        <img src="https://ucarecdn.com/09bcae53-4a97-41fa-a664-25c0c1042382/airywomanopeninglockwithakey.png" alt="Password Reset Image">
                        <h1>Reset your password</h1>
                        <p>We've got a request from you to reset the password for your account. Please click on the button below to get a new password.</p>
                        <a href="https://mccalumnitracker.com/admin/new-password.php?token=$token" class="button">Reset my password</a>
                        <p>If you didn't request a password reset, please ignore this email or contact support if you have questions.</p>
                    </div>
                    <div class="footer">
                        <p>Questions? Contact us at <a href="mailto:support@company.com">support@company.com</a> or call 1-877-123-4567.</p>
                        <p class="social-icons">
                            <a href="https://facebook.com"><img src="https://ucarecdn.com/7ead65a8-a270-4a31-8f89-abdbdc718677/fb.png" alt="Facebook"></a>
                            <a href="https://instagram.com"><img src="https://img.icons8.com/fluency/50/instagram-new.png" alt="Instagram"></a>
                            <a href="https://twitter.com"><img src="https://img.icons8.com/papercut/120/twitter.png" alt="Twitter"></a>
                        </p>
                        <p>© 2024 Company. All rights reserved.</p>
                    </div>
                </div>
            </body>
            </html>
            END;
            $sender = "From: johnchristianfariola@gmail.com";

            // Assuming $mail is already set up in mailer.php
            $mail = require __DIR__ . "/mailer.php";
            $mail->setFrom("noreply@example.com");
            $mail->addAddress($email);
            $mail->Subject = $subject;
            $mail->isHTML(true); // Set email format to HTML
            $mail->Body = $message;

            try {
                if ($mail->send()) {
                    $info = "We've sent a password reset code to your email - $email";
                    $_SESSION['info'] = $info;
                    $_SESSION['email'] = $email;
                    header('location: index.php'); // Redirect to index.php instead of reset-code.php
                    exit();
                } else {
                    $errors['otp-error'] = "Failed while sending code!";
                }
            } catch (Exception $e) {
                $errors['otp-error'] = "Message could not be sent. Mailer error: {$mail->ErrorInfo}";
            }
        } 
    }
}


if (isset($_POST['change-password'])) {
    $_SESSION['info'] = "";
    $token = $_POST["token"];
    $token_hash = hash("sha256", $token);

    // Fetch the admin data from Firebase
    $data = $firebase->retrieve("admin");
    $admin = json_decode($data, true);

    debug_log("Admin data retrieved for password change:");
    debug_log($admin);

    if (!$admin || !isset($admin['reset_token_hash']) || $admin['reset_token_hash'] !== $token_hash) {
        $errors['token'] = "Token not found or invalid";
    } else {
        if (isset($admin["reset_token_expires_at"]) && strtotime($admin["reset_token_expires_at"]) <= time()) {
            $errors['token'] = "Token has expired";
        } elseif (strlen($_POST["password"]) < 8) {
            $errors['password'] = "Password must be at least 8 characters";
        } elseif (!preg_match("/[a-z]/i", $_POST["password"])) {
            $errors['password'] = "Password must contain at least one letter";
        } elseif (!preg_match("/[0-9]/", $_POST["password"])) {
            $errors['password'] = "Password must contain at least one number";
        } elseif ($_POST["password"] !== $_POST["password_confirmation"]) {
            $errors['password'] = "Passwords must match";
        } else {
            $password_hash = password_hash($_POST["password"], PASSWORD_DEFAULT);

            // Update the user's password in Firebase and clear reset token
            $admin["password"] = $password_hash;
            $admin["reset_token_hash"] = null;
            $admin["reset_token_expires_at"] = null;

            $updateResult = $firebase->update("admin", null, $admin);
            debug_log("Password update result:");
            debug_log($updateResult);

            $_SESSION['info'] = "Your password has been changed. Now you can log in with your new password.";
            header('Location: index.php');
            exit();
        }
    }
}

// Display errors if any
if (!empty($errors)) {
    foreach ($errors as $error) {
        echo "<p style='color: red;'>$error</p>";
    }
}
?>
    
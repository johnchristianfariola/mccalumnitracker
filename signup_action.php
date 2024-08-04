<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Require PHPMailer files
require 'phpmailer/src/Exception.php';
require 'phpmailer/src/PHPMailer.php';
require 'phpmailer/src/SMTP.php';
require_once 'includes/firebaseRDB.php';
require_once 'includes/config.php'; // Include the config file

// Initialize Firebase URL
$firebase = new firebaseRDB($databaseURL);


if (isset($_POST['signup'])) {
    $lastname = $_POST['lastname'];
    $studentid = $_POST['schoolId'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $cpassword = $_POST['curpassword'];
    $errors = array();

    if ($password !== $cpassword) {
        $errors['password'] = "Confirm password not matched!";
    }

    // Retrieve alumni data
    $data = $firebase->retrieve("alumni");
    $data = json_decode($data, true);

    // Check if email already exists and is verified
    $email_exists = false;
    $email_verified = false;
    foreach ($data as $id => $alumni) {
        if (isset($alumni['email']) && $alumni['email'] == $email) {
            $email_exists = true;
            if (isset($alumni['status']) && $alumni['status'] === 'verified') {
                $email_verified = true;
            }
            break;
        }
    }

    if ($email_exists && $email_verified) {
        $error_message = urlencode("This email is already associated with a verified account.");
        header("Location: index.php?error=$error_message");
        exit();
    }

    $alumni_id = null;
    $already_verified = false;
    foreach ($data as $id => $alumni) {
        if (strcasecmp($alumni['lastname'], $lastname) == 0 && $alumni['studentid'] == $studentid) {
            $alumni_id = $id;
            // Check if the alumni is already verified
            if (isset($alumni['status']) && $alumni['status'] === 'verified') {
                $already_verified = true;
            }
            break;
        }
    }

    if (!$alumni_id) {
        $error_message = urlencode("No matching alumni found with the provided last name and Alumni ID!");
        header("Location: index.php?error=$error_message");
        exit();
    }

    if ($already_verified) {
        $error_message = urlencode("You are already verified. You cannot sign up again.");
        header("Location: index.php?error=$error_message");
        exit();
    }

    if (count($errors) === 0) {
        $encpass = password_hash($password, PASSWORD_BCRYPT);
        $code = rand(999999, 111111);
        $status = "notverified";

        // Update alumni data
        $update_data = [
            'email' => $email,
            'password' => $encpass,
            'code' => $code,
            'status' => $status
        ];

        try {
            // Update user data in Firebase
            $firebase->update("alumni", $alumni_id, $update_data);

            // Send email verification
            $mail = new PHPMailer(true);
            // SMTP configuration
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com';
            $mail->SMTPAuth = true;
            $mail->Username = EMAIL_USERNAME; // Your Gmail address
            $mail->Password = EMAIL_PASSWORD; // Your Gmail app password
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port = 587;

            // Email content
            $mail->setFrom(EMAIL_USERNAME, 'Aurelia!');
            $mail->addAddress($email, $lastname);
            $mail->isHTML(true);
            $mail->Subject = 'Email Verification Code';
            $mail->Body = "Your verification code is $code";

            $mail->send();

            // Prepare message for otp.php
            $info = "We've sent a verification code to your email - $email";
            $_SESSION['info'] = $info;
            $_SESSION['email'] = $email;
            $_SESSION['password'] = $password;

            // Redirect to verification page with message
            header('location: user-otp.php?show_alert=1');
            exit();
        } catch (Exception $e) {
            $errors['otp-error'] = "Failed while sending code! Mailer Error: {$mail->ErrorInfo}";
        }
    }
}

// Display errors if any
if (!empty($errors)) {
    foreach ($errors as $error) {
        echo $error . "<br>";
    }
}
?>
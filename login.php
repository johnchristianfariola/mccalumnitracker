<?php
// Start the session at the very beginning
session_start();
include 'includes/firebaseRDB.php';
require_once 'includes/config.php';

$firebase = new firebaseRDB($databaseURL);

if (isset($_POST['login'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $alumniData = $firebase->retrieve("alumni");
    $alumniData = json_decode($alumniData, true);

    if ($alumniData === null) {
        $_SESSION['error'] = 'Error retrieving data from Firebase';
        header('location: index.php');
        exit();
    }

    $foundUser = null;
    foreach ($alumniData as $id => $alumni) {
        if (isset($alumni['email']) && $alumni['email'] === $email) {
            $foundUser = $alumni;
            $foundUser['id'] = $id; // Store the ID
            break;
        }
    }

    if ($foundUser) {
        if (password_verify($password, $foundUser['password'])) {
            if ($foundUser['status'] === 'notverified') {
                $_SESSION['error'] = 'Please verify your account';
                header('location: index.php');
                exit();
            }

            // Generate a unique session ID
            $session_id = 'user_session_' . $foundUser['id'];
            session_id($session_id);
            session_regenerate_id(true);

            // Set session variables
            $_SESSION['alumni'] = $email;
            $_SESSION['alumni_id'] = $foundUser['id'];
            $_SESSION['forms_completed'] = $foundUser['forms_completed'];

            // Generate token and store in session
            $token = bin2hex(random_bytes(32));
            $_SESSION['token'] = $token;

            // Set secure session cookie parameters
            $params = session_get_cookie_params();
            setcookie(session_name(), session_id(), [
                'expires' => time() + $params['lifetime'],
                'path' => $params['path'],
                'domain' => $params['domain'],
                'secure' => true,
                'httponly' => true,
                'samesite' => 'Lax'
            ]);

            if (!$foundUser['forms_completed']) {
                header('location: userpage/alumni_profile.php?token=' . $token);
            } else {
                header('location: userpage/index.php');
            }
            exit();
        } else {
            $_SESSION['error'] = 'Incorrect password';
        }
    } else {
        $_SESSION['error'] = 'Cannot find account with the email';
    }
} else {
    $_SESSION['error'] = 'Input Alumni credentials first';
}

header('location: index.php');
exit();
?>
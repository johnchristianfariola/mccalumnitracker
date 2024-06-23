<?php
include 'includes/session.php';

$return = isset($_GET['return']) ? $_GET['return'] : 'home.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $required_fields = ['curr_password', 'username', 'firstname', 'lastname'];

    $valid = true;
    $missing_fields = [];

    foreach ($required_fields as $field) {
        if (!isset($_POST[$field]) || empty(trim($_POST[$field]))) {
            $valid = false;
            $missing_fields[] = $field;
        }
    }

    if ($valid) {
        // Sanitize input data
        $curr_password = htmlspecialchars($_POST['curr_password']);
        $username = htmlspecialchars($_POST['username']);
        $firstname = htmlspecialchars($_POST['firstname']);
        $lastname = htmlspecialchars($_POST['lastname']);
        $photo = isset($_FILES['photo']['name']) ? $_FILES['photo']['name'] : '';

        if (password_verify($curr_password, $user['password'])) {
            if (!empty($photo)) {
                $upload_dir = 'uploads/';
                $target_file = $upload_dir . basename($photo);
                if (move_uploaded_file($_FILES['photo']['tmp_name'], $target_file)) {
                    $filename = 'uploads/' . basename($photo);
                } else {
                    $_SESSION['error'] = 'Failed to upload photo.';
                    header('Location: ' . $return);
                    exit();
                }
            } else {
                $filename = $user['image_url'];
            }

            if (empty($_POST['password'])) {
                $hashed_password = $user['password'];
            } else {
                $hashed_password = password_hash($_POST['password'], PASSWORD_DEFAULT);
            }

            // Prepare updated data for Firebase
            $updatedData = [
                'user' => $username,
                'password' => $hashed_password,
                'firstname' => $firstname,
                'lastname' => $lastname,
                'image_url' => $filename
            ];

            // Include FirebaseRDB class and initialize
            require_once 'includes/firebaseRDB.php';
            $databaseURL = "https://mccnians-bc4f4-default-rtdb.firebaseio.com/";
            $firebase = new firebaseRDB($databaseURL);

            // Define the table variable
            $table = 'admin'; // Make sure this is the correct table name in your Firebase

            // Update Firebase
            $updateResult = $firebase->update($table, '', $updatedData);
            $updateResult = json_decode($updateResult, true);

            if ($updateResult !== null && $updateResult !== false) {
                // Ensure $_SESSION['user'] is an array before merging
                if (!isset($_SESSION['user']) || !is_array($_SESSION['user'])) {
                    $_SESSION['user'] = [];
                }
                $_SESSION['user'] = array_merge($_SESSION['user'], $updatedData);
                $_SESSION['success'] = 'Admin profile updated successfully';
            } else {
                $_SESSION['error'] = 'Error updating profile in Firebase';
            }
        } else {
            $_SESSION['error'] = 'Incorrect current password';
        }
    } else {
        $_SESSION['error'] = 'All fields are required.';
    }
} else {
    $_SESSION['error'] = 'Invalid request method.';
}

header('Location: ' . $return);
exit();
?>

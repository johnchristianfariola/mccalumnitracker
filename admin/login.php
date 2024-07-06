<?php
session_start();
include 'includes/conn.php';

if(isset($_POST['login'])){
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Prepare a SQL statement with placeholders for username and password
    $sql = "SELECT * FROM admin WHERE username = ?";

    // Prepare the SQL statement
    $stmt = $conn->prepare($sql);

    // Bind the parameters to the placeholders
    $stmt->bind_param("s", $username);

    // Execute the query
    $stmt->execute();

    // Get the result
    $result = $stmt->get_result();

    // Check if a row was returned
    if($result->num_rows < 1){
        $_SESSION['error'] = 'Cannot find account with the username';
    }
    else{
        $row = $result->fetch_assoc();
        if(password_verify($password, $row['password'])){
            $_SESSION['admin'] = $row['id'];
        }
        else{
            $_SESSION['error'] = 'Incorrect password';
        }
    }
}
else{
    $_SESSION['error'] = 'Input admin credentials first';
}

header('location: index.php');
?>

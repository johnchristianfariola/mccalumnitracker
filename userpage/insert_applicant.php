<?php
$mysqlHost = "127.0.0.1";
$mysqlUsername = "u510162695_fms_db_root";
$mysqlPassword = "1Fms_db_root";
$mysqlDatabase = "u510162695_fms_db";

// Function to get MySQL connection
function getMySQLConnection() {
    global $mysqlHost, $mysqlUsername, $mysqlPassword, $mysqlDatabase;
    $conn = new mysqli($mysqlHost, $mysqlUsername, $mysqlPassword, $mysqlDatabase);
    if ($conn->connect_error) {
        error_log("MySQL Connection failed: " . $conn->connect_error);
        return false;
    }
    return $conn;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $uniqueId = $_POST['unique_id'];
    $idNumber = $_POST['id_number'];
    $fullname = $_POST['fullname'];
    $email = $_POST['email'];
    $contact = $_POST['contact'];
    $sex = $_POST['sex'];
    $dob = $_POST['dob'];
    $yearGraduated = $_POST['year_graduated'];
    $admission = $_POST['admission'];
    $programGraduated = $_POST['program_graduated'];
    $isVerified = $_POST['is_verified'];
    $password = $_POST['password'];

    $conn = getMySQLConnection();
    if ($conn) {
        $stmt = $conn->prepare("INSERT INTO applicant (unique_id, id_number, fullname, email, contact, sex, dob, year_graduated, admission, program_graduated, is_verified, password) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("ssssssssssis", $uniqueId, $idNumber, $fullname, $email, $contact, $sex, $dob, $yearGraduated, $admission, $programGraduated, $isVerified, $password);

        if ($stmt->execute()) {
            echo json_encode(["success" => true, "message" => "Data inserted successfully"]);
        } else {
            echo json_encode(["success" => false, "message" => "Failed to insert data"]);
        }

        $stmt->close();
        $conn->close();
    } else {
        echo json_encode(["success" => false, "message" => "Database connection failed"]);
    }
}
?>
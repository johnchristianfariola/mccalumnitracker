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
    $password = $_POST['password']; // Ensure this is hashed
    $admission = $_POST['admission'];
    $isVerified = $_POST['is_verified'];
    $alumniId = $_POST['alumni_id'];
    $contact = $_POST['contact'];
    $dob = $_POST['dob'];
    $yearGraduated = $_POST['year_graduated'];

    $conn = getMySQLConnection();
    if ($conn) {
        $stmt = $conn->prepare("INSERT INTO applicant (unique_id, id_number, fullname, email, password, admission, is_verified, alumni_id, contact, dob, year_graduated) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("ssssssissss", $uniqueId, $idNumber, $fullname, $email, $password, $admission, $isVerified, $alumniId, $contact, $dob, $yearGraduated);
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
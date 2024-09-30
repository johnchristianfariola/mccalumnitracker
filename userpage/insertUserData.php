<?php
$servername = "127.0.0.1";
$username = "u510162695_fms_db_root";
$password = "1Fms_db_root";
$dbname = "u510162695_fms_db";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get the posted data
$data = json_decode(file_get_contents("php://input"), true);

$unique_id = $data['unique_id'];
$id_number = $data['id_number'];
$fullname = $data['fullname'];
$email = $data['email'];
$contact = $data['contact'];
$sex = $data['sex'];
$dob = $data['dob'];
$year_graduated = $data['year_graduated'];
$admission = $data['admission'];
$program_graduated = $data['program_graduated'];
$is_verified = $data['is_verified'];
$password = $data['password'];

// Prepare and bind
$stmt = $conn->prepare("INSERT INTO applicant (unique_id, id_number, fullname, email, contact, sex, dob, year_graduated, admission, program_graduated, is_verified, password) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
$stmt->bind_param("ssssssssssis", $unique_id, $id_number, $fullname, $email, $contact, $sex, $dob, $year_graduated, $admission, $program_graduated, $is_verified, $password);

if ($stmt->execute()) {
    echo json_encode(["success" => true]);
} else {
    echo json_encode(["success" => false, "error" => $stmt->error]);
}

$stmt->close();
$conn->close();
?>
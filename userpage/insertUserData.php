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

// Check if data is received
if (!$data) {
    die(json_encode(["success" => false, "error" => "No data received"]));
}

// Extract data with checks
$unique_id = isset($data['unique_id']) ? $data['unique_id'] : null;
$id_number = isset($data['id_number']) ? $data['id_number'] : null;
$fullname = isset($data['fullname']) ? $data['fullname'] : null;
$email = isset($data['email']) ? $data['email'] : null;
$contact = isset($data['contact']) ? $data['contact'] : null;
$sex = isset($data['sex']) ? $data['sex'] : null;
$dob = isset($data['dob']) ? $data['dob'] : null;
$year_graduated = isset($data['year_graduated']) ? $data['year_graduated'] : null;
$admission = isset($data['admission']) ? $data['admission'] : null;
$program_graduated = isset($data['program_graduated']) ? $data['program_graduated'] : null;
$is_verified = isset($data['is_verified']) ? $data['is_verified'] : 0;
$password = isset($data['password']) ? $data['password'] : null;

// Check for required fields
if (!$unique_id || !$id_number || !$fullname || !$email || !$contact || !$sex || !$dob || !$year_graduated || !$program_graduated || !$password) {
    die(json_encode(["success" => false, "error" => "Missing required fields"]));
}

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
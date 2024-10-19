<?php
header('Content-Type: application/json');

$servername = "127.0.0.1"; // e.g., 'localhost'
$username = "root";
$password = "";
$dbname = "judging";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die(json_encode(["error" => "Connection failed: " . $conn->connect_error]));
}

// Get data from POST request
$channelName = $_POST['channel_name'] ?? '';
$hostUid = $_POST['host_uid'] ?? '';

if ($channelName && $hostUid) {
    $sql = "UPDATE live_streams SET host_uid = ? WHERE channel_name = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss", $hostUid, $channelName);
    if ($stmt->execute()) {
        echo json_encode(["success" => true]);
    } else {
        echo json_encode(["error" => "Failed to update host UID"]);
    }
    $stmt->close();
} else {
    echo json_encode(["error" => "Invalid input"]);
}

$conn->close();
?>
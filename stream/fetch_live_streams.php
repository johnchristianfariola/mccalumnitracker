<?php
header('Content-Type: application/json');

// Database connection parameters
$servername = "127.0.0.1"; // e.g., 'localhost'
$username = "u510162695_judging";
$password = "1Judging_root";
$dbname = "u510162695_judging";


    

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die(json_encode(["error" => "Connection failed: " . $conn->connect_error]));
}

// Fetch the channel name for stream_id 1
$sql = "SELECT channel_name FROM live_streams WHERE stream_id = 1";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    echo json_encode(["channel_name" => $row['channel_name']]);
} else {
    echo json_encode(["error" => "Stream not found"]);
}

$conn->close();
?>
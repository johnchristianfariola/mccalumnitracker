<?php
$servername = "127.0.0.1";
$username = "u510162695_judging_root";
$password = "1Judging_root";
$dbname = "u510162695_judging";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// SQL to clear all data from the live_streams table
$clearTableSql = "TRUNCATE TABLE `live_streams`";

if ($conn->query($clearTableSql) === TRUE) {
    echo "All data cleared from 'live_streams' table successfully<br>";
} else {
    echo "Error clearing table: " . $conn->error . "<br>";
}

// SQL to insert new data
$insertDataSql = "INSERT INTO `live_streams` (`organizer_id`, `channel_name`, `stream_title`, `host_uid`, `stream_status`, `start_time`, `end_time`, `viewer_count`, `app_id`, `token`, `role`, `image_url`, `created_at`, `updated_at`, `is_video_enabled`, `is_audio_enabled`) VALUES
(31, 'Channel_1', 'Tech Talk', NULL, 'scheduled', '2024-10-18 16:06:00', '2024-10-18 18:06:00', 0, '639e26f0457a4e85b9e24844db6078cd', 'f390d604df0f4e0191dc0652773f77a3', 'host', 'https://picsum.photos/1920/1080?random=1', '2024-10-19 02:38:56', '2024-10-19 08:19:44', 1, 1)";

if ($conn->query($insertDataSql) === TRUE) {
    echo "New record inserted successfully";
} else {
    echo "Error inserting record: " . $conn->error;
}

$conn->close();
?>
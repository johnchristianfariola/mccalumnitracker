<?php
$servername = "127.0.0.1"; // e.g., 'localhost'
$username = "u510162695_judging_root";
$password = "1Judging_root";
$dbname = "u510162695_judging";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// SQL to create table
$sql = "CREATE TABLE `live_streams` (
  `stream_id` int(11) NOT NULL AUTO_INCREMENT,
  `organizer_id` int(11) NOT NULL,
  `channel_name` varchar(255) NOT NULL,
  `stream_title` varchar(255) NOT NULL,
  `host_uid` varchar(50) NOT NULL,
  `stream_status` enum('offline','live','scheduled') DEFAULT 'offline',
  `start_time` datetime DEFAULT NULL,
  `end_time` datetime DEFAULT NULL,
  `viewer_count` int(11) DEFAULT 0,
  `app_id` varchar(255) DEFAULT NULL,
  `token` varchar(255) DEFAULT NULL,
  `role` enum('host','audience') DEFAULT 'audience',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `is_video_enabled` varchar(45) DEFAULT '1',
  `is_audio_enabled` tinyint(1) DEFAULT 1,
  PRIMARY KEY (`stream_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci";

if ($conn->query($sql) === TRUE) {
    echo "Table 'live_streams' created successfully";
} else {
    echo "Error creating table: " . $conn->error;
}

$conn->close();
?>
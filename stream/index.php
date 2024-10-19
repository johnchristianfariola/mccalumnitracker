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

// SQL to drop existing table
$dropTableSql = "DROP TABLE IF EXISTS `live_streams`";

if ($conn->query($dropTableSql) === TRUE) {
    echo "Existing 'live_streams' table dropped successfully<br>";
} else {
    echo "Error dropping table: " . $conn->error . "<br>";
}

// SQL to create new table
$createTableSql = "CREATE TABLE `live_streams` (
  `stream_id` int(11) NOT NULL AUTO_INCREMENT,
  `organizer_id` int(11) NOT NULL,
  `channel_name` varchar(255) NOT NULL,
  `stream_title` varchar(255) NOT NULL,
  `host_uid` varchar(50) DEFAULT NULL,
  `stream_status` enum('offline','live','scheduled') DEFAULT 'offline',
  `start_time` datetime DEFAULT NULL,
  `end_time` datetime DEFAULT NULL,
  `viewer_count` int(11) DEFAULT 0,
  `app_id` varchar(255) DEFAULT NULL,
  `token` varchar(255) DEFAULT NULL,
  `role` enum('host','audience') DEFAULT 'audience',
  `image_url` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `is_video_enabled` tinyint(1) DEFAULT 1,
  `is_audio_enabled` tinyint(1) DEFAULT 1,
  PRIMARY KEY (`stream_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci";

if ($conn->query($createTableSql) === TRUE) {
    echo "New 'live_streams' table created successfully<br>";
} else {
    echo "Error creating table: " . $conn->error . "<br>";
}

// SQL to insert data
$insertDataSql = "INSERT INTO `live_streams` (`organizer_id`, `channel_name`, `stream_title`, `host_uid`, `stream_status`, `start_time`, `end_time`, `viewer_count`, `app_id`, `token`, `role`, `image_url`, `created_at`, `updated_at`, `is_video_enabled`, `is_audio_enabled`) VALUES
(31, 'Channel_1', 'Tech Talk', NULL, 'scheduled', '2024-10-18 16:06:00', '2024-10-18 18:06:00', 0, '639e26f0457a4e85b9e24844db6078cd', 'f390d604df0f4e0191dc0652773f77a3', 'host', 'https://picsum.photos/1920/1080?random=1', '2024-10-19 02:38:56', '2024-10-19 08:19:44', 1, 1)";

if ($conn->query($insertDataSql) === TRUE) {
    echo "New record inserted successfully";
} else {
    echo "Error inserting record: " . $conn->error;
}

$conn->close();
?>
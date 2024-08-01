<?php
include 'includes/timezone.php';
require_once 'includes/config.php';
require_once 'includes/firebaseRDB.php';

date_default_timezone_set('Asia/Manila');

$firebase = new firebaseRDB($databaseURL);

// Fetch data from Firebase
$alumniData = $firebase->retrieve("alumni");
$newsData = $firebase->retrieve("news");
$eventData = $firebase->retrieve("event");
$jobData = $firebase->retrieve("job");
$newsCommentsData = $firebase->retrieve("news_comments");
$eventCommentsData = $firebase->retrieve("event_comments");
$jobCommentsData = $firebase->retrieve("job_comments");

// Decode JSON data into associative arrays
$alumni = json_decode($alumniData, true) ?: [];
$news = json_decode($newsData, true) ?: [];
$events = json_decode($eventData, true) ?: [];
$jobs = json_decode($jobData, true) ?: [];
$newsComments = json_decode($newsCommentsData, true) ?: [];
$eventComments = json_decode($eventCommentsData, true) ?: [];
$jobComments = json_decode($jobCommentsData, true) ?: [];

function getAlumniName($alumni_id, $alumni)
{
    if (isset($alumni[$alumni_id])) {
        return $alumni[$alumni_id]['firstname'] . ' ' . $alumni[$alumni_id]['lastname'];
    }
    return "Unknown";
}

function getItemTitle($item_id, $items)
{
    if (isset($items[$item_id])) {
        return isset($items[$item_id]['news_title']) ? $items[$item_id]['news_title'] :
            (isset($items[$item_id]['event_title']) ? $items[$item_id]['event_title'] :
                (isset($items[$item_id]['job_title']) ? $items[$item_id]['job_title'] : "Unknown"));
    }
    return "Unknown";
}

function timeElapsed($timestamp) {
    $now = time();
    $diff = $now - $timestamp;

    if ($diff < 60) {
        return "just now";
    } elseif ($diff < 3600) {
        $minutes = floor($diff / 60);
        return $minutes == 1 ? "1 minute ago" : "$minutes minutes ago";
    } elseif ($diff < 86400) {
        $hours = floor($diff / 3600);
        return $hours == 1 ? "1 hour ago" : "$hours hours ago";
    } elseif ($diff < 604800) {
        $days = floor($diff / 86400);
        return $days == 1 ? "1 day ago" : "$days days ago";
    } elseif ($diff < 2592000) {
        $weeks = floor($diff / 604800);
        return $weeks == 1 ? "1 week ago" : "$weeks weeks ago";
    } else {
        return date("F j, Y", $timestamp);
    }
}

// Combine all comments
$all_comments = [];
foreach ($newsComments as $id => $comment) {
    $all_comments[] = [
        'type' => 'news',
        'alumni_id' => $comment['alumni_id'],
        'comment' => $comment['comment'],
        'item_id' => $comment['news_id'],
        'date' => strtotime($comment['date_commented'])
    ];
}
foreach ($eventComments as $id => $comment) {
    $all_comments[] = [
        'type' => 'event',
        'alumni_id' => $comment['alumni_id'],
        'comment' => $comment['comment'],
        'item_id' => $comment['event_id'],
        'date' => strtotime($comment['date_commented'])
    ];
}
foreach ($jobComments as $id => $comment) {
    $all_comments[] = [
        'type' => 'job',
        'alumni_id' => $comment['alumni_id'],
        'comment' => $comment['comment'],
        'item_id' => $comment['job_id'],
        'date' => strtotime($comment['date_commented'])
    ];
}

// Sort comments by date, newest first
usort($all_comments, function ($a, $b) {
    return $b['date'] - $a['date'];
});

// Get the last read timestamp from a cookie or session
$last_read_timestamp = isset($_GET['last_read_timestamp']) ? intval($_GET['last_read_timestamp']) : 0;

$new_comment_count = 0;
$formatted_comments = [];

$recent_comments = array_slice($all_comments, 0, 5);

foreach ($recent_comments as $comment) {
    $alumni_name = getAlumniName($comment['alumni_id'], $alumni);
    $item_title = getItemTitle($comment['item_id'], $comment['type'] == 'news' ? $news : ($comment['type'] == 'event' ? $events : $jobs));
    
    $formatted_comments[] = [
        'alumni_name' => $alumni_name,
        'item_title' => $item_title,
        'comment' => htmlspecialchars($comment['comment']),
        'profile_url' => $alumni[$comment['alumni_id']]['profile_url'] ?? 'img/default-avatar.jpg',
        'time_elapsed' => timeElapsed($comment['date']),
        'timestamp' => $comment['date']
    ];
}

// Set the content type to JSON
header('Content-Type: application/json');

// Output the JSON-encoded comments
echo json_encode([
    'comments' => $formatted_comments
]);
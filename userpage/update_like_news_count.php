<?php
require_once "../includes/firebaseRDB.php";
require_once "../includes/config.php";

$firebase = new firebaseRDB($databaseURL);

if (isset($_POST['news_id']) && isset($_POST['alumni_id'])) {
    $news_id = $_POST['news_id'];
    $alumni_id = $_POST['alumni_id'];

    $news_data = $firebase->retrieve("news/{$news_id}");
    $news_data = json_decode($news_data, true);

    if (!isset($news_data['likes'])) {
        $news_data['likes'] = [];
    }

    $is_liked = in_array($alumni_id, $news_data['likes']);

    if ($is_liked) {
        $news_data['likes'] = array_diff($news_data['likes'], [$alumni_id]);
    } else {
        $news_data['likes'][] = $alumni_id;
    }

    $firebase->update($table, "news/{$news_id}", $news_data);

    echo json_encode([
        'success' => true,
        'is_liked' => !$is_liked,
        'like_count' => count($news_data['likes'])
    ]);
} else {
    echo json_encode(['success' => false]);
}
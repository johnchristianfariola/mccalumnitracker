<?php
session_start();
require_once '../includes/firebaseRDB.php';
require_once '../includes/config.php';

$firebase = new firebaseRDB($databaseURL);

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $forum_id = $_GET['forum_id'];
    $alumni_id = $_SESSION['user']['id'];

    // Get current forum data
    $forum_data = $firebase->retrieve("forum/$forum_id");
    $forum_data = json_decode($forum_data, true);

    $reaction_counts = $forum_data['reaction_counts'] ?? [];
    $user_reaction = null;
    $user_reaction_time = null;

    if (isset($forum_data['reactions'])) {
        foreach ($forum_data['reactions'] as $reaction => $users) {
            if (isset($users[$alumni_id])) {
                $user_reaction = $reaction;
                $user_reaction_time = $users[$alumni_id]['timestamp'];
                break;
            }
        }
    }

    echo json_encode([
        'status' => 'success',
        'reaction_counts' => $reaction_counts,
        'user_reaction' => $user_reaction,
        'user_reaction_time' => $user_reaction_time
    ]);
} elseif ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $forum_id = $_POST['forum_id'];
    $reaction = $_POST['reaction'];
    $alumni_id = $_SESSION['user']['id'];

    // Get current forum data
    $forum_data = $firebase->retrieve("forum/$forum_id");
    $forum_data = json_decode($forum_data, true);

    // Initialize reaction_counts if not set
    if (!isset($forum_data['reaction_counts'])) {
        $forum_data['reaction_counts'] = [];
    }

    // Initialize reactions if not set
    if (!isset($forum_data['reactions'])) {
        $forum_data['reactions'] = [];
    }

    // Remove previous reaction if exists
    foreach ($forum_data['reactions'] as $r => $users) {
        if (isset($users[$alumni_id])) {
            unset($forum_data['reactions'][$r][$alumni_id]);
            $forum_data['reaction_counts'][$r]--;
            if ($forum_data['reaction_counts'][$r] == 0) {
                unset($forum_data['reaction_counts'][$r]);
            }
            break;
        }
    }

    // Add new reaction with timestamp
    if (!isset($forum_data['reactions'][$reaction])) {
        $forum_data['reactions'][$reaction] = [];
    }
    $forum_data['reactions'][$reaction][$alumni_id] = [
        'timestamp' => time()
    ];

    // Update reaction count
    if (!isset($forum_data['reaction_counts'][$reaction])) {
        $forum_data['reaction_counts'][$reaction] = 0;
    }
    $forum_data['reaction_counts'][$reaction]++;

    // Update forum data in Firebase
    $firebase->update("forum", $forum_id, $forum_data);

    echo json_encode([
        'status' => 'success',
        'message' => 'Reaction updated successfully',
        'reaction_counts' => $forum_data['reaction_counts']
    ]);
} else {
    echo json_encode(['status' => 'error', 'message' => 'Invalid request method']);
}
?>
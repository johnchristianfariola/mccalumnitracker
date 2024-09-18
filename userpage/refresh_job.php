<?php

require_once '../includes/firebaseRDB.php';
require_once '../includes/config.php';

date_default_timezone_set('Asia/Manila');

$firebase = new firebaseRDB($databaseURL);

function timeAgo($timestamp) {
    $currentTime = time();
    $commentTime = strtotime($timestamp);
    $difference = $currentTime - $commentTime;

    $intervals = [
        31536000 => 'year',
        2592000 => 'month',
        604800 => 'week',
        86400 => 'day',
        3600 => 'hour',
        60 => 'minute',
        1 => 'second'
    ];

    foreach ($intervals as $seconds => $label) {
        $count = floor($difference / $seconds);
        if ($count > 0) {
            return $count . " " . $label . ($count > 1 ? "s" : "") . " ago";
        }
    }
    return "Just now";
}

function renderComment($comment, $commentId, $alumniId, $firebase) {
    $commenterData = $firebase->retrieve("alumni/{$comment["alumni_id"]}");
    $commenterData = json_decode($commenterData, true);
    $commenterProfileUrl = $commenterData["profile_url"] ?? '';
    $commenterFirstName = $commenterData["firstname"] ?? '';
    $commenterLastName = $commenterData["lastname"] ?? '';
    $isLiked = isset($comment["liked_by"][$alumniId]);
    
    ob_start();
    ?>
    <li data-comment-id="<?php echo $commentId; ?>" style="list-style:none;">
        <div class="comment-avatar"><img src="<?php echo htmlspecialchars($commenterProfileUrl); ?>" alt=""></div>
        <div class="comment-box">
            <div class="comment-header">
                <h6 class="comment-author">
                    <a href="view_alumni_details.php?id=<?php echo htmlspecialchars($comment['alumni_id']); ?>"><?php echo htmlspecialchars($commenterFirstName . " " . $commenterLastName); ?></a>
                </h6>
                <span><?php echo $comment["date_ago"]; ?></span>
                <i class="fa fa-reply reply-button"></i>
                <i class="fa fa-heart heart-icon <?php echo $isLiked ? 'liked' : ''; ?>"
                    data-comment-id="<?php echo $commentId; ?>"></i>
                <span class="heart-count"><?php echo isset($comment["heart_count"]) ? $comment["heart_count"] : 0; ?></span>
            </div>
            <div class="comment-body">
                <?php echo htmlspecialchars($comment["comment"]); ?>
            </div>
        </div>
    </li>
    <div class="reply-container" style="display: none;">
        <form class="reply-form">
            <textarea class="reply-textarea" placeholder="Write your reply here..."></textarea>
            <button type="submit" class="btn btn-primary submit-reply">Reply</button>
            <input type="hidden" name="parent_comment_id" value="<?php echo $commentId; ?>">
        </form>
    </div>
    <?php if (isset($comment["replies"]) && is_array($comment["replies"])): ?>
        <ul class="comment-list reply-list">
            <?php foreach ($comment["replies"] as $replyId => $reply): 
                echo renderReply($reply, $replyId, $firebase);
            endforeach; ?>
        </ul>
    <?php endif;
    return ob_get_clean();
}

function renderReply($reply, $replyId, $firebase) {
    $replyAuthorData = $firebase->retrieve("alumni/{$reply["alumni_id"]}");
    $replyAuthorData = json_decode($replyAuthorData, true);
    
    ob_start();
    ?>
    <li>
        <div class="comment-avatar"><img src="<?php echo htmlspecialchars($replyAuthorData["profile_url"] ?? ''); ?>" alt=""></div>
        <div class="comment-box">
            <div class="comment-header">
                <h6 class="comment-author">
                    <a href="view_alumni_details.php?id=<?php echo htmlspecialchars($reply['alumni_id']); ?>"><?php echo htmlspecialchars($replyAuthorData["firstname"] ?? '') . " " . htmlspecialchars($replyAuthorData["lastname"] ?? ''); ?></a>
                </h6>
                <span><?php echo timeAgo($reply["date_replied"]); ?></span>
            </div>
            <div class="comment-body">
                <?php echo htmlspecialchars($reply["comment"]); ?>
            </div>
        </div>
    </li>
    <?php
    return ob_get_clean();
}

if (isset($_GET['job_id']) && isset($_GET['last_update']) && isset($_GET['alumni_id'])) {
    $jobId = $_GET['job_id'];
    $lastUpdate = $_GET['last_update'];
    $alumniId = $_GET['alumni_id'];

    $commentData = $firebase->retrieve("job_comments");
    $commentData = json_decode($commentData, true);
    $jobComments = [];

    if (is_array($commentData)) {
        foreach ($commentData as $commentId => $comment) {
            if ($comment["job_id"] === $jobId) {
                $comment["date_ago"] = timeAgo($comment["date_commented"]);
                $jobComments[$commentId] = $comment;
            }
        }
    }

    if (!empty($jobComments)) {
        echo '<ul id="comment-list" class="comment-list">';
        foreach ($jobComments as $commentId => $comment) {
            echo renderComment($comment, $commentId, $alumniId, $firebase);
        }
        echo '</ul>';
    } else {
        echo '<ul id="comment-list" class="comment-list"><li id="no-comments-message" class="center-message">Be the First to Comment</li></ul>';
    }
}
?>
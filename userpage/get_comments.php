<?php
require_once '../includes/firebaseRDB.php';

// Initialize Firebase URL
$databaseURL = "https://mccnians-bc4f4-default-rtdb.firebaseio.com";
$firebase = new firebaseRDB($databaseURL);
$event_id = $_GET['event_id'];

// Fetch comments for the event
$commentData = $firebase->retrieve("comment");
$commentData = json_decode($commentData, true);

// Filter comments for this event and generate HTML
$html = '';
foreach ($commentData as $commentId => $comment) {
    if ($comment['event_id'] === $event_id) {
        $commenterData = $firebase->retrieve("alumni/{$comment['alumni_id']}");
        $commenterData = json_decode($commenterData, true);
        $commenterProfileUrl = $commenterData['profile_url'];
        $commenterFirstName = $commenterData['firstname'];
        $commenterLastName = $commenterData['lastname'];

        $html .= '<li data-comment-id="' . $commentId . '">
            <div class="comment-main-level">
                <div class="comment-avatar"><img src="' . $commenterProfileUrl . '" alt=""></div>
                <div class="comment-box">
                    <div class="comment-head">
                        <h6 class="comment-name by-author">
                            <a href="#">' . $commenterFirstName . ' ' . $commenterLastName . '</a>
                        </h6>
                        <span>' . timeAgo($comment['date_commented']) . '</span>
                        <i class="fa fa-reply reply-button"></i>
                        <i class="fa fa-heart"></i>
                    </div>
                    <div class="comment-content">
                        ' . htmlspecialchars($comment['comment']) . '
                    </div>
                </div>
            </div>
            <div class="reply-container" style="display: none;"></div>
            <ul class="comments-list reply-list">';

        if (isset($comment['replies'])) {
            foreach ($comment['replies'] as $replyId => $reply) {
                $replyAuthorData = $firebase->retrieve("alumni/{$reply['alumni_id']}");
                $replyAuthorData = json_decode($replyAuthorData, true);

                $html .= '<li>
                    <div class="comment-avatar"><img src="' . $replyAuthorData['profile_url'] . '" alt=""></div>
                    <div class="comment-box">
                        <div class="comment-head">
                            <h6 class="comment-name by-author">
                                <a href="#">' . $replyAuthorData['firstname'] . ' ' . $replyAuthorData['lastname'] . '</a>
                            </h6>
                            <span>' . timeAgo($reply['date_replied']) . '</span>
                        </div>
                        <div class="comment-content">
                            ' . htmlspecialchars($reply['comment']) . '
                        </div>
                    </div>
                </li>';
            }
        }

        $html .= '</ul></li>';
    }
}

echo $html;

function timeAgo($dateString) {
    $date = new DateTime($dateString);
    $now = new DateTime();
    $interval = $now->diff($date);

    if ($interval->y > 0) {
        return $interval->y . ' year' . ($interval->y > 1 ? 's' : '') . ' ago';
    } elseif ($interval->m > 0) {
        return $interval->m . ' month' . ($interval->m > 1 ? 's' : '') . ' ago';
    } elseif ($interval->d > 0) {
        return $interval->d . ' day' . ($interval->d > 1 ? 's' : '') . ' ago';
    } elseif ($interval->h > 0) {
        return $interval->h . ' hour' . ($interval->h > 1 ? 's' : '') . ' ago';
    } elseif ($interval->i > 0) {
        return $interval->i . ' minute' . ($interval->i > 1 ? 's' : '') . ' ago';
    } else {
        return 'Just now';
    }
}
?>
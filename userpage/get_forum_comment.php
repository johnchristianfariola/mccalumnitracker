<!--====get_forum_comment.php======-->
<?php
include '../includes/session.php';
require_once '../includes/firebaseRDB.php';
require_once '../includes/config.php';

$firebase = new firebaseRDB($databaseURL);

function time_elapsed_string($datetime, $full = false)
{
    $now = new DateTime('now', new DateTimeZone('Asia/Manila'));
    $ago = new DateTime($datetime, new DateTimeZone('Asia/Manila'));
    $diff = $now->diff($ago);

    $diff->w = floor($diff->d / 7);
    $diff->d -= $diff->w * 7;

    $string = array(
        'y' => 'year',
        'm' => 'month',
        'w' => 'week',
        'd' => 'day',
        'h' => 'hour',
        'i' => 'minute',
        's' => 'second',
    );

    foreach ($string as $k => &$v) {
        if ($diff->$k) {
            $v = $diff->$k . ' ' . $v . ($diff->$k > 1 ? 's' : '');
        } else {
            unset($string[$k]);
        }
    }

    if (!$full)
        $string = array_slice($string, 0, 1);
    return $string ? implode(', ', $string) . ' ago' : 'just now';
}

if (isset($_GET['forum_id'])) {
    $forum_id = $_GET['forum_id'];

    $all_comments = $firebase->retrieve("forum_comments");
    $all_comments = json_decode($all_comments, true);

    $alumni_data = $firebase->retrieve("alumni");
    $alumni_data = json_decode($alumni_data, true);

    if ($all_comments === null) {
        echo '<div class="no-comments">Unable to retrieve comments at this time.</div>';
    } else {
        if (!is_array($all_comments)) {
            echo '<div class="no-comments">Error processing comments data.</div>';
        } else {
            $forum_comments = array_filter($all_comments, function ($comment) use ($forum_id) {
                return isset($comment['forum_id']) && $comment['forum_id'] === $forum_id;
            });

            if ($forum_comments) {
                foreach ($forum_comments as $comment_id => $comment) {
                    $commenter = $alumni_data[$comment['alumni_id']] ?? null;
                    $commenter_name = $commenter ? $commenter['firstname'] . ' ' . $commenter['lastname'] : 'Unknown Alumni';
                    $commenter_profile = $commenter['profile_url'] ?? '../images/profile.png';
                    ?>
                    <div class="comment">
                        <div class="comment-author">
                            <img src="<?php echo htmlspecialchars($commenter_profile); ?>" class="comment-avatar" alt="author" onerror="if (this.src != 'uploads/profile.jpg') this.src = 'uploads/profile.jpg';">
                            <span><?php echo htmlspecialchars($commenter_name); ?></span>
                            &nbsp;&nbsp;&nbsp;
                            <span class="comment-time"><?php echo time_elapsed_string($comment['date_commented']); ?></span>
                        </div>
                        <div class="comment-content">
                            <?php echo htmlspecialchars($comment['comment']); ?>
                        </div>
                        <div class="reply-section">
                            <span class="heart-btn" data-comment-id="<?php echo $comment_id; ?>">
                                <i
                                    class="fa <?php echo in_array($_SESSION['user']['id'], $comment['liked_by'] ?? []) ? 'fa-heart' : 'fa-heart-o'; ?>"></i>
                            </span>
                            <span class="heart-count"><?php echo $comment['heart_count'] ?? 0; ?></span>
                            &nbsp;&nbsp;
                            <span class="dislike-btn" data-comment-id="<?php echo $comment_id; ?>">
                                <i
                                    class="fa <?php echo in_array($_SESSION['user']['id'], $comment['disliked_by'] ?? []) ? 'fa-thumbs-down' : 'fa-thumbs-o-down'; ?>"></i>
                            </span>
                            <span class="dislike-count"><?php echo $comment['dislike_count'] ?? 0; ?></span>
                            <button class="reply-btn" data-comment-id="<?php echo $comment_id; ?>">Reply</button>
                            <div class="reply-input-area" style="display: none;">
                                <input type="text" class="reply-input" placeholder="Write a reply...">
                                <button class="submit-reply-btn" data-comment-id="<?php echo $comment_id; ?>">Reply</button>
                            </div>
                            <div class="reply-list">
                                <?php
                                if (isset($comment['replies'])) {
                                    $replies = is_array($comment['replies']) ? $comment['replies'] : [$comment['replies']];
                                    foreach ($replies as $reply_id => $reply) {
                                        $replier = $alumni_data[$reply['alumni_id']] ?? null;
                                        $replier_name = $replier ? $replier['firstname'] . ' ' . $replier['lastname'] : 'Unknown Alumni';
                                        $replier_profile = $replier['profile_url'] ?? '../images/profile.png';
                                        ?>
                                        <div class="reply">
                                            <div class="reply-author">
                                                <img class="comment-avatar" src="<?php echo htmlspecialchars($replier_profile); ?>" alt="author" onerror="if (this.src != 'uploads/profile.jpg') this.src = 'uploads/profile.jpg';">
                                                <span><?php echo htmlspecialchars($replier_name); ?></span>
                                                &nbsp;&nbsp;&nbsp;
                                                <span class="reply-time"><?php echo time_elapsed_string($reply['date_replied']); ?></span>
                                            </div>
                                            <div class="reply-content">
                                                <?php echo htmlspecialchars($reply['reply']); ?>
                                            </div>
                                        </div>
                                        <?php
                                    }
                                }
                                ?>
                            </div>
                        </div>
                    </div>
                    <?php
                }
            } else {
                echo '<div class="no-comments">No comments yet. Be the first to comment!</div>';
            }
        }
    }
}
?>
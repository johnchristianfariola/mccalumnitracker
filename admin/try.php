
<?php
// Include Firebase database handling class
require_once '../includes/firebaseRDB.php';

// Initialize Firebase URL
$databaseURL = "https://mccnians-bc4f4-default-rtdb.firebaseio.com";
$firebase = new firebaseRDB($databaseURL);

// Get the news ID from the URL
if (isset($_GET['id'])) {
    $news_id = $_GET['id'];

    // Retrieve the specific news item using the ID
    $news_data = $firebase->retrieve("news/{$news_id}");
    $news_data = json_decode($news_data, true);

    if ($news_data) {
        // Display news details
        $image_url = htmlspecialchars($news_data['image_url']);
        $news_author = htmlspecialchars($news_data['news_author']);
        $news_created = htmlspecialchars($news_data['news_created']);
        $news_description = nl2br(htmlspecialchars($news_data['news_description']));
        $news_title = htmlspecialchars($news_data['news_title']);
        ?>

        <!DOCTYPE html>
        <html lang="en">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title><?php echo $news_title; ?></title>
            <link rel="stylesheet" href="path/to/your/css/styles.css">
        </head>
        <body>
            <div class="news-details">
                <img src="../admin/<?php echo $image_url; ?>" alt="News Image">
                <h1></h1>
                <p>Posted By </p>
                <p>Date: </p>
                <div class="news-description">
                    <?php echo $news_description; ?>
                </div>
            </div>
        </body>
        </html>

        <?php
    } else {
        echo "News item not found.";
    }
} else {
    echo "No news ID provided.";
}
?>

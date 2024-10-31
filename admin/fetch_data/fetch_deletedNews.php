<?php
//fetch_deletedNews.php
require_once 'includes/firebaseRDB.php';
require_once 'includes/config.php';

$firebase = new firebaseRDB($databaseURL);

$data = $firebase->retrieve("deleted_news");
$data = json_decode($data, true);

if (is_array($data)) {
   foreach ($data as $id => $news) {
       $news_description_plain = strip_tags($news['news_description']);
       $image_html = $news['image_url'] ? "<img src='{$news['image_url']}' alt='News Image' width='65px' height='65px'>" : '';

       echo "<tr>
               <td>$image_html</td>
               <td>{$news['news_title']}</td>
               <td>{$news['news_author']}</td>
               <td class='description-cell'>$news_description_plain</td>
               <td>{$news['news_created']}</td>
               <td>
               <a class='btn btn-success btn-sm btn-flat open-retrieve' data-id='$id'>RESTORE</a>
               <a class='btn btn-danger btn-sm btn-flat open-delete' data-id='$id'>DELETE</a>
               </td>
             </tr>";
   }
}
?>
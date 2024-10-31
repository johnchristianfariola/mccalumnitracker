<?php 
require_once 'includes/firebaseRDB.php'; 
require_once 'includes/config.php'; // Include your config file 

$firebase = new firebaseRDB($databaseURL); 
$data = $firebase->retrieve("deleted_gallery"); 
$data = json_decode($data, true); 

if (is_array($data)) { 
    foreach ($data as $id => $gallery) { 
        // Strip HTML tags from gallery_description 
        // Prepare image HTML if image_url is available 
        $image_html = ''; 
        if (isset($gallery['image_url']) && !empty($gallery['image_url'])) { 
            $image_html = "<img src='{$gallery['image_url']}' alt='gallery Image' width='65px' height='65px'>"; 
        } 
        echo "<tr> 
                <td>{$image_html}</td> 
                <td>{$gallery['gallery_name']}</td> 
                <td>{$gallery['created_on']}</td> 
                <td> 
                    <a class='btn btn-success btn-sm btn-flat open-retrieve' data-id='$id'>RESTORE</a> 
                    <a class='btn btn-danger btn-sm btn-flat open-delete' data-id='$id'>DELETE</a> 
                </td> 
              </tr>"; 
    } 
} 
?>
<?php
// Include the firebaseRDB class
require_once 'firebaseRDB.php';

// Firebase configuration
$firebase_url = "https://mccalumniapp-default-rtdb.firebaseio.com/";
$firebase = new firebaseRDB($firebase_url);

// Handle file upload
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['image']) && isset($_POST['userId'])) {
    $uploadDir = 'userpage/uploads/';
    $userId = $_POST['userId'];
    $fileName = 'profile_' . $userId . '_' . time() . '.jpg';
    $targetPath = $uploadDir . $fileName;

    if (move_uploaded_file($_FILES['image']['tmp_name'], $targetPath)) {
        // File uploaded successfully, now update Firebase
        $imageUrl = 'uploads/' . $fileName;  // Relative path to be stored in Firebase
        
        // Prepare data for Firebase update
        $data = [
            'profile_url' => $imageUrl
        ];

        // Update Firebase
        $result = $firebase->update('alumni', $userId, $data);

        if ($result) {
            // Successfully updated Firebase
            echo json_encode([
                'success' => true,
                'imageUrl' => $imageUrl,
                'message' => 'Image uploaded and profile updated successfully'
            ]);
        } else {
            // Failed to update Firebase
            http_response_code(500);
            echo json_encode([
                'success' => false,
                'message' => 'Image uploaded but failed to update profile'
            ]);
        }
    } else {
        // Failed to upload file
        http_response_code(500);
        echo json_encode([
            'success' => false,
            'message' => 'Failed to upload image'
        ]);
    }
} else {
    // Invalid request
    http_response_code(400);
    echo json_encode([
        'success' => false,
        'message' => 'Invalid request'
    ]);
}
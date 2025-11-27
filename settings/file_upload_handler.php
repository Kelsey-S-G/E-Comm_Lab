<?php
// settings/file_upload_handler.php

function uploadFile($file, $subfolder = 'misc') {
    // Define base upload directory
    $base_dir = __DIR__ . "/../uploads/";
    
    // Target directory
    $target_dir = $base_dir . $subfolder . "/";
    
    // Create directory if it doesn't exist
    if (!is_dir($target_dir)) {
        mkdir($target_dir, 0755, true); // Recursive creation
    }

    // Sanitize filename
    $filename = basename($file["name"]);
    $filename = preg_replace("/[^a-zA-Z0-9\._-]/", "", $filename); // Remove special chars
    
    // Generate unique name to prevent overwrites
    $unique_name = time() . "_" . uniqid() . "_" . $filename;
    $target_file = $target_dir . $unique_name;
    
    // Validation
    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
    $allowed_types = ['jpg', 'jpeg', 'png', 'gif', 'webp', 'pdf'];
    
    // Check is image (if applicable)
    $check = getimagesize($file["tmp_name"]);
    if($check === false && $imageFileType != 'pdf') {
        return false; // Not an image
    }

    // Check file size (e.g., limit to 5MB)
    if ($file["size"] > 5000000) {
        return false; // Too large
    }

    // Check format
    if(!in_array($imageFileType, $allowed_types)) {
        return false;
    }

    // Upload
    if (move_uploaded_file($file["tmp_name"], $target_file)) {
        // Return relative path for DB storage
        return "../uploads/" . $subfolder . "/" . $unique_name;
    } else {
        return false;
    }
}
?>
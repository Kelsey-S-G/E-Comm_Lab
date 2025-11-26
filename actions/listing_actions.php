<?php
// actions/listing_actions.php
require_once("../controllers/listing_controller.php");
require_once("../settings/core.php");

check_login(); // Security Check

header('Content-Type: application/json');

$action = $_POST['action'] ?? '';

// --- Image Upload Helper ---
function uploadImage($file) {
    $target_dir = "../uploads/";
    
    // Create uploads dir if not exists
    if (!is_dir($target_dir)) {
        mkdir($target_dir, 0755, true);
    }

    $target_file = $target_dir . basename($file["name"]);
    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
    $check = getimagesize($file["tmp_name"]);

    if($check !== false) {
        if (move_uploaded_file($file["tmp_name"], $target_file)) {
            return $target_file; // Return relative path for DB
        }
    }
    return false;
}

switch ($action) {
    case 'add':
        $venture_id = $_POST['venture_id'];
        $title = $_POST['title'];
        $price = $_POST['price'];
        $desc = $_POST['desc'];
        $type = $_POST['type']; // Product or Mentorship
        $keywords = $_POST['keywords'];
        
        // Handle Image
        $imagePath = null;
        if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
            $imagePath = uploadImage($_FILES['image']);
        }

        if (!$imagePath) {
            echo json_encode(['status' => 'error', 'message' => 'Valid Image is required']);
            exit();
        }

        $result = add_listing_ctr($venture_id, $title, $price, $desc, $type, $imagePath, $keywords);
        
        if ($result) {
            echo json_encode(['status' => 'success', 'message' => 'Listing published successfully']);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Database error']);
        }
        break;

    case 'update':
        $id = $_POST['listing_id'];
        $title = $_POST['title'];
        $price = $_POST['price'];
        $desc = $_POST['desc'];
        $type = $_POST['type'];
        $keywords = $_POST['keywords'];
        
        // Check if new image uploaded
        $imagePath = null;
        if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
            $imagePath = uploadImage($_FILES['image']);
        }

        $result = update_listing_ctr($id, $title, $price, $desc, $type, $keywords, $imagePath);
        
        if ($result) {
            echo json_encode(['status' => 'success', 'message' => 'Listing updated']);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Update failed']);
        }
        break;

    // Add Delete case similarly...
    default:
        echo json_encode(['status' => 'error', 'message' => 'Invalid action']);
}
?>
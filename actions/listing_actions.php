<?php
// actions/listing_actions.php
require_once("../controllers/listing_controller.php");
require_once("../settings/core.php");
require_once("../settings/file_upload_handler.php"); // Include Helper

check_login();

header('Content-Type: application/json');

$action = $_POST['action'] ?? '';

switch ($action) {
    case 'add':
        // Collect inputs
        $venture_id = $_POST['venture_id'];
        $title = $_POST['title'];
        $price = $_POST['price'];
        $desc = $_POST['desc'];
        $type = $_POST['type'];
        $keywords = $_POST['keywords'];
        
        // CLEANER IMAGE HANDLING
        $imagePath = null;
        if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
            $imagePath = uploadFile($_FILES['image'], 'listings'); // Use Helper
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
        
        $imagePath = null;
        // Check if a new image was uploaded
        if (isset($_FILES['image']) && $_FILES['image']['size'] > 0 && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
            $imagePath = uploadFile($_FILES['image'], 'listings');
        }

        // If $imagePath is null, the controller should handle keeping the old image
        $result = update_listing_ctr($id, $title, $price, $desc, $type, $keywords, $imagePath);
        
        if ($result) {
            echo json_encode(['status' => 'success', 'message' => 'Listing updated']);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Update failed']);
        }
        break;

    default:
        echo json_encode(['status' => 'error', 'message' => 'Invalid action']);
}
?>
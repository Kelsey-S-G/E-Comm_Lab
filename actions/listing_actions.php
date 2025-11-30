<?php
// actions/listing_actions.php
require_once("../controllers/listing_controller.php");
require_once("../settings/core.php");
require_once("../settings/file_upload_handler.php");

check_login(); // Ensure user is logged in

header('Content-Type: application/json');

$action = $_POST['action'] ?? '';
$user_id = get_user_id();
$user_role = $_SESSION['user_role'] ?? 2; // 1 = Admin, 2 = Alumni
$user_inst_id = $_SESSION['institution_id'] ?? 0;

switch ($action) {
    case 'add':
        // 1. Check Verification
        if (!isVerified()) {
            echo json_encode(['status' => 'error', 'message' => 'Only verified alumni can post listings.']);
            exit();
        }

        // 2. Collect Inputs
        $venture_id = $_POST['venture_id'];
        $title = $_POST['title'];
        $price = $_POST['price'];
        $desc = $_POST['desc'];
        $type = $_POST['type'];
        $keywords = $_POST['keywords'];
        
        // 3. Handle Image Upload
        $imagePath = null;
        if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
            $imagePath = uploadFile($_FILES['image'], 'listings');
        }

        if (!$imagePath) {
            echo json_encode(['status' => 'error', 'message' => 'Valid Image is required for new listings']);
            exit();
        }

        // 4. Create Listing
        $result = add_listing_ctr($venture_id, $title, $price, $desc, $type, $imagePath, $keywords);
        
        if ($result) {
            echo json_encode(['status' => 'success', 'message' => 'Listing published successfully']);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Database error']);
        }
        break;
    
    case 'update':
        $id = $_POST['listing_id'];
        
        // 1. Fetch Listing & Permission Check
        $target = get_single_listing_ctr($id);

        if (!$target) { 
            echo json_encode(['status' => 'error', 'message' => 'Listing not found']); 
            exit(); 
        }

        // Note: $target should ideally include 'owner_id' and 'institution_id' from the join in get_one_listing
        // Assuming listing_class.php's get_one_listing JOINs to alumni table via venture
        // (Ensure your get_one_listing query selects a.alumni_id as owner_id and a.institution_id)
        
        $owner_id = $target['owner_id'] ?? 0; 
        $owner_inst_id = $target['institution_id'] ?? 0; // The institution of the listing owner

        $is_owner = ($owner_id == $user_id);
        $is_inst_admin = ($user_role == 1 && $owner_inst_id == $user_inst_id);

        if (!$is_owner && !$is_inst_admin) {
             echo json_encode(['status' => 'error', 'message' => 'Unauthorized. You can only edit your own listings.']);
             exit();
        }

        // 2. Collect Update Data
        $title = $_POST['title'];
        $price = $_POST['price'];
        $desc = $_POST['desc'];
        $type = $_POST['type'];
        $keywords = $_POST['keywords'];
        
        // 3. Handle Optional New Image
        $imagePath = null;
        if (isset($_FILES['image']) && $_FILES['image']['size'] > 0 && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
            $imagePath = uploadFile($_FILES['image'], 'listings');
        }

        // 4. Update
        $result = update_listing_ctr($id, $title, $price, $desc, $type, $keywords, $imagePath);
        
        if ($result) {
            echo json_encode(['status' => 'success', 'message' => 'Listing updated successfully']);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Update failed']);
        }
        break;

    case 'delete':
        $id = $_POST['listing_id'];

        // 1. Fetch Listing & Permission Check
        $target = get_single_listing_ctr($id);

        if (!$target) { 
            echo json_encode(['status' => 'error', 'message' => 'Listing not found']); 
            exit(); 
        }

        $owner_id = $target['owner_id'] ?? 0;
        $owner_inst_id = $target['institution_id'] ?? 0;

        $is_owner = ($owner_id == $user_id);
        $is_inst_admin = ($user_role == 1 && $owner_inst_id == $user_inst_id);

        if (!$is_owner && !$is_inst_admin) {
            echo json_encode(['status' => 'error', 'message' => 'Unauthorized. You cannot delete this listing.']);
            exit();
        }

        // 2. Delete
        $result = delete_listing_ctr($id);
        
        if ($result) {
            echo json_encode(['status' => 'success', 'message' => 'Listing deleted successfully']);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Delete failed']);
        }
        break;

    default:
        echo json_encode(['status' => 'error', 'message' => 'Invalid action']);
}
?>
<?php
// actions/cart_actions.php
require_once("../controllers/cart_controller.php");
require_once("../controllers/listing_controller.php"); // Added to check ownership
require_once("../settings/core.php");

if (!is_logged_in()) {
    echo json_encode(['status' => 'error', 'message' => 'Please login to shop.']);
    exit();
}

header('Content-Type: application/json');

$action = $_POST['action'] ?? '';
$user_id = get_user_id();

switch ($action) {
    case 'add':
        // CHECK 1: Verification
        if (!isVerified()) {
            echo json_encode(['status' => 'error', 'message' => 'Only verified alumni can make purchases.']);
            exit();
        }

        $p_id = $_POST['listing_id'];
        $qty = $_POST['qty'] ?? 1;

        // CHECK 2: PREVENT SELF-PURCHASE
        // Fetch listing details to check owner
        $listing = get_one_listing_ctr($p_id);
        if ($listing && $listing['owner_id'] == $user_id) {
            echo json_encode(['status' => 'error', 'message' => 'You cannot buy your own listing!']);
            exit();
        }

        $ip_add = $_SERVER['REMOTE_ADDR'];
        
        $result = add_to_cart_ctr($p_id, $ip_add, $user_id, $qty);
        
        if ($result) echo json_encode(['status' => 'success', 'message' => 'Added to cart']);
        else echo json_encode(['status' => 'error', 'message' => 'Failed to add to cart']);
        break;

    case 'update_qty':
        $p_id = $_POST['listing_id'];
        $qty = $_POST['qty'];
        
        if ($qty < 1) {
            echo json_encode(['status' => 'error', 'message' => 'Quantity must be at least 1']);
            exit();
        }

        $result = update_cart_qty_ctr($p_id, $user_id, $qty);
        if ($result) echo json_encode(['status' => 'success', 'message' => 'Cart updated']);
        else echo json_encode(['status' => 'error', 'message' => 'Update failed']);
        break;

    case 'remove':
        $p_id = $_POST['listing_id'];
        $result = remove_from_cart_ctr($p_id, $user_id);
        if ($result) echo json_encode(['status' => 'success', 'message' => 'Item removed']);
        else echo json_encode(['status' => 'error', 'message' => 'Removal failed']);
        break;

    case 'empty':
        $result = empty_cart_ctr($user_id);
        if ($result) echo json_encode(['status' => 'success', 'message' => 'Cart emptied']);
        else echo json_encode(['status' => 'error', 'message' => 'Failed to empty cart']);
        break;

    default:
        echo json_encode(['status' => 'error', 'message' => 'Invalid action']);
}
?>
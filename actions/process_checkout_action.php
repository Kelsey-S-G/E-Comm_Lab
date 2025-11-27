<?php
// actions/process_checkout_action.php
// UPDATED: Prepares order for Paystack (Does NOT finalize payment)

require_once("../controllers/cart_controller.php");
require_once("../controllers/order_controller.php");
require_once("../settings/core.php");

check_login(); 

header('Content-Type: application/json');

$user_id = get_user_id();

// 1. Get Cart
$cart_items = get_cart_items_ctr($user_id);
if (empty($cart_items)) {
    echo json_encode(['status' => 'error', 'message' => 'Cart is empty']);
    exit();
}

// 2. Generate Reference (Invoice No)
// This must match what we send to Paystack later
$invoice_no = 'REC-' . mt_rand(10000, 99999) . '-' . time();

// 3. Create "Pending" Order
$order_id = create_order_ctr($user_id, $invoice_no, 'pending');

if ($order_id) {
    // 4. Save Cart Items to Order Details (Snapshot)
    foreach ($cart_items as $item) {
        add_order_details_ctr($order_id, $item['p_id'], $item['qty']);
    }

    // 5. Return Success & Invoice No
    // The Frontend will use this invoice_no as the Paystack "reference"
    echo json_encode([
        'status' => 'success', 
        'message' => 'Order initialized',
        'invoice_no' => $invoice_no,
        'order_id' => $order_id
    ]);

} else {
    echo json_encode(['status' => 'error', 'message' => 'Failed to initialize order']);
}
?>
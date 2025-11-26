<?php
// actions/process_checkout_action.php
require_once("../controllers/cart_controller.php");
require_once("../controllers/order_controller.php");
require_once("../settings/core.php");

check_login(); // Security Check

header('Content-Type: application/json');

$user_id = get_user_id();

// 1. Get Current Cart Items
$cart_items = get_cart_items_ctr($user_id);
$total_amount = get_cart_total_ctr($user_id);

if (empty($cart_items)) {
    echo json_encode(['status' => 'error', 'message' => 'Cart is empty']);
    exit();
}

// 2. Generate Unique Invoice Number
$invoice_no = 'REC-' . mt_rand(1000, 9999) . '-' . time();

// 3. Create Order
$order_id = create_order_ctr($user_id, $invoice_no);

if ($order_id) {
    // 4. Move Cart Items to Order Details
    foreach ($cart_items as $item) {
        add_order_details_ctr($order_id, $item['p_id'], $item['qty']);
    }

    // 5. Record Payment (Simulated)
    record_payment_ctr($total_amount, $user_id, $order_id);

    // 6. Empty Cart
    empty_cart_ctr($user_id);

    echo json_encode([
        'status' => 'success', 
        'message' => 'Payment successful! Order placed.',
        'order_id' => $order_id,
        'invoice' => $invoice_no
    ]);
} else {
    echo json_encode(['status' => 'error', 'message' => 'Failed to create order']);
}
?>
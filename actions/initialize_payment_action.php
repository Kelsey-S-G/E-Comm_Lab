<?php
// actions/initialize_payment_action.php
require_once("../controllers/cart_controller.php");
require_once("../controllers/order_controller.php"); // Reuse order creation logic
require_once("../controllers/paystack_controller.php");
require_once("../settings/core.php");

check_login();

header('Content-Type: application/json');

$user_id = get_user_id();
// Assuming we store email in session, or fetch it
// For robustness, let's fetch the user's email from DB if not in session
// For now, using a placeholder or session email
$user_email = $_SESSION['user_email'] ?? 'customer@reconnect.com'; 

// 1. Get Cart Total
$cart_total = get_cart_total_ctr($user_id);
$platform_fee = $cart_total * 0.02;
$final_amount = $cart_total + $platform_fee;

if ($final_amount <= 0) {
    echo json_encode(['status' => 'error', 'message' => 'Cart is empty']);
    exit();
}

// 2. Generate Reference
$reference = 'REC-' . mt_rand(10000, 99999) . '-' . time();

// 3. Call Paystack
$paystack_response = initialize_paystack_payment($user_email, $final_amount, $reference);

if ($paystack_response['status']) {
    // 4. Create "Pending" Order in DB before redirecting
    // This ensures we have a record to update later
    $order_id = create_order_ctr($user_id, $reference, 'pending');
    
    // Move items to order details (Pending state)
    $cart_items = get_cart_items_ctr($user_id);
    foreach ($cart_items as $item) {
        add_order_details_ctr($order_id, $item['p_id'], $item['qty']);
    }

    // Return Authorization URL to frontend
    echo json_encode([
        'status' => 'success', 
        'authorization_url' => $paystack_response['data']['authorization_url'],
        'reference' => $reference
    ]);
} else {
    echo json_encode(['status' => 'error', 'message' => 'Paystack initialization failed: ' . $paystack_response['message']]);
}
?>
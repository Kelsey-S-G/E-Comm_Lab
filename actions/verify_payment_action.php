<?php
// actions/verify_payment_action.php
require_once("../controllers/paystack_controller.php");
require_once("../controllers/order_controller.php");
require_once("../controllers/cart_controller.php");
require_once("../settings/core.php");

// Optional: Check login if accessed directly by user browser
// If used as webhook, validation would be different (signature check)
if (isset($_GET['reference'])) {
    check_login(); 
}

header('Content-Type: application/json');

$reference = $_REQUEST['reference'] ?? '';

if (!$reference) {
    echo json_encode(['status' => 'error', 'message' => 'No reference provided']);
    exit();
}

// 1. Verify with Paystack
$verification = verify_paystack_payment($reference);

if ($verification['status'] && $verification['data']['status'] === 'success') {
    
    $amount_paid = $verification['data']['amount'] / 100;
    $paystack_email = $verification['data']['customer']['email'];
    
    // 2. Find Order
    $order = get_order_by_invoice_ctr($reference);

    if ($order) {
        // 3. Check if already paid to avoid duplicates
        // Assuming 'status' column in orders table tracks this
        if ($order['status'] === 'success') {
             echo json_encode(['status' => 'success', 'message' => 'Order already verified']);
             exit();
        }

        // 4. Record Payment
        // Use the user_id from the order, not necessarily the session (for webhooks)
        $user_id = $order['buyer_id'];
        
        $record_result = record_payment_ctr($amount_paid, $user_id, $order['order_id']);
        
        // 5. Update Order Status
        update_order_status_ctr($order['order_id'], 'success');

        // 6. Empty Cart (If user is online/session active)
        // Note: Doing this via webhook is tricky for specific user sessions. 
        // Best done on the callback page or if we have a cart table linked to user_id in DB.
        if (isset($_SESSION['user_id']) && $_SESSION['user_id'] == $user_id) {
            empty_cart_ctr($user_id);
        }

        // 7. Send Email (Reusing the function from core.php)
        // Fetch user name if possible, or use "Valued Customer"
        $user_name = "Alumni"; 
        // send_payment_receipt($paystack_email, $user_name, $reference, $amount_paid);

        echo json_encode(['status' => 'success', 'message' => 'Payment Verified']);

    } else {
        echo json_encode(['status' => 'error', 'message' => 'Order not found for reference']);
    }

} else {
    echo json_encode(['status' => 'error', 'message' => 'Verification failed: ' . $verification['message']]);
}
?>
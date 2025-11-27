<?php
require_once("../controllers/payment_controller.php");
require_once("../controllers/order_controller.php");
require_once("../controllers/cart_controller.php");
require_once("../settings/core.php");

// 1. Ensure user is logged in
check_login();

$reference = $_GET['reference'] ?? '';
$status_msg = "Verifying payment...";
$status_class = "info";

if ($reference) {
    // 2. Verify with Paystack API
    $verification = verify_paystack_payment($reference);

    if ($verification['status'] && $verification['data']['status'] === 'success') {
        
        // 3. Get Verification Data
        $amount_paid = $verification['data']['amount'] / 100; // Convert kobo to GHS
        $paystack_email = $verification['data']['customer']['email']; // Email from Paystack transaction
        $user_id = get_user_id();
        $user_name = get_user_name(); // Ensure this function exists in core.php

        // 4. Find the Pending Order
        // Ideally, get_order_by_invoice_ctr($reference) should return the order details
        // If not implemented, we assume the current session user owns the pending order
        // For robustness, let's assume we have the order ID from the reference logic or session
        
        // RECORD PAYMENT
        // Assuming we fetch the order ID based on the reference (invoice_no)
        $order = get_order_by_invoice_ctr($reference);

        if ($order) {
            // Record in DB
            record_payment_ctr($amount_paid, $user_id, $order['order_id']);
            
            // Update Order Status to 'Success' (Optional but recommended)
            // update_order_status_ctr($order['order_id'], 'success');

            // Empty Cart
            empty_cart_ctr($user_id);
            
            // --- NEW: SEND EMAIL RECEIPT ---
            // Use the email from Paystack or Session
            send_payment_receipt($paystack_email, $user_name, $reference, $amount_paid);

            $status_msg = "Payment Successful! A receipt has been sent to $paystack_email.";
            $status_class = "success";
        } else {
            // Edge case: Payment verified but DB order not found immediately
            $status_msg = "Payment verified. Order processing...";
            $status_class = "warning";
        }

    } else {
        $status_msg = "Payment Failed or Declined.";
        $status_class = "error";
    }
} else {
    $status_msg = "Invalid reference.";
    $status_class = "error";
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Payment Status - ReConnect</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="../style.css" />
    <style>
        .status-card { max-width: 500px; margin: 100px auto; padding: 2rem; border-radius: 12px; text-align: center; background: var(--color-surface-elevated); box-shadow: var(--shadow-level-2); }
        .success { color: green; border: 1px solid green; }
        .error { color: red; border: 1px solid red; }
        .warning { color: orange; border: 1px solid orange; }
        .info { color: blue; }
        h2 { margin-bottom: 1rem; }
    </style>
</head>
<body>
    <?php include 'header.php'; ?>
    
    <div class="status-card <?php echo $status_class; ?>">
        <h2><?php echo $status_msg; ?></h2>
        <?php if($reference): ?>
            <p>Reference: <strong><?php echo htmlspecialchars($reference); ?></strong></p>
        <?php endif; ?>
        <br>
        <a href="listings.php" class="btn btn-primary">Return to Marketplace</a>
    </div>

    <?php include 'footer.php'; ?>
</body>
</html>
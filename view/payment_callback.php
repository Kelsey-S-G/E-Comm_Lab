<?php
// ReConnect/view/payment_callback.php
require_once("../controllers/paystack_controller.php");
require_once("../controllers/order_controller.php");
require_once("../controllers/cart_controller.php");
require_once("../settings/core.php");

// 1. Ensure user is logged in
check_login();

// Get reference from URL
$reference = $_GET['reference'] ?? $_GET['trxref'] ?? '';
$status_msg = "Verifying payment...";
$status_class = "info";

if ($reference) {
    // 2. Verify with Paystack API
    $verification = verify_paystack_payment($reference);

    if ($verification['status'] && $verification['data']['status'] === 'success') {
        
        // 3. Get Verification Data
        $amount_paid = $verification['data']['amount'] / 100;
        $paystack_email = $verification['data']['customer']['email'];
        $user_id = get_user_id();
        
        // Use Session name
        $user_name = $_SESSION['user_name'] ?? 'Valued Customer'; 

        // 4. Find the Pending Order
        $order = get_order_by_invoice_ctr($reference);

        if ($order) {
            // Check if already paid
            if ($order['status'] !== 'success') {
                // Record Payment
                record_payment_ctr($amount_paid, $user_id, $order['order_id']);
                
                // Update Order Status
                update_order_status_ctr($order['order_id'], 'success');

                // Empty Cart
                empty_cart_ctr($user_id);
            }

            $status_msg = "Payment Successful! Thank you, $user_name.";
            $status_class = "success";
        } else {
            $status_msg = "Payment verified, but order record not found. Please contact support.";
            $status_class = "warning";
        }

    } else {
        $status_msg = "Payment Failed or Declined. Please try again.";
        $status_class = "error";
    }
} else {
    $status_msg = "Invalid reference provided.";
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
        /* Dark Theme Optimized Styles */
        body {
            background-color: var(--color-surface);
            color: var(--color-on-surface);
        }

        .status-card { 
            max-width: 500px; 
            margin: 100px auto; 
            padding: 3rem 2rem; 
            border-radius: 12px; 
            text-align: center; 
            background: var(--color-surface-elevated); 
            box-shadow: var(--shadow-level-2); 
            border: 1px solid var(--color-border);
        }

        /* Status Colors using RGBA for Dark Mode Transparency */
        .success { 
            border: 1px solid rgba(74, 222, 128, 0.3); /* Green Border */
            background-color: rgba(74, 222, 128, 0.1); /* Subtle Green Tint */
        }
        .success h2 { color: #4ade80; } /* Bright Green Text */

        .error { 
            border: 1px solid rgba(248, 113, 113, 0.3); /* Red Border */
            background-color: rgba(248, 113, 113, 0.1); /* Subtle Red Tint */
        }
        .error h2 { color: #f87171; } /* Bright Red Text */

        .warning { 
            border: 1px solid rgba(251, 191, 36, 0.3); /* Amber Border */
            background-color: rgba(251, 191, 36, 0.1); /* Subtle Amber Tint */
        }
        .warning h2 { color: #fbbf24; } /* Bright Amber Text */

        .info { 
            border: 1px solid rgba(96, 165, 250, 0.3); /* Blue Border */
            background-color: rgba(96, 165, 250, 0.1); /* Subtle Blue Tint */
        }
        .info h2 { color: #60a5fa; } /* Bright Blue Text */

        h2 { 
            margin-bottom: 1rem; 
            font-family: var(--font-family-heading); 
            font-size: 1.5rem;
        }

        p { 
            margin-bottom: 2rem; 
            color: var(--color-on-surface-secondary); 
            font-size: 1rem;
            line-height: 1.5;
        }

        /* Override button margin for this page */
        .btn-primary {
            width: 70%;
            justify-content: center;
        }
    </style>
</head>
<body>
    <?php include 'header.php'; ?>
    
    <div class="status-card <?php echo $status_class; ?>">
        <div style="font-size: 3rem; margin-bottom: 1rem;">
            <?php 
                if ($status_class == 'success') echo '✅';
                elseif ($status_class == 'error') echo '❌';
                elseif ($status_class == 'warning') echo '⚠️';
                else echo 'ℹ️';
            ?>
        </div>

        <h2><?php echo $status_msg; ?></h2>
        
        <?php if($reference): ?>
            <p>Transaction Reference: <br><strong style="color: var(--color-on-surface);"><?php echo htmlspecialchars($reference); ?></strong></p>
        <?php endif; ?>
        
        <div>
            <a href="listings.php" class="btn btn-primary">Return to Marketplace</a>
        </div>
    </div>

    <?php include 'footer.php'; ?>
</body>
</html>
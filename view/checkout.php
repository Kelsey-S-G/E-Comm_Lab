<?php
require_once("../settings/core.php");
require_once("../controllers/cart_controller.php");

check_login();
$user_id = get_user_id();
$cart_items = get_cart_items_ctr($user_id);
$cart_total = get_cart_total_ctr($user_id);

// ReConnect Ethical Fee (e.g., 2% for community fund)
$platform_fee = $cart_total * 0.02; 
$final_total = $cart_total + $platform_fee;

if (empty($cart_items)) {
    header("Location: cart.php"); // Redirect if empty
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Checkout - ReConnect</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="../style.css" />
    <link rel="stylesheet" href="../css/checkout.css" />
</head>
<body>
    <div class="checkout-container">
        <?php include 'header.php'; ?>

        <div class="checkout-content">
            <!-- Left: Billing Info (Static for Demo) -->
            <div class="checkout-form-section">
                <h1 class="checkout-title">Secure Checkout</h1>
                <form id="paymentForm" class="checkout-form">
                    <!-- ... Billing fields from your previous uploaded HTML ... -->
                    <fieldset class="form-section">
                        <h2 class="form-section-title">Billing Details</h2>
                        <div class="form-group">
                            <label>Full Name</label>
                            <input type="text" class="form-input" value="<?php echo $_SESSION['user_name']; ?>" readonly />
                        </div>
                        <!-- Simplified for Week 9 Demo -->
                        <div class="alert alert-info" style="margin-top: 1rem;">
                            <strong>Note:</strong> This is a simulated payment gateway for the academic project. No real money will be charged.
                        </div>
                    </fieldset>

                    <button type="button" class="btn btn-primary btn-lg" style="width: 100%;" onclick="showPaymentModal()">
                        Pay GHS <?php echo number_format($final_total, 2); ?>
                    </button>
                </form>
            </div>

            <!-- Right: Order Summary -->
            <aside class="order-summary-desktop">
                <h2 class="summary-title">Order Summary</h2>
                <div class="summary-items">
                    <?php foreach ($cart_items as $item): ?>
                        <div class="summary-item">
                            <div class="item-details">
                                <div style="display:flex; flex-direction:column;">
                                    <span class="item-name"><?php echo $item['title']; ?></span>
                                    <span class="item-seller">Qty: <?php echo $item['qty']; ?></span>
                                </div>
                            </div>
                            <p class="item-price">GHS <?php echo number_format($item['price'] * $item['qty'], 2); ?></p>
                        </div>
                    <?php endforeach; ?>
                </div>
                <div class="summary-divider"></div>
                <div class="summary-section">
                    <div class="summary-row"><span>Subtotal</span><span>GHS <?php echo number_format($cart_total, 2); ?></span></div>
                    <div class="summary-row"><span>ReConnect Fee (2%)</span><span>GHS <?php echo number_format($platform_fee, 2); ?></span></div>
                </div>
                <div class="summary-divider"></div>
                <div class="summary-total">
                    <span>Total</span><span>GHS <?php echo number_format($final_total, 2); ?></span>
                </div>
            </aside>
        </div>
    </div>

    <!-- Payment Simulation Modal -->
    <div id="paymentModal" style="display:none; position:fixed; top:0; left:0; width:100%; height:100%; background:rgba(0,0,0,0.8); z-index:2000; align-items:center; justify-content:center;">
        <div style="background:var(--color-surface-elevated); padding:2rem; border-radius:12px; max-width:400px; width:90%; text-align:center; border:1px solid var(--color-primary);">
            <h2>Confirm Payment</h2>
            <p style="margin: 1rem 0;">You are about to pay <strong>GHS <?php echo number_format($final_total, 2); ?></strong> to ReConnect.</p>
            <div style="display:flex; gap:1rem; justify-content:center;">
                <button class="btn btn-outline" onclick="closePaymentModal()">Cancel</button>
                <button class="btn btn-primary" onclick="processPayment()">Confirm Payment</button>
            </div>
        </div>
    </div>

    <script src="../js/checkout.js"></script>
</body>
</html>
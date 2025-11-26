<?php
require_once("../settings/core.php");
require_once("../controllers/cart_controller.php");

check_login();
$user_id = get_user_id();
$cart_items = get_cart_items_ctr($user_id);
$cart_total = get_cart_total_ctr($user_id);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Shopping Cart - ReConnect</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="../style.css" />
    <link rel="stylesheet" href="../css/marketplace.css" /> <!-- Reusing styles -->
    <style>
        .cart-table { width: 100%; border-collapse: collapse; margin: 2rem 0; }
        .cart-table th { text-align: left; padding: 1rem; background: var(--color-surface-elevated); }
        .cart-table td { padding: 1rem; border-bottom: 1px solid var(--color-border); }
        .cart-img { width: 60px; height: 60px; object-fit: cover; border-radius: 8px; }
        .qty-input { width: 50px; padding: 5px; text-align: center; }
        .cart-summary { background: var(--color-surface-elevated); padding: 2rem; border-radius: 12px; text-align: right; margin-top: 2rem; }
    </style>
</head>
<body>
    <div class="marketplace-container">
        <?php include 'header.php'; ?>

        <div class="marketplace-products" style="max-width: 1000px; margin: 0 auto;">
            <h2 class="section-title">Your Cart</h2>

            <?php if (!empty($cart_items)): ?>
                <table class="cart-table">
                    <thead>
                        <tr>
                            <th>Item</th>
                            <th>Price</th>
                            <th>Qty</th>
                            <th>Subtotal</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($cart_items as $item): ?>
                            <tr id="row-<?php echo $item['p_id']; ?>">
                                <td style="display: flex; gap: 15px; align-items: center;">
                                    <?php $img = !empty($item['image']) ? $item['image'] : '../assets/placeholder_product.png'; ?>
                                    <img src="<?php echo $img; ?>" class="cart-img">
                                    <div>
                                        <strong><?php echo $item['title']; ?></strong><br>
                                        <small><?php echo ucfirst($item['listing_type']); ?></small>
                                    </div>
                                </td>
                                <td>GHS <?php echo number_format($item['price'], 2); ?></td>
                                <td>
                                    <input type="number" class="qty-input" value="<?php echo $item['qty']; ?>" min="1" 
                                           onchange="updateQty(<?php echo $item['p_id']; ?>, this.value)">
                                </td>
                                <td>GHS <?php echo number_format($item['price'] * $item['qty'], 2); ?></td>
                                <td>
                                    <button class="btn btn-sm btn-outline" onclick="removeItem(<?php echo $item['p_id']; ?>)">Remove</button>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>

                <div class="cart-summary">
                    <h3>Total: <span style="color: var(--color-primary);">GHS <?php echo number_format($cart_total, 2); ?></span></h3>
                    <div style="margin-top: 1rem; display: flex; justify-content: flex-end; gap: 1rem;">
                        <a href="listings.php" class="btn btn-outline">Continue Shopping</a>
                        <a href="checkout.php" class="btn btn-primary">Proceed to Checkout</a>
                    </div>
                </div>
            <?php else: ?>
                <div class="alert alert-info" style="text-align: center; padding: 3rem;">
                    Your cart is empty. <br><br>
                    <a href="listings.php" class="btn btn-primary">Browse Marketplace</a>
                </div>
            <?php endif; ?>
        </div>

        <?php include 'footer.php'; ?>
    </div>
    <script src="../js/cart.js"></script>
</body>
</html>
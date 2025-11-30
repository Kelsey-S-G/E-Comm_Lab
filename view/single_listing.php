<?php
require_once("../settings/core.php");
require_once("../controllers/listing_controller.php");

if (!isset($_GET['id'])) {
    header("Location: listings.php");
    exit();
}

$id = $_GET['id'];

$listing = get_one_listing_ctr($id);

if (!$listing) {
    echo "Listing not found.";
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title><?php echo $listing['title']; ?> - ReConnect</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="../style.css" />
    <link rel="stylesheet" href="../css/marketplace.css" />
    <style>
        /* Simple layout for single product */
        .single-product-container { display: grid; grid-template-columns: 1fr 1fr; gap: 3rem; padding: 4rem; max-width: 1200px; margin: 0 auto; }
        .product-main-img { width: 100%; border-radius: 12px; border: 1px solid var(--color-border); }
        .product-details h1 { font-size: 2.5rem; margin-bottom: 0.5rem; }
        .product-meta { color: var(--color-on-surface-secondary); margin-bottom: 2rem; font-size: 0.9rem; }
        .product-price-lg { font-size: 2rem; font-weight: 700; color: var(--color-primary); margin-bottom: 1.5rem; }
        .product-desc { line-height: 1.8; margin-bottom: 2rem; }
        @media (max-width: 768px) { .single-product-container { grid-template-columns: 1fr; padding: 2rem; } }
    </style>
</head>
<body>
    <div class="marketplace-container">
        <?php include 'header.php'; ?>

        <div class="single-product-container">
            <div class="product-gallery">
                <?php $imgSrc = !empty($listing['image']) ? $listing['image'] : '../assets/placeholder_product.png'; ?>
                <img src="<?php echo $imgSrc; ?>" class="product-main-img" alt="<?php echo $listing['title']; ?>">
            </div>

            <div class="product-details">
                <span class="badge"><?php echo ucfirst($listing['listing_type']); ?></span>
                <h1><?php echo $listing['title']; ?></h1>
                
                <div class="product-meta">
                    <span>Venture: <strong><?php echo $listing['venture_name'] ?? 'N/A'; ?></strong></span> | 
                    <span>Alumni: <strong><?php echo $listing['owner_name'] ?? 'N/A'; ?></strong></span> | 
                    <span>Sector: <strong><?php echo $listing['cat_name'] ?? 'N/A'; ?></strong></span>
                </div>

                <div class="product-price-lg">GHS <?php echo number_format($listing['price'], 2); ?></div>

                <p class="product-desc">
                    <?php echo nl2br($listing['description']); ?>
                </p>

                <div class="purchase-actions">
                    <form>
                        <input type="number" id="qtyInput" value="1" min="1" style="padding: 10px; width: 60px; margin-right: 10px;">
                        <button type="button" class="btn btn-primary btn-lg" onclick="addToCart(<?php echo $listing['listing_id']; ?>)">
                            Add to Cart
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <?php include 'footer.php'; ?>
    </div>

    <script>
        function addToCart(id) {
            // 1. Get quantity from the input we just named
            const qtyInput = document.getElementById("qtyInput");
            const qty = qtyInput ? qtyInput.value : 1;

            if (qty < 1) {
                alert("Please enter a valid quantity.");
                return;
            }

            // 2. Prepare Data
            const formData = new FormData();
            formData.append("action", "add");
            formData.append("listing_id", id);
            formData.append("qty", qty);

            // 3. Send to Backend
            fetch("../actions/cart_actions.php", {
                method: "POST",
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.status === "success") {
                    alert(data.message); // "Added to cart"
                    // Optional: Ask to go to cart
                    if(confirm("Item added! Go to Cart?")) {
                        window.location.href = "cart.php";
                    }
                } else {
                    alert("Error: " + data.message);
                }
            })
            .catch(err => {
                console.error(err);
                alert("Network error. Please ensure you are logged in.");
            });
        }
    </script>
</body>
</html>
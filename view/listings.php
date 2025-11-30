<?php
require_once("../settings/core.php");
require_once("../controllers/listing_controller.php");
require_once("../controllers/category_controller.php");
require_once("../controllers/venture_controller.php");

// enforceVerification(); // Optional: Restrict to verified users only

// Handle Filter Logic
$listings = [];
if (isset($_GET['search'])) {
    $listings = search_listings_ctr($_GET['search']);
    $filter_title = "Search Results for: '" . htmlspecialchars($_GET['search']) . "'";
} elseif (isset($_GET['cat'])) {
    $listings = filter_listings_by_category_ctr($_GET['cat']);
    $filter_title = "Sector Filter";
} elseif (isset($_GET['ven'])) {
    $listings = filter_listings_by_venture_ctr($_GET['ven']);
    $filter_title = "Venture Filter";
} else {
    $listings = get_all_listings_ctr(); // Default: Show all
    $filter_title = "All Alumni Listings";
}

// Fetch options for filter dropdowns
$categories = get_all_categories_ctr();
$ventures = get_all_ventures_ctr(); 
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Marketplace - ReConnect</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="../style.css" />
    <link rel="stylesheet" href="../css/marketplace.css" />
</head>
<body>
    <div class="marketplace-container">
        <?php include 'header.php'; ?>

        <!-- Hero / Search Section -->
        <section class="marketplace-hero">
            <div class="marketplace-hero-content">
                <h1 class="hero-title">Alumni Marketplace</h1>
                <p class="hero-subtitle">Support verified alumni businesses.</p>
                
                <form action="listings.php" method="GET" class="marketplace-search-bar">
                    <input type="text" name="search" class="marketplace-search-input" placeholder="Search products, services, or mentors..." value="<?php echo isset($_GET['search']) ? htmlspecialchars($_GET['search']) : ''; ?>" />
                    <button type="submit" class="btn btn-primary">Search</button>
                </form>
            </div>
        </section>

        <!-- Filters Section -->
        <section class="marketplace-filters-section">
            <div class="marketplace-filters">
                <!-- Category Filter -->
                <div class="filter-group">
                    <label>Filter by Sector</label>
                    <select class="thq-select" onchange="location = this.value;">
                        <option value="listings.php">All Sectors</option>
                        <?php if ($categories): foreach($categories as $cat): ?>
                            <option value="listings.php?cat=<?php echo $cat['cat_id']; ?>" <?php if(isset($_GET['cat']) && $_GET['cat'] == $cat['cat_id']) echo 'selected'; ?>>
                                <?php echo $cat['cat_name']; ?>
                            </option>
                        <?php endforeach; endif; ?>
                    </select>
                </div>

                <!-- Venture Filter -->
                <div class="filter-group">
                    <label>Filter by Venture</label>
                    <select class="thq-select" onchange="location = this.value;">
                        <option value="listings.php">All Ventures</option>
                        <?php if ($ventures): foreach($ventures as $ven): ?>
                            <option value="listings.php?ven=<?php echo $ven['venture_id']; ?>" <?php if(isset($_GET['ven']) && $_GET['ven'] == $ven['venture_id']) echo 'selected'; ?>>
                                <?php echo $ven['venture_name']; ?>
                            </option>
                        <?php endforeach; endif; ?>
                    </select>
                </div>
                
                <a href="listings.php" class="btn btn-outline">Reset</a>
            </div>
        </section>

        <!-- Products Grid -->
        <section class="marketplace-products">
            <h2 class="section-title"><?php echo $filter_title; ?></h2>
            
            <?php if (empty($listings)): ?>
                <div class="alert alert-info" style="text-align:center; padding: 2rem; background-color: var(--color-surface-elevated); border-radius: 8px; border: 1px solid var(--color-border); color: var(--color-on-surface);">
                    No listings found matching your criteria. <a href="listings.php" style="color: var(--color-primary);">View all</a>
                </div>
            <?php else: ?>
                <div class="marketplace-grid">
                    <?php foreach ($listings as $item): ?>
                        <div class="product-card">
                            <div class="product-image">
                                <!-- Handle Image Path (Check if exists or use placeholder) -->
                                <?php $imgSrc = !empty($item['image']) ? $item['image'] : '../assets/placeholder_product.png'; ?>
                                <img src="<?php echo $imgSrc; ?>" alt="<?php echo $item['title']; ?>" class="product-img" />
                                <span class="product-badge"><?php echo ucfirst($item['listing_type']); ?></span>
                            </div>
                            <div class="product-info">
                                <div class="product-header">
                                    <h3 class="product-title"><?php echo $item['title']; ?></h3>
                                </div>
                                <div class="product-seller">
                                    <div class="seller-info">
                                        <p class="seller-name">By: <?php echo $item['venture_name']; ?></p>
                                        <p class="seller-badge"><?php echo $item['cat_name']; ?></p>
                                    </div>
                                </div>
                                <div class="product-footer">
                                    <span class="product-price">GHS <?php echo number_format($item['price'], 2); ?></span>
                                    <a href="single_listing.php?id=<?php echo $item['listing_id']; ?>" class="btn btn-sm btn-primary">View Details</a>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </section>

        <?php include 'footer.php'; ?>
    </div>
</body>
</html>

<?php
require_once("../settings/core.php");
require_once("../controllers/listing_controller.php");
require_once("../controllers/category_controller.php");
require_once("../controllers/venture_controller.php");

// 1. Get User's Institution ID
$user_inst_id = $_SESSION['institution_id'] ?? 0;

// 2. Handle Filter Logic (Using Inst ID for all queries)
$listings = [];
if (isset($_GET['search'])) {
    $listings = search_listings_ctr($_GET['search'], $user_inst_id);
    $filter_title = "Search Results for: '" . htmlspecialchars($_GET['search']) . "'";
} elseif (isset($_GET['cat'])) {
    $listings = filter_listings_by_category_ctr($_GET['cat'], $user_inst_id);
    $filter_title = "Sector Filter";
} elseif (isset($_GET['ven'])) {
    $listings = filter_listings_by_venture_ctr($_GET['ven'], $user_inst_id);
    $filter_title = "Venture Filter";
} else {
    // Default: Show all from MY institution only
    $listings = get_listings_by_institution_ctr($user_inst_id); 
    $filter_title = "All Alumni Listings";
}

// 3. Fetch options for filters
$categories = get_all_categories_ctr();
// Update: Only fetch ventures from THIS institution for the dropdown
$ventures = get_ventures_by_institution_ctr($user_inst_id); 
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

        <section class="marketplace-hero">
            <div class="marketplace-hero-content">
                <h1 class="hero-title">Alumni Marketplace</h1>
                <p class="hero-subtitle">Support verified alumni businesses from your institution.</p>
                
                <form action="listings.php" method="GET" class="marketplace-search-bar">
                    <input type="text" name="search" class="marketplace-search-input" placeholder="Search products, services, or mentors..." value="<?php echo isset($_GET['search']) ? htmlspecialchars($_GET['search']) : ''; ?>" />
                    <button type="submit" class="btn btn-primary">Search</button>
                </form>
            </div>
        </section>

        <section class="marketplace-filters-section">
            <div class="marketplace-filters">
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

        <section class="marketplace-products">
            <h2 class="section-title"><?php echo $filter_title; ?></h2>
            
            <?php if (empty($listings)): ?>
                <div class="alert alert-info" style="text-align:center; padding: 2rem; background-color: rgba(96, 165, 250, 0.1); border-radius: 8px; border: 1px solid rgba(96, 165, 250, 0.3); color: white;">
                    No listings found matching your criteria. <a href="listings.php" style="color: var(--color-primary);">View all</a>
                </div>
            <?php else: ?>
                <div class="marketplace-grid">
                    <?php foreach ($listings as $item): ?>
                        <div class="product-card">
                            <div class="product-image">
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
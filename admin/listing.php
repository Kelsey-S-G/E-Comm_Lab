<?php
require_once("../settings/core.php");
require_once("../controllers/venture_controller.php");
require_once("../controllers/listing_controller.php");

check_login();
$user_id = get_user_id();
$user_role = $_SESSION['user_role'] ?? 2; // 1 = Admin
$user_inst_id = $_SESSION['institution_id'] ?? 0;

// Fetch ventures for the dropdown (user still needs their own ventures to add new listings)
$my_ventures = get_my_ventures_ctr($user_id);

// LOGIC UPDATE: Admin sees all institution listings, User sees only theirs
if ($user_role == 1) {
    $display_listings = get_listings_by_institution_ctr($user_inst_id);
    $section_title = "Manage Institution Listings";
} else {
    $display_listings = get_my_listings_ctr($user_id);
    $section_title = "Your Active Listings";
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Manage Listings - ReConnect</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="../style.css" />
    <link rel="stylesheet" href="../css/profile.css" />
    <style>
        .listing-item { display: flex; justify-content: space-between; align-items: center; padding: 1rem; border: 1px solid var(--color-border); border-radius: 8px; margin-bottom: 10px; background: var(--color-surface-elevated); }
        .listing-info h4 { margin: 0 0 5px 0; color: var(--color-on-surface); }
        .listing-info p { margin: 0; font-size: 0.9rem; color: var(--color-on-surface-secondary); }
    </style>
</head>
<body>
    <div class="profile-container">
        <?php include '../view/header.php'; ?>
        
        <div class="profile-wrapper">
        <aside class="profile-sidebar">
            <div class="sidebar-menu">
                <a href="venture.php" class="sidebar-link">My Ventures</a>
                <a href="listing.php" class="sidebar-link active">Manage Listings</a>
                <a href="media_library.php" class="sidebar-link">Media Library</a>

                <?php if (isset($_SESSION['user_role']) && $_SESSION['user_role'] == 1): ?>
                    <div style="border-top: 1px solid var(--color-border); margin: 10px 0;"></div>
                    <a href="category.php" class="sidebar-link">🏢 Venture Sectors</a>
                <?php endif; ?>
            </div>
        </aside>

            <main class="profile-main">
                <section class="profile-section">
                    <h2 class="section-title">Add New Listing</h2>
                    <?php if (!$my_ventures): ?>
                        <div class="alert alert-danger" style="color: red; padding: 10px; border: 1px solid red; border-radius: 6px;">
                            You need to <a href="venture.php" style="font-weight:bold;">register a venture</a> before you can post listings.
                        </div>
                    <?php else: ?>
                        <form id="listingForm" class="auth-form" enctype="multipart/form-data">
                            <input type="hidden" name="action" value="add" />
                            <div class="form-group"><label>Select Venture</label>
                                <select name="venture_id" class="form-input">
                                    <?php foreach ($my_ventures as $v): ?>
                                        <option value="<?php echo $v['venture_id']; ?>"><?php echo $v['venture_name']; ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div class="form-row" style="display: grid; grid-template-columns: 2fr 1fr; gap: 1rem;">
                                <div class="form-group"><label>Listing Title</label><input type="text" name="title" class="form-input" required /></div>
                                <div class="form-group"><label>Price (GHS)</label><input type="number" name="price" class="form-input" step="0.01" required /></div>
                            </div>
                            <div class="form-group"><label>Type</label>
                                <select name="type" class="form-input">
                                    <option value="product">Physical Product</option>
                                    <option value="service">Service</option>
                                    <option value="mentorship">Mentorship Session</option>
                                </select>
                            </div>
                            <div class="form-group"><label>Description</label><textarea name="desc" class="form-input" rows="4" required></textarea></div>
                            <div class="form-group"><label>Image</label><input type="file" name="image" class="form-input" accept="image/*" required /></div>
                            <div class="form-group"><label>Keywords</label><input type="text" name="keywords" class="form-input" placeholder="tech, tutoring, python" /></div>
                            <button type="submit" class="btn btn-primary">Publish Listing</button>
                        </form>
                    <?php endif; ?>
                </section>

                <section class="profile-section">
                    <h2 class="section-title"><?php echo $section_title; ?></h2>
                    <div class="listings-list">
                        <?php if ($display_listings): ?>
                            <?php foreach ($display_listings as $item): ?>
                                <div class="listing-item" id="listing-<?php echo $item['listing_id']; ?>">
                                    <div class="listing-info">
                                        <h4><?php echo $item['title']; ?></h4>
                                        <p>
                                            <?php echo $item['venture_name']; ?> 
                                            <?php if($user_role == 1 && isset($item['owner_name'])) echo " • Owner: " . $item['owner_name']; ?>
                                            • GHS <?php echo $item['price']; ?>
                                        </p>
                                    </div>
                                    <button class="btn btn-sm btn-outline" style="border-color: red; color: red;" onclick="deleteListing(<?php echo $item['listing_id']; ?>)">Delete</button>
                                </div>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <p style="color: var(--color-on-surface-secondary);">No listings found.</p>
                        <?php endif; ?>
                    </div>
                </section>
            </main>
        </div>
    </div>
    <script src="../js/listing.js"></script>
    <script>
    function deleteListing(id) {
        if (!confirm("Are you sure you want to delete this listing?")) return;
        const formData = new FormData();
        formData.append("action", "delete");
        formData.append("listing_id", id);
        fetch("../actions/listing_actions.php", { method: "POST", body: formData })
        .then(res => res.json())
        .then(data => {
            if (data.status === "success") {
                document.getElementById("listing-" + id).remove();
                alert(data.message);
            } else {
                alert(data.message);
            }
        })
        .catch(err => console.error(err));
    }
    </script>
</body>
</html>
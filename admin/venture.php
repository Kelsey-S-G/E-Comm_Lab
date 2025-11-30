<?php
require_once("../settings/core.php");
require_once("../controllers/venture_controller.php");
require_once("../controllers/category_controller.php");

check_login();
$user_id = get_user_id();
$user_role = $_SESSION['user_role'] ?? 2;
$user_inst_id = $_SESSION['institution_id'] ?? 0;
$sectors = get_all_categories_ctr();

if ($user_role == 1) {
    $display_ventures = get_ventures_by_institution_ctr($user_inst_id);
    $section_title = "Manage Institution Ventures";
} else {
    $display_ventures = get_my_ventures_ctr($user_id);
    $section_title = "Your Active Ventures";
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>My Ventures - ReConnect</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="../style.css" />
    <link rel="stylesheet" href="../css/profile.css" />
    <style>
        /* Updated: Ensure Venture Name is white */
        .review-header strong {
            color: white;
            font-size: 1.1rem;
        }
    </style>
</head>
<body>
    <div class="profile-container">
        <?php include '../view/header.php'; ?>
        
        <div class="profile-wrapper">
            <aside class="profile-sidebar">
                <div class="sidebar-menu">
                    <a href="venture.php" class="sidebar-link active">My Ventures</a>
                    <a href="listing.php" class="sidebar-link">Manage Listings</a>
                    <a href="media_library.php" class="sidebar-link">Media Library</a>
                    <?php if ($user_role == 1): ?>
                        <div style="border-top: 1px solid var(--color-border); margin: 10px 0;"></div>
                        <a href="category.php" class="sidebar-link">🏢 Venture Sectors</a>
                    <?php endif; ?>
                </div>
            </aside>

            <main class="profile-main">
                <section class="profile-section">
                    <h2 class="section-title">Register a Venture</h2>
                    <p class="section-content">List your business or consultancy on the Alumni Network.</p>
                    
                    <form id="ventureForm" class="auth-form">
                        <input type="hidden" name="action" value="add" />
                        <div class="form-group"><label>Venture Name</label><input type="text" name="v_name" class="form-input" required /></div>
                        <div class="form-group"><label>Sector</label>
                            <select name="cat_id" class="form-input" required>
                                <?php foreach ($sectors as $sec): ?>
                                    <option value="<?php echo $sec['cat_id']; ?>"><?php echo $sec['cat_name']; ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="form-group"><label>Description</label><textarea name="v_desc" class="form-input" rows="3"></textarea></div>
                        <button type="submit" class="btn btn-primary">Create Venture</button>
                    </form>
                </section>

                <section class="profile-section">
                    <h3 class="section-title"><?php echo $section_title; ?></h3>
                    <div class="reviews-list">
                        <?php if ($display_ventures): ?>
                            <?php foreach ($display_ventures as $v): ?>
                                <div class="review-item" id="venture-<?php echo $v['venture_id']; ?>">
                                    <div class="review-header">
                                        <strong><?php echo $v['venture_name']; ?></strong>
                                        <span class="badge"><?php echo $v['cat_name']; ?></span>
                                    </div>
                                    <p style="color: var(--color-on-surface-secondary);"><?php echo $v['description']; ?></p>
                                    <?php if($user_role == 1 && isset($v['owner_name'])): ?>
                                        <p style="font-size:0.8rem; color:var(--color-primary); margin-top:5px;">Owner: <?php echo $v['owner_name']; ?></p>
                                    <?php endif; ?>
                                    <div style="margin-top: 10px; text-align: right;">
                                        <button class="btn btn-sm btn-outline" style="border-color: red; color: red;" onclick="deleteVenture(<?php echo $v['venture_id']; ?>)">Delete Venture</button>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <p style="color: var(--color-on-surface-secondary);">No ventures found.</p>
                        <?php endif; ?>
                    </div>
                </section>
            </main>
        </div>
    </div>
    <script src="../js/venture.js"></script>
    <script>
    function deleteVenture(id) {
        if (!confirm("Are you sure? This will delete the venture AND all its listings.")) return;
        const formData = new FormData();
        formData.append("action", "delete");
        formData.append("v_id", id);
        fetch("../actions/venture_actions.php", { method: "POST", body: formData })
        .then(res => res.json())
        .then(data => {
            if (data.status === "success") {
                document.getElementById("venture-" + id).remove();
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
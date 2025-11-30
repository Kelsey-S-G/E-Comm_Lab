<?php
require_once("../settings/core.php");
require_once("../controllers/venture_controller.php");
require_once("../controllers/category_controller.php");

check_login();
$user_id = get_user_id();
$my_ventures = get_my_ventures_ctr($user_id);
$sectors = get_all_categories_ctr();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>My Ventures - ReConnect</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="../style.css" />
    <link rel="stylesheet" href="../css/profile.css" />
</head>
<body>
    <div class="profile-container">
        <?php include '../view/header.php'; // Reuse header logic ?>
        
        <div class="profile-wrapper">
            <aside class="profile-sidebar">
                <!-- Sidebar Links -->
                <div class="sidebar-menu">
                    <a href="venture.php" class="sidebar-link active">My Ventures</a>
                    <a href="listing.php" class="sidebar-link">Manage Listings</a>
                </div>
            </aside>

            <main class="profile-main">
                <section class="profile-section">
                    <h2 class="section-title">Register a Venture</h2>
                    <p class="section-content">List your business or consultancy on the Alumni Network.</p>
                    
                    <form id="ventureForm" class="auth-form">
                        <input type="hidden" name="action" value="add" />
                        <div class="form-group">
                            <label>Venture Name</label>
                            <input type="text" name="v_name" class="form-input" required />
                        </div>
                        <div class="form-group">
                            <label>Sector</label>
                            <select name="cat_id" class="form-input" required>
                                <?php foreach ($sectors as $sec): ?>
                                    <option value="<?php echo $sec['cat_id']; ?>"><?php echo $sec['cat_name']; ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Description</label>
                            <textarea name="v_desc" class="form-input" rows="3"></textarea>
                        </div>
                        <button type="submit" class="btn btn-primary">Create Venture</button>
                    </form>
                </section>

                <section class="profile-section">
                    <h3 class="section-title">Your Active Ventures</h3>
                    <div class="reviews-list">
                        <?php if ($my_ventures): ?>
                            <?php foreach ($my_ventures as $v): ?>
                                <div class="review-item">
                                    <div class="review-header">
                                        <strong><?php echo $v['venture_name']; ?></strong>
                                        <span class="badge"><?php echo $v['cat_name']; ?></span>
                                    </div>
                                    <p style="color: var(--color-on-surface-secondary);"><?php echo $v['description']; ?></p>
                                    <!-- Add Edit/Delete Buttons triggering JS here -->
                                </div>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <p style="color: var(--color-on-surface-secondary);">No ventures registered yet.</p>
                        <?php endif; ?>
                    </div>
                </section>
            </main>
        </div>
    </div>
    <script src="../js/venture.js"></script>
</body>
</html>

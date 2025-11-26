<?php
require_once("../settings/core.php");
require_once("../controllers/category_controller.php");

// 1. Security: Identity Lock for Admins Only
check_admin_privilege();

// 2. Fetch Existing Sectors
$categories = get_all_categories_ctr();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Admin: Manage Venture Sectors</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="../style.css" />
    <!-- Using Profile CSS for sidebar layout reuse -->
    <link rel="stylesheet" href="../css/profile.css" /> 
    <style>
        /* Specific overrides for Admin Table */
        .admin-table { width: 100%; border-collapse: collapse; margin-top: 20px; background: white; border-radius: 8px; overflow: hidden; }
        .admin-table th, .admin-table td { padding: 15px; text-align: left; border-bottom: 1px solid #eee; }
        .admin-table th { background-color: var(--color-surface-elevated); font-weight: bold; }
        .action-btn { padding: 5px 10px; border-radius: 4px; text-decoration: none; font-size: 0.8rem; cursor: pointer; border: none; }
        .btn-edit { background-color: #FFC107; color: #000; margin-right: 5px; }
        .btn-delete { background-color: #DC3545; color: #fff; }
        .form-inline { display: flex; gap: 10px; margin-bottom: 20px; background: #fff; padding: 20px; border-radius: 8px; }
        .form-inline input { flex: 1; padding: 10px; border: 1px solid #ccc; border-radius: 4px; }
    </style>
</head>
<body>
    <div class="profile-container">
        <!-- Reuse Navigation -->
        <nav class="profile-nav">
            <div class="profile-nav-content">
                <a href="../index.php" class="profile-logo">
                    <span>ReConnect Admin</span>
                </a>
                <div class="profile-nav-actions">
                    <a href="../actions/logout.php"><button class="btn btn-outline btn-sm">Logout</button></a>
                </div>
            </div>
        </nav>

        <div class="profile-wrapper">
            <!-- Admin Sidebar -->
            <aside class="profile-sidebar">
                <div class="sidebar-menu">
                    <a href="#" class="sidebar-link active">
                        <span class="sidebar-icon">🏢</span>
                        <span>Venture Sectors</span>
                    </a>
                    <!-- Future Admin Links -->
                    <a href="#" class="sidebar-link">
                        <span class="sidebar-icon">👥</span>
                        <span>Verify Alumni</span>
                    </a>
                </div>
            </aside>

            <!-- Main Content -->
            <main class="profile-main">
                <section class="profile-section">
                    <h2 class="section-title">Manage Venture Sectors</h2>
                    <p class="section-content">Define the industries available for alumni ventures in the marketplace.</p>

                    <!-- Add Category Form -->
                    <div class="form-inline">
                        <input type="text" id="newCategoryName" placeholder="Enter new sector name (e.g. AgriTech, Legal Services)" />
                        <button id="addCategoryBtn" class="btn btn-primary">Add Sector</button>
                    </div>

                    <!-- List of Categories -->
                    <table class="admin-table">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Sector Name</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody id="categoryTableBody">
                            <?php if ($categories): ?>
                                <?php foreach ($categories as $cat): ?>
                                    <tr id="row-<?php echo $cat['cat_id']; ?>">
                                        <td><?php echo $cat['cat_id']; ?></td>
                                        <td>
                                            <span class="display-name"><?php echo $cat['cat_name']; ?></span>
                                            <input type="text" class="edit-input" value="<?php echo $cat['cat_name']; ?>" style="display:none;" />
                                        </td>
                                        <td>
                                            <button class="action-btn btn-edit" onclick="enableEdit(<?php echo $cat['cat_id']; ?>)">Edit</button>
                                            <button class="action-btn btn-primary btn-save" style="display:none;" onclick="saveEdit(<?php echo $cat['cat_id']; ?>)">Save</button>
                                            <button class="action-btn btn-delete" onclick="deleteCategory(<?php echo $cat['cat_id']; ?>)">Delete</button>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr><td colspan="3">No sectors defined yet.</td></tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </section>
            </main>
        </div>
    </div>

    <!-- JavaScript for AJAX Operations -->
    <script src="../js/category.js"></script>
</body>
</html>
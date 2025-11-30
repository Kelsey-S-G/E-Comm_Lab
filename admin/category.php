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
    <link rel="stylesheet" href="../css/profile.css" /> 
    <style>
        /* Dark Theme Admin Table */
        .admin-table { 
            width: 100%; 
            border-collapse: collapse; 
            margin-top: 20px; 
            background: var(--color-surface-elevated); /* Dark Background */
            border-radius: 8px; 
            overflow: hidden; 
            border: 1px solid var(--color-border); /* Consistent Border */
        }
        
        .admin-table th, .admin-table td { 
            padding: 15px; 
            text-align: left; 
            border-bottom: 1px solid var(--color-border); 
            color: var(--color-on-surface); /* Light text */
        }

        .admin-table th { 
            background-color: var(--color-surface); /* Slightly darker header */
            font-weight: bold; 
            color: white; /* Explicitly White Headers */
            text-transform: uppercase;
            font-size: 0.85rem;
            letter-spacing: 0.05em;
        }

        /* Action Buttons */
        .action-btn { padding: 6px 12px; border-radius: 4px; text-decoration: none; font-size: 0.8rem; cursor: pointer; border: none; font-weight: 600; transition: opacity 0.2s; }
        .action-btn:hover { opacity: 0.9; }
        .btn-edit { background-color: #f59e0b; color: #000; margin-right: 5px; } /* Amber */
        .btn-delete { background-color: #ef4444; color: #fff; } /* Red */
        .btn-save { margin-right: 5px; }

        /* Dark Theme Form */
        .form-inline { 
            display: flex; 
            gap: 10px; 
            margin-bottom: 20px; 
            background: var(--color-surface-elevated); 
            padding: 20px; 
            border-radius: 8px; 
            border: 1px solid var(--color-border);
        }
        
        .form-inline input { 
            flex: 1; 
            padding: 12px; 
            border: 1px solid var(--color-border); 
            border-radius: 6px; 
            background-color: var(--color-surface); /* Dark Input */
            color: white; 
            font-size: 1rem;
        }
        
        .form-inline input:focus {
            outline: none;
            border-color: var(--color-primary);
        }

        /* Edit Input Field in Table */
        .edit-input {
            background-color: var(--color-surface);
            border: 1px solid var(--color-border);
            color: white;
            padding: 5px 10px;
            border-radius: 4px;
            width: 100%;
        }
    </style>
</head>
<body>
    <div class="profile-container">
        <?php include '../view/header.php'; ?>

        <div class="profile-wrapper">
            <aside class="profile-sidebar">
                <div class="sidebar-menu">
                    <a href="venture.php" class="sidebar-link">My Ventures</a>
                    <a href="listing.php" class="sidebar-link">Manage Listings</a>
                    <a href="media_library.php" class="sidebar-link">Media Library</a>

                    <div style="border-top: 1px solid var(--color-border); margin: 10px 0;"></div>
                    <a href="category.php" class="sidebar-link active">🏢 Venture Sectors</a>
                </div>
            </aside>

            <main class="profile-main">
                <section class="profile-section">
                    <h2 class="section-title">Manage Venture Sectors</h2>
                    <p class="section-content">Define the industries available for alumni ventures in the marketplace.</p>

                    <div class="form-inline">
                        <input type="text" id="newCategoryName" placeholder="Enter new sector name (e.g. AgriTech, Legal Services)" />
                        <button id="addCategoryBtn" class="btn btn-primary">Add Sector</button>
                    </div>

                    <table class="admin-table">
                        <thead>
                            <tr>
                                <th style="width: 10%;">ID</th>
                                <th>Sector Name</th>
                                <th style="width: 20%;">Actions</th>
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
                                <tr><td colspan="3" style="text-align:center;">No sectors defined yet.</td></tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </section>
            </main>
        </div>
    </div>

    <script src="../js/category.js"></script>
</body>
</html>
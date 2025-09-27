<?php
session_start();
require_once(__DIR__ . "/../settings/core.php");

// Check if the user is logged in
if (!isLoggedIn()) {
    header("Location: ../login/login.php");
    exit();
}

// Check if the user is an admin
if (!isAdmin()) {
    header("Location: ../login/login.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Category Management - AfriCraft Global</title>
    <!-- Updated to use modern dark theme CSS -->
    <link href="../css/theme.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <script src="../js/category.js" defer></script>
</head>
<body>
    <!-- Navigation Bar -->
    <nav class="navbar">
        <div class="container">
            <a class="navbar-brand" href="../index.php">
                <i class="fas fa-shopping-bag"></i>AfriCraft Global
            </a>
            <div class="d-flex align-items-center gap-3">
                <span class="navbar-text">
                    <i class="fas fa-user-shield"></i>Admin: <?php echo htmlspecialchars($_SESSION['user_name']); ?>
                </span>
                <a class="nav-link" href="../actions/logout_action.php">
                    <i class="fas fa-sign-out-alt"></i>Logout
                </a>
            </div>
        </div>
    </nav>
    
    <!-- Main Content -->
    <div class="container mt-5">
        <!-- Admin Header -->
        <div class="hero-section">
            <h1><i class="fas fa-tags"></i>Category Management</h1>
            <p class="lead">Manage product categories for your AfriCraft Global marketplace</p>
        </div>
        
        <!-- Add Category Section -->
        <div class="card mb-4">
            <div class="card-header">
                <h3><i class="fas fa-plus-circle"></i>Add New Category</h3>
            </div>
            <div class="card-body">
                <form id="addCategoryForm">
                    <div class="row">
                        <div class="col-md-8">
                            <div class="mb-3">
                                <label for="cat_name" class="form-label">
                                    <i class="fas fa-tag"></i>Category Name
                                </label>
                                <input type="text" id="cat_name" name="cat_name" class="form-control" 
                                       placeholder="Enter category name (e.g., Traditional Crafts, Jewelry, Textiles)" 
                                       required maxlength="100">
                            </div>
                        </div>
                        <div class="col-md-4 d-flex align-items-end">
                            <div class="mb-3 w-100">
                                <button type="submit" class="btn btn-primary w-100">
                                    <i class="fas fa-plus"></i>Add Category
                                </button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        
        <!-- Categories Display Section -->
        <div class="card">
            <div class="card-header">
                <h3><i class="fas fa-list"></i>Your Categories</h3>
            </div>
            <div class="card-body">
                <div class="row" id="categoriesContainer">
                    <!-- Categories will be loaded here via JavaScript -->
                    <div class="col-12 text-center">
                        <div class="spinner-border text-primary" role="status">
                            <span style="position: absolute; width: 1px; height: 1px; padding: 0; margin: -1px; overflow: hidden; clip: rect(0, 0, 0, 0); white-space: nowrap; border: 0;">Loading categories...</span>
                        </div>
                        <p class="mt-3" style="color: var(--text-secondary);">Loading categories...</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Update Category Modal -->
    <div id="updateModal" class="modal">
        <div class="modal-content">
            <span class="close" onclick="closeUpdateModal()">&times;</span>
            <h4 class="mb-3"><i class="fas fa-edit"></i>Update Category</h4>
            <form id="updateCategoryForm">
                <input type="hidden" id="update_cat_id" name="cat_id">
                <div class="mb-3">
                    <label for="update_cat_name" class="form-label">
                        <i class="fas fa-tag"></i>Category Name
                    </label>
                    <input type="text" id="update_cat_name" name="cat_name" class="form-control" 
                           placeholder="Enter new category name" required maxlength="100">
                </div>
                <div class="d-flex justify-content-end gap-2">
                    <button type="button" class="btn btn-secondary" onclick="closeUpdateModal()">
                        <i class="fas fa-times"></i>Cancel
                    </button>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save"></i>Update Category
                    </button>
                </div>
            </form>
        </div>
    </div>
</body>
</html>

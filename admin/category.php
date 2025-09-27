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
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <script src="../js/category.js" defer></script>
    <style>
        body {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        
        .navbar {
            background: rgba(0, 0, 0, 0.9) !important;
            backdrop-filter: blur(10px);
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
        }
        
        .navbar-brand {
            font-weight: 700;
            font-size: 1.8rem;
            color: #fff !important;
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.3);
        }
        
        .nav-link {
            color: #fff !important;
            font-weight: 500;
            transition: all 0.3s ease;
            padding: 0.5rem 1rem !important;
            border-radius: 25px;
            margin: 0 0.2rem;
        }
        
        .nav-link:hover {
            background: rgba(255, 255, 255, 0.1);
            transform: translateY(-2px);
        }
        
        .navbar-text {
            color: #f8f9fa !important;
            font-weight: 500;
        }
        
        .main-container {
            margin-top: 2rem;
            margin-bottom: 2rem;
        }
        
        .admin-header {
            background: rgba(255, 255, 255, 0.95);
            border-radius: 20px;
            padding: 2rem;
            margin-bottom: 2rem;
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.1);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.2);
        }
        
        .admin-header h1 {
            color: #2c3e50;
            font-weight: 700;
            margin-bottom: 0.5rem;
            text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.1);
        }
        
        .admin-header .lead {
            color: #5a6c7d;
            margin-bottom: 0;
        }
        
        .category-section {
            background: rgba(255, 255, 255, 0.95);
            border-radius: 20px;
            padding: 2rem;
            margin-bottom: 2rem;
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.1);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.2);
        }
        
        .section-title {
            color: #2c3e50;
            font-weight: 600;
            margin-bottom: 1.5rem;
            padding-bottom: 0.5rem;
            border-bottom: 3px solid #667eea;
        }
        
        .form-label {
            color: #2c3e50;
            font-weight: 600;
            margin-bottom: 0.8rem;
        }
        
        .form-control {
            border: 2px solid #e9ecef;
            border-radius: 12px;
            padding: 0.8rem 1rem;
            font-size: 1rem;
            transition: all 0.3s ease;
            background: rgba(255, 255, 255, 0.9);
        }
        
        .form-control:focus {
            border-color: #667eea;
            box-shadow: 0 0 0 0.2rem rgba(102, 126, 234, 0.25);
            background: white;
            transform: translateY(-2px);
        }
        
        .btn-primary {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border: none;
            border-radius: 12px;
            padding: 0.8rem 2rem;
            font-weight: 600;
            transition: all 0.3s ease;
        }
        
        .btn-primary:hover {
            transform: translateY(-3px);
            box-shadow: 0 10px 25px rgba(102, 126, 234, 0.4);
            background: linear-gradient(135deg, #764ba2 0%, #667eea 100%);
        }
        
        .category-card {
            border: none;
            border-radius: 15px;
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.1);
            transition: all 0.3s ease;
            background: rgba(255, 255, 255, 0.95);
        }
        
        .category-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.15);
        }
        
        .category-card .card-title {
            color: #2c3e50;
            font-weight: 600;
        }
        
        .btn-outline-primary {
            color: #667eea;
            border-color: #667eea;
            transition: all 0.3s ease;
        }
        
        .btn-outline-primary:hover {
            background: #667eea;
            border-color: #667eea;
            transform: translateY(-2px);
        }
        
        .btn-outline-danger {
            color: #e74c3c;
            border-color: #e74c3c;
            transition: all 0.3s ease;
        }
        
        .btn-outline-danger:hover {
            background: #e74c3c;
            border-color: #e74c3c;
            transform: translateY(-2px);
        }
        
        /* Modal Styles */
        .modal {
            display: none;
            position: fixed;
            z-index: 1000;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            overflow: auto;
            background-color: rgba(0, 0, 0, 0.5);
            backdrop-filter: blur(5px);
        }
        
        .modal-content {
            background: rgba(255, 255, 255, 0.95);
            margin: 10% auto;
            padding: 2rem;
            border-radius: 20px;
            width: 90%;
            max-width: 500px;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.2);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.2);
        }
        
        .close {
            color: #aaa;
            float: right;
            font-size: 28px;
            font-weight: bold;
            cursor: pointer;
            transition: color 0.3s ease;
        }
        
        .close:hover,
        .close:focus {
            color: #667eea;
        }
        
        .alert-info {
            background: linear-gradient(135deg, rgba(102, 126, 234, 0.1) 0%, rgba(118, 75, 162, 0.1) 100%);
            border: 1px solid rgba(102, 126, 234, 0.2);
            color: #2c3e50;
            border-radius: 15px;
        }

        /* Enhanced Modal Styles for Dynamic Modals */
        .modal-header {
            border-bottom: 2px solid #e9ecef;
            padding-bottom: 1rem;
            margin-bottom: 1rem;
        }

        .modal-header h5 {
            margin: 0;
            color: #2c3e50;
            font-weight: 600;
        }

        .modal-body {
            padding: 1rem 0;
        }

        .modal-footer {
            border-top: 2px solid #e9ecef;
            padding-top: 1rem;
            margin-top: 1rem;
            display: flex;
            justify-content: flex-end;
            gap: 0.5rem;
        }

        .text-success {
            color: #28a745 !important;
        }

        .text-danger {
            color: #dc3545 !important;
        }

        .text-warning {
            color: #ffc107 !important;
        }
    </style>
</head>
<body>
    <!-- Navigation Bar -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container">
            <a class="navbar-brand" href="../index.php">
                <i class="fas fa-shopping-bag me-2"></i>AfriCraft Global
            </a>
            <div class="navbar-nav ms-auto">
                <span class="navbar-text me-3">
                    <i class="fas fa-user-shield me-1"></i>Admin: <?php echo htmlspecialchars($_SESSION['user_name']); ?>
                </span>
                <a class="nav-link" href="../actions/logout_action.php">
                    <i class="fas fa-sign-out-alt me-1"></i>Logout
                </a>
            </div>
        </div>
    </nav>
    
    <!-- Main Content -->
    <div class="container main-container">
        <!-- Admin Header -->
        <div class="admin-header text-center">
            <h1><i class="fas fa-tags me-2"></i>Category Management</h1>
            <p class="lead">Manage product categories for your AfriCraft Global marketplace</p>
        </div>
        
        <!-- Add Category Section -->
        <div class="category-section">
            <h3 class="section-title"><i class="fas fa-plus-circle me-2"></i>Add New Category</h3>
            <form id="addCategoryForm">
                <div class="row">
                    <div class="col-md-8">
                        <div class="mb-3">
                            <label for="cat_name" class="form-label">Category Name</label>
                            <input type="text" id="cat_name" name="cat_name" class="form-control" 
                                   placeholder="Enter category name (e.g., Traditional Crafts, Jewelry, Textiles)" 
                                   required maxlength="100">
                        </div>
                    </div>
                    <div class="col-md-4 d-flex align-items-end">
                        <div class="mb-3 w-100">
                            <button type="submit" class="btn btn-primary w-100">
                                <i class="fas fa-plus me-2"></i>Add Category
                            </button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
        
        <!-- Categories Display Section -->
        <div class="category-section">
            <h3 class="section-title"><i class="fas fa-list me-2"></i>Your Categories</h3>
            <div class="row" id="categoriesContainer">
                <!-- Categories will be loaded here via JavaScript -->
                <div class="col-12 text-center">
                    <div class="spinner-border text-primary" role="status">
                        <span class="visually-hidden">Loading categories...</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Update Category Modal -->
    <div id="updateModal" class="modal">
        <div class="modal-content">
            <span class="close" onclick="closeUpdateModal()">&times;</span>
            <h4 class="mb-3"><i class="fas fa-edit me-2"></i>Update Category</h4>
            <form id="updateCategoryForm">
                <input type="hidden" id="update_cat_id" name="cat_id">
                <div class="mb-3">
                    <label for="update_cat_name" class="form-label">Category Name</label>
                    <input type="text" id="update_cat_name" name="cat_name" class="form-control" 
                           placeholder="Enter new category name" required maxlength="100">
                </div>
                <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                    <button type="button" class="btn btn-secondary" onclick="closeUpdateModal()">
                        <i class="fas fa-times me-2"></i>Cancel
                    </button>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save me-2"></i>Update Category
                    </button>
                </div>
            </form>
        </div>
    </div>
</body>
</html>
<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AfriCraft Global - Authentic African Craftsmanship</title>
    <!-- Updated to use modern dark theme CSS -->
    <link href="css/theme.css" rel="stylesheet">
    <!-- Font Awesome Icons -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
</head>
<body>
    <!-- Navigation Bar -->
    <nav class="navbar">
        <div class="container">
            <a class="navbar-brand" href="#">
                <i class="fas fa-shopping-bag"></i>AfriCraft Global
            </a>
            <div class="d-flex align-items-center gap-3">
                <?php if (isset($_SESSION['user_id'])): ?>
                    <!-- User is logged in -->
                    <span class="navbar-text">
                        <i class="fas fa-user"></i>Welcome, <?php echo htmlspecialchars($_SESSION['user_name']); ?>!
                    </span>
                    
                    <?php if (isset($_SESSION['user_role']) && $_SESSION['user_role'] == 1): ?>
                        <!-- User is an admin -->
                        <a class="nav-link" href="admin/category.php">
                            <i class="fas fa-tags"></i>Category Management
                        </a>
                    <?php endif; ?>
                    
                    <a class="nav-link" href="actions/logout_action.php">
                        <i class="fas fa-sign-out-alt"></i>Logout
                    </a>
                <?php else: ?>
                    <!-- User is not logged in -->
                    <a class="nav-link" href="login/register.php">
                        <i class="fas fa-user-plus"></i>Register
                    </a>
                    <a class="nav-link" href="login/login.php">
                        <i class="fas fa-sign-in-alt"></i>Login
                    </a>
                <?php endif; ?>
            </div>
        </div>
    </nav>
    
    <!-- Main Content -->
    <div class="container mt-5">
        <!-- Hero Section -->
        <div class="hero-section">
            <?php if (isset($_SESSION['user_id'])): ?>
                <h1>
                    <i class="fas fa-home"></i>
                    Welcome back, <?php echo htmlspecialchars($_SESSION['user_name']); ?>!
                </h1>
                <p class="lead">
                    You're successfully logged into AfriCraft Global - your gateway to authentic African craftsmanship. 
                    Explore our curated marketplace connecting talented artisans with conscious consumers worldwide.
                </p>
                
                <!-- User Profile Information -->
                <div class="profile-info">
                    <h5><i class="fas fa-user-circle"></i>Your Profile Information</h5>
                    <div class="row">
                        <div class="col-md-6">
                            <ul>
                                <li><strong><i class="fas fa-envelope"></i>Email:</strong> <?php echo htmlspecialchars($_SESSION['user_email']); ?></li>
                                <li><strong><i class="fas fa-globe"></i>Country:</strong> <?php echo htmlspecialchars($_SESSION['user_country']); ?></li>
                            </ul>
                        </div>
                        <div class="col-md-6">
                            <ul>
                                <li><strong><i class="fas fa-city"></i>City:</strong> <?php echo htmlspecialchars($_SESSION['user_city']); ?></li>
                                <li><strong><i class="fas fa-phone"></i>Contact:</strong> <?php echo htmlspecialchars($_SESSION['user_contact']); ?></li>
                            </ul>
                        </div>
                    </div>
                    
                    <?php if (isset($_SESSION['user_role']) && $_SESSION['user_role'] == 1): ?>
                        <!-- Admin Panel -->
                        <div class="admin-panel">
                            <h5><i class="fas fa-user-shield"></i>Administrator Dashboard</h5>
                            <p class="mb-3">You have administrative privileges. Access your management tools below:</p>
                            <a href="admin/category.php" class="btn-admin">
                                <i class="fas fa-tags"></i>Manage Categories
                            </a>
                            <a href="#" class="btn-admin">
                                <i class="fas fa-box"></i>Manage Products
                            </a>
                            <a href="#" class="btn-admin">
                                <i class="fas fa-users"></i>Manage Users
                            </a>
                        </div>
                    <?php endif; ?>
                </div>
                
            <?php else: ?>
                <h1>
                    <i class="fas fa-shopping-bag"></i>
                    Welcome to AfriCraft Global
                </h1>
                <p class="lead">
                    Discover authentic African craftsmanship from verified artisans across the continent. 
                    Join our community of conscious consumers supporting traditional crafts and ethical trade.
                </p>
                
                <!-- Call to Action -->
                <div class="cta-section">
                    <h3><i class="fas fa-star"></i>Start Your Journey Today</h3>
                    <p>Join thousands of satisfied customers discovering unique African crafts</p>
                    <a href="login/register.php" class="btn-cta">
                        <i class="fas fa-user-plus"></i>Create Account
                    </a>
                    <a href="login/login.php" class="btn-cta">
                        <i class="fas fa-sign-in-alt"></i>Sign In
                    </a>
                </div>
            <?php endif; ?>
        </div>
        
        <!-- Features Section -->
        <div class="row">
            <div class="col-12">
                <h2 class="text-center mb-4">
                    <i class="fas fa-gem"></i>
                    Why Choose AfriCraft Global?
                </h2>
            </div>
            <div class="col-md-4 mb-4">
                <div class="feature-card">
                    <div class="feature-icon">
                        <i class="fas fa-certificate"></i>
                    </div>
                    <h5 class="feature-title">Verified Artisans</h5>
                    <p class="feature-description">
                        Every artisan on our platform is carefully vetted to ensure authenticity and quality craftsmanship.
                    </p>
                </div>
            </div>
            <div class="col-md-4 mb-4">
                <div class="feature-card">
                    <div class="feature-icon">
                        <i class="fas fa-shipping-fast"></i>
                    </div>
                    <h5 class="feature-title">Global Logistics</h5>
                    <p class="feature-description">
                        Seamless international shipping and payment solutions connecting Africa to the world.
                    </p>
                </div>
            </div>
            <div class="col-md-4 mb-4">
                <div class="feature-card">
                    <div class="feature-icon">
                        <i class="fas fa-heart"></i>
                    </div>
                    <h5 class="feature-title">Ethical Trade</h5>
                    <p class="feature-description">
                        Supporting local communities and preserving traditional crafts through fair trade practices.
                    </p>
                </div>
            </div>
            <div class="col-md-6 mb-4">
                <div class="feature-card">
                    <div class="feature-icon">
                        <i class="fas fa-palette"></i>
                    </div>
                    <h5 class="feature-title">Curated Collection</h5>
                    <p class="feature-description">
                        From traditional textiles to contemporary art, discover carefully selected pieces that tell unique stories.
                    </p>
                </div>
            </div>
            <div class="col-md-6 mb-4">
                <div class="feature-card">
                    <div class="feature-icon">
                        <i class="fas fa-shield-alt"></i>
                    </div>
                    <h5 class="feature-title">Secure Shopping</h5>
                    <p class="feature-description">
                        Shop with confidence using our secure payment systems and buyer protection policies.
                    </p>
                </div>
            </div>
        </div>
    </div>
</body>
</html>

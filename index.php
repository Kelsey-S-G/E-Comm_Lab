<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AfriCraft Global - Authentic African Craftsmanship</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome Icons -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
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
            transition: all 0.3s ease;
        }
        
        .navbar-brand:hover {
            transform: scale(1.05);
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
        
        .container.mt-5 {
            margin-top: 4rem !important;
        }
        
        .hero-section {
            background: rgba(255, 255, 255, 0.95);
            border-radius: 20px;
            padding: 3rem;
            margin-bottom: 2rem;
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.1);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.2);
        }
        
        .display-4 {
            color: #2c3e50;
            font-weight: 700;
            margin-bottom: 1.5rem;
            text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.1);
        }
        
        .lead {
            color: #5a6c7d;
            font-size: 1.2rem;
            line-height: 1.6;
            margin-bottom: 2rem;
        }
        
        .profile-info {
            background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
            border-radius: 15px;
            padding: 2rem;
            margin-top: 2rem;
            border-left: 5px solid #667eea;
        }
        
        .profile-info ul li {
            padding: 0.5rem 0;
            border-bottom: 1px solid rgba(0, 0, 0, 0.1);
            color: #2c3e50;
        }
        
        .profile-info ul li:last-child {
            border-bottom: none;
        }
        
        .profile-info strong {
            color: #667eea;
        }
        
        .features-section {
            background: rgba(255, 255, 255, 0.95);
            border-radius: 20px;
            padding: 2rem;
            margin-bottom: 2rem;
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.1);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.2);
        }
        
        .feature-card {
            background: linear-gradient(135deg, rgba(102, 126, 234, 0.1) 0%, rgba(118, 75, 162, 0.1) 100%);
            border: 1px solid rgba(102, 126, 234, 0.2);
            border-radius: 15px;
            padding: 1.5rem;
            margin-bottom: 1rem;
            transition: all 0.3s ease;
        }
        
        .feature-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 10px 25px rgba(102, 126, 234, 0.2);
        }
        
        .feature-icon {
            font-size: 2.5rem;
            color: #667eea;
            margin-bottom: 1rem;
        }
        
        .feature-title {
            color: #2c3e50;
            font-weight: 600;
            margin-bottom: 0.5rem;
        }
        
        .feature-description {
            color: #5a6c7d;
            font-size: 0.95rem;
            line-height: 1.5;
        }
        
        .cta-section {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border-radius: 20px;
            padding: 2rem;
            color: white;
            text-align: center;
            box-shadow: 0 15px 35px rgba(102, 126, 234, 0.3);
        }
        
        .btn-cta {
            background: rgba(255, 255, 255, 0.2);
            border: 2px solid rgba(255, 255, 255, 0.3);
            color: white;
            padding: 0.8rem 2rem;
            border-radius: 25px;
            font-weight: 600;
            transition: all 0.3s ease;
            text-decoration: none;
            display: inline-block;
            margin: 0.5rem;
        }
        
        .btn-cta:hover {
            background: rgba(255, 255, 255, 0.3);
            border-color: rgba(255, 255, 255, 0.5);
            color: white;
            transform: translateY(-2px);
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.2);
        }
        
        .admin-panel {
            background: linear-gradient(135deg, #28a745 0%, #20c997 100%);
            border-radius: 15px;
            padding: 1.5rem;
            color: white;
            margin-top: 1rem;
        }
        
        .admin-panel h5 {
            margin-bottom: 1rem;
            font-weight: 600;
        }
        
        .btn-admin {
            background: rgba(255, 255, 255, 0.2);
            border: 1px solid rgba(255, 255, 255, 0.3);
            color: white;
            padding: 0.5rem 1rem;
            border-radius: 8px;
            font-weight: 500;
            transition: all 0.3s ease;
            text-decoration: none;
            display: inline-block;
            margin-right: 0.5rem;
        }
        
        .btn-admin:hover {
            background: rgba(255, 255, 255, 0.3);
            color: white;
            transform: translateY(-1px);
        }
    </style>
</head>
<body>
    <!-- Navigation Bar -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container">
            <a class="navbar-brand" href="#">
                <i class="fas fa-shopping-bag me-2"></i>AfriCraft Global
            </a>
            <div class="navbar-nav ms-auto">
                <?php if (isset($_SESSION['user_id'])): ?>
                    <!-- User is logged in -->
                    <span class="navbar-text me-3">
                        <i class="fas fa-user me-1"></i>Welcome, <?php echo htmlspecialchars($_SESSION['user_name']); ?>!
                    </span>
                    
                    <?php if (isset($_SESSION['user_role']) && $_SESSION['user_role'] == 1): ?>
                        <!-- User is an admin -->
                        <a class="nav-link" href="admin/category.php">
                            <i class="fas fa-tags me-1"></i>Category Management
                        </a>
                    <?php endif; ?>
                    
                    <a class="nav-link" href="actions/logout_action.php">
                        <i class="fas fa-sign-out-alt me-1"></i>Logout
                    </a>
                <?php else: ?>
                    <!-- User is not logged in -->
                    <a class="nav-link" href="login/register.php">
                        <i class="fas fa-user-plus me-1"></i>Register
                    </a>
                    <a class="nav-link" href="login/login.php">
                        <i class="fas fa-sign-in-alt me-1"></i>Login
                    </a>
                <?php endif; ?>
            </div>
        </div>
    </nav>
    
    <!-- Main Content -->
    <div class="container mt-5">
        <!-- Hero Section -->
        <div class="hero-section text-center">
            <?php if (isset($_SESSION['user_id'])): ?>
                <h1 class="display-4">
                    <i class="fas fa-home me-2"></i>
                    Welcome back, <?php echo htmlspecialchars($_SESSION['user_name']); ?>!
                </h1>
                <p class="lead">
                    You're successfully logged into AfriCraft Global - your gateway to authentic African craftsmanship. 
                    Explore our curated marketplace connecting talented artisans with conscious consumers worldwide.
                </p>
                
                <!-- User Profile Information -->
                <div class="profile-info">
                    <h5><i class="fas fa-user-circle me-2"></i>Your Profile Information</h5>
                    <div class="row">
                        <div class="col-md-6">
                            <ul class="list-unstyled text-start">
                                <li><strong><i class="fas fa-envelope me-2"></i>Email:</strong> <?php echo htmlspecialchars($_SESSION['user_email']); ?></li>
                                <li><strong><i class="fas fa-globe me-2"></i>Country:</strong> <?php echo htmlspecialchars($_SESSION['user_country']); ?></li>
                            </ul>
                        </div>
                        <div class="col-md-6">
                            <ul class="list-unstyled text-start">
                                <li><strong><i class="fas fa-city me-2"></i>City:</strong> <?php echo htmlspecialchars($_SESSION['user_city']); ?></li>
                                <li><strong><i class="fas fa-phone me-2"></i>Contact:</strong> <?php echo htmlspecialchars($_SESSION['user_contact']); ?></li>
                            </ul>
                        </div>
                    </div>
                    
                    <?php if (isset($_SESSION['user_role']) && $_SESSION['user_role'] == 1): ?>
                        <!-- Admin Panel -->
                        <div class="admin-panel">
                            <h5><i class="fas fa-user-shield me-2"></i>Administrator Dashboard</h5>
                            <p class="mb-3">You have administrative privileges. Access your management tools below:</p>
                            <a href="admin/category.php" class="btn-admin">
                                <i class="fas fa-tags me-2"></i>Manage Categories
                            </a>
                            <a href="#" class="btn-admin">
                                <i class="fas fa-box me-2"></i>Manage Products
                            </a>
                            <a href="#" class="btn-admin">
                                <i class="fas fa-users me-2"></i>Manage Users
                            </a>
                        </div>
                    <?php endif; ?>
                </div>
                
            <?php else: ?>
                <h1 class="display-4">
                    <i class="fas fa-shopping-bag me-2"></i>
                    Welcome to AfriCraft Global
                </h1>
                <p class="lead">
                    Discover authentic African craftsmanship from verified artisans across the continent. 
                    Join our community of conscious consumers supporting traditional crafts and ethical trade.
                </p>
                
                <!-- Call to Action -->
                <div class="cta-section">
                    <h3><i class="fas fa-star me-2"></i>Start Your Journey Today</h3>
                    <p>Join thousands of satisfied customers discovering unique African crafts</p>
                    <a href="login/register.php" class="btn-cta">
                        <i class="fas fa-user-plus me-2"></i>Create Account
                    </a>
                    <a href="login/login.php" class="btn-cta">
                        <i class="fas fa-sign-in-alt me-2"></i>Sign In
                    </a>
                </div>
            <?php endif; ?>
        </div>
        
        <!-- Features Section -->
        <div class="features-section">
            <h2 class="text-center mb-4">
                <i class="fas fa-gem me-2"></i>
                Why Choose AfriCraft Global?
            </h2>
            <div class="row">
                <div class="col-md-4">
                    <div class="feature-card text-center">
                        <div class="feature-icon">
                            <i class="fas fa-certificate"></i>
                        </div>
                        <h5 class="feature-title">Verified Artisans</h5>
                        <p class="feature-description">
                            Every artisan on our platform is carefully vetted to ensure authenticity and quality craftsmanship.
                        </p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="feature-card text-center">
                        <div class="feature-icon">
                            <i class="fas fa-shipping-fast"></i>
                        </div>
                        <h5 class="feature-title">Global Logistics</h5>
                        <p class="feature-description">
                            Seamless international shipping and payment solutions connecting Africa to the world.
                        </p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="feature-card text-center">
                        <div class="feature-icon">
                            <i class="fas fa-heart"></i>
                        </div>
                        <h5 class="feature-title">Ethical Trade</h5>
                        <p class="feature-description">
                            Supporting local communities and preserving traditional crafts through fair trade practices.
                        </p>
                    </div>
                </div>
            </div>
            
            <div class="row">
                <div class="col-md-6">
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
                <div class="col-md-6">
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
    </div>
    
    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
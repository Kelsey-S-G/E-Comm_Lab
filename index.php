<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home</title>
    <!-- Included Some Bootstrap CSS to Improve UI-->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
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
        
        .container.mt-5 {
            margin-top: 4rem !important;
        }
        
        .jumbotron {
            background: rgba(255, 255, 255, 0.95);
            border-radius: 20px;
            padding: 3rem;
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
    </style>
</head>
<body>
    <!-- Navigation Bar -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container">
            <a class="navbar-brand" href="#">Shoppn</a>
            <div class="navbar-nav ms-auto">
                <?php if (isset($_SESSION['user_id'])): ?>
                    <!-- User is logged in -->
                    <span class="navbar-text me-3">
                        Welcome, <?php echo htmlspecialchars($_SESSION['user_name']); ?>!
                    </span>
                    <a class="nav-link" href="actions/logout_action.php">Logout</a>
                <?php else: ?>
                    <!-- User is not logged in -->
                    <a class="nav-link" href="login/register.php">Register</a>
                    <a class="nav-link" href="login/login.php">Login</a>
                <?php endif; ?>
            </div>
        </div>
    </nav>
    
    <!-- Main Page -->
    <div class="container mt-5">
        <div class="jumbotron">
            <?php if (isset($_SESSION['user_id'])): ?>
                <h1 class="display-4">Welcome back, <?php echo htmlspecialchars($_SESSION['user_name']); ?>!</h1>
                <p class="lead">You are now logged in to Shoppn. Explore our platform and enjoy your shopping experience.</p>
                <!-- Enhanced profile information section with better styling -->
                <div class="profile-info">
                    <p><strong>Your Profile Information:</strong></p>
                    <ul class="list-unstyled">
                        <li><strong>Email:</strong> <?php echo htmlspecialchars($_SESSION['user_email']); ?></li>
                        <li><strong>Country:</strong> <?php echo htmlspecialchars($_SESSION['user_country']); ?></li>
                        <li><strong>City:</strong> <?php echo htmlspecialchars($_SESSION['user_city']); ?></li>
                        <li><strong>Contact:</strong> <?php echo htmlspecialchars($_SESSION['user_contact']); ?></li>
                    </ul>
                </div>
            <?php else: ?>
                <h1 class="display-4">Welcome to Shoppn</h1>
                <p class="lead">Please register or login to explore our platform.</p>
            <?php endif; ?>
        </div>
    </div>
</body>
</html>

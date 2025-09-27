<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - AfriCraft Global</title>
    <!-- Updated to use modern dark theme CSS -->
    <link href="../css/theme.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <script src="../js/register.js" defer></script>
</head>
<body>
    <!-- Navigation Bar -->
    <nav class="navbar">
        <div class="container">
            <a class="navbar-brand" href="../index.php">
                <i class="fas fa-shopping-bag"></i>AfriCraft Global
            </a>
            <div class="d-flex align-items-center gap-3">
                <a class="nav-link" href="login.php">
                    <i class="fas fa-sign-in-alt"></i>Login
                </a>
            </div>
        </div>
    </nav>

    <!-- Registration Form -->
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header text-center">
                        <h4><i class="fas fa-user-plus"></i>Join AfriCraft Global</h4>
                        <p style="margin: 0; opacity: 0.9;">Create your account to start exploring authentic African crafts</p>
                    </div>
                    <div class="card-body">
                        <form id="registerForm">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="name" class="form-label">
                                            <i class="fas fa-user"></i>Full Name
                                        </label>
                                        <input type="text" id="name" name="name" class="form-control" 
                                               placeholder="Enter your full name" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="email" class="form-label">
                                            <i class="fas fa-envelope"></i>Email Address
                                        </label>
                                        <input type="email" id="email" name="email" class="form-control" 
                                               placeholder="Enter your email address" required>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="mb-3">
                                <label for="password" class="form-label">
                                    <i class="fas fa-lock"></i>Password
                                </label>
                                <input type="password" id="password" name="password" class="form-control" 
                                       placeholder="Create a secure password" required>
                            </div>
                            
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="country" class="form-label">
                                            <i class="fas fa-globe"></i>Country
                                        </label>
                                        <input type="text" id="country" name="country" class="form-control" 
                                               placeholder="Enter your country" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="city" class="form-label">
                                            <i class="fas fa-city"></i>City
                                        </label>
                                        <input type="text" id="city" name="city" class="form-control" 
                                               placeholder="Enter your city" required>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="mb-4">
                                <label for="contact" class="form-label">
                                    <i class="fas fa-phone"></i>Contact Number
                                </label>
                                <input type="text" id="contact" name="contact" class="form-control" 
                                       placeholder="Enter your contact number" required>
                            </div>
                            
                            <div class="d-grid mb-3">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-user-plus"></i>Create Account
                                </button>
                            </div>
                            
                            <div class="text-center">
                                <p style="color: var(--text-secondary);">
                                    Already have an account? 
                                    <a href="login.php" style="color: var(--green-primary); text-decoration: none;">
                                        Sign in here
                                    </a>
                                </p>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>


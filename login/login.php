<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - AfriCraft Global</title>
    <!-- Updated to use modern dark theme CSS -->
    <link href="../css/theme.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <script src="../js/login.js" defer></script>
</head>
<body>
    <!-- Navigation Bar -->
    <nav class="navbar">
        <div class="container">
            <a class="navbar-brand" href="../index.php">
                <i class="fas fa-shopping-bag"></i>AfriCraft Global
            </a>
            <div class="d-flex align-items-center gap-3">
                <a class="nav-link" href="register.php">
                    <i class="fas fa-user-plus"></i>Register
                </a>
            </div>
        </div>
    </nav>

    <!-- Login Form -->
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header text-center">
                        <h4><i class="fas fa-sign-in-alt"></i>Welcome Back</h4>
                        <p style="margin: 0; opacity: 0.9;">Sign in to your AfriCraft Global account</p>
                    </div>
                    <div class="card-body">
                        <form id="loginForm">
                            <div class="mb-3">
                                <label for="email" class="form-label">
                                    <i class="fas fa-envelope"></i>Email Address
                                </label>
                                <input type="email" id="email" name="email" class="form-control" 
                                       placeholder="Enter your email address" required>
                            </div>
                            <div class="mb-4">
                                <label for="password" class="form-label">
                                    <i class="fas fa-lock"></i>Password
                                </label>
                                <input type="password" id="password" name="password" class="form-control" 
                                       placeholder="Enter your password" required>
                            </div>
                            <div class="d-grid mb-3">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-sign-in-alt"></i>Sign In
                                </button>
                            </div>
                            <div class="text-center">
                                <p style="color: var(--text-secondary);">
                                    Don't have an account? 
                                    <a href="register.php" style="color: var(--green-primary); text-decoration: none;">
                                        Create one here
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

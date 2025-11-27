<!DOCTYPE html>
<html lang="en">
<head>
    <title>Sign In - ReConnect</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Lato:ital,wght@0,100;0,300;0,400;0,700;0,900&display=swap" />
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Roboto+Slab:wght@100;200;300;400;500;600;700;800;900&display=swap" />
    <link rel="stylesheet" href="../style.css" />
    <link rel="stylesheet" href="../css/signin.css" />
    <style>
        .alert { padding: 10px; border-radius: 8px; margin-bottom: 15px; display: none; font-size: 0.9rem; text-align: center; }
        .alert-danger { background-color: #f8d7da; color: #721c24; border: 1px solid #f5c6cb; }
        .alert-success { background-color: #d4edda; color: #155724; border: 1px solid #c3e6cb; }
    </style>
</head>
<body>
    <div class="auth-container">
        <div class="auth-card">
            <div class="auth-header">
                <a href="../index.php" class="auth-logo">
                    <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 32 32" aria-hidden="true">
                      <g fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2">
                        <path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2M16 3.128a4 4 0 0 1 0 7.744M22 21v-2a4 4 0 0 0-3-3.87"></path>
                        <circle cx="9" cy="7" r="4"></circle>
                      </g>
                    </svg>
                    <span>ReConnect</span>
                </a>
            </div>

            <h1 class="auth-title">Welcome Back</h1>
            <p class="auth-subtitle">Sign in to your alumni network account</p>

            <!-- Feedback Message Container -->
            <div id="msgContainer" class="alert"></div>

            <form id="loginForm" class="auth-form">
                <div class="form-group">
                    <label class="form-label">Email Address</label>
                    <input type="email" id="email" name="email" class="form-input" placeholder="you@alumni.com" required />
                </div>

                <div class="form-group">
                    <label class="form-label">Password</label>
                    <input type="password" id="password" name="password" class="form-input" placeholder="Enter your password" required />
                </div>

                <div class="form-options">
                    <label class="form-checkbox">
                      <input type="checkbox" />
                      <span>Remember me</span>
                    </label>
                </div>

                <button type="submit" id="loginBtn" class="btn btn-primary btn-lg" style="width: 100%; margin-top: 1rem;">Sign In</button>
            </form>

            <p class="auth-footer-text">
                Don't have an account? <a href="signup.php" class="form-link">Create one</a>
            </p>
        </div>
        <div class="auth-background"></div>
    </div>
    <!-- Include JS for validation and AJAX -->
    <script src="../js/login.js"></script>
</body>
</html>
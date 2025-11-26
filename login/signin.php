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
                    <a href="#" class="form-link">Forgot password?</a>
                </div>

                <button type="submit" id="loginBtn" class="btn btn-primary btn-lg" style="width: 100%; margin-top: 1rem;">Sign In</button>
            </form>

            <div class="auth-divider">
              <span>or continue with</span>
            </div>

            <div class="auth-social">
              <button type="button" class="auth-social-btn">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="currentColor">
                  <path d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z"/><path d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z"/><path d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.07H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.93l2.85-2.22.81-.62z"/><path d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.07l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z"/>
                </svg>
                <span>Google</span>
              </button>
              <button type="button" class="auth-social-btn">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="currentColor">
                  <path d="M13 28H11V14h-3v-3h3V8c0-2.88 1.19-7 7-7h5.5v3h-3.97c-1.5 0-1.6.75-1.6 2.05l-.75 5.95h4.5l-.75 3H16.5z"/>
                </svg>
                <span>Facebook</span>
              </button>
            </div>

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
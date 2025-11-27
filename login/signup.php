<?php
require_once '../controllers/alumni_controller.php';
$institutions = get_all_institutions_ctr(); // Fetch institutions for dropdown
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Sign Up - ReConnect</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Lato:ital,wght@0,100;0,300;0,400;0,700;0,900&display=swap" />
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Roboto+Slab:wght@100;200;300;400;500;600;700;800;900&display=swap" />
    <link rel="stylesheet" href="../style.css" />
    <link rel="stylesheet" href="../css/signup.css" />
    <style>
        /* Minimal inline styles for alerts to blend with original CSS */
        .alert { padding: 10px; border-radius: 8px; margin-bottom: 15px; display: none; font-size: 0.9rem; }
        .alert-danger { background-color: #f8d7da; color: #721c24; border: 1px solid #f5c6cb; }
        .alert-success { background-color: #d4edda; color: #155724; border: 1px solid #c3e6cb; }
        /* Ensure new select inputs match original input styling */
        select.form-input {
            appearance: none;
            background-image: url("data:image/svg+xml;charset=UTF-8,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24' fill='none' stroke='currentColor' stroke-width='2' stroke-linecap='round' stroke-linejoin='round'%3e%3cpolyline points='6 9 12 15 18 9'%3e%3c/polyline%3e%3c/svg%3e");
            background-repeat: no-repeat;
            background-position: right 1rem center;
            background-size: 1em;
        }
    </style>
</head>
<body>
    <div class="signup-container">
        <!-- Left Side: Original Structure with ReConnect Content -->
        <div class="signup-benefits-section">
            <a href="../index.php" style="text-decoration: none; color: white; display: flex; align-items: center; gap: 10px; margin-bottom: 2rem;">
                <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 32 32" aria-hidden="true">
                  <g fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2">
                    <path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2M16 3.128a4 4 0 0 1 0 7.744M22 21v-2a4 4 0 0 0-3-3.87"></path>
                    <circle cx="9" cy="7" r="4"></circle>
                  </g>
                </svg>
                <span style="font-family: 'Roboto Slab', serif; font-size: 1.5rem; font-weight: 700;">ReConnect</span>
            </a>

            <h2 class="signup-benefits-title">Join Your Alumni Network</h2>
            
            <div class="signup-benefit-item">
                <div class="signup-benefit-icon">🔒</div>
                <div class="signup-benefit-text">
                    <strong>Identity Locked Community</strong><br>
                    Connect exclusively with verified alumni from your institution.
                </div>
            </div>
            <div class="signup-benefit-item">
                <div class="signup-benefit-icon">🌍</div>
                <div class="signup-benefit-text">
                    <strong>Digital Ancestry</strong><br>
                    Preserve shared memories and build your legacy.
                </div>
            </div>
            <div class="signup-benefit-item">
                <div class="signup-benefit-icon">💼</div>
                <div class="signup-benefit-text">
                    <strong>Ethical Marketplace</strong><br>
                    Trade, mentor, and invest within a trusted circle.
                </div>
            </div>
        </div>

        <!-- Right Side: Form Section -->
        <div class="signup-form-section">
            <div class="signup-form-container">
                <h1 class="signup-form-title">Create Your Account</h1>
                <p class="signup-form-subtitle">Verify your alumni status to get started.</p>

                <!-- Feedback Message Container -->
                <div id="msgContainer" class="alert"></div>

                <form id="registerForm" class="signup-form">
                    
                    <!-- Full Name -->
                    <div class="form-group">
                        <label>Full Name</label>
                        <input type="text" name="full_name" placeholder="" required />
                    </div>

                    <!-- Email -->
                    <div class="form-group">
                        <label>Email Address</label>
                        <input type="email" id="email" name="email" placeholder="" required />
                    </div>

                    <!-- Contact Info (Week 2 Req) -->
                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem;">
                        <div class="form-group">
                            <label>Country</label>
                            <input type="text" name="country" placeholder="Ghana" required />
                        </div>
                        <div class="form-group">
                            <label>City</label>
                            <input type="text" name="city" placeholder="Accra" required />
                        </div>
                    </div>

                    <div class="form-group">
                        <label>Contact Number</label>
                        <input type="tel" id="contact" name="contact_no" placeholder="" required />
                    </div>

                    <div class="signup-divider">Verification Details</div>

                    <!-- ReConnect Specifics -->
                    <div class="form-group">
                        <label>University/School</label>
                        <select name="institution_id" class="form-control" required>
                            <option value="">Select your institution</option>
                            <?php
                            if ($institutions) {
                                foreach ($institutions as $inst) {
                                    echo "<option value='{$inst['institution_id']}'>{$inst['name']}</option>";
                                }
                            }
                            ?>
                        </select>
                    </div>

                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem;">
                        <div class="form-group">
                            <label>Matriculation No.</label>
                            <input type="text" name="matric_no" placeholder="e.g. 180902034" required />
                        </div>
                        <div class="form-group">
                            <label>Grad Year</label>
                            <input type="number" name="grad_year" placeholder="2024" required />
                        </div>
                    </div>

                    <!-- Password -->
                    <div class="form-group">
                        <label>Password</label>
                        <input type="password" id="password" name="password" placeholder="Create a strong password" required />
                    </div>

                    <button type="submit" id="submitBtn" class="signup-submit-btn">Create Account</button>
                </form>

                <div class="signup-login-link">
                    Already have an account? <a href="signin.php">Sign in</a>
                </div>
            </div>
        </div>
    </div>
    <!-- Include JS for validation and AJAX -->
    <script src="../js/register.js"></script>
</body>
</html>
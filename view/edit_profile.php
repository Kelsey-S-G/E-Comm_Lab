<?php
require_once("../settings/core.php");
require_once("../controllers/alumni_controller.php");

check_login();
$user_id = get_user_id();

// Fetch current data to pre-fill the form
$user = get_alumni_details_ctr($user_id);

if (!$user) {
    echo "Error fetching user data."; // Should effectively never happen if logged in
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Edit Profile - ReConnect</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="../style.css" />
    <link rel="stylesheet" href="../css/profile.css" />
    <!-- Reusing signup styles for form inputs as they look good -->
    <link rel="stylesheet" href="../css/signup.css" /> 
    <style>
        /* Specific tweaks for the edit page inside the dashboard layout */
        .edit-container { max-width: 800px; margin: 0 auto; background: var(--color-surface-elevated); padding: 2rem; border-radius: 12px; border: 1px solid var(--color-border); }
        .form-group label { color: var(--color-on-surface); }
    </style>
</head>
<body>
    <div class="profile-container">
        <?php include 'header.php'; ?>

        <div class="profile-wrapper">
            <!-- Sidebar -->
            <aside class="profile-sidebar">
                <div class="sidebar-menu">
                    <a href="profile.php" class="sidebar-link active"><span class="sidebar-icon">👤</span><span>My Profile</span></a>
                    <a href="../admin/venture.php" class="sidebar-link"><span class="sidebar-icon">🏢</span><span>My Ventures</span></a>
                    <a href="../admin/listing.php" class="sidebar-link"><span class="sidebar-icon">📦</span><span>Manage Listings</span></a>
                    <a href="cart.php" class="sidebar-link"><span class="sidebar-icon">🛒</span><span>My Cart</span></a>
                    <a href="../actions/logout_action.php" class="sidebar-link"><span class="sidebar-icon">🚪</span><span>Logout</span></a>
                </div>
            </aside>

            <!-- Main Content -->
            <main class="profile-main">
                <div class="edit-container">
                    <h2 class="section-title">Edit Profile</h2>
                    
                    <form id="editProfileForm" class="auth-form">
                        
                        <div class="form-group">
                            <label>Full Name</label>
                            <input type="text" name="full_name" class="form-input" value="<?php echo htmlspecialchars($user['full_name']); ?>" required />
                        </div>

                        <div class="form-group">
                            <label>Current Position / Job Title</label>
                            <input type="text" name="current_position" class="form-input" value="<?php echo htmlspecialchars($user['current_position']); ?>" placeholder="e.g. Senior Developer" />
                        </div>

                        <div class="form-row" style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem;">
                            <div class="form-group">
                                <label>Country</label>
                                <input type="text" name="country" class="form-input" value="<?php echo htmlspecialchars($user['country']); ?>" required />
                            </div>
                            <div class="form-group">
                                <label>City</label>
                                <input type="text" name="city" class="form-input" value="<?php echo htmlspecialchars($user['city']); ?>" required />
                            </div>
                        </div>

                        <div class="form-group">
                            <label>Contact Number</label>
                            <input type="tel" name="contact_no" class="form-input" value="<?php echo htmlspecialchars($user['contact_no']); ?>" required />
                        </div>

                        <!-- Read Only Fields (Security) -->
                        <div class="form-group">
                            <label>Email (Cannot be changed)</label>
                            <input type="email" class="form-input" value="<?php echo htmlspecialchars($user['email']); ?>" disabled style="opacity: 0.6;" />
                        </div>
                        
                        <div class="form-row" style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem;">
                            <div class="form-group">
                                <label>Institution</label>
                                <input type="text" class="form-input" value="<?php echo htmlspecialchars($_SESSION['institution_id'] ?? 'N/A'); ?>" disabled style="opacity: 0.6;" />
                            </div>
                            <div class="form-group">
                                <label>Class Of</label>
                                <input type="text" class="form-input" value="<?php echo htmlspecialchars($user['grad_year']); ?>" disabled style="opacity: 0.6;" />
                            </div>
                        </div>

                        <div style="margin-top: 2rem; display: flex; gap: 1rem;">
                            <button type="submit" class="btn btn-primary">Save Changes</button>
                            <a href="profile.php" class="btn btn-outline">Cancel</a>
                        </div>
                    </form>
                </div>
            </main>
        </div>
    </div>
    
    <script>
    document.addEventListener("DOMContentLoaded", function() {
        const form = document.getElementById("editProfileForm");
        form.addEventListener("submit", function(e) {
            e.preventDefault();
            const formData = new FormData(form);

            const btn = form.querySelector("button[type=submit]");
            const originalText = btn.innerText;
            btn.innerText = "Saving...";
            btn.disabled = true;

            fetch("../actions/update_profile_action.php", {
                method: "POST",
                body: formData
            })
            .then(res => res.json())
            .then(data => {
                if (data.status === "success") {
                    alert(data.message);
                    window.location.href = "profile.php"; // Redirect back to view profile
                } else {
                    alert("Error: " + data.message);
                    btn.innerText = originalText;
                    btn.disabled = false;
                }
            })
            .catch(err => {
                console.error(err);
                alert("Network error.");
                btn.innerText = originalText;
                btn.disabled = false;
            });
        });
    });
    </script>
    <?php include 'footer.php'; ?>
</body>
</html>
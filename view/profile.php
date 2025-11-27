<?php
// ReConnect/view/profile.php
require_once("../settings/core.php");
require_once("../controllers/alumni_controller.php");

check_login();
$user_id = get_user_id();
// Ideally you'd fetch the full user profile here using a controller function
// $user = get_alumni_details_ctr($user_id); 
// For now, we use session data and static placeholders where DB logic isn't fully connected yet
$user_name = $_SESSION['user_name'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>My Profile - ReConnect</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="../style.css" />
    <link rel="stylesheet" href="../css/profile.css" />
</head>
<body>
    <div class="profile-container">
        <?php include 'header.php'; ?>

        <div class="profile-wrapper">
            <!-- Sidebar -->
            <aside class="profile-sidebar">
                <div class="sidebar-menu">
                    <a href="profile.php" class="sidebar-link active">
                        <span class="sidebar-icon">👤</span>
                        <span>My Profile</span>
                    </a>
                    <a href="../admin/venture.php" class="sidebar-link">
                        <span class="sidebar-icon">🏢</span>
                        <span>My Ventures</span>
                    </a>
                    <a href="../admin/listing.php" class="sidebar-link">
                        <span class="sidebar-icon">📦</span>
                        <span>Manage Listings</span>
                    </a>
                    <a href="cart.php" class="sidebar-link">
                        <span class="sidebar-icon">🛒</span>
                        <span>My Cart</span>
                    </a>
                    <a href="../actions/logout_action.php" class="sidebar-link">
                        <span class="sidebar-icon">🚪</span>
                        <span>Logout</span>
                    </a>
                </div>
            </aside>

            <!-- Main Content -->
            <main class="profile-main">
                <!-- Profile Header -->
                <section class="profile-header">
                    <div class="profile-header-background"></div>
                    <div class="profile-header-content">
                        <div class="profile-avatar-wrapper">
                            <!-- Placeholder Avatar -->
                            <div class="profile-avatar" style="background:#ccc; display:flex; align-items:center; justify-content:center; font-size:3rem; color:#fff; border:4px solid var(--color-surface-elevated);">
                                <?php echo substr($user_name, 0, 1); ?>
                            </div>
                        </div>
                        <div class="profile-info">
                            <h1 class="profile-name"><?php echo htmlspecialchars($user_name); ?></h1>
                            <p class="profile-title">Verified Alumni</p>
                            <div class="profile-badges">
                                <span class="badge">Verified</span>
                                <span class="badge badge-seller">Community Member</span>
                            </div>
                        </div>
                        <button class="btn btn-primary">Edit Profile</button>
                    </div>
                </section>

                <!-- Profile Stats -->
                <section class="profile-stats">
                    <div class="stat-card">
                        <p class="stat-value">Active</p>
                        <p class="stat-label">Status</p>
                    </div>
                    <div class="stat-card">
                        <p class="stat-value">0</p>
                        <p class="stat-label">Ventures</p>
                    </div>
                    <div class="stat-card">
                        <p class="stat-value">0</p>
                        <p class="stat-label">Listings</p>
                    </div>
                </section>

                <!-- Details Section -->
                <section class="profile-section">
                    <h2 class="section-title">My Details</h2>
                    <div class="profile-details">
                        <div class="detail-item">
                            <span class="detail-label">Name</span>
                            <span class="detail-value"><?php echo htmlspecialchars($user_name); ?></span>
                        </div>
                        <div class="detail-item">
                            <span class="detail-label">Verification Status</span>
                            <span class="detail-value" style="color: green;">Verified</span>
                        </div>
                        <!-- Add more fields from DB as needed -->
                    </div>
                </section>
            </main>
        </div>
    </div>
    <?php include 'footer.php'; ?>
</body>
</html>
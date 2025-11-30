<?php
require_once("../settings/core.php");
require_once("../controllers/alumni_controller.php");

check_login();
$user_id = get_user_id();
$user_name = $_SESSION['user_name'];
$status = $_SESSION['verification_status'] ?? 'pending';

// Badge Styles
$badgeText = ucfirst($status);
$badgeColor = '#ccc';
$textColor = '#555';

if ($status === 'verified') {
    $badgeColor = '#e6fffa'; $textColor = '#047857';
} elseif ($status === 'rejected') {
    $badgeColor = '#fef2f2'; $textColor = '#b91c1c';
} else {
    $badgeColor = '#fffbeb'; $textColor = '#b45309';
}
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
        <?php include '../view/header.php'; ?>

        <div class="profile-wrapper">
            <aside class="profile-sidebar">
                <div class="sidebar-menu">
                    <a href="profile.php" class="sidebar-link active"><span class="sidebar-icon">👤</span><span>My Profile</span></a>
                    <a href="../admin/venture.php" class="sidebar-link"><span class="sidebar-icon">🏢</span><span>My Ventures</span></a>
                    <a href="../admin/listing.php" class="sidebar-link"><span class="sidebar-icon">📦</span><span>Manage Listings</span></a>
                    <a href="cart.php" class="sidebar-link"><span class="sidebar-icon">🛒</span><span>My Cart</span></a>
                    <a href="../actions/logout_action.php" class="sidebar-link"><span class="sidebar-icon">🚪</span><span>Logout</span></a>
                </div>
            </aside>

            <main class="profile-main">
                <section class="profile-header">
                    <div class="profile-header-background"></div>
                    <div class="profile-header-content">
                        <div class="profile-avatar-wrapper">
                            <div class="profile-avatar" style="background:#ccc; display:flex; align-items:center; justify-content:center; font-size:3rem; color:#fff; border:4px solid var(--color-surface-elevated);">
                                <?php echo substr($user_name, 0, 1); ?>
                            </div>
                        </div>
                        <div class="profile-info">
                            <h1 class="profile-name"><?php echo htmlspecialchars($user_name); ?></h1>
                            <div class="profile-badges">
                                <span class="badge" style="background-color: <?php echo $badgeColor; ?>; color: <?php echo $textColor; ?>; border: 1px solid <?php echo $textColor; ?>;">
                                    <?php echo $badgeText; ?>
                                </span>
                                <span class="badge badge-seller">Community Member</span>
                            </div>
                        </div>
                        <!-- Functional Edit Button -->
                        <a href="edit_profile.php" class="btn btn-primary">Edit Profile</a>
                    </div>
                </section>

                <section class="profile-section">
                    <h2 class="section-title">My Details</h2>
                    <div class="profile-details">
                        <div class="detail-item">
                            <span class="detail-label">Name</span>
                            <span class="detail-value"><?php echo htmlspecialchars($user_name); ?></span>
                        </div>
                        <div class="detail-item">
                            <span class="detail-label">Verification Status</span>
                            <span class="detail-value" style="color: <?php echo $textColor; ?>; font-weight:bold;">
                                <?php echo $badgeText; ?>
                            </span>
                        </div>
                        <div class="detail-item">
                            <span class="detail-label">Institution ID</span>
                            <span class="detail-value"><?php echo $_SESSION['institution_id'] ?? 'N/A'; ?></span>
                        </div>
                    </div>
                </section>
            </main>
        </div>
    </div>
    <?php include '../view/footer.php'; ?>
</body>
</html>
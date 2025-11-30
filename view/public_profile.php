<?php
require_once("../settings/core.php");
require_once("../controllers/alumni_controller.php");

check_login();

if (!isset($_GET['id'])) {
    header("Location: community.php");
    exit();
}

$target_id = $_GET['id'];
$all_alumni = get_all_alumni_ctr();
$profile_user = null;
foreach($all_alumni as $a) {
    if ($a['alumni_id'] == $target_id) {
        $profile_user = $a;
        break;
    }
}

if (!$profile_user) {
    echo "User not found.";
    exit();
}

// Logic for Dynamic Verification Tag
$status = $profile_user['verification_status'] ?? 'pending';
$badgeText = ucfirst($status);
$badgeColor = '#ccc'; // Default Gray
$textColor = '#555';

if ($status === 'verified') {
    $badgeColor = '#e6fffa'; // Light Green bg
    $textColor = '#047857';  // Green text
} elseif ($status === 'rejected') {
    $badgeColor = '#fef2f2'; // Light Red
    $textColor = '#b91c1c';  // Red
} else {
    // Pending
    $badgeColor = '#fffbeb'; // Light Yellow
    $textColor = '#b45309';  // Yellow/Orange
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title><?php echo htmlspecialchars($profile_user['full_name']); ?> - ReConnect</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="../style.css" />
    <link rel="stylesheet" href="../css/profile.css" />
</head>
<body>
    <div class="profile-container">
        <?php include 'header.php'; ?>

        <div class="profile-wrapper" style="justify-content: center;"> 
            <!-- No Sidebar for Public View -->
            <main class="profile-main" style="max-width: 900px;">
                <section class="profile-header">
                    <div class="profile-header-background"></div>
                    <div class="profile-header-content">
                        <div class="profile-avatar-wrapper">
                            <div class="profile-avatar" style="background:#ccc; display:flex; align-items:center; justify-content:center; font-size:3rem; color:#fff; border:4px solid var(--color-surface-elevated);">
                                <?php echo substr($profile_user['full_name'], 0, 1); ?>
                            </div>
                        </div>
                        <div class="profile-info">
                            <h1 class="profile-name"><?php echo htmlspecialchars($profile_user['full_name']); ?></h1>
                            <p class="profile-title"><?php echo htmlspecialchars($profile_user['current_position'] ?? 'Alumni'); ?></p>
                            
                            <!-- DYNAMIC VERIFICATION BADGE -->
                            <div class="profile-badges">
                                <span class="badge" style="background-color: <?php echo $badgeColor; ?>; color: <?php echo $textColor; ?>; border: 1px solid <?php echo $textColor; ?>;">
                                    <?php echo $badgeText; ?>
                                </span>
                            </div>
                        </div>
                        
                        <!-- Connect Button Logic (Optional: Disable if not verified) -->
                        <?php if (isVerified()): ?>
                            <button class="btn btn-primary" onclick="alert('Connection request sent!')">Connect</button>
                        <?php else: ?>
                            <button class="btn btn-secondary" disabled title="Verify your account to connect">Connect</button>
                        <?php endif; ?>
                    </div>
                </section>

                <section class="profile-section">
                    <h2 class="section-title">About</h2>
                    <div class="profile-details">
                        <div class="detail-item">
                            <span class="detail-label">Institution</span>
                            <span class="detail-value"><?php echo htmlspecialchars($profile_user['institution_name'] ?? 'N/A'); ?></span>
                        </div>
                        <div class="detail-item">
                            <span class="detail-label">Class Of</span>
                            <span class="detail-value"><?php echo htmlspecialchars($profile_user['grad_year']); ?></span>
                        </div>
                        <div class="detail-item">
                            <span class="detail-label">Location</span>
                            <span class="detail-value"><?php echo htmlspecialchars($profile_user['city'] . ', ' . $profile_user['country']); ?></span>
                        </div>
                    </div>
                </section>
            </main>
        </div>
    </div>
    <?php include 'footer.php'; ?>
</body>
</html>
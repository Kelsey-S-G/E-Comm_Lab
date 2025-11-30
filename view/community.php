<?php
require_once("../settings/core.php");
require_once("../controllers/alumni_controller.php");

check_login(); 

$user_id = get_user_id();
$all_alumni = [];

// Safer fetching
if (function_exists('get_all_alumni_ctr')) {
    $all_alumni = get_all_alumni_ctr();
}

$current_user_inst_id = $_SESSION['institution_id'] ?? 0;
$is_verified = isVerified(); 
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Community Directory - ReConnect</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="../style.css" />
    <link rel="stylesheet" href="../css/community.css" />
</head>
<body>
    <div class="community-container">
        <?php include '../view/header.php'; ?>

        <section class="community-hero">
            <div class="community-hero-content">
                <h1 class="hero-title">My Alumni Network</h1>
                <p class="hero-subtitle">Connect with verified peers from your institution.</p>
                <div class="community-search-bar">
                    <input type="text" id="alumniSearch" class="community-search-input" placeholder="Search by name, class, or role..." onkeyup="filterAlumni()">
                </div>
            </div>
        </section>

        <section class="community-members">
            <div class="members-grid" id="membersGrid">
                <?php if (!empty($all_alumni)): ?>
                    <?php foreach ($all_alumni as $alum): 
                        if ($alum['alumni_id'] == $user_id) continue;
                        if ($alum['institution_id'] != $current_user_inst_id) continue;
                    ?>
                    <div class="member-card filter-item" data-name="<?php echo strtolower($alum['full_name']); ?>" data-role="<?php echo strtolower($alum['current_position'] ?? ''); ?>">
                        <div class="member-header">
                            <div style="width:100%; height:100%; background: linear-gradient(135deg, var(--color-primary), var(--color-secondary)); opacity:0.2;"></div>
                            <?php 
                                $vStatus = $alum['verification_status'] ?? 'pending';
                                $statusColor = ($vStatus == 'verified') ? '#4ade80' : (($vStatus == 'pending') ? '#facc15' : '#ccc');
                            ?>
                            <div class="member-status" style="background-color: <?php echo $statusColor; ?>">
                                <?php echo ucfirst($vStatus); ?>
                            </div>
                        </div>
                        <div class="member-info">
                            <div class="member-avatar" style="background:#ccc; display:flex; align-items:center; justify-content:center; font-size:2rem; color:#fff;">
                                <?php echo substr($alum['full_name'], 0, 1); ?>
                            </div>
                            <h3 class="member-name"><?php echo $alum['full_name']; ?></h3>
                            <p class="member-title"><?php echo $alum['current_position'] ?? 'Alumni Member'; ?></p>
                            <div class="member-meta">
                                <span class="meta-item">🎓 Class of <?php echo $alum['grad_year']; ?></span>
                                <span class="meta-item">📚 <?php echo $alum['institution_name'] ?? 'University'; ?></span>
                            </div>
                            
                            <div class="member-actions">
                                <?php if ($is_verified): ?>
                                    <button class="btn btn-sm btn-primary" style="flex: 1;" onclick="alert('Connection Request Sent!')">Connect</button>
                                <?php else: ?>
                                    <button class="btn btn-sm btn-secondary" style="flex: 1; opacity: 0.6; cursor: not-allowed;" onclick="alert('Only verified alumni can connect.')">Verify</button>
                                <?php endif; ?>
                                <a href="../view/public_profile.php?id=<?php echo $alum['alumni_id']; ?>" class="btn btn-sm btn-outline" style="flex: 1; text-align:center;">View Profile</a>
                            </div>
                        </div>
                    </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <p style="text-align:center; grid-column: 1/-1;">No alumni found from your institution.</p>
                <?php endif; ?>
            </div>
        </section>

        <?php include '../view/footer.php'; ?>
    </div>
    <script>
        function filterAlumni() {
            const input = document.getElementById('alumniSearch').value.toLowerCase();
            const cards = document.querySelectorAll('.filter-item');
            cards.forEach(card => {
                const name = card.getAttribute('data-name');
                const role = card.getAttribute('data-role');
                if (name.includes(input) || role.includes(input)) {
                    card.style.display = "flex";
                } else {
                    card.style.display = "none";
                }
            });
        }
    </script>
</body>
</html>
<?php
require_once("../settings/core.php");
require_once("../controllers/alumni_controller.php");

check_login(); // Identity Lock: Only logged in users can see the directory

$alumni_list = get_all_alumni_ctr(); 
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
        <?php include 'header.php'; ?>

        <!-- Hero Section -->
        <section class="community-hero">
            <div class="community-hero-content">
                <h1 class="hero-title">Alumni Directory</h1>
                <p class="hero-subtitle">Connect with verified alumni from your institution.</p>
                
                <!-- Search (Simple JS Filter for now) -->
                <div class="community-search-bar">
                    <input type="text" id="alumniSearch" class="community-search-input" placeholder="Search by name, class, or role..." onkeyup="filterAlumni()">
                </div>
            </div>
        </section>

        <!-- Alumni Grid -->
        <section class="community-members">
            <div class="members-grid" id="membersGrid">
                <?php if (!empty($alumni_list)): ?>
                    <?php foreach ($alumni_list as $alum): 
                        // Skip the current user
                        if ($alum['alumni_id'] == get_user_id()) continue;
                    ?>
                    <div class="member-card filter-item" data-name="<?php echo strtolower($alum['full_name']); ?>" data-role="<?php echo strtolower($alum['current_position']); ?>">
                        <div class="member-header">
                            <!-- Dynamic background based on school could go here -->
                            <div style="width:100%; height:100%; background: linear-gradient(135deg, var(--color-primary), var(--color-secondary)); opacity:0.2;"></div>
                            <div class="member-status">Verified</div>
                        </div>
                        <div class="member-info">
                            <!-- Placeholder Avatar -->
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
                                <button class="btn btn-sm btn-primary" style="flex: 1;" onclick="alert('Connection Request Sent!')">Connect</button>
                                <button class="btn btn-sm btn-outline" style="flex: 1;">View Profile</button>
                            </div>
                        </div>
                    </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <p style="text-align:center; grid-column: 1/-1;">No other alumni found yet.</p>
                <?php endif; ?>
            </div>
        </section>

        <?php include 'footer.php'; ?>
    </div>

    <script>
        // Simple Client-Side Filter
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
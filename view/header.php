<?php
// ReConnect/view/header.php
// Ensure session is started if this file is included directly
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Determine root path for links depending on where this file is included
// If included from root (index.php), path is ".". If from subfolder (view/admin), path is ".."
$rootPath = (basename($_SERVER['PHP_SELF']) == 'index.php') ? '.' : '..';
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <title>ReConnect - Digital Ancestry</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta charset="utf-8" />
    
    <!-- External Fonts & CSS -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Lato:ital,wght@0,100;0,300;0,400;0,700;0,900&display=swap" />
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Roboto+Slab:wght@100;200;300;400;500;600;700;800;900&display=swap" />
    
    <!-- Stylesheets with dynamic root path -->
    <link rel="stylesheet" href="<?php echo $rootPath; ?>/style.css" />
    <link rel="stylesheet" href="<?php echo $rootPath; ?>/css/navigation.css" />
    <link rel="stylesheet" href="<?php echo $rootPath; ?>/css/index.css" />
    <!-- Include component specific CSS if needed based on page logic -->
  </head>
  <body>
    <div class="navigation-container1">
      <nav id="navigation" class="navigation">
        <div class="navigation__container">
          <!-- Logo Section -->
          <a href="<?php echo $rootPath; ?>/index.php">
            <div class="navigation__logo">
              <div class="navigation__logo-icon">
                <!-- Logo SVG -->
                <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 32 32" aria-hidden="true">
                  <g fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2">
                    <path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2M16 3.128a4 4 0 0 1 0 7.744M22 21v-2a4 4 0 0 0-3-3.87"></path>
                    <circle cx="9" cy="7" r="4"></circle>
                  </g>
                </svg>
              </div>
              <span class="navigation__logo-text">ReConnect</span>
            </div>
          </a>

          <!-- Menu Links -->
          <div class="navigation__menu">
            <ul class="navigation__list">
              <li class="navigation__item"><a href="<?php echo $rootPath; ?>/view/listings.php"><div class="navigation__link"><span>Marketplace</span></div></a></li>
              <li class="navigation__item"><a href="<?php echo $rootPath; ?>/view/community.php"><div class="navigation__link"><span>Community</span></div></a></li>
              <li class="navigation__item"><a href="<?php echo $rootPath; ?>/view/events.php"><div class="navigation__link"><span>Events</span></div></a></li>
            </ul>
          </div>

          <!-- Dynamic Auth Actions -->
          <div class="navigation__actions">
            <?php if (isset($_SESSION['user_id'])): ?>
                <!-- Logged In State -->
                <span style="margin-right: 10px; font-weight: bold; color: var(--color-on-surface);">Hi, <?php echo htmlspecialchars($_SESSION['user_name'] ?? 'Alumni'); ?></span>
                
                <!-- Check if Admin for extra link -->
                <?php if (isset($_SESSION['user_role']) && $_SESSION['user_role'] == 1): ?>
                    <a href="<?php echo $rootPath; ?>/admin/venture.php"><div class="navigation__login"><span>Admin</span></div></a>
                <?php else: ?>
                    <a href="<?php echo $rootPath; ?>/view/profile.php"><div class="navigation__login"><span>Profile</span></div></a>
                <?php endif; ?>

                <!-- UPDATED LOGOUT LINK -->
                <a href="<?php echo $rootPath; ?>/actions/logout_action.php"><button class="btn btn-outline btn-sm">Logout</button></a>
            <?php else: ?>
                <!-- Guest State -->
                <a href="<?php echo $rootPath; ?>/login/signin.php"><div class="navigation__login"><span>Sign In</span></div></a>
                <a href="<?php echo $rootPath; ?>/login/signup.php"><button class="navigation__cta btn btn-primary">Get Started</button></a>
            <?php endif; ?>
          </div>
        </div>
      </nav>
    </div>
    <!-- Spacer for fixed nav -->
    <div style="height: 80px;"></div>
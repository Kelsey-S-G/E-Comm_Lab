<?php
// ReConnect/view/footer.php
// Dynamic root path logic same as header
$rootPath = (basename($_SERVER['PHP_SELF']) == 'index.php') ? '.' : '..';
?>
    <link rel="stylesheet" href="<?php echo $rootPath; ?>/css/footer.css" />
    <footer id="footer-section" class="footer-main">
      <div class="footer-container">
        <div class="footer-top-section">
          <div class="footer-brand-column">
            <div class="footer-logo-wrapper">
                <div class="footer-logo-icon">
                  <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24">
                    <g fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2">
                      <path d="M21.42 10.922a1 1 0 0 0-.019-1.838L12.83 5.18a2 2 0 0 0-1.66 0L2.6 9.08a1 1 0 0 0 0 1.832l8.57 3.908a2 2 0 0 0 1.66 0zM22 10v6"></path>
                      <path d="M6 12.5V16a6 3 0 0 0 12 0v-3.5"></path>
                    </g>
                  </svg>
                </div>
              <span class="footer-logo-text">ReConnect</span>
            </div>
            <p class="footer-brand-description">
              Building the digital ancestry of Africa's educated generation. Monetize belonging ethically.
            </p>
          </div>
          <div class="footer-links-column">
            <h3 class="footer-column-title">Platform</h3>
            <ul class="footer-links-list">
              <li><a href="<?php echo $rootPath; ?>/index.php"><div class="footer-link"><span>Home</span></div></a></li>
              <li><a href="<?php echo $rootPath; ?>/view/listings.php"><div class="footer-link"><span>Marketplace</span></div></a></li>
              <li><a href="<?php echo $rootPath; ?>/view/community.php"><div class="footer-link"><span>Community</span></div></a></li>
            </ul>
          </div>
          <div class="footer-links-column">
            <h3 class="footer-column-title">User</h3>
            <ul class="footer-links-list">
                <?php if (!isset($_SESSION['user_id'])): ?>
                  <li><a href="<?php echo $rootPath; ?>/login/signin.php"><div class="footer-link"><span>Sign In</span></div></a></li>
                  <li><a href="<?php echo $rootPath; ?>/login/signup.php"><div class="footer-link"><span>Sign Up</span></div></a></li>
                <?php else: ?>
                  <li><a href="<?php echo $rootPath; ?>/view/profile.php"><div class="footer-link"><span>My Profile</span></div></a></li>
                  <li><a href="<?php echo $rootPath; ?>/actions/logout.php"><div class="footer-link"><span>Logout</span></div></a></li>
                <?php endif; ?>
            </ul>
          </div>
        </div>
        <div class="footer-divider"></div>
        <div class="footer-bottom-section">
          <p class="footer-copyright">© 2025 ReConnect. All rights reserved.</p>
        </div>
      </div>
    </footer>
  </body>
</html>
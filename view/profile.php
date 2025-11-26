<!DOCTYPE html>
<html lang="en">
  <head>
    <title>My Profile - ReConnect</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta charset="utf-8" />
    <style data-tag="reset-style-sheet">
      html {  line-height: 1.15;}body {  margin: 0;}* {  box-sizing: border-box;  border-width: 0;  border-style: solid;  -webkit-font-smoothing: antialiased;}p,li,ul,pre,div,h1,h2,h3,h4,h5,h6,figure,blockquote,figcaption {  margin: 0;  padding: 0;}button {  background-color: transparent;}button,input,optgroup,select,textarea {  font-family: inherit;  font-size: 100%;  line-height: 1.15;  margin: 0;}button,select {  text-transform: none;}button,[type="button"],[type="reset"],[type="submit"] {  -webkit-appearance: button;  color: inherit;}button::-moz-focus-inner,[type="button"]::-moz-focus-inner,[type="reset"]::-moz-focus-inner,[type="submit"]::-moz-focus-inner {  border-style: none;  padding: 0;}button:-moz-focus,[type="button"]:-moz-focus,[type="reset"]:-moz-focus,[type="submit"]:focus {  outline: 1px dotted ButtonText;}a {  color: inherit;  text-decoration: inherit;}pre {  white-space: normal;}input {  padding: 2px 4px;}img {  display: block;}details {  display: block;  margin: 0;  padding: 0;}summary::-webkit-details-marker {  display: none;}html { scroll-behavior: smooth  }
    </style>
    <style data-tag="default-style-sheet">
      html {
        font-family: Lato;
        font-size: 1rem;
      }
      body {
        font-weight: 400;
        color: var(--color-on-surface);
        background: var(--color-surface);
        fill: var(--color-on-surface);
      }
    </style>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Lato:ital,wght@0,100;0,300;0,400;0,700;0,900&display=swap" data-tag="font" />
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Roboto+Slab:wght@100;200;300;400;500;600;700;800;900&display=swap" data-tag="font" />
    <link rel="stylesheet" href="./style.css" />
    <!-- Added link to separate profile CSS file -->
    <link rel="stylesheet" href="../css/profile.css" />
  </head>
  <body>
    <div class="profile-container">
      <!-- Navigation -->
      <nav class="profile-nav">
        <div class="profile-nav-content">
          <a href="index.html" class="profile-logo">
            <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 32 32" aria-hidden="true">
              <g fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2">
                <path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2M16 3.128a4 4 0 0 1 0 7.744M22 21v-2a4 4 0 0 0-3-3.87"></path>
                <circle cx="9" cy="7" r="4"></circle>
              </g>
            </svg>
            <span>ReConnect</span>
          </a>
          <div class="profile-nav-actions">
            <button class="btn btn-outline btn-sm">Settings</button>
            <button class="btn btn-outline btn-sm">Logout</button>
          </div>
        </div>
      </nav>

      <div class="profile-wrapper">
        <!-- Sidebar -->
        <aside class="profile-sidebar">
          <div class="sidebar-menu">
            <a href="#profile" class="sidebar-link active">
              <span class="sidebar-icon">👤</span>
              <span>My Profile</span>
            </a>
            <a href="#orders" class="sidebar-link">
              <span class="sidebar-icon">📦</span>
              <span>Orders</span>
            </a>
            <a href="#purchases" class="sidebar-link">
              <span class="sidebar-icon">🛒</span>
              <span>Purchases</span>
            </a>
            <a href="#services" class="sidebar-link">
              <span class="sidebar-icon">💼</span>
              <span>My Services</span>
            </a>
            <a href="#messages" class="sidebar-link">
              <span class="sidebar-icon">💬</span>
              <span>Messages</span>
            </a>
            <a href="#settings" class="sidebar-link">
              <span class="sidebar-icon">⚙️</span>
              <span>Account Settings</span>
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
                <img src="/placeholder.svg?height=120&width=120" alt="Profile Avatar" class="profile-avatar" />
                <button class="profile-avatar-edit">📷</button>
              </div>
              <div class="profile-info">
                <h1 class="profile-name">Sarah Johnson</h1>
                <p class="profile-title">Business Consultant | Class of 2018</p>
                <div class="profile-badges">
                  <span class="badge">Verified Alumni</span>
                  <span class="badge badge-seller">Verified Seller</span>
                </div>
              </div>
              <button class="btn btn-primary">Edit Profile</button>
            </div>
          </section>

          <!-- Profile Stats -->
          <section class="profile-stats">
            <div class="stat-card">
              <p class="stat-value">4.8</p>
              <p class="stat-label">Rating</p>
            </div>
            <div class="stat-card">
              <p class="stat-value">256</p>
              <p class="stat-label">Transactions</p>
            </div>
            <div class="stat-card">
              <p class="stat-value">98%</p>
              <p class="stat-label">Positive Feedback</p>
            </div>
            <div class="stat-card">
              <p class="stat-value">12</p>
              <p class="stat-label">Active Services</p>
            </div>
          </section>

          <!-- About Section -->
          <section class="profile-section">
            <h2 class="section-title">About Me</h2>
            <p class="section-content">
              I'm a business consultant with 6+ years of experience helping startups scale. I specialize in strategic planning, market analysis, and business development. When I'm not consulting, I mentor young entrepreneurs in the alumni network.
            </p>
            <div class="profile-details">
              <div class="detail-item">
                <span class="detail-label">Email</span>
                <span class="detail-value">sarah@example.com</span>
              </div>
              <div class="detail-item">
                <span class="detail-label">University</span>
                <span class="detail-value">University of Lagos, 2018</span>
              </div>
              <div class="detail-item">
                <span class="detail-label">Location</span>
                <span class="detail-value">Lagos, Nigeria</span>
              </div>
              <div class="detail-item">
                <span class="detail-label">Joined</span>
                <span class="detail-value">January 2024</span>
              </div>
            </div>
          </section>

          <!-- Recent Reviews -->
          <section class="profile-section">
            <h2 class="section-title">Recent Reviews</h2>
            <div class="reviews-list">
              <div class="review-item">
                <div class="review-header">
                  <span class="review-stars">★★★★★</span>
                  <span class="review-date">2 days ago</span>
                </div>
                <p class="review-author">John Doe - CEO of StartupXYZ</p>
                <p class="review-text">"Sarah provided exceptional consulting services. Her insights were invaluable to our growth strategy. Highly recommended!"</p>
              </div>
              <div class="review-item">
                <div class="review-header">
                  <span class="review-stars">★★★★★</span>
                  <span class="review-date">1 week ago</span>
                </div>
                <p class="review-author">Jane Smith - Founder</p>
                <p class="review-text">"Professional, punctual, and results-driven. Sarah exceeded our expectations on every front."</p>
              </div>
            </div>
          </section>
        </main>
      </div>
    </div>
  </body>
</html>

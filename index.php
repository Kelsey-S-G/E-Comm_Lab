<?php
// 1. Load Core Settings
require_once 'settings/core.php';

// 2. Include the Header (Navigation logic is inside header.php)
include 'view/header.php';
?>

<!-- Original Content Structure Preserved -->
<div class="home-container10">
    <div class="home-container11">
        <div class="home-container12">
            <!-- Inline styles from original index.html -->
            <style>
              #hero-section {
                display: flex;
                justify-content: center;
                align-items: center;
                min-height: 100vh;
                padding: var(--spacing-4xl) 0;
                background: var(--color-surface);
                position: relative;
                overflow: hidden;
              }
              #hero-section::before {
                content: "";
                position: absolute;
                top: 0;
                left: 0;
                right: 0;
                bottom: 0;
                background: radial-gradient(
                      circle at 20% 30%,
                      color-mix(in srgb, var(--color-primary) 8%, transparent),
                      transparent 60%
                    ),
                    radial-gradient(
                      circle at 80% 70%,
                      color-mix(in srgb, var(--color-secondary) 6%, transparent),
                      transparent 60%
                    );
                z-index: 1;
                pointer-events: none;
              }
              @media (max-width: 767px) {
              #hero-section {
                min-height: auto;
                padding: var(--spacing-3xl) 0;
              }
              }
              #identity-trust-section {
                padding: var(--section-gap) 0;
                background: var(--color-surface);
              }
              #memory-section {
                padding: var(--section-gap) 0;
                background: var(--color-surface);
              }
              #marketplace-section {
                padding: var(--section-gap) 0;
                background: var(--color-surface);
              }
              #events-section {
                padding: var(--section-gap) 0;
                background: var(--color-surface);
              }
              #play-video-btn {
                display: inline-flex;
                align-items: center;
                gap: var(--spacing-sm);
                width: fit-content;
              }
              #how-works-section {
                padding: var(--section-gap) 0;
                background: var(--color-surface);
              }
              #impact-metrics-section {
                padding: var(--section-gap) 0;
                background: var(--color-surface);
              }
              @media (prefers-reduced-motion: reduce) {
              *, *::before, *::after {
                animation-duration: 0.01ms !important;
                animation-iteration-count: 1 !important;
                transition-duration: 0.01ms !important;
              }
              }
            </style>
        </div>
    </div>

    <section id="hero-section" role="region" aria-labelledby="hero-heading">
        <div class="hero-container">
            <div class="hero-panel">
                <div class="hero-copy">
                    <h1 id="hero-heading">
                        ReConnect — The Digital Bridge for Verified Alumni
                    </h1>
                    <p class="lead">
                        Preserve shared histories, authenticate trusted connections,
                        and open ethical pathways to economic opportunity.
                    </p>
                    <p class="body">
                        Securely verify your alumni identity, rediscover cohort
                        achievements, and access curated learning and marketplace
                        opportunities designed for former students and institutions.
                    </p>
                    <div class="hero-actions">
                        <?php if (!is_logged_in()): ?>
                            <a href="login/signup.php">
                                <div role="button" aria-label="Get verified and join ReConnect" class="btn btn-primary btn-lg">
                                    <span>Get Verified</span>
                                </div>
                            </a>
                        <?php endif; ?>
                        <a href="#how-works-section">
                            <div role="button" aria-label="Learn more about ReConnect" class="btn btn-lg btn-outline">
                                <span>Learn More</span>
                            </div>
                        </a>
                    </div>
                </div>
                <aside aria-hidden="false" class="hero-visual">
                    <div class="hero-visual-inner">
                        <ul class="feature-list">
                            <li>
                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24">
                                    <path fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 6L9 17l-5-5"></path>
                                </svg>
                                <span>Verified identity and credentials</span>
                            </li>
                            <li>
                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24">
                                    <path fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 6L9 17l-5-5"></path>
                                </svg>
                                <span>Secure memory preservation</span>
                            </li>
                            <li>
                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24">
                                    <path fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 6L9 17l-5-5"></path>
                                </svg>
                                <span>Ethical monetization pathways</span>
                            </li>
                            <li>
                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24">
                                    <path fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 6L9 17l-5-5"></path>
                                </svg>
                                <span>Institutional partnerships</span>
                            </li>
                        </ul>
                    </div>
                </aside>
            </div>
        </div>
    </section>

    <!-- Identity Trust Section -->
    <section id="identity-trust-section" role="region" aria-labelledby="identity-trust-heading">
        <div class="identity-trust-container">
            <div class="identity-trust-content">
                <div class="identity-left-column">
                    <h2 id="identity-trust-heading">Verified Alumni. Verifiable Trust.</h2>
                    <p class="identity-intro">
                        Every profile on ReConnect is verified against institutional
                        records and multi-factor identity checks — so decisions,
                        collaborations, and transactions happen with confidence.
                    </p>
                    <?php if (!is_logged_in()): ?>
                        <a href="login/signup.php">
                            <div role="button" aria-label="Claim your verified profile" class="btn btn-primary">
                                <span>Claim Your Profile</span>
                            </div>
                        </a>
                    <?php endif; ?>
                </div>
                <div class="identity-cards-grid">
                    <article role="article" class="identity-card">
                        <div class="card-icon">
                            <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24">
                                <path fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13c0 5-3.5 7.5-7.66 8.95a1 1 0 0 1-.67-.01C7.5 20.5 4 18 4 13V6a1 1 0 0 1 1-1c2 0 4.5-1.2 6.24-2.72a1.17 1.17 0 0 1 1.52 0C14.51 3.81 17 5 19 5a1 1 0 0 1 1 1z"></path>
                            </svg>
                        </div>
                        <h3>Secure Profiles</h3>
                        <p>Academic records and graduation cohorts are surfaced clearly.</p>
                    </article>
                    <article role="article" class="identity-card">
                        <div class="card-icon">
                            <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24">
                                <g fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2">
                                    <rect width="18" height="11" x="3" y="11" rx="2" ry="2"></rect>
                                    <path d="M7 11V7a5 5 0 0 1 10 0v4"></path>
                                </g>
                            </svg>
                        </div>
                        <h3>Permissioned Sharing</h3>
                        <p>Control what parts of your identity are visible to the network.</p>
                    </article>
                    <article role="article" class="identity-card">
                        <div class="card-icon">
                            <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24">
                                <g fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2">
                                    <path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2M16 3.128a4 4 0 0 1 0 7.744M22 21v-2a4 4 0 0 0-3-3.87"></path>
                                    <circle cx="9" cy="7" r="4"></circle>
                                </g>
                            </svg>
                        </div>
                        <h3>Institutional Sync</h3>
                        <p>Direct data partnerships ensure accreditation status is current.</p>
                    </article>
                </div>
            </div>
        </div>
    </section>

    <!-- How It Works Section (New) -->
    <section id="how-works-section" role="region" aria-labelledby="how-works-heading">
        <div class="how-works-container">
            <div class="how-works-anchor">
                <h2 id="how-works-heading">How ReConnect Works</h2>
                <p class="anchor-intro">
                    A simple, transparent process from verification to ethical
                    opportunity — designed for institutions and alumni seeking
                    meaningful impact.
                </p>
                <?php if (!is_logged_in()): ?>
                    <a href="login/signup.php">
                        <div role="button" aria-label="Start your verification process" class="btn btn-primary">
                            <span>Get Started</span>
                        </div>
                    </a>
                <?php endif; ?>
            </div>
            <div role="list" aria-label="ReConnect process steps" class="how-works-timeline">
                <article role="listitem" class="timeline-step timeline-step-hero">
                    <div class="step-number"><span>01</span></div>
                    <div class="step-content">
                        <h3>Simple Onboarding — Verified in Minutes</h3>
                        <p>
                            Create your ReConnect profile using institutional
                            credentials or secure ID verification. We authenticate
                            affiliations so every connection starts from trust.
                        </p>
                    </div>
                </article>
                <article role="listitem" class="timeline-step">
                    <div class="step-number"><span>02</span></div>
                    <div class="step-content">
                        <h3>Curated Identity &amp; Network Building</h3>
                        <p>
                            Reconnect with classmates, join your cohort's digital space,
                            and map professional skills visible only to verified peers.
                        </p>
                    </div>
                </article>
                <article role="listitem" class="timeline-step">
                    <div class="step-number"><span>03</span></div>
                    <div class="step-content">
                        <h3>Discover Opportunities Tailored to You</h3>
                        <p>
                            Find mentorships, jobs, and business partnerships within
                            your alumni network. Support fellow graduates by purchasing
                            from their verified ventures.
                        </p>
                    </div>
                </article>
                <article role="listitem" class="timeline-step">
                    <div class="step-number"><span>04</span></div>
                    <div class="step-content">
                        <h3>Ethical Monetization</h3>
                        <p>
                            Offer your own services or products. Transactions are
                            secure, with a small percentage going back to support
                            community initiatives.
                        </p>
                    </div>
                </article>
            </div>
        </div>
    </section>

    <!-- Marketplace Section -->
    <section id="marketplace-section" role="region" aria-labelledby="alum-market-title">
        <div class="marketplace-container">
            <header class="marketplace-header">
                <h2 id="alum-market-title">Alumni Marketplace — Ethical Opportunities</h2>
                <p class="marketplace-intro">
                    Discover curated offerings from verified alumni: professional courses, mentorship packages, and legacy products.
                </p>
            </header>
            
            <!-- Featured Cards -->
            <div role="list" aria-label="Featured marketplace offerings" class="marketplace-carousel">
                <article role="listitem" class="marketplace-featured-card">
                    <div class="featured-card-image">
                        <img src="https://images.pexels.com/photos/5940703/pexels-photo-5940703.jpeg?auto=compress&amp;cs=tinysrgb&amp;w=1500" alt="Mentorship" loading="lazy" />
                        <div class="featured-card-overlay"></div>
                    </div>
                    <div class="featured-card-content">
                        <div class="featured-badge">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24">
                                <path fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 6L9 17l-5-5"></path>
                            </svg>
                            <span>Verified Instructor</span>
                        </div>
                        <h3>Executive Micro-Course</h3>
                        <p>Strategy for Emerging Markets.</p>
                        <a href="view/listings.php"><div role="button" class="btn btn-primary btn-sm"><span>Enroll Now</span></div></a>
                    </div>
                </article>
                <article role="listitem" class="marketplace-featured-card">
                    <div class="featured-card-image">
                        <img src="https://images.pexels.com/photos/4342493/pexels-photo-4342493.jpeg?auto=compress&amp;cs=tinysrgb&amp;w=1500" alt="Career Clinic" loading="lazy" />
                        <div class="featured-card-overlay"></div>
                    </div>
                    <div class="featured-card-content">
                        <div class="featured-badge">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24">
                                <path fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 6L9 17l-5-5"></path>
                            </svg>
                            <span>Institution Verified</span>
                        </div>
                        <h3>Career Clinics</h3>
                        <p>Resume &amp; Interview Audit sessions.</p>
                        <a href="view/listings.php"><div role="button" class="btn btn-primary btn-sm"><span>Book Session</span></div></a>
                    </div>
                </article>
            </div>

            <div class="marketplace-cta-block">
                <h3>Ready to explore opportunities?</h3>
                <a href="view/listings.php">
                    <div role="button" aria-label="Browse full marketplace" class="btn btn-primary btn-lg">
                        <span>Browse Marketplace</span>
                    </div>
                </a>
            </div>
        </div>
    </section>

    <!-- Impact Metrics Section -->
    <section id="impact-metrics-section" role="region" aria-labelledby="impact-trust-heading">
        <div class="impact-metrics-container">
            <div class="impact-lead">
                <h2 id="impact-trust-heading">Trusted by Alumni, Validated by Institutions</h2>
                <p class="impact-supporting">
                    Real outcomes, verified data, and ethical practices that drive impact.
                </p>
            </div>
            <div class="metrics-row">
                <article role="group" aria-labelledby="metric-1" class="metric-card">
                    <div id="metric-1" class="metric-number"><span>120k+</span></div>
                    <div class="metric-label"><span>Verified alumni profiles across 85 institutions.</span></div>
                </article>
                <article role="group" aria-labelledby="metric-4" class="metric-card">
                    <div id="metric-4" class="metric-number"><span>$4.6M</span></div>
                    <div class="metric-label"><span>In ethically generated alumni revenue.</span></div>
                </article>
                <article role="group" aria-labelledby="metric-6" class="metric-card">
                    <div id="metric-6" class="metric-number"><span>99.7%</span></div>
                    <div class="metric-label"><span>Data-accuracy score via continuous verification.</span></div>
                </article>
            </div>
        </div>
    </section>

    <div class="home-container20">
        <div class="home-container21">
            <style>
                @keyframes heroFadeIn {to {opacity: 1; transform: translateY(0);}}
                @keyframes heroVisualFadeIn {to {opacity: 1; transform: translateY(0);}}
                @keyframes cardReveal {to {opacity: 1; transform: translateY(0);}}
                @keyframes carouselReveal {to {opacity: 1; transform: translateY(0);}}
                @keyframes stepReveal {to {opacity: 1; transform: translateY(0);}}
                @keyframes metricReveal {to {opacity: 1; transform: translateY(0);}}
            </style>
        </div>
    </div>
    
    <div class="home-container22">
        <div class="home-container23">
            <script defer="" data-name="homepage-interactions">
                document.addEventListener('DOMContentLoaded', function() {
                    // Intersection Observer for scroll-triggered animations
                    const observerOptions = { root: null, rootMargin: "0px", threshold: 0.1 };
                    const animateOnScroll = new IntersectionObserver(function (entries) {
                        entries.forEach(function (entry) {
                            if (entry.isIntersecting) {
                                entry.target.style.opacity = "1";
                                entry.target.style.transform = "translateY(0)";
                            }
                        });
                    }, observerOptions);

                    const cards = document.querySelectorAll(".identity-card, .marketplace-featured-card, .metric-card");
                    cards.forEach(function (card) {
                        animateOnScroll.observe(card);
                    });
                });
            </script>
        </div>
    </div>
</div>

<?php
// 3. Include the Footer
include 'view/footer.php';
?>
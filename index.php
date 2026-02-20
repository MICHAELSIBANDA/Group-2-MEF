<?php
  $currentYear = date("Y");
  $siteName = "Make Education Fashionable";
  $siteAbbr = "MEF";
  $contactEmail = "info@mef.org.za";

  $navLinks = [
    ["label" => "Home",         "href" => "#home"],
    ["label" => "About",        "href" => "#about"],
    ["label" => "Impact",       "href" => "#impact"],
    ["label" => "Testimonials", "href" => "#stories"],
    ["label" => "Contact",      "href" => "#contact"],
  ];

  $stats = [
    ["value" => "10K+", "label" => "Students Inspired"],
    ["value" => "50+",  "label" => "Campuses Reached"],
    ["value" => "200+", "label" => "Success Stories"],
    ["value" => "15+",  "label" => "Partner Organisations"],
  ];

  $stories = [
    [
      "name"     => "Naledi Mokoena",
      "title"    => "From Township Dreamer to Tech Professional",
      "location" => "Soshanguve, South Africa",
      "field"    => "Informatics",
      "excerpt"  => "Naledi grew up sharing textbooks and studying without reliable internet access. Long taxi rides and financial pressure made university feel impossible &mdash; but she refused to quit.",
      "full"     => [
        "Naledi grew up sharing textbooks and studying without reliable internet access. Long taxi rides and financial pressure made university feel impossible &mdash; but she refused to quit.",
        "She spent late nights in campus labs, learned coding through free online resources, and built small websites for local businesses. By her final year, she developed a student budgeting app that impressed her lecturers.",
        "Today, Naledi works as a Junior Software Developer in Johannesburg.",
      ],
      "quote"    => "Your background does not define your future. Education upgrades your life.",
    ],
    [
      "name"     => "Ayesha Daniels",
      "title"    => "The Shy Student Who Became a Leader",
      "location" => "Cape Town",
      "field"    => "Business Management",
      "excerpt"  => "In her first year, Ayesha failed a presentation because she was too shy to speak in front of her classmates. She considered changing courses &mdash; or quitting.",
      "full"     => [
        "In her first year, Ayesha failed a presentation because she was too shy to speak in front of her classmates. She considered changing courses &mdash; or quitting.",
        "Instead, she joined a debate club, attended mentorship sessions, and practiced public speaking every week. Slowly, confidence replaced fear.",
        "Today, she works as a Project Coordinator managing teams and leading meetings confidently.",
      ],
      "quote"    => "Growth starts where comfort ends.",
    ],
    [
      "name"     => "Thabo Nkosi",
      "title"    => "The Comeback Graduate",
      "location" => "Gauteng",
      "field"    => "Marketing",
      "excerpt"  => "After failing two modules due to financial and family pressure, Thabo thought his academic journey was over.",
      "full"     => [
        "After failing two modules due to financial and family pressure, Thabo thought his academic journey was over.",
        "Instead of dropping out, he applied for academic support, rewrote his exams, and studied before sunrise while working part-time. He graduated one year later than planned &mdash; but stronger than ever.",
        "Today, Thabo owns a digital marketing agency serving small businesses.",
      ],
      "quote"    => "Delay is not defeat. Success still looks good on you.",
    ],
  ];

  $socialLinks = [
    ["label" => "Facebook",  "href" => "https://facebook.com/kgethi.phakeng",         "icon" => "facebook"],
    ["label" => "Twitter",   "href" => "https://twitter.com/@FabAcademic",             "icon" => "twitter"],
    ["label" => "LinkedIn",  "href" => "https://linkedin.com/in/mamokgethiphakeng",    "icon" => "linkedin"],
  ];

  
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <meta name="description" content="A South African social movement rebranding academic excellence. Celebrating education, inspiring futures, and making achievement fashionable." />
  <title><?php echo htmlspecialchars($siteName); ?> | <?php echo $siteAbbr; ?></title>

  /*
  <!-- Google Fonts -->
  <link rel="preconnect" href="https://fonts.googleapis.com" />
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=Playfair+Display:wght@700&display=swap" rel="stylesheet" />
 */
  <!-- Stylesheet -->
  <link rel="stylesheet" href="/styles/styles.css" />
</head>
<body>


  <!-- ========== HEADER ========== -->
  <!-- ============================ -->
 <header class="site-header" role="banner">
  <div class="header-inner">
    <!-- UPDATED LOGO -->
    <a href="#home" class="logo" aria-label="<?php echo $siteAbbr; ?> Home">
      <img src="/images/logos.png" alt="<?php echo htmlspecialchars($siteName); ?> logo" />
    </a>

    <nav class="nav-desktop" aria-label="Main navigation">
      <?php foreach ($navLinks as $link): ?>
        <a href="<?php echo $link['href']; ?>"><?php echo $link['label']; ?></a>
      <?php endforeach; ?>
      <a href="#contact" class="nav-cta">Join Movement</a>
    </nav>

    <button class="mobile-toggle" aria-label="Open menu" aria-expanded="false" onclick="toggleMenu()">
      <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" id="menu-icon">
        <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16" />
      </svg>
      <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" id="close-icon" style="display:none;">
        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
      </svg>
    </button>
  </div>

    <nav class="mobile-nav" id="mobileNav" aria-label="Mobile navigation">
      <?php foreach ($navLinks as $link): ?>
        <a href="<?php echo $link['href']; ?>" onclick="closeMenu()"><?php echo $link['label']; ?></a>
      <?php endforeach; ?>
      <a href="#contact" class="nav-cta" onclick="closeMenu()">Join Movement</a>
    </nav>
  </header>

  <main>

    <!-- ========== HERO ========== -->
    <!-- ========================== -->
    <section id="home" class="hero">
      <img class="hero-bg" src="/images/grad.jpg" alt="" />
      <div class="hero-overlay"></div>

      <div class="hero-content">
        <p class="hero-label">A South African Social Movement</p>
        <h1 class="hero-title">Making Education Fashionable</h1>
        <p class="hero-subtitle">
          Rebranding excellence for social impact. Celebrating education, inspiring futures, and turning learning into a lifestyle.
        </p>
        <div class="hero-actions">
          <a href="#contact" class="btn btn--accent">Join the Movement</a>
          <a href="#about" class="btn btn--outline-light">Learn More</a>
        </div>
      </div>

      <div class="hero-scroll" aria-hidden="true">
        <div class="hero-scroll-pill">
          <div class="hero-scroll-dot"></div>
        </div>
      </div>
    </section>

    <!-- ========== ABOUT ========== -->
    <!-- =========================== -->
    <section id="about" class="about">
      <div class="container">
        <div class="about-header">
          <span class="section-label">Who We Are</span>
          <h2 class="section-title">About The Movement</h2>
          <hr class="section-divider section-divider--center" />
        </div>

        <div class="about-grid">
          <!-- Image -->
          <div class="about-image-wrap">
            <div class="about-image">
              <img src="/images/Prof.jpg" alt="Professor in academic regalia celebrating education" />
            </div>
            <div class="about-image-accent" aria-hidden="true"></div>
          </div>

          <!-- Text -->
          <div class="about-text">
            <p>
              <?php echo $siteAbbr; ?> is a South African social movement that &ldquo;rebrands&rdquo; academic excellence. It is an initiative that uses the glamour of fashion and celebrity culture to make graduation and literacy the ultimate status symbols.
            </p>
            <p>
              By showcasing real student stories of overcoming adversity, <?php echo $siteAbbr; ?> aims to inspire and empower young people to pursue their education with pride and confidence. We believe that when education is fashionable, success becomes a lifestyle.
            </p>

            <div class="about-features">
              <!-- Mission -->
              <div class="about-feature">
                <div class="about-feature-icon">
                  <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="var(--color-primary)"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/></svg>
                </div>
                <div>
                  <h3>Our Mission</h3>
                  <p>To shift the youth&apos;s perception of education from &ldquo;boring&rdquo; to &ldquo;aspirational&rdquo; by celebrating academic achievement with the same energy as pop culture.</p>
                </div>
              </div>

              <!-- Vision -->
              <div class="about-feature">
                <div class="about-feature-icon about-feature-icon--accent">
                  <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="var(--color-accent)"><path d="M22 10v6M2 10l10-5 10 5-10 5z"/><path d="M6 12v5c3 3 9 3 12 0v-5"/></svg>
                </div>
                <div>
                  <h3>Our Vision</h3>
                  <p>To see a generation where academic regalia is as trendy as designer streetwear, and where intellectual achievement is celebrated on the red carpet.</p>
                </div>
              </div>

              <!-- Community -->
              <div class="about-feature">
                <div class="about-feature-icon">
                  <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="var(--color-primary)"><path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M22 21v-2a4 4 0 0 0-3-3.87M16 3.13a4 4 0 0 1 0 7.75"/></svg>
                </div>
                <div>
                  <h3>Our Community</h3>
                  <p>A growing network of students, graduates, and mentors across South Africa who champion education as the most fashionable pursuit.</p>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>


    <!-- ========== IMPACT ========== -->
    <!-- ========== SECTION ========= -->
    <section id="impact" class="impact">
      <div class="container">
        <div class="impact-grid">

          <!-- Text + Stats -->
          <div class="impact-text">
            <span class="section-label">Our Impact</span>
            <h2 class="section-title">Transforming Lives Through Education</h2>
            <p class="impact-description">
              Across South Africa, we are proving that education can be the ultimate status symbol. Through events, mentorship, and storytelling, <?php echo $siteAbbr; ?> is building a movement where young people see academic success as the most aspirational path forward.
            </p>

            <div class="stats-grid">
              <?php foreach ($stats as $stat): ?>
                <div class="stat-card">
                  <p class="stat-value"><?php echo $stat['value']; ?></p>
                  <p class="stat-label"><?php echo $stat['label']; ?></p>
                </div>
              <?php endforeach; ?>
            </div>
          </div>
        </div>
      </div>
    </section>


    <!-- ========== TESTIMONIALS ========== -->
    <!-- ========== SECTION AREA ========== -->
    <section id="stories" class="testimonials">
      <div class="container">
        <div class="testimonials-header">
          <span class="section-label">Real Stories</span>
          <h2 class="section-title">Testimonials</h2>
          <hr class="section-divider section-divider--center" />
          <p class="sub">
            Every graduate has a story of perseverance. These are just a few of the remarkable journeys that prove education is worth every sacrifice.
          </p>
        </div>

        <div class="testimonials-grid">
          <?php foreach ($stories as $story): ?>
            <div class="story-card">
              <div class="story-card-icon">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                  <path d="M3 21c3 0 7-1 7-8V5c0-1.25-.756-2.017-2-2H4c-1.25 0-2 .75-2 1.972V11c0 1.25.75 2 2 2 1 0 1 0 1 1v1c0 1-1 2-2 2s-1 .008-1 1.031V21z"/>
                  <path d="M15 21c3 0 7-1 7-8V5c0-1.25-.757-2.017-2-2h-4c-1.25 0-2 .75-2 1.972V11c0 1.25.75 2 2 2h.75c0 2.25.25 4-2.75 4v3c0 1 0 1 1 1z"/>
                </svg>
              </div>

              <h3><?php echo htmlspecialchars($story['name']); ?></h3>
              <p class="story-title"><?php echo htmlspecialchars($story['title']); ?></p>

              <div class="story-meta">
                <span>
                  <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path d="M20 10c0 6-8 12-8 12s-8-6-8-12a8 8 0 0 1 16 0Z"/><circle cx="12" cy="10" r="3"/></svg>
                  <?php echo htmlspecialchars($story['location']); ?>
                </span>
                <span>
                  <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path d="M4 19.5v-15A2.5 2.5 0 0 1 6.5 2H20v20H6.5a2.5 2.5 0 0 1 0-5H20"/></svg>
                  <?php echo htmlspecialchars($story['field']); ?>
                </span>
              </div>

              <p class="story-excerpt"><?php echo $story['excerpt']; ?></p>

              <blockquote>
                <p>&ldquo;<?php echo htmlspecialchars($story['quote']); ?>&rdquo;</p>
                <cite>&mdash; <?php echo htmlspecialchars($story['name']); ?></cite>
              </blockquote>
            </div>
          <?php endforeach; ?>
        </div>
      </div>
    </section>

    <!-- ========== CTA ========== -->
    <!-- ========================= -->
    <section id="contact" class="cta">
      <div class="container">
        <div class="cta-content">
          <span class="section-label">Be Part of the Change</span>
          <h2 class="section-title" style="color: #ffffff;">Join the Movement</h2>
          <p class="cta-desc">
            Whether you are a student, graduate, mentor, or ally of education &mdash; there is a place for you in the <?php echo $siteAbbr; ?> community. Let us make education the most fashionable pursuit of our generation.
          </p>
          <div class="cta-actions">
            <a href="mailto:<?php echo $contactEmail; ?>" class="btn btn--accent">Get in Touch</a>
            <a href="#stories" class="btn btn--outline-white">Read Stories</a>
          </div>
        </div>
      </div>
    </section>

  </main>



  <!-- ========== FOOTER ========== -->
  <!-- ============================ -->
  <footer class="site-footer" role="contentinfo">
    <div class="footer-inner">
      <div class="footer-grid">

        <!-- Brand -->
        <div class="footer-brand">
          <img  src="/images/logos.png" alt="<?php echo htmlspecialchars($siteName); ?> logo" />
          <p>A South African social movement rebranding academic excellence and making education the ultimate status symbol.</p>
        </div>

        <!-- Quick Links -->
        <div>
          <h3 class="footer-heading">Quick Links</h3>
          <nav class="footer-links" aria-label="Footer navigation">
            <?php foreach ($navLinks as $link): ?>
              <a href="<?php echo $link['href']; ?>"><?php echo $link['label']; ?></a>
            <?php endforeach; ?>
          </nav>
        </div>

        <!-- Social -->
        <div>
          <h3 class="footer-heading">Connect With Us</h3>
          <div class="social-links">
            <?php foreach ($socialLinks as $social): ?>
              <a
                href="<?php echo $social['href']; ?>"
                target="_blank"
                rel="noopener noreferrer"
                aria-label="<?php echo $social['label']; ?>"
                class="social-link"
              >
                <?php if ($social['icon'] === 'facebook'): ?>
                  <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path d="M18 2h-3a5 5 0 0 0-5 5v3H7v4h3v8h4v-8h3l1-4h-4V7a1 1 0 0 1 1-1h3z"/></svg>
                <?php elseif ($social['icon'] === 'twitter'): ?>
                  <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path d="M22 4s-.7 2.1-2 3.4c1.6 10-9.4 17.3-18 11.6 2.2.1 4.4-.6 6-2C3 15.5.5 9.6 3 5c2.2 2.6 5.6 4.1 9 4-.9-4.2 4-6.6 7-3.8 1.1 0 3-1.2 3-1.2z"/></svg>
                <?php elseif ($social['icon'] === 'linkedin'): ?>
                  <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path d="M16 8a6 6 0 0 1 6 6v7h-4v-7a2 2 0 0 0-2-2 2 2 0 0 0-2 2v7h-4v-7a6 6 0 0 1 6-6z"/><rect width="4" height="12" x="2" y="9"/><circle cx="4" cy="4" r="2"/></svg>
                <?php endif; ?>
              </a>
            <?php endforeach; ?>
          </div>
          <div class="footer-contact">
            <p>South Africa</p>
          </div>
        </div>
      </div>

      <div class="footer-bottom">
        <p>&copy; <?php echo $currentYear; ?> <?php echo htmlspecialchars($siteName); ?>. All rights reserved.</p>
      </div>
    </div>
  </footer>

  <!-- Minimal vanilla JS for mobile menu toggle only -->
  <script>
    function toggleMenu() {
      var nav = document.getElementById('mobileNav');
      var menuIcon = document.getElementById('menu-icon');
      var closeIcon = document.getElementById('close-icon');
      var btn = document.querySelector('.mobile-toggle');
      var isOpen = nav.classList.contains('active');

      if (isOpen) {
        nav.classList.remove('active');
        menuIcon.style.display = '';
        closeIcon.style.display = 'none';
        btn.setAttribute('aria-expanded', 'false');
        btn.setAttribute('aria-label', 'Open menu');
      } else {
        nav.classList.add('active');
        menuIcon.style.display = 'none';
        closeIcon.style.display = '';
        btn.setAttribute('aria-expanded', 'true');
        btn.setAttribute('aria-label', 'Close menu');
      }
    }

    function closeMenu() {
      var nav = document.getElementById('mobileNav');
      var menuIcon = document.getElementById('menu-icon');
      var closeIcon = document.getElementById('close-icon');
      var btn = document.querySelector('.mobile-toggle');
      nav.classList.remove('active');
      menuIcon.style.display = '';
      closeIcon.style.display = 'none';
      btn.setAttribute('aria-expanded', 'false');
      btn.setAttribute('aria-label', 'Open menu');
    }
  </script>

</body>
</html>

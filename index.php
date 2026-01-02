<?php echo '<!DOCTYPE html>'; ?>
<html lang="en">

<head>
    <link rel="icon" type="image/png" sizes="32x32" href="assets/images/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="assets/images/favicon-16x16.png">
    <link rel="apple-touch-icon" sizes="180x180" href="assets/images/apple-touch-icon.png">
    <link rel="icon" href="assets/images/favicon.ico" type="image/x-icon">
    <script type="application/ld+json">
    {
      "@context": "https://schema.org",
      "@type": "Organization",
      "name": "Proma Africa",
      "url": "https://promaafrica.com",
      "logo": "https://promaafrica.com/assets/images/2.png"
    }
    </script>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=5.0, user-scalable=yes">
    <meta name="theme-color" content="#f6ae01">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">

    <title>Proma Africa - Leading Property Survey & Real Estate Consultancy in Tanzania</title>

    <meta name="description"
        content="Proma Africa: A trusted leader in Property Survey, land administration, real estate services, and resettlement consultancy. Serving corporations, individuals, and government organizations across Tanzania and Africa.">

    <meta name="keywords"
        content="Proma Africa, Property Survey Tanzania, land surveying Tanzania, real estate Tanzania, resettlement consultancy Africa, land administration Tanzania, asset management Tanzania, property management Tanzania">

    <meta name="author" content="Proma Africa">

    <meta property="og:title" content="Proma Africa - Leading Property Survey & Real Estate Consultancy">
    <meta property="og:description"
        content="A trusted leader in Property Survey, land administration, real estate services, and resettlement consultancy across Tanzania and Africa.">
    <meta property="og:image" content="assets/images/2.png">
    <meta property="og:url" content="https://promaafrica.com/index.php">
    <meta property="og:type" content="website">
    <meta property="og:locale" content="en_TZ">
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="Proma Africa - Leading Property Survey & Real Estate Consultancy">
    <meta name="twitter:description"
        content="A trusted leader in Property Survey, land administration, real estate services, and resettlement consultancy across Tanzania and Africa.">
    <meta name="twitter:image" content="assets/images/2.png">
    <link rel="canonical" href="https://promaafrica.com/index.php">
    <link rel="stylesheet" href="assets/css/stylesss.css">
    <link rel="stylesheet" href="assets/css/text-justify-updates.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@8/swiper-bundle.min.css" />
    <style>
/* Base styles */
:root {
  --primary-color: #f6ae01;
  --primary-hover: #e29f01;
  --secondary-color: #0056b3;
  --text-dark: #333;
  --text-medium: #555;
  --text-light: #777;
  --bg-light: #f9f9f9;
  --bg-white: #fff;
  --shadow-sm: 0 2px 6px rgba(0, 0, 0, 0.1);
  --shadow-md: 0 5px 15px rgba(0, 0, 0, 0.05);
  --shadow-lg: 0 15px 30px rgba(0, 0, 0, 0.1);
  --border-radius-sm: 5px;
  --border-radius-md: 8px;
  --border-radius-lg: 10px;
  --border-radius-xl: 50px;
  --transition-fast: 0.2s ease;
  --transition-normal: 0.3s ease;
  --transition-slow: 0.4s ease;
  --font-size-xs: 0.8rem;
  --font-size-sm: 0.9rem;
  --font-size-md: 1rem;
  --font-size-lg: 1.1rem;
  --font-size-xl: 1.5rem;
  --font-size-2xl: 2rem;
  --font-size-3xl: 2.5rem;
  --font-size-4xl: 3rem;
  --spacing-xs: 5px;
  --spacing-sm: 10px;
  --spacing-md: 15px;
  --spacing-lg: 20px;
  --spacing-xl: 30px;
  --spacing-2xl: 40px;
  --spacing-3xl: 60px;
  --container-padding: 20px;
  --header-height: 70px;
  font-family: "Gill Sans MT", sans-serif;
}

.container {
  max-width: 1200px;
  margin: 0 auto;
  padding: 0 var(--container-padding);
}

/* Company Hero Section */
.company-hero {
  position: relative;
  min-height: 90vh;
  display: flex;
  align-items: center;
  justify-content: center;
  text-align: center;
  color: var(--bg-white);
  margin-top: var(--header-height);
  overflow: hidden;
}

.company-hero-background {
  position: absolute;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  background: linear-gradient(rgba(0, 0, 0, 0.6), rgba(0, 0, 0, 0.4)), url('assets/images/b7.jpg');
  background-size: cover;
  background-position: center;
  background-attachment: fixed;
  z-index: 0;
}

.company-hero-content {
  position: relative;
  z-index: 1;
  max-width: 900px;
  padding: var(--spacing-3xl) var(--container-padding);
}

.company-hero .hero-main-text {
  font-size: clamp(2rem, 4.2vw, 3.5rem);
  font-weight: 400;
  line-height: 1.5;
  color: var(--bg-white);
  max-width: 95%;
  margin: 0 auto var(--spacing-3xl);
  letter-spacing: 1.5px;
  text-transform: none;
  text-shadow: 2px 2px 12px rgba(0, 0, 0, 0.8);
  font-family: 'Gill Sans MT', 'Segoe UI', sans-serif;
  text-align: center;
  overflow: visible;
  word-wrap: break-word;
}

.company-hero .hero-main-text .hero-accent {
  color: var(--primary-color);
  font-weight: 700;
  text-shadow: 
    0 0 15px rgba(246, 174, 1, 0.6),
    0 0 25px rgba(246, 174, 1, 0.4),
    2px 2px 8px rgba(0, 0, 0, 0.8);
  position: relative;
  display: inline-block;
  padding: 0 4px;
  transition: all 0.3s ease;
}

.company-hero .hero-main-text .hero-accent:hover {
  transform: translateY(-2px);
  text-shadow: 
    0 0 20px rgba(246, 174, 1, 0.8),
    0 0 30px rgba(246, 174, 1, 0.5),
    2px 2px 10px rgba(0, 0, 0, 0.8);
}

.company-hero .hero-main-text .hero-accent::before {
  content: '';
  position: absolute;
  bottom: -2px;
  left: 0;
  width: 100%;
  height: 2px;
  background: linear-gradient(90deg, transparent, var(--primary-color), transparent);
  opacity: 0.6;
  transform: scaleX(0);
  transform-origin: center;
  transition: transform 0.4s ease;
}

.company-hero:hover .hero-main-text .hero-accent::before {
  transform: scaleX(1);
}

.hero-buttons {
  display: flex;
  flex-wrap: wrap;
  gap: var(--spacing-md);
  justify-content: center;
  margin-top: var(--spacing-2xl);
}

.btn-hero {
  display: inline-flex;
  align-items: center;
  gap: 0.5rem;
  padding: 15px 30px;
  border-radius: var(--border-radius-xl);
  font-size: var(--font-size-md);
  font-weight: 600;
  text-decoration: none;
  transition: all var(--transition-normal);
  border: 2px solid;
}

.btn-hero.btn-primary {
  background: var(--primary-color);
  color: var(--bg-white);
  border-color: var(--primary-color);
}

.btn-hero.btn-primary:hover {
  background: var(--primary-hover);
  border-color: var(--primary-hover);
  transform: translateY(-3px);
  box-shadow: 0 6px 20px rgba(246, 174, 1, 0.4);
}

.btn-hero.btn-secondary {
  background: transparent;
  color: var(--bg-white);
  border-color: var(--bg-white);
}

.btn-hero.btn-secondary:hover {
  background: var(--bg-white);
  color: var(--text-dark);
  transform: translateY(-3px);
  box-shadow: 0 6px 20px rgba(255, 255, 255, 0.3);
}

/* Properties Showcase Section */
.properties-showcase {
  padding: var(--spacing-3xl) 0;
  background-color: var(--bg-light);
}

.properties-showcase h2 {
  text-align: center;
  font-size: var(--font-size-3xl);
  color: var(--text-dark);
  margin-bottom: var(--spacing-2xl);
  font-weight: 700;
}

.properties-grid-locations {
  display: grid;
  grid-template-columns: repeat(3, 1fr);
  gap: var(--spacing-lg);
}

.property-location-card {
  background-color: var(--bg-white);
  border-radius: var(--border-radius-md);
  box-shadow: var(--shadow-md);
  overflow: hidden;
  transition: transform var(--transition-normal), box-shadow var(--transition-normal);
  display: flex;
  flex-direction: column;
}

.property-location-card:hover {
  transform: translateY(-5px);
  box-shadow: var(--shadow-lg);
}

.property-location-card-image img {
  width: 100%;
  height: 200px;
  object-fit: cover;
  display: block;
}

.property-location-card-content {
  padding: var(--spacing-md);
  flex-grow: 1;
  display: flex;
  flex-direction: column;
}

.property-location-card-content h3 {
  font-size: var(--font-size-xl);
  color: var(--text-dark);
  margin-bottom: var(--spacing-sm);
  font-weight: 600;
}

.property-location-card-content p {
  font-size: var(--font-size-md);
  color: var(--text-medium);
  margin-bottom: var(--spacing-md);
  line-height: 1.6;
  flex-grow: 1;
}

.btn-view-properties {
  display: inline-flex;
  align-items: center;
  justify-content: center;
  padding: var(--spacing-sm) var(--spacing-md);
  background-color: var(--primary-color);
  color: var(--bg-white);
  font-size: var(--font-size-md);
  font-weight: 500;
  border-radius: var(--border-radius-sm);
  text-decoration: none;
  transition: background-color var(--transition-fast);
  margin-top: auto;
}

.btn-view-properties i {
  margin-left: var(--spacing-xs);
}

.btn-view-properties:hover {
  background-color: var(--primary-hover);
}

/* Responsive Design */
@media (max-width: 992px) {
  .properties-grid-locations {
    grid-template-columns: repeat(2, 1fr);
  }
}

@media (max-width: 768px) {
  .company-hero {
    min-height: 70vh;
  }

  .company-hero .hero-main-text {
    font-size: clamp(1.4rem, 4.5vw, 2rem);
    padding: 0 15px;
    margin-bottom: var(--spacing-2xl);
    letter-spacing: 0.8px;
    white-space: normal;
    line-height: 1.5;
    max-width: 100%;
  }

  .company-hero .hero-main-text .hero-accent {
    padding: 0 2px;
  }

  .company-hero .hero-main-text .hero-accent::before {
    height: 1.5px;
    bottom: -1px;
  }

  .hero-buttons {
    flex-direction: column;
    align-items: stretch;
    gap: var(--spacing-sm);
    padding: 0 20px;
  }

  .btn-hero {
    width: 100%;
    justify-content: center;
  }
  
  .properties-grid-locations {
    grid-template-columns: 1fr;
  }

  .property-location-card-image img {
    height: 220px;
  }
}
    </style>
</head>

<body>
    <!-- Preloader -->
    <div class="preloader">
        <div class="loader"></div>
    </div>

    <!-- Custom Cursor -->
    <div class="custom-cursor"></div>

    <!-- Progress Bar -->
    <div class="progress-bar"></div>

    <?php include 'includes/navbar.php'; ?>

    <!-- Company Hero Section -->
    <section class="company-hero">
        <div class="company-hero-background"></div>
        <div class="company-hero-content">
            <h1 class="hero-main-text" data-aos="fade-up">
                Transforming <span class="hero-accent">property</span>, <span class="hero-accent">land</span> & <span class="hero-accent">real estate</span> consultancy across <span class="hero-accent">Africa</span>.
            </h1>
            <div class="hero-buttons" data-aos="fade-up" data-aos-delay="200">
                <a href="about.php" class="btn-hero btn-primary">
                    <i class="fas fa-info-circle"></i>
                    About Us
                </a>
                <a href="contact.php" class="btn-hero btn-secondary">
                    <i class="fas fa-phone"></i>
                    Get in Contact
                </a>
            </div>
        </div>
    </section>



    <!-- New Section: What Sets Us Apart -->
    <section id="what-sets-us-apart" class="what-sets-us-apart">
        <div class="container">
            <h2 data-aos="fade-up">What makes us different</h2>
            <div class="apart-grid">
                <div class="apart-card" data-aos="fade-up" data-aos-delay="100">
                    <div class="apart-card-image">
                        <img src="assets/images/w1.jpg" alt="Due Diligence & Market Analysis" loading="lazy">
                    </div>
                    <div class="apart-card-icon-overlay">
                        <i class="fas fa-chart-line"></i>
                    </div>
                    <div class="apart-card-content">
                        <h3 style="text-transform: none;">Due Diligence & Market Analysis</h3>
                        <p>We perform in-depth research on each property, highlighting its advantages and potential problems. Our comprehensive market analysis delivers essential insights to help you make informed decisions, including current trends and opportunities.</p>
                    </div>
                </div>
                <div class="apart-card" data-aos="fade-up" data-aos-delay="200">
                    <div class="apart-card-image">
                        <img src="assets/images/w2.jpg" alt="After-Sales Support" loading="lazy">
                    </div>
                    <div class="apart-card-icon-overlay">
                        <i class="fas fa-headset"></i>
                    </div>
                    <div class="apart-card-content">
                        <h3 style="text-transform: none;">After-Sales Support</h3>
                        <p>We provide continuous support after the sale, assisting with everything from relocation to investment management, ensuring you can leverage your new property right away.</p>
                    </div>
                </div>
                <div class="apart-card" data-aos="fade-up" data-aos-delay="400">
                    <div class="apart-card-image">
                        <img src="assets/images/w3.jpg" alt="Personalised Property Search" loading="lazy">
                    </div>
                    <div class="apart-card-icon-overlay">
                        <i class="fas fa-binoculars"></i>
                    </div>
                    <div class="apart-card-content">
                        <h3 style="text-transform: none;">Personalised Property Search</h3>
                        <p>We conduct thorough market research to identify properties that match your specific criteria and investment goals. Leveraging our in-depth knowledge of Tanzania's real estate market & our strong network of top listing agents, we ensure access to the finest properties in prime locations.</p>
                    </div>
                </div>
                <div class="apart-card" data-aos="fade-up" data-aos-delay="500">
                    <div class="apart-card-image">
                        <img src="assets/images/w4.jpg" alt="Property Viewings & Evaluations" loading="lazy">
                    </div>
                    <div class="apart-card-icon-overlay">
                        <i class="fas fa-check-circle"></i>
                    </div>
                    <div class="apart-card-content">
                        <h3 style="text-transform: none;">Property Viewings & Evaluations</h3>
                        <p>We arrange private viewings of shortlisted properties and provide expert evaluations. Our team offers detailed insights, understanding the local nuances to help you make the best decision.</p>
                    </div>
                </div>
                <div class="apart-card" data-aos="fade-up" data-aos-delay="600">
                    <div class="apart-card-image">
                        <img src="assets/images/w5.jpg" alt="Negotiation & Transaction Management" loading="lazy">
                    </div>
                    <div class="apart-card-icon-overlay">
                        <i class="fas fa-briefcase"></i>
                    </div>
                    <div class="apart-card-content">
                        <h3 style="text-transform: none;">Negotiation & Transaction Management</h3>
                        <p>Our expert advisors handle all aspects of the negotiation process, working tirelessly to secure the best possible terms for you, ensuring a smooth transaction from offer submission to closing.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- New Section: Available Properties -->
    <section id="properties-showcase" class="properties-showcase">
        <div class="container">
            <h2 data-aos="fade-up">Available Properties</h2>
            <div class="properties-grid-locations">
                <!-- Tanzania Mainland -->
                <div class="property-location-card" data-aos="fade-up" data-aos-delay="100">
                    <div class="property-location-card-image">
                        <img src="assets/images/b5.jpg" alt="Properties in Tanzania Mainland" loading="lazy">
                    </div>
                    <div class="property-location-card-content">
                        <h3>Tanzania Mainland</h3>
                        <p>Explore a wide range of properties including residential, commercial, and land plots across Tanzania Mainland.</p>
                        <a href="sales.php?location=Dar%20es%20Salaam" class="btn-view-properties">
                            View Mainland Properties <i class="fas fa-arrow-right"></i>
                        </a>
                    </div>
                </div>
                <!-- Zanzibar -->
                <div class="property-location-card" data-aos="fade-up" data-aos-delay="200">
                    <div class="property-location-card-image">
                        <img src="assets/images/b10.jpg" alt="Properties in Zanzibar" loading="lazy">
                    </div>
                    <div class="property-location-card-content">
                        <h3>Zanzibar</h3>
                        <p>Discover exclusive properties and investment opportunities in the beautiful islands of Zanzibar.</p>
                        <a href="sales.php?location=Zanzibar" class="btn-view-properties">
                            View Zanzibar Properties <i class="fas fa-arrow-right"></i>
                        </a>
                    </div>
                </div>
                <!-- Plots and Farms -->
                <div class="property-location-card" data-aos="fade-up" data-aos-delay="300">
                    <div class="property-location-card-image">
                        <img src="assets/images/pf.jpg" alt="Plots and Farms" loading="lazy">
                    </div>
                    <div class="property-location-card-content">
                        <h3>Plots and Farms</h3>
                        <p>Invest in fertile agricultural land, farming estates, and spacious plots for development across Tanzania.</p>
                        <a href="sales.php?property_type=Land" class="btn-view-properties">
                            View Plots & Farms <i class="fas fa-arrow-right"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section id="services" class="services">
        <div class="container">
            <h2 data-aos="fade-up">Our Services</h2>
            <div class="services-grid">
                <div class="service-card" data-aos="fade-up" data-aos-delay="100">
                    <i class="fas fa-balance-scale"></i>
                    <h3>Valuation Advisory Services</h3>
                    <p>Professional advice on estimation of asset monetary worth for personal, private institutions and government use - including machinery, equipment, land, brand survey, intellectual property, technology, and all types of properties.</p>
                    <a href="services.php#survey" class="service-link">Learn More <i class="fas fa-arrow-right"></i></a>
                </div>
                <div class="service-card" data-aos="fade-up" data-aos-delay="300">
                    <i class="fas fa-file-contract"></i>
                    <h3>Land Administration</h3>
                    <p>Expert management of land ownership information including Certificate of Right of Occupancy
                        facilitation and title deed transfer services.</p>
                    <a href="services.php#administration" class="service-link">Learn More <i class="fas fa-arrow-right"></i></a>
                </div>
                <div class="service-card" data-aos="fade-up" data-aos-delay="400">
                    <i class="fas fa-tasks"></i>
                    <h3>Asset Management</h3>
                    <p>Full lifecycle management of organizational assets featuring barcode/QR tracking, asset verification,
                        tracking, and database development services.</p>
                    <a href="services.php#asset" class="service-link">Learn More <i class="fas fa-arrow-right"></i></a>
                </div>
                <div class="service-card" data-aos="fade-up" data-aos-delay="100">
                    <i class="fas fa-building"></i>
                    <h3>Property Investment</h3>
                    <p>Strategic guidance and opportunities for investing in residential, commercial, and industrial properties — tailored for individuals, businesses, and institutional investors seeking sustainable growth and long-term value.</p>
                    <a href="services.php#property-investment" class="service-link">Learn More <i class="fas fa-arrow-right"></i></a>
                </div>
                <div class="service-card" data-aos="fade-up" data-aos-delay="500">
                    <i class="fas fa-building"></i>
                    <h3>Property Management</h3>
                    <p>Professional building management to maximize returns including client acquisition, vendor/tenant
                        lease management, and maintenance services.</p>
                    <a href="services.php#property" class="service-link">Learn More <i class="fas fa-arrow-right"></i></a>
                </div>
                <div class="service-card" data-aos="fade-up" data-aos-delay="700">
                    <i class="fas fa-users"></i>
                    <h3>Resettlement and Livelihood Restoration</h3>
                    <p>Comprehensive consultancy services for resettlement planning, implementation, and livelihood
                        restoration programs, ensuring sustainable outcomes for affected communities.</p>
                    <a href="services.php#resettlement" class="service-link">Learn More <i class="fas fa-arrow-right"></i></a>
                </div>
                <div class="service-card" data-aos="fade-up" data-aos-delay="200">
                    <i class="fas fa-map-marked-alt"></i>
                    <h3>Land Surveying</h3>
                    <p>Comprehensive land measurement services including site inspection, land use planning, zoning &
                        permits assistance, boundaries verification and recovery for all sectors.</p>
                    <a href="services.php#surveying" class="service-link">Learn More <i class="fas fa-arrow-right"></i></a>
                </div>
            </div>
        </div>
    </section>

    <!-- Partners Section -->
    <section class="partners-section" data-aos="fade-up">
        <div class="container">
            <h2>Our Esteemed Stakeholders</h2>
            <div class="partners-grid" id="partnersGrid">
                <!-- Partners will be loaded dynamically via JavaScript -->
            </div>
        </div>
    </section>

    <!-- Contact Section -->
    <section id="contact" class="contact-simplified" data-aos="fade-up">
        <div class="container">
            <h2>Get In Touch</h2>
            <div class="contact-info-simplified">
                <div class="info-item" data-aos="fade-up" data-aos-delay="100">
                    <i class="fas fa-envelope"></i>
                    <p><a href="mailto:info@promaafrica.com">info@promaafrica.com</a></p>
                </div>
                <div class="info-item" data-aos="fade-up" data-aos-delay="200">
                    <i class="fas fa-phone"></i>
                    <p><a href="tel:+255756069451">+255 756 069 451</a></p>
                    <p><a href="tel:+255755989743">+255 755 989 743</a></p>
                </div>
                <div class="info-item" data-aos="fade-up" data-aos-delay="300">
                    <i class="fas fa-map-marker-alt"></i>
                    <p>Dar es Salaam, Tanzania</p>
                </div>
            </div>
        </div>
    </section>

    <div class="floating-social">
        <a href="https://www.linkedin.com/in/proma-africa-09128b35a/" target="_blank" aria-label="LinkedIn"><i class="fab fa-linkedin-in"></i></a>
        <a href="https://www.instagram.com/promaafrica?igsh=MXh0YjlnZng1M2hvcw%3D%3D&utm_source=qr" target="_blank" aria-label="Instagram"><i class="fab fa-instagram"></i></a>
    </div>

    <div class="back-to-top">
        <i class="fas fa-arrow-up"></i>
    </div>

    <?php include 'includes/footer.php'; ?>

    <!-- Add AOS library for scroll animations -->
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <!-- Add Swiper for modern sliders -->
    <script src="https://cdn.jsdelivr.net/npm/swiper@8/swiper-bundle.min.js"></script>

    <script>
        // Initialize AOS with mobile-friendly settings
        AOS.init({
            once: true,
            offset: 50,
            duration: 600,
            delay: 0,
            disable: window.innerWidth < 768 ? 'phone' : false
        });

        // Preloader with reduced timeout for mobile
        window.addEventListener('load', function() {
            const preloader = document.querySelector('.preloader');
            const timeoutDuration = window.innerWidth < 768 ? 300 : 500;
            
            preloader.classList.add('fade-out');
            setTimeout(() => {
                preloader.style.display = 'none';
            }, timeoutDuration);
        });

        // Custom cursor - only for desktop
        const cursor = document.querySelector('.custom-cursor');
        
        if (window.innerWidth > 768) {
            cursor.style.display = 'block';
            
            document.addEventListener('mousemove', (e) => {
                cursor.style.left = e.clientX + 'px';
                cursor.style.top = e.clientY + 'px';
            });

            document.addEventListener('mousedown', () => {
                cursor.classList.add('active');
            });

            document.addEventListener('mouseup', () => {
                cursor.classList.remove('active');
            });

            const interactiveElements = document.querySelectorAll('a, button, .service-card, .info-item, .value-card, .feature-card');
            interactiveElements.forEach(el => {
                el.addEventListener('mouseenter', () => {
                    cursor.classList.add('active');
                });
                el.addEventListener('mouseleave', () => {
                    cursor.classList.remove('active');
                });
            });
        }

        // Optimized hamburger menu for mobile
        const menuIcon = document.getElementById('menuIcon');
        const menuLinks = document.getElementById('menuLinks');
        const closeBtn = document.getElementById('closeBtn');

        if (menuIcon && menuLinks && closeBtn) {
            menuIcon.addEventListener('click', (e) => {
                e.preventDefault();
                menuLinks.classList.add('show');
                document.body.style.overflow = 'hidden';
            });

            closeBtn.addEventListener('click', (e) => {
                e.preventDefault();
                menuLinks.classList.remove('show');
                document.body.style.overflow = '';
            });

            document.addEventListener('click', (event) => {
                if (!menuIcon.contains(event.target) && !menuLinks.contains(event.target) && menuLinks.classList.contains('show')) {
                    menuLinks.classList.remove('show');
                    document.body.style.overflow = '';
                }
            });
        }

        // Partners data
        const partnersData = [
            { logo: "assets/images/p7.jpeg", name: "Wizara ya Ardhi, Nyumba na Maeneeleo ya Makazi" },
            { logo: "assets/images/p1.jpeg", name: "BRELA" },
            { logo: "assets/images/p3.jpeg", name: "TRA" },
            { logo: "assets/images/p2.jpeg", name: "Tanzania Investment Centre" },
            { logo: "assets/images/p4.jpeg", name: "NEMC" },
            { logo: "assets/images/p5.jpeg", name: "Zanzibar Investment Promotion Authority" },
            { logo: "assets/images/p6.jpeg", name: "Bank of Tanzania" }
        ];

        // Function to load partners dynamically
        function loadPartners() {
            const partnersGrid = document.getElementById('partnersGrid');
            const isMobile = window.innerWidth < 768;

            if (!partnersGrid) return;

            partnersGrid.innerHTML = '';

            if (partnersData && partnersData.length > 0) {
                partnersData.forEach((partner, index) => {
                    const partnerItem = document.createElement('div');
                    partnerItem.className = 'partner-item';
                    
                    if (!isMobile) {
                        partnerItem.setAttribute('data-aos', 'fade-up');
                        partnerItem.setAttribute('data-aos-delay', (index * 50).toString());
                    }

                    const img = document.createElement('img');
                    img.loading = "lazy";
                    img.src = partner.logo;
                    img.alt = partner.name + ' Logo';
                    img.className = 'partner-logo';

                    img.onerror = function () {
                        this.src = 'assets/images/placeholder-logo.png';
                        console.log(`Failed to load image for ${partner.name}`);
                    };

                    const namePara = document.createElement('p');
                    namePara.className = 'partner-name';
                    namePara.textContent = partner.name;

                    partnerItem.appendChild(img);
                    partnerItem.appendChild(namePara);
                    partnersGrid.appendChild(partnerItem);
                });
            } else {
                partnersGrid.innerHTML = '<p>No partners information available at the moment.</p>';
            }
        }

        document.addEventListener('DOMContentLoaded', loadPartners);

        // Optimized progress bar for mobile
        let ticking = false;
        window.addEventListener('scroll', () => {
            if (!ticking) {
                window.requestAnimationFrame(() => {
                    const windowHeight = document.documentElement.scrollHeight - document.documentElement.clientHeight;
                    const scrolled = (window.scrollY / windowHeight) * 100;
                    const progressBar = document.querySelector('.progress-bar');
                    if (progressBar) {
                        progressBar.style.width = `${scrolled}%`;
                    }
                    ticking = false;
                });
                ticking = true;
            }
        });

        // Back to top button
        let backToTopTicking = false;
        window.addEventListener('scroll', () => {
            if (!backToTopTicking) {
                window.requestAnimationFrame(() => {
                    const backToTop = document.querySelector('.back-to-top');
                    if (backToTop) {
                        backToTop.classList.toggle('visible', window.scrollY > 300);
                    }
                    backToTopTicking = false;
                });
                backToTopTicking = true;
            }
        });

        const backToTopBtn = document.querySelector('.back-to-top');
        if (backToTopBtn) {
            backToTopBtn.addEventListener('click', () => {
                window.scrollTo({ top: 0, behavior: 'smooth' });
            });

            if ('ontouchstart' in window) {
                backToTopBtn.addEventListener('touchstart', (e) => {
                    e.preventDefault();
                    window.scrollTo({ top: 0, behavior: 'smooth' });
                });
            }
        }

        // Smooth scroll for anchor links
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                const targetId = this.getAttribute('href');
                if (targetId !== '#') {
                    e.preventDefault();
                    const targetElement = document.querySelector(targetId);
                    if (targetElement) {
                        if (menuLinks && menuLinks.classList.contains('show')) {
                            menuLinks.classList.remove('show');
                            document.body.style.overflow = '';
                        }
                        
                        targetElement.scrollIntoView({
                            behavior: 'smooth'
                        });
                    }
                }
            });
        });
    </script>
</body>

</html>
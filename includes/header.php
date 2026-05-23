<?php
// Handle Modal Enquiry Submission
$header_enq_msg = '';
$show_modal = false;
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['submit_header_enquiry'])) {
    require_once __DIR__ . '/../database/config.php';
    $name = mysqli_real_escape_string($conn, trim($_POST['name']));
    $email = mysqli_real_escape_string($conn, trim($_POST['email']));
    $phone = mysqli_real_escape_string($conn, trim($_POST['phone']));
    $message = isset($_POST['message']) ? mysqli_real_escape_string($conn, trim($_POST['message'])) : '';
    $source = "Header Quick Enquiry";

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $header_enq_msg = "<div class='alert alert-danger'><i class='fa-solid fa-circle-exclamation'></i> Please enter a valid email address.</div>";
    } elseif (!preg_match('/^[0-9]{10}$/', $phone)) {
        $header_enq_msg = "<div class='alert alert-danger'><i class='fa-solid fa-circle-exclamation'></i> Mobile number must be exactly 10 digits.</div>";
    } else {
        $sql = "INSERT INTO enquiries (name, email, phone, message, source) VALUES ('$name', '$email', '$phone', '$message', '$source')";
        if (mysqli_query($conn, $sql)) {
            $header_enq_msg = "<div class='alert alert-success'><i class='fa-solid fa-circle-check'></i> Thank you! Our team will contact you soon.</div>";
        } else {
            $header_enq_msg = "<div class='alert alert-danger'><i class='fa-solid fa-circle-exclamation'></i> Error submitting enquiry. Please try again.</div>";
        }
    }
    $show_modal = true;
}

// Fetch Projects for Dropdown
$projects_menu = [];
if (file_exists(__DIR__ . '/../database/config.php')) {
    require_once __DIR__ . '/../database/config.php';
    $proj_sql = "SELECT id, title FROM projects ORDER BY id DESC";
    $proj_res = mysqli_query($conn, $proj_sql);
    if ($proj_res) {
        while ($p = mysqli_fetch_assoc($proj_res)) {
            $projects_menu[] = $p;
        }
    }
}
?>
<!-- SEO JSON-LD Structured Data Schema -->
<script type="application/ld+json">
{
  "@context": "https://schema.org",
  "@type": "RealEstateAgent",
  "name": "GuruGhar Estate",
  "alternateName": "GuruGhar Estate",
  "url": "https://gurugharestate.com",
  "logo": "https://gurugharestate.com/assets/gurgarestates-logo.png",
  "image": "https://gurugharestate.com/assets/gurgarestates-logo.png",
  "description": "GuruGhar Estate is a premier real estate construction and consultancy company in Faridabad, Delhi NCR, delivering high-quality residential homes and premium builder floors.",
  "telephone": "+91-8851404063",
  "email": "gurugharestates@gmail.com",
  "address": {
    "@type": "PostalAddress",
    "streetAddress": "Sector 16",
    "addressLocality": "Faridabad",
    "addressRegion": "Haryana",
    "postalCode": "121002",
    "addressCountry": "IN"
  },
  "contactPoint": [
    {
      "@type": "ContactPoint",
      "telephone": "+91-8851404063",
      "contactType": "sales",
      "areaServed": "IN",
      "availableLanguage": "English"
    },
    {
      "@type": "ContactPoint",
      "telephone": "+91-9999566126",
      "contactType": "consultancy",
      "areaServed": "IN",
      "availableLanguage": "English"
    }
  ],
  "sameAs": [
    "https://www.facebook.com/gurugharestate",
    "https://www.instagram.com/gurugharestate"
  ]
}
</script>

<!-- includes/header.php -->
<link rel="icon" href="assets/favicon.png?v=<?= time() ?>" type="image/png">
<link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700&family=Playfair+Display:wght@500;600;700&family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
<link rel="stylesheet" href="assets/css/header.css?v=<?= time() ?>">

<!-- Slim Premium Top Bar -->
<div class="header-fixed-wrapper" id="header-fixed-wrapper">
    <div class="top-bar" id="top-bar">
        <div class="top-bar-container">
            <div class="top-bar-content">
                <span class="top-bar-tag"><i class="fa-solid fa-location-dot"></i> Location - Faridabad, Haryana India</span>
                <span class="divider">|</span>
                <span class="top-bar-tag"><i class="fa-solid fa-envelope"></i> <a href="mailto:gurugharestates@gmail.com">gurugharestates@gmail.com</a></span>
                <span class="divider">|</span>
                <span class="top-bar-tag"><i class="fa-solid fa-envelope"></i> <a href="mailto:batra.consultants@gmail.com">batra.consultants@gmail.com</a></span>
                <span class="divider">|</span>
                <span class="top-bar-tag"><i class="fa-solid fa-phone"></i> <a href="tel:+918851404063">+91-8851404063</a></span>
                <span class="divider">|</span>
                <span class="top-bar-tag"><i class="fa-solid fa-phone"></i> <a href="tel:+919999566126">+91-9999566126</a></span>
            </div>
        </div>
    </div>

    <header id="main-header" class="header">
        <div class="header-container">

            <!-- Static Left Logo -->
            <div class="logo-container" id="logo-container">
                <a href="index.php">
                    <img src="assets/gurgarestates-logo.png?v=<?= time() ?>" alt="GuruGhar Estates Logo" id="logo-image" onerror="this.onerror=null; this.src='assets/gurgarestates-logo.png';">
                </a>
            </div>

        <!-- Navigation Menu (Centered) -->
        <nav class="main-nav" id="main-nav">
            <div class="nav-links">
                <a href="index.php" class="nav-item <?= strpos($_SERVER['PHP_SELF'], 'index.php') !== false ? 'active' : '' ?>">HOME</a>
                <a href="about-us.php" class="nav-item <?= strpos($_SERVER['PHP_SELF'], 'about-us.php') !== false ? 'active' : '' ?>">ABOUT US</a>

                <div class="nav-dropdown">
                    <a href="#" class="dropdown-toggle nav-item">PROJECTS <i class="fas fa-chevron-down dropdown-caret"></i></a>
                    <div class="dropdown-content">
                        <?php foreach ($projects_menu as $pm): ?>
                            <a href="project-details.php?id=<?= $pm['id'] ?>"><?= htmlspecialchars($pm['title']) ?></a>
                        <?php endforeach; ?>
                        <?php if (empty($projects_menu)): ?>
                            <a href="#">No projects available</a>
                        <?php endif; ?>
                    </div>
                </div>

                <a href="contact-us.php" class="nav-item <?= strpos($_SERVER['PHP_SELF'], 'contact-us.php') !== false ? 'active' : '' ?>">CONTACT US</a>
            </div>
        </nav>

        <!-- Right Side CTA Actions -->
        <div class="header-buttons" id="header-buttons">
            <a href="tel:+918851404063" class="btn btn-outline" title="Call Us Now">
                <i class="fa-solid fa-phone"></i>
                <span class="phone-number-text">+91 88514 04063</span>
            </a>
            <button id="enquireBtn" class="btn btn-primary">Enquire Now</button>
        </div>

        <!-- Mobile Menu Toggle -->
        <div class="mobile-toggle" id="mobile-toggle">
            <div class="hamburger-lines">
                <span class="line line1"></span>
                <span class="line line2"></span>
                <span class="line line3"></span>
            </div>
        </div>
    </div>
</header>
</div>

<!-- Mobile Navigation Drawer -->
<div class="mobile-nav" id="mobile-nav">
    <div class="mobile-nav-header">
        <div class="mobile-logo">
            <img src="assets/gurgarestates-logo.png?v=<?= time() ?>" alt="GuruGhar Estates Logo" onerror="this.onerror=null; this.src='assets/gurgarestates-logo.png';">
        </div>
        <div class="mobile-nav-close" id="mobile-nav-close">
            <i class="fa-solid fa-xmark"></i>
        </div>
    </div>
    
    <ul class="mobile-menu-list">
        <li><a href="index.php" class="<?= strpos($_SERVER['PHP_SELF'], 'index.php') !== false ? 'active' : '' ?>">HOME</a></li>
        <li><a href="about-us.php" class="<?= strpos($_SERVER['PHP_SELF'], 'about-us.php') !== false ? 'active' : '' ?>">ABOUT US</a></li>
        <li class="mobile-dropdown-trigger">
            <a href="javascript:void(0)" class="mobile-dropdown-toggle">PROJECTS <i class="fas fa-chevron-down mobile-caret"></i></a>
            <ul class="mobile-dropdown-content">
                <?php foreach ($projects_menu as $pm): ?>
                    <li><a href="project-details.php?id=<?= $pm['id'] ?>"><?= htmlspecialchars($pm['title']) ?></a></li>
                <?php endforeach; ?>
                <?php if (empty($projects_menu)): ?>
                    <li><a href="#">No projects available</a></li>
                <?php endif; ?>
            </ul>
        </li>
        <li><a href="contact-us.php" class="<?= strpos($_SERVER['PHP_SELF'], 'contact-us.php') !== false ? 'active' : '' ?>">CONTACT US</a></li>
    </ul>
    
    <div class="mobile-actions">
        <a href="tel:+918851404063" class="btn btn-outline mobile-btn"><i class="fa-solid fa-phone"></i> +91 88514 04063</a>
        <button id="mobileEnquireBtn" class="btn btn-primary mobile-btn">Enquire Now</button>
    </div>
</div>

<!-- Enquire Now Modal -->
<div id="headerEnquireModal" class="header-modal <?= $show_modal ? 'show' : '' ?>">
    <div class="header-modal-content">
        <span class="header-modal-close" id="headerModalClose"><i class="fa-solid fa-xmark"></i></span>
        <h2 class="modal-title">Quick Enquiry</h2>
        <p class="modal-subtitle">Leave your details and we will get back to you shortly.</p>

        <?= $header_enq_msg ?>

        <form method="POST" action="">
            <div class="form-group">
                <input type="text" name="name" class="header-form-control" placeholder="Your Full Name" autocomplete="name" required>
            </div>
            <div class="form-group">
                <input type="email" name="email" class="header-form-control" placeholder="Your Email Address" autocomplete="email" required pattern="[a-z0-9._%+\-]+@[a-z0-9.\-]+\.[a-z]{2,}$" title="Please enter a valid email address">
            </div>
            <div class="form-group">
                <input type="tel" name="phone" class="header-form-control" placeholder="Your Phone Number" autocomplete="tel" required pattern="[0-9]{10}" maxlength="10" title="Please enter exactly 10 digits for your mobile number" oninput="this.value = this.value.replace(/[^0-9]/g, '').slice(0, 10);">
            </div>
            <div class="form-group">
                <textarea name="message" class="header-form-control" placeholder="I am interested in... (Optional)" rows="3" autocomplete="off"></textarea>
            </div>
            <button type="submit" name="submit_header_enquiry" class="btn btn-primary w-100">Submit Enquiry</button>
        </form>
    </div>
</div>

<!-- Overlay background for Mobile Nav -->
<div class="mobile-nav-overlay" id="mobile-nav-overlay"></div>

<script>
    document.addEventListener("DOMContentLoaded", () => {
        // Scroll Event for Dynamic Header
        const headerWrapper = document.getElementById("header-fixed-wrapper");
        const header = document.getElementById("main-header");
        const topBar = document.getElementById("top-bar");

        function handleScroll() {
            if (window.scrollY > 40) {
                if (headerWrapper) headerWrapper.classList.add("scrolled");
                header.classList.add("scrolled");
                if (topBar) topBar.classList.add("scrolled");
            } else {
                if (headerWrapper) headerWrapper.classList.remove("scrolled");
                header.classList.remove("scrolled");
                if (topBar) topBar.classList.remove("scrolled");
            }
        }

        window.addEventListener("scroll", handleScroll);
        handleScroll(); // Run once initially

        // Mobile Menu Toggle
        const toggleBtn = document.getElementById("mobile-toggle");
        const closeBtn = document.getElementById("mobile-nav-close");
        const mobileNav = document.getElementById("mobile-nav");
        const overlay = document.getElementById("mobile-nav-overlay");

        function openMobileMenu() {
            mobileNav.classList.add("active");
            overlay.classList.add("active");
            document.body.style.overflow = 'hidden';
        }

        function closeMobileMenu() {
            mobileNav.classList.remove("active");
            overlay.classList.remove("active");
            document.body.style.overflow = 'auto';
        }

        if (toggleBtn) toggleBtn.addEventListener("click", openMobileMenu);
        if (closeBtn) closeBtn.addEventListener("click", closeMobileMenu);
        if (overlay) overlay.addEventListener("click", closeMobileMenu);

        // Mobile Dropdown Toggle
        const mobileDropTrigger = document.querySelector('.mobile-dropdown-trigger > a');
        if (mobileDropTrigger) {
            mobileDropTrigger.addEventListener('click', function (e) {
                e.preventDefault();
                const parent = this.parentElement;
                parent.classList.toggle('active');
                
                // Animate caret rotation
                const caret = this.querySelector('.mobile-caret');
                if (caret) {
                    if (parent.classList.contains('active')) {
                        caret.style.transform = 'rotate(180deg)';
                    } else {
                        caret.style.transform = 'rotate(0deg)';
                    }
                }
            });
        }

        // Modal Logic
        const modal = document.getElementById("headerEnquireModal");
        const openBtn = document.getElementById("enquireBtn");
        const mobileOpenBtn = document.getElementById("mobileEnquireBtn");
        const closeModalBtn = document.getElementById("headerModalClose");

        function openModal() {
            modal.classList.add("show");
            document.body.style.overflow = 'hidden'; // Prevent background scrolling
            closeMobileMenu(); // Close mobile menu if it is open
        }

        function closeModal() {
            modal.classList.remove("show");
            document.body.style.overflow = 'auto';
        }

        if (openBtn) openBtn.addEventListener("click", openModal);
        if (mobileOpenBtn) mobileOpenBtn.addEventListener("click", openModal);
        if (closeModalBtn) closeModalBtn.addEventListener("click", closeModal);

        window.addEventListener("click", (e) => {
            if (e.target == modal) {
                closeModal();
            }
        });
    });
</script>
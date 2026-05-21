<!-- includes/footer.php -->
<link rel="stylesheet" href="assets/css/footer.css?v=<?= time() ?>">

<?php
// Safely ensure the database connection is initialized for footer query
if (!isset($conn)) {
    $config_path = __DIR__ . '/../database/config.php';
    if (file_exists($config_path)) {
        require_once $config_path;
    }
}

$footer_projects = null;
if (isset($conn)) {
    $footer_stmt = $conn->prepare("SELECT id, title FROM projects ORDER BY id DESC LIMIT 5");
    if ($footer_stmt) {
        $footer_stmt->execute();
        $footer_projects = $footer_stmt->get_result();
    }
}
?>

<footer class="footer">
    <!-- Premium Consultation CTA Strip -->
    <div class="footer-cta-strip">
        <div class="footer-cta-container">
            <div class="footer-cta-text">
                <h3>Elevate Your Living Experience</h3>
                <p>Consult with our luxury residential floor experts and build your dream home today.</p>
            </div>
            <div class="footer-cta-action">
                <a href="contact-us.php" class="footer-cta-btn">Book Consultation <i class="fa-solid fa-arrow-right-long"></i></a>
            </div>
        </div>
    </div>

    <div class="footer-container">
        <!-- Top Footer Grid -->
        <div class="footer-grid">

            <!-- Col 1: Branding & Profile -->
            <div class="footer-col branding-col">
                <div class="footer-brand-wrap">
                    <img src="assets/gurgarestates-logo.png?v=<?= time() ?>" alt="Guru Ghar Estate" class="footer-logo" onerror="this.onerror=null; this.src='assets/gurgarestates-logo.png';">
                </div>
                <p class="tagline">Building Dreams, Delivering Luxury</p>
                <p class="desc">Experience the absolute pinnacle of sophisticated living tailored to your expectations. Guru Ghar Estate delivers premium, bespoke residential builder floors across Faridabad and the Delhi NCR region.</p>

                <!-- High-End Tactile Social Widgets -->
                <div class="social-icons-wrapper">
                    <a href="https://www.facebook.com/gurugharestate" target="_blank" class="social-icon" aria-label="Facebook"><i class="fa-brands fa-facebook-f"></i></a>
                    <a href="https://www.instagram.com/gurugharestate" target="_blank" class="social-icon" aria-label="Instagram"><i class="fa-brands fa-instagram"></i></a>
                    <a href="https://wa.me/918851404063" target="_blank" class="social-icon" aria-label="WhatsApp"><i class="fa-brands fa-whatsapp"></i></a>
                </div>
            </div>

            <!-- Col 2: Quick Links -->
            <div class="footer-col links-col">
                <h4 class="col-title">Quick Navigation</h4>
                <ul class="footer-links">
                    <li><a href="index.php"><i class="fa-solid fa-chevron-right"></i> Home</a></li>
                    <li><a href="about-us.php"><i class="fa-solid fa-chevron-right"></i> About Us</a></li>
                    <li><a href="index.php#projects"><i class="fa-solid fa-chevron-right"></i> Featured Portfolio</a></li>
                    <li><a href="index.php#specifications"><i class="fa-solid fa-chevron-right"></i> Technical Specs</a></li>
                    <li><a href="contact-us.php"><i class="fa-solid fa-chevron-right"></i> Contact Us</a></li>
                </ul>
            </div>

            <!-- Col 3: Dynamic Projects List -->
            <div class="footer-col presence-col">
                <h4 class="col-title">Our Projects</h4>
                <ul class="footer-links">
                    <?php if (isset($footer_projects) && $footer_projects && $footer_projects->num_rows > 0): ?>
                        <?php while ($f_proj = $footer_projects->fetch_assoc()): ?>
                            <li>
                                <a href="project-details.php?id=<?= $f_proj['id'] ?>">
                                    <i class="fa-solid fa-building"></i> <?= htmlspecialchars($f_proj['title']) ?>
                                </a>
                            </li>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <li><a href="index.php#projects"><i class="fa-solid fa-building"></i> Faridabad Luxury Floors</a></li>
                        <li><a href="index.php#projects"><i class="fa-solid fa-building"></i> Gurugram Residences</a></li>
                        <li><a href="index.php#projects"><i class="fa-solid fa-building"></i> South Delhi Luxury Floors</a></li>
                    <?php endif; ?>
                </ul>
            </div>

            <!-- Col 4: Sync'd Contacts & Map -->
            <div class="footer-col contact-col">
                <h4 class="col-title">Corporate Office</h4>
                <ul class="contact-list">
                    <li>
                        <i class="fa-solid fa-phone"></i>
                        <div class="contact-info-block">
                            <a href="tel:+918851404063">+91 88514 04063</a>
                            <a href="tel:+919999566126">+91 99995 66126</a>
                        </div>
                    </li>
                    <li>
                        <i class="fa-solid fa-envelope"></i>
                        <div class="contact-info-block">
                            <a href="mailto:gurugharestates@gmail.com">gurugharestates@gmail.com</a>
                            <a href="mailto:batra.consultants@gmail.com">batra.consultants@gmail.com</a>
                        </div>
                    </li>
                    <li>
                        <i class="fa-solid fa-location-dot"></i>
                        <div class="contact-info-block text-block">
                            <strong>Guru Ghar Estate</strong><br>
                            JC-21, Ground Floor, Sector - 81, Puri VIP Floors.<br>
                            Haryana 121007
                        </div>
                    </li>
                </ul>

                <!-- Embedded Location Map -->
                <div class="footer-map-wrapper">
                    <iframe
                        src="https://maps.google.com/maps?width=100%25&amp;height=600&amp;hl=en&amp;q=RR%20Homes,%20Puri%20Vip%20Floors,%20Sector%2081,%20Faridabad&amp;t=&amp;z=13&amp;ie=UTF8&amp;iwloc=B&amp;output=embed"
                        width="100%" height="130"
                        style="border:0; display:block;" allowfullscreen=""
                        loading="lazy" referrerpolicy="no-referrer-when-downgrade">
                    </iframe>
                </div>
            </div>

        </div>
    </div>

    <!-- Bottom Strip -->
    <div class="footer-bottom">
        <div class="footer-bottom-container">
            <p class="copyright-text">&copy; <?php echo date('Y'); ?> Guru Ghar Estate | All rights reserved.</p>
            <p class="mineib-credit">
                Website Powered by
                <a href="https://www.mineib.com" target="_blank" class="mineib-link">
                    Mineib Creative Technology
                </a>
            </p>
        </div>
    </div>

    <!-- Back to Top Floating Button -->
    <a href="#" class="back-to-top" id="backToTop" aria-label="Back to Top">
        <i class="fa-solid fa-arrow-up"></i>
    </a>
</footer>

<script>
    document.addEventListener("DOMContentLoaded", function () {
        const backToTop = document.getElementById("backToTop");

        // Show/Hide back to top on scroll
        window.addEventListener("scroll", function () {
            if (window.scrollY > 400) {
                backToTop.classList.add("visible");
            } else {
                backToTop.classList.remove("visible");
            }
        });

        // Smooth scroll to top
        backToTop.addEventListener("click", function (e) {
            e.preventDefault();
            window.scrollTo({
                top: 0,
                behavior: 'smooth'
            });
        });
    });
</script>
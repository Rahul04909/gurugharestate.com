<?php
require_once __DIR__ . '/../database/config.php';
$stmt = $conn->prepare("SELECT id, title, short_description, seo_featured_image FROM projects ORDER BY id DESC LIMIT 6");
$stmt->execute();
$projects = $stmt->get_result();
?>
<!-- components/projects.php -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />
<link rel="stylesheet" href="assets/css/projects.css">

<section id="projects" class="projects-section">
    <div class="projects-container">
        
        <!-- Section Heading & Integrated Nav Buttons -->
        <div class="projects-header-flex">
            <div class="section-heading">
                <span class="projects-micro-tag">CURATED COLLECTION</span>
                <h2>Our Premium <span class="gold-text">Builder Floors</span></h2>
                <div class="projects-title-underline"></div>
                <p>Discover our meticulously crafted residential spaces that redefine modern luxury and absolute comfort in Faridabad.</p>
            </div>
            
            <!-- Custom Integrated Slider Navigation Buttons -->
            <div class="projects-slider-nav">
                <button class="projects-prev-btn" aria-label="Previous Project"><i class="fa-solid fa-arrow-left"></i></button>
                <button class="projects-next-btn" aria-label="Next Project"><i class="fa-solid fa-arrow-right"></i></button>
            </div>
        </div>

        <!-- Projects Swiper Slider -->
        <div class="swiper projects-slider">
            <div class="swiper-wrapper">
                <?php if ($projects->num_rows > 0): ?>
                    <?php while ($row = $projects->fetch_assoc()): ?>
                    <div class="swiper-slide project-card">
                        <!-- Card Top Image & Badges -->
                        <div class="card-img-wrapper">
                            <span class="premium-badge"><i class="fa-solid fa-crown"></i> PREMIUM RESIDENCE</span>
                            <div class="card-img">
                                <?php if(!empty($row['seo_featured_image'])): ?>
                                    <img src="assets/uploads/projects/<?= htmlspecialchars($row['seo_featured_image']) ?>" alt="<?= htmlspecialchars($row['title']) ?>">
                                <?php else: ?>
                                    <img src="assets/front-about.png" alt="Guru Ghar Estate Premium Residence" class="placeholder-img">
                                    <div class="placeholder-overlay">
                                        <img src="assets/gurgarestates-logo.png" alt="Guru Ghar Estate Logo" class="overlay-logo">
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>
                        
                        <!-- Card Content -->
                        <div class="card-content">
                            <h3><?= htmlspecialchars($row['title']) ?></h3>
                            <p class="project-desc"><?= htmlspecialchars(mb_strimwidth($row['short_description'], 0, 130, '...')) ?></p>
                            
                            <div class="card-action">
                                <a href="project-details.php?id=<?= $row['id'] ?>" class="skew-btn">Explore Residence</a>
                            </div>
                        </div>
                    </div>
                    <?php endwhile; ?>
                <?php else: ?>
                    <div class="swiper-slide no-projects-box">
                        <i class="fa-regular fa-building"></i>
                        <p>No premium masterworks available right now. Check back later!</p>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</section>

<!-- Swiper JS CDN -->
<script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
<script>
document.addEventListener("DOMContentLoaded", () => {
    const projectsSwiper = new Swiper('.projects-slider', {
        slidesPerView: 1,
        spaceBetween: 30,
        loop: true,
        autoplay: {
            delay: 5000,
            disableOnInteraction: false,
        },
        navigation: {
            nextEl: '.projects-next-btn',
            prevEl: '.projects-prev-btn',
        },
        breakpoints: {
            // >= 768px (Tablets)
            768: {
                slidesPerView: 2,
                spaceBetween: 30
            },
            // >= 1100px (Desktop)
            1100: {
                slidesPerView: 3,
                spaceBetween: 40
            }
        }
    });
});
</script>


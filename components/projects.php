<?php
require_once __DIR__ . '/../database/config.php';
$stmt = $conn->prepare("SELECT id, title, short_description, seo_featured_image FROM projects ORDER BY id DESC LIMIT 6");
$stmt->execute();
$projects = $stmt->get_result();
?>
<!-- components/projects.php -->
<link rel="stylesheet" href="assets/css/projects.css">

<section id="projects" class="projects-section">
    <div class="projects-container">
        
        <!-- Section Heading -->
        <div class="section-heading">
            <span class="projects-micro-tag">CURATED COLLECTION</span>
            <h2>Our Premium <span class="gold-text">Builder Floors</span></h2>
            <div class="projects-title-underline"></div>
            <p>Discover our meticulously crafted residential spaces that redefine modern luxury and absolute comfort in Faridabad.</p>
        </div>

        <!-- Projects Grid -->
        <div class="projects-grid">
            <?php if ($projects->num_rows > 0): ?>
                <?php while ($row = $projects->fetch_assoc()): ?>
                <div class="project-card">
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
                        
                        <!-- 4-Cell Premium Specifications Grid -->
                        <div class="project-specs-grid">
                            <div class="spec-cell">
                                <i class="fa-solid fa-bed"></i>
                                <span class="spec-label">4 BHK</span>
                            </div>
                            <div class="spec-cell">
                                <i class="fa-solid fa-building"></i>
                                <span class="spec-label">Luxury Floor</span>
                            </div>
                            <div class="spec-cell">
                                <i class="fa-solid fa-square-parking"></i>
                                <span class="spec-label">Private Parking</span>
                            </div>
                            <div class="spec-cell">
                                <i class="fa-solid fa-shield-halved"></i>
                                <span class="spec-label">24/7 Security</span>
                            </div>
                        </div>
                        
                        <div class="card-action">
                            <a href="project-details.php?id=<?= $row['id'] ?>" class="skew-btn">Explore Residence</a>
                        </div>
                    </div>
                </div>
                <?php endwhile; ?>
            <?php else: ?>
                <div class="no-projects-box">
                    <i class="fa-regular fa-building"></i>
                    <p>No premium masterworks available right now. Check back later!</p>
                </div>
            <?php endif; ?>
        </div>
    </div>
</section>

<?php
require_once __DIR__ . '/../database/config.php';

// Dynamic database table self-healing to prevent frontend crashes
$conn->query("CREATE TABLE IF NOT EXISTS gallery (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(255) DEFAULT NULL,
    image_name VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
)");

// Fetch all gallery items
$res = $conn->query("SELECT id, title, image_name FROM gallery ORDER BY id DESC");
$gallery_items = [];
if ($res && $res->num_rows > 0) {
    while ($row = $res->fetch_assoc()) {
        $gallery_items[] = $row;
    }
}
?>
<!-- components/gallery.php -->
<style>
/* Modern Premium Gallery Component Stylesheet */
.gallery-section {
    padding: 80px 0;
    background-color: #0f172a; /* Premium deep dark slate color */
    color: #ffffff;
    position: relative;
    overflow: hidden;
}

.gallery-section::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    height: 1px;
    background: linear-gradient(90deg, rgba(212,175,55,0) 0%, rgba(212,175,55,0.4) 50%, rgba(212,175,55,0) 100%);
}

.gallery-container {
    max-width: 1200px;
    margin: 0 auto;
    padding: 0 20px;
}

/* Heading section */
.gallery-header {
    text-align: center;
    margin-bottom: 50px;
}

.gallery-micro-tag {
    font-size: 0.8rem;
    font-weight: 700;
    letter-spacing: 2px;
    color: #d4af37; /* Gold accent color */
    text-transform: uppercase;
    display: inline-block;
    margin-bottom: 12px;
    position: relative;
}

.gallery-header h2 {
    font-size: 2.5rem;
    font-weight: 700;
    margin-bottom: 16px;
    color: #ffffff;
    font-family: 'Outfit', 'Source Sans Pro', sans-serif;
}

.gallery-header h2 .gold-text {
    color: #d4af37;
}

.gallery-title-underline {
    width: 60px;
    height: 3px;
    background-color: #d4af37;
    margin: 0 auto 20px auto;
    border-radius: 2px;
}

.gallery-subtitle {
    font-size: 1.05rem;
    color: #94a3b8; /* Slate gray color */
    max-width: 700px;
    margin: 0 auto;
    line-height: 1.6;
}

/* Grid Layout */
.gallery-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
    gap: 24px;
    margin-top: 40px;
}

/* Gallery Card */
.gallery-card {
    position: relative;
    border-radius: 12px;
    overflow: hidden;
    aspect-ratio: 4 / 3;
    cursor: pointer;
    background-color: #1e293b;
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.3);
    transition: transform 0.4s cubic-bezier(0.165, 0.84, 0.44, 1), box-shadow 0.4s ease;
    border: 1px solid rgba(255, 255, 255, 0.05);
}

.gallery-card:hover {
    transform: translateY(-8px);
    box-shadow: 0 12px 30px rgba(212, 175, 55, 0.15);
    border-color: rgba(212, 175, 55, 0.3);
}

.gallery-img-wrapper {
    width: 100%;
    height: 100%;
    overflow: hidden;
    position: relative;
}

.gallery-img-wrapper img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: transform 0.6s cubic-bezier(0.165, 0.84, 0.44, 1);
}

.gallery-card:hover .gallery-img-wrapper img {
    transform: scale(1.1);
}

/* Dynamic Glassmorphism Overlay */
.gallery-overlay {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: linear-gradient(to top, rgba(15, 23, 42, 0.9) 0%, rgba(15, 23, 42, 0.2) 60%, rgba(15, 23, 42, 0) 100%);
    backdrop-filter: blur(2px);
    opacity: 0;
    transition: opacity 0.4s ease;
    display: flex;
    flex-direction: column;
    justify-content: flex-end;
    padding: 20px;
    box-sizing: border-box;
}

.gallery-card:hover .gallery-overlay {
    opacity: 1;
}

.gallery-overlay-icon {
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%) scale(0.8);
    width: 50px;
    height: 50px;
    background-color: rgba(212, 175, 55, 0.9);
    color: #0f172a;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.25rem;
    box-shadow: 0 4px 15px rgba(212, 175, 55, 0.4);
    transition: transform 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
}

.gallery-card:hover .gallery-overlay-icon {
    transform: translate(-50%, -50%) scale(1);
}

.gallery-item-title {
    font-size: 1.15rem;
    font-weight: 600;
    color: #ffffff;
    margin: 0;
    transform: translateY(15px);
    transition: transform 0.4s cubic-bezier(0.165, 0.84, 0.44, 1);
    font-family: 'Outfit', sans-serif;
    text-shadow: 0 2px 4px rgba(0, 0, 0, 0.5);
}

.gallery-card:hover .gallery-item-title {
    transform: translateY(0);
}

/* Empty State Styling */
.gallery-empty-box {
    grid-column: 1 / -1;
    text-align: center;
    padding: 60px 20px;
    background-color: #1e293b;
    border-radius: 12px;
    border: 1px dashed rgba(255, 255, 255, 0.1);
}

.gallery-empty-box i {
    font-size: 3.5rem;
    color: #475569;
    margin-bottom: 20px;
}

.gallery-empty-box p {
    font-size: 1.1rem;
    color: #94a3b8;
    margin: 0;
}

/* Lightbox Modal CSS Overlay */
.gallery-lightbox {
    display: none;
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background-color: rgba(9, 15, 29, 0.98);
    z-index: 100000;
    justify-content: center;
    align-items: center;
    opacity: 0;
    transition: opacity 0.3s ease;
    backdrop-filter: blur(10px);
}

.gallery-lightbox.active {
    display: flex;
    opacity: 1;
}

.lightbox-content {
    position: relative;
    max-width: 90%;
    max-height: 85%;
    display: flex;
    flex-direction: column;
    align-items: center;
    user-select: none;
}

.lightbox-content img {
    max-width: 100%;
    max-height: 80vh;
    object-fit: contain;
    border-radius: 6px;
    box-shadow: 0 10px 40px rgba(0,0,0,0.8);
    border: 2px solid rgba(255, 255, 255, 0.08);
    transform: scale(0.95);
    transition: transform 0.3s cubic-bezier(0.165, 0.84, 0.44, 1);
}

.gallery-lightbox.active .lightbox-content img {
    transform: scale(1);
}

.lightbox-caption {
    margin-top: 15px;
    color: #ffffff;
    font-size: 1.15rem;
    font-weight: 500;
    text-align: center;
    max-width: 800px;
    font-family: 'Outfit', sans-serif;
}

.lightbox-caption .gold-caption {
    color: #d4af37;
    font-weight: bold;
    display: block;
    margin-bottom: 4px;
}

.lightbox-caption .counter-caption {
    font-size: 0.85rem;
    color: #64748b;
    margin-top: 5px;
    display: block;
}

/* Lightbox Action Controls */
.lightbox-close {
    position: absolute;
    top: 25px;
    right: 30px;
    background: none;
    border: none;
    color: #94a3b8;
    font-size: 2.5rem;
    cursor: pointer;
    transition: color 0.2s, transform 0.2s;
    line-height: 1;
    z-index: 100010;
}

.lightbox-close:hover {
    color: #ffffff;
    transform: scale(1.1);
}

.lightbox-nav-btn {
    position: absolute;
    top: 50%;
    transform: translateY(-50%);
    background: rgba(30, 41, 59, 0.4);
    border: 1px solid rgba(255, 255, 255, 0.1);
    color: #ffffff;
    width: 55px;
    height: 55px;
    border-radius: 50%;
    font-size: 1.3rem;
    cursor: pointer;
    display: flex;
    align-items: center;
    justify-content: center;
    transition: all 0.3s ease;
    z-index: 100010;
}

.lightbox-nav-btn:hover {
    background: rgba(212, 175, 55, 0.95);
    color: #0f172a;
    border-color: #d4af37;
    box-shadow: 0 0 15px rgba(212, 175, 55, 0.4);
}

.lightbox-prev {
    left: 30px;
}

.lightbox-next {
    right: 30px;
}

/* Responsive Breakpoints */
@media (max-width: 768px) {
    .gallery-header h2 {
        font-size: 2rem;
    }
    
    .lightbox-nav-btn {
        width: 44px;
        height: 44px;
        font-size: 1rem;
    }
    
    .lightbox-prev {
        left: 15px;
    }
    
    .lightbox-next {
        right: 15px;
    }
    
    .lightbox-close {
        top: 15px;
        right: 20px;
        font-size: 2rem;
    }
}
</style>

<section class="gallery-section" id="gallery-portfolio">
    <div class="gallery-container">
        
        <!-- Section Header -->
        <div class="gallery-header">
            <span class="gallery-micro-tag">Visual Portfolio</span>
            <h2>Our Architectural <span class="gold-text">Gallery</span></h2>
            <div class="gallery-title-underline"></div>
            <p class="gallery-subtitle">Take an exclusive visual tour of our exquisitely designed builder floors, luxury interiors, and premium elevations executed across Faridabad.</p>
        </div>
        
        <!-- Gallery Grid -->
        <div class="gallery-grid">
            <?php if (!empty($gallery_items)): ?>
                <?php foreach ($gallery_items as $index => $item): ?>
                    <div class="gallery-card" onclick="openLightbox(<?= $index ?>)" role="button" aria-label="Open image in full view">
                        <div class="gallery-img-wrapper">
                            <img src="assets/uploads/gallery/<?= htmlspecialchars($item['image_name']) ?>" 
                                 alt="<?= htmlspecialchars($item['title'] ?: 'Guru Ghar Estate Premium Work') ?>" 
                                 loading="lazy">
                            <div class="gallery-overlay">
                                <div class="gallery-overlay-icon"><i class="fa-solid fa-expand"></i></div>
                                <?php if (!empty($item['title'])): ?>
                                    <h4 class="gallery-item-title"><?= htmlspecialchars($item['title']) ?></h4>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <!-- Curated fallback high-quality imagery to maintain stunning layout even if table is empty -->
                <div class="gallery-card" onclick="openLightbox(0)">
                    <div class="gallery-img-wrapper">
                        <img src="assets/front-about.png" alt="Guru Ghar Premium Elevation" loading="lazy">
                        <div class="gallery-overlay">
                            <div class="gallery-overlay-icon"><i class="fa-solid fa-expand"></i></div>
                            <h4 class="gallery-item-title">Premium Front Elevation</h4>
                        </div>
                    </div>
                </div>
                <div class="gallery-card" onclick="openLightbox(1)">
                    <div class="gallery-img-wrapper">
                        <img src="assets/front-about.png" alt="Guru Ghar Luxury Interior" loading="lazy">
                        <div class="gallery-overlay">
                            <div class="gallery-overlay-icon"><i class="fa-solid fa-expand"></i></div>
                            <h4 class="gallery-item-title">Exquisite Modern Interior</h4>
                        </div>
                    </div>
                </div>
                <div class="gallery-card" onclick="openLightbox(2)">
                    <div class="gallery-img-wrapper">
                        <img src="assets/front-about.png" alt="Guru Ghar Contemporary Building" loading="lazy">
                        <div class="gallery-overlay">
                            <div class="gallery-overlay-icon"><i class="fa-solid fa-expand"></i></div>
                            <h4 class="gallery-item-title">Luxury Builder Floor Exterior</h4>
                        </div>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </div>
</section>

<!-- Lightbox Modal -->
<div id="galleryLightbox" class="gallery-lightbox" onclick="handleBackdropClick(event)">
    <button class="lightbox-close" onclick="closeLightbox()">&times;</button>
    <button class="lightbox-nav-btn lightbox-prev" onclick="prevSlide(event)" aria-label="Previous Image"><i class="fa-solid fa-chevron-left"></i></button>
    <button class="lightbox-nav-btn lightbox-next" onclick="nextSlide(event)" aria-label="Next Image"><i class="fa-solid fa-chevron-right"></i></button>
    
    <div class="lightbox-content">
        <img id="lightboxImg" src="" alt="Enlarged gallery view">
        <div class="lightbox-caption" id="lightboxCaption"></div>
    </div>
</div>

<script>
// Dynamic image array population from PHP context
const galleryImages = [
    <?php if (!empty($gallery_items)): ?>
        <?php foreach ($gallery_items as $item): ?>
            {
                src: "assets/uploads/gallery/<?= htmlspecialchars($item['image_name']) ?>",
                title: "<?= htmlspecialchars($item['title'] ?: 'Guru Ghar Estate Masterpiece') ?>"
            },
        <?php endforeach; ?>
    <?php else: ?>
        // Default curated list
        { src: "assets/front-about.png", title: "Premium Front Elevation" },
        { src: "assets/front-about.png", title: "Exquisite Modern Interior" },
        { src: "assets/front-about.png", title: "Luxury Builder Floor Exterior" }
    <?php endif; ?>
];

let activeIndex = 0;
const lightbox = document.getElementById('galleryLightbox');
const lightboxImg = document.getElementById('lightboxImg');
const lightboxCaption = document.getElementById('lightboxCaption');

function openLightbox(index) {
    activeIndex = index;
    updateLightboxContent();
    lightbox.classList.add('active');
    document.body.style.overflow = 'hidden'; // Stop background scrolling
    
    // Add keyboard listeners when open
    document.addEventListener('keydown', handleKeyPress);
}

function closeLightbox() {
    lightbox.classList.remove('active');
    document.body.style.overflow = ''; // Restore background scrolling
    document.removeEventListener('keydown', handleKeyPress);
}

function updateLightboxContent() {
    const item = galleryImages[activeIndex];
    lightboxImg.src = item.src;
    lightboxCaption.innerHTML = `
        <span class="gold-caption">${item.title}</span>
        <span class="counter-caption">Image ${activeIndex + 1} of ${galleryImages.length}</span>
    `;
}

function nextSlide(event) {
    if (event) event.stopPropagation();
    activeIndex = (activeIndex + 1) % galleryImages.length;
    updateLightboxContent();
}

function prevSlide(event) {
    if (event) event.stopPropagation();
    activeIndex = (activeIndex - 1 + galleryImages.length) % galleryImages.length;
    updateLightboxContent();
}

function handleKeyPress(e) {
    if (e.key === 'Escape') {
        closeLightbox();
    } else if (e.key === 'ArrowRight') {
        nextSlide();
    } else if (e.key === 'ArrowLeft') {
        prevSlide();
    }
}

function handleBackdropClick(e) {
    // Only close if user clicked the backdrop outside content or nav buttons
    if (e.target === lightbox || e.target.classList.contains('lightbox-content')) {
        closeLightbox();
    }
}
</script>

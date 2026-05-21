<?php
require_once __DIR__ . '/database/config.php';

// get id
if (!isset($_GET['id'])) {
    header("Location: index.php");
    exit;
}

$id = intval($_GET['id']);
$stmt = $conn->prepare("SELECT * FROM projects WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$project = $stmt->get_result()->fetch_assoc();

if (!$project) {
    header("Location: index.php");
    exit;
}

// Extract properties
$title = htmlspecialchars($project['title']);
$short_description = htmlspecialchars($project['short_description']);
$description = $project['description']; 
$specifications = $project['specifications']; 
$hero_slides = json_decode($project['hero_slides'], true) ?: [];
$images = json_decode($project['images'], true) ?: [];
$seo_featured = htmlspecialchars($project['seo_featured_image']);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($project['seo_meta_title'] ?: $project['title']) ?> | Guru Ghar Estate</title>
    <meta name="description" content="<?= htmlspecialchars($project['seo_meta_description'] ?: $short_description) ?>">
    <meta name="keywords" content="<?= htmlspecialchars($project['seo_meta_keywords']) ?>">
    <?php if($project['seo_schema']): ?>
    <script type="application/ld+json">
    <?= $project['seo_schema'] ?>
    </script>
    <?php endif; ?>
    <link rel="stylesheet" href="assets/css/projects.css">
    <!-- Include Swiper for slider -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />
    <style>
        body { 
            background-color: #f7f7f9; 
            font-family: 'Outfit', 'Inter', sans-serif; 
            color: #333;
        }
        
        .project-hero { 
            position: relative; 
            height: 65vh; 
            background: #111; 
            overflow: hidden; 
            margin-top: 80px; 
            box-shadow: 0 10px 30px rgba(0,0,0,0.1);
        }
        .project-hero .swiper { 
            width: 100%; 
            height: 100%; 
        }
        .project-hero .swiper-slide img { 
            width: 100%; 
            height: 100%; 
            object-fit: cover; 
            opacity: 0.95; 
            transition: transform 8s ease;
        }
        .project-hero .swiper-slide-active img {
            transform: scale(1.05);
        }
        
        /* Swiper custom pagination styles */
        .myHeroSwiper .swiper-pagination-bullet {
            background: #fff;
            opacity: 0.6;
            width: 10px;
            height: 10px;
            transition: all 0.3s ease;
        }
        .myHeroSwiper .swiper-pagination-bullet-active {
            background: #d4af37;
            opacity: 1;
            width: 25px;
            border-radius: 5px;
        }

        /* Premium Info Header */
        .project-details-header {
            background: #ffffff;
            padding: 50px 5%;
            border-bottom: 1px solid rgba(212,175,55,0.15);
            box-shadow: 0 8px 30px rgba(0,0,0,0.02);
            position: relative;
            z-index: 5;
        }
        .header-container-inner {
            max-width: 1400px;
            margin: 0 auto;
        }
        .header-main-meta {
            display: flex;
            gap: 15px;
            margin-bottom: 15px;
            align-items: center;
        }
        .meta-badge {
            background: rgba(212, 175, 55, 0.1);
            color: #d4af37;
            padding: 6px 14px;
            font-size: 11px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 1px;
            border-radius: 4px;
            border: 1px solid rgba(212, 175, 55, 0.2);
        }
        .meta-location {
            color: #666;
            font-size: 13px;
            font-weight: 500;
            display: flex;
            align-items: center;
            gap: 5px;
        }
        .project-main-title {
            font-family: 'Playfair Display', serif;
            font-size: 42px;
            color: #222;
            font-weight: 700;
            margin: 0 0 15px 0;
            line-height: 1.2;
        }
        .project-title-bar {
            width: 80px;
            height: 3px;
            background: #d4af37;
            margin-bottom: 25px;
            border-radius: 2px;
        }
        .project-lead-desc {
            font-size: 18px;
            line-height: 1.8;
            color: #555;
            max-width: 900px;
            font-style: italic;
            border-left: 4px solid #d4af37;
            padding-left: 20px;
            margin: 0;
        }

        .main-wrapper { 
            background: #fbfbfb; 
        }
        .details-container { 
            padding: 50px 5%; 
            max-width: 1400px; 
            margin: 0 auto; 
            display: grid; 
            grid-template-columns: 2.2fr 1.1fr; 
            gap: 50px; 
        }
        
        .details-content { 
            background: #ffffff; 
            padding: 45px; 
            border-radius: 12px; 
            box-shadow: 0 10px 40px rgba(0,0,0,0.03); 
            border: 1px solid rgba(0,0,0,0.03);
        }
        .details-sidebar { 
            background: #ffffff; 
            color: #333; 
            padding: 24px 22px; 
            border-radius: 12px; 
            box-shadow: 0 12px 35px rgba(0,0,0,0.04); 
            border: 1px solid rgba(212,175,55,0.15);
            border-top: 5px solid #d4af37; 
            align-self: flex-start; 
            position: sticky; 
            top: 100px; 
            transition: all 0.3s ease;
        }
        .details-sidebar:hover {
            box-shadow: 0 18px 45px rgba(212,175,55,0.08);
            border-color: rgba(212,175,55,0.3);
        }

        .sidebar-header { margin-bottom: 18px; border-bottom: 1px solid #f0f0f0; padding-bottom: 14px; position: relative; }
        .sidebar-badge {
            display: inline-flex;
            align-items: center;
            gap: 4px;
            background: rgba(212, 175, 55, 0.1);
            color: #d4af37;
            padding: 4px 10px;
            font-size: 10px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            border-radius: 3px;
            margin-bottom: 8px;
            border: 1px solid rgba(212, 175, 55, 0.15);
        }
        .sidebar-header h3 { font-family: 'Playfair Display', serif; font-size: 1.25rem; text-transform: uppercase; margin: 0; color: #222; font-weight: 700; line-height: 1.3;}
        .sidebar-header p { color: #666; margin-top: 6px; font-size: 0.85rem; line-height: 1.4; }
        
        .section-title { 
            font-family: 'Playfair Display', serif;
            font-size: 22px; 
            color: #222; 
            margin-bottom: 30px; 
            position: relative; 
            padding-bottom: 12px; 
            font-weight: 700; 
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        .section-title::after { 
            content: ''; 
            position: absolute; 
            left: 0; 
            bottom: 0; 
            width: 50px; 
            height: 3px; 
            background: #d4af37; 
            border-radius: 2px;
        }
        
        .content-box { 
            margin-bottom: 60px; 
            font-size: 1.05rem; 
            line-height: 1.9; 
            color: #4a4a4f; 
        }
        .content-box:last-child {
            margin-bottom: 0;
        }
        .content-box p {
            margin-bottom: 20px;
        }
        .content-box ul {
            padding-left: 20px;
            margin-bottom: 20px;
        }
        .content-box li {
            margin-bottom: 10px;
        }
        .content-box img { 
            max-width: 100%; 
            border-radius: 8px; 
            margin: 25px 0; 
            box-shadow: 0 10px 30px rgba(0,0,0,0.05);
        }
        
        .form-group-custom { 
            margin-bottom: 12px; 
        }
        .form-group-custom label { 
            display: block; 
            font-weight: 600; 
            margin-bottom: 5px; 
            color: #555; 
            font-size: 0.75rem; 
            text-transform: uppercase; 
            letter-spacing: 0.5px;
        }
        
        /* Enhanced Enquiry Form Styling */
        .input-icon-wrapper {
            position: relative;
            display: flex;
            align-items: center;
            width: 100%;
        }
        .input-icon-wrapper i {
            position: absolute;
            left: 14px;
            color: #d4af37;
            font-size: 12px;
            pointer-events: none;
            transition: all 0.3s ease;
            z-index: 2;
        }
        .input-icon-wrapper input {
            padding: 10px 12px 10px 38px !important;
            font-family: 'Outfit', sans-serif !important;
            font-size: 13px !important;
            border: 1px solid rgba(0,0,0,0.06) !important;
            background: #fafafa !important;
            border-radius: 6px !important;
            width: 100%;
            transition: all 0.3s cubic-bezier(0.25, 0.8, 0.25, 1) !important;
            box-sizing: border-box !important;
        }
        .input-icon-wrapper textarea {
            padding: 10px 12px 10px 38px !important;
            font-family: 'Outfit', sans-serif !important;
            font-size: 13px !important;
            border: 1px solid rgba(0,0,0,0.06) !important;
            background: #fafafa !important;
            border-radius: 6px !important;
            width: 100%;
            transition: all 0.3s cubic-bezier(0.25, 0.8, 0.25, 1) !important;
            box-sizing: border-box !important;
            resize: none !important;
            min-height: 65px !important;
            overflow: hidden !important;
        }
        .textarea-wrapper {
            align-items: flex-start;
        }
        .textarea-wrapper i {
            top: 12px;
        }
        
        /* Focus state effects */
        .input-icon-wrapper input:focus,
        .input-icon-wrapper textarea:focus {
            border-color: #d4af37 !important;
            background: #ffffff !important;
            box-shadow: 0 4px 12px rgba(212,175,55,0.1) !important;
            outline: none !important;
            transform: scale(1.01);
        }
        .input-icon-wrapper input:focus + i,
        .input-icon-wrapper textarea:focus + i {
            color: #222;
        }
        .input-icon-wrapper:focus-within i {
            color: #d4af37;
            transform: scale(1.1);
        }

        /* Premium Form Button */
        .premium-submit-btn {
            position: relative;
            background: linear-gradient(135deg, #d4af37 0%, #b89324 100%);
            color: #ffffff;
            border: none;
            border-radius: 6px;
            padding: 11px 20px;
            font-family: 'Outfit', sans-serif;
            font-weight: 700;
            font-size: 13px;
            text-transform: uppercase;
            letter-spacing: 1px;
            cursor: pointer;
            width: 100%;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            transition: all 0.3s cubic-bezier(0.25, 0.8, 0.25, 1);
            box-shadow: 0 4px 15px rgba(212,175,55,0.2);
            outline: none;
            box-sizing: border-box;
            overflow: hidden;
            margin-top: 5px;
        }
        .premium-submit-btn::after {
            content: '';
            position: absolute;
            top: 0;
            left: -50%;
            width: 30%;
            height: 100%;
            background: linear-gradient(to right, rgba(255,255,255,0) 0%, rgba(255,255,255,0.3) 50%, rgba(255,255,255,0) 100%);
            transform: skewX(-25deg);
            transition: 0.75s;
        }
        .premium-submit-btn:hover::after {
            left: 120%;
        }
        .premium-submit-btn:hover {
            background: #222;
            box-shadow: 0 6px 18px rgba(34,34,34,0.25);
            transform: translateY(-2px);
            color: #d4af37;
        }
        .premium-submit-btn:active {
            transform: translateY(0);
        }

        .form-trust-badges {
            display: flex;
            justify-content: space-between;
            margin-top: 12px;
            padding-top: 10px;
            border-top: 1px solid rgba(0,0,0,0.04);
            gap: 10px;
        }
        .trust-badge-item {
            font-size: 10.5px;
            color: #777;
            font-weight: 500;
            display: flex;
            align-items: center;
            gap: 5px;
        }
        .trust-badge-item i {
            color: #d4af37;
            font-size: 11px;
        }
        
        .gallery-grid { 
            display: grid; 
            grid-template-columns: repeat(auto-fill, minmax(220px, 1fr)); 
            gap: 20px; 
            margin-top: 30px; 
        }
        .gallery-grid img { 
            width: 100%; 
            height: 220px; 
            object-fit: cover; 
            border-radius: 8px; 
            transition: all 0.4s cubic-bezier(0.25, 0.8, 0.25, 1); 
            cursor: pointer;
            box-shadow: 0 5px 15px rgba(0,0,0,0.03);
            border: 1px solid rgba(0,0,0,0.02);
        }
        .gallery-grid img:hover { 
            transform: translateY(-5px) scale(1.03); 
            box-shadow: 0 15px 30px rgba(0,0,0,0.12); 
            border-color: rgba(212,175,55,0.3);
        }
        
        /* Modal for Image Preview */
        .modal { display: none; position: fixed; z-index: 9999; padding-top: 50px; left: 0; top: 0; width: 100%; height: 100%; overflow: auto; background-color: rgba(15,15,17,0.95); backdrop-filter: blur(8px); -webkit-backdrop-filter: blur(8px);}
        .modal-content { margin: auto; display: block; max-width: 85%; max-height: 80vh; object-fit: contain; box-shadow: 0 0 50px rgba(0,0,0,0.6); border-radius: 8px; border: 1px solid rgba(212,175,55,0.25); transition: transform 0.3s ease;}
        .close { position: absolute; top: 20px; right: 40px; color: #fff; font-size: 45px; font-weight: 300; transition: 0.3s; cursor: pointer; text-shadow: 0 0 10px rgba(0,0,0,0.5);}
        .close:hover, .close:focus { color: #d4af37; text-decoration: none; cursor: pointer; transform: scale(1.15) rotate(90deg);}

        @media(max-width: 991px) {
            .details-container { grid-template-columns: 1fr; gap: 30px; padding: 30px 5%; }
            .details-sidebar { position: static; max-height: none; overflow-y: visible; margin-top: 20px;}
            .details-content { padding: 30px 20px; }
            .project-main-title { font-size: 32px; }
            .project-details-header { padding: 40px 5%; }
        }
    </style>
</head>
<body>
    <?php include 'includes/header.php'; ?>

    <section class="project-hero">
        <div class="swiper myHeroSwiper">
            <div class="swiper-wrapper">
                <?php if(!empty($hero_slides)): ?>
                    <?php foreach($hero_slides as $slide): ?>
                    <div class="swiper-slide"><img src="assets/uploads/projects/<?= htmlspecialchars($slide) ?>" alt="<?= $title ?>"></div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <div class="swiper-slide"><img src="assets/uploads/projects/<?= htmlspecialchars($seo_featured) ?>" alt="<?= $title ?>"></div>
                <?php endif; ?>
            </div>
            <div class="swiper-pagination"></div>
        </div>
    </section>

    <div class="project-details-header">
        <div class="header-container-inner">
            <div class="header-main-meta">
                <span class="meta-badge"><i class="fa-solid fa-crown"></i> Elite Collection</span>
                <span class="meta-location"><i class="fa-solid fa-location-dot"></i> Faridabad, NCR</span>
            </div>
            <h1 class="project-main-title"><?= $title ?></h1>
            <div class="project-title-bar"></div>
            <p class="project-lead-desc"><?= $short_description ?></p>
        </div>
    </div>

    <div class="main-wrapper">
        <div class="details-container">
            <div class="details-content">
                <div class="content-box">
                    <h2 class="section-title">Project Overview</h2>
                    <div>
                        <?= empty(trim(strip_tags($description))) ? '<p>Details coming soon.</p>' : $description ?>
                    </div>
                </div>

                <?php if(!empty(trim(strip_tags($specifications)))): ?>
                <div class="content-box">
                    <h2 class="section-title">Specifications</h2>
                    <div><?= $specifications ?></div>
                </div>
                <?php endif; ?>

                <?php if(!empty($images)): ?>
                <div class="content-box">
                    <h2 class="section-title">Photo Gallery</h2>
                    <div class="gallery-grid">
                        <?php foreach($images as $img): ?>
                            <img src="assets/uploads/projects/<?= htmlspecialchars($img) ?>" alt="Gallery Image" class="gallery-item" onclick="openModal(this)">
                        <?php endforeach; ?>
                    </div>
                </div>
                <?php endif; ?>
            </div>

            <div class="details-sidebar">
                <div class="sidebar-header">
                    <div class="sidebar-badge"><i class="fa-solid fa-bolt-lightning"></i> Instant Response</div>
                    <h3>Interested in <span style="color:#d4af37;"><?= $title ?></span>?</h3>
                    <p>Contact our elite real estate specialists directly.</p>
                </div>
                
                <?php
                $enq_msg = '';
                if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['submit_enquiry'])) {
                    require_once 'database/config.php';
                    $name = mysqli_real_escape_string($conn, $_POST['name']);
                    $email = mysqli_real_escape_string($conn, $_POST['email']);
                    $phone = mysqli_real_escape_string($conn, $_POST['phone']);
                    $message = mysqli_real_escape_string($conn, $_POST['message']);
                    $source = "Project Inquiry: " . mysqli_real_escape_string($conn, $title);
                    
                    $sql = "INSERT INTO enquiries (name, email, phone, message, source) VALUES ('$name', '$email', '$phone', '$message', '$source')";
                    
                    if(mysqli_query($conn, $sql)) {
                        $enq_msg = "<div style='color:#28a745; background:rgba(40,167,69,0.1); padding:10px; border-radius:5px; margin-bottom:15px; font-weight:bold; font-size:13px; border-left:4px solid #28a745;'>Thank you! Your enquiry has been completely received. Our team will contact you.</div>";
                    } else {
                        $enq_msg = "<div style='color:#dc3545; background:rgba(220,53,69,0.1); padding:10px; border-radius:5px; margin-bottom:15px; font-weight:bold; font-size:13px; border-left:4px solid #dc3545;'>Error submitting enquiry. Please try again.</div>";
                    }
                }
                ?>
                <?= $enq_msg ?>

                <form class="enquiry-form" method="POST">
                    <div class="form-group-custom">
                        <label>Full Name</label>
                        <div class="input-icon-wrapper">
                            <i class="fa-solid fa-user"></i>
                            <input type="text" name="name" placeholder="Enter your full name" required>
                        </div>
                    </div>
                    <div class="form-group-custom">
                        <label>Email Address</label>
                        <div class="input-icon-wrapper">
                            <i class="fa-solid fa-envelope"></i>
                            <input type="email" name="email" placeholder="Enter your email" required>
                        </div>
                    </div>
                    <div class="form-group-custom">
                        <label>Phone Number</label>
                        <div class="input-icon-wrapper">
                            <i class="fa-solid fa-phone"></i>
                            <input type="text" name="phone" placeholder="Enter your phone" required>
                        </div>
                    </div>
                    <div class="form-group-custom">
                        <label>Your Message</label>
                        <div class="input-icon-wrapper textarea-wrapper">
                            <i class="fa-solid fa-message"></i>
                            <textarea name="message" rows="2" placeholder="How can we help you?" required>I am interested in the <?= $title ?> project and would like to know more details.</textarea>
                        </div>
                    </div>
                    <button type="submit" name="submit_enquiry" class="premium-submit-btn">
                        <span>SUBMIT ENQUIRY</span>
                        <i class="fa-solid fa-paper-plane"></i>
                    </button>
                    <div class="form-trust-badges">
                        <div class="trust-badge-item"><i class="fa-solid fa-clock-rotate-left"></i> Response in 15m</div>
                        <div class="trust-badge-item"><i class="fa-solid fa-shield-halved"></i> 100% Privacy</div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- The Modal for Lightbox -->
    <div id="imageModal" class="modal">
        <span class="close" onclick="closeModal()">&times;</span>
        <img class="modal-content" id="img01">
    </div>

    <?php include 'includes/footer.php'; ?>

    <!-- Swiper JS -->
    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
    <script>
        // Initialize Swiper
        var swiper = new Swiper(".myHeroSwiper", {
            loop: true,
            autoplay: {
                delay: 4000,
                disableOnInteraction: false,
            },
            pagination: {
                el: ".swiper-pagination",
                clickable: true,
            },
        });

        // Lightbox Functions
        var modal = document.getElementById("imageModal");
        var modalImg = document.getElementById("img01");

        function openModal(element) {
            modal.style.display = "block";
            modalImg.src = element.src;
        }

        function closeModal() {
            modal.style.display = "none";
        }
        
        // Close modal on click outside image
        window.onclick = function(event) {
            if (event.target == modal) {
                modal.style.display = "none";
            }
        }
    </script>
</body>
</html>

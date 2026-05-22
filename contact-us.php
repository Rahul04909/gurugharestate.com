<?php
// contact-us.php
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact Us | GuruGhar Estate</title>
    <meta name="description" content="Get in touch with GuruGhar Estate. Contact our premier real estate consultancy and builder floor development team in Faridabad and Delhi NCR.">
    <meta name="keywords" content="GuruGhar Estate, Contact GuruGhar Estate, Real Estate Office Faridabad, Property Consultancy Office, Contact Real Estate Agents">
    <link rel="icon" href="assets/favicon.png?v=<?= time() ?>" type="image/png">

    <!-- Open Graph / Facebook SEO -->
    <meta property="og:type" content="website">
    <meta property="og:url" content="https://gurugharestate.com/contact-us.php">
    <meta property="og:title" content="Contact Us | GuruGhar Estate">
    <meta property="og:description" content="Get in touch with GuruGhar Estate. Contact our premier real estate consultancy and builder floor development team in Faridabad and Delhi NCR.">
    <meta property="og:image" content="https://gurugharestate.com/assets/gurgarestates-logo.png">

    <!-- Twitter Card SEO -->
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:url" content="https://gurugharestate.com/contact-us.php">
    <meta name="twitter:title" content="Contact Us | GuruGhar Estate">
    <meta name="twitter:description" content="Get in touch with GuruGhar Estate. Contact our premier real estate consultancy and builder floor development team in Faridabad and Delhi NCR.">
    <meta name="twitter:image" content="https://gurugharestate.com/assets/gurgarestates-logo.png">
    
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700&family=Playfair+Display:ital,wght@0,500;0,600;0,700;1,500;1,600;1,700&family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <style>
        /* ==========================================================================
           Corporate Color Tokens & Base Styles
           ========================================================================== */
        :root {
            --ct-bg: #fdfdfd;                 /* Elegant clean background */
            --ct-dark: #302f35;               /* Deep slate-charcoal */
            --ct-dark-card: #1e1d23;          /* Rich charcoal for info card */
            --ct-gold: #d4af37;               /* Premium brand gold */
            --ct-gold-glow: rgba(212, 175, 55, 0.2);
            
            --ct-text: #4a4a4f;               /* Sophisticated charcoal body text */
            --ct-text-light: #6c6c72;         /* Muted subtext */
            
            --ct-transition: all 0.4s cubic-bezier(0.25, 0.8, 0.25, 1);
        }

        body {
            font-family: 'Outfit', 'Poppins', sans-serif;
            background-color: var(--ct-bg);
            color: var(--ct-text);
            margin: 0;
            padding: 0;
        }

        /* ==========================================================================
           Hero Section Header
           ========================================================================== */
        .page-hero {
            position: relative;
            height: 40vh;
            min-height: 320px;
            background-color: var(--ct-dark);
            background-image: linear-gradient(135deg, #302f35 0%, #1e1d23 100%);
            margin-top: 138px;                 /* Space below fixed header */
            display: flex;
            align-items: center;
            justify-content: center;
            overflow: hidden;
        }

        /* Ambient glow background overlay */
        .page-hero::before {
            content: '';
            position: absolute;
            width: 140%;
            height: 100%;
            top: 20%;
            left: -20%;
            background: radial-gradient(circle, var(--ct-gold) 0%, transparent 60%);
            opacity: 0.12;
            pointer-events: none;
            filter: blur(80px);
        }

        .page-hero-content {
            position: relative;
            z-index: 2;
            text-align: center;
            color: #ffffff;
            padding: 0 20px;
            max-width: 900px;
        }

        .page-hero-content h1 {
            font-family: 'Playfair Display', serif;
            font-size: 3.5rem;
            font-weight: 700;
            margin: 0 0 15px 0;
            letter-spacing: 0.5px;
            text-shadow: 0 4px 15px rgba(0, 0, 0, 0.3);
        }

        .page-hero-content h1 span {
            color: var(--ct-gold);
            font-style: italic;
        }

        .page-hero-content p {
            font-size: 1.15rem;
            line-height: 1.6;
            margin: 0 auto;
            opacity: 0.9;
            font-weight: 300;
            max-width: 750px;
            text-shadow: 0 2px 8px rgba(0, 0, 0, 0.3);
        }

        /* ==========================================================================
           Contact Main Grid Section
           ========================================================================== */
        .contact-section {
            padding: 120px 40px;
            position: relative;
        }

        .contact-container {
            max-width: 1320px;
            margin: 0 auto;
            display: grid;
            grid-template-columns: 1fr 1.2fr;
            gap: 70px;
            align-items: stretch;
        }

        /* Left Side: Premium Slate Information Card */
        .contact-info-wrapper {
            background-color: var(--ct-dark-card);
            background-image: linear-gradient(145deg, #1e1d23 0%, #151419 100%);
            color: #ffffff;
            padding: 60px 50px;
            border-radius: 12px;
            box-shadow: 0 20px 50px rgba(0, 0, 0, 0.15);
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            position: relative;
            overflow: hidden;
            border-left: 5px solid var(--ct-gold);
        }

        /* Ambient glow for card */
        .contact-info-wrapper::before {
            content: '';
            position: absolute;
            top: -50%;
            right: -50%;
            width: 100%;
            height: 100%;
            background: radial-gradient(circle, var(--ct-gold-glow) 0%, transparent 70%);
            pointer-events: none;
            opacity: 0.5;
        }

        .info-card-header {
            margin-bottom: 40px;
        }

        .info-card-header h2 {
            font-family: 'Playfair Display', serif;
            font-size: 2.2rem;
            margin: 0 0 10px 0;
            color: #ffffff;
        }

        .info-card-header h2 span {
            color: var(--ct-gold);
            font-style: italic;
        }

        .info-card-underline {
            width: 50px;
            height: 2px;
            background-color: var(--ct-gold);
            border-radius: 2px;
        }

        .info-item {
            display: flex;
            align-items: flex-start;
            margin-bottom: 35px;
            position: relative;
            z-index: 2;
        }

        .info-item:last-of-type {
            margin-bottom: 0;
        }

        .info-icon {
            background: rgba(212, 175, 55, 0.1);
            color: var(--ct-gold);
            width: 50px;
            height: 50px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.25rem;
            margin-right: 25px;
            flex-shrink: 0;
            border: 1px solid rgba(212, 175, 55, 0.2);
            box-shadow: 0 4px 15px rgba(212, 175, 55, 0.05);
            transition: var(--ct-transition);
        }

        .info-item:hover .info-icon {
            background-color: var(--ct-gold);
            color: #ffffff;
            box-shadow: 0 8px 25px var(--ct-gold-glow);
            transform: translateY(-3px);
        }

        .info-content h3 {
            font-size: 1.1rem;
            margin: 0 0 8px 0;
            font-weight: 600;
            letter-spacing: 1px;
            text-transform: uppercase;
            color: #f7f7f9;
        }

        .info-content p,
        .info-content a {
            font-size: 1.05rem;
            color: #cccccc;
            line-height: 1.65;
            text-decoration: none;
            transition: var(--ct-transition);
            display: block;
        }

        .info-content a {
            margin-bottom: 4px;
        }

        .info-content a:last-child {
            margin-bottom: 0;
        }

        .info-content a:hover {
            color: var(--ct-gold);
        }

        /* Premium Social Media Icons block */
        .info-social-block {
            margin-top: 50px;
            border-top: 1px solid rgba(255, 255, 255, 0.08);
            padding-top: 30px;
            position: relative;
            z-index: 2;
        }

        .info-social-block p {
            font-size: 0.9rem;
            text-transform: uppercase;
            letter-spacing: 1.5px;
            color: #99999f;
            margin: 0 0 15px 0;
            font-weight: 500;
        }

        .social-links-grid {
            display: flex;
            gap: 12px;
        }

        .social-circle-link {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background-color: rgba(255, 255, 255, 0.05);
            border: 1px solid rgba(255, 255, 255, 0.1);
            color: #ffffff;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1rem;
            transition: var(--ct-transition);
            text-decoration: none !important;
        }

        .social-circle-link:hover {
            background-color: var(--ct-gold);
            color: var(--ct-dark-card);
            border-color: var(--ct-gold);
            transform: translateY(-4px);
            box-shadow: 0 8px 20px var(--ct-gold-glow);
        }

        /* Right Side: Clean Premium Form Card */
        .contact-form-wrapper {
            background: #ffffff;
            padding: 60px 50px;
            border-radius: 12px;
            box-shadow: 0 15px 40px rgba(0, 0, 0, 0.04);
            border: 1px solid rgba(48, 47, 53, 0.05);
            transition: var(--ct-transition);
        }

        .contact-form-wrapper:hover {
            box-shadow: 0 25px 55px rgba(0, 0, 0, 0.07);
        }

        .form-header-block {
            margin-bottom: 35px;
        }

        .form-title {
            font-family: 'Playfair Display', serif;
            font-size: 2.2rem;
            color: var(--ct-dark);
            margin: 0 0 10px 0;
            font-weight: 700;
        }

        .form-title span {
            color: var(--ct-gold);
            font-style: italic;
        }

        .form-subtitle {
            color: var(--ct-text-light);
            margin: 0;
            font-size: 1.02rem;
            line-height: 1.6;
            font-weight: 300;
        }

        /* Gorgeous Custom CSS Alerts */
        .alert {
            padding: 16px 20px;
            border-radius: 8px;
            margin-bottom: 30px;
            font-size: 0.98rem;
            font-weight: 500;
            display: flex;
            align-items: center;
            gap: 12px;
            line-height: 1.5;
        }

        .alert-success {
            color: #155724;
            background-color: #e2f0d9;
            border: 1px solid #c5e0b4;
            border-left: 5px solid #28a745;
        }

        .alert-danger {
            color: #721c24;
            background-color: #f8d7da;
            border: 1px solid #f5c6cb;
            border-left: 5px solid #dc3545;
        }

        .alert i {
            font-size: 1.15rem;
        }

        /* Form Controls styling */
        .form-group-custom {
            margin-bottom: 25px;
        }

        .form-group-custom label {
            display: block;
            font-weight: 500;
            margin-bottom: 8px;
            color: var(--ct-dark);
            font-size: 0.85rem;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .contact-form input,
        .contact-form textarea {
            width: 100%;
            box-sizing: border-box;
            padding: 15px 20px;
            border: 1px solid #e1e1e6;
            background: #fcfcfd;
            color: var(--ct-dark);
            border-radius: 8px;
            font-family: 'Outfit', sans-serif;
            font-size: 1rem;
            font-weight: 400;
            transition: var(--ct-transition);
        }

        .contact-form input::placeholder,
        .contact-form textarea::placeholder {
            color: #a0a0a5;
            font-weight: 300;
        }

        .contact-form input:focus,
        .contact-form textarea:focus {
            border-color: var(--ct-gold);
            outline: none;
            box-shadow: 0 0 0 4px var(--ct-gold-glow);
            background: #ffffff;
        }

        .contact-form textarea {
            resize: vertical;
            min-height: 130px;
        }

        /* Tactile Luxury Skew Button */
        .skew-btn-gold {
            display: inline-block;
            background-color: var(--ct-gold);
            color: #ffffff;
            text-decoration: none;
            padding: 16px 36px;
            font-weight: 600;
            text-transform: uppercase;
            font-size: 0.95rem;
            letter-spacing: 2px;
            border: none;
            cursor: pointer;
            transition: var(--ct-transition);
            border-radius: 6px;
            width: 100%;
            text-align: center;
            margin-top: 10px;
            box-shadow: 0 6px 18px rgba(212, 175, 55, 0.2);
        }

        .skew-btn-gold:hover {
            background-color: var(--ct-dark);
            transform: translateY(-3px);
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.15);
        }

        /* ==========================================================================
           Interactive Museum Google Map Section
           ========================================================================== */
        .contact-map-section {
            padding: 0 40px 120px 40px;
            position: relative;
        }

        .map-section-header {
            max-width: 1320px;
            margin: 0 auto 35px auto;
            text-align: center;
        }

        .map-section-header h2 {
            font-family: 'Playfair Display', serif;
            font-size: 2.2rem;
            color: var(--ct-dark);
            margin: 0 0 12px 0;
            font-weight: 700;
        }

        .map-section-header h2 span {
            color: var(--ct-gold);
            font-style: italic;
        }

        .map-title-underline {
            width: 60px;
            height: 3px;
            background-color: var(--ct-gold);
            margin: 0 auto;
            border-radius: 2px;
        }

        .contact-map-container {
            max-width: 1320px;
            margin: 0 auto;
        }

        .contact-map-wrapper {
            position: relative;
            background: #ffffff;
            border-radius: 12px;
            padding: 8px;
            box-shadow: 0 15px 40px rgba(0, 0, 0, 0.04);
            border: 1px solid rgba(48, 47, 53, 0.05);
            transition: var(--ct-transition);
        }

        .contact-map-wrapper iframe {
            border-radius: 8px;
            filter: grayscale(0.2) contrast(1.1);
            transition: var(--ct-transition);
            display: block;
        }

        .contact-map-wrapper:hover {
            box-shadow: 0 25px 55px rgba(0, 0, 0, 0.1);
            border-color: rgba(212, 175, 55, 0.25);
        }

        .contact-map-wrapper:hover iframe {
            filter: grayscale(0) contrast(1.05);
        }

        /* ==========================================================================
           RESPONSIVENESS
           ========================================================================== */
        @media screen and (max-width: 1200px) {
            .contact-container {
                gap: 40px;
            }
            .contact-info-wrapper {
                padding: 45px 35px;
            }
            .contact-form-wrapper {
                padding: 45px 35px;
            }
        }

        @media screen and (max-width: 992px) {
            .page-hero {
                margin-top: 80px;       /* Spacing adjusts for mobile/tablet header */
                height: 35vh;
            }
            .page-hero-content h1 {
                font-size: 2.8rem;
            }
            .contact-section {
                padding: 80px 30px;
            }
            .contact-container {
                grid-template-columns: 1fr;
                gap: 50px;
            }
            .contact-map-section {
                padding: 0 30px 80px 30px;
            }
        }

        @media screen and (max-width: 768px) {
            .page-hero-content h1 {
                font-size: 2.3rem;
            }
            .page-hero-content p {
                font-size: 1rem;
            }
            .contact-info-wrapper {
                padding: 40px 30px;
            }
            .contact-form-wrapper {
                padding: 40px 30px;
            }
            .form-title, .map-section-header h2 {
                font-size: 1.8rem;
            }
            .info-card-header h2 {
                font-size: 1.8rem;
            }
            .contact-form input, .contact-form textarea {
                padding: 13px 18px;
            }
        }
    </style>
</head>

<body>
    <?php include 'includes/header.php'; ?>

    <!-- Page Title Hero -->
    <section class="page-hero">
        <div class="page-hero-content">
            <h1>Get In <span>Touch</span></h1>
            <p>We'd love to hear from you. Let's start a conversation and build something extraordinary together.</p>
        </div>
    </section>

    <!-- Main Contact Section (Grid Layout) -->
    <section class="contact-section">
        <div class="contact-container">
            
            <!-- Left Column: Slate Information Card -->
            <div class="contact-info-wrapper">
                <div>
                    <div class="info-card-header">
                        <h2>Corporate <span>Office</span></h2>
                        <div class="info-card-underline"></div>
                    </div>
                    
                    <!-- HQ Address -->
                    <div class="info-item">
                        <div class="info-icon"><i class="fas fa-map-marker-alt"></i></div>
                        <div class="info-content">
                            <h3>Our Headquarters</h3>
                            <p>JC-21, Ground Floor, Sector - 81, Puri VIP Floors.<br>Faridabad, Haryana 121007</p>
                        </div>
                    </div>
                    
                    <!-- Dynamic Phone List -->
                    <div class="info-item">
                        <div class="info-icon"><i class="fas fa-phone-alt"></i></div>
                        <div class="info-content">
                            <h3>Phone Numbers</h3>
                            <a href="tel:+918851404063">+91 88514 04063</a>
                            <a href="tel:+919999566126">+91 99995 66126</a>
                        </div>
                    </div>
                    
                    <!-- Dynamic Email List -->
                    <div class="info-item">
                        <div class="info-icon"><i class="fas fa-envelope"></i></div>
                        <div class="info-content">
                            <h3>Email Addresses</h3>
                            <a href="mailto:gurugharestates@gmail.com">gurugharestates@gmail.com</a>
                            <a href="mailto:batra.consultants@gmail.com">batra.consultants@gmail.com</a>
                        </div>
                    </div>
                </div>
                
                <!-- Social Connect Blocks -->
                <div class="info-social-block">
                    <p>Connect With Us</p>
                    <div class="social-links-grid">
                        <a href="https://www.facebook.com/gurugharestate" target="_blank" class="social-circle-link" title="Facebook"><i class="fab fa-facebook-f"></i></a>
                        <a href="https://www.instagram.com/gurugharestate" target="_blank" class="social-circle-link" title="Instagram"><i class="fab fa-instagram"></i></a>
                    </div>
                </div>
                
            </div>

            <!-- Right Column: Enquiry Form Card -->
            <div class="contact-form-wrapper">
                <div class="form-header-block">
                    <h2 class="form-title">Send A <span>Message</span></h2>
                    <p class="form-subtitle">Have a question regarding our ongoing projects or looking to schedule a consultation? Fill out the form below and our dedicated team will reach out to you.</p>
                </div>

                <?php
                $msg = '';
                if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['submit_contact'])) {
                    require_once 'database/config.php';
                    $name = mysqli_real_escape_string($conn, $_POST['name']);
                    $email = mysqli_real_escape_string($conn, $_POST['email']);
                    $phone = mysqli_real_escape_string($conn, $_POST['phone']);
                    $message = isset($_POST['message']) ? mysqli_real_escape_string($conn, $_POST['message']) : '';
                    $source = "Contact Us Page";
                    
                    $sql = "INSERT INTO enquiries (name, email, phone, message, source) VALUES ('$name', '$email', '$phone', '$message', '$source')";
                    
                    if (mysqli_query($conn, $sql)) {
                        $msg = "<div class='alert alert-success'><i class='fa-solid fa-circle-check'></i> Your message has been successfully sent! Our team will contact you soon.</div>";
                    } else {
                        $msg = "<div class='alert alert-danger'><i class='fa-solid fa-circle-exclamation'></i> Error submitting message. Please try again.</div>";
                    }
                }
                ?>
                <?= $msg ?>

                <form class="contact-form" method="POST" action="">
                    <div class="form-group-custom">
                        <label for="form-name">Your Name *</label>
                        <input type="text" id="form-name" name="name" placeholder="Enter your full name" autocomplete="name" required>
                    </div>
                    <div class="form-group-custom">
                        <label for="form-email">Email Address *</label>
                        <input type="email" id="form-email" name="email" placeholder="Enter your email address" autocomplete="email" required>
                    </div>
                    <div class="form-group-custom">
                        <label for="form-phone">Phone Number *</label>
                        <input type="tel" id="form-phone" name="phone" placeholder="Enter your mobile number" autocomplete="tel" required>
                    </div>
                    <div class="form-group-custom">
                        <label for="form-message">Message / Inquiry (Optional)</label>
                        <textarea id="form-message" name="message" placeholder="How can we help you today? (Optional)" autocomplete="off"></textarea>
                    </div>
                    <button type="submit" name="submit_contact" class="skew-btn-gold">SEND MESSAGE</button>
                </form>
            </div>
            
        </div>
    </section>

    <!-- Full Width Interactive Google Map Section -->
    <section class="contact-map-section">
        <div class="map-section-header">
            <h2>Find Us On <span>The Map</span></h2>
            <div class="map-title-underline"></div>
        </div>
        
        <div class="contact-map-container">
            <div class="contact-map-wrapper">
                <iframe
                    src="https://maps.google.com/maps?width=100%25&amp;height=600&amp;hl=en&amp;q=Guru%20Ghar%20Estate,%20Puri%20Vip%20Floors,%20Sector%2081,%20Faridabad&amp;t=&amp;z=14&amp;ie=UTF8&amp;iwloc=B&amp;output=embed"
                    width="100%" height="450"
                    style="border:0; display:block;" allowfullscreen=""
                    loading="lazy" referrerpolicy="no-referrer-when-downgrade">
                </iframe>
            </div>
        </div>
    </section>

    <?php include 'includes/footer.php'; ?>
</body>

</html>
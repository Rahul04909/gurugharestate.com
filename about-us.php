<?php
// about-us.php
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>About Us | Guru Ghar Estate</title>
    <meta name="description" content="Guru Ghar Estate is one of the fastest-growing construction and real estate consultancy companies in Faridabad, Delhi NCR, delivering high-quality residential builder floors.">
    <meta name="keywords" content="Guru Ghar Estate, About Guru Ghar Estate, Real Estate Faridabad, Construction Specialists, Real Estate Consultants, Luxury Builder Floors">
    <link rel="icon" href="assets/favicon.png?v=<?= time() ?>" type="image/png">

    <!-- Open Graph / Facebook SEO -->
    <meta property="og:type" content="website">
    <meta property="og:url" content="https://gurugharestate.com/about-us.php">
    <meta property="og:title" content="About Us | Guru Ghar Estate">
    <meta property="og:description" content="Guru Ghar Estate is one of the fastest-growing construction and real estate consultancy companies in Faridabad, Delhi NCR, delivering high-quality residential builder floors.">
    <meta property="og:image" content="https://gurugharestate.com/assets/gurgarestates-logo.png">

    <!-- Twitter Card SEO -->
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:url" content="https://gurugharestate.com/about-us.php">
    <meta name="twitter:title" content="About Us | Guru Ghar Estate">
    <meta name="twitter:description" content="Guru Ghar Estate is one of the fastest-growing construction and real estate consultancy companies in Faridabad, Delhi NCR, delivering high-quality residential builder floors.">
    <meta name="twitter:image" content="https://gurugharestate.com/assets/gurgarestates-logo.png">
    
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700&family=Playfair+Display:ital,wght@0,500;0,600;0,700;1,500;1,600;1,700&family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <style>
        /* ==========================================================================
           Corporate Color Tokens & Base Styles
           ========================================================================== */
        :root {
            --ab-bg: #fdfdfd;                 /* Elegant clean gallery background */
            --ab-dark: #302f35;               /* Deep slate-charcoal core accent */
            --ab-gold: #d4af37;               /* Premium luxury brand gold */
            --ab-gold-glow: rgba(212, 175, 55, 0.2);
            
            --ab-text: #4a4a4f;               /* Sophisticated charcoal body text */
            --ab-text-light: #6c6c72;         /* Muted subtext */
            
            --ab-transition: all 0.4s cubic-bezier(0.25, 0.8, 0.25, 1);
        }

        body {
            font-family: 'Outfit', 'Poppins', sans-serif;
            background-color: var(--ab-bg);
            color: var(--ab-text);
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
            background-color: var(--ab-dark);
            background-image: linear-gradient(135deg, #302f35 0%, #1e1d23 100%);
            margin-top: 138px;                 /* Space below fixed header */
            display: flex;
            align-items: center;
            justify-content: center;
            overflow: hidden;
        }

        /* Diagonal ambient glow line overlay */
        .page-hero::before {
            content: '';
            position: absolute;
            width: 140%;
            height: 100%;
            top: 20%;
            left: -20%;
            background: radial-gradient(circle, var(--ab-gold) 0%, transparent 60%);
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
            color: var(--ab-gold);
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
           About Main Section (Who We Are)
           ========================================================================== */
        .about-section {
            padding: 120px 40px;
            position: relative;
        }

        .about-container {
            max-width: 1320px;
            margin: 0 auto;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 80px;
        }

        .about-content {
            flex: 1.2;
            max-width: 650px;
        }

        .about-micro-tag {
            display: inline-block;
            background: rgba(212, 175, 55, 0.12);
            color: var(--ab-gold);
            padding: 8px 18px;
            border-radius: 30px;
            font-size: 12px;
            font-weight: 600;
            letter-spacing: 1.8px;
            text-transform: uppercase;
            margin-bottom: 22px;
            border: 1px solid rgba(212, 175, 55, 0.25);
        }

        .section-title {
            font-family: 'Playfair Display', serif;
            font-size: 2.8rem;
            color: var(--ab-dark);
            margin: 0 0 15px 0;
            font-weight: 700;
            line-height: 1.2;
        }

        .section-title span {
            color: var(--ab-gold);
            font-style: italic;
        }

        .about-title-underline {
            width: 75px;
            height: 3px;
            background-color: var(--ab-gold);
            margin-bottom: 35px;
            border-radius: 2px;
            box-shadow: 0 0 10px rgba(212, 175, 55, 0.25);
        }

        .about-content p {
            font-size: 1.08rem;
            line-height: 1.85;
            color: var(--ab-text);
            margin: 0 0 25px 0;
            font-weight: 400;
        }

        .about-content p strong {
            color: var(--ab-dark);
            font-weight: 600;
        }

        /* Museum-framed image layouts */
        .about-image {
            flex: 1;
            display: flex;
            justify-content: center;
            align-items: center;
            position: relative;
        }

        .about-portrait-wrapper {
            position: relative;
            width: 100%;
            max-width: 440px;
            height: 520px;
        }

        .about-portrait-gold-frame {
            position: absolute;
            top: 24px;
            left: -24px;
            width: 100%;
            height: 100%;
            border: 3px solid var(--ab-gold);
            border-radius: 8px;
            box-shadow: 0 10px 30px rgba(212, 175, 55, 0.12), var(--ab-gold-glow);
            z-index: 1;
            transition: var(--ab-transition);
        }

        .about-portrait-img {
            position: relative;
            width: 100%;
            height: 100%;
            object-fit: cover;
            border-radius: 8px;
            border: 6px solid #ffffff;
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.1);
            z-index: 2;
            transition: var(--ab-transition);
        }

        /* 3D Translation animations on hover */
        .about-portrait-wrapper:hover .about-portrait-img {
            transform: translateY(-8px);
            box-shadow: 0 25px 45px rgba(0, 0, 0, 0.15);
        }

        .about-portrait-wrapper:hover .about-portrait-gold-frame {
            transform: translate(8px, -8px);
            box-shadow: 0 15px 35px rgba(212, 175, 55, 0.22);
        }

        /* ==========================================================================
           Vision & Mission (Symmetrical Columns)
           ========================================================================== */
        .vision-mission-section {
            padding: 100px 40px;
            background-color: #f7f7f9;
            border-top: 1px solid rgba(48, 47, 53, 0.05);
            position: relative;
        }

        .vm-container {
            max-width: 1320px;
            margin: 0 auto;
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 70px;
        }

        .vm-content {
            background: #ffffff;
            border: 1px solid rgba(48, 47, 53, 0.06);
            border-radius: 12px;
            padding: 50px 45px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.02);
            transition: var(--ab-transition);
        }

        .vm-content:hover {
            transform: translateY(-6px);
            box-shadow: 0 18px 40px rgba(0, 0, 0, 0.05);
            border-color: rgba(212, 175, 55, 0.2);
        }

        .vm-content h3 {
            font-family: 'Playfair Display', serif;
            font-size: 2.2rem;
            color: var(--ab-dark);
            margin: 0 0 15px 0;
            font-weight: 700;
        }

        .vm-content h3 span {
            color: var(--ab-gold);
            font-style: italic;
        }

        .vm-title-underline {
            width: 60px;
            height: 3px;
            background-color: var(--ab-gold);
            margin-bottom: 30px;
            border-radius: 2px;
        }

        .vm-content p {
            font-size: 1.05rem;
            line-height: 1.75;
            color: var(--ab-text);
            margin: 0 0 20px 0;
            font-weight: 400;
        }

        .vm-content p:last-child {
            margin-bottom: 0;
        }

        /* Custom list layout */
        .vm-list {
            list-style: none;
            padding: 0;
            margin: 0;
            display: flex;
            flex-direction: column;
            gap: 16px;
        }

        .vm-list li {
            display: flex;
            align-items: flex-start;
            gap: 15px;
            font-size: 1.05rem;
            line-height: 1.6;
            color: var(--ab-text);
        }

        .vm-list li i {
            color: var(--ab-gold);
            font-size: 14px;
            margin-top: 6px;
        }

        /* ==========================================================================
           RESPONSIVENESS (Responsive viewports stacking)
           ========================================================================== */
        @media screen and (max-width: 1200px) {
            .about-container {
                gap: 50px;
            }
            .section-title {
                font-size: 2.5rem;
            }
            .about-portrait-wrapper {
                height: 480px;
            }
            .vm-container {
                gap: 40px;
            }
        }

        @media screen and (max-width: 992px) {
            .page-hero {
                margin-top: 80px;       /* Spacing adjusts for simple header height */
                height: 35vh;
            }
            .page-hero-content h1 {
                font-size: 2.8rem;
            }
            .about-section {
                padding: 80px 30px;
            }
            .about-container {
                flex-direction: column;
                gap: 60px;
                text-align: center;
            }
            .about-content {
                max-width: 100%;
                display: flex;
                flex-direction: column;
                align-items: center;
            }
            .about-title-underline {
                margin: 0 auto 35px auto;
            }
            .about-portrait-wrapper {
                max-width: 380px;
                height: 450px;
            }
            .about-portrait-gold-frame {
                left: -15px;
                top: 15px;
            }
            .vision-mission-section {
                padding: 80px 30px;
            }
            .vm-container {
                grid-template-columns: 1fr;
                gap: 40px;
            }
            .vm-content {
                padding: 40px 35px;
            }
        }

        @media screen and (max-width: 768px) {
            .page-hero-content h1 {
                font-size: 2.3rem;
            }
            .page-hero-content p {
                font-size: 1rem;
            }
            .section-title {
                font-size: 2.1rem;
            }
            .about-content p {
                font-size: 1rem;
                line-height: 1.75;
            }
            .about-portrait-wrapper {
                height: 380px;
            }
            .vm-content h3 {
                font-size: 1.8rem;
            }
            .vm-content p, .vm-list li {
                font-size: 0.98rem;
            }
        }
    </style>
</head>
<body>
    <?php include 'includes/header.php'; ?>

    <!-- Page Title Hero -->
    <section class="page-hero">
        <div class="page-hero-content">
            <h1>About <span>Guru Ghar Estate</span></h1>
            <p>Pushing horizons of possibilities by turning your dream house into a reality with our passionate, experienced, and dedicated team.</p>
        </div>
    </section>
 
    <!-- Section A: Overview & Portrait -->
    <section class="about-section">
        <div class="about-container">
            
            <div class="about-content">
                <span class="about-micro-tag">WHO WE ARE</span>
                <h2 class="section-title">Architects of <span>Luxurious Living</span></h2>
                <div class="about-title-underline"></div>
                
                <p><strong>Guru Ghar Estate</strong> is one of the fastest-growing construction and real estate consultancy companies in Faridabad and the Delhi NCR region. Stitched together by brilliant minds with clear business values, we build on the foundations of trust, quality, and structural excellence.</p>
                <p>With more than 10 years of diverse, hands-on industry experience, Guru Ghar Estate delivers exceptionally spacious residential units, custom European-style elevations, and bulletproof project timelines. We design masterworks that are rich in modern premium aesthetics and durable for generations.</p>
                <p>The vast industry experience and oversight of our founders, <strong>Sandeep Goel</strong> and <strong>Pravesh Goel</strong>, ensure our material choices, team Alignments, and finishings represent global benchmarks. We work consistently to materialize client dreams into lifetime sanctuaries.</p>
            </div>
            
            <div class="about-image">
                <div class="about-portrait-wrapper">
                    <!-- Golden offset frame -->
                    <div class="about-portrait-gold-frame"></div>
                    <!-- Main page jpeg image asset -->
                    <img src="assets/about-us.jpeg?v=<?= time() ?>" alt="Guru Ghar Estate Premium Real Estate Architecture" class="about-portrait-img">
                </div>
            </div>
            
        </div>
    </section>

    <!-- Section B: Symmetrical Vision & Mission Columns -->
    <section class="vision-mission-section">
        <div class="vm-container">
            
            <!-- Vision Card -->
            <div class="vm-content">
                <h3>Our <span>Vision</span></h3>
                <div class="vm-title-underline"></div>
                
                <p>To be the premier real estate group in the region by paving a pathway for the finest level of quality construction, and to consistently design modern, sustainable, and high-end residential builder floors.</p>
                
                <ul class="vm-list">
                    <li><i class="fa-solid fa-circle-check"></i> <span>Build lifelong relationships founded on commitment, trust, and absolute integrity.</span></li>
                    <li><i class="fa-solid fa-circle-check"></i> <span>Consistently remain the preferred choice for premium luxury buyer requirements.</span></li>
                    <li><i class="fa-solid fa-circle-check"></i> <span>Combine architectural beauty with affordable engineering standards.</span></li>
                </ul>
            </div>
            
            <!-- Mission Card -->
            <div class="vm-content">
                <h3>Our <span>Mission</span></h3>
                <div class="vm-title-underline"></div>
                
                <p>Guru Ghar Estate is working on a mission of establishing an atmosphere of trust, clear transparency, and zero-compromise professionalism inside the regional real estate market.</p>
                
                <ul class="vm-list">
                    <li><i class="fa-solid fa-circle-check"></i> <span>Exceed the limits of client expectations with every residential floor layout delivered.</span></li>
                    <li><i class="fa-solid fa-circle-check"></i> <span>Ensure strict adherence to timelines and professional code ethics across site casting actions.</span></li>
                    <li><i class="fa-solid fa-circle-check"></i> <span>Integrate ongoing architectural innovations and environment-friendly building materials.</span></li>
                </ul>
            </div>
            
        </div>
    </section>

    <?php include 'includes/footer.php'; ?>
</body>
</html>

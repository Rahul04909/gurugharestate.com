<!-- components/projects-map.php -->
<link rel="stylesheet" href="assets/css/projects-map.css?v=<?= time() ?>">

<section class="projects-map-section">
    <!-- Beautiful Glowing Ambient Overlay Elements -->
    <div class="map-bg-glow glow-1"></div>
    <div class="map-bg-glow glow-2"></div>

    <div class="projects-map-container">
        
        <!-- Left Side: Interactive Location Explorer & Stats -->
        <div class="p-map-content">
            <div class="p-map-badge">ELITE NCR ADDRESSES</div>
            
            <h2>Presence of <br><span class="gold-text">Guru Ghar Estate</span></h2>
            <div class="p-map-title-underline"></div>
            
            <p class="p-map-description">We build luxury architectural masterworks in India's most highly-sought residential neighborhoods. Explore our active premier hubs across Delhi NCR, meticulously designed for multi-generational elegance.</p>
            
            <!-- Dynamic Interactive Location Cards Grid (Clean Premium 2x2 Layout) -->
            <div class="map-location-selector">
                <div class="loc-card active" data-location="faridabad">
                    <span class="loc-dot"></span>
                    <div class="loc-card-info">
                        <h4>Faridabad</h4>
                        <span class="loc-count">15+ Floors</span>
                    </div>
                </div>
                <div class="loc-card" data-location="gurugram">
                    <span class="loc-dot"></span>
                    <div class="loc-card-info">
                        <h4>Gurugram</h4>
                        <span class="loc-count">8+ Projects</span>
                    </div>
                </div>
                <div class="loc-card" data-location="delhi">
                    <span class="loc-dot"></span>
                    <div class="loc-card-info">
                        <h4>South Delhi</h4>
                        <span class="loc-count">5+ Floors</span>
                    </div>
                </div>
                <div class="loc-card" data-location="noida">
                    <span class="loc-dot"></span>
                    <div class="loc-card-info">
                        <h4>Noida NCR</h4>
                        <span class="loc-count">Upcoming</span>
                    </div>
                </div>
            </div>

            <!-- Real Estate Statistics with GSAP Tweens -->
            <div class="p-map-stats">
                <div class="stat-card">
                    <h3><span class="stat-number" data-target="25">0</span>+</h3>
                    <p>Premium Projects</p>
                </div>
                <div class="stat-card">
                    <h3><span class="stat-number" data-target="10">0</span>M+</h3>
                    <p>Sq.Ft. Delivered</p>
                </div>
            </div>

            <a href="projects.php" class="btn-primary map-cta-btn">View All Projects <i class="fa-solid fa-arrow-right"></i></a>
        </div>

        <!-- Right Side: Interactive Map Visual -->
        <div class="p-map-visual">
            <div class="map-wrapper">
                <img src="assets/delhi-ncr-map.jpg?v=<?= time() ?>" alt="Guru Ghar Estate Presence Map" class="main-map-img">
            </div>

            <!-- Glassmorphic Tooltip Card displaying Active Location Details -->
            <div class="map-tooltip-box">
                <div class="tooltip-header">
                    <span class="tooltip-badge">CORE LUXURY HUB</span>
                    <h4 id="tooltip-title">Faridabad</h4>
                </div>
                <p id="tooltip-desc">15+ Handcrafted premium builder floors in elite Sectors 14, 15, 21, and 85. Our main center of design excellence featuring European architectural elevations, marble flooring, and modular setups.</p>
                <div class="tooltip-footer">
                    <div class="tooltip-stat">
                        <span class="t-label">Status</span>
                        <span class="t-val text-green" id="tooltip-status">Ready to Move & Ongoing</span>
                    </div>
                    <div class="tooltip-stat">
                        <span class="t-label">Price Range</span>
                        <span class="t-val" id="tooltip-price">₹1.5Cr - ₹4.5Cr</span>
                    </div>
                </div>
            </div>
        </div>

    </div>
</section>

<!-- GSAP (GreenSock Animation Platform) & ScrollTrigger CDN Libraries -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.2/gsap.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.2/ScrollTrigger.min.js"></script>

<script>
document.addEventListener("DOMContentLoaded", function() {
    // Register GSAP ScrollTrigger
    gsap.registerPlugin(ScrollTrigger);

    // Interactive details database for mapping selector nodes
    const locationData = {
        faridabad: {
            title: "Faridabad",
            badge: "CORE LUXURY HUB",
            desc: "15+ Handcrafted premium builder floors in elite Sectors 14, 15, 21, and 85. Our main center of design excellence featuring European architectural elevations, marble flooring, and modular setups.",
            status: "Ready to Move & Ongoing",
            price: "₹1.5Cr - ₹4.5Cr"
        },
        gurugram: {
            title: "Gurugram Hub",
            badge: "PREMIUM ELITE SECTOR",
            desc: "8+ Ultra-luxury builder floors along Golf Course Extension Road. Crafted specifically for executives seeking unparalleled connectivity, automated smart home integrations, and serene high-end societies.",
            status: "Ongoing & Booking Open",
            price: "₹2.5Cr - ₹6.5Cr"
        },
        delhi: {
            title: "South Delhi Hub",
            badge: "ULTRA-LUXURY COLLECTION",
            desc: "5+ Super premium architectural residences in Greater Kailash, Vasant Vihar, and Panchsheel. Elegant collaborations with top designers delivering landmark addresses with double-height lobbies and security.",
            status: "Exclusive Collaboration",
            price: "₹4.5Cr - ₹12.0Cr"
        },
        noida: {
            title: "Noida NCR",
            badge: "MODERN RESIDENCES",
            desc: "Upcoming luxury residences strategically positioned in Sectors 44, 105, and 150. Offering unparalleled green space integration, modern clubhouses, high-speed lift systems, and world-class structural health.",
            status: "Pre-Launch Bookings",
            price: "₹1.8Cr - ₹3.8Cr"
        }
    };

    // 1. Entry scroll transitions using GSAP (Only decorative containers for robust rendering)
    // Left content loads statically by default to guarantee 100% visibility on all devices
    gsap.from(".p-map-visual .map-wrapper", {
        opacity: 0,
        scale: 0.95,
        duration: 1,
        ease: "power2.out",
        scrollTrigger: {
            trigger: ".projects-map-section",
            start: "top 75%"
        }
    });

    // Floating dynamic tooltip box entrance
    gsap.from(".map-tooltip-box", {
        opacity: 0,
        y: 25,
        scale: 0.98,
        duration: 1,
        ease: "power2.out",
        scrollTrigger: {
            trigger: ".projects-map-section",
            start: "top 65%"
        }
    });

    // Dynamic numeric stats counter count-ups
    gsap.utils.toArray(".stat-number").forEach(function(stat) {
        const target = parseInt(stat.getAttribute("data-target"), 10);
        gsap.fromTo(stat, {
            textContent: 0
        }, {
            textContent: target,
            duration: 1.8,
            ease: "power2.out",
            snap: { textContent: 1 },
            scrollTrigger: {
                trigger: ".projects-map-section",
                start: "top 75%",
                toggleActions: "play none none none"
            }
        });
    });

    // 2. Interactive Selector Action Bindings
    const locCards = document.querySelectorAll(".loc-card");
    const tooltipBox = document.querySelector(".map-tooltip-box");

    function activateLocation(locKey) {
        const data = locationData[locKey];
        if (!data) return;

        // Strip current active selections
        locCards.forEach(c => c.classList.remove("active"));

        // Set matching card as active
        const targetCard = document.querySelector(`.loc-card[data-location="${locKey}"]`);
        if (targetCard) targetCard.classList.add("active");

        // Prevent layout transitions clashing by killing current animations
        gsap.killTweensOf(tooltipBox);

        // GSAP dynamic crossfade for tooltip detail cards
        gsap.to(tooltipBox, {
            opacity: 0,
            y: 15,
            duration: 0.15,
            onComplete: function() {
                // Update raw text nodes inside card bounds
                document.getElementById("tooltip-title").textContent = data.title;
                document.querySelector(".tooltip-badge").textContent = data.badge;
                document.getElementById("tooltip-desc").textContent = data.desc;
                document.getElementById("tooltip-status").textContent = data.status;
                document.getElementById("tooltip-price").textContent = data.price;

                // Alternate state color tag classes for launch variables
                const statusEl = document.getElementById("tooltip-status");
                if (locKey === "noida") {
                    statusEl.className = "t-val text-gold";
                } else {
                    statusEl.className = "t-val text-green";
                }

                // Smoothly fade back into view
                gsap.to(tooltipBox, {
                    opacity: 1,
                    y: 0,
                    duration: 0.25,
                    ease: "power2.out"
                });
            }
        });
    }

    // Connect location card trigger bounds
    locCards.forEach(card => {
        card.addEventListener("click", function() {
            const locKey = this.getAttribute("data-location");
            activateLocation(locKey);
        });
    });
});
</script>

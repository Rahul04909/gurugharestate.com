<!-- components/projects-map.php -->
<link rel="stylesheet" href="assets/css/projects-map.css">

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
            
            <!-- Dynamic Interactive Location Cards Grid -->
            <div class="map-location-selector">
                <div class="loc-card active" data-location="faridabad">
                    <div class="loc-card-header">
                        <span class="loc-dot"></span>
                        <h4>Faridabad (HQ)</h4>
                        <span class="loc-count">15+ Floors</span>
                    </div>
                    <p>Handcrafted premium builder floors in elite sectors 14, 15, 21, and 85.</p>
                </div>
                <div class="loc-card" data-location="gurugram">
                    <div class="loc-card-header">
                        <span class="loc-dot"></span>
                        <h4>Gurugram</h4>
                        <span class="loc-count">8+ Projects</span>
                    </div>
                    <p>High-end modern residential floors along Golf Course Extension Road.</p>
                </div>
                <div class="loc-card" data-location="delhi">
                    <div class="loc-card-header">
                        <span class="loc-dot"></span>
                        <h4>South Delhi</h4>
                        <span class="loc-count">5+ Residences</span>
                    </div>
                    <p>Ultra-luxury architectural collaborations in Vasant Vihar and GK-II.</p>
                </div>
                <div class="loc-card" data-location="noida">
                    <div class="loc-card-header">
                        <span class="loc-dot"></span>
                        <h4>Noida NCR</h4>
                        <span class="loc-count">Upcoming</span>
                    </div>
                    <p>Modern luxury spaces situated in active, hyper-connected residential hubs.</p>
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

        <!-- Right Side: Interactive Map & Floating Visual Pins -->
        <div class="p-map-visual">
            <div class="map-wrapper">
                <img src="assets/map.svg?v=<?= time() ?>" alt="Guru Ghar Estate Presence Map" class="main-map-img">
                
                <!-- Pulsing Golden Hotspot Pin representing collective Delhi NCR presence -->
                <div class="map-pin pin-delhi active" data-location="delhi" title="Delhi NCR Presence">
                    <div class="pin-pulse"></div>
                    <div class="pin-inner"></div>
                </div>
            </div>

            <!-- Glassmorphic Tooltip Card displaying Active Location Details -->
            <div class="map-tooltip-box">
                <div class="tooltip-header">
                    <span class="tooltip-badge">CORE LUXURY HUB</span>
                    <h4 id="tooltip-title">Faridabad (HQ)</h4>
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
            title: "Faridabad (HQ)",
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

    // 1. Entry scroll transitions using GSAP
    gsap.from(".p-map-content .p-map-badge, .p-map-content h2, .p-map-content .p-map-title-underline, .p-map-content .p-map-description", {
        opacity: 0,
        y: 40,
        duration: 1,
        stagger: 0.15,
        ease: "power2.out",
        scrollTrigger: {
            trigger: ".projects-map-section",
            start: "top 75%",
            toggleActions: "play none none none"
        }
    });

    // Staggered interactive location cards appearance
    gsap.from(".map-location-selector .loc-card", {
        opacity: 0,
        x: -45,
        duration: 0.8,
        stagger: 0.12,
        ease: "power2.out",
        scrollTrigger: {
            trigger: ".map-location-selector",
            start: "top 80%"
        }
    });

    // Map visual boundaries reveal
    gsap.from(".p-map-visual .main-map-img", {
        opacity: 0,
        scale: 0.93,
        duration: 1.4,
        ease: "power3.out",
        scrollTrigger: {
            trigger: ".p-map-visual",
            start: "top 75%"
        }
    });

    // Elastic dropping pins
    gsap.from(".p-map-visual .map-pin", {
        opacity: 0,
        y: -80,
        scale: 0,
        duration: 1.4,
        ease: "elastic.out(1, 0.45)",
        stagger: 0.15,
        scrollTrigger: {
            trigger: ".p-map-visual",
            start: "top 70%"
        }
    });

    // Floating dynamic tooltip box entrance
    gsap.from(".map-tooltip-box", {
        opacity: 0,
        y: 40,
        scale: 0.95,
        duration: 1.2,
        ease: "power2.out",
        scrollTrigger: {
            trigger: ".p-map-visual",
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
            duration: 2,
            ease: "power2.out",
            snap: { textContent: 1 },
            scrollTrigger: {
                trigger: ".p-map-stats",
                start: "top 85%",
                toggleActions: "play none none none"
            }
        });
    });

    // 2. Interactive Selector Action Bindings
    const locCards = document.querySelectorAll(".loc-card");
    const mapPins = document.querySelectorAll(".map-pin");
    const tooltipBox = document.querySelector(".map-tooltip-box");

    function activateLocation(locKey) {
        const data = locationData[locKey];
        if (!data) return;

        // Strip current active selections
        locCards.forEach(c => c.classList.remove("active"));
        mapPins.forEach(p => p.classList.remove("active"));

        // Set matching components as active
        const targetCard = document.querySelector(`.loc-card[data-location="${locKey}"]`);
        const targetPin = document.querySelector(`.map-pin.pin-delhi`);
        
        if (targetCard) targetCard.classList.add("active");
        if (targetPin) targetPin.classList.add("active");

        // Staggered bounce scale transition on pin to draw immediate focus
        if (targetPin) {
            gsap.fromTo(targetPin, 
                { scale: 1 }, 
                { scale: 1.3, duration: 0.25, yoyo: true, repeat: 1, ease: "power1.out" }
            );
        }

        // GSAP dynamic crossfade for tooltip detail cards
        gsap.to(tooltipBox, {
            opacity: 0,
            y: 15,
            duration: 0.2,
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
                    duration: 0.35,
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

    // Connect hotspot pin triggers
    mapPins.forEach(pin => {
        pin.addEventListener("click", function() {
            const locKey = this.getAttribute("data-location");
            activateLocation(locKey);
        });
    });
});
</script>

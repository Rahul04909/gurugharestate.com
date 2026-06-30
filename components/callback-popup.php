<!-- components/callback-popup.php -->
<link rel="stylesheet" href="assets/css/callback-popup.css?v=<?= time() ?>">

<div id="callbackModalOverlay" class="callback-modal-overlay">
    <div class="callback-modal-card">
        <!-- Close Button -->
        <button id="callbackCloseBtn" class="callback-close-btn" aria-label="Close modal">
            <i class="fa-solid fa-xmark"></i>
        </button>

        <!-- Header -->
        <div class="callback-header">
            <h2 class="callback-title-small">Looking for something specific?</h2>
            <h2 class="callback-title-accent">We're just a call away.</h2>
            <p class="callback-subtitle">Share your number below and we'll call you back shortly.</p>
        </div>

        <!-- Alert Notification Panel -->
        <div id="callbackAlert" class="callback-alert"></div>

        <!-- Submission Form -->
        <form id="callbackForm" class="callback-form" novalidate>
            <!-- Name Input Group -->
            <div class="callback-input-group">
                <label for="cbName">Full Name *</label>
                <div class="callback-input-wrapper">
                    <i class="fa-solid fa-user callback-input-icon"></i>
                    <input type="text" id="cbName" name="name" class="callback-input-field"
                           placeholder="Enter your full name" autocomplete="name" required>
                </div>
            </div>

            <!-- Phone Input Group -->
            <div class="callback-input-group">
                <label for="cbPhone">Phone Number *</label>
                <div class="callback-input-wrapper">
                    <!-- Indian Flag Prefix Container -->
                    <div class="phone-prefix-container">
                        <div class="indian-flag-icon">
                            <svg width="20" height="13" viewBox="0 0 3 2" style="display:block;">
                                <rect width="3" height="2" fill="#F4C430"/>
                                <rect width="3" height="1.33" fill="#FFF"/>
                                <rect width="3" height="0.67" fill="#090"/>
                                <circle cx="1.5" cy="1" r="0.2" fill="#000080"/>
                            </svg>
                        </div>
                        <span class="phone-prefix-text">+91</span>
                    </div>
                    <input type="tel" id="cbPhone" name="phone" class="callback-input-field callback-phone-field"
                           placeholder="81234 56789" autocomplete="tel" required maxlength="10">
                </div>
            </div>

            <!-- Submit Button -->
            <button type="submit" id="callbackSubmitBtn" class="callback-submit-btn">
                <i class="fa-solid fa-phone-volume"></i> Call me back
            </button>
        </form>

        <!-- Footer Links -->
        <div class="callback-footer">
            <div class="callback-secure-text">
                <i class="fa-solid fa-shield-halved"></i>
                <span>Rest assured, your details are secure with us.</span>
            </div>
            <div class="callback-links-block">
                <div class="callback-link-row">
                    <span>Have a custom requirement?</span>
                    <a href="contact-us.php">Write to us</a>
                </div>
                <div class="callback-link-row">
                    <span>In a hurry? Call us now</span>
                    <a href="tel:+919999566126">+91 99995 66126</a>
                </div>
                <p class="callback-hint-text">*Please enter your 10-digit mobile number.</p>
            </div>
        </div>
    </div>
</div>

<script>
(function () {
    'use strict';

    var STORAGE_KEY  = 'gurughar_callback_popup_dismissed';
    var POPUP_DELAY  = 5000; // 5 seconds

    var overlay    = document.getElementById('callbackModalOverlay');
    var closeBtn   = document.getElementById('callbackCloseBtn');
    var form       = document.getElementById('callbackForm');
    var alertBox   = document.getElementById('callbackAlert');
    var phoneInput = document.getElementById('cbPhone');
    var submitBtn  = document.getElementById('callbackSubmitBtn');

    /* ── Digits-only for phone ── */
    phoneInput.addEventListener('input', function () {
        this.value = this.value.replace(/[^0-9]/g, '').slice(0, 10);
    });

    /* ── Show / hide popup ── */
    function openPopup() {
        overlay.classList.add('show');
        document.body.style.overflow = 'hidden';
    }

    function closePopup(dismiss) {
        overlay.classList.remove('show');
        document.body.style.overflow = '';
        if (dismiss) {
            localStorage.setItem(STORAGE_KEY, Date.now().toString());
        }
    }

    /* ── Alert helper ── */
    function showAlert(type, message) {
        alertBox.className = 'callback-alert callback-alert-' + type;
        alertBox.innerHTML =
            '<i class="fa-solid ' + (type === 'success' ? 'fa-circle-check' : 'fa-circle-exclamation') + '"></i> ' +
            '<span>' + message + '</span>';
        alertBox.style.display = 'flex';
    }

    function hideAlert() {
        alertBox.style.display = 'none';
        alertBox.className = 'callback-alert';
        alertBox.innerHTML = '';
    }

    /* ── Close button & overlay click ── */
    closeBtn.addEventListener('click', function () { closePopup(true); });
    overlay.addEventListener('click', function (e) {
        if (e.target === overlay) { closePopup(true); }
    });

    /* ── Form submission via Fetch API ── */
    form.addEventListener('submit', function (e) {
        e.preventDefault();

        var name  = document.getElementById('cbName').value.trim();
        var phone = phoneInput.value.trim();

        hideAlert();

        if (name.length < 2) {
            showAlert('danger', 'Please enter your full name (minimum 2 characters).');
            return;
        }
        if (phone.length !== 10) {
            showAlert('danger', 'Please enter exactly 10 digits for your mobile number.');
            return;
        }

        /* Disable button */
        submitBtn.disabled = true;
        submitBtn.innerHTML = '<i class="fa-solid fa-spinner fa-spin"></i> Processing...';

        /* Build form data */
        var formData = new FormData();
        formData.append('name', name);
        formData.append('phone', '+91' + phone);

        fetch('submit-callback.php', {
            method: 'POST',
            body: formData
        })
        .then(function (res) { return res.json(); })
        .then(function (data) {
            if (data.success) {
                showAlert('success', data.message);
                form.style.display = 'none';
                /* Suppress popup permanently after successful submission */
                localStorage.setItem(STORAGE_KEY, (Date.now() + 315360000000).toString()); // +10 years
                setTimeout(function () { closePopup(false); }, 3500);
            } else {
                showAlert('danger', data.message || 'Something went wrong. Please try again.');
                submitBtn.disabled = false;
                submitBtn.innerHTML = '<i class="fa-solid fa-phone-volume"></i> Call me back';
            }
        })
        .catch(function () {
            showAlert('danger', 'An error occurred. Please try again.');
            submitBtn.disabled = false;
            submitBtn.innerHTML = '<i class="fa-solid fa-phone-volume"></i> Call me back';
        });
    });

    /* ── Trigger on load ── */
    function checkAndShow() {
        var stored = localStorage.getItem(STORAGE_KEY);
        var now    = Date.now();

        /* Show if: never dismissed, OR 24 h have passed since last dismissal */
        if (!stored || (now - parseInt(stored, 10) > 86400000)) {
            setTimeout(function () {
                /* Don't open if the Enquire Now header modal is already open */
                var headerModal = document.getElementById('headerEnquireModal');
                if (headerModal && headerModal.classList.contains('show')) { return; }
                openPopup();
            }, POPUP_DELAY);
        }
    }

    /* Run after the full page has loaded */
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', checkAndShow);
    } else {
        checkAndShow();
    }
})();
</script>

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
        <div id="callbackAlert" class="callback-alert">
            <i id="callbackAlertIcon" class="fa-solid"></i>
            <span id="callbackAlertText"></span>
        </div>

        <!-- Submission Form -->
        <form id="callbackForm" class="callback-form" novalidate>
            <!-- Name Input Group -->
            <div class="callback-input-group">
                <label for="cbName">Full Name *</label>
                <div class="callback-input-wrapper">
                    <i class="fa-solid fa-user callback-input-icon"></i>
                    <input type="text" id="cbName" name="name" class="callback-input-field" placeholder="Enter your full name" autocomplete="name" required>
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
                    <input type="tel" id="cbPhone" name="phone" class="callback-input-field callback-phone-field" placeholder="81234 56789" autocomplete="tel" required maxlength="10">
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
                    <a href="contact-us.php" id="cbWriteToUs">Write to us</a>
                </div>
                <div class="callback-link-row">
                    <span>In a hurry? Call us now</span>
                    <a href="tel:+919999566126" id="cbCallNow">+91 99995 66126</a>
                </div>
                <p class="callback-hint-text">*Please enter your 10-digit mobile number.</p>
            </div>
        </div>
    </div>
</div>

<script>
$(document).ready(function() {
    const $overlay = $('#callbackModalOverlay');
    const $closeBtn = $('#callbackCloseBtn');
    const $form = $('#callbackForm');
    const $alert = $('#callbackAlert');
    const $alertIcon = $('#callbackAlertIcon');
    const $alertText = $('#callbackAlertText');
    const $submitBtn = $('#callbackSubmitBtn');
    
    const STORAGE_KEY = 'gurughar_callback_popup_dismissed';
    const POPUP_DELAY_MS = 5000; // 5 seconds delay

    // Allow digits only for phone number field
    $('#cbPhone').on('input', function() {
        this.value = this.value.replace(/[^0-9]/g, '').slice(0, 10);
    });

    // Check if popup should be shown
    function checkAndShowPopup() {
        const dismissedTime = localStorage.getItem(STORAGE_KEY);
        const currentTime = new Date().getTime();
        
        // Show if not dismissed, or if 24 hours have passed since last dismissal (24 * 60 * 60 * 1000 = 86400000 ms)
        if (!dismissedTime || (currentTime - parseInt(dismissedTime) > 86400000)) {
            setTimeout(function() {
                // Ensure no other modal is currently active on load before opening
                if (!$('.header-modal').hasClass('show')) {
                    $overlay.addClass('show');
                    $('body').css('overflow', 'hidden');
                }
            }, POPUP_DELAY_MS);
        }
    }

    // Close and dismiss logic
    function closePopup(permanent = false) {
        $overlay.removeClass('show');
        $('body').css('overflow', '');
        
        if (permanent) {
            localStorage.setItem(STORAGE_KEY, new Date().getTime().toString());
        }
    }

    // Bind close events
    $closeBtn.on('click', function() {
        closePopup(true); // Dismiss for 24 hours
    });

    $overlay.on('click', function(e) {
        if (e.target === this) {
            closePopup(true); // Dismiss for 24 hours
        }
    });

    // Handle AJAX Submission
    $form.on('submit', function(e) {
        e.preventDefault();
        
        // Front-end Validation
        const name = $.trim($('#cbName').val());
        const phone = $.trim($('#cbPhone').val());
        
        $alert.removeClass('callback-alert-success callback-alert-danger').hide();

        if (name.length < 2) {
            showAlert('danger', 'fa-circle-exclamation', 'Please enter your full name (minimum 2 characters).');
            return;
        }

        if (phone.length !== 10) {
            showAlert('danger', 'fa-circle-exclamation', 'Please enter exactly 10 digits for your mobile number.');
            return;
        }

        // Disable button to prevent double click
        $submitBtn.prop('disabled', true).html('<i class="fa-solid fa-spinner fa-spin"></i> Processing...');

        // AJAX POST Request
        $.ajax({
            url: 'submit-callback.php',
            type: 'POST',
            dataType: 'json',
            data: {
                name: name,
                phone: '+91' + phone
            },
            success: function(response) {
                if (response.success) {
                    showAlert('success', 'fa-circle-check', response.message);
                    $form.slideUp(300);
                    
                    // Permanent dismissal on successful submission
                    localStorage.setItem(STORAGE_KEY, (new Date().getTime() + 10 * 365 * 24 * 60 * 60 * 1000).toString()); // 10 years expiration
                    
                    // Close after 3.5 seconds
                    setTimeout(function() {
                        closePopup(false);
                    }, 3500);
                } else {
                    showAlert('danger', 'fa-circle-exclamation', response.message);
                    $submitBtn.prop('disabled', false).html('<i class="fa-solid fa-phone-volume"></i> Call me back');
                }
            },
            error: function() {
                showAlert('danger', 'fa-circle-exclamation', 'An error occurred. Please try again.');
                $submitBtn.prop('disabled', false).html('<i class="fa-solid fa-phone-volume"></i> Call me back');
            }
        });
    });

    function showAlert(type, iconClass, message) {
        $alert.removeClass('callback-alert-success callback-alert-danger');
        $alertIcon.removeClass();
        
        $alert.addClass('callback-alert-' + type);
        $alertIcon.addClass('fa-solid ' + iconClass);
        $alertText.text(message);
        
        $alert.css('display', 'flex').hide().fadeIn(200);
    }

    // Trigger Popup Check
    checkAndShowPopup();
});
</script>

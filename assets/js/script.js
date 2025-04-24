// Mobile menu toggle
document.addEventListener('DOMContentLoaded', function() {
    const menuToggle = document.getElementById('menu-toggle');
    const navMenu = document.getElementById('nav-menu');

    if (menuToggle && navMenu) {
        menuToggle.addEventListener('click', function() {
            navMenu.classList.toggle('active');

            // Animate hamburger to X
            const spans = menuToggle.querySelectorAll('span');
            if (spans[0] && spans[1] && spans[2]) {
                if (navMenu.classList.contains('active')) {
                    spans[0].style.transform = 'rotate(45deg) translate(5px, 5px)';
                    spans[1].style.opacity = '0';
                    spans[2].style.transform = 'rotate(-45deg) translate(5px, -5px)';
                } else {
                    spans[0].style.transform = 'rotate(0)';
                    spans[1].style.opacity = '1';
                    spans[2].style.transform = 'rotate(0)';
                }
            }
        });

        // Close menu when clicking outside
        document.addEventListener('click', function(event) {
            if (
                navMenu.classList.contains('active') &&
                !navMenu.contains(event.target) &&
                !menuToggle.contains(event.target)
            ) {
                navMenu.classList.remove('active');
                const spans = menuToggle.querySelectorAll('span');
                if (spans[0] && spans[1] && spans[2]) {
                    spans[0].style.transform = 'rotate(0)';
                    spans[1].style.opacity = '1';
                    spans[2].style.transform = 'rotate(0)';
                }
            }
        });
    }

    // Form validation
    const contactForm = document.querySelector('form');
    if (contactForm) {
        contactForm.addEventListener('submit', function(event) {
            let valid = true;
            const requiredFields = contactForm.querySelectorAll('[required]');

            requiredFields.forEach(field => {
                if (!field.value.trim()) {
                    valid = false;
                    field.style.borderColor = 'var(--error-color)';
                } else {
                    field.style.borderColor = 'var(--border-color)';
                }
            });

            // Email validation
            const emailField = contactForm.querySelector('input[type="email"]');
            if (emailField && emailField.value.trim()) {
                const emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
                if (!emailPattern.test(emailField.value.trim())) {
                    valid = false;
                    emailField.style.borderColor = 'var(--error-color)';
                }
            }

            if (!valid) {
                event.preventDefault();
                alert('Veuillez remplir correctement tous les champs obligatoires.');
            }
        });
    }
});
// Minimal client-side JS for menu toggle, scroll effect, and FAQ accordion

document.addEventListener('DOMContentLoaded', function () {

    // Mobile menu toggle
    const hamburger = document.getElementById('hamburger-btn');
    const sideMenu  = document.getElementById('side-menu');
    const closeBtn  = document.getElementById('close-menu');

    if (hamburger && sideMenu) {
        hamburger.addEventListener('click', function () {
            sideMenu.classList.add('open');
        });
    }
    if (closeBtn && sideMenu) {
        closeBtn.addEventListener('click', function () {
            sideMenu.classList.remove('open');
        });
    }

    // Navbar scroll effect
    const navbar = document.querySelector('.navbar');
    if (navbar) {
        window.addEventListener('scroll', function () {
            if (window.scrollY > 50) {
                navbar.classList.add('scrolled');
            } else {
                navbar.classList.remove('scrolled');
            }
        });
    }

    // FAQ accordion toggle
    document.querySelectorAll('.faq-card .question').forEach(function (btn) {
        btn.addEventListener('click', function () {
            const card = btn.closest('.faq-card');
            const wasOpen = card.classList.contains('open');
            document.querySelectorAll('.faq-card').forEach(c => c.classList.remove('open'));
            if (!wasOpen) card.classList.add('open');
        });
    });

    // Challenges category filter (client-side, just for UX)
    const typeButtons = document.querySelectorAll('.type-option');
    typeButtons.forEach(function (btn) {
        btn.addEventListener('click', function () {
            const type = btn.dataset.type;
            typeButtons.forEach(b => b.classList.remove('active'));
            btn.classList.add('active');
            document.querySelectorAll('.full-card').forEach(function (card) {
                if (type === 'all' || card.dataset.category === type) {
                    card.style.display = '';
                } else {
                    card.style.display = 'none';
                }
            });
        });
    });

});

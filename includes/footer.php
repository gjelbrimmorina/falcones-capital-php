</main>

<footer class="footer">
    <div class="wrapper">
        <div class="footer-cols">
            <div class="footer-about">
                <a href="<?php echo url('index.php'); ?>" class="logo">
                    <img src="<?php echo asset('images/logo.png'); ?>" alt="Falcones Capital" class="logo-img">
                    <span>Falcones Capital</span>
                </a>
                <p>Built by traders for traders. Access simulated trading capital up to $300,000.</p>
                <div class="socials">
                    <a href="#"><i class="fab fa-discord"></i></a>
                    <a href="#"><i class="fab fa-twitter"></i></a>
                    <a href="#"><i class="fab fa-instagram"></i></a>
                    <a href="#"><i class="fab fa-youtube"></i></a>
                </div>
            </div>
            <div class="footer-menu">
                <h4>Quick Links</h4>
                <ul>
                    <li><a href="<?php echo url('challenges.php'); ?>">Buy Challenge</a></li>
                    <li><a href="<?php echo url('trading-rules.php'); ?>">Trading Rules</a></li>
                    <li><a href="<?php echo url('about.php'); ?>">About Us</a></li>
                    <li><a href="<?php echo url('faq.php'); ?>">FAQs</a></li>
                </ul>
            </div>
            <div class="footer-menu">
                <h4>Legal</h4>
                <ul>
                    <li><a href="#">Terms of Service</a></li>
                    <li><a href="#">Privacy Policy</a></li>
                    <li><a href="#">Risk Disclosure</a></li>
                    <li><a href="#">Refund Policy</a></li>
                </ul>
            </div>
            <div class="footer-menu">
                <h4>Support</h4>
                <ul>
                    <li><a href="<?php echo url('contact.php'); ?>">Contact Us</a></li>
                    <li><a href="#">Live Chat</a></li>
                    <li><a href="#">Discord</a></li>
                    <li><a href="mailto:<?php echo e($GLOBALS['CONTACT_EMAIL']); ?>">Email</a></li>
                </ul>
            </div>
        </div>
        <div class="copyright">
            <p>&copy; <?php echo (int) $GLOBALS['CURRENT_YEAR']; ?> <?php echo e($GLOBALS['SITE_NAME']); ?>. All rights reserved.</p>
        </div>
    </div>
</footer>

<script src="<?php echo asset('js/main.js'); ?>"></script>
</body>
</html>

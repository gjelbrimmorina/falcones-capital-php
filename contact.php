<?php
$pageTitle = 'Contact Us';
require_once __DIR__ . '/includes/header.php';

// Form handling with server-side validation using RegEx
$errors = [];
$success = false;
$formData = [
    'name' => '',
    'email' => '',
    'phone' => '',
    'subject' => '',
    'message' => '',
];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Collect input
    $formData['name']    = trim($_POST['name']    ?? '');
    $formData['email']   = trim($_POST['email']   ?? '');
    $formData['phone']   = trim($_POST['phone']   ?? '');
    $formData['subject'] = trim($_POST['subject'] ?? '');
    $formData['message'] = trim($_POST['message'] ?? '');
    $agree               = isset($_POST['agree']);

    // REGEX VALIDATION (server-side)
    if (!validateName($formData['name'])) {
        $errors['name'] = 'Name must be 2-50 characters and contain only letters, spaces, hyphens, or apostrophes.';
    }
    if (!validateEmail($formData['email'])) {
        $errors['email'] = 'Please enter a valid email address (e.g. name@example.com).';
    }
    // Phone is optional, but if provided must be valid
    if ($formData['phone'] !== '' && !validatePhone($formData['phone'])) {
        $errors['phone'] = 'Phone must be 8-15 digits (optional + prefix).';
    }
    if ($formData['subject'] === '') {
        $errors['subject'] = 'Please select a subject.';
    }
    if (strlen($formData['message']) < 10) {
        $errors['message'] = 'Message must be at least 10 characters long.';
    }
    if (!$agree) {
        $errors['agree'] = 'You must agree to the Terms of Service.';
    }

    // Success — in Phase 2 this will save to DB and send email
    if (empty($errors)) {
        $success = true;
        // Reset form data after successful submission
        $formData = ['name' => '', 'email' => '', 'phone' => '', 'subject' => '', 'message' => ''];
    }
}
?>

<section class="page-header">
    <div class="wrapper">
        <span class="tag">Get in Touch</span>
        <h1>Contact <span class="blue">Us</span></h1>
        <p>Have questions? We are here to help you succeed</p>
    </div>
</section>

<section class="page-content">
    <div class="wrapper">
        <div class="contact-layout">
            <div class="contact-left">
                <h2>Reach Out <span class="blue">Anytime</span></h2>
                <p>Our support team is available to assist you with any questions about challenges, trading rules, or payouts.</p>

                <div class="methods">
                    <div class="method">
                        <div class="method-icon"><i class="fas fa-envelope"></i></div>
                        <div class="method-text">
                            <h3>Email Us</h3>
                            <p><?php echo e($GLOBALS['CONTACT_EMAIL']); ?></p>
                            <span class="green-text">Usually responds within 24 hours</span>
                        </div>
                    </div>
                    <div class="method">
                        <div class="method-icon"><i class="fas fa-comments"></i></div>
                        <div class="method-text">
                            <h3>Live Chat</h3>
                            <p>Available on our dashboard</p>
                            <span class="green-text">Average response time: 5 minutes</span>
                        </div>
                    </div>
                    <div class="method">
                        <div class="method-icon"><i class="fas fa-clock"></i></div>
                        <div class="method-text">
                            <h3>Support Hours</h3>
                            <p>Monday - Friday</p>
                            <span>9:00 AM - 6:00 PM (EST)</span>
                        </div>
                    </div>
                </div>

                <div class="social-area">
                    <h3>Follow Us</h3>
                    <div class="social-buttons">
                        <a href="#" class="social-btn"><i class="fab fa-discord"></i></a>
                        <a href="#" class="social-btn"><i class="fab fa-telegram"></i></a>
                        <a href="#" class="social-btn"><i class="fab fa-twitter"></i></a>
                        <a href="#" class="social-btn"><i class="fab fa-instagram"></i></a>
                    </div>
                </div>
            </div>

            <div class="form-box">
                <h3>Send us a Message</h3>

                <?php if ($success): ?>
                    <div class="alert success">
                        <i class="fas fa-check-circle"></i>
                        Thank you! Your message has been received. We will reply within 24 hours.
                    </div>
                <?php endif; ?>

                <?php if (!empty($errors) && !$success): ?>
                    <div class="alert error">
                        <i class="fas fa-exclamation-circle"></i>
                        Please fix the errors below and try again.
                    </div>
                <?php endif; ?>

                <form method="POST" action="">
                    <div class="form-cols">
                        <div class="input-group">
                            <label for="name">Full Name</label>
                            <input type="text" id="name" name="name" placeholder="John Doe" value="<?php echo e($formData['name']); ?>" required>
                            <?php if (isset($errors['name'])): ?>
                                <span class="field-error"><?php echo e($errors['name']); ?></span>
                            <?php endif; ?>
                        </div>
                        <div class="input-group">
                            <label for="email">Email Address</label>
                            <input type="text" id="email" name="email" placeholder="john@example.com" value="<?php echo e($formData['email']); ?>" required>
                            <?php if (isset($errors['email'])): ?>
                                <span class="field-error"><?php echo e($errors['email']); ?></span>
                            <?php endif; ?>
                        </div>
                    </div>
                    <div class="input-group">
                        <label for="phone">Phone (optional)</label>
                        <input type="text" id="phone" name="phone" placeholder="+38344123456" value="<?php echo e($formData['phone']); ?>">
                        <?php if (isset($errors['phone'])): ?>
                            <span class="field-error"><?php echo e($errors['phone']); ?></span>
                        <?php endif; ?>
                    </div>
                    <div class="input-group">
                        <label for="subject">Subject</label>
                        <select id="subject" name="subject" required>
                            <option value="">Select a topic</option>
                            <option value="general"   <?php echo $formData['subject'] === 'general'   ? 'selected' : ''; ?>>General Question</option>
                            <option value="challenge" <?php echo $formData['subject'] === 'challenge' ? 'selected' : ''; ?>>Challenge Inquiry</option>
                            <option value="payout"    <?php echo $formData['subject'] === 'payout'    ? 'selected' : ''; ?>>Payout Support</option>
                            <option value="technical" <?php echo $formData['subject'] === 'technical' ? 'selected' : ''; ?>>Technical Issue</option>
                            <option value="other"     <?php echo $formData['subject'] === 'other'     ? 'selected' : ''; ?>>Other</option>
                        </select>
                        <?php if (isset($errors['subject'])): ?>
                            <span class="field-error"><?php echo e($errors['subject']); ?></span>
                        <?php endif; ?>
                    </div>
                    <div class="input-group">
                        <label for="message">Message</label>
                        <textarea id="message" name="message" rows="5" placeholder="How can we help you?" required><?php echo e($formData['message']); ?></textarea>
                        <?php if (isset($errors['message'])): ?>
                            <span class="field-error"><?php echo e($errors['message']); ?></span>
                        <?php endif; ?>
                    </div>
                    <div class="checkbox">
                        <input type="checkbox" id="agree" name="agree" required>
                        <label for="agree">I agree to the Terms of Service and Privacy Policy</label>
                        <?php if (isset($errors['agree'])): ?>
                            <span class="field-error"><?php echo e($errors['agree']); ?></span>
                        <?php endif; ?>
                    </div>
                    <button type="submit" class="button blue-btn wide-btn">Send Message</button>
                </form>
                <p class="form-info"><i class="fas fa-lock"></i> Your information is secure and will never be shared</p>
            </div>
        </div>
    </div>
</section>

<section class="topics">
    <div class="wrapper">
        <div class="title-area">
            <span class="tag">Quick Help</span>
            <h2>Popular <span class="blue">Topics</span></h2>
        </div>
        <div class="topics-list">
            <a href="<?php echo url('faq.php'); ?>" class="topic-box">
                <div class="topic-icon"><i class="fas fa-rocket"></i></div>
                <h3>Getting Started</h3>
                <p>Learn how to begin your trading journey with us</p>
                <span class="topic-link">Learn more <i class="fas fa-arrow-right"></i></span>
            </a>
            <a href="<?php echo url('trading-rules.php'); ?>" class="topic-box">
                <div class="topic-icon"><i class="fas fa-book"></i></div>
                <h3>Trading Rules</h3>
                <p>Understand all the rules and parameters</p>
                <span class="topic-link">View rules <i class="fas fa-arrow-right"></i></span>
            </a>
            <a href="<?php echo url('faq.php'); ?>?cat=payouts" class="topic-box">
                <div class="topic-icon"><i class="fas fa-wallet"></i></div>
                <h3>Payouts</h3>
                <p>Everything about withdrawals and profit splits</p>
                <span class="topic-link">Read more <i class="fas fa-arrow-right"></i></span>
            </a>
        </div>
    </div>
</section>

<?php require_once __DIR__ . '/includes/footer.php'; ?>

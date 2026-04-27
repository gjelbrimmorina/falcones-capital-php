<?php
$pageTitle = 'FAQ';
require_once __DIR__ . '/includes/header.php';
require_once __DIR__ . '/data/faqs.php';

// Get active category from URL (associative array key)
$activeCategory = $_GET['cat'] ?? 'general';
if (!isset($faqData[$activeCategory])) {
    $activeCategory = 'general';
}
?>

<section class="page-header">
    <div class="wrapper">
        <span class="tag">Got Questions?</span>
        <h1>Frequently Asked <span class="blue">Questions</span></h1>
        <p>Find answers to common questions about our challenges, rules, and payouts</p>
    </div>
</section>

<section class="faq-content">
    <div class="wrapper">
        <div class="faq-tabs">
            <?php
            $tabs = [
                'general' => ['icon' => 'fas fa-info-circle', 'label' => 'General'],
                'trading' => ['icon' => 'fas fa-chart-line',  'label' => 'Trading'],
                'payouts' => ['icon' => 'fas fa-wallet',      'label' => 'Payouts'],
                'account' => ['icon' => 'fas fa-user',        'label' => 'Account'],
            ];
            foreach ($tabs as $key => $tab):
                $isActive = $key === $activeCategory ? 'active' : '';
            ?>
                <a href="?cat=<?php echo urlencode($key); ?>" class="faq-tab <?php echo $isActive; ?>">
                    <i class="<?php echo e($tab['icon']); ?>"></i> <?php echo e($tab['label']); ?>
                </a>
            <?php endforeach; ?>
        </div>

        <div class="faq-list">
            <?php
            // Loop through FAQ objects for the active category
            $categoryFaqs = $faqData[$activeCategory];
            foreach ($categoryFaqs as $faq): ?>
                <div class="faq-card">
                    <button class="question">
                        <?php echo e($faq->getQuestion()); ?>
                        <i class="fas fa-chevron-down"></i>
                    </button>
                    <div class="answer">
                        <p><?php echo e($faq->getAnswer()); ?></p>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<section class="faq-bottom">
    <div class="wrapper">
        <div class="cta-inner">
            <h2>Still Have <span class="blue">Questions?</span></h2>
            <p>Our support team is ready to help you with any questions</p>
            <div class="faq-buttons">
                <a href="<?php echo url('contact.php'); ?>" class="button blue-btn big-btn">Contact Support</a>
                <a href="<?php echo url('challenges.php'); ?>" class="button border-btn big-btn">View Challenges</a>
            </div>
        </div>
    </div>
</section>

<?php require_once __DIR__ . '/includes/footer.php'; ?>

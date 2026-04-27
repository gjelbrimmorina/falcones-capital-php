 <?php
$pageTitle = 'About Us';
require_once __DIR__ . '/includes/header.php';
?>

<section class="page-header">
    <div class="wrapper">
        <span class="tag">Our Story</span>
        <h1>About <span class="blue">Falcones Capital</span></h1>
        <p>Building the future of proprietary trading, one trader at a time</p>
    </div>
</section>

<section class="story">
    <div class="wrapper">
        <div class="story-layout">
            <div class="story-text">
                <h2>Our <span class="blue">Mission</span></h2>
                <p>Falcones Capital was founded with a simple belief: talented traders should not be held back by lack of capital. We provide the funding, you bring the skills.</p>
                <p>Our mission is to identify and empower skilled traders worldwide, giving them access to significant trading capital without risking their own money. We believe in fair rules, transparent processes, and genuine partnerships with our traders.</p>
                <p>Whether you are a seasoned professional or an emerging talent, we provide the platform and capital you need to succeed in the financial markets.</p>
            </div>
            <div class="story-img">
                <div class="img-placeholder">
                    <img src="<?php echo asset('images/logo.png'); ?>" alt="Falcones Capital" class="about-logo">
                    <span>Trading Excellence</span>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="about-stats">
    <div class="wrapper">
        <div class="stats-grid">
            <?php
            // Associative multidimensional array
            $stats = [
                ['num' => '$180M+',  'desc' => 'Total Payouts to Traders'],
                ['num' => '50,000+', 'desc' => 'Active Traders Worldwide'],
                ['num' => '195+',    'desc' => 'Countries Represented'],
                ['num' => (string) $GLOBALS['FOUNDED_YEAR'], 'desc' => 'Year Founded'],
            ];
            foreach ($stats as $s): ?>
                <div class="stat-box">
                    <div class="stat-num"><?php echo e($s['num']); ?></div>
                    <p><?php echo e($s['desc']); ?></p>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<section class="values">
    <div class="wrapper">
        <div class="title-area">
            <span class="tag">What We Stand For</span>
            <h2>Our <span class="blue">Values</span></h2>
        </div>
        <div class="values-list">
            <?php
            $values = [
                ['icon' => 'fas fa-handshake',   'title' => 'Transparency', 'desc' => 'Clear rules, no hidden fees, and honest communication. What you see is what you get.'],
                ['icon' => 'fas fa-users',       'title' => 'Trader First', 'desc' => 'Every decision we make considers the impact on our trading community first.'],
                ['icon' => 'fas fa-lightbulb',   'title' => 'Innovation',   'desc' => 'Constantly improving our platform, tools, and offerings based on trader feedback.'],
                ['icon' => 'fas fa-balance-scale','title' => 'Fairness',    'desc' => 'Rules designed to give you the best chance of success, not to trip you up.'],
            ];
            foreach ($values as $v): ?>
                <div class="value-box">
                    <div class="value-icon"><i class="<?php echo e($v['icon']); ?>"></i></div>
                    <h3><?php echo e($v['title']); ?></h3>
                    <p><?php echo e($v['desc']); ?></p>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<section class="timeline-section">
    <div class="wrapper">
        <div class="title-area">
            <span class="tag">Our Journey</span>
            <h2>Company <span class="blue">Timeline</span></h2>
        </div>
        <div class="timeline">
            <?php
            $timeline = [
                ['year' => '2021', 'title' => 'The Beginning',    'desc' => 'Falcones Capital was founded with a mission to democratize access to trading capital for talented traders worldwide.'],
                ['year' => '2022', 'title' => 'Rapid Growth',     'desc' => 'Reached 10,000 traders and $10M in payouts. Launched new account sizes and improved our evaluation process.'],
                ['year' => '2023', 'title' => 'Global Expansion', 'desc' => 'Expanded to 150+ countries, launched mobile app, and introduced the scaling program with up to 100% profit splits.'],
                ['year' => '2024', 'title' => 'Industry Leader',  'desc' => 'Surpassed $180M in payouts, serving 50,000+ traders across 195 countries. Continuing to innovate and grow.'],
            ];
            foreach ($timeline as $t): ?>
                <div class="timeline-entry">
                    <div class="marker"></div>
                    <div class="timeline-box">
                        <span class="date-tag"><?php echo e($t['year']); ?></span>
                        <h3><?php echo e($t['title']); ?></h3>
                        <p><?php echo e($t['desc']); ?></p>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<section class="cta">
    <div class="wrapper">
        <div class="cta-inner">
            <h2>Join the <span class="blue">Falcones Family</span></h2>
            <p>Become part of a global community of successful traders</p>
            <div class="cta-buttons">
                <a href="<?php echo url('challenges.php'); ?>" class="button blue-btn big-btn">Get Started Today</a>
                <a href="<?php echo url('contact.php'); ?>" class="button border-btn big-btn">Contact Us</a>
            </div>
        </div>
    </div>
</section>

<?php require_once __DIR__ . '/includes/footer.php'; ?>

<?php
$pageTitle = 'Home';
require_once __DIR__ . '/includes/header.php';
require_once __DIR__ . '/data/challenges.php';
require_once __DIR__ . '/includes/functions.php';

// Get first 3 challenges for the homepage preview (after sorting by price)
$sortedChallenges = sortChallengesByPrice($allChallenges, true);
$featuredChallenges = [
    $allChallenges[0], // $5k Starter
    $allChallenges[3], // $50k Pro (popular)
    $allChallenges[4], // $100k Elite
];

// Use of a simple LOCAL variable
$heroTagline = 'Trusted Prop Trading Firm';
?>

<section class="banner">
    <div class="wrapper">
        <div class="banner-inner">
            <span class="banner-tag"><?php echo e($heroTagline); ?></span>
            <h1>Trade with Up to <span class="blue">$300,000</span> in Capital</h1>
            <p>Join thousands of funded traders worldwide. Pass our evaluation, get funded, and keep up to 100% of your profits.</p>
            <div class="stats-row">
                <div class="stat">
                    <span class="stat-num">$180M+</span>
                    <span class="stat-text">Paid to Traders</span>
                </div>
                <div class="stat">
                    <span class="stat-num">195+</span>
                    <span class="stat-text">Countries</span>
                </div>
                <div class="stat">
                    <span class="stat-num">50K+</span>
                    <span class="stat-text">Active Traders</span>
                </div>
            </div>
            <div class="banner-buttons">
                <a href="<?php echo url('challenges.php'); ?>" class="button blue-btn big-btn">Get Funded Now</a>
                <a href="<?php echo url('trading-rules.php'); ?>" class="button border-btn big-btn">View Rules</a>
            </div>
        </div>
    </div>
</section>

<section class="platforms">
    <div class="wrapper">
        <p class="platforms-heading">Trade on industry-leading platforms</p>
        <div class="platforms-list">
            <?php
            // Numeric array + foreach loop
            $platforms = [
                ['name' => 'MetaTrader 5',  'icon' => 'fas fa-desktop'],
                ['name' => 'cTrader',       'icon' => 'fas fa-chart-bar'],
                ['name' => 'Match-Trader',  'icon' => 'fas fa-exchange-alt'],
            ];
            foreach ($platforms as $p): ?>
                <div class="platform"><i class="<?php echo e($p['icon']); ?>"></i> <?php echo e($p['name']); ?></div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<section class="features" id="features">
    <div class="wrapper">
        <div class="title-area">
            <span class="tag">Why Choose Us</span>
            <h2>Built for <span class="blue">Serious Traders</span></h2>
            <p>Experience the difference with our trader-first approach</p>
        </div>
        <div class="features-list">
            <?php
            // Features as multidimensional array
            $features = [
                ['icon' => 'fas fa-bolt',        'title' => 'Instant Funding',       'desc' => 'Get your trading account credentials instantly after purchase. Start trading within minutes.'],
                ['icon' => 'fas fa-infinity',    'title' => 'No Time Limits',        'desc' => "Take your time to hit profit targets. We don't rush you with arbitrary deadlines."],
                ['icon' => 'fas fa-percent',     'title' => 'Up to 100% Profit Split','desc' => 'Start at 60% and scale up to keeping 100% of all your trading profits.'],
                ['icon' => 'fas fa-chart-line',  'title' => 'Scale to $300K',        'desc' => 'Grow your account through our scaling plan. Consistent traders get more capital.'],
                ['icon' => 'fas fa-newspaper',   'title' => 'News Trading Allowed',  'desc' => 'Trade during high-impact news events. No restrictions on your strategy.'],
                ['icon' => 'fas fa-robot',       'title' => 'EAs and Bots Welcome',  'desc' => 'Use Expert Advisors and automated strategies. We support algorithmic traders.'],
            ];
            foreach ($features as $f): ?>
                <div class="feature-box">
                    <div class="icon-box"><i class="<?php echo e($f['icon']); ?>"></i></div>
                    <h3><?php echo e($f['title']); ?></h3>
                    <p><?php echo e($f['desc']); ?></p>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<section class="steps">
    <div class="wrapper">
        <div class="title-area">
            <span class="tag">Simple Process</span>
            <h2>How It <span class="blue">Works</span></h2>
        </div>
        <div class="steps-list">
            <?php
            // for loop with numeric index to show step number
            $steps = [
                ['title' => 'Choose Your Challenge', 'desc' => 'Select an account size from $5K to $200K that matches your trading style and goals.'],
                ['title' => 'Pass the Evaluation',   'desc' => 'Hit the 8% profit target while respecting drawdown limits. No time pressure.'],
                ['title' => 'Get Funded and Paid',   'desc' => 'Receive your funded account and start earning. Request payouts bi-weekly.'],
            ];
            for ($i = 0; $i < count($steps); $i++): ?>
                <div class="step-box">
                    <div class="step-num"><?php echo ($i + 1); ?></div>
                    <h3><?php echo e($steps[$i]['title']); ?></h3>
                    <p><?php echo e($steps[$i]['desc']); ?></p>
                </div>
            <?php endfor; ?>
        </div>
    </div>
</section>

<section class="challenges" id="challenges">
    <div class="wrapper">
        <div class="title-area">
            <span class="tag">Choose Your Size</span>
            <h2>Trading <span class="blue">Challenges</span></h2>
            <p>One-step evaluation with transparent rules</p>
        </div>
        <div class="cards-grid">
            <?php foreach ($featuredChallenges as $ch): ?>
                <div class="card <?php echo $ch->isPopular() ? 'popular' : ''; ?>">
                    <?php if ($ch->isPopular()): ?>
                        <div class="popular-badge">Most Popular</div>
                    <?php endif; ?>
                    <div class="card-header">
                        <span class="amount"><?php echo e($ch->getSize()); ?></span>
                        <span class="label"><?php echo e($ch->getLabel()); ?></span>
                    </div>
                    <div class="price-area">
                        <span class="price"><?php echo e($ch->getPrice()); ?></span>
                    </div>
                    <ul class="check-list">
                        <li><i class="fas fa-check"></i> <?php echo e($ch->getProfitTarget()); ?> Profit Target</li>
                        <li><i class="fas fa-check"></i> <?php echo e($ch->getDailyDrawdown()); ?> Daily Drawdown</li>
                        <li><i class="fas fa-check"></i> <?php echo e($ch->getMaxDrawdown()); ?> Max Drawdown</li>
                        <li><i class="fas fa-check"></i> No Time Limit</li>
                        <li><i class="fas fa-check"></i> <?php echo e($ch->getProfitSplit()); ?> Profit Split</li>
                    </ul>
                    <a href="<?php echo url('challenges.php'); ?>" class="button <?php echo $ch->isPopular() ? 'blue-btn' : 'border-btn'; ?> wide-btn">Select Plan</a>
                </div>
            <?php endforeach; ?>
        </div>
        <div class="cards-bottom">
            <a href="<?php echo url('challenges.php'); ?>" class="button border-btn">View All Account Sizes</a>
        </div>
    </div>
</section>

<section class="payouts">
    <div class="wrapper">
        <div class="title-area">
            <span class="tag">Flexible Rewards</span>
            <h2>Profit <span class="blue">Sharing</span></h2>
        </div>
        <div class="payouts-list">
            <div class="payout-box">
                <div class="percent">60%</div>
                <h3>Starting Split</h3>
                <p>Begin your journey with a competitive 60% profit split from day one.</p>
            </div>
            <div class="payout-box">
                <div class="percent">80%</div>
                <h3>Scaling Split</h3>
                <p>Increase to 80% as you prove consistent profitability.</p>
            </div>
            <div class="payout-box popular">
                <div class="percent">100%</div>
                <h3>Maximum Split</h3>
                <p>Top performers keep 100% of their profits. You earned it!</p>
            </div>
        </div>
    </div>
</section>

<section class="reviews">
    <div class="wrapper">
        <div class="title-area">
            <span class="tag">Trader Stories</span>
            <h2>What Our <span class="blue">Traders Say</span></h2>
        </div>
        <div class="reviews-list">
            <?php
            $reviews = [
                ['initials' => 'JD', 'name' => 'James D.',   'acc' => '$50K Funded Trader',  'text' => 'Best prop firm I have worked with. The rules are fair, payouts are fast, and the support team actually helps. Got my first $5K payout within 3 weeks!'],
                ['initials' => 'SM', 'name' => 'Sarah M.',   'acc' => '$100K Funded Trader', 'text' => 'No time limits is a game changer. I can trade my strategy without pressure. Already scaled to $100K and the profit splits keep getting better.'],
                ['initials' => 'MK', 'name' => 'Michael K.', 'acc' => '$200K Funded Trader', 'text' => 'Coming from another prop firm, Falcones is leagues ahead. The dashboard is clean, spreads are tight, and I have received $25K in payouts so far.'],
            ];
            foreach ($reviews as $r): ?>
                <div class="review-box">
                    <div class="stars">
                        <?php for ($i = 0; $i < 5; $i++): ?><i class="fas fa-star"></i><?php endfor; ?>
                    </div>
                    <p>"<?php echo e($r['text']); ?>"</p>
                    <div class="reviewer">
                        <div class="avatar"><?php echo e($r['initials']); ?></div>
                        <div class="reviewer-info">
                            <strong><?php echo e($r['name']); ?></strong>
                            <span><?php echo e($r['acc']); ?></span>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<section class="cta">
    <div class="wrapper">
        <div class="cta-inner">
            <h2>Ready to Start Your <span class="blue">Trading Journey?</span></h2>
            <p>Join over 50,000 traders who trust Falcones Capital</p>
            <div class="cta-buttons">
                <a href="<?php echo url('challenges.php'); ?>" class="button blue-btn big-btn">Get Funded Today</a>
                <a href="<?php echo url('faq.php'); ?>" class="button border-btn big-btn">Learn More</a>
            </div>
        </div>
    </div>
</section>

<?php require_once __DIR__ . '/includes/footer.php'; ?>

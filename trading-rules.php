<?php
$pageTitle = 'Trading Rules';
require_once __DIR__ . '/includes/header.php';
?>

<section class="page-header">
    <div class="wrapper">
        <span class="tag">Know the Rules</span>
        <h1>Trading <span class="blue">Rules</span></h1>
        <p>Clear and fair rules designed to help you succeed as a funded trader</p>
    </div>
</section>

<section class="page-content">
    <div class="wrapper">
        <div class="rules-cards">
            <div class="rule-card">
                <div class="rule-icon allowed"><i class="fas fa-check-circle"></i></div>
                <h3>Allowed</h3>
                <ul class="rule-list allowed">
                    <?php
                    $allowed = [
                        'All trading strategies',
                        'News trading',
                        'Weekend and overnight holding',
                        'Expert Advisors (EAs)',
                        'Scalping and day trading',
                        'Swing trading',
                    ];
                    foreach ($allowed as $rule): ?>
                        <li><i class="fas fa-check"></i> <?php echo e($rule); ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
            <div class="rule-card">
                <div class="rule-icon not-allowed"><i class="fas fa-times-circle"></i></div>
                <h3>Not Allowed</h3>
                <ul class="rule-list not-allowed">
                    <?php
                    $notAllowed = [
                        'Martingale or grid without stop loss',
                        'Arbitrage or latency exploitation',
                        'Account management services',
                        'Copy trading between accounts',
                        'High-frequency tick scalping',
                        'Exploiting platform errors',
                    ];
                    foreach ($notAllowed as $rule): ?>
                        <li><i class="fas fa-times"></i> <?php echo e($rule); ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        </div>
    </div>
</section>

<section class="table-section">
    <div class="wrapper">
        <h2>Challenge <span class="blue">Parameters</span></h2>
        <div class="table-container">
            <table class="params-table">
                <thead>
                    <tr>
                        <th>Parameter</th>
                        <th>Evaluation Phase</th>
                        <th>Funded Account</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    // Multidimensional array for table rows
                    $params = [
                        ['Profit Target',         '8%',        'No target'],
                        ['Daily Drawdown',        '5%',        '5%'],
                        ['Maximum Drawdown',      '10%',       '10%'],
                        ['Minimum Trading Days',  '1 day',     'No minimum'],
                        ['Maximum Trading Period','Unlimited', 'Unlimited'],
                        ['Profit Split',          'N/A',       '60% - 100%'],
                    ];
                    foreach ($params as $row): ?>
                        <tr>
                            <?php foreach ($row as $cell): ?>
                                <td><?php echo e($cell); ?></td>
                            <?php endforeach; ?>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</section>

<section class="page-content">
    <div class="wrapper">
        <h2>Rule <span class="blue">Details</span></h2>
        <div class="detail-cards">
            <div class="detail-card">
                <div class="detail-top">
                    <div class="detail-icon"><i class="fas fa-chart-pie"></i></div>
                    <h3>Daily Drawdown (5%)</h3>
                </div>
                <div class="detail-text">
                    <p>Your daily loss cannot exceed 5% of your starting balance for that day. This is calculated at the end of each trading day.</p>
                    <div class="example">
                        <strong>Example:</strong> With a $50,000 account, your maximum daily loss is $2,500. If your account starts the day at $52,000, your max loss for that day is $2,600 (5% of $52,000).
                    </div>
                </div>
            </div>
            <div class="detail-card">
                <div class="detail-top">
                    <div class="detail-icon"><i class="fas fa-shield-alt"></i></div>
                    <h3>Maximum Drawdown (10%)</h3>
                </div>
                <div class="detail-text">
                    <p>Your account balance cannot fall below 90% of your initial starting balance at any time during the challenge.</p>
                    <div class="example">
                        <strong>Example:</strong> With a $50,000 account, your account must never drop below $45,000. This is a static level based on your initial balance.
                    </div>
                </div>
            </div>
            <div class="detail-card">
                <div class="detail-top">
                    <div class="detail-icon"><i class="fas fa-bullseye"></i></div>
                    <h3>Profit Target (8%)</h3>
                </div>
                <div class="detail-text">
                    <p>To pass the evaluation, you need to achieve an 8% profit on your initial account balance. There is no time limit to achieve this.</p>
                    <div class="note">
                        <i class="fas fa-info-circle"></i> Once funded, there is no profit target. Trade at your own pace and withdraw profits whenever you want.
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="payouts">
    <div class="wrapper">
        <div class="title-area">
            <span class="tag">Get Paid</span>
            <h2>Payout <span class="blue">Rules</span></h2>
        </div>
        <div class="payouts-list">
            <div class="payout-box">
                <div class="percent"><i class="fas fa-calendar-alt"></i></div>
                <h3>Bi-Weekly Payouts</h3>
                <p>Request your profits every 14 days. Consistent payouts you can rely on.</p>
            </div>
            <div class="payout-box">
                <div class="percent"><i class="fas fa-bolt"></i></div>
                <h3>Fast Processing</h3>
                <p>Payouts processed within 24-48 hours via your preferred method.</p>
            </div>
            <div class="payout-box">
                <div class="percent"><i class="fas fa-wallet"></i></div>
                <h3>Multiple Methods</h3>
                <p>Bank transfer, crypto, and other payment options available.</p>
            </div>
        </div>
    </div>
</section>

<section class="cta">
    <div class="wrapper">
        <div class="cta-inner">
            <h2>Ready to Start <span class="blue">Trading?</span></h2>
            <p>Choose your challenge and prove your skills</p>
            <div class="cta-buttons">
                <a href="<?php echo url('challenges.php'); ?>" class="button blue-btn big-btn">View Challenges</a>
                <a href="<?php echo url('faq.php'); ?>" class="button border-btn big-btn">More Questions?</a>
            </div>
        </div>
    </div>
</section>

<?php require_once __DIR__ . '/includes/footer.php'; ?>

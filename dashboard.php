<?php
$pageTitle = 'Dashboard';
require_once __DIR__ . '/includes/header.php';
require_once __DIR__ . '/data/traders.php';
require_once __DIR__ . '/data/challenges.php';

// This page requires login
requireLogin();

$user = getCurrentUser();
$role = $user->getRole();
?>

<section class="dashboard">
    <div class="wrapper">

        <!-- Welcome card (shown to both roles) -->
        <div class="dash-welcome">
            <div class="dash-welcome-left">
                <div class="dash-avatar"><?php echo e($user->getInitials()); ?></div>
                <div>
                    <h1>Welcome back, <span class="blue"><?php echo e($user->getName()); ?></span></h1>
                    <p><?php echo $user->getRoleBadge(); ?> &nbsp; <?php echo e($user->getEmail()); ?></p>
                </div>
            </div>
            <div class="dash-welcome-right">
                <span class="login-time">
                    <i class="fas fa-clock"></i> Session started: <?php echo e($_SESSION['login_time'] ?? ''); ?>
                </span>
            </div>
        </div>

        <!-- ==============================
             ADMIN VIEW (Role: admin)
             ============================== -->
        <?php if ($role === 'admin'): ?>

            <h2 class="dash-title"><?php echo e($user->getDashboardTitle()); ?></h2>

            <!-- Stats cards -->
            <div class="dash-stats">
                <?php
                // Calculate stats from dummy data (demonstrates array operations)
                $totalTraders   = count($dummyTraders);
                $fundedCount    = 0;
                $evalCount      = 0;
                $totalPayouts   = 0;
                foreach ($dummyTraders as $t) {
                    if ($t['status'] === 'funded') $fundedCount++;
                    else $evalCount++;
                    $totalPayouts += $t['payout'];
                }
                $pendingMessages = count($dummyMessages);
                ?>
                <div class="dash-stat-card">
                    <div class="dash-stat-icon blue-bg"><i class="fas fa-users"></i></div>
                    <div class="dash-stat-text">
                        <span class="dash-stat-num"><?php echo $totalTraders; ?></span>
                        <span class="dash-stat-label">Total Traders</span>
                    </div>
                </div>
                <div class="dash-stat-card">
                    <div class="dash-stat-icon green-bg"><i class="fas fa-check"></i></div>
                    <div class="dash-stat-text">
                        <span class="dash-stat-num"><?php echo $fundedCount; ?></span>
                        <span class="dash-stat-label">Funded</span>
                    </div>
                </div>
                <div class="dash-stat-card">
                    <div class="dash-stat-icon orange-bg"><i class="fas fa-hourglass-half"></i></div>
                    <div class="dash-stat-text">
                        <span class="dash-stat-num"><?php echo $evalCount; ?></span>
                        <span class="dash-stat-label">In Evaluation</span>
                    </div>
                </div>
                <div class="dash-stat-card">
                    <div class="dash-stat-icon blue-bg"><i class="fas fa-dollar-sign"></i></div>
                    <div class="dash-stat-text">
                        <span class="dash-stat-num">$<?php echo number_format($totalPayouts); ?></span>
                        <span class="dash-stat-label">Total Payouts</span>
                    </div>
                </div>
                <div class="dash-stat-card">
                    <div class="dash-stat-icon orange-bg"><i class="fas fa-envelope"></i></div>
                    <div class="dash-stat-text">
                        <span class="dash-stat-num"><?php echo $pendingMessages; ?></span>
                        <span class="dash-stat-label">New Messages</span>
                    </div>
                </div>
            </div>

            <!-- Traders table -->
            <div class="dash-panel">
                <div class="dash-panel-head">
                    <h3><i class="fas fa-users"></i> All Traders</h3>
                    <span class="count-badge"><?php echo $totalTraders; ?> total</span>
                </div>
                <div class="table-container">
                    <table class="params-table dash-table">
                        <thead>
                            <tr>
                                <th>Trader</th>
                                <th>Email</th>
                                <th>Account</th>
                                <th>Country</th>
                                <th>Status</th>
                                <th>Payout</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($dummyTraders as $t): ?>
                                <tr>
                                    <td><strong><?php echo e($t['name']); ?></strong></td>
                                    <td><?php echo e($t['email']); ?></td>
                                    <td><?php echo e($t['account']); ?></td>
                                    <td><?php echo e($t['country']); ?></td>
                                    <td>
                                        <span class="role-badge <?php echo $t['status'] === 'funded' ? 'funded' : 'evaluation'; ?>">
                                            <?php echo $t['status'] === 'funded' ? 'Funded' : 'Evaluation'; ?>
                                        </span>
                                    </td>
                                    <td class="green-text"><strong>$<?php echo number_format($t['payout']); ?></strong></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Messages panel -->
            <div class="dash-panel">
                <div class="dash-panel-head">
                    <h3><i class="fas fa-envelope"></i> Recent Contact Messages</h3>
                    <span class="count-badge"><?php echo $pendingMessages; ?> new</span>
                </div>
                <div class="messages-list">
                    <?php foreach ($dummyMessages as $msg): ?>
                        <div class="message-card">
                            <div class="message-head">
                                <strong><?php echo e($msg['name']); ?></strong>
                                <span class="subj-badge"><?php echo e($msg['subject']); ?></span>
                                <span class="message-date"><?php echo e($msg['date']); ?></span>
                            </div>
                            <div class="message-email"><?php echo e($msg['email']); ?></div>
                            <div class="message-body"><?php echo e($msg['message']); ?></div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>

        <!-- ==============================
             TRADER VIEW (Role: trader)
             ============================== -->
        <?php else: ?>

            <h2 class="dash-title"><?php echo e($user->getDashboardTitle()); ?></h2>

            <!-- Trader stats -->
            <div class="dash-stats">
                <div class="dash-stat-card">
                    <div class="dash-stat-icon blue-bg"><i class="fas fa-wallet"></i></div>
                    <div class="dash-stat-text">
                        <span class="dash-stat-num"><?php echo e($user->getFormattedAccountSize()); ?></span>
                        <span class="dash-stat-label">Account Size</span>
                    </div>
                </div>
                <div class="dash-stat-card">
                    <div class="dash-stat-icon green-bg"><i class="fas fa-percent"></i></div>
                    <div class="dash-stat-text">
                        <span class="dash-stat-num"><?php echo e($user->getProfitSplit()); ?>%</span>
                        <span class="dash-stat-label">Profit Split</span>
                    </div>
                </div>
                <div class="dash-stat-card">
                    <div class="dash-stat-icon blue-bg"><i class="fas fa-dollar-sign"></i></div>
                    <div class="dash-stat-text">
                        <span class="dash-stat-num"><?php echo e($user->getFormattedPayout()); ?></span>
                        <span class="dash-stat-label">Total Earned</span>
                    </div>
                </div>
                <div class="dash-stat-card">
                    <div class="dash-stat-icon orange-bg"><i class="fas fa-bullseye"></i></div>
                    <div class="dash-stat-text">
                        <span class="dash-stat-num">$<?php echo number_format($user->getProfitTarget()); ?></span>
                        <span class="dash-stat-label">Profit Target (8%)</span>
                    </div>
                </div>
            </div>

            <!-- Dummy payout history -->
            <div class="dash-panel">
                <div class="dash-panel-head">
                    <h3><i class="fas fa-history"></i> Recent Payout History</h3>
                </div>
                <div class="table-container">
                    <table class="params-table dash-table">
                        <thead>
                            <tr>
                                <th>Date</th>
                                <th>Amount</th>
                                <th>Method</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            // Dummy payout history — sorted by date (newest first)
                            $payouts = [
                                ['date' => '2026-04-15', 'amount' => 3200, 'method' => 'Bank Transfer',  'status' => 'Completed'],
                                ['date' => '2026-04-01', 'amount' => 2800, 'method' => 'USDT',           'status' => 'Completed'],
                                ['date' => '2026-03-17', 'amount' => 4100, 'method' => 'Bank Transfer',  'status' => 'Completed'],
                                ['date' => '2026-03-03', 'amount' => 2400, 'method' => 'USDT',           'status' => 'Completed'],
                            ];
                            // Sort by date descending
                            usort($payouts, fn($a, $b) => strcmp($b['date'], $a['date']));
                            foreach ($payouts as $p): ?>
                                <tr>
                                    <td><?php echo e($p['date']); ?></td>
                                    <td class="green-text"><strong>$<?php echo number_format($p['amount']); ?></strong></td>
                                    <td><?php echo e($p['method']); ?></td>
                                    <td><span class="role-badge funded"><?php echo e($p['status']); ?></span></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Available challenges (call to action) -->
            <div class="dash-panel">
                <div class="dash-panel-head">
                    <h3><i class="fas fa-plus-circle"></i> Purchase a New Challenge</h3>
                </div>
                <div class="cards-grid">
                    <?php
                    // Show only 3 popular challenges
                    $featured = [$allChallenges[0], $allChallenges[3], $allChallenges[4]];
                    foreach ($featured as $ch): ?>
                        <div class="card <?php echo $ch->isPopular() ? 'popular' : ''; ?>">
                            <div class="card-header">
                                <span class="amount"><?php echo e($ch->getSize()); ?></span>
                                <span class="label"><?php echo e($ch->getLabel()); ?></span>
                            </div>
                            <div class="price-area">
                                <span class="price"><?php echo e($ch->getPrice()); ?></span>
                            </div>
                            <ul class="check-list">
                                <li><i class="fas fa-check"></i> <?php echo e($ch->getProfitTarget()); ?> Profit Target</li>
                                <li><i class="fas fa-check"></i> <?php echo e($ch->getProfitSplit()); ?> Split</li>
                            </ul>
                            <a href="<?php echo url('challenges.php'); ?>" class="button <?php echo $ch->isPopular() ? 'blue-btn' : 'border-btn'; ?> wide-btn">Buy Now</a>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>

        <?php endif; ?>

    </div>
</section>

<?php require_once __DIR__ . '/includes/footer.php'; ?>

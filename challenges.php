<?php
$pageTitle = 'Challenges';
require_once __DIR__ . '/includes/header.php';
require_once __DIR__ . '/data/challenges.php';

// Demonstration of sorting (server-side)
// Default: sort by size ascending
$sortBy = $_GET['sort'] ?? 'size_asc';

switch ($sortBy) {
    case 'size_desc':
        $displayChallenges = sortChallengesBySize($allChallenges, false);
        break;
    case 'price_asc':
        $displayChallenges = sortChallengesByPrice($allChallenges, true);
        break;
    case 'price_desc':
        $displayChallenges = sortChallengesByPrice($allChallenges, false);
        break;
    case 'size_asc':
    default:
        $displayChallenges = sortChallengesBySize($allChallenges, true);
}
?>

<section class="page-header">
    <div class="wrapper">
        <span class="tag">Start Trading</span>
        <h1>Choose Your <span class="blue">Challenge</span></h1>
        <p>Select your preferred account size and begin your journey to becoming a funded trader</p>
    </div>
</section>

<section class="page-content">
    <div class="wrapper">
        <div class="type-picker">
            <div class="type-options">
                <button class="type-option active" data-type="all">All Accounts</button>
                <button class="type-option" data-type="starter">Starter ($5K-$25K)</button>
                <button class="type-option" data-type="pro">Pro ($50K-$200K)</button>
            </div>

            <form method="GET" action="" class="sort-form">
                <label for="sort">Sort by:</label>
                <select name="sort" id="sort" onchange="this.form.submit()">
                    <option value="size_asc"   <?php echo $sortBy === 'size_asc'   ? 'selected' : ''; ?>>Size (Low → High)</option>
                    <option value="size_desc"  <?php echo $sortBy === 'size_desc'  ? 'selected' : ''; ?>>Size (High → Low)</option>
                    <option value="price_asc"  <?php echo $sortBy === 'price_asc'  ? 'selected' : ''; ?>>Price (Low → High)</option>
                    <option value="price_desc" <?php echo $sortBy === 'price_desc' ? 'selected' : ''; ?>>Price (High → Low)</option>
                </select>
            </form>
        </div>

        <div class="all-cards">
            <?php foreach ($displayChallenges as $ch): ?>
                <div class="full-card <?php echo $ch->isPopular() ? 'popular' : ''; ?>" data-category="<?php echo e($ch->getCategory()); ?>">
                    <?php if ($ch->isPopular()): ?>
                        <div class="popular-badge">Most Popular</div>
                    <?php endif; ?>
                    <div class="card-top">
                        <span class="label"><?php echo e($ch->getLabel()); ?></span>
                        <span class="account-amount"><?php echo e($ch->getSize()); ?></span>
                    </div>
                    <div class="card-price">
                        <span class="price"><?php echo e($ch->getPrice()); ?></span>
                        <span class="price-note">one-time fee</span>
                    </div>
                    <div class="details">
                        <div class="detail"><span>Profit Target</span><strong><?php echo e($ch->getProfitTarget()); ?></strong></div>
                        <div class="detail"><span>Daily Drawdown</span><strong><?php echo e($ch->getDailyDrawdown()); ?></strong></div>
                        <div class="detail"><span>Max Drawdown</span><strong><?php echo e($ch->getMaxDrawdown()); ?></strong></div>
                        <div class="detail"><span>Profit Split</span><strong class="green-text"><?php echo e($ch->getProfitSplit()); ?></strong></div>
                    </div>
                    <div class="included-section">
                        <h4>What's Included:</h4>
                        <ul class="included-list">
                            <li class="included"><i class="fas fa-check"></i> No Time Limit</li>
                            <li class="included"><i class="fas fa-check"></i> Free Retries on Profit Split</li>
                            <li class="included"><i class="fas fa-check"></i> All Trading Styles Allowed</li>
                            <li class="included"><i class="fas fa-check"></i> News Trading Permitted</li>
                            <li class="included"><i class="fas fa-check"></i> Weekend Holding Allowed</li>
                            <li class="included"><i class="fas fa-check"></i> EA/Bots Welcome</li>
                        </ul>
                    </div>
                    <?php if (isLoggedIn()): ?>
                        <a href="<?php echo url('dashboard.php'); ?>" class="button <?php echo $ch->isPopular() ? 'blue-btn' : 'border-btn'; ?> wide-btn">Get Started</a>
                    <?php else: ?>
                        <a href="<?php echo url('login.php'); ?>" class="button <?php echo $ch->isPopular() ? 'blue-btn' : 'border-btn'; ?> wide-btn">Sign In to Buy</a>
                    <?php endif; ?>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<section class="scaling">
    <div class="wrapper">
        <div class="title-area">
            <span class="tag">Grow With Us</span>
            <h2>Scaling <span class="blue">Plan</span></h2>
            <p>Consistent traders unlock higher capital and better profit splits</p>
        </div>
        <div class="scale-list">
            <div class="scale-box">
                <div class="scale-icon"><i class="fas fa-seedling"></i></div>
                <h3>Phase 1</h3>
                <p>Starting capital with 60% profit split</p>
                <div class="requirement">Complete 3 profitable months</div>
            </div>
            <div class="arrow"><i class="fas fa-chevron-right"></i></div>
            <div class="scale-box">
                <div class="scale-icon"><i class="fas fa-chart-line"></i></div>
                <h3>Phase 2</h3>
                <p>1.5x capital with 70% profit split</p>
                <div class="requirement">Maintain consistency for 3 months</div>
            </div>
            <div class="arrow"><i class="fas fa-chevron-right"></i></div>
            <div class="scale-box">
                <div class="scale-icon"><i class="fas fa-rocket"></i></div>
                <h3>Phase 3</h3>
                <p>2x capital with 80-100% profit split</p>
                <div class="requirement">Continue growing with us</div>
            </div>
        </div>
    </div>
</section>

<?php require_once __DIR__ . '/includes/footer.php'; ?>

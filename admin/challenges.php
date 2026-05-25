<?php
$pageTitle = 'Manage Challenges';
require_once __DIR__ . '/../includes/header.php';
require_once __DIR__ . '/../includes/repositories.php';
requireRole('admin');

if (!dbAvailable()) {
    $dbWarning = 'MySQL is not connected. Import sql/falcones_capital.sql first.';
}

$editId = isset($_GET['edit']) ? (int)$_GET['edit'] : 0;
$editing = $editId ? getChallengeById($editId) : null;
$errors = [];

$form = [
    'label' => $editing['label'] ?? '',
    'account_size' => $editing['account_size'] ?? '',
    'price' => $editing['price'] ?? '',
    'profit_target' => $editing['profit_target'] ?? '8',
    'daily_drawdown' => $editing['daily_drawdown'] ?? '5',
    'max_drawdown' => $editing['max_drawdown'] ?? '10',
    'profit_split' => $editing['profit_split'] ?? '80',
    'category' => $editing['category'] ?? 'starter',
    'is_popular' => $editing['is_popular'] ?? 0,
];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!verifyCsrfToken($_POST['csrf_token'] ?? '')) $errors[] = 'Invalid CSRF token.';
    foreach ($form as $key => $value) $form[$key] = trim($_POST[$key] ?? '');
    $form['is_popular'] = isset($_POST['is_popular']) ? 1 : 0;

    if ($form['label'] === '') $errors[] = 'Label is required.';
    if (!validateMoney($form['account_size'])) $errors[] = 'Account size must be a positive number.';
    if (!validateMoney($form['price'])) $errors[] = 'Price must be a positive number.';
    foreach (['profit_target','daily_drawdown','max_drawdown','profit_split'] as $percentField) {
        if (!validatePercent($form[$percentField])) $errors[] = $percentField . ' must be between 0 and 100.';
    }
    if (!validateStatus($form['category'], ['starter','pro'])) $errors[] = 'Invalid category.';

    if (empty($errors)) {
        try {
            if ($editId) {
                updateChallenge($editId, $form);
                redirectWith('admin/challenges.php', 'success', 'Challenge updated successfully.');
            } else {
                createChallenge($form);
                redirectWith('admin/challenges.php', 'success', 'Challenge created successfully.');
            }
        } catch (Throwable $e) {
            error_log($e->getMessage());
            $errors[] = 'Database error. Check if SQL dump is imported.';
        }
    }
}

$flash = getFlash();
$challenges = dbAvailable() ? getChallengesFromDb() : [];
?>
<section class="dashboard"><div class="wrapper">
    <div class="dash-panel-head page-actions">
        <h1><i class="fas fa-layer-group"></i> Manage Challenges</h1>
        <a class="button border-btn" href="<?php echo url('dashboard.php'); ?>">Back to Dashboard</a>
    </div>

    <?php if (!empty($dbWarning)): ?><div class="alert error"><?php echo e($dbWarning); ?></div><?php endif; ?>
    <?php if ($flash): ?><div class="alert <?php echo e($flash['type']); ?>"><?php echo e($flash['message']); ?></div><?php endif; ?>
    <?php if ($errors): ?><div class="alert error"><?php echo e(implode(' ', $errors)); ?></div><?php endif; ?>

    <div class="dash-panel form-panel">
        <h3><?php echo $editId ? 'Edit Challenge' : 'Create New Challenge'; ?></h3>
        <form method="POST" class="admin-form">
            <?php echo csrfInput(); ?>
            <div class="form-cols">
                <div class="input-group"><label>Label</label><input name="label" value="<?php echo e($form['label']); ?>" required></div>
                <div class="input-group"><label>Account Size</label><input type="number" step="0.01" name="account_size" value="<?php echo e($form['account_size']); ?>" required></div>
            </div>
            <div class="form-cols">
                <div class="input-group"><label>Price</label><input type="number" step="0.01" name="price" value="<?php echo e($form['price']); ?>" required></div>
                <div class="input-group"><label>Category</label><select name="category"><option value="starter" <?php echo $form['category']==='starter'?'selected':''; ?>>Starter</option><option value="pro" <?php echo $form['category']==='pro'?'selected':''; ?>>Pro</option></select></div>
            </div>
            <div class="form-cols four-cols">
                <div class="input-group"><label>Profit Target %</label><input type="number" step="0.01" name="profit_target" value="<?php echo e($form['profit_target']); ?>"></div>
                <div class="input-group"><label>Daily DD %</label><input type="number" step="0.01" name="daily_drawdown" value="<?php echo e($form['daily_drawdown']); ?>"></div>
                <div class="input-group"><label>Max DD %</label><input type="number" step="0.01" name="max_drawdown" value="<?php echo e($form['max_drawdown']); ?>"></div>
                <div class="input-group"><label>Profit Split %</label><input type="number" step="0.01" name="profit_split" value="<?php echo e($form['profit_split']); ?>"></div>
            </div>
            <div class="checkbox"><input type="checkbox" id="popular" name="is_popular" <?php echo $form['is_popular'] ? 'checked' : ''; ?>><label for="popular">Mark as popular</label></div>
            <button class="button blue-btn" type="submit"><?php echo $editId ? 'Update Challenge' : 'Create Challenge'; ?></button>
            <?php if ($editId): ?><a class="button border-btn" href="<?php echo url('admin/challenges.php'); ?>">Cancel</a><?php endif; ?>
        </form>
    </div>

    <div class="dash-panel">
        <div class="dash-panel-head"><h3>Challenges from MySQL</h3><span class="count-badge"><?php echo count($challenges); ?> total</span></div>
        <div class="table-container"><table class="params-table dash-table"><thead><tr><th>ID</th><th>Label</th><th>Account</th><th>Price</th><th>Category</th><th>Popular</th><th>Actions</th></tr></thead><tbody id="challenge-table-body">
        <?php foreach ($challenges as $c): ?>
            <tr id="challenge-row-<?php echo (int)$c['id']; ?>"><td><?php echo (int)$c['id']; ?></td><td><strong><?php echo e($c['label']); ?></strong></td><td>$<?php echo number_format((float)$c['account_size']); ?></td><td>$<?php echo number_format((float)$c['price']); ?></td><td><?php echo e($c['category']); ?></td><td><?php echo $c['is_popular'] ? 'Yes' : 'No'; ?></td><td><a class="button border-btn small-btn" href="<?php echo url('admin/challenges.php?edit=' . (int)$c['id']); ?>">Edit</a> <button class="button danger-btn small-btn ajax-delete-challenge" data-id="<?php echo (int)$c['id']; ?>" data-token="<?php echo e(csrfToken()); ?>">Delete AJAX</button></td></tr>
        <?php endforeach; ?>
        </tbody></table></div>
    </div>
</div></section>
<?php require_once __DIR__ . '/../includes/footer.php'; ?>

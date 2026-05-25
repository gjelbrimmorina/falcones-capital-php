<?php
$pageTitle = 'Manage Traders';
require_once __DIR__ . '/../includes/header.php';
require_once __DIR__ . '/../includes/repositories.php';
requireRole('admin');

$editId = isset($_GET['edit']) ? (int)$_GET['edit'] : 0;
$editing = $editId ? getTraderById($editId) : null;
$errors = [];
$form = [
    'name' => $editing['name'] ?? '',
    'email' => $editing['email'] ?? '',
    'password' => '',
    'account_size' => $editing['account_size'] ?? '50000',
    'country' => $editing['country'] ?? 'Kosovo',
    'status' => $editing['status'] ?? 'evaluation',
    'profit_split' => $editing['profit_split'] ?? '70',
    'total_payout' => $editing['total_payout'] ?? '0',
    'avatar_path' => $editing['avatar_path'] ?? null,
];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!verifyCsrfToken($_POST['csrf_token'] ?? '')) $errors[] = 'Invalid CSRF token.';
    foreach (['name','email','password','account_size','country','status','profit_split','total_payout'] as $key) $form[$key] = trim($_POST[$key] ?? '');
    $form['avatar_path'] = $editing['avatar_path'] ?? null;

    if (!validateName($form['name'])) $errors[] = 'Name must contain only letters/spaces and be 2-50 chars.';
    if (!validateEmail($form['email'])) $errors[] = 'Invalid email.';
    if (!$editId && !validatePassword($form['password'])) $errors[] = 'Password must be 6+ chars and contain letters and numbers.';
    if ($editId && $form['password'] !== '' && !validatePassword($form['password'])) $errors[] = 'New password must be 6+ chars and contain letters and numbers.';
    if (!validateMoney($form['account_size'])) $errors[] = 'Account size must be valid.';
    if (!validatePercent($form['profit_split'])) $errors[] = 'Profit split must be 0-100.';
    if (!validateMoney($form['total_payout'])) $errors[] = 'Total payout must be valid.';
    if (!validateStatus($form['status'], ['evaluation','funded','suspended'])) $errors[] = 'Invalid status.';

    if (empty($errors)) {
        try {
            $form['avatar_path'] = uploadAvatar($_FILES['avatar'] ?? null, $form['avatar_path']);
            if ($editId) {
                updateTrader($editId, $form);
                redirectWith('admin/traders.php', 'success', 'Trader updated successfully.');
            } else {
                createTrader($form);
                redirectWith('admin/traders.php', 'success', 'Trader created successfully.');
            }
        } catch (Throwable $e) {
            error_log($e->getMessage());
            $errors[] = 'Operation failed. Email may already exist or database is not imported.';
        }
    }
}

if (isset($_GET['delete'])) {
    if (!verifyCsrfToken($_GET['token'] ?? '')) redirectWith('admin/traders.php', 'error', 'Invalid token.');
    try {
        deleteTrader((int)$_GET['delete']);
        redirectWith('admin/traders.php', 'success', 'Trader deleted successfully.');
    } catch (Throwable $e) {
        error_log($e->getMessage());
        redirectWith('admin/traders.php', 'error', 'Trader could not be deleted.');
    }
}

$flash = getFlash();
$traders = dbAvailable() ? getTradersFromDb() : [];
?>
<section class="dashboard"><div class="wrapper">
    <div class="dash-panel-head page-actions"><h1><i class="fas fa-users-cog"></i> Manage Traders</h1><a class="button border-btn" href="<?php echo url('dashboard.php'); ?>">Back to Dashboard</a></div>
    <?php if (!dbAvailable()): ?><div class="alert error">MySQL is not connected. Import sql/falcones_capital.sql first.</div><?php endif; ?>
    <?php if ($flash): ?><div class="alert <?php echo e($flash['type']); ?>"><?php echo e($flash['message']); ?></div><?php endif; ?>
    <?php if ($errors): ?><div class="alert error"><?php echo e(implode(' ', $errors)); ?></div><?php endif; ?>

    <div class="dash-panel form-panel"><h3><?php echo $editId ? 'Edit Trader' : 'Create Trader'; ?></h3>
        <form method="POST" enctype="multipart/form-data" class="admin-form">
            <?php echo csrfInput(); ?>
            <div class="form-cols"><div class="input-group"><label>Name</label><input name="name" value="<?php echo e($form['name']); ?>" required></div><div class="input-group"><label>Email</label><input name="email" value="<?php echo e($form['email']); ?>" required></div></div>
            <div class="form-cols"><div class="input-group"><label><?php echo $editId ? 'New Password (optional)' : 'Password'; ?></label><input type="password" name="password" <?php echo $editId ? '' : 'required'; ?>></div><div class="input-group"><label>Avatar Upload</label><input type="file" name="avatar" accept="image/png,image/jpeg,image/webp"></div></div>
            <div class="form-cols"><div class="input-group"><label>Account Size</label><input type="number" step="0.01" name="account_size" value="<?php echo e($form['account_size']); ?>"></div><div class="input-group"><label>Country</label><input name="country" value="<?php echo e($form['country']); ?>"></div></div>
            <div class="form-cols"><div class="input-group"><label>Status</label><select name="status"><option value="evaluation" <?php echo $form['status']==='evaluation'?'selected':''; ?>>Evaluation</option><option value="funded" <?php echo $form['status']==='funded'?'selected':''; ?>>Funded</option><option value="suspended" <?php echo $form['status']==='suspended'?'selected':''; ?>>Suspended</option></select></div><div class="input-group"><label>Profit Split %</label><input type="number" step="0.01" name="profit_split" value="<?php echo e($form['profit_split']); ?>"></div></div>
            <div class="input-group"><label>Total Payout</label><input type="number" step="0.01" name="total_payout" value="<?php echo e($form['total_payout']); ?>"></div>
            <button class="button blue-btn" type="submit"><?php echo $editId ? 'Update Trader' : 'Create Trader'; ?></button>
            <?php if ($editId): ?><a class="button border-btn" href="<?php echo url('admin/traders.php'); ?>">Cancel</a><?php endif; ?>
        </form>
    </div>

    <div class="dash-panel"><div class="dash-panel-head"><h3>Traders from MySQL</h3><span class="count-badge"><?php echo count($traders); ?> total</span></div>
        <div class="table-container"><table class="params-table dash-table"><thead><tr><th>ID</th><th>Trader</th><th>Email</th><th>Account</th><th>Country</th><th>Status</th><th>Payout</th><th>Actions</th></tr></thead><tbody>
        <?php foreach ($traders as $t): ?><tr><td><?php echo (int)$t['id']; ?></td><td><strong><?php echo e($t['name']); ?></strong></td><td><?php echo e($t['email']); ?></td><td>$<?php echo number_format((float)$t['account_size']); ?></td><td><?php echo e($t['country']); ?></td><td><span class="status <?php echo e($t['status']); ?>"><?php echo e($t['status']); ?></span></td><td>$<?php echo number_format((float)$t['total_payout']); ?></td><td><a class="button border-btn small-btn" href="<?php echo url('admin/traders.php?edit=' . (int)$t['id']); ?>">Edit</a> <a class="button danger-btn small-btn" onclick="return confirm('Delete trader?')" href="<?php echo url('admin/traders.php?delete=' . (int)$t['id'] . '&token=' . urlencode(csrfToken())); ?>">Delete</a></td></tr><?php endforeach; ?>
        </tbody></table></div>
    </div>
</div></section>
<?php require_once __DIR__ . '/../includes/footer.php'; ?>

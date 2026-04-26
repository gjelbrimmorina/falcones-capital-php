<?php
$pageTitle = 'Sign In';
require_once __DIR__ . '/includes/header.php';

// If already logged in, redirect to dashboard
if (isLoggedIn()) {
    header('Location: ' . url('dashboard.php'));
    exit;
}

$error = '';
// Pre-fill email from remember-me cookie
$rememberedEmail = getCookie('remember_email', '');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email    = trim($_POST['email']    ?? '');
    $password = trim($_POST['password'] ?? '');
    $remember = isset($_POST['remember']);

    // Server-side validation with RegEx (email format)
    if (!validateEmail($email)) {
        $error = 'Please enter a valid email address.';
    } elseif (strlen($password) < 3) {
        $error = 'Password is required.';
    } elseif (attemptLogin($email, $password, $remember)) {
        header('Location: ' . url('dashboard.php'));
        exit;
    } else {
        $error = 'Invalid email or password. Please try again.';
    }
}
?>

<section class="login-section">
    <div class="wrapper">
        <div class="login-box">
            <div class="login-left">
                <img src="<?php echo asset('images/logo.png'); ?>" alt="Falcones Capital" class="login-logo">
                <h2>Welcome <span class="blue">Back</span></h2>
                <p>Sign in to access your trader dashboard, manage challenges, and request payouts.</p>

                <div class="demo-box">
                    <h4><i class="fas fa-info-circle"></i> Demo Credentials</h4>
                    <div class="demo-row">
                        <strong>Admin:</strong>
                        <code>admin@falcones.com / admin123</code>
                    </div>
                    <div class="demo-row">
                        <strong>Trader:</strong>
                        <code>trader@falcones.com / trader123</code>
                    </div>
                </div>
            </div>

            <div class="login-right">
                <h3>Sign In</h3>

                <?php if ($error !== ''): ?>
                    <div class="alert error">
                        <i class="fas fa-exclamation-circle"></i>
                        <?php echo e($error); ?>
                    </div>
                <?php endif; ?>

                <?php if ($rememberedEmail !== ''): ?>
                    <div class="alert info">
                        <i class="fas fa-user"></i>
                        Welcome back, we remembered your email.
                    </div>
                <?php endif; ?>

                <form method="POST" action="" class="login-form">
                    <div class="input-group">
                        <label for="email">Email Address</label>
                        <input type="text" id="email" name="email" value="<?php echo e($rememberedEmail); ?>" placeholder="admin@falcones.com" required autofocus>
                    </div>

                    <div class="input-group">
                        <label for="password">Password</label>
                        <input type="password" id="password" name="password" placeholder="Enter your password" required>
                    </div>

                    <div class="checkbox">
                        <input type="checkbox" id="remember" name="remember" <?php echo $rememberedEmail !== '' ? 'checked' : ''; ?>>
                        <label for="remember">Remember me for 30 days</label>
                    </div>

                    <button type="submit" class="button blue-btn wide-btn big-btn">
                        <i class="fas fa-sign-in-alt"></i> Sign In
                    </button>
                </form>

                <p class="login-foot">
                    <a href="<?php echo url('contact.php'); ?>">Need help? Contact support</a>
                </p>
            </div>
        </div>
    </div>
</section>

<?php require_once __DIR__ . '/includes/footer.php'; ?>

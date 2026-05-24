<?php
require_once __DIR__ . '/../classes/User.php';
require_once __DIR__ . '/../classes/Admin.php';
require_once __DIR__ . '/../classes/Trader.php';
require_once __DIR__ . '/db.php';

// Phase 1 fallback users if MySQL is not imported yet.
$HARDCODED_USERS = [
    'admin@falcones.com' => [
        'password' => 'admin123',
        'name'     => 'Admin User',
        'role'     => 'admin'
    ],
    'trader@falcones.com' => [
        'password' => 'trader123',
        'name'     => 'John Trader',
        'role'     => 'trader',
        'accountSize' => 50000,
        'profitSplit' => 70,
        'totalPayout' => 12500,
        'status'      => 'funded'
    ]
];

function attemptLogin($email, $password, $remember = false) {
    global $HARDCODED_USERS;
    $email = strtolower(trim($email));
    $pdo = getPDO();

    if ($pdo) {
        try {
            $stmt = $pdo->prepare('SELECT id, name, email, password_hash, role FROM users WHERE email = ? AND is_active = 1 LIMIT 1');
            $stmt->execute([$email]);
            $user = $stmt->fetch();

            if (!$user || !password_verify($password, $user['password_hash'])) {
                return false;
            }

            session_regenerate_id(true);
            $_SESSION['user_id']    = (int)$user['id'];
            $_SESSION['user_email'] = $user['email'];
            $_SESSION['user_name']  = $user['name'];
            $_SESSION['user_role']  = $user['role'];
            $_SESSION['logged_in']  = true;
            $_SESSION['login_time'] = date('Y-m-d H:i:s');

            if ($remember) {
                setcookie('remember_email', $email, time() + (30 * 24 * 60 * 60), '/');
            }
            return true;
        } catch (Throwable $e) {
            error_log('DB login failed: ' . $e->getMessage());
        }
    }

    if (!isset($HARDCODED_USERS[$email])) return false;
    $user = $HARDCODED_USERS[$email];
    if ($user['password'] !== $password) return false;

    session_regenerate_id(true);
    $_SESSION['user_id']    = null;
    $_SESSION['user_email'] = $email;
    $_SESSION['user_name']  = $user['name'];
    $_SESSION['user_role']  = $user['role'];
    $_SESSION['logged_in']  = true;
    $_SESSION['login_time'] = date('Y-m-d H:i:s');

    if ($remember) {
        setcookie('remember_email', $email, time() + (30 * 24 * 60 * 60), '/');
    }
    return true;
}

function logoutUser() {
    $_SESSION = [];
    if (ini_get('session.use_cookies')) {
        $params = session_get_cookie_params();
        setcookie(session_name(), '', time() - 42000, $params['path'], $params['domain'], $params['secure'], $params['httponly']);
    }
    session_destroy();
    if (isset($_COOKIE['remember_email'])) {
        setcookie('remember_email', '', time() - 3600, '/');
    }
}

function isLoggedIn() {
    return isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true;
}

function getUserRole() { return $_SESSION['user_role'] ?? null; }
function getUserName() { return $_SESSION['user_name'] ?? null; }
function getUserEmail() { return $_SESSION['user_email'] ?? null; }
function getUserId() { return $_SESSION['user_id'] ?? null; }

function getCurrentUser() {
    if (!isLoggedIn()) return null;

    $pdo = getPDO();
    if ($pdo && getUserId()) {
        try {
            $stmt = $pdo->prepare('SELECT u.*, tp.account_size, tp.profit_split, tp.total_payout, tp.status FROM users u LEFT JOIN trader_profiles tp ON tp.user_id = u.id WHERE u.id = ? LIMIT 1');
            $stmt->execute([getUserId()]);
            $data = $stmt->fetch();
            if ($data) {
                if ($data['role'] === 'admin') {
                    return new Admin($data['email'], $data['name']);
                }
                return new Trader($data['email'], $data['name'], (float)($data['account_size'] ?? 0), (int)($data['profit_split'] ?? 0), (float)($data['total_payout'] ?? 0), $data['status'] ?? 'evaluation');
            }
        } catch (Throwable $e) {
            error_log('getCurrentUser failed: ' . $e->getMessage());
        }
    }

    global $HARDCODED_USERS;
    $email = $_SESSION['user_email'];
    if (!isset($HARDCODED_USERS[$email])) return null;
    $data = $HARDCODED_USERS[$email];
    if ($data['role'] === 'admin') return new Admin($email, $data['name']);
    return new Trader($email, $data['name'], $data['accountSize'] ?? 50000, $data['profitSplit'] ?? 70, $data['totalPayout'] ?? 0, $data['status'] ?? 'funded');
}

function requireLogin() {
    if (!isLoggedIn()) {
        header('Location: ' . url('login.php'));
        exit;
    }
}

function requireRole($role) {
    requireLogin();
    if (getUserRole() !== $role) {
        header('Location: ' . url('dashboard.php'));
        exit;
    }
}

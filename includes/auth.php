<?php
// Authentication logic — hardcoded users (NO database, as per Phase 1)
require_once __DIR__ . '/../classes/User.php';
require_once __DIR__ . '/../classes/Admin.php';
require_once __DIR__ . '/../classes/Trader.php';

// Hardcoded users — associative array (demonstration of arrays)
// In Phase 2, this will be replaced with a MySQL database
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

/**
 * Attempt to login with email + password.
 * Returns true on success, false on failure.
 */
function attemptLogin($email, $password, $remember = false) {
    global $HARDCODED_USERS;

    $email = strtolower(trim($email));

    if (!isset($HARDCODED_USERS[$email])) {
        return false;
    }

    $user = $HARDCODED_USERS[$email];
    if ($user['password'] !== $password) {
        return false;
    }

    // Store in session
    $_SESSION['user_email'] = $email;
    $_SESSION['user_name']  = $user['name'];
    $_SESSION['user_role']  = $user['role'];
    $_SESSION['logged_in']  = true;
    $_SESSION['login_time'] = date('Y-m-d H:i:s');

    // Remember-me cookie (lives 30 days)
    if ($remember) {
        setcookie('remember_email', $email, time() + (30 * 24 * 60 * 60), '/');
    }

    return true;
}

/**
 * Logout — clears session and remember-me cookie.
 */
function logoutUser() {
    $_SESSION = [];
    session_destroy();
    if (isset($_COOKIE['remember_email'])) {
        setcookie('remember_email', '', time() - 3600, '/');
    }
}

/**
 * Check if user is logged in.
 */
function isLoggedIn() {
    return isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true;
}

/**
 * Get current user role.
 */
function getUserRole() {
    return $_SESSION['user_role'] ?? null;
}

/**
 * Get current user name.
 */
function getUserName() {
    return $_SESSION['user_name'] ?? null;
}

/**
 * Get current user email.
 */
function getUserEmail() {
    return $_SESSION['user_email'] ?? null;
}

/**
 * Build a full User object (Admin or Trader) from the current session.
 * Returns null if not logged in.
 */
function getCurrentUser() {
    global $HARDCODED_USERS;

    if (!isLoggedIn()) return null;

    $email = $_SESSION['user_email'];
    if (!isset($HARDCODED_USERS[$email])) return null;

    $data = $HARDCODED_USERS[$email];

    if ($data['role'] === 'admin') {
        return new Admin($email, $data['name']);
    } else {
        return new Trader(
            $email,
            $data['name'],
            $data['accountSize'] ?? 50000,
            $data['profitSplit'] ?? 70,
            $data['totalPayout'] ?? 0,
            $data['status']      ?? 'funded'
        );
    }
}

/**
 * Require user to be logged in — redirect to login if not.
 */
function requireLogin() {
    if (!isLoggedIn()) {
        header('Location: ' . url('login.php'));
        exit;
    }
}

/**
 * Require specific role — redirect if not matching.
 */
function requireRole($role) {
    requireLogin();
    if (getUserRole() !== $role) {
        header('Location: ' . url('dashboard.php'));
        exit;
    }
}

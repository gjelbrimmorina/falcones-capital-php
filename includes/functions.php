<?php
// Utility functions — validation (RegEx), sorting, sanitization

/**
 * Escape HTML output (basic XSS protection).
 */
function e($value) {
    return htmlspecialchars($value ?? '', ENT_QUOTES, 'UTF-8');
}

// ============================================
// REGEX VALIDATION FUNCTIONS
// ============================================

/**
 * Validate email address with RegEx.
 * Format: name@domain.tld (basic standard email pattern)
 */
function validateEmail($email) {
    $pattern = '/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/';
    return (bool) preg_match($pattern, $email);
}

/**
 * Validate full name — only letters, spaces, hyphens, apostrophes (2-50 chars).
 */
function validateName($name) {
    $pattern = "/^[a-zA-Z\s'-]{2,50}$/";
    return (bool) preg_match($pattern, $name);
}

/**
 * Validate phone number — optional +, then 8-15 digits.
 */
function validatePhone($phone) {
    $pattern = '/^\+?[0-9]{8,15}$/';
    return (bool) preg_match($pattern, $phone);
}

/**
 * Validate password — at least 6 chars, must contain letter and number.
 */
function validatePassword($password) {
    $pattern = '/^(?=.*[A-Za-z])(?=.*\d)[A-Za-z\d]{6,}$/';
    return (bool) preg_match($pattern, $password);
}

// ============================================
// SORTING FUNCTIONS
// ============================================

/**
 * Sort challenges by price (ascending or descending).
 */
function sortChallengesByPrice($challenges, $ascending = true) {
    usort($challenges, function($a, $b) use ($ascending) {
        $cmp = $a->getNumericPrice() - $b->getNumericPrice();
        return $ascending ? $cmp : -$cmp;
    });
    return $challenges;
}

/**
 * Sort challenges by size (ascending or descending).
 */
function sortChallengesBySize($challenges, $ascending = true) {
    usort($challenges, function($a, $b) use ($ascending) {
        $cmp = $a->getNumericSize() - $b->getNumericSize();
        return $ascending ? $cmp : -$cmp;
    });
    return $challenges;
}

/**
 * Filter challenges by category (starter / pro / all).
 */
function filterChallenges($challenges, $category) {
    if ($category === 'all') return $challenges;
    
    $result = [];
    foreach ($challenges as $c) {
        if ($c->getCategory() === $category) {
            $result[] = $c;
        }
    }
    return $result;
}

// ============================================
// HELPER FUNCTIONS
// ============================================

/**
 * Determine if a link is the current page (for active menu class).
 */
function isActivePage($page) {
    $current = basename($_SERVER['PHP_SELF']);
    return $current === $page ? 'active' : '';
}

/**
 * Get cookie value safely.
 */
function getCookie($name, $default = '') {
    return $_COOKIE[$name] ?? $default;
}

/**
 * Get theme preference from cookie.
 */
function getThemePreference() {
    return getCookie('theme', 'dark');
}

// ============================================
// PHASE 2 SECURITY + ADVANCED HELPERS
// ============================================

/**
 * CSRF token protects POST forms from cross-site request forgery.
 */
function csrfToken() {
    if (empty($_SESSION['csrf_token'])) {
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
    }
    return $_SESSION['csrf_token'];
}

function csrfInput() {
    return '<input type="hidden" name="csrf_token" value="' . e(csrfToken()) . '">';
}

function verifyCsrfToken($token) {
    return isset($_SESSION['csrf_token']) && is_string($token) && hash_equals($_SESSION['csrf_token'], $token);
}

function redirectWith($path, $type, $message) {
    $_SESSION['flash'] = ['type' => $type, 'message' => $message];
    header('Location: ' . url($path));
    exit;
}

function getFlash() {
    $flash = $_SESSION['flash'] ?? null;
    unset($_SESSION['flash']);
    return $flash;
}

function validateMoney($value) {
    return is_numeric($value) && (float)$value >= 0;
}

function validatePercent($value) {
    return is_numeric($value) && (float)$value >= 0 && (float)$value <= 100;
}

function validateStatus($status, $allowed) {
    return in_array($status, $allowed, true);
}

function ensureDirectory($dir) {
    if (!is_dir($dir)) {
        mkdir($dir, 0775, true);
    }
}

/**
 * Handles avatar/image upload safely: size limit, extension whitelist, MIME whitelist, unique filename.
 */
function uploadAvatar($file, $oldPath = null) {
    if (!isset($file) || ($file['error'] ?? UPLOAD_ERR_NO_FILE) === UPLOAD_ERR_NO_FILE) {
        return $oldPath;
    }

    if ($file['error'] !== UPLOAD_ERR_OK) {
        throw new RuntimeException('Upload failed. Please try again.');
    }

    if ($file['size'] > 2 * 1024 * 1024) {
        throw new RuntimeException('Avatar must be smaller than 2MB.');
    }

    $allowedExt = ['jpg', 'jpeg', 'png', 'webp'];
    $ext = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
    if (!in_array($ext, $allowedExt, true)) {
        throw new RuntimeException('Only JPG, PNG or WEBP images are allowed.');
    }

    $finfo = new finfo(FILEINFO_MIME_TYPE);
    $mime = $finfo->file($file['tmp_name']);
    $allowedMime = ['image/jpeg', 'image/png', 'image/webp'];
    if (!in_array($mime, $allowedMime, true)) {
        throw new RuntimeException('Invalid image file type.');
    }

    $uploadDir = __DIR__ . '/../uploads/avatars';
    ensureDirectory($uploadDir);
    $filename = 'avatar_' . bin2hex(random_bytes(10)) . '.' . $ext;
    $target = $uploadDir . '/' . $filename;

    if (!move_uploaded_file($file['tmp_name'], $target)) {
        throw new RuntimeException('Could not save uploaded file.');
    }

    return 'uploads/avatars/' . $filename;
}

function sendContactEmail($name, $email, $subject, $message) {
    $to = $GLOBALS['MAIL_TO'] ?? $GLOBALS['CONTACT_EMAIL'];
    $safeSubject = 'Falcones Contact: ' . preg_replace('/[\r\n]+/', ' ', $subject);
    $body = "Name: {$name}\nEmail: {$email}\n\nMessage:\n{$message}";
    $headers = "From: no-reply@falcones-capital.local\r\nReply-To: {$email}\r\n";

    $sent = false;
    try {
        $sent = @mail($to, $safeSubject, $body, $headers);
    } catch (Throwable $e) {
        error_log('Mail error: ' . $e->getMessage());
    }

    // Local development fallback: log the email so the requirement can be demonstrated on XAMPP.
    $logDir = __DIR__ . '/../storage';
    ensureDirectory($logDir);
    file_put_contents($logDir . '/mail_log.txt', "--- " . date('Y-m-d H:i:s') . " ---\nTo: {$to}\nSubject: {$safeSubject}\n{$body}\n\n", FILE_APPEND);

    return $sent;
}

function jsonResponse($data, $statusCode = 200) {
    http_response_code($statusCode);
    header('Content-Type: application/json');
    echo json_encode($data);
    exit;
}

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

<?php
// Global configuration
// This file uses global variables as required by the project specification

// Global variables (as per requirement: "Përdorimi i variablave(edhe ato globale)")
$GLOBALS['SITE_NAME']        = 'Falcones Capital';
$GLOBALS['SITE_TAGLINE']     = 'Get Funded Up to $300K';
$GLOBALS['SITE_DESCRIPTION'] = 'Proprietary trading firm for Forex traders. Get funded up to $300,000.';
$GLOBALS['CONTACT_EMAIL']    = 'support@falcones-capital.com';
$GLOBALS['FOUNDED_YEAR']     = 2021;
$GLOBALS['CURRENT_YEAR']     = date('Y');

// Base URL helper — adjust if installed in a subfolder
// Example: if project is at http://localhost/falcones-capital-php, BASE_URL = '/falcones-capital-php'
// Base URL helper — adjust if installed in a subfolder
$GLOBALS['BASE_URL'] = '/falcones-capital-php';

// Phase 2: MySQL configuration
$GLOBALS['DB_HOST'] = 'localhost';
$GLOBALS['DB_NAME'] = 'falcones_capital';
$GLOBALS['DB_USER'] = 'root';
$GLOBALS['DB_PASS'] = '';

// Phase 2: email configuration. On local XAMPP, emails are also saved to storage/mail_log.txt.
$GLOBALS['MAIL_TO'] = 'support@falcones-capital.com';

// Helper function to build URLs
function url($path = '') {
    $base = $GLOBALS['BASE_URL'];
    $path = ltrim($path, '/');
    return $base . '/' . $path;
}

// Helper function to build asset URLs
function asset($path) {
    return url('assets/' . ltrim($path, '/'));
}

// Start session on every page that includes this file
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

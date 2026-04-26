<?php
require_once __DIR__ . '/config.php';
require_once __DIR__ . '/auth.php';
require_once __DIR__ . '/functions.php';

$pageTitle = $pageTitle ?? $GLOBALS['SITE_NAME'];
$theme = getThemePreference(); // read theme cookie
?>
<!DOCTYPE html>
<html lang="en" data-theme="<?php echo e($theme); ?>">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="theme-color" content="#0A1628">
    <meta name="description" content="<?php echo e($GLOBALS['SITE_DESCRIPTION']); ?>">
    <title><?php echo e($pageTitle); ?> | <?php echo e($GLOBALS['SITE_NAME']); ?></title>

    <link rel="icon" href="<?php echo asset('images/favicon.ico'); ?>">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="<?php echo asset('css/styles.css'); ?>">
</head>
<body>

<header class="navbar">
    <nav>
        <div class="wrapper">
            <div class="nav-wrapper">
                <a href="<?php echo url('index.php'); ?>" class="logo">
                    <img src="<?php echo asset('images/logo.png'); ?>" alt="Falcones Capital" class="logo-img">
                    <span>Falcones Capital</span>
                </a>

                <ul class="menu">
                    <li><a href="<?php echo url('index.php'); ?>"         class="<?php echo isActivePage('index.php'); ?>">Home</a></li>
                    <li><a href="<?php echo url('challenges.php'); ?>"    class="<?php echo isActivePage('challenges.php'); ?>">Challenges</a></li>
                    <li><a href="<?php echo url('trading-rules.php'); ?>" class="<?php echo isActivePage('trading-rules.php'); ?>">Trading Rules</a></li>
                    <li><a href="<?php echo url('about.php'); ?>"         class="<?php echo isActivePage('about.php'); ?>">About Us</a></li>
                    <li><a href="<?php echo url('faq.php'); ?>"           class="<?php echo isActivePage('faq.php'); ?>">FAQs</a></li>
                    <li><a href="<?php echo url('contact.php'); ?>"       class="<?php echo isActivePage('contact.php'); ?>">Contact</a></li>
                </ul>

                <div class="nav-buttons">
                    <?php if (isLoggedIn()): ?>
                        <a href="<?php echo url('dashboard.php'); ?>" class="button border-btn">
                            <i class="fas fa-user-circle"></i> <?php echo e(getUserName()); ?>
                        </a>
                        <a href="<?php echo url('logout.php'); ?>" class="button blue-btn">Logout</a>
                    <?php else: ?>
                        <a href="<?php echo url('login.php'); ?>" class="button border-btn">Dashboard</a>
                        <a href="<?php echo url('login.php'); ?>" class="button blue-btn">Sign In</a>
                    <?php endif; ?>
                </div>

                <button class="hamburger" id="hamburger-btn">
                    <i class="fas fa-bars"></i>
                </button>
            </div>
        </div>
    </nav>
</header>

<div class="side-menu" id="side-menu">
    <div class="side-menu-top">
        <a href="<?php echo url('index.php'); ?>" class="logo">
            <img src="<?php echo asset('images/logo.png'); ?>" alt="Falcones Capital" class="logo-img">
            <span>Falcones Capital</span>
        </a>
        <button class="close-btn" id="close-menu">
            <i class="fas fa-times"></i>
        </button>
    </div>
    <ul class="side-links">
        <li><a href="<?php echo url('index.php'); ?>">Home</a></li>
        <li><a href="<?php echo url('challenges.php'); ?>">Challenges</a></li>
        <li><a href="<?php echo url('trading-rules.php'); ?>">Trading Rules</a></li>
        <li><a href="<?php echo url('about.php'); ?>">About Us</a></li>
        <li><a href="<?php echo url('faq.php'); ?>">FAQs</a></li>
        <li><a href="<?php echo url('contact.php'); ?>">Contact</a></li>
    </ul>
    <div class="side-buttons">
        <?php if (isLoggedIn()): ?>
            <a href="<?php echo url('dashboard.php'); ?>" class="button border-btn wide-btn">Dashboard</a>
            <a href="<?php echo url('logout.php'); ?>" class="button blue-btn wide-btn">Logout</a>
        <?php else: ?>
            <a href="<?php echo url('login.php'); ?>" class="button border-btn wide-btn">Sign In</a>
            <a href="<?php echo url('login.php'); ?>" class="button blue-btn wide-btn">Sign Up</a>
        <?php endif; ?>
    </div>
</div>

<main>

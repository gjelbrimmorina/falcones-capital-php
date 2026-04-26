<?php
require_once __DIR__ . '/includes/config.php';
require_once __DIR__ . '/includes/auth.php';

logoutUser();

header('Location: ' . url('login.php'));
exit;

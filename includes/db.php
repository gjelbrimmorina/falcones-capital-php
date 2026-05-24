<?php
/**
 * Phase 2 database connection using PDO.
 * PDO prepared statements are used everywhere to protect from SQL Injection.
 */
require_once __DIR__ . '/config.php';

function getPDO() {
    static $pdo = null;
    if ($pdo instanceof PDO) {
        return $pdo;
    }

    $host = $GLOBALS['DB_HOST'] ?? 'localhost';
    $db   = $GLOBALS['DB_NAME'] ?? 'falcones_capital';
    $user = $GLOBALS['DB_USER'] ?? 'root';
    $pass = $GLOBALS['DB_PASS'] ?? '';
    $charset = 'utf8mb4';

    $dsn = "mysql:host={$host};dbname={$db};charset={$charset}";

    try {
        $pdo = new PDO($dsn, $user, $pass, [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES => false,
        ]);
        return $pdo;
    } catch (PDOException $e) {
        error_log('Database connection failed: ' . $e->getMessage());
        return null;
    }
}

function dbAvailable() {
    return getPDO() instanceof PDO;
}

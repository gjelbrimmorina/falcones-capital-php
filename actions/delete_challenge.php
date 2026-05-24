<?php
require_once __DIR__ . '/../includes/config.php';
require_once __DIR__ . '/../includes/functions.php';
require_once __DIR__ . '/../includes/auth.php';
require_once __DIR__ . '/../includes/repositories.php';

requireRole('admin');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') jsonResponse(['success' => false, 'message' => 'Method not allowed'], 405);
if (!verifyCsrfToken($_POST['csrf_token'] ?? '')) jsonResponse(['success' => false, 'message' => 'Invalid token'], 403);
$id = (int)($_POST['id'] ?? 0);
if ($id <= 0) jsonResponse(['success' => false, 'message' => 'Invalid challenge ID'], 422);

try {
    deleteChallenge($id);
    jsonResponse(['success' => true, 'message' => 'Challenge deleted with AJAX.']);
} catch (Throwable $e) {
    error_log($e->getMessage());
    jsonResponse(['success' => false, 'message' => 'Delete failed. The challenge may be linked to traders.'], 500);
}

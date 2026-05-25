<?php
require_once __DIR__ . '/db.php';

function getChallengesFromDb() {
    $pdo = getPDO();
    if (!$pdo) return [];
    $stmt = $pdo->query('SELECT * FROM challenges ORDER BY account_size ASC');
    return $stmt->fetchAll();
}

function getChallengeById($id) {
    $pdo = getPDO(); if (!$pdo) return null;
    $stmt = $pdo->prepare('SELECT * FROM challenges WHERE id = ?');
    $stmt->execute([(int)$id]);
    return $stmt->fetch();
}

function createChallenge($data) {
    $pdo = getPDO();
    $stmt = $pdo->prepare('INSERT INTO challenges (label, account_size, price, profit_target, daily_drawdown, max_drawdown, profit_split, category, is_popular) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)');
    $stmt->execute([$data['label'], $data['account_size'], $data['price'], $data['profit_target'], $data['daily_drawdown'], $data['max_drawdown'], $data['profit_split'], $data['category'], $data['is_popular']]);
    return $pdo->lastInsertId();
}

function updateChallenge($id, $data) {
    $pdo = getPDO();
    $stmt = $pdo->prepare('UPDATE challenges SET label=?, account_size=?, price=?, profit_target=?, daily_drawdown=?, max_drawdown=?, profit_split=?, category=?, is_popular=? WHERE id=?');
    return $stmt->execute([$data['label'], $data['account_size'], $data['price'], $data['profit_target'], $data['daily_drawdown'], $data['max_drawdown'], $data['profit_split'], $data['category'], $data['is_popular'], (int)$id]);
}

function deleteChallenge($id) {
    $pdo = getPDO();
    $stmt = $pdo->prepare('DELETE FROM challenges WHERE id = ?');
    return $stmt->execute([(int)$id]);
}

function getTradersFromDb() {
    $pdo = getPDO(); if (!$pdo) return [];
    $sql = 'SELECT u.id, u.name, u.email, u.role, u.avatar_path, u.created_at, tp.account_size, tp.country, tp.status, tp.profit_split, tp.total_payout
            FROM users u LEFT JOIN trader_profiles tp ON tp.user_id = u.id
            WHERE u.role = "trader" ORDER BY u.id DESC';
    return $pdo->query($sql)->fetchAll();
}

function getTraderById($id) {
    $pdo = getPDO(); if (!$pdo) return null;
    $stmt = $pdo->prepare('SELECT u.*, tp.account_size, tp.country, tp.status, tp.profit_split, tp.total_payout FROM users u LEFT JOIN trader_profiles tp ON tp.user_id = u.id WHERE u.id = ? AND u.role = "trader"');
    $stmt->execute([(int)$id]);
    return $stmt->fetch();
}

function createTrader($data) {
    $pdo = getPDO();
    $pdo->beginTransaction();
    try {
        $stmt = $pdo->prepare('INSERT INTO users (name, email, password_hash, role, avatar_path) VALUES (?, ?, ?, "trader", ?)');
        $stmt->execute([$data['name'], $data['email'], password_hash($data['password'], PASSWORD_DEFAULT), $data['avatar_path'] ?? null]);
        $userId = (int)$pdo->lastInsertId();
        $stmt = $pdo->prepare('INSERT INTO trader_profiles (user_id, account_size, country, status, profit_split, total_payout) VALUES (?, ?, ?, ?, ?, ?)');
        $stmt->execute([$userId, $data['account_size'], $data['country'], $data['status'], $data['profit_split'], $data['total_payout']]);
        $pdo->commit();
        return $userId;
    } catch (Throwable $e) {
        $pdo->rollBack();
        throw $e;
    }
}

function updateTrader($id, $data) {
    $pdo = getPDO();
    $pdo->beginTransaction();
    try {
        $params = [$data['name'], $data['email'], $data['avatar_path'] ?? null];
        $sql = 'UPDATE users SET name=?, email=?, avatar_path=?';
        if (!empty($data['password'])) {
            $sql .= ', password_hash=?';
            $params[] = password_hash($data['password'], PASSWORD_DEFAULT);
        }
        $sql .= ' WHERE id=? AND role="trader"';
        $params[] = (int)$id;
        $stmt = $pdo->prepare($sql);
        $stmt->execute($params);

        $stmt = $pdo->prepare('UPDATE trader_profiles SET account_size=?, country=?, status=?, profit_split=?, total_payout=? WHERE user_id=?');
        $stmt->execute([$data['account_size'], $data['country'], $data['status'], $data['profit_split'], $data['total_payout'], (int)$id]);
        $pdo->commit();
        return true;
    } catch (Throwable $e) {
        $pdo->rollBack();
        throw $e;
    }
}

function deleteTrader($id) {
    $pdo = getPDO();
    $stmt = $pdo->prepare('DELETE FROM users WHERE id = ? AND role = "trader"');
    return $stmt->execute([(int)$id]);
}

function getContactMessages($limit = 100) {
    $pdo = getPDO(); if (!$pdo) return [];
    $stmt = $pdo->prepare('SELECT * FROM contact_messages ORDER BY created_at DESC LIMIT ?');
    $stmt->bindValue(1, (int)$limit, PDO::PARAM_INT);
    $stmt->execute();
    return $stmt->fetchAll();
}

function saveContactMessage($data) {
    $pdo = getPDO(); if (!$pdo) return false;
    $stmt = $pdo->prepare('INSERT INTO contact_messages (name, email, phone, subject, message) VALUES (?, ?, ?, ?, ?)');
    return $stmt->execute([$data['name'], $data['email'], $data['phone'], $data['subject'], $data['message']]);
}

function markMessageRead($id) {
    $pdo = getPDO();
    $stmt = $pdo->prepare('UPDATE contact_messages SET is_read = 1 WHERE id = ?');
    return $stmt->execute([(int)$id]);
}

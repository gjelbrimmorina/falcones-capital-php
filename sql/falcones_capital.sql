CREATE DATABASE IF NOT EXISTS falcones_capital CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE falcones_capital;

DROP TABLE IF EXISTS payout_requests;
DROP TABLE IF EXISTS contact_messages;
DROP TABLE IF EXISTS trader_challenges;
DROP TABLE IF EXISTS trader_profiles;
DROP TABLE IF EXISTS challenges;
DROP TABLE IF EXISTS users;

CREATE TABLE users (
  id INT AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(100) NOT NULL,
  email VARCHAR(120) NOT NULL UNIQUE,
  password_hash VARCHAR(255) NOT NULL,
  role ENUM('admin','trader') NOT NULL DEFAULT 'trader',
  avatar_path VARCHAR(255) DEFAULT NULL,
  is_active TINYINT(1) NOT NULL DEFAULT 1,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;

CREATE TABLE challenges (
  id INT AUTO_INCREMENT PRIMARY KEY,
  label VARCHAR(80) NOT NULL,
  account_size DECIMAL(12,2) NOT NULL,
  price DECIMAL(10,2) NOT NULL,
  profit_target DECIMAL(5,2) NOT NULL DEFAULT 8.00,
  daily_drawdown DECIMAL(5,2) NOT NULL DEFAULT 5.00,
  max_drawdown DECIMAL(5,2) NOT NULL DEFAULT 10.00,
  profit_split DECIMAL(5,2) NOT NULL DEFAULT 80.00,
  category ENUM('starter','pro') NOT NULL DEFAULT 'starter',
  is_popular TINYINT(1) NOT NULL DEFAULT 0,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;

CREATE TABLE trader_profiles (
  id INT AUTO_INCREMENT PRIMARY KEY,
  user_id INT NOT NULL UNIQUE,
  account_size DECIMAL(12,2) NOT NULL DEFAULT 0,
  country VARCHAR(80) NOT NULL DEFAULT 'Kosovo',
  status ENUM('evaluation','funded','suspended') NOT NULL DEFAULT 'evaluation',
  profit_split DECIMAL(5,2) NOT NULL DEFAULT 70.00,
  total_payout DECIMAL(12,2) NOT NULL DEFAULT 0,
  FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
) ENGINE=InnoDB;

CREATE TABLE trader_challenges (
  id INT AUTO_INCREMENT PRIMARY KEY,
  user_id INT NOT NULL,
  challenge_id INT NOT NULL,
  status ENUM('active','passed','failed') NOT NULL DEFAULT 'active',
  started_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
  FOREIGN KEY (challenge_id) REFERENCES challenges(id) ON DELETE CASCADE
) ENGINE=InnoDB;

CREATE TABLE contact_messages (
  id INT AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(100) NOT NULL,
  email VARCHAR(120) NOT NULL,
  phone VARCHAR(30) DEFAULT NULL,
  subject VARCHAR(150) NOT NULL,
  message TEXT NOT NULL,
  is_read TINYINT(1) NOT NULL DEFAULT 0,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;

CREATE TABLE payout_requests (
  id INT AUTO_INCREMENT PRIMARY KEY,
  user_id INT NOT NULL,
  amount DECIMAL(12,2) NOT NULL,
  status ENUM('pending','approved','rejected') NOT NULL DEFAULT 'pending',
  requested_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
) ENGINE=InnoDB;

INSERT INTO users (id, name, email, password_hash, role, is_active) VALUES
(1, 'Admin User', 'admin@falcones.com', '$2y$12$lcq.CIPo4Y30jkdWIj0UxOz7YaNLZe8MF3TuKu40So6ejHFfi8W4O', 'admin', 1),
(2, 'John Trader', 'trader@falcones.com', '$2y$12$UIILLMWxulRyc57keKzeTOJdB7GzpeXLU4PZT.3sFHZl4GLhDM4ji', 'trader', 1),
(3, 'Arta Krasniqi', 'arta@falcones.com', '$2y$12$3J6ouuC8RaXtKmmbn7kK2.XDTkd6m3gGnA9zfY1j.heps2w17pWAq', 'trader', 1);

INSERT INTO challenges (id, label, account_size, price, profit_target, daily_drawdown, max_drawdown, profit_split, category, is_popular) VALUES
(1, 'Starter', 5000, 49, 8, 5, 10, 60, 'starter', 0),
(2, 'Growth', 10000, 89, 8, 5, 10, 70, 'starter', 0),
(3, 'Pro', 25000, 179, 8, 5, 10, 80, 'starter', 1),
(4, 'Elite', 50000, 299, 8, 5, 10, 80, 'pro', 0),
(5, 'Master', 100000, 499, 8, 5, 10, 90, 'pro', 1),
(6, 'Falcon', 200000, 899, 8, 5, 10, 100, 'pro', 0);

INSERT INTO trader_profiles (user_id, account_size, country, status, profit_split, total_payout) VALUES
(2, 50000, 'Kosovo', 'funded', 70, 12500),
(3, 100000, 'Albania', 'evaluation', 80, 0);

INSERT INTO trader_challenges (user_id, challenge_id, status) VALUES
(2, 4, 'passed'),
(3, 5, 'active');

INSERT INTO contact_messages (name, email, phone, subject, message, is_read) VALUES
('Demo Client', 'client@example.com', '+38344111222', 'Question about challenge', 'Can I trade during news?', 0),
('Support Tester', 'tester@example.com', NULL, 'Payout method', 'Do you support bank transfer?', 1);

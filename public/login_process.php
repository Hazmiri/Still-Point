<?php

declare(strict_types=1);

/**
 * Start session to store login state
 */
session_start();

/**
 * Validate input
 */
if (!isset($_POST['username'], $_POST['password'])) {
  die('Invalid request.');
}

$username = trim($_POST['username']);
$password = $_POST['password'];

require_once __DIR__ . '/../src/db.php';

$pdo = db();

/**
 * Retrieve user by username
 */
$stmt = $pdo->prepare("SELECT * FROM users WHERE username = :username");
$stmt->execute(['username' => $username]);

$user = $stmt->fetch();

/**
 * Verify password
 */
if (!$user || !password_verify($password, $user['password_hash'])) {
    die('Invalid credentials.');
}

?>
<?php
declare(strict_types=1);

require_once __DIR__ . '/../src/bootstrap.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    flash('Invalid login request.', 'error');
    redirect('login.php');
}

if (!verify_csrf($_POST['csrf_token'] ?? null)) {
    flash('Your session token was invalid. Please try again.', 'error');
    redirect('login.php');
}

$username = trim($_POST['username'] ?? '');
$password = $_POST['password'] ?? '';

$errors = [];
$old = [
    'username' => $username,
];

if ($username === '' || $password === '') {
    $errors[] = 'Username and password are required.';
}

if ($errors !== []) {
    store_form_state('login', $errors, $old);
    redirect('login.php');
}

$pdo = db();

$stmt = $pdo->prepare("SELECT * FROM users WHERE username = :username");
$stmt->execute(['username' => $username]);

$user = $stmt->fetch();

if (!$user || !password_verify($password, $user['password_hash'])) {
    store_form_state('login', ['Invalid username or password.'], $old);
    redirect('login.php');
}

session_regenerate_id(true);

$_SESSION['user_id'] = $user['id'];
$_SESSION['username'] = $user['username'];

flash('Signed in successfully.');
redirect('dashboard.php');
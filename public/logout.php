<?php
declare(strict_types=1);

require_once __DIR__ . '/../src/bootstrap.php';

unset($_SESSION['user_id'], $_SESSION['username']);

flash('You have been signed out.');
redirect('login.php');
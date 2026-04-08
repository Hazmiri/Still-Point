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

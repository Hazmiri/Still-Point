<?php

declare(strict_types=1);
function db(): PDO
{
  static $pdo = null;

  if ($pdo instanceof PDO) {
    return $pdo;
  }

  $dsn = 'mysql:host=127.0.0.1;dbname=still_point;charset=utf8mb4';
  $user = 'root';
  $pass = ''; // XAMPP default (we harden later)

  $pdo = new PDO($dsn, $user, $pass, [
    PDO::ATTR_ERRMODE     => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE  => PDO::FETCH_ASSOC,
  ]);

  return $pdo;
}

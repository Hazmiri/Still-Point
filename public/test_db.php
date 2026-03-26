<?php

declare(strict_types=1);

require_once __DIR__ . '/../src/db.php';

try {
  $pdo = db();
  $result = $pdo->query("SELECT 'Connection successful' AS message")->fetch();

  echo htmlspecialchars($result['message'], ENT_QUOTES, 'UTF-8');
} catch (Throwable $e) {
  echo "Error: " . $e->getMessage();
}

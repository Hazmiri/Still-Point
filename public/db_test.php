<?php

declare(strict_types=1);

require_once __DIR__ . '/../src/db.php';

$row = db()->query("SELECT 'Still Point connected.' AS message")->fetch();
echo htmlspecialchars($row['message'], ENT_QUOTES, 'UTF-8');

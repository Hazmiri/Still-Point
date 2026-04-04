<?php

declare(strict_types=1);

/**
 * STEP 1 — Validate input from URL
 */

// Check if 'id' exists
if (!isset($_GET['id'])) {
  die('Instrument ID not provided.');
}

// Convert to integer
$id = (int) $_GET['id'];

// Validate value
if ($id <= 0) {
  die('Invalid instrument ID.');
}

/**
 * STEP 2 — Query database safely
 */

require_once __DIR__ . '/../src/db.php';

$pdo = db();

// Prepared statement protects against SQL injection
$stmt = $pdo->prepare("SELECT * FROM instruments WHERE id = :id");

// Execute with parameter
$stmt->execute(['id' => $id]);

// Fetch one record
$instrument = $stmt->fetch();

/**
 * STEP 3 — Handle missing data
 */

if (!$instrument) {
  die('Instrument not found.');
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <title>Instrument</title>
</head>

<body>

  <h1>
    <?= htmlspecialchars($instrument['name'], ENT_QUOTES, 'UTF-8') ?>
  </h1>

  <p>
    <strong>Type:</strong>
    <?= htmlspecialchars($instrument['cue_type'], ENT_QUOTES, 'UTF-8') ?><br>

    <strong>Material:</strong>
    <?= htmlspecialchars($instrument['material'], ENT_QUOTES, 'UTF-8') ?><br>

    <strong>Length:</strong>
    <?= (int)$instrument['length_mm'] ?> mm<br>

    <strong>Weight:</strong>
    <?= (int)$instrument['weight_g'] ?> g<br>

    <strong>Tip:</strong>
    <?= htmlspecialchars($instrument['tip_mm'], ENT_QUOTES, 'UTF-8') ?> mm
  </p>

  <p>
    <?= htmlspecialchars($instrument['description'], ENT_QUOTES, 'UTF-8') ?>
  </p>

</body>

</html>
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

  <h1>Instrument Detail</h1>

  <p>Content will appear here.</p>

  <p>
    <a href="collection.php">← Back to Collection</a>
  </p>

</body>

</html>
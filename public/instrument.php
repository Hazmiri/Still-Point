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
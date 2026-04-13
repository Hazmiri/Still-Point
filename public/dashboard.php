<?php
declare(strict_types=1);

/**
 * Load shared project setup.
 */
require_once __DIR__ . '/../src/bootstrap.php';

/**
 * Protect the dashboard so only authenticated users can access it.
 */
if (!isset($_SESSION['user_id'])) {
    die('Access denied.');
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Custodian Console</title>
</head>
<body>

<h1>Custodian Console</h1>

<p>You are authenticated.</p>

<p>
    <a href="add_instrument.php">Register a new instrument</a>
</p>

<p>
    <a href="logout.php">Logout</a>
</p>

</body>
</html>
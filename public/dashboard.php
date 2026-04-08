<?php
declare(strict_types=1);

session_start();

/**
 * Protect page
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
    <a href="logout.php">Logout</a>
</p>

</body>
</html>
<?php
declare(strict_types=1);

/**
 * Start the session so we can check whether the user is logged in.
 */
session_start();

/**
 * Protect this page.
 * If the custodian is not logged in, deny access.
 */
if (!isset($_SESSION['user_id'])) {
    die('Access denied.');
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Register Instrument</title>
</head>
<body>

<h1>Register Instrument</h1>

<p>This page will allow the custodian to add a new instrument.</p>

<p>
    <a href="dashboard.php">← Back to Dashboard</a>
</p>

</body>
</html>
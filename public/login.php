<?php

declare(strict_types=1);

/**
 * Load shared project setup.
 */
require_once __DIR__ . '/../src/bootstrap.php';
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Custodian Access</title>
</head>

<body>

    <h1>Custodian Access</h1>

    <form method="POST" action="login_process.php">

        <label>
            Username:
            <input type="text" name="username" required>
        </label>
        <br><br>

        <label>
            Password:
            <input type="password" name="password" required>
        </label>
        <br><br>

        <button type="submit">Enter</button>

    </form>

</body>

</html>
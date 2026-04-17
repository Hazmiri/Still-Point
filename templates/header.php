<?php
declare(strict_types=1);

/**
 * Shared page header.
 *
 * Expected variables:
 * - $pageTitle: string
 */
if (!isset($pageTitle) || $pageTitle === '') {
    $pageTitle = 'Still Point';
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title><?= htmlspecialchars($pageTitle, ENT_QUOTES, 'UTF-8') ?></title>
</head>

<body>

<header>

    <nav aria-label="Main site navigation">
        <ul>
            <li><a href="index.php">Home</a></li>
            <li><a href="collection.php">Collection</a></li>
            <li><a href="provenance.php">Provenance</a></li>
            <li><a href="contact.php">Contact</a></li>
            <li><a href="faq.php">FAQ</a></li>
            <li><a href="login.php">Custodian Access</a></li>
            </ul>
    </nav>

</header>

<main>
    
</main>
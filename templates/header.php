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
    <link rel="stylesheet" href="assets/style.css">
</head>

<body>

    <header>

        <nav aria-label="Main site navigation">
            <ul>
                <li><a href="index.php" class="<?= $activePage === 'home' ? 'active' : '' ?>">Home</a></li>
                <li><a href="collection.php" class="<?= $activePage === 'collection' ? 'active' : '' ?>">Collection</a></li>
                <li><a href="provenance.php" class="<?= $activePage === 'provenance' ? 'active' : '' ?>">Provenance</a></li>
                <li><a href="contact.php" class="<?= $activePage === 'contact' ? 'active' : '' ?>">Contact</a></li>
                <li><a href="faq.php" class="<?= $activePage === 'faq' ? 'active' : '' ?>">FAQ</a></li>
                <li><a href="login.php" class="<?= $activePage === 'login' ? 'active' : '' ?>">Custodian Access</a></li>
            </ul>
        </nav>

    </header>

    <main>
        <?php if (!empty($flashMessages)): ?>
            <?php foreach ($flashMessages as $message): ?>
                <div class="flash-success">
                    <?= e($message) ?>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </main>
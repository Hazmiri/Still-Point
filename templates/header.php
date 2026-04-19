<?php
declare(strict_types=1);

if (!isset($pageTitle) || $pageTitle === '') {
    $pageTitle = 'Still Point';
}

if (!isset($activePage)) {
    $activePage = '';
}

$flashMessages = take_flash_messages();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= e($pageTitle) ?></title>
    <link rel="stylesheet" href="assets/style.css">
</head>
<body>

<a class="skip-link" href="#main-content">Skip to main content</a>

<header class="site-header">
    <div class="site-header-bar">
        <a class="site-brand" href="index.php">Still Point</a>

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
    </div>
</header>

<main id="main-content">
    <?php if (!empty($flashMessages)): ?>
        <?php foreach ($flashMessages as $flash): ?>
            <div class="flash-message flash-message--<?= e($flash['type']) ?>">
                <?= e($flash['message']) ?>
            </div>
        <?php endforeach; ?>
    <?php endif; ?>
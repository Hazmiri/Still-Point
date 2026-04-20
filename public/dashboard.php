<?php
declare(strict_types=1);

require_once __DIR__ . '/../src/bootstrap.php';

require_login();

$pageTitle = 'Custodian Console — Still Point';
$activePage = '';

$pdo = db();

$totalInstruments = (int) $pdo->query("SELECT COUNT(*) FROM instruments")->fetchColumn();

$latestInstrument = $pdo
    ->query("SELECT name, created_at FROM instruments ORDER BY created_at DESC LIMIT 1")
    ->fetch();

require_once __DIR__ . '/../templates/header.php';
?>

<section class="panel">
    <h1>Custodian Console</h1>

    <p class="lede">
        Welcome back<?= isset($_SESSION['username']) ? ', ' . e($_SESSION['username']) : '' ?>.
        Use this area to manage the protected side of the collection.
    </p>
</section>

<section class="dashboard-grid">
    <div class="stat-card">
        <span>Total instruments</span>
        <strong><?= $totalInstruments ?></strong>
    </div>

    <div class="stat-card">
        <span>Latest entry</span>
        <strong><?= $latestInstrument ? e($latestInstrument['name']) : 'None yet' ?></strong>
    </div>
</section>

<section class="panel">
    <h2>Actions</h2>

    <div class="action-row">
        <a class="button button--primary" href="add_instrument.php">Register Instrument</a>
        <a class="button button--secondary" href="collection.php">View Collection</a>
        <a class="button button--secondary" href="logout.php">Sign out</a>
    </div>
</section>

<?php require_once __DIR__ . '/../templates/footer.php'; ?>
<?php
declare(strict_types=1);

require_once __DIR__ . '/../src/bootstrap.php';

$pageTitle = 'Still Point';
$activePage = 'home';

$pdo = db();

$stmt = $pdo->query(
    "SELECT id, name, cue_type, material
     FROM instruments
     ORDER BY created_at DESC
     LIMIT 3"
);

$recentInstruments = $stmt->fetchAll();

require_once __DIR__ . '/../templates/header.php';
?>

<section class="panel">
    <h1>Still Point</h1>

    <p class="lede">
        Still Point is a focused digital catalogue of precision cue instruments.
        The collection is curated around control, balance, composition, and intended use.
    </p>

    <p>
        Rather than presenting a general sports shop, the site concentrates on a narrow
        and deliberate range of cue-based instruments so that each entry can be documented
        with care and precision.
    </p>

    <p>
        Visitors can explore the public collection, read instrument details, and understand
        the principles behind the archive. Authenticated custodians can add new instruments
        through the protected console.
    </p>
</section>

<section class="panel">
    <h2>Recent Instruments</h2>

    <?php if (empty($recentInstruments)): ?>
        <p>No instruments have been registered yet.</p>
    <?php else: ?>
        <ul class="compact-list">
            <?php foreach ($recentInstruments as $instrument): ?>
                <li>
                    <a href="instrument.php?id=<?= (int) $instrument['id'] ?>">
                        <?= e($instrument['name']) ?>
                    </a>
                    —
                    <?= e($instrument['cue_type']) ?> /
                    <?= e($instrument['material']) ?>
                </li>
            <?php endforeach; ?>
        </ul>
    <?php endif; ?>
</section>

<?php require_once __DIR__ . '/../templates/footer.php'; ?>
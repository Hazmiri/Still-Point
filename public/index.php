<?php
declare(strict_types=1);

/**
 * Load shared project setup.
 */
require_once __DIR__ . '/../src/bootstrap.php';

/**
 * Retrieve the three most recent instruments for display on the home page.
 */
$pdo = db();

$stmt = $pdo->query(
    "SELECT id, name, cue_type, material
     FROM instruments
     ORDER BY created_at DESC
     LIMIT 3"
);

$recentInstruments = $stmt->fetchAll();

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Still Point</title>
</head>
<body>

<h1>Still Point</h1>

<p>A curated collection of precision cue instruments.</p>

<p>
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

<h2>Recent Instruments</h2>

<?php if (empty($recentInstruments)): ?>
    <p>No instruments have been registered yet.</p>
<?php else: ?>
    <ul>
        <?php foreach ($recentInstruments as $instrument): ?>
            <li>
                <a href="instrument.php?id=<?= (int) $instrument['id'] ?>">
                    <?= htmlspecialchars($instrument['name'], ENT_QUOTES, 'UTF-8') ?>
                </a>
                —
                <?= htmlspecialchars($instrument['cue_type'], ENT_QUOTES, 'UTF-8') ?>
                /
                <?= htmlspecialchars($instrument['material'], ENT_QUOTES, 'UTF-8') ?>
            </li>
        <?php endforeach; ?>
    </ul>
<?php endif; ?>

</body>
</html>
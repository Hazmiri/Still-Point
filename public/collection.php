<?php
declare(strict_types=1);

require_once __DIR__ . '/../src/db.php';

$pdo = db();
$items = $pdo->query("SELECT * FROM instruments ORDER BY created_at DESC")->fetchAll();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Still Point — Collection</title>
</head>
<body>

<h1>The Collection</h1>

<?php if (empty($items)): ?>
    <p>No instruments registered yet.</p>
<?php else: ?>
    <ul>
        <?php foreach ($items as $item): ?>
            <li>
                <strong><?= htmlspecialchars($item['name'], ENT_QUOTES, 'UTF-8') ?></strong><br>
                Type: <?= htmlspecialchars($item['cue_type'], ENT_QUOTES, 'UTF-8') ?><br>
                Material: <?= htmlspecialchars($item['material'], ENT_QUOTES, 'UTF-8') ?><br>
                Length: <?= (int)$item['length_mm'] ?> mm<br>
                Weight: <?= (int)$item['weight_g'] ?> g<br>
                Tip: <?= htmlspecialchars($item['tip_mm'], ENT_QUOTES, 'UTF-8') ?> mm<br>
                <p><?= htmlspecialchars($item['description'], ENT_QUOTES, 'UTF-8') ?></p>
            </li>
            <hr>
        <?php endforeach; ?>
    </ul>
<?php endif; ?>

</body>
</html>
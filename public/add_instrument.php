<?php

declare(strict_types=1);

/**
 * Load shared project setup.
 */
require_once __DIR__ . '/../src/bootstrap.php';

/**
 * Validate input from URL.
 */
if (!isset($_GET['id'])) {
    die('Instrument ID not provided.');
}

$id = (int) $_GET['id'];

if ($id <= 0) {
    die('Invalid instrument ID.');
}

/**
 * Query database safely.
 */
$pdo = db();

$stmt = $pdo->prepare("SELECT * FROM instruments WHERE id = :id");
$stmt->execute(['id' => $id]);

$instrument = $stmt->fetch();

if (!$instrument) {
    die('Instrument not found.');
}

/**
 * Set dynamic page title.
 */
$pageTitle = $instrument['name'];

require_once __DIR__ . '/../templates/header.php';
?>

<h1>
    <?= htmlspecialchars($instrument['name'], ENT_QUOTES, 'UTF-8') ?>
</h1>

<?php if (!empty($instrument['image_path'])): ?>
    <p>
        <img
            src="<?= htmlspecialchars($instrument['image_path'], ENT_QUOTES, 'UTF-8') ?>"
            alt="<?= htmlspecialchars($instrument['name'], ENT_QUOTES, 'UTF-8') ?>"
            width="320">
    </p>
<?php endif; ?>

<p>
    <strong>Type:</strong>
    <?= htmlspecialchars($instrument['cue_type'], ENT_QUOTES, 'UTF-8') ?><br>

    <strong>Material:</strong>
    <?= htmlspecialchars($instrument['material'], ENT_QUOTES, 'UTF-8') ?><br>

    <strong>Length:</strong>
    <?= (int)$instrument['length_mm'] ?> mm<br>

    <strong>Weight:</strong>
    <?= (int)$instrument['weight_g'] ?> g<br>

    <strong>Tip:</strong>
    <?= htmlspecialchars((string) $instrument['tip_mm'], ENT_QUOTES, 'UTF-8') ?> mm
</p>

<p>
    <?= htmlspecialchars($instrument['description'], ENT_QUOTES, 'UTF-8') ?>
</p>

<p>
    <a href="collection.php">← Back to Collection</a>
</p>

<?php require_once __DIR__ . '/../templates/footer.php'; ?>
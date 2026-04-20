<?php
declare(strict_types=1);

require_once __DIR__ . '/../src/bootstrap.php';

if (!isset($_GET['id'])) {
    flash('Instrument ID not provided.', 'error');
    redirect('collection.php');
}

$id = (int) $_GET['id'];

if ($id <= 0) {
    flash('Invalid instrument ID.', 'error');
    redirect('collection.php');
}

$pdo = db();

$stmt = $pdo->prepare("SELECT * FROM instruments WHERE id = :id");
$stmt->execute(['id' => $id]);

$instrument = $stmt->fetch();

if (!$instrument) {
    flash('Instrument not found.', 'error');
    redirect('collection.php');
}

$pageTitle = $instrument['name'] . ' — Still Point';
$activePage = 'collection';

require_once __DIR__ . '/../templates/header.php';
?>

<section class="panel instrument-detail">
    <h1><?= e($instrument['name']) ?></h1>

    <?php if (!empty($instrument['image_path'])): ?>
        <div class="instrument-hero">
            <img
                src="<?= e($instrument['image_path']) ?>"
                alt="<?= e($instrument['name']) ?>"
                width="360"
            >
        </div>
    <?php endif; ?>

    <dl class="instrument-meta">
        <dt>Type</dt>
        <dd><?= e($instrument['cue_type']) ?></dd>

        <dt>Material</dt>
        <dd><?= e($instrument['material']) ?></dd>

        <dt>Length</dt>
        <dd><?= (int) $instrument['length_mm'] ?> mm</dd>

        <dt>Weight</dt>
        <dd><?= (int) $instrument['weight_g'] ?> g</dd>

        <dt>Tip</dt>
        <dd><?= e((string) $instrument['tip_mm']) ?> mm</dd>
    </dl>

    <p><?= e($instrument['description']) ?></p>

    <div class="action-row">
        <a class="button button--secondary" href="collection.php">Back to Collection</a>
    </div>
</section>

<?php require_once __DIR__ . '/../templates/footer.php'; ?>
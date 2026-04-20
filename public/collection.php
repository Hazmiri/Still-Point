<?php
declare(strict_types=1);

require_once __DIR__ . '/../src/bootstrap.php';

$pageTitle = 'Still Point — Collection';
$activePage = 'collection';

$pdo = db();

$items = $pdo
    ->query("SELECT * FROM instruments ORDER BY created_at DESC")
    ->fetchAll();

require_once __DIR__ . '/../templates/header.php';
?>

<section>
    <h1>The Collection</h1>

    <?php if (empty($items)): ?>
        <div class="panel">
            <p>No instruments have been registered yet.</p>
        </div>
    <?php else: ?>
        <ul class="collection-list">
            <?php foreach ($items as $item): ?>
                <li>
                    <article class="collection-card">
                        <div class="collection-media">
                            <?php if (!empty($item['image_path'])): ?>
                                <img
                                    src="<?= e($item['image_path']) ?>"
                                    alt="<?= e($item['name']) ?>"
                                    width="220"
                                >
                            <?php endif; ?>
                        </div>

                        <div class="collection-copy">
                            <h2 class="collection-title">
                                <a href="instrument.php?id=<?= (int) $item['id'] ?>">
                                    <?= e($item['name']) ?>
                                </a>
                            </h2>

                            <dl class="meta-list">
                                <dt>Type</dt>
                                <dd><?= e($item['cue_type']) ?></dd>

                                <dt>Material</dt>
                                <dd><?= e($item['material']) ?></dd>

                                <dt>Length</dt>
                                <dd><?= (int) $item['length_mm'] ?> mm</dd>

                                <dt>Weight</dt>
                                <dd><?= (int) $item['weight_g'] ?> g</dd>

                                <dt>Tip</dt>
                                <dd><?= e((string) $item['tip_mm']) ?> mm</dd>
                            </dl>

                            <p><?= e($item['description']) ?></p>

                            <p>
                                <a href="instrument.php?id=<?= (int) $item['id'] ?>">View full entry</a>
                            </p>
                        </div>
                    </article>
                </li>
            <?php endforeach; ?>
        </ul>
    <?php endif; ?>
</section>

<?php require_once __DIR__ . '/../templates/footer.php'; ?>
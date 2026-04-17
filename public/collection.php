<?php
declare(strict_types=1);

/**
 * Load shared project setup.
 */
require_once __DIR__ . '/../src/bootstrap.php';

/**
 * Set page title for shared header.
 */
$pageTitle = 'Still Point — Collection';

/**
 * Create database connection.
 */
$pdo = db();

/**
 * Retrieve all instruments, newest first.
 */
$items = $pdo
    ->query("SELECT * FROM instruments ORDER BY created_at DESC")
    ->fetchAll();

require_once __DIR__ . '/../templates/header.php';
?>

<h1>The Collection</h1>

<?php if (empty($items)): ?>
    <p>No instruments registered yet.</p>
<?php else: ?>
    <ul>
        <?php foreach ($items as $item): ?>
            <li>
                <article>
                    <strong>
                        <a href="instrument.php?id=<?= (int)$item['id'] ?>">
                            <?= htmlspecialchars($item['name'], ENT_QUOTES, 'UTF-8') ?>
                        </a>
                    </strong><br>

                    <?php if (!empty($item['image_path'])): ?>
                        <p>
                            <img
                                src="<?= htmlspecialchars($item['image_path'], ENT_QUOTES, 'UTF-8') ?>"
                                alt="<?= htmlspecialchars($item['name'], ENT_QUOTES, 'UTF-8') ?>"
                                width="220">
                        </p>
                    <?php endif; ?>

                    Type:
                    <?= htmlspecialchars($item['cue_type'], ENT_QUOTES, 'UTF-8') ?><br>

                    Material:
                    <?= htmlspecialchars($item['material'], ENT_QUOTES, 'UTF-8') ?><br>

                    Length:
                    <?= (int)$item['length_mm'] ?> mm<br>

                    Weight:
                    <?= (int)$item['weight_g'] ?> g<br>

                    Tip:
                    <?= htmlspecialchars((string) $item['tip_mm'], ENT_QUOTES, 'UTF-8') ?> mm<br>

                    <p>
                        <?= htmlspecialchars($item['description'], ENT_QUOTES, 'UTF-8') ?>
                    </p>
                </article>
            </li>

            <hr> 

        <?php endforeach; ?>
    </ul>
<?php endif; ?>

<?php require_once __DIR__ . '/../templates/footer.php'; ?>
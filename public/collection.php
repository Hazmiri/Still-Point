<?php

declare(strict_types=1);

/**
 * Load shared project setup.
 */
require_once __DIR__ . '/../src/bootstrap.php';

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
?>

$filters = [
'q' => trim((string) ($_GET['q'] ?? '')),
'cue_type' => trim((string) ($_GET['cue_type'] ?? '')),
'material' => trim((string) ($_GET['material'] ?? '')),
];

$types = instrument_types();

if ($filters['cue_type'] !== '' && !isset($types[$filters['cue_type']])) {
$filters['cue_type'] = '';
}

$materials = $pdo
->query('SELECT DISTINCT material FROM instruments ORDER BY material ASC')
->fetchAll(PDO::FETCH_COLUMN);

$sql = 'SELECT * FROM instruments WHERE 1 = 1';
$params = [];

if ($filters['q'] !== '') {
$sql .= ' AND (name LIKE :query OR material LIKE :query OR description LIKE :query)';
$params['query'] = '%' . $filters['q'] . '%';
}

if ($filters['cue_type'] !== '') {
$sql .= ' AND cue_type = :cue_type';
$params['cue_type'] = $filters['cue_type'];
}

if ($filters['material'] !== '') {
$sql .= ' AND material = :material';
$params['material'] = $filters['material'];
}

$sql .= ' ORDER BY created_at DESC';

$statement = $pdo->prepare($sql);
$statement->execute($params);
$items = $statement->fetchAll();

$pageTitle = 'Still Point | Collection';
$pageDescription = 'Browse cue sports equipment stored in the Still Point database.';
$activePage = 'collection';
$flashMessages = take_flash_messages();

require __DIR__ . '/../templates/header.php';
?>

<section class="stack">
    <header class="hero">
        <div>
            <span class="eyebrow">Database-driven collection</span>
            <h1>Shop a focused range of cue sports equipment.</h1>
            <p class="lede">Search the database by keyword, filter by cue type, and open each item for full details. The page updates from MySQL using PHP prepared statements.</p>
        </div>
        <aside class="hero-meta" aria-label="Collection summary">
            <article class="metric-card">
                <span>Items available</span>
                <strong><?= e((string) count($items)) ?></strong>
            </article>
            <article class="metric-card">
                <span>Materials listed</span>
                <strong><?= e((string) count($materials)) ?></strong>
            </article>
        </aside>
    </header>

    <section class="panel filter-panel" aria-labelledby="filter-heading">
        <h2 id="filter-heading" class="section-title">Search the collection</h2>
        <form method="get" class="form-grid">
            <div class="field">
                <label for="q">Keyword</label>
                <input
                    id="q"
                    name="q"
                    type="search"
                    value="<?= e($filters['q']) ?>"
                    placeholder="Search by name, material or description">
            </div>
            <div class="field">
                <label for="cue_type">Cue type</label>
                <select id="cue_type" name="cue_type">
                    <option value="">All cue types</option>
                    <?php foreach ($types as $value => $label): ?>
                        <option value="<?= e($value) ?>" <?= $filters['cue_type'] === $value ? 'selected' : '' ?>>
                            <?= e($label) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="field">
                <label for="material">Material</label>
                <select id="material" name="material">
                    <option value="">All materials</option>
                    <?php foreach ($materials as $material): ?>
                        <option value="<?= e((string) $material) ?>" <?= $filters['material'] === $material ? 'selected' : '' ?>>
                            <?= e((string) $material) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="field">
                <span class="field-hint">Filters are handled on the server with validated query parameters.</span>
                <div class="filter-actions">
                    <button class="button" type="submit">Apply filters</button>
                    <a class="button button--ghost" href="collection.php">Clear filters</a>
                </div>
            </div>
        </form>
    </section>

    <?php if ($items === []): ?>
        <section class="notice notice--error" aria-labelledby="empty-heading">
            <h2 id="empty-heading" class="notice-title">No matching cues were found.</h2>
            <p>Try broadening the filters or sign in to the member area and add a new cue to the database.</p>
        </section>
    <?php else: ?>
        <section class="collection-grid" aria-label="Collection results">
            <?php foreach ($items as $item): ?>
                <article class="collection-card">
                    <div class="card-media">
                        <?php if (!empty($item['image_path'])): ?>
                            <img src="<?= e(upload_url((string) $item['image_path'])) ?>" alt="<?= e($item['name']) ?>">
                        <?php else: ?>
                            <div class="placeholder-art" role="img" aria-label="No product image available yet">
                                Image added by members will appear here.
                            </div>
                        <?php endif; ?>
                    </div>

                    <div>
                        <span class="tag"><?= e(cue_type_label((string) $item['cue_type'])) ?></span>
                        <h2 class="card-title"><?= e($item['name']) ?></h2>
                        <p><?= e(excerpt((string) $item['description'])) ?></p>
                        <ul class="meta-list">
                            <li><strong>Material</strong><span><?= e($item['material']) ?></span></li>
                            <li><strong>Length</strong><span><?= e((string) $item['length_mm']) ?> mm</span></li>
                            <li><strong>Weight</strong><span><?= e((string) $item['weight_g']) ?> g</span></li>
                            <li><strong>Tip</strong><span><?= e((string) $item['tip_mm']) ?> mm</span></li>
                        </ul>
                        <div class="button-row">
                            <a class="button button--accent" href="instrument.php?id=<?= (int) $item['id'] ?>">View details</a>
                        </div>
                    </div>
                </article>
            <?php endforeach; ?>
        </section>
    <?php endif; ?>
</section>

<?php
require __DIR__ . '/../templates/footer.php';
return;
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Still Point — Collection</title>
</head>

<body>

    <!-- Main page title -->
    <h1>The Collection</h1>

    <?php if (empty($items)): ?>
        <!-- If there are no records in the database -->
        <p>No instruments registered yet.</p>

    <?php else: ?>
        <!-- If we have data, we display it -->
        <ul>

            <?php foreach ($items as $item): ?>
                <!-- Each $item represents one row from the database -->

                <li>
                    <!-- htmlspecialchars prevents XSS (security requirement) -->
                    <strong>
                        <a href="instrument.php?id=<?= (int)$item['id'] ?>">
                            <?= htmlspecialchars($item['name'], ENT_QUOTES, 'UTF-8') ?>
                        </a>
                    </strong><br>

                    Type:
                    <?= htmlspecialchars($item['cue_type'], ENT_QUOTES, 'UTF-8') ?><br>

                    Material:
                    <?= htmlspecialchars($item['material'], ENT_QUOTES, 'UTF-8') ?><br>

                    <!-- Casting to int ensures clean numeric output -->
                    Length:
                    <?= (int)$item['length_mm'] ?> mm<br>

                    Weight:
                    <?= (int)$item['weight_g'] ?> g<br>

                    Tip:
                    <?= htmlspecialchars($item['tip_mm'], ENT_QUOTES, 'UTF-8') ?> mm<br>

                    <p>
                        <?= htmlspecialchars($item['description'], ENT_QUOTES, 'UTF-8') ?>
                    </p>
                </li>

                <hr>

            <?php endforeach; ?>

        </ul>
    <?php endif; ?>

</body>

</html>
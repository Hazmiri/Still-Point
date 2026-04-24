<?php

declare(strict_types=1);

require_once __DIR__ . '/../src/bootstrap.php';

/**
 * Set page title and active navigation state.
 */
$pageTitle = 'Still Point — Collection';
$activePage = 'collection';

/**
 * Read filter values from the URL.
 * GET is appropriate here because the user is searching and filtering public content.
 */
$search = trim($_GET['search'] ?? '');
$cueType = trim($_GET['cue_type'] ?? '');
$material = trim($_GET['material'] ?? '');

/**
 * Create database connection.
 */
$pdo = db();

/**
 * Start with a base SQL query.
 * We will add conditions only when the user provides filter values.
 */
$sql = "SELECT * FROM instruments WHERE 1=1";
$params = [];

/**
 * If a search term is provided, filter by instrument name.
 */
if ($search !== '') {
    $sql .= " AND name LIKE :search";
    $params['search'] = '%' . $search . '%';
}

/**
 * If a cue type is selected, filter by cue type.
 */
if ($cueType !== '') {
    $sql .= " AND cue_type = :cue_type";
    $params['cue_type'] = $cueType;
}

/**
 * If a material is provided, filter by material.
 * LIKE is used here so partial matches are possible.
 */
if ($material !== '') {
    $sql .= " AND material LIKE :material";
    $params['material'] = '%' . $material . '%';
}

/**
 * Always show newest entries first.
 */
$sql .= " ORDER BY created_at DESC";

/**
 * Prepare and execute the query safely.
 */
$stmt = $pdo->prepare($sql);
$stmt->execute($params);

/**
 * Fetch filtered results.
 */
$items = $stmt->fetchAll();

require_once __DIR__ . '/../templates/header.php';
?>

<section>
    <h1>The Collection</h1>

    <p class="lede">
        The collection presents each instrument as a structured entry rather than a loose product listing.
        Visitors can browse by name, cue type and material, then open a full page for each item.
    </p>

    <p>
        This page is designed to support comparison. Instead of relying only on image and title,
        each entry also presents core metadata so that differences between instruments remain visible
        during browsing.
    </p>
</section>

<section class="panel form-shell">
    <h2>Search and filter</h2>

    <form method="GET" action="collection.php">
        <div class="field">
            <label for="search">Search by name</label>
            <input
                type="text"
                id="search"
                name="search"
                value="<?= e($search) ?>"
                placeholder="e.g. Ash Precision Cue">
        </div>

        <div class="field">
            <label for="cue_type">Cue type</label>
            <select id="cue_type" name="cue_type">
                <option value="">All types</option>
                <option value="playing" <?= $cueType === 'playing' ? 'selected' : '' ?>>Playing</option>
                <option value="break" <?= $cueType === 'break' ? 'selected' : '' ?>>Break</option>
                <option value="training" <?= $cueType === 'training' ? 'selected' : '' ?>>Training</option>
            </select>
        </div>

        <div class="field">
            <label for="material">Material</label>
            <input
                type="text"
                id="material"
                name="material"
                value="<?= e($material) ?>"
                placeholder="e.g. Ash, Ebony, Maple">
        </div>

        <div class="action-row">
            <button class="button button--primary" type="submit">Apply filters</button>
            <a class="button button--secondary" href="collection.php">Reset</a>
        </div>
    </form>
</section>

<section>
    <?php if (empty($items)): ?>
        <div class="panel">
            <p>No instruments matched your search.</p>
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
                                    width="220">
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
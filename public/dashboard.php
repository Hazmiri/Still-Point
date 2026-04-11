<?php

declare(strict_types=1);

require_once __DIR__ . '/../src/bootstrap.php';

require_login();

$pdo = db();

$stats = [
    'total' => (int) $pdo->query('SELECT COUNT(*) FROM instruments')->fetchColumn(),
    'playing' => 0,
    'break' => 0,
    'training' => 0,
];

$typeTotals = $pdo
    ->query('SELECT cue_type, COUNT(*) AS total FROM instruments GROUP BY cue_type')
    ->fetchAll();

foreach ($typeTotals as $row) {
    if (isset($stats[$row['cue_type']])) {
        $stats[$row['cue_type']] = (int) $row['total'];
    }
}

$recentItems = $pdo
    ->query('SELECT id, name, cue_type, material, created_at FROM instruments ORDER BY created_at DESC LIMIT 6')
    ->fetchAll();

$formState = take_form_state('instrument');
$errors = $formState['errors'];
$old = $formState['old'];

$pageTitle = 'Still Point | Member Area';
$pageDescription = 'Secure dashboard for adding new cue items to the database.';
$activePage = 'dashboard';
$flashMessages = take_flash_messages();

require __DIR__ . '/../templates/header.php';
?>

<section class="stack">
    <header class="hero">
        <div>
            <span class="eyebrow">Authenticated member area</span>
            <h1>Welcome back, <?= e($_SESSION['username']) ?>.</h1>
            <p class="lede">Use this protected dashboard to add new cues to the MySQL database. Uploads are validated on the server, stored outside the PHP pages, and linked back into the collection automatically.</p>
            <div class="button-row">
                <a class="button button--accent" href="#add-instrument">Add a new cue</a>
                <a class="button button--ghost" href="logout.php">Log out</a>
            </div>
        </div>
        <aside class="stats-strip" aria-label="Inventory totals">
            <article class="metric-card">
                <span>Total cues</span>
                <strong><?= e((string) $stats['total']) ?></strong>
            </article>
            <article class="metric-card">
                <span>Playing cues</span>
                <strong><?= e((string) $stats['playing']) ?></strong>
            </article>
            <article class="metric-card">
                <span>Break cues</span>
                <strong><?= e((string) $stats['break']) ?></strong>
            </article>
            <article class="metric-card">
                <span>Training cues</span>
                <strong><?= e((string) $stats['training']) ?></strong>
            </article>
        </aside>
    </header>

    <section class="dashboard-grid">
        <section id="add-instrument" class="panel form-panel" aria-labelledby="add-heading">
            <h2 id="add-heading" class="section-title">Add a new cue to the database</h2>
            <p class="form-copy">Every field is required so the public pages have enough information for accessibility, search, and usability.</p>

            <?php if ($errors !== []): ?>
                <div class="error-summary" role="alert">
                    <strong>Please correct the following before submitting:</strong>
                    <ul>
                        <?php foreach ($errors as $error): ?>
                            <li><?= e($error) ?></li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            <?php endif; ?>

            <form method="post" action="add_instrument.php" enctype="multipart/form-data" class="form-grid">
                <input type="hidden" name="csrf_token" value="<?= e(csrf_token()) ?>">

                <div class="field">
                    <label for="name">Cue name</label>
                    <input id="name" name="name" type="text" maxlength="120" required value="<?= e(old_value($old, 'name')) ?>">
                </div>

                <div class="field">
                    <label for="cue_type">Cue type</label>
                    <select id="cue_type" name="cue_type" required>
                        <option value="">Select a cue type</option>
                        <?php foreach (instrument_types() as $value => $label): ?>
                            <option value="<?= e($value) ?>" <?= old_value($old, 'cue_type') === $value ? 'selected' : '' ?>>
                                <?= e($label) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="field">
                    <label for="material">Material</label>
                    <input
                        id="material"
                        name="material"
                        type="text"
                        maxlength="80"
                        required
                        value="<?= e(old_value($old, 'material')) ?>"
                        placeholder="Ash, Maple, Carbon fibre"
                    >
                </div>

                <div class="field">
                    <label for="length_mm">Length in millimetres</label>
                    <input id="length_mm" name="length_mm" type="number" min="900" max="1600" required value="<?= e(old_value($old, 'length_mm')) ?>">
                </div>

                <div class="field">
                    <label for="weight_g">Weight in grams</label>
                    <input id="weight_g" name="weight_g" type="number" min="350" max="750" required value="<?= e(old_value($old, 'weight_g')) ?>">
                </div>

                <div class="field">
                    <label for="tip_mm">Tip size in millimetres</label>
                    <input id="tip_mm" name="tip_mm" type="number" step="0.1" min="8" max="15" required value="<?= e(old_value($old, 'tip_mm')) ?>">
                </div>

                <div class="field field--full">
                    <label for="description">Description</label>
                    <textarea id="description" name="description" maxlength="1200" required data-char-count><?= e(old_value($old, 'description')) ?></textarea>
                    <span class="field-hint">Write at least 40 characters describing who the cue suits and why. <span data-char-output="description">0 characters</span></span>
                </div>

                <div class="field field--full">
                    <label for="image">Product image</label>
                    <input
                        id="image"
                        name="image"
                        type="file"
                        accept=".jpg,.jpeg,.png,.webp,image/jpeg,image/png,image/webp"
                        required
                        data-image-input
                    >
                    <span class="field-hint">Accepted formats: JPEG, PNG or WebP. Maximum file size: 2MB.</span>
                </div>

                <div class="field field--full">
                    <figure class="upload-preview">
                        <img data-preview-image hidden alt="Selected upload preview">
                        <figcaption class="caption" data-preview-caption>Upload a JPEG, PNG or WebP image up to 2MB.</figcaption>
                    </figure>
                </div>

                <div class="field field--full">
                    <button class="button button--accent" type="submit">Save cue to collection</button>
                </div>
            </form>
        </section>

        <section class="stack" aria-labelledby="recent-heading">
            <section class="panel">
                <h2 id="recent-heading" class="section-title">Recent additions</h2>
                <p class="form-copy">New items appear on the public collection page immediately after a successful insert.</p>
                <div class="table-shell">
                    <table>
                        <caption class="caption">Latest cues stored in the Still Point database.</caption>
                        <thead>
                        <tr>
                            <th scope="col">Name</th>
                            <th scope="col">Type</th>
                            <th scope="col">Material</th>
                            <th scope="col">Added</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php foreach ($recentItems as $item): ?>
                            <tr>
                                <td><a href="instrument.php?id=<?= (int) $item['id'] ?>"><?= e($item['name']) ?></a></td>
                                <td><?= e(cue_type_label((string) $item['cue_type'])) ?></td>
                                <td><?= e($item['material']) ?></td>
                                <td><?= e(date('d M Y', strtotime((string) $item['created_at']))) ?></td>
                            </tr>
                        <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </section>

            <section class="panel">
                <h2 class="section-title">Security checklist</h2>
                <ul class="plain-list">
                    <li>Passwords are checked with <code>password_verify()</code>.</li>
                    <li>Prepared statements protect database queries from SQL injection.</li>
                    <li>Output is escaped with <code>htmlspecialchars()</code> to reduce XSS risk.</li>
                    <li>Uploads are MIME-checked and the uploads folder blocks PHP execution.</li>
                    <li>State-changing forms use CSRF tokens.</li>
                </ul>
            </section>
        </section>
    </section>
</section>

<?php require __DIR__ . '/../templates/footer.php'; ?>

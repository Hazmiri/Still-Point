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
        It was designed as a controlled archive rather than a broad sports shop,
        so that each entry could be recorded with clarity, consistency and purpose.
    </p>

    <p>
        The site brings together public browsing and protected content management.
        A visitor can move through the collection, open an individual instrument page,
        and read supporting pages that explain the logic of the archive. A member can
        sign in separately and register new entries through the protected dashboard.
    </p>

    <p>
        The project is deliberately narrow. Instead of trying to display every possible
        sporting item, it concentrates on a specific class of instruments so that the
        relationship between data, usability and structure can be seen more clearly.
    </p>
</section>

<section class="panel">
    <h2>What the archive contains</h2>

    <p>
        Each instrument is recorded through a structured set of attributes rather than
        loose description alone. Entries may include cue type, material, dimensional
        properties, an uploaded image, and a short account of the instrument’s intended use.
    </p>

    <p>
        This makes the collection easier to browse because the user is not forced to rely
        on scattered details or inconsistent wording from one entry to another.
    </p>
</section>

<section class="panel">
    <h2>How to use the site</h2>

    <p>
        A visitor can begin with the collection page, open a full instrument entry,
        and then use the provenance, FAQ and contact pages to understand the wider context
        of the archive. The protected member area is separated from the public route so that
        browsing and content management remain clearly distinct actions.
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
<?php

declare(strict_types=1);

require_once __DIR__ . '/../src/bootstrap.php';

$pageTitle = 'Still Point — Provenance';
$activePage = 'provenance';

require_once __DIR__ . '/../templates/header.php';
?>

<section class="panel">
    <h1>Provenance</h1>

    <p class="lede">
        Still Point was created as a focused archive of precision cue instruments.
        The purpose of the collection is not breadth, but disciplined selection.
    </p>

    <p>
        Each instrument is recorded as a distinct entry with attributes that affect
        control, balance, and intended use. This allows visitors to compare items in a
        structured way rather than browsing an unfocused general catalogue.
    </p>

    <p>
        The archive gives attention to material composition, dimensional properties,
        and functional classification. By limiting the collection to a specific range,
        the site remains readable, purposeful, and easier to maintain.
    </p>
</section>

<section class="panel">
    <h2>Selection Principles</h2>

    <ul>
        <li>Only cue instruments within the defined collection scope are included.</li>
        <li>Each entry must have a clear functional type, such as playing, break, or training.</li>
        <li>Material and dimensional data must be recorded in a structured form.</li>
        <li>Descriptions should explain the instrument’s intended use and handling qualities.</li>
    </ul>

    <h2>Why the Collection Is Narrow</h2>

    <p>
        A narrow collection improves consistency, usability, and data quality.
        It also reflects the project’s aim of creating a database-driven system
        that is specific enough to be managed carefully and evaluated critically.
    </p>
</section>

<section class="panel">
    <h2>Why material and measurement matter</h2>

    <p>
        Material and dimension are not minor details in this collection. They affect handling, balance,
        feedback, and the way an instrument is understood by the user. For that reason, the archive does
        not treat description as enough on its own. Structured data is part of the value of the record.
    </p>

    <p>
        This was important to me while building the project because it changed the website from a page of
        text into a system of organised entries that could be compared and evaluated more carefully.
    </p>
</section>

<?php require_once __DIR__ . '/../templates/footer.php'; ?>
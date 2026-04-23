<?php

declare(strict_types=1);

require_once __DIR__ . '/../src/bootstrap.php';

$pageTitle = 'Still Point — FAQ';
$activePage = 'faq';

require_once __DIR__ . '/../templates/header.php';
?>

<section class="panel">
    <h1>Frequently Asked Questions</h1>

    <h2>What is Still Point?</h2>
    <p>
        Still Point is a focused digital catalogue of precision cue instruments.
        It is designed to present a narrow and well-defined collection rather than a general sports shop.
    </p>

    <h2>Can visitors add new instruments?</h2>
    <p>
        No. Public visitors can browse the collection, read item details, and submit enquiries.
        Only authenticated custodians can register new instruments through the protected console.
    </p>

    <h2>Why is the collection limited?</h2>
    <p>
        The collection is intentionally narrow so that each entry can be described consistently
        and managed with greater clarity, accuracy, and usability.
    </p>

    <h2>How do I view more detail about an instrument?</h2>
    <p>
        Select an instrument from the public collection page.
        Each listed item links to a dedicated detail page containing its recorded attributes.
    </p>

    <h2>What information is recorded for each instrument?</h2>
    <p>
        Entries may include name, cue type, material, dimensional properties, descriptive notes,
        and where available, an uploaded image.
    </p>

    <h2>How can I make an enquiry?</h2>
    <p>
        Use the contact page and provide a clear subject and message.
        Identifying the relevant instrument helps reduce ambiguity and supports a better response.
    </p>

    <h2>Why are only certain cue types included?</h2>
    <p>
        The collection is intentionally controlled so that each record can be structured consistently and managed
        with greater clarity. This improves both usability and the reliability of the stored data.
    </p>

    <h2>Are the measurements standardised?</h2>
    <p>
        Measurements are entered in a structured format so that entries remain comparable. This helps reduce
        ambiguity and makes the database more useful than a purely descriptive page.
    </p>

    <h2>Why is member access protected?</h2>
    <p>
        The public side of the site is designed for browsing and enquiry, while the protected side is reserved
        for authenticated content management. This separation reduces confusion and supports trust.
    </p>
</section>

<?php require_once __DIR__ . '/../templates/footer.php'; ?>
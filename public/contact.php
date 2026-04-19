<?php

declare(strict_types=1);

/**
 * Load shared project setup.
 */
require_once __DIR__ . '/../src/bootstrap.php';

/**
 * Set page title and active navigation state.
 */
$pageTitle = 'Still Point — Contact';
$activePage = 'contact';

/**
 * Prepare simple default values.
 * These allow the form to keep user input if the page is reloaded later.
 */
$old = [
    'name' => '',
    'email' => '',
    'subject' => '',
    'message' => ''
];

/**
 * Load shared header.
 */
require_once __DIR__ . '/../templates/header.php';
?>

<section>
    <h1 id="contact-heading">Contact</h1>

    <p>
        Visitors may use this page to send an enquiry about an instrument,
        ask for clarification about the collection, or request further detail
        about a listed entry.
    </p>

    <p>
        The contact process is designed to remain simple and readable,
        with clear field labels and restrained input requirements.
    </p>
</section>

<section aria-labelledby="contact-form-heading">
    <h2 id="contact-form-heading">Send an Enquiry</h2>

    <form method="POST" action="contact_process.php" aria-labelledby="contact-heading">
        <div class="field">
            <label for="name">Your name:</label>
            <input
                type="text"
                id="name"
                name="name"
                required
                value="<?= htmlspecialchars($old['name'], ENT_QUOTES, 'UTF-8') ?>">
        </div>

        <div class="field">
            <label for="email">Email address:</label>
            <input
                type="email"
                id="email"
                name="email"
                required
                value="<?= htmlspecialchars($old['email'], ENT_QUOTES, 'UTF-8') ?>">
        </div>

        <div class="field">
            <label for="subject">Subject:</label>
            <input
                type="text"
                id="subject"
                name="subject"
                required
                value="<?= htmlspecialchars($old['subject'], ENT_QUOTES, 'UTF-8') ?>">
        </div>

        <div class="field">
            <label for="message">Message:</label>
            <textarea
                id="message"
                name="message"
                rows="8"
                required><?= htmlspecialchars($old['message'], ENT_QUOTES, 'UTF-8') ?></textarea>
        </div>

        <button class="button button--primary" type="submit">Send enquiry</button>
    </form>
</section>

<section>
    <h2>Response Guidance</h2>

    <p>
        Enquiries should identify the instrument clearly where possible.
        This helps reduce ambiguity and supports a more useful response.
    </p>

    <p>
        The form is intentionally limited to essential fields in order to reduce
        friction and support straightforward completion.
    </p>
</section>

<?php require_once __DIR__ . '/../templates/footer.php'; ?>
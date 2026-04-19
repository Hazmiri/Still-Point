<?php

declare(strict_types=1);

require_once __DIR__ . '/../src/bootstrap.php';

$pageTitle = 'Still Point — Contact';

require_once __DIR__ . '/../templates/header.php';
?>

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

<form method="POST" action="contact_process.php" aria-labelledby="contact-heading">
    <label for="name">Your name:</label><br>
    <input type="text" id="name" name="name" required><br><br>

    <label for="email">Email address:</label><br>
    <input type="email" id="email" name="email" required><br><br>

    <label for="subject">Subject:</label><br>
    <input type="text" id="subject" name="subject" required><br><br>

    <label for="message">Message:</label><br>
    <textarea id="message" name="message" rows="8" cols="50" required></textarea><br><br>

    <button class="button button--primary" type="submit">Send enquiry</button>
</form>

<h2>Response Guidance</h2>

<p>
    Enquiries should identify the instrument clearly where possible.
    This helps reduce ambiguity and supports a more useful response.
</p>

<p>
    The form is intentionally limited to essential fields in order to reduce
    friction and support straightforward completion.
</p>

<?php require_once __DIR__ . '/../templates/footer.php'; ?>
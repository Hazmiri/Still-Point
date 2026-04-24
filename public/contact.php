<?php

declare(strict_types=1);

require_once __DIR__ . '/../src/bootstrap.php';

$formState = take_form_state('contact');
$errors = $formState['errors'];
$old = $formState['old'];

$pageTitle = 'Still Point — Contact';
$activePage = 'contact';

require_once __DIR__ . '/../templates/header.php';
?>

<section class="panel">
    <h1 id="contact-heading">Contact</h1>

    <p class="lede">
        Visitors may use this page to send an enquiry about an instrument,
        request clarification about a listing, or ask for further detail
        about the purpose of the collection.
    </p>

    <p>
        The contact route is intentionally simple. The aim is to reduce friction,
        keep the form readable, and make it clear what information is actually needed.
    </p>
</section>

<section class="panel form-shell" aria-labelledby="contact-form-heading">
    <h2 id="contact-form-heading">Send an enquiry</h2>

    <!-- keep your form here exactly as it is -->
</section>

<?php if ($errors !== []): ?>
    <div class="error-summary" role="alert">
        <strong>Please correct the following:</strong>
        <ul>
            <?php foreach ($errors as $error): ?>
                <li><?= e($error) ?></li>
            <?php endforeach; ?>
        </ul>
    </div>
<?php endif; ?>

<form method="POST" action="contact_process.php" aria-labelledby="contact-heading">
    <input type="hidden" name="csrf_token" value="<?= e(csrf_token()) ?>">

    <div class="field">
        <label for="name">Your name</label>
        <input type="text" id="name" name="name" required value="<?= e(old_value($old, 'name')) ?>">
    </div>

    <div class="field">
        <label for="email">Email address</label>
        <input type="email" id="email" name="email" required value="<?= e(old_value($old, 'email')) ?>">
    </div>

    <div class="field">
        <label for="subject">Subject</label>
        <input type="text" id="subject" name="subject" required value="<?= e(old_value($old, 'subject')) ?>">
    </div>

    <div class="field">
        <label for="message">Message</label>
        <textarea id="message" name="message" rows="8" required><?= e(old_value($old, 'message')) ?></textarea>
    </div>

    <div class="action-row">
        <button class="button button--primary" type="submit">Send enquiry</button>
    </div>
</form>
</section>

<section class="panel">
    <h2>Response guidance</h2>

    <p>
        Useful enquiries usually identify the instrument name, the part of the listing being
        questioned, and whether the request relates to dimensions, material, or general clarification.
        This helps the response remain specific and efficient.
    </p>

    <p>
        The form is intentionally limited to essential fields only. That decision was made to support
        straightforward completion and reduce unnecessary effort for the user.
    </p>
</section>

<?php require_once __DIR__ . '/../templates/footer.php'; ?>
<?php
declare(strict_types=1);

/**
 * Load shared setup.
 */
require_once __DIR__ . '/../src/bootstrap.php';

/**
 * Only allow POST requests.
 */
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    die('Invalid request method.');
}

/**
 * Required fields.
 */
$requiredFields = ['name', 'email', 'subject', 'message'];

foreach ($requiredFields as $field) {
    if (!isset($_POST[$field])) {
        die('Missing form field.');
    }
}

/**
 * Clean input.
 */
$name = trim($_POST['name']);
$email = trim($_POST['email']);
$subject = trim($_POST['subject']);
$message = trim($_POST['message']);

/**
 * Validate empty fields.
 */
if ($name === '' || $email === '' || $subject === '' || $message === '') {
    die('All fields are required.');
}

/**
 * Validate email format.
 */
if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    die('Invalid email address.');
}

/**
 * OPTIONAL — store message in database
 * For now, we simulate handling.
 */

/**
 * Create success message (flash).
 */
$_SESSION['flash_messages'][] = 'Your enquiry has been sent successfully.';

/**
 * Redirect back to contact page.
 */
header('Location: contact.php');
exit;
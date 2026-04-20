<?php
declare(strict_types=1);

require_once __DIR__ . '/../src/bootstrap.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    flash('Invalid enquiry request.', 'error');
    redirect('contact.php');
}

if (!verify_csrf($_POST['csrf_token'] ?? null)) {
    flash('Your session token was invalid. Please try again.', 'error');
    redirect('contact.php');
}

$name = trim($_POST['name'] ?? '');
$email = trim($_POST['email'] ?? '');
$subject = trim($_POST['subject'] ?? '');
$message = trim($_POST['message'] ?? '');

$old = [
    'name' => $name,
    'email' => $email,
    'subject' => $subject,
    'message' => $message,
];

$errors = [];

if ($name === '' || $email === '' || $subject === '' || $message === '') {
    $errors[] = 'All fields are required.';
}

if ($email !== '' && !filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $errors[] = 'Please provide a valid email address.';
}

if ($errors !== []) {
    store_form_state('contact', $errors, $old);
    redirect('contact.php');
}

/**
 * In this project version, successful handling is simulated.
 * The user still receives a complete validation and feedback flow.
 */
flash('Your enquiry has been sent successfully.');
redirect('contact.php');
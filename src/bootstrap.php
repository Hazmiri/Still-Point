<?php
declare(strict_types=1);

/**
 * Shared project bootstrap.
 * Starts the session, loads the database helper,
 * and provides small reusable functions.
 */

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once __DIR__ . '/db.php';

/**
 * Escape output safely for HTML.
 */
function e(mixed $value): string
{
    return htmlspecialchars((string) $value, ENT_QUOTES, 'UTF-8');
}

/**
 * Redirect and stop execution.
 */
function redirect(string $location): never
{
    header('Location: ' . $location);
    exit;
}

/**
 * Store a flash message for the next request.
 */
function flash(string $message, string $type = 'success'): void
{
    $_SESSION['flash_messages'][] = [
        'type' => $type,
        'message' => $message,
    ];
}

/**
 * Retrieve and clear flash messages.
 */
function take_flash_messages(): array
{
    $messages = $_SESSION['flash_messages'] ?? [];
    unset($_SESSION['flash_messages']);

    return is_array($messages) ? $messages : [];
}

/**
 * Store form errors and old values temporarily.
 */
function store_form_state(string $formKey, array $errors, array $old = []): void
{
    $_SESSION['form_state'][$formKey] = [
        'errors' => $errors,
        'old' => $old,
    ];
}

/**
 * Retrieve and clear stored form state.
 */
function take_form_state(string $formKey): array
{
    $state = $_SESSION['form_state'][$formKey] ?? [
        'errors' => [],
        'old' => [],
    ];

    unset($_SESSION['form_state'][$formKey]);

    return $state;
}

/**
 * Safely retrieve a previous form value.
 */
function old_value(array $old, string $key, string $default = ''): string
{
    $value = $old[$key] ?? $default;
    return is_scalar($value) ? (string) $value : $default;
}

/**
 * Check whether a user is authenticated.
 */
function is_logged_in(): bool
{
    return isset($_SESSION['user_id']) && is_numeric($_SESSION['user_id']);
}

/**
 * Require authentication.
 */
function require_login(): void
{
    if (!is_logged_in()) {
        flash('Please sign in to continue.', 'error');
        redirect('login.php');
    }
}

/**
 * Generate or retrieve a CSRF token.
 */
function csrf_token(): string
{
    if (
        !isset($_SESSION['csrf_token']) ||
        !is_string($_SESSION['csrf_token']) ||
        $_SESSION['csrf_token'] === ''
    ) {
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
    }

    return $_SESSION['csrf_token'];
}

/**
 * Verify a CSRF token.
 */
function verify_csrf(?string $token): bool
{
    return is_string($token)
        && isset($_SESSION['csrf_token'])
        && is_string($_SESSION['csrf_token'])
        && hash_equals($_SESSION['csrf_token'], $token);
}
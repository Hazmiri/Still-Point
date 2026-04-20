<?php
declare(strict_types=1);

require_once __DIR__ . '/../src/bootstrap.php';

if (is_logged_in()) {
    redirect('dashboard.php');
}

$formState = take_form_state('login');
$errors = $formState['errors'];
$old = $formState['old'];

$pageTitle = 'Custodian Access — Still Point';
$activePage = 'login';

require_once __DIR__ . '/../templates/header.php';
?>

<section class="panel auth-shell">
    <h1>Custodian Access</h1>

    <p class="lede">
        Sign in to manage the protected member area and register new instruments.
    </p>

    <?php if ($errors !== []): ?>
        <div class="error-summary" role="alert">
            <strong>We could not sign you in:</strong>
            <ul>
                <?php foreach ($errors as $error): ?>
                    <li><?= e($error) ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
    <?php endif; ?>

    <form method="POST" action="login_process.php">
        <input type="hidden" name="csrf_token" value="<?= e(csrf_token()) ?>">

        <div class="field">
            <label for="username">Username</label>
            <input
                id="username"
                name="username"
                type="text"
                autocomplete="username"
                required
                value="<?= e(old_value($old, 'username')) ?>"
            >
        </div>

        <div class="field">
            <label for="password">Password</label>
            <input
                id="password"
                name="password"
                type="password"
                autocomplete="current-password"
                required
            >
        </div>

        <div class="action-row">
            <button class="button button--primary" type="submit">Sign in</button>
        </div>
    </form>
</section>

<?php require_once __DIR__ . '/../templates/footer.php'; ?>
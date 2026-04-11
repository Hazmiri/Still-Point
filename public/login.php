<?php

declare(strict_types=1);

require_once __DIR__ . '/../src/bootstrap.php';

if (is_logged_in()) {
    redirect('dashboard.php');
}

$formState = take_form_state('login');
$errors = $formState['errors'];
$old = $formState['old'];

$pageTitle = 'Still Point | Member Log In';
$pageDescription = 'Sign in to the protected member area and manage cue items.';
$activePage = 'login';
$flashMessages = take_flash_messages();

require __DIR__ . '/../templates/header.php';
?>

<section class="stack">
    <header class="panel">
        <span class="eyebrow">Protected route</span>
        <h1 class="page-title">Member log in</h1>
        <p class="lede">The public website is available to everyone, but only authorised members can add new cues to the database. This login uses password hashing and a CSRF token for protection.</p>
    </header>

    <section class="content-grid">
        <section class="panel form-panel" aria-labelledby="login-heading">
            <h2 id="login-heading" class="section-title">Enter your credentials</h2>

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

            <form method="post" action="login_process.php" class="form-grid">
                <input type="hidden" name="csrf_token" value="<?= e(csrf_token()) ?>">

                <div class="field field--full">
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

                <div class="field field--full">
                    <label for="password">Password</label>
                    <input id="password" name="password" type="password" autocomplete="current-password" required>
                </div>

                <div class="field field--full">
                    <button class="button button--accent" type="submit">Sign in</button>
                </div>
            </form>
        </section>

        <section class="panel" aria-labelledby="login-demo-heading">
            <h2 id="login-demo-heading" class="section-title">Demo credentials</h2>
            <p>Seeded credentials are included in the SQL script so the member area can be tested immediately after importing the database.</p>
            <ul class="plain-list">
                <li>Username: <code>custodian</code></li>
                <li>Password: <code>stillpoint-admin</code></li>
            </ul>
            <p class="caption">For a real deployment you would move these credentials out of documentation and create users manually.</p>
        </section>
    </section>
</section>

<?php require __DIR__ . '/../templates/footer.php'; ?>

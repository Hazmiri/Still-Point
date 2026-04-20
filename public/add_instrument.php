<?php
declare(strict_types=1);

require_once __DIR__ . '/../src/bootstrap.php';

require_login();

$formState = take_form_state('instrument');
$errors = $formState['errors'];
$old = $formState['old'];

$pageTitle = 'Register Instrument — Still Point';
$activePage = '';

require_once __DIR__ . '/../templates/header.php';
?>

<section class="panel form-shell">
    <h1>Register Instrument</h1>

    <p class="lede">
        Use this form to add a new cue instrument to the collection.
        All values should be realistic and within the expected range.
    </p>

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

    <form method="POST" action="add_instrument_process.php" enctype="multipart/form-data">
        <input type="hidden" name="csrf_token" value="<?= e(csrf_token()) ?>">

        <div class="field">
            <label for="name">Instrument name</label>
            <input type="text" id="name" name="name" required value="<?= e(old_value($old, 'name')) ?>">
        </div>

        <div class="field">
            <label for="cue_type">Cue type</label>
            <select id="cue_type" name="cue_type" required>
                <option value="">Select a type</option>
                <option value="playing" <?= old_value($old, 'cue_type') === 'playing' ? 'selected' : '' ?>>Playing</option>
                <option value="break" <?= old_value($old, 'cue_type') === 'break' ? 'selected' : '' ?>>Break</option>
                <option value="training" <?= old_value($old, 'cue_type') === 'training' ? 'selected' : '' ?>>Training</option>
            </select>
        </div>

        <div class="field">
            <label for="material">Material</label>
            <input type="text" id="material" name="material" required value="<?= e(old_value($old, 'material')) ?>">
        </div>

        <div class="field">
            <label for="length_mm">Length (mm)</label>
            <input type="number" id="length_mm" name="length_mm" min="900" max="1700" required value="<?= e(old_value($old, 'length_mm')) ?>">
            <small class="form-help">Enter a value between 900 mm and 1700 mm.</small>
        </div>

        <div class="field">
            <label for="weight_g">Weight (g)</label>
            <input type="number" id="weight_g" name="weight_g" min="300" max="800" required value="<?= e(old_value($old, 'weight_g')) ?>">
            <small class="form-help">Enter a value between 300 g and 800 g.</small>
        </div>

        <div class="field">
            <label for="tip_mm">Tip size (mm)</label>
            <input type="number" id="tip_mm" name="tip_mm" min="7.0" max="15.0" step="0.1" required value="<?= e(old_value($old, 'tip_mm')) ?>">
            <small class="form-help">Enter a value between 7.0 mm and 15.0 mm.</small>
        </div>

        <div class="field">
            <label for="image">Instrument image</label>
            <input type="file" id="image" name="image" accept=".jpg,.jpeg,.png,.webp" required>
            <small class="form-help">Accepted formats: JPG, PNG, WEBP. Maximum size: 2 MB.</small>
        </div>

        <div class="field">
            <label for="description">Description</label>
            <textarea id="description" name="description" rows="6" required><?= e(old_value($old, 'description')) ?></textarea>
        </div>

        <div class="action-row">
            <button class="button button--primary" type="submit">Save Instrument</button>
            <a class="button button--secondary" href="dashboard.php">Back to Dashboard</a>
        </div>
    </form>
</section>

<?php require_once __DIR__ . '/../templates/footer.php'; ?>
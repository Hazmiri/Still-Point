<?php
declare(strict_types=1);

/**
 * Load shared project setup.
 */
require_once __DIR__ . '/../src/bootstrap.php';

/**
 * Only authenticated users may register instruments.
 */
if (!isset($_SESSION['user_id'])) {
    die('Access denied.');
}

/**
 * Set page title for shared header.
 */
$pageTitle = 'Still Point — Register Instrument';

require_once __DIR__ . '/../templates/header.php';
?>

<h1>Register Instrument</h1>

<p>
    Use this form to add a new cue instrument to the collection.
    All values should be realistic and within the expected range.
</p>

<form method="POST" action="add_instrument_process.php" enctype="multipart/form-data">

    <label for="name">Instrument name:</label><br>
    <input type="text" id="name" name="name" required><br><br>

    <label for="cue_type">Cue type:</label><br>
    <select id="cue_type" name="cue_type" required>
        <option value="">Select a type</option>
        <option value="playing">Playing</option>
        <option value="break">Break</option>
        <option value="training">Training</option>
    </select><br><br>

    <label for="material">Material:</label><br>
    <input type="text" id="material" name="material" required><br><br>

    <label for="length_mm">Length (mm):</label><br>
    <input
        type="number"
        id="length_mm"
        name="length_mm"
        min="900"
        max="1700"
        required
    ><br><br>

    <label for="weight_g">Weight (g):</label><br>
    <input
        type="number"
        id="weight_g"
        name="weight_g"
        min="300"
        max="800"
        required
    ><br><br>

    <label for="tip_mm">Tip size (mm):</label><br>
    <input
        type="number"
        id="tip_mm"
        name="tip_mm"
        min="7.0"
        max="15.0"
        step="0.1"
        required
    ><br><br>

    <label for="image">Instrument image:</label><br>
    <input
        type="file"
        id="image"
        name="image"
        accept=".jpg,.jpeg,.png,.webp"
        required
    ><br><br>

    <label for="description">Description:</label><br>
    <textarea id="description" name="description" rows="6" cols="50" required></textarea><br><br>

    <button class="button button--primary" type="submit">Save Instrument</button>
</form>

<p>
    <a href="dashboard.php">← Back to Dashboard</a>
</p>

<?php require_once __DIR__ . '/../templates/footer.php'; ?>
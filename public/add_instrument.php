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
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Register Instrument</title>
</head>

<body>

    <h1>Register Instrument</h1>

    <form method="POST" action="add_instrument_process.php" enctype="multipart/form-data">

        <label for="name">Instrument name:</label><br>
        <input type="file" id="image" name="image" accept=".jpg,.jpeg, .png, .webp" required><br><br>

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
        <input type="number" id="length_mm" name="length_mm" min="1" required><br><br>

        <label for="weight_g">Weight (g):</label><br>
        <input type="number" id="weight_g" name="weight_g" min="1" required><br><br>

        <label for="tip_mm">Tip size (mm):</label><br>
        <input type="number" id="tip_mm" name="tip_mm" min="0.1" step="0.1" required><br><br>

        <label for="description">Description:</label><br>
        <textarea id="description" name="description" rows="6" cols="50" required></textarea><br><br>

        <button type="submit">Save Instrument</button>
    </form>

    <p>
        <a href="dashboard.php">← Back to Dashboard</a>
    </p>
</body>

</html>
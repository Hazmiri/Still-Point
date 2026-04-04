<?php
declare(strict_types=1); 
// Enforces strict typing (more predictable behaviour in PHP 8+)

/**
 * Load the database connection function
 * This gives us access to db() which returns a PDO connection
 */
require_once __DIR__ . '/../src/db.php';

/**
 * Get a connection to the database
 */
$pdo = db();

/**
 * Execute a SQL query to retrieve all instruments
 * ORDER BY ensures newest items appear first
 */
$items = $pdo
    ->query("SELECT * FROM instruments ORDER BY created_at DESC")
    ->fetchAll(); // fetch all results as an array
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Still Point — Collection</title>
</head>
<body>

<!-- Main page title -->
<h1>The Collection</h1>

<?php if (empty($items)): ?>
    <!-- If there are no records in the database -->
    <p>No instruments registered yet.</p>

<?php else: ?>
    <!-- If we have data, we display it -->
    <ul>

        <?php foreach ($items as $item): ?>
            <!-- Each $item represents one row from the database -->

            <li>
                <!-- htmlspecialchars prevents XSS (security requirement) -->
                <strong>
                    <?= htmlspecialchars($item['name'], ENT_QUOTES, 'UTF-8') ?>
                </strong><br>

                Type:
                <?= htmlspecialchars($item['cue_type'], ENT_QUOTES, 'UTF-8') ?><br>

                Material:
                <?= htmlspecialchars($item['material'], ENT_QUOTES, 'UTF-8') ?><br>

                <!-- Casting to int ensures clean numeric output -->
                Length:
                <?= (int)$item['length_mm'] ?> mm<br>

                Weight:
                <?= (int)$item['weight_g'] ?> g<br>

                Tip:
                <?= htmlspecialchars($item['tip_mm'], ENT_QUOTES, 'UTF-8') ?> mm<br>

                <p>
                    <?= htmlspecialchars($item['description'], ENT_QUOTES, 'UTF-8') ?>
                </p>
            </li>

            <hr>

        <?php endforeach; ?>

    </ul>
<?php endif; ?>

</body>
</html>
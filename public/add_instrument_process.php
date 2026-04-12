<?php
declare(strict_types=1);

/**
 * Start session because this is a protected action.
 */
session_start();

/**
 * Only logged-in users can add instruments.
 */
if (!isset($_SESSION['user_id'])) {
    die('Access denied.');
}

/**
 * Check that all required POST fields exist.
 */
$requiredFields = [
    'name',
    'cue_type',
    'material',
    'length_mm',
    'weight_g',
    'tip_mm',
    'description'
];

foreach ($requiredFields as $field) {
    if (!isset($_POST[$field])) {
        die('Missing form field: ' . htmlspecialchars($field, ENT_QUOTES, 'UTF-8'));
    }
}

/**
 * Trim and validate submitted values.
 */
$name = trim($_POST['name']);
$cueType = trim($_POST['cue_type']);
$material = trim($_POST['material']);
$lengthMm = (int) $_POST['length_mm'];
$weightG = (int) $_POST['weight_g'];
$tipMm = (float) $_POST['tip_mm'];
$description = trim($_POST['description']);

/**
 * Validate text fields are not empty.
 */
if ($name === '' || $material === '' || $description === '') {
    die('Text fields must not be empty.');
}

/**
 * Validate cue type against allowed values.
 */
$allowedTypes = ['playing', 'break', 'training'];

if (!in_array($cueType, $allowedTypes, true)) {
    die('Invalid cue type.');
}

/**
 * Validate numeric values.
 */
if ($lengthMm <= 0 || $weightG <= 0 || $tipMm <= 0) {
    die('Numeric values must be greater than zero.');
}

/**
 * Load the database connection.
 */
require_once __DIR__ . '/../src/db.php';

$pdo = db();

/**
 * Insert the new instrument using a prepared statement.
 * This protects the database against SQL injection.
 */
$stmt = $pdo->prepare(
    "INSERT INTO instruments
        (name, cue_type, material, length_mm, weight_g, tip_mm, description)
     VALUES
        (:name, :cue_type, :material, :length_mm, :weight_g, :tip_mm, :description)"
);

$stmt->execute([
    'name' => $name,
    'cue_type' => $cueType,
    'material' => $material,
    'length_mm' => $lengthMm,
    'weight_g' => $weightG,
    'tip_mm' => $tipMm,
    'description' => $description
]);

/**
 * Redirect after successful insertion.
 * For now, send the user back to the collection page to confirm the new item appears.
 */
header('Location: collection.php');
exit;
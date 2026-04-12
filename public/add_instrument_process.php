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
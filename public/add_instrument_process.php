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
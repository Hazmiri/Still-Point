<?php
declare(strict_types=1);

/**
 * Load shared project setup.
 */
require_once __DIR__ . '/../src/bootstrap.php';

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
 * Validate numeric values against realistic ranges.
 */
if ($lengthMm < 900 || $lengthMm > 1700) {
    die('Length must be between 900 mm and 1700 mm.');
}

if ($weightG < 300 || $weightG > 800) {
    die('Weight must be between 300 g and 800 g.');
}

if ($tipMm < 7.0 || $tipMm > 15.0) {
    die('Tip size must be between 7.0 mm and 15.0 mm.');
}

/**
 * Check that an image file was uploaded.
 */
if (!isset($_FILES['image'])) {
    die('Image upload is missing.');
}

$image = $_FILES['image'];

/**
 * Validate upload error status.
 */
if ($image['error'] !== UPLOAD_ERR_OK) {
    die('Image upload failed.');
}

/**
 * Limit image size to 2 MB.
 */
$maxFileSize = 2 * 1024 * 1024;

if ($image['size'] > $maxFileSize) {
    die('Image must not exceed 2 MB.');
}

/**
 * Validate MIME type using server-side inspection.
 */
$finfo = finfo_open(FILEINFO_MIME_TYPE);
$mimeType = finfo_file($finfo, $image['tmp_name']);
finfo_close($finfo);

$allowedMimeTypes = [
    'image/jpeg' => '.jpg',
    'image/png'  => '.png',
    'image/webp' => '.webp'
];

if (!isset($allowedMimeTypes[$mimeType])) {
    die('Invalid image type. Only JPG, PNG, and WEBP are allowed.');
}

/**
 * Generate a safe unique filename for the uploaded image.
 */
$extension = $allowedMimeTypes[$mimeType];
$uniqueFilename = bin2hex(random_bytes(16)) . $extension;

/**
 * Build the destination path.
 */
$uploadDirectory = __DIR__ . '/../uploads/';

if (!is_dir($uploadDirectory)) {
    die('Upload directory does not exist.');
}

$destinationPath = $uploadDirectory . $uniqueFilename;

/**
 * Move the uploaded file from temporary storage to the uploads folder.
 */
if (!move_uploaded_file($image['tmp_name'], $destinationPath)) {
    die('Failed to save uploaded image.');
}

/**
 * Store a relative path for use in the website.
 */
$imagePath = '../uploads/' . $uniqueFilename;

/**
 * Create database connection.
 */
$pdo = db();

/**
 * Insert the new instrument using a prepared statement.
 * This protects the database against SQL injection.
 */
$stmt = $pdo->prepare(
    "INSERT INTO instruments
        (name, cue_type, material, length_mm, weight_g, tip_mm, description, image_path)
     VALUES
        (:name, :cue_type, :material, :length_mm, :weight_g, :tip_mm, :description, :image_path)"
);

$stmt->execute([
    'name' => $name,
    'cue_type' => $cueType,
    'material' => $material,
    'length_mm' => $lengthMm,
    'weight_g' => $weightG,
    'tip_mm' => $tipMm,
    'description' => $description,
    'image_path' => $imagePath
]);

/**
 * Redirect after successful insertion.
 */
header('Location: collection.php');
exit;
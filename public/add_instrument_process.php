<?php
declare(strict_types=1);

require_once __DIR__ . '/../src/bootstrap.php';

require_login();

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    flash('Invalid instrument submission request.', 'error');
    redirect('add_instrument.php');
}

if (!verify_csrf($_POST['csrf_token'] ?? null)) {
    flash('Your session token was invalid. Please try again.', 'error');
    redirect('add_instrument.php');
}

$name = trim($_POST['name'] ?? '');
$cueType = trim($_POST['cue_type'] ?? '');
$material = trim($_POST['material'] ?? '');
$lengthMm = (int) ($_POST['length_mm'] ?? 0);
$weightG = (int) ($_POST['weight_g'] ?? 0);
$tipMm = (float) ($_POST['tip_mm'] ?? 0);
$description = trim($_POST['description'] ?? '');

$old = [
    'name' => $name,
    'cue_type' => $cueType,
    'material' => $material,
    'length_mm' => (string) $lengthMm,
    'weight_g' => (string) $weightG,
    'tip_mm' => (string) $tipMm,
    'description' => $description,
];

$errors = [];

if ($name === '' || $material === '' || $description === '') {
    $errors[] = 'Text fields must not be empty.';
}

$allowedTypes = ['playing', 'break', 'training'];

if (!in_array($cueType, $allowedTypes, true)) {
    $errors[] = 'Please select a valid cue type.';
}

if ($lengthMm < 900 || $lengthMm > 1700) {
    $errors[] = 'Length must be between 900 mm and 1700 mm.';
}

if ($weightG < 300 || $weightG > 800) {
    $errors[] = 'Weight must be between 300 g and 800 g.';
}

if ($tipMm < 7.0 || $tipMm > 15.0) {
    $errors[] = 'Tip size must be between 7.0 mm and 15.0 mm.';
}

if (!isset($_FILES['image'])) {
    $errors[] = 'An image upload is required.';
} else {
    $image = $_FILES['image'];

    if ($image['error'] !== UPLOAD_ERR_OK) {
        $errors[] = 'Image upload failed.';
    } else {
        $maxFileSize = 2 * 1024 * 1024;

        if ($image['size'] > $maxFileSize) {
            $errors[] = 'Image must not exceed 2 MB.';
        }

        $finfo = finfo_open(FILEINFO_MIME_TYPE);
        $mimeType = finfo_file($finfo, $image['tmp_name']);
        finfo_close($finfo);

        $allowedMimeTypes = [
            'image/jpeg' => '.jpg',
            'image/png'  => '.png',
            'image/webp' => '.webp',
        ];

        if (!isset($allowedMimeTypes[$mimeType])) {
            $errors[] = 'Invalid image type. Only JPG, PNG, and WEBP are allowed.';
        }
    }
}

if ($errors !== []) {
    store_form_state('instrument', $errors, $old);
    redirect('add_instrument.php');
}

$extension = $allowedMimeTypes[$mimeType];
$uniqueFilename = bin2hex(random_bytes(16)) . $extension;

$uploadDirectory = __DIR__ . '/../uploads/';

if (!is_dir($uploadDirectory) && !mkdir($uploadDirectory, 0755, true)) {
    store_form_state('instrument', ['Upload directory could not be created.'], $old);
    redirect('add_instrument.php');
}

$destinationPath = $uploadDirectory . $uniqueFilename;

if (!move_uploaded_file($image['tmp_name'], $destinationPath)) {
    store_form_state('instrument', ['Failed to save the uploaded image.'], $old);
    redirect('add_instrument.php');
}

$imagePath = '../uploads/' . $uniqueFilename;

$pdo = db();

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
    'image_path' => $imagePath,
]);

flash('Instrument registered successfully.');
redirect('collection.php');
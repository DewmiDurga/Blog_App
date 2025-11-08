<?php
header('Content-Type: application/json');
require_once '../../config/db.php';
require_once '../../includes/auth.php';
requireLogin();

// handle file upload
$imageFilename = null;
if (!empty($_FILES['image']['name'])) {
    $targetDir = __DIR__ . '/../../../uploads/';
    $fileName = basename($_FILES['image']['name']);
    $fileType = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));
    $allowedTypes = ['jpg', 'jpeg', 'png', 'webp'];

    // validate file type
    if (!in_array($fileType, $allowedTypes)) {
        http_response_code(400);
        echo json_encode(['error' => 'Only JPG, PNG, or WebP images allowed.']);
        exit();
    }

    // Validate size ( 2MB max)
    if ($_FILES['image']['size'] > 2 * 1024 * 1024) {
        http_response_code(400);
        echo json_encode(['error' => 'Image must be less than 2MB.']);
        exit();
    }

    // generate unique filename
    $uniqueName = uniqid() . '_' . time() . '.' . $fileType;
    $targetFile = $targetDir . $uniqueName;

    // create uploads directory if it doesnot exist
    if (!is_dir($targetDir)) {
        mkdir($targetDir, 0755, true);
    }

    // move uploaded file
    if (!move_uploaded_file($_FILES['image']['tmp_name'], $targetFile)) {
        http_response_code(500);
        echo json_encode(['error' => 'Failed to upload image.']);
        exit();
    }

    $imageFilename = $uniqueName;
}

// validate title and content
$title = trim($_POST['title'] ?? '');
$content = trim($_POST['content'] ?? '');
if (!$title || !$content) {
    http_response_code(400);
    echo json_encode(['error' => 'title and content required']);
    exit();
}

// handle category_id securely
$category_id = $_POST['category_id'] ?? null;
if ($category_id !== null) {
    if (!is_numeric($category_id)) {
        http_response_code(400);
        echo json_encode(['error' => 'Invalid category']);
        exit();
    }
    $catCheck = $pdo->prepare("SELECT 1 FROM category WHERE id = ?");
    $catCheck->execute([$category_id]);
    if (!$catCheck->fetch()) {
        http_response_code(400);
        echo json_encode(['error' => 'Invalid category']);
        exit();
    }
}

// insert post
try {
    $stmt = $pdo->prepare("INSERT INTO blogPost (user_id, title, content, image, category_id) VALUES (?, ?, ?, ?, ?)");
    $stmt->execute([$_SESSION['user_id'], $title, $content, $imageFilename, $category_id]);
    echo json_encode(['success' => true, 'id' => $pdo->lastInsertId()]);
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(['error' => 'Failed to create post']);
}
?>
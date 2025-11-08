<?php
header('Content-Type: application/json');
require_once '../../config/db.php';
require_once '../../includes/auth.php';
requireLogin();

$id = $_POST['id'] ?? null;
if (!$id || !is_numeric($id)) {
    http_response_code(400);
    echo json_encode(['error' => 'Invalid post ID']);
    exit();
}

// fetch current post (including image and user_id)
$stmt = $pdo->prepare("SELECT user_id, image FROM blogPost WHERE id = ?");
$stmt->execute([$id]);
$post = $stmt->fetch();
if (!$post) {
    http_response_code(404);
    echo json_encode(['error' => 'Post not found']);
    exit();
}

// removed duplicate 
if (!isOwner($post['user_id'])) {
    http_response_code(403);
    echo json_encode(['error' => 'Forbidden']);
    exit();
}

// validate title and content
$title = trim($_POST['title'] ?? '');
$content = trim($_POST['content'] ?? '');
if (!$title || !$content) {
    http_response_code(400);
    echo json_encode(['error' => 'Title and content required']);
    exit();
}

// Handle image upload
$imageFilename = $post['image']; 
if (!empty($_FILES['image']['name'])) {
    $targetDir = __DIR__ . '/../../../uploads/';
    $fileName = basename($_FILES['image']['name']);
    $fileType = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));
    $allowedTypes = ['jpg', 'jpeg', 'png', 'webp'];

    if (!in_array($fileType, $allowedTypes)) {
        http_response_code(400);
        echo json_encode(['error' => 'Only JPG, PNG, or WebP images allowed.']);
        exit();
    }

    if ($_FILES['image']['size'] > 2 * 1024 * 1024) {
        http_response_code(400);
        echo json_encode(['error' => 'Image must be less than 2MB.']);
        exit();
    }

    $uniqueName = uniqid() . '_' . time() . '.' . $fileType;
    $targetFile = $targetDir . $uniqueName;

    if (!is_dir($targetDir)) {
        mkdir($targetDir, 0755, true);
    }

    if (!move_uploaded_file($_FILES['image']['tmp_name'], $targetFile)) {
        http_response_code(500);
        echo json_encode(['error' => 'Failed to upload image.']);
        exit();
    }

    $imageFilename = $uniqueName;
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

// update post
try {
    $stmt = $pdo->prepare("UPDATE blogPost SET title = ?, content = ?, image = ?, category_id = ? WHERE id = ?");
    $stmt->execute([$title, $content, $imageFilename, $category_id, $id]);
    echo json_encode(['success' => true]);
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(['error' => 'Failed to update post']);
}
?>
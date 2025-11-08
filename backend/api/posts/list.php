<?php
require_once '../../config/db.php';

$category_id = $_GET['category_id'] ?? null;
$query = $_GET['q'] ?? null;

$sql = "SELECT p.id, p.title, p.content, p.image, p.created_at, u.username, c.name AS category_name
        FROM blogPost p
        JOIN user u ON p.user_id = u.id
        LEFT JOIN category c ON p.category_id = c.id
        WHERE 1=1";

$params = [];

if ($query !== null && trim($query) !== '') {
    $sql .= " AND (p.title LIKE ? OR p.content LIKE ?)";
    $like = '%' . $query . '%';
    $params[] = $like;
    $params[] = $like;
}

if ($category_id !== null && is_numeric($category_id)) {
    $sql .= " AND p.category_id = ?";
    $params[] = $category_id;
}

$sql .= " ORDER BY p.created_at DESC";

$stmt = $pdo->prepare($sql);
$stmt->execute($params);
echo json_encode($stmt->fetchAll(PDO::FETCH_ASSOC));
?>
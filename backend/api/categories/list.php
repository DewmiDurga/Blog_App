<?php
require_once '../../config/db.php';

try {
    $stmt = $pdo->query("SELECT id, name FROM category ORDER BY name");
    echo json_encode($stmt->fetchAll(PDO::FETCH_ASSOC));
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(['error' => 'Failed to load categories']);
}
?>
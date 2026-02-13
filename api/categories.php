<?php
header('Content-Type: application/json');
require_once '../admin/config.php';

$method = $_SERVER['REQUEST_METHOD'];

// Get all categories with article count
if ($method === 'GET') {
    $categories = $conn->query("
        SELECT c.id, c.name, c.slug, COUNT(a.id) as article_count
        FROM categories c
        LEFT JOIN articles a ON a.category_id = c.id AND a.status = 'published'
        GROUP BY c.id, c.name, c.slug
        ORDER BY c.name
    ");
    
    $data = [];
    while ($cat = $categories->fetch_assoc()) {
        $data[] = $cat;
    }
    
    echo json_encode([
        'success' => true,
        'data' => $data
    ]);
}

else {
    http_response_code(405);
    echo json_encode([
        'success' => false,
        'message' => 'Method tidak diizinkan'
    ]);
}
?>

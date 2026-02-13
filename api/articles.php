<?php
header('Content-Type: application/json');

try {
    require_once '../admin/config.php';
    
    // Check if database connection is valid
    if (!$conn) {
        throw new Exception('Database connection failed');
    }
    
    $method = $_SERVER['REQUEST_METHOD'];
    $action = $_GET['action'] ?? '';
    
    // Get articles from database
    if ($method === 'GET') {
        if ($action === 'search') {
            $query = sanitize($_GET['q'] ?? '');
            $category = intval($_GET['category'] ?? 0);
            $page = intval($_GET['page'] ?? 1);
            $limit = intval($_GET['limit'] ?? 12);
            $offset = ($page - 1) * $limit;
            
            $where = "WHERE a.status = 'published'";
            if (!empty($query)) {
                $query_escaped = $conn->real_escape_string(strtolower($query));
                $where .= " AND (LOWER(a.title) LIKE '%$query_escaped%' OR LOWER(a.content) LIKE '%$query_escaped%')";
            }
            if ($category > 0) {
                $where .= " AND a.category_id = $category";
            }
            
            // Total count
            $count_result = $conn->query("SELECT COUNT(*) as total FROM articles a $where");
            if (!$count_result) {
                throw new Exception('Query error: ' . $conn->error);
            }
            $count_data = $count_result->fetch_assoc();
            $total = $count_data['total'] ?? 0;
            
            // Get articles
            $articles = $conn->query("
                SELECT a.id, a.title, a.slug, a.excerpt, a.content, a.read_time, a.published_at, a.status, c.name as category_name, c.id as category_id
                FROM articles a
                LEFT JOIN categories c ON a.category_id = c.id
                $where
                ORDER BY a.published_at DESC
                LIMIT $offset, $limit
            ");
            
            if (!$articles) {
                throw new Exception('Query error: ' . $conn->error);
            }
            
            $data = [];
            while ($article = $articles->fetch_assoc()) {
                $data[] = [
                    'id' => $article['id'],
                    'title' => $article['title'],
                    'slug' => $article['slug'],
                    'excerpt' => $article['excerpt'],
                    'content' => substr(strip_tags($article['content']), 0, 150) . '...',
                    'category' => $article['category_name'],
                    'category_id' => $article['category_id'],
                    'read_time' => $article['read_time'],
                    'date' => date('d M Y', strtotime($article['published_at']))
                ];
            }
            
            echo json_encode([
                'success' => true,
                'data' => $data,
                'total' => $total,
                'page' => $page,
                'pages' => ceil($total / $limit)
            ]);
            
        } elseif ($action === 'categories') {
            $categories = $conn->query("SELECT id, name FROM categories ORDER BY name");
            if (!$categories) {
                throw new Exception('Query error: ' . $conn->error);
            }
            $data = [];
            while ($cat = $categories->fetch_assoc()) {
                $data[] = $cat;
            }
            echo json_encode([
                'success' => true,
                'data' => $data
            ]);
            
        } elseif (!empty($action)) {
            // Get single article by slug or id
            $id_or_slug = $conn->real_escape_string($action);
            
            $article = $conn->query("
                SELECT a.id, a.title, a.slug, a.excerpt, a.content, a.read_time, a.published_at, a.status, a.views, a.author_id, a.tags, c.name as category_name, c.id as category_id
                FROM articles a
                LEFT JOIN categories c ON a.category_id = c.id
                WHERE (a.id = '$id_or_slug' OR a.slug = '$id_or_slug') AND a.status = 'published'
                LIMIT 1
            ");
            
            if (!$article) {
                throw new Exception('Query error: ' . $conn->error);
            }
            
            $articleData = $article->fetch_assoc();
            
            if ($articleData) {
                // Update views
                $conn->query("UPDATE articles SET views = views + 1 WHERE id = {$articleData['id']}");
                
                echo json_encode([
                    'success' => true,
                    'data' => $articleData
                ]);
            } else {
                http_response_code(404);
                echo json_encode([
                    'success' => false,
                    'message' => 'Artikel tidak ditemukan'
                ]);
            }
            
        } else {
            // List all published articles with pagination
            $page = intval($_GET['page'] ?? 1);
            $limit = intval($_GET['limit'] ?? 12);
            $offset = ($page - 1) * $limit;
            
            $count_result = $conn->query("SELECT COUNT(*) as total FROM articles WHERE status = 'published'");
            if (!$count_result) {
                throw new Exception('Query error: ' . $conn->error);
            }
            $count_data = $count_result->fetch_assoc();
            $total = $count_data['total'] ?? 0;
            
            $articles = $conn->query("
                SELECT a.id, a.title, a.slug, a.excerpt, a.content, a.read_time, a.published_at, a.status, c.name as category_name, c.id as category_id
                FROM articles a
                LEFT JOIN categories c ON a.category_id = c.id
                WHERE a.status = 'published'
                ORDER BY a.published_at DESC
                LIMIT $offset, $limit
            ");
            
            if (!$articles) {
                throw new Exception('Query error: ' . $conn->error);
            }
            
            $data = [];
            while ($article = $articles->fetch_assoc()) {
                $data[] = [
                    'id' => $article['id'],
                    'title' => $article['title'],
                    'slug' => $article['slug'],
                    'excerpt' => $article['excerpt'],
                    'category' => $article['category_name'],
                    'category_id' => $article['category_id'],
                    'read_time' => $article['read_time'],
                    'date' => date('d M Y', strtotime($article['published_at']))
                ];
            }
            
            echo json_encode([
                'success' => true,
                'data' => $data,
                'total' => $total,
                'page' => $page,
                'pages' => ceil($total / $limit)
            ]);
        }
    }
    
    // Delete article (admin only)
    elseif ($method === 'DELETE') {
        requireLogin();
        
        $id = intval($_GET['id'] ?? 0);
        
        if ($id === 0) {
            http_response_code(400);
            echo json_encode([
                'success' => false,
                'message' => 'ID artikel tidak valid'
            ]);
        } else {
            $stmt = $conn->prepare("DELETE FROM articles WHERE id = ?");
            $stmt->bind_param("i", $id);
            
            if ($stmt->execute()) {
                echo json_encode([
                    'success' => true,
                    'message' => 'Artikel berhasil dihapus'
                ]);
            } else {
                http_response_code(500);
                echo json_encode([
                    'success' => false,
                    'message' => 'Gagal menghapus artikel'
                ]);
            }
            $stmt->close();
        }
    }
    
    else {
        http_response_code(405);
        echo json_encode([
            'success' => false,
            'message' => 'Method tidak diizinkan'
        ]);
    }
} catch (Exception $e) {
    http_response_code(500);
    error_log("API Error: " . $e->getMessage());
    echo json_encode([
        'success' => false,
        'message' => 'Error: ' . $e->getMessage(),
        'error' => $e->getMessage()
    ]);
}
?>

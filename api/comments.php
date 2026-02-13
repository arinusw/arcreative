<?php
header('Content-Type: application/json');

try {
    require_once '../admin/config.php';
    
    // Check if database connection is valid
    if (!$conn) {
        throw new Exception('Database connection failed');
    }
    
    $method = $_SERVER['REQUEST_METHOD'];
    
    // Get comments for an article
    if ($method === 'GET') {
        $article_id = intval($_GET['article_id'] ?? 0);
        
        if ($article_id === 0) {
            http_response_code(400);
            echo json_encode([
                'success' => false,
                'message' => 'ID artikel tidak valid'
            ]);
            exit();
        }
        
        $comments = $conn->query("
            SELECT id, author_name as name, author_email as email, content, created_at
            FROM comments
            WHERE article_id = $article_id AND status = 'approved'
            ORDER BY created_at DESC
        ");
        
        if (!$comments) {
            throw new Exception('Query error: ' . $conn->error);
        }
        
        $data = [];
        while ($comment = $comments->fetch_assoc()) {
            $data[] = [
                'id' => $comment['id'],
                'name' => htmlspecialchars($comment['name']),
                'email' => htmlspecialchars($comment['email']),
                'content' => nl2br(htmlspecialchars($comment['content'])),
                'date' => date('d M Y H:i', strtotime($comment['created_at']))
            ];
        }
        
        echo json_encode([
            'success' => true,
            'data' => $data
        ]);
    }
    
    // Add new comment
    elseif ($method === 'POST') {
        $article_id = intval($_POST['article_id'] ?? 0);
        $name = sanitize($_POST['name'] ?? '');
        $email = sanitize($_POST['email'] ?? '');
        $content = sanitize($_POST['content'] ?? '');
        
        if ($article_id === 0 || empty($name) || empty($email) || empty($content)) {
            http_response_code(400);
            echo json_encode([
                'success' => false,
                'message' => 'Semua field harus diisi'
            ]);
            exit();
        }
        
        // Validate email
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            http_response_code(400);
            echo json_encode([
                'success' => false,
                'message' => 'Email tidak valid'
            ]);
            exit();
        }
        
        // Check if article exists
        $article_check = $conn->query("SELECT id FROM articles WHERE id = $article_id AND status = 'published'");
        if (!$article_check) {
            throw new Exception('Query error: ' . $conn->error);
        }
        
        if ($article_check->num_rows === 0) {
            http_response_code(404);
            echo json_encode([
                'success' => false,
                'message' => 'Artikel tidak ditemukan'
            ]);
            exit();
        }
        
        // Get moderation setting from admin
        $settings_file = __DIR__ . '/../admin/settings.json';
        $requires_moderation = true;
        
        if (file_exists($settings_file)) {
            $settings = json_decode(file_get_contents($settings_file), true);
            $requires_moderation = ($settings['comment_moderation'] ?? true) === 'yes';
        }
        
        $status = $requires_moderation ? 'pending' : 'approved';
        
        $stmt = $conn->prepare("
            INSERT INTO comments (article_id, author_name, author_email, content, status)
            VALUES (?, ?, ?, ?, ?)
        ");
        
        if (!$stmt) {
            throw new Exception('Prepare error: ' . $conn->error);
        }
        
        $stmt->bind_param(
            "issss",
            $article_id, $name, $email, $content, $status
        );
        
        if ($stmt->execute()) {
            echo json_encode([
                'success' => true,
                'message' => $requires_moderation ? 'Komentar Anda akan ditampilkan setelah persetujuan admin' : 'Komentar berhasil ditambahkan'
            ]);
        } else {
            http_response_code(500);
            throw new Exception('Execute error: ' . $stmt->error);
        }
        
        $stmt->close();
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
    error_log("Comments API Error: " . $e->getMessage());
    echo json_encode([
        'success' => false,
        'message' => 'Error: ' . $e->getMessage(),
        'error' => $e->getMessage()
    ]);
}
?>

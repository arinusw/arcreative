<?php
require_once 'config.php';
requireLogin();

$error = '';
$success = '';

// Get all comments
$comments = $conn->query("
    SELECT c.*, a.title as article_title
    FROM comments c
    LEFT JOIN articles a ON c.article_id = a.id
    ORDER BY c.created_at DESC
");

// Handle status update
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action'])) {
    if ($_POST['action'] === 'approve') {
        $comment_id = intval($_POST['comment_id'] ?? 0);
        $stmt = $conn->prepare("UPDATE comments SET status = 'approved' WHERE id = ?");
        $stmt->bind_param("i", $comment_id);
        
        if ($stmt->execute()) {
            $success = 'Komentar berhasil disetujui!';
        } else {
            $error = 'Error: ' . $conn->error;
        }
        $stmt->close();
        
    } elseif ($_POST['action'] === 'reject') {
        $comment_id = intval($_POST['comment_id'] ?? 0);
        $stmt = $conn->prepare("UPDATE comments SET status = 'rejected' WHERE id = ?");
        $stmt->bind_param("i", $comment_id);
        
        if ($stmt->execute()) {
            $success = 'Komentar berhasil ditolak!';
        } else {
            $error = 'Error: ' . $conn->error;
        }
        $stmt->close();
        
    } elseif ($_POST['action'] === 'delete') {
        $comment_id = intval($_POST['comment_id'] ?? 0);
        $stmt = $conn->prepare("DELETE FROM comments WHERE id = ?");
        $stmt->bind_param("i", $comment_id);
        
        if ($stmt->execute()) {
            $success = 'Komentar berhasil dihapus!';
        } else {
            $error = 'Error: ' . $conn->error;
        }
        $stmt->close();
    }
    
    // Refresh comments
    $comments = $conn->query("
        SELECT c.*, a.title as article_title
        FROM comments c
        LEFT JOIN articles a ON c.article_id = a.id
        ORDER BY c.created_at DESC
    ");
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Moderasi Komentar - Ar Creative CMS</title>
    
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700;800&display=swap" rel="stylesheet" />
    
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" />
    
    <link rel="stylesheet" href="css/admin.css" />
    
    <style>
        .comment-card {
            background: white;
            border: 1px solid #e0e0e0;
            border-radius: 8px;
            padding: 1.5rem;
            margin-bottom: 1.5rem;
            transition: all 0.3s;
        }
        
        .comment-card:hover {
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
        }
        
        .comment-header {
            display: flex;
            justify-content: space-between;
            align-items: start;
            margin-bottom: 1rem;
        }
        
        .comment-author {
            font-weight: 600;
            color: #222;
        }
        
        .comment-meta {
            display: flex;
            gap: 1rem;
            font-size: 0.85rem;
            color: #999;
            margin-top: 0.5rem;
        }
        
        .comment-content {
            color: #555;
            line-height: 1.6;
            margin-bottom: 1rem;
        }
        
        .comment-actions {
            display: flex;
            gap: 0.5rem;
            flex-wrap: wrap;
        }
        
        .comment-actions form {
            display: inline;
        }
        
        .status-badge {
            display: inline-block;
            padding: 4px 10px;
            border-radius: 20px;
            font-size: 0.85rem;
            font-weight: 600;
        }
        
        .status-pending {
            background: rgba(255, 193, 7, 0.1);
            color: #ffc107;
        }
        
        .status-approved {
            background: rgba(40, 167, 69, 0.1);
            color: #28a745;
        }
        
        .status-rejected {
            background: rgba(220, 53, 69, 0.1);
            color: #dc3545;
        }
    </style>
</head>
<body>
    <!-- Sidebar Navigation -->
    <aside class="sidebar">
        <div class="sidebar-header">
            <h2><i class="fas fa-cube"></i> Ar Creative</h2>
            <p>Admin Panel</p>
        </div>
        
        <nav class="sidebar-menu">
            <a href="dashboard.php" class="menu-item">
                <i class="fas fa-chart-line"></i> Dashboard
            </a>
            <a href="articles.php" class="menu-item">
                <i class="fas fa-newspaper"></i> Artikel
            </a>
            <a href="categories.php" class="menu-item">
                <i class="fas fa-tags"></i> Kategori
            </a>
            <a href="comments.php" class="menu-item active">
                <i class="fas fa-comments"></i> Komentar
            </a>
            <hr />
            <a href="settings.php" class="menu-item">
                <i class="fas fa-cogs"></i> Pengaturan
            </a>
            <a href="logout.php" class="menu-item logout">
                <i class="fas fa-sign-out-alt"></i> Logout
            </a>
        </nav>
    </aside>
    
    <!-- Main Content -->
    <main class="main-content">
        <!-- Header -->
        <header class="admin-header">
            <div class="header-left">
                <h1>Moderasi Komentar</h1>
                <p>Kelola komentar dari pembaca blog</p>
            </div>
        </header>
        
        <!-- Content -->
        <div class="container">
            <?php if (!empty($error)): ?>
                <div style="padding: 12px 15px; background-color: rgba(220, 53, 69, 0.1); color: #dc3545; border-radius: 8px; margin-bottom: 1rem;">
                    <i class="fas fa-exclamation-circle"></i> <?php echo $error; ?>
                </div>
            <?php endif; ?>
            
            <?php if (!empty($success)): ?>
                <div style="padding: 12px 15px; background-color: rgba(40, 167, 69, 0.1); color: #28a745; border-radius: 8px; margin-bottom: 1rem;">
                    <i class="fas fa-check-circle"></i> <?php echo $success; ?>
                </div>
            <?php endif; ?>
            
            <div class="recent-section">
                <h3 style="margin-bottom: 1.5rem;">
                    <i class="fas fa-comments"></i> Komentar Pembaca
                </h3>
                
                <?php
                $comment_data = [];
                while ($comment = $comments->fetch_assoc()) {
                    $comment_data[] = $comment;
                }
                
                if (empty($comment_data)):
                ?>
                    <p style="text-align: center; color: #999; padding: 2rem;">
                        <i class="fas fa-inbox"></i> Belum ada komentar
                    </p>
                <?php else: ?>
                    <?php foreach ($comment_data as $comment): ?>
                        <div class="comment-card">
                            <div class="comment-header">
                                <div>
                                    <div class="comment-author"><?php echo htmlspecialchars($comment['name']); ?></div>
                                    <div class="comment-meta">
                                        <span><i class="fas fa-envelope"></i> <?php echo htmlspecialchars($comment['email']); ?></span>
                                        <span><i class="fas fa-newspaper"></i> <?php echo htmlspecialchars($comment['article_title'] ?? 'Unknown'); ?></span>
                                        <span><i class="fas fa-clock"></i> <?php echo date('d/m/Y H:i', strtotime($comment['created_at'])); ?></span>
                                    </div>
                                </div>
                                <span class="status-badge status-<?php echo $comment['status']; ?>">
                                    <?php echo ucfirst($comment['status']); ?>
                                </span>
                            </div>
                            
                            <div class="comment-content">
                                <?php echo nl2br(htmlspecialchars($comment['content'])); ?>
                            </div>
                            
                            <div class="comment-actions">
                                <?php if ($comment['status'] !== 'approved'): ?>
                                    <form method="POST">
                                        <input type="hidden" name="action" value="approve" />
                                        <input type="hidden" name="comment_id" value="<?php echo $comment['id']; ?>" />
                                        <button type="submit" class="btn-icon" title="Setujui Komentar">
                                            <i class="fas fa-check" style="color: #28a745;"></i> Setujui
                                        </button>
                                    </form>
                                <?php endif; ?>
                                
                                <?php if ($comment['status'] !== 'rejected'): ?>
                                    <form method="POST">
                                        <input type="hidden" name="action" value="reject" />
                                        <input type="hidden" name="comment_id" value="<?php echo $comment['id']; ?>" />
                                        <button type="submit" class="btn-icon" title="Tolak Komentar">
                                            <i class="fas fa-times" style="color: #ffc107;"></i> Tolak
                                        </button>
                                    </form>
                                <?php endif; ?>
                                
                                <form method="POST">
                                    <input type="hidden" name="action" value="delete" />
                                    <input type="hidden" name="comment_id" value="<?php echo $comment['id']; ?>" />
                                    <button type="submit" class="btn-icon" title="Hapus Komentar" onclick="return confirm('Yakin ingin menghapus komentar ini?');">
                                        <i class="fas fa-trash" style="color: #dc3545;"></i> Hapus
                                    </button>
                                </form>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
        </div>
    </main>
    
    <style>
        .btn-icon {
            background: none;
            border: none;
            padding: 6px 12px;
            cursor: pointer;
            color: #6c757d;
            font-size: 0.9rem;
            border-radius: 4px;
            transition: all 0.3s;
            display: inline-flex;
            align-items: center;
            gap: 0.4rem;
        }
        
        .btn-icon:hover {
            background: #f5f7fa;
        }
    </style>
</body>
</html>

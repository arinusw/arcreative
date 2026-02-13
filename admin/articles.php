<?php
require_once 'config.php';
requireLogin();

// Get all articles
$articles = $conn->query("
    SELECT a.id, a.title, c.name as category, a.status, a.created_at, a.views
    FROM articles a
    LEFT JOIN categories c ON a.category_id = c.id
    ORDER BY a.created_at DESC
");

// Handle delete
if (isset($_GET['delete'])) {
    $id = intval($_GET['delete']);
    
    // Delete related data first
    $conn->query("DELETE FROM comments WHERE article_id = $id");
    $conn->query("DELETE FROM article_tags WHERE article_id = $id");
    
    // Then delete article
    $conn->query("DELETE FROM articles WHERE id = $id");
    header('Location: articles.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Kelola Artikel - Ar Creative CMS</title>
    
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700;800&display=swap" rel="stylesheet" />
    
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" />
    
    <link rel="stylesheet" href="css/admin.css" />
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
            <a href="articles.php" class="menu-item active">
                <i class="fas fa-newspaper"></i> Artikel
            </a>
            <a href="categories.php" class="menu-item">
                <i class="fas fa-tags"></i> Kategori
            </a>
            <a href="comments.php" class="menu-item">
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
                <h1>Kelola Artikel</h1>
                <p>Manage semua artikel di website</p>
            </div>
            <div class="header-right">
                <a href="new-article.php" class="btn btn-primary">
                    <i class="fas fa-plus"></i> Buat Artikel Baru
                </a>
            </div>
        </header>
        
        <!-- Content -->
        <div class="container">
            <div class="recent-section">
                <table>
                    <thead>
                        <tr>
                            <th>Judul</th>
                            <th>Kategori</th>
                            <th>Status</th>
                            <th>Views</th>
                            <th>Tanggal</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($article = $articles->fetch_assoc()): ?>
                            <tr>
                                <td><?php echo $article['title']; ?></td>
                                <td><span class="badge"><?php echo $article['category']; ?></span></td>
                                <td>
                                    <span class="status status-<?php echo $article['status']; ?>">
                                        <?php echo ucfirst($article['status']); ?>
                                    </span>
                                </td>
                                <td><?php echo $article['views']; ?></td>
                                <td><?php echo date('d M Y', strtotime($article['created_at'])); ?></td>
                                <td>
                                    <a href="edit-article.php?id=<?php echo $article['id']; ?>" class="btn-action">
                                        <i class="fas fa-edit"></i> Edit
                                    </a>
                                    <a href="articles.php?delete=<?php echo $article['id']; ?>" class="btn-action delete" onclick="return confirm('Hapus artikel ini?')">
                                        <i class="fas fa-trash"></i> Hapus
                                    </a>
                                </td>
                            </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </main>
</body>
</html>

<?php
require_once 'config.php';
requireLogin();

// Get statistics
$totalArticles = $conn->query("SELECT COUNT(*) as count FROM articles WHERE status='published'")->fetch_assoc()['count'];
$totalDraft = $conn->query("SELECT COUNT(*) as count FROM articles WHERE status='draft'")->fetch_assoc()['count'];
$totalCategories = $conn->query("SELECT COUNT(*) as count FROM categories")->fetch_assoc()['count'];
$recentArticles = $conn->query("
    SELECT a.id, a.title, c.name as category, a.created_at, a.status 
    FROM articles a 
    LEFT JOIN categories c ON a.category_id = c.id 
    ORDER BY a.created_at DESC 
    LIMIT 5
");
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Dashboard Admin - Ar Creative CMS</title>
    
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
            <a href="dashboard.php" class="menu-item active">
                <i class="fas fa-chart-line"></i> Dashboard
            </a>
            <a href="articles.php" class="menu-item">
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
                <h1>Dashboard</h1>
                <p>Selamat datang, <?php echo $_SESSION['admin_name']; ?>!</p>
            </div>
            <div class="header-right">
                <div class="user-info">
                    <img src="https://via.placeholder.com/40" alt="Profile" />
                    <span><?php echo $_SESSION['admin_name']; ?></span>
                </div>
            </div>
        </header>
        
        <!-- Content -->
        <div class="container">
            <!-- Statistics Cards -->
            <div class="stats-grid">
                <div class="stat-card">
                    <div class="stat-icon" style="background: linear-gradient(135deg, #569ae3, #4a8bc2);">
                        <i class="fas fa-newspaper"></i>
                    </div>
                    <div class="stat-content">
                        <h3>Artikel Dipublikasi</h3>
                        <p class="stat-number"><?php echo $totalArticles; ?></p>
                    </div>
                </div>
                
                <div class="stat-card">
                    <div class="stat-icon" style="background: linear-gradient(135deg, #f77f00, #fcbf49);">
                        <i class="fas fa-file-alt"></i>
                    </div>
                    <div class="stat-content">
                        <h3>Draft Artikel</h3>
                        <p class="stat-number"><?php echo $totalDraft; ?></p>
                    </div>
                </div>
                
                <div class="stat-card">
                    <div class="stat-icon" style="background: linear-gradient(135deg, #06a77d, #28a745);">
                        <i class="fas fa-tags"></i>
                    </div>
                    <div class="stat-content">
                        <h3>Kategori</h3>
                        <p class="stat-number"><?php echo $totalCategories; ?></p>
                    </div>
                </div>
                
                <div class="stat-card">
                    <div class="stat-icon" style="background: linear-gradient(135deg, #d62828, #f77f00);">
                        <i class="fas fa-comments"></i>
                    </div>
                    <div class="stat-content">
                        <h3>Komentar Baru</h3>
                        <p class="stat-number">0</p>
                    </div>
                </div>
            </div>
            
            <!-- Recent Articles -->
            <div class="recent-section">
                <div class="section-header">
                    <h2>Artikel Terbaru</h2>
                    <a href="articles.php" class="btn-link">Lihat Semua</a>
                </div>
                
                <div class="articles-table">
                    <table>
                        <thead>
                            <tr>
                                <th>Judul</th>
                                <th>Kategori</th>
                                <th>Status</th>
                                <th>Tanggal</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php while ($article = $recentArticles->fetch_assoc()): ?>
                                <tr>
                                    <td><?php echo $article['title']; ?></td>
                                    <td><span class="badge"><?php echo $article['category']; ?></span></td>
                                    <td>
                                        <span class="status status-<?php echo $article['status']; ?>">
                                            <?php echo ucfirst($article['status']); ?>
                                        </span>
                                    </td>
                                    <td><?php echo date('d M Y', strtotime($article['created_at'])); ?></td>
                                    <td>
                                        <a href="edit-article.php?id=<?php echo $article['id']; ?>" class="btn-action">Edit</a>
                                        <a href="delete-article.php?id=<?php echo $article['id']; ?>" class="btn-action delete" onclick="return confirm('Hapus artikel ini?')">Hapus</a>
                                    </td>
                                </tr>
                            <?php endwhile; ?>
                        </tbody>
                    </table>
                </div>
            </div>
            
            <!-- Quick Actions -->
            <div class="quick-actions">
                <a href="new-article.php" class="btn btn-primary">
                    <i class="fas fa-plus"></i> Buat Artikel Baru
                </a>
                <a href="categories.php" class="btn btn-secondary">
                    <i class="fas fa-tags"></i> Kelola Kategori
                </a>
            </div>
        </div>
    </main>
</body>
</html>

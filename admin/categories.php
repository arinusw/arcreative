<?php
require_once 'config.php';
requireLogin();

$error = '';
$success = '';

// Get all categories
$categories = $conn->query("SELECT c.id, c.name, c.slug, COUNT(a.id) as article_count 
    FROM categories c 
    LEFT JOIN articles a ON a.category_id = c.id 
    GROUP BY c.id, c.name, c.slug 
    ORDER BY c.name");

// Handle new category
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'add') {
    $name = sanitize($_POST['category_name'] ?? '');
    
    if (empty($name)) {
        $error = 'Nama kategori harus diisi!';
    } else {
        // Auto-generate slug
        $slug = strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-', $name)));
        
        $stmt = $conn->prepare("INSERT INTO categories (name, slug) VALUES (?, ?)");
        $stmt->bind_param("ss", $name, $slug);
        
        if ($stmt->execute()) {
            $success = 'Kategori berhasil ditambahkan!';
            $categories = $conn->query("SELECT c.id, c.name, c.slug, COUNT(a.id) as article_count 
                FROM categories c 
                LEFT JOIN articles a ON a.category_id = c.id 
                GROUP BY c.id, c.name, c.slug 
                ORDER BY c.name");
        } else {
            $error = 'Error: ' . $conn->error;
        }
        
        $stmt->close();
    }
}

// Handle delete category
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'delete') {
    $category_id = intval($_POST['category_id'] ?? 0);
    
    // Check if category has articles
    $check = $conn->query("SELECT COUNT(*) as count FROM articles WHERE category_id = $category_id");
    $count_result = $check->fetch_assoc();
    
    if ($count_result['count'] > 0) {
        $error = 'Tidak bisa menghapus kategori yang memiliki artikel!';
    } else {
        $stmt = $conn->prepare("DELETE FROM categories WHERE id = ?");
        $stmt->bind_param("i", $category_id);
        
        if ($stmt->execute()) {
            $success = 'Kategori berhasil dihapus!';
            $categories = $conn->query("SELECT c.id, c.name, c.slug, COUNT(a.id) as article_count 
                FROM categories c 
                LEFT JOIN articles a ON a.category_id = c.id 
                GROUP BY c.id, c.name, c.slug 
                ORDER BY c.name");
        } else {
            $error = 'Error: ' . $conn->error;
        }
        
        $stmt->close();
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Kelola Kategori - Ar Creative CMS</title>
    
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
            <a href="articles.php" class="menu-item">
                <i class="fas fa-newspaper"></i> Artikel
            </a>
            <a href="categories.php" class="menu-item active">
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
                <h1>Kategori</h1>
                <p>Kelola kategori artikel blog Anda</p>
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
            
            <!-- Add New Category -->
            <div class="recent-section" style="margin-bottom: 2rem;">
                <h3 style="margin-bottom: 1rem;">Tambah Kategori Baru</h3>
                <form method="POST" style="display: grid; grid-template-columns: 1fr auto auto; gap: 1rem; align-items: end;">
                    <div class="form-group" style="margin-bottom: 0;">
                        <label for="category_name">Nama Kategori</label>
                        <input type="text" id="category_name" name="category_name" placeholder="Contoh: Web Development" required />
                    </div>
                    <input type="hidden" name="action" value="add" />
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-plus"></i> Tambah
                    </button>
                </form>
            </div>
            
            <!-- Categories List -->
            <div class="recent-section">
                <h3 style="margin-bottom: 1rem;">Daftar Kategori</h3>
                
                <div class="table-responsive">
                    <table class="admin-table">
                        <thead>
                            <tr>
                                <th>Nama Kategori</th>
                                <th>Slug</th>
                                <th>Jumlah Artikel</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $categories_array = [];
                            while ($cat = $categories->fetch_assoc()):
                                $categories_array[] = $cat;
                            ?>
                                <tr>
                                    <td><strong><?php echo htmlspecialchars($cat['name']); ?></strong></td>
                                    <td><code style="background: #f5f7fa; padding: 2px 6px; border-radius: 4px; font-size: 0.85rem;"><?php echo $cat['slug']; ?></code></td>
                                    <td><span class="badge" style="background: #569ae3; color: white; padding: 4px 8px; border-radius: 4px; font-size: 0.85rem;"><?php echo $cat['article_count']; ?></span></td>
                                    <td>
                                        <form method="POST" style="display: inline;">
                                            <input type="hidden" name="action" value="delete" />
                                            <input type="hidden" name="category_id" value="<?php echo $cat['id']; ?>" />
                                            <?php if ($cat['article_count'] == 0): ?>
                                                <button type="submit" class="btn-icon btn-danger" onclick="return confirm('Yakin ingin menghapus kategori ini?');" title="Hapus">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            <?php else: ?>
                                                <button type="button" class="btn-icon btn-disabled" title="Tidak bisa dihapus (ada artikel)" disabled>
                                                    <i class="fas fa-lock"></i>
                                                </button>
                                            <?php endif; ?>
                                        </form>
                                    </td>
                                </tr>
                            <?php endwhile; ?>
                            
                            <?php if (empty($categories_array)): ?>
                                <tr>
                                    <td colspan="4" style="text-align: center; padding: 2rem; color: #999;">
                                        <i class="fas fa-inbox"></i> Belum ada kategori
                                    </td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </main>
    
    <style>
        .btn-icon {
            background: none;
            border: none;
            padding: 6px 8px;
            cursor: pointer;
            color: #6c757d;
            font-size: 1rem;
            border-radius: 4px;
            transition: all 0.3s;
        }
        
        .btn-icon:hover {
            background: #f5f7fa;
        }
        
        .btn-danger {
            color: #dc3545;
        }
        
        .btn-danger:hover {
            background: rgba(220, 53, 69, 0.1);
        }
        
        .btn-disabled {
            opacity: 0.5;
            cursor: not-allowed;
        }
        
        .btn-disabled:hover {
            background: none;
        }
    </style>
</body>
</html>

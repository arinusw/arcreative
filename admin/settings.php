<?php
require_once 'config.php';
requireLogin();

$error = '';
$success = '';

// In a real implementation, you'd store these in a database 'settings' table
// For now, we'll use a JSON file
$settings_file = __DIR__ . '/settings.json';
$settings = [];

if (file_exists($settings_file)) {
    $settings = json_decode(file_get_contents($settings_file), true);
} else {
    $settings = [
        'site_title' => 'Ar Creative',
        'site_description' => 'Professional design and development studio',
        'site_author' => 'Ar Creative Team',
        'posts_per_page' => '12',
        'timezone' => 'Asia/Jakarta',
        'enable_comments' => 'yes',
        'comment_moderation' => 'yes'
    ];
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $settings['site_title'] = sanitize($_POST['site_title'] ?? '');
    $settings['site_description'] = sanitize($_POST['site_description'] ?? '');
    $settings['site_author'] = sanitize($_POST['site_author'] ?? '');
    $settings['posts_per_page'] = intval($_POST['posts_per_page'] ?? 12);
    $settings['timezone'] = sanitize($_POST['timezone'] ?? 'Asia/Jakarta');
    $settings['enable_comments'] = $_POST['enable_comments'] ?? 'yes';
    $settings['comment_moderation'] = $_POST['comment_moderation'] ?? 'yes';
    
    if (file_put_contents($settings_file, json_encode($settings, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES))) {
        $success = 'Pengaturan berhasil disimpan!';
    } else {
        $error = 'Gagal menyimpan pengaturan!';
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Pengaturan - Ar Creative CMS</title>
    
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
            <a href="categories.php" class="menu-item">
                <i class="fas fa-tags"></i> Kategori
            </a>
            <a href="comments.php" class="menu-item">
                <i class="fas fa-comments"></i> Komentar
            </a>
            <hr />
            <a href="settings.php" class="menu-item active">
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
                <h1>Pengaturan Website</h1>
                <p>Kelola konfigurasi umum website Anda</p>
            </div>
        </header>
        
        <!-- Content -->
        <div class="container">
            <div class="recent-section">
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
                
                <form method="POST">
                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 2rem;">
                        <div>
                            <h3 style="margin-bottom: 1.5rem;">Informasi Dasar</h3>
                            
                            <div class="form-group">
                                <label for="site_title">Judul Website</label>
                                <input type="text" id="site_title" name="site_title" value="<?php echo htmlspecialchars($settings['site_title']); ?>" required />
                            </div>
                            
                            <div class="form-group">
                                <label for="site_description">Deskripsi Website</label>
                                <textarea id="site_description" name="site_description" style="min-height: 80px;" required><?php echo htmlspecialchars($settings['site_description']); ?></textarea>
                            </div>
                            
                            <div class="form-group">
                                <label for="site_author">Nama Penulis Default</label>
                                <input type="text" id="site_author" name="site_author" value="<?php echo htmlspecialchars($settings['site_author']); ?>" />
                            </div>
                        </div>
                        
                        <div>
                            <h3 style="margin-bottom: 1.5rem;">Pengaturan Blog</h3>
                            
                            <div class="form-group">
                                <label for="posts_per_page">Artikel Per Halaman</label>
                                <input type="number" id="posts_per_page" name="posts_per_page" value="<?php echo $settings['posts_per_page']; ?>" min="1" max="50" />
                            </div>
                            
                            <div class="form-group">
                                <label for="timezone">Zona Waktu</label>
                                <select id="timezone" name="timezone">
                                    <option value="Asia/Jakarta" <?php echo ($settings['timezone'] === 'Asia/Jakarta') ? 'selected' : ''; ?>>Asia/Jakarta (WIB)</option>
                                    <option value="Asia/Makassar" <?php echo ($settings['timezone'] === 'Asia/Makassar') ? 'selected' : ''; ?>>Asia/Makassar (WITA)</option>
                                    <option value="Asia/Jayapura" <?php echo ($settings['timezone'] === 'Asia/Jayapura') ? 'selected' : ''; ?>>Asia/Jayapura (WIT)</option>
                                    <option value="UTC" <?php echo ($settings['timezone'] === 'UTC') ? 'selected' : ''; ?>>UTC</option>
                                </select>
                            </div>
                            
                            <h3 style="margin-top: 2rem; margin-bottom: 1rem;">Komentar</h3>
                            
                            <div class="form-group">
                                <label>
                                    <input type="checkbox" name="enable_comments" value="yes" <?php echo ($settings['enable_comments'] === 'yes') ? 'checked' : ''; ?> />
                                    Aktifkan Komentar
                                </label>
                            </div>
                            
                            <div class="form-group">
                                <label>
                                    <input type="checkbox" name="comment_moderation" value="yes" <?php echo ($settings['comment_moderation'] === 'yes') ? 'checked' : ''; ?> />
                                    Moderasi Komentar
                                </label>
                                <small style="display: block; color: #999; margin-top: 0.5rem;">Komentar harus disetujui sebelum tampil</small>
                            </div>
                        </div>
                    </div>
                    
                    <div style="margin-top: 2rem; display: flex; gap: 1rem;">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save"></i> Simpan Pengaturan
                        </button>
                        <a href="dashboard.php" class="btn btn-secondary">
                            <i class="fas fa-arrow-left"></i> Kembali
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </main>
</body>
</html>

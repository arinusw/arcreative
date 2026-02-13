<?php
require_once 'config.php';
requireLogin();

$article_id = intval($_GET['id'] ?? 0);
$article = null;
$error = '';
$success = '';

if ($article_id === 0) {
    die('Artikel tidak ditemukan!');
}

// Get article data
$stmt = $conn->prepare("SELECT * FROM articles WHERE id = ?");
$stmt->bind_param("i", $article_id);
$stmt->execute();
$result = $stmt->get_result();
$article = $result->fetch_assoc();
$stmt->close();

if (!$article) {
    die('Artikel tidak ditemukan!');
}

$categories = $conn->query("SELECT id, name FROM categories ORDER BY name");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = sanitize($_POST['title'] ?? '');
    $content = $_POST['content'] ?? '';
    $excerpt = sanitize($_POST['excerpt'] ?? '');
    $category_id = intval($_POST['category_id'] ?? 0);
    $status = $_POST['status'] ?? 'draft';
    $read_time = intval($_POST['read_time'] ?? 5);
    
    // Create slug from title
    $slug = strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-', $title)));
    
    if (empty($title) || empty($content)) {
        $error = 'Judul dan konten harus diisi!';
    } else {
        $published_at = ($status === 'published') ? ($article['published_at'] ?: date('Y-m-d H:i:s')) : null;
        
        $stmt = $conn->prepare("
            UPDATE articles 
            SET title = ?, slug = ?, content = ?, excerpt = ?, category_id = ?, read_time = ?, status = ?, published_at = ?
            WHERE id = ?
        ");
        
        $stmt->bind_param(
            "ssssiissi",
            $title, $slug, $content, $excerpt, $category_id, $read_time, $status, $published_at, $article_id
        );
        
        if ($stmt->execute()) {
            $success = 'Artikel berhasil diperbarui!';
            // Refresh article data
            $result = $conn->query("SELECT * FROM articles WHERE id = $article_id");
            $article = $result->fetch_assoc();
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
    <title>Edit Artikel - Ar Creative CMS</title>
    
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700;800&display=swap" rel="stylesheet" />
    
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" />
    
    <link rel="stylesheet" href="css/admin.css" />
    
    <!-- Quill Editor -->
    <link href="https://cdn.jsdelivr.net/npm/quill@1.3.6/dist/quill.snow.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/quill@1.3.6/dist/quill.min.js"></script>
    <style>
        .ql-container {
            font-family: 'Poppins', sans-serif;
            font-size: 14px;
        }
        #editor-container {
            background: white;
            border: 1px solid #ddd;
            border-radius: 4px;
            min-height: 400px;
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
                <h1>Edit Artikel</h1>
                <p><?php echo htmlspecialchars($article['title']); ?></p>
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
                    <div style="display: grid; grid-template-columns: 2fr 1fr; gap: 2rem;">
                        <!-- Main Content -->
                        <div>
                            <div class="form-group">
                                <label for="title">Judul Artikel</label>
                                <input type="text" id="title" name="title" value="<?php echo htmlspecialchars($article['title']); ?>" required />
                            </div>
                            
                            <div class="form-group">
                                <label for="excerpt">Ringkasan (Excerpt)</label>
                                <textarea id="excerpt" name="excerpt" style="min-height: 80px;"><?php echo htmlspecialchars($article['excerpt']); ?></textarea>
                            </div>
                            
                            <div class="form-group">
                                <label for="content">Konten</label>
                                <div id="editor-container"></div>
                                <input type="hidden" id="content" name="content" required />
                                <!-- Store original content for Quill to load -->
                                <script>
                                    var originalContent = <?php echo json_encode($article['content']); ?>;
                                </script>
                            </div>
                        </div>
                        
                        <!-- Sidebar -->
                        <div>
                            <div class="form-group">
                                <label for="category_id">Kategori</label>
                                <select id="category_id" name="category_id" required>
                                    <option value="">Pilih Kategori</option>
                                    <?php
                                    $categories = $conn->query("SELECT id, name FROM categories ORDER BY name");
                                    while ($cat = $categories->fetch_assoc()): ?>
                                        <option value="<?php echo $cat['id']; ?>" <?php echo ($cat['id'] == $article['category_id']) ? 'selected' : ''; ?>>
                                            <?php echo $cat['name']; ?>
                                        </option>
                                    <?php endwhile; ?>
                                </select>
                            </div>
                            
                            <div class="form-group">
                                <label for="read_time">Waktu Baca (menit)</label>
                                <input type="number" id="read_time" name="read_time" value="<?php echo $article['read_time']; ?>" min="1" />
                            </div>
                            
                            <div class="form-group">
                                <label for="status">Status</label>
                                <select id="status" name="status">
                                    <option value="draft" <?php echo ($article['status'] === 'draft') ? 'selected' : ''; ?>>Draft</option>
                                    <option value="published" <?php echo ($article['status'] === 'published') ? 'selected' : ''; ?>>Publish</option>
                                </select>
                            </div>
                            
                            <div style="background-color: #f8f9fa; padding: 1rem; border-radius: 8px; margin-bottom: 1rem;">
                                <p style="font-size: 0.85rem; color: #6c757d; margin-bottom: 0.5rem;">Info Artikel:</p>
                                <p style="font-size: 0.9rem; margin: 0.25rem 0;">
                                    <strong>Slug:</strong> <?php echo $article['slug']; ?>
                                </p>
                                <p style="font-size: 0.9rem; margin: 0.25rem 0;">
                                    <strong>Dibuat:</strong> <?php echo date('d/m/Y H:i', strtotime($article['created_at'])); ?>
                                </p>
                                <?php if ($article['published_at']): ?>
                                    <p style="font-size: 0.9rem; margin: 0.25rem 0;">
                                        <strong>Dipublikasi:</strong> <?php echo date('d/m/Y H:i', strtotime($article['published_at'])); ?>
                                    </p>
                                <?php endif; ?>
                            </div>
                            
                            <div style="display: flex; gap: 1rem;">
                                <button type="submit" class="btn btn-primary" style="flex: 1;">
                                    <i class="fas fa-save"></i> Simpan
                                </button>
                                <a href="articles.php" class="btn btn-secondary" style="flex: 1; text-align: center;">
                                    <i class="fas fa-arrow-left"></i> Batal
                                </a>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </main>
    
    <script>
        // Initialize Quill Editor
        const quill = new Quill('#editor-container', {
            theme: 'snow',
            placeholder: 'Ketik konten artikel di sini...',
            modules: {
                toolbar: [
                    ['bold', 'italic', 'underline', 'strike'],
                    ['blockquote', 'code-block'],
                    [{ 'header': 1 }, { 'header': 2 }],
                    [{ 'list': 'ordered'}, { 'list': 'bullet' }],
                    [{ 'color': [] }, { 'background': [] }],
                    ['link', 'image', 'video'],
                    ['clean']
                ]
            }
        });

        // Load existing article content into Quill
        if (typeof originalContent !== 'undefined' && originalContent) {
            quill.root.innerHTML = originalContent;
        }

        // Handle form submission - get Quill content and put into hidden input
        document.querySelector('form').addEventListener('submit', function(e) {
            const contentInput = document.querySelector('#content');
            contentInput.value = quill.root.innerHTML;
            
            // Validate that content is not empty
            if (quill.getText().trim().length === 0) {
                e.preventDefault();
                alert('Konten harus diisi!');
                return false;
            }
        });
    </script>
</body>
</html>

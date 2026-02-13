<?php
require_once 'config.php';
requireLogin();

$categories = $conn->query("SELECT id, name FROM categories ORDER BY name");
$error = '';
$success = '';

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
        $author_id = $_SESSION['admin_id'];
        $published_at = ($status === 'published') ? date('Y-m-d H:i:s') : null;
        
        $stmt = $conn->prepare("
            INSERT INTO articles (title, slug, content, excerpt, category_id, author_id, read_time, status, published_at)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)
        ");
        
        $stmt->bind_param(
            "ssssiiss",
            $title, $slug, $content, $excerpt, $category_id, $author_id, $read_time, $status, $published_at
        );
        
        if ($stmt->execute()) {
            $success = 'Artikel berhasil dibuat!';
            header('Location: articles.php');
            exit();
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
    <title>Buat Artikel Baru - Ar Creative CMS</title>
    
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
                <h1>Buat Artikel Baru</h1>
                <p>Tambahkan konten baru ke website Anda</p>
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
                                <input type="text" id="title" name="title" required />
                            </div>
                            
                            <div class="form-group">
                                <label for="excerpt">Ringkasan (Excerpt)</label>
                                <textarea id="excerpt" name="excerpt" style="min-height: 80px;"></textarea>
                            </div>
                            
                            <div class="form-group">
                                <label for="content">Konten</label>
                                <div id="editor-container"></div>
                                <input type="hidden" id="content" name="content" required />
                            </div>
                        </div>
                        
                        <!-- Sidebar -->
                        <div>
                            <div class="form-group">
                                <label for="category_id">Kategori</label>
                                <select id="category_id" name="category_id" required>
                                    <option value="">Pilih Kategori</option>
                                    <?php while ($cat = $categories->fetch_assoc()): ?>
                                        <option value="<?php echo $cat['id']; ?>"><?php echo $cat['name']; ?></option>
                                    <?php endwhile; ?>
                                </select>
                            </div>
                            
                            <div class="form-group">
                                <label for="read_time">Waktu Baca (menit)</label>
                                <input type="number" id="read_time" name="read_time" value="5" min="1" />
                            </div>
                            
                            <div class="form-group">
                                <label for="status">Status</label>
                                <select id="status" name="status">
                                    <option value="draft">Draft</option>
                                    <option value="published">Publish</option>
                                </select>
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

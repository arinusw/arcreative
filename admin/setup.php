<?php
/**
 * DATABASE SETUP & DEBUG FILE
 * Akses dari: http://localhost/arcreative/admin/setup.php
 * 
 * FILE INI HARUS DIHAPUS SETELAH SETUP SELESAI
 * JANGAN UPLOAD KE PRODUCTION
 */

error_reporting(E_ALL);
ini_set('display_errors', 1);

$db_host = 'localhost';
$db_user = 'root';
$db_pass = '';
$db_name = 'arcreative_cms';

// Create connection
$conn = new mysqli($db_host, $db_user, $db_pass);

if ($conn->connect_error) {
    die('❌ Database Connection Failed: ' . $conn->connect_error);
}

// Create Database
$create_db = "CREATE DATABASE IF NOT EXISTS $db_name";
if (!$conn->query($create_db)) {
    die('❌ Failed to create database: ' . $conn->error);
}

// Select Database
$conn->select_db($db_name);

$setup_status = [];

// Create Tables
$tables_sql = "
-- USERS TABLE
CREATE TABLE IF NOT EXISTS users (
    id INT PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(100) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    role ENUM('admin', 'editor') DEFAULT 'editor',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    is_active BOOLEAN DEFAULT TRUE
);

-- CATEGORIES TABLE
CREATE TABLE IF NOT EXISTS categories (
    id INT PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(100) NOT NULL UNIQUE,
    slug VARCHAR(100) NOT NULL UNIQUE,
    description TEXT,
    icon VARCHAR(50),
    color VARCHAR(7),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- ARTICLES TABLE
CREATE TABLE IF NOT EXISTS articles (
    id INT PRIMARY KEY AUTO_INCREMENT,
    title VARCHAR(255) NOT NULL,
    slug VARCHAR(255) NOT NULL UNIQUE,
    content LONGTEXT NOT NULL,
    excerpt TEXT,
    category_id INT NOT NULL,
    author_id INT NOT NULL,
    featured_image VARCHAR(255),
    read_time INT DEFAULT 5,
    tags TEXT,
    status ENUM('draft', 'published', 'archived') DEFAULT 'draft',
    published_at DATETIME,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    views INT DEFAULT 0,
    FOREIGN KEY (category_id) REFERENCES categories(id) ON DELETE CASCADE,
    FOREIGN KEY (author_id) REFERENCES users(id) ON DELETE RESTRICT,
    INDEX idx_slug (slug),
    INDEX idx_category (category_id),
    INDEX idx_status (status),
    INDEX idx_published (published_at)
);

-- COMMENTS TABLE
CREATE TABLE IF NOT EXISTS comments (
    id INT PRIMARY KEY AUTO_INCREMENT,
    article_id INT NOT NULL,
    author_name VARCHAR(100) NOT NULL,
    author_email VARCHAR(100) NOT NULL,
    content TEXT NOT NULL,
    status ENUM('pending', 'approved', 'rejected') DEFAULT 'pending',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (article_id) REFERENCES articles(id) ON DELETE CASCADE,
    INDEX idx_article (article_id),
    INDEX idx_status (status)
);

-- TAGS TABLE
CREATE TABLE IF NOT EXISTS tags (
    id INT PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(100) NOT NULL UNIQUE,
    slug VARCHAR(100) NOT NULL UNIQUE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- ARTICLE TAGS
CREATE TABLE IF NOT EXISTS article_tags (
    article_id INT NOT NULL,
    tag_id INT NOT NULL,
    PRIMARY KEY (article_id, tag_id),
    FOREIGN KEY (article_id) REFERENCES articles(id) ON DELETE CASCADE,
    FOREIGN KEY (tag_id) REFERENCES tags(id) ON DELETE CASCADE
);
";

// Execute each table creation
$tables = explode(';', $tables_sql);
foreach ($tables as $table) {
    $table = trim($table);
    if (!empty($table)) {
        if (!$conn->query($table)) {
            $setup_status[] = '⚠️ ' . substr($table, 0, 50) . '... - ' . $conn->error;
        }
    }
}

// Insert sample data
$insert_data = false;
if (isset($_POST['insert_sample_data'])) {
    insert_sample_data($conn, $setup_status);
    $insert_data = true;
}

?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Database Setup - Ar Creative</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }
        .container {
            background: white;
            border-radius: 10px;
            padding: 40px;
            max-width: 800px;
            width: 100%;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.2);
        }
        h1 {
            color: #333;
            margin-bottom: 30px;
            text-align: center;
        }
        .status-box {
            background: #f8f9fa;
            border-left: 4px solid #667eea;
            padding: 15px;
            margin: 15px 0;
            border-radius: 5px;
        }
        .status-box.success {
            border-left-color: #28a745;
            background: #d4edda;
            color: #155724;
        }
        .status-box.error {
            border-left-color: #dc3545;
            background: #f8d7da;
            color: #721c24;
        }
        .status-box.warning {
            border-left-color: #ffc107;
            background: #fff3cd;
            color: #856404;
        }
        .button-group {
            display: flex;
            gap: 10px;
            margin-top: 30px;
            flex-wrap: wrap;
        }
        button, a {
            padding: 12px 24px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
            text-decoration: none;
            display: inline-block;
            transition: all 0.3s;
        }
        .btn-primary {
            background: #667eea;
            color: white;
        }
        .btn-primary:hover {
            background: #5568d3;
        }
        .btn-danger {
            background: #dc3545;
            color: white;
        }
        .btn-danger:hover {
            background: #c82333;
        }
        .status-table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
        }
        .status-table th {
            background: #667eea;
            color: white;
            padding: 12px;
            text-align: left;
        }
        .status-table td {
            padding: 10px 12px;
            border-bottom: 1px solid #ddd;
        }
        .status-table tr:nth-child(even) {
            background: #f8f9fa;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>🔧 Database Setup - Ar Creative</h1>
        
        <div class="status-box success">
            ✅ <strong>Database & Tables Created Successfully</strong>
        </div>

        <h2>Status Sistem</h2>
        <table class="status-table">
            <thead>
                <tr>
                    <th>Komponen</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>Database Connection</td>
                    <td><span style="color: green;">✅ Connected</span></td>
                </tr>
                <tr>
                    <td>Database Name</td>
                    <td><?php echo $db_name; ?></td>
                </tr>
                <tr>
                    <td>Tables Created</td>
                    <td><span style="color: green;">✅ All tables ready</span></td>
                </tr>
                <tr>
                    <td>Sample Data</td>
                    <td id="sample-status">❌ Not inserted</td>
                </tr>
            </tbody>
        </table>

        <h2>Langkah Selanjutnya</h2>
        <ol style="margin-left: 20px; margin-bottom: 20px;">
            <li>Klik tombol "Insert Sample Data" untuk membuat data contoh artikel dan kategori</li>
            <li>Akses halaman blog di <code>http://localhost/arcreative/blog.html</code></li>
            <li>Hapus file <code>admin/setup.php</code> setelah selesai setup</li>
        </ol>

        <form method="POST" onsubmit="return confirm('Insert sample data? Klik OK untuk melanjutkan.')">
            <div class="button-group">
                <button type="submit" name="insert_sample_data" class="btn-primary">
                    📝 Insert Sample Data
                </button>
                <a href="../../admin/index.php" class="btn-primary">👤 Go to Admin Panel</a>
                <a href="../../blog.html" class="btn-primary">📰 Go to Blog</a>
                <a href="../../index.html" class="btn-primary">🏠 Go to Homepage</a>
            </div>
        </form>

        <?php if ($insert_data): ?>
            <div class="status-box success" style="margin-top: 30px;">
                ✅ <strong>Sample Data Inserted Successfully!</strong><br>
                Now you can:
                <ul style="margin-left: 20px; margin-top: 10px;">
                    <li>Visit <a href="../../blog.html" style="color: #1976d2;">Blog Page</a></li>
                    <li>Check <a href="../../articles/article.php?id=1" style="color: #1976d2;">First Article</a></li>
                </ul>
            </div>
        <?php endif; ?>
    </div>
</body>
</html>

<?php

function insert_sample_data($conn, &$status) {
    // Insert default admin user
    $hashed_password = password_hash('password123', PASSWORD_BCRYPT);
    $conn->query("INSERT IGNORE INTO users (name, email, password, role) VALUES ('Admin Ar Creative', 'admin@arcreative.local', '$hashed_password', 'admin')");
    
    // Get or create admin user ID
    $user_result = $conn->query("SELECT id FROM users WHERE role = 'admin' LIMIT 1");
    $user_row = $user_result->fetch_assoc();
    $admin_id = $user_row['id'] ?? 1;
    
    // Insert categories
    $categories = [
        ['name' => 'Tutorial Desain Grafis', 'slug' => 'tutorial-design'],
        ['name' => 'Tutorial Web Development', 'slug' => 'tutorial-web'],
        ['name' => 'Tips & Trik Digital', 'slug' => 'tips-trik'],
        ['name' => 'Tutorial Teknis Komputer', 'slug' => 'tutorial-teknis'],
        ['name' => 'Management Konten', 'slug' => 'management-konten'],
    ];
    
    foreach ($categories as $cat) {
        $name = $conn->real_escape_string($cat['name']);
        $slug = $cat['slug'];
        $conn->query("INSERT IGNORE INTO categories (name, slug, description) VALUES ('$name', '$slug', 'Kategori $name')");
    }
    
    // Get category IDs
    $cat_result = $conn->query("SELECT id FROM categories LIMIT 1");
    $cat_row = $cat_result->fetch_assoc();
    $category_id = $cat_row['id'] ?? 1;
    
    // Insert sample articles
    $articles = [
        [
            'title' => 'Panduan Lengkap Memulai Desain Grafis untuk Pemula',
            'slug' => 'panduan-desain-grafis-pemula',
            'content' => '<h2>Pengenalan Desain Grafis</h2><p>Desain grafis adalah seni dan praktik merencanakan dan proyek ide-ide visual dengan menggunakan teks dan gambar. Ini melibatkan proses komunikasi visual untuk mengkomunikasikan pesan kepada audiens.</p><h2>Tools yang Dibutuhkan</h2><p>Beberapa tools populer untuk desain grafis meliputi:</p><ul><li>Adobe Creative Suite (Photoshop, Illustrator, InDesign)</li><li>Figma</li><li>CorelDRAW</li><li>GIMP (Free)</li></ul><h2>Tips untuk Pemula</h2><p>Mulai dari dasar, pelajari teori warna, tipografi, dan komposisi sebelum terjun ke software profesional.</p>',
            'excerpt' => 'Belajar dasar-dasar desain grafis dari nol. Panduan ini mencakup teori warna, tipografi, komposisi, dan tools yang perlu Anda kuasai.',
            'read_time' => 8,
            'tags' => 'Design,Beginner,Tutorial'
        ],
        [
            'title' => '6 Tips Membuat Website yang SEO Friendly dan Cepat',
            'slug' => 'tips-website-seo-friendly',
            'content' => '<h2>Pentingnya SEO untuk Website</h2><p>SEO (Search Engine Optimization) adalah teknik untuk meningkatkan visibilitas website di mesin pencari seperti Google.</p><h2>6 Tips Membuat Website SEO Friendly</h2><ol><li><strong>Optimasi Kecepatan Loading</strong> - Gunakan CDN, minify CSS/JS, dan compress gambar</li><li><strong>Mobile Responsive Design</strong> - Pastikan website terlihat bagus di semua device</li><li><strong>Internal Linking</strong> - Link ke halaman lain dalam website Anda</li><li><strong>Meta Description</strong> - Tulis deskripsi menarik untuk setiap halaman</li><li><strong>Quality Content</strong> - Buat konten berkualitas yang relevan dengan keyword target</li><li><strong>XML Sitemap</strong> - Buat sitemap untuk membantu Google mengindex website</li></ol><p>Implementasi tips ini akan membantu meningkatkan ranking website Anda di Google.</p>',
            'excerpt' => 'Optimasi website untuk ranking tinggi di Google. Teknik SEO on-page, off-page, dan technical SEO yang proven meningkatkan traffic.',
            'read_time' => 10,
            'tags' => 'SEO,Web Development,Performance'
        ],
        [
            'title' => 'Logo Design: Tips & Trik Membuat Logo yang Memorable',
            'slug' => 'logo-design-tips-trik',
            'content' => '<h2>Apa itu Logo yang Baik?</h2><p>Logo yang baik adalah kombinasi dari visual yang menarik, sederhana, dan memorable. Logo harus mampu mengkomunikasikan nilai brand dalam bentuk visual yang simple.</p><h2>Proses Desain Logo</h2><h3>1. Riset</h3><p>Pelajari brand, kompetitor, dan target audience sebelum mulai design.</p><h3>2. Sketsa</h3><p>Mulai dengan sketsa di kertas untuk explorasi ide-ide awal.</p><h3>3. Digitalisasi</h3><p>Transform sketsa ke format digital menggunakan design tools.</p><h3>4. Refinement</h3><p>Perbaiki detail, color, dan typography sampai hasil yang sempurna.</p><h2>Tools Populer</h2><p>Adobe Illustrator, Figma, dan CorelDRAW adalah tools yang paling digunakan untuk logo design.</p>',
            'excerpt' => 'Pelajari cara membuat logo yang efektif, memorable, dan timeless. Dari sketsa awal hingga finalisasi dengan software profesional.',
            'read_time' => 10,
            'tags' => 'Logo,Branding,Design'
        ]
    ];
    
    foreach ($articles as $article) {
        $title = $conn->real_escape_string($article['title']);
        $slug = $article['slug'];
        $content = $conn->real_escape_string($article['content']);
        $excerpt = $conn->real_escape_string($article['excerpt']);
        $read_time = $article['read_time'];
        $tags = $article['tags'];
        
        $published_at = date('Y-m-d H:i:s', strtotime('-' . rand(1, 30) . ' days'));
        
        $query = "INSERT IGNORE INTO articles 
                  (title, slug, content, excerpt, category_id, author_id, read_time, tags, status, published_at) 
                  VALUES ('$title', '$slug', '$content', '$excerpt', $category_id, $admin_id, $read_time, '$tags', 'published', '$published_at')";
        
        if (!$conn->query($query)) {
            $status[] = '⚠️ Failed to insert: ' . $article['title'] . ' - ' . $conn->error;
        }
    }
    
    // Update sample data status in UI
    echo '<script>document.getElementById("sample-status").innerHTML = "✅ Inserted";</script>';
}

$conn->close();
?>

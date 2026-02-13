<?php
// Simple article detail page
$article_identifier = $_GET['id'] ?? $_GET['slug'] ?? '';

if (empty($article_identifier)) {
    die('Artikel tidak ditemukan!');
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Artikel - Ar Creative</title>
    
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700;800&display=swap" rel="stylesheet" />
    
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" />
    
    <link rel="stylesheet" href="../css/style.css" />
    <link rel="stylesheet" href="../css/blog.css" />
    
    <style>
        .blog-detail {
            max-width: 900px;
            margin: 0 auto;
            padding: 2rem;
        }
        
        .blog-detail-header {
            margin-bottom: 3rem;
        }
        
        .blog-detail-meta {
            display: flex;
            gap: 1.5rem;
            margin: 1rem 0;
            font-size: 0.95rem;
            color: #666;
            flex-wrap: wrap;
        }
        
        .blog-detail-meta span {
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }
        
        .blog-detail-meta a {
            color: #569ae3;
            text-decoration: none;
        }
        
        .blog-detail-meta a:hover {
            text-decoration: underline;
        }
        
        .blog-detail-content {
            line-height: 1.8;
            font-size: 1.05rem;
            color: #333;
            margin: 2rem 0;
        }
        
        .blog-detail-content h2 {
            font-size: 1.5rem;
            color: #222;
            margin-top: 2rem;
            margin-bottom: 1rem;
        }
        
        .blog-detail-content h3 {
            font-size: 1.2rem;
            color: #222;
            margin-top: 1.5rem;
            margin-bottom: 0.8rem;
        }
        
        .blog-detail-content p {
            margin-bottom: 1rem;
        }
        
        .blog-detail-content ul, .blog-detail-content ol {
            margin-left: 1.5rem;
            margin-bottom: 1rem;
        }
        
        .blog-detail-content li {
            margin-bottom: 0.5rem;
        }
        
        .blog-detail-content blockquote {
            border-left: 4px solid #569ae3;
            padding-left: 1rem;
            margin-left: 0;
            margin-bottom: 1rem;
            color: #666;
            font-style: italic;
        }
        
        .blog-detail-tags {
            display: flex;
            gap: 0.5rem;
            flex-wrap: wrap;
            margin-top: 2rem;
            padding-top: 2rem;
            border-top: 1px solid #eee;
        }
        
        .blog-detail-tags a {
            display: inline-block;
            padding: 0.4rem 1rem;
            background: #f0f0f0;
            color: #569ae3;
            border-radius: 20px;
            text-decoration: none;
            font-size: 0.9rem;
            transition: all 0.3s;
        }
        
        .blog-detail-tags a:hover {
            background: #569ae3;
            color: white;
        }
        
        .blog-detail-footer {
            margin-top: 3rem;
            padding: 2rem;
            background: #f8f9fa;
            border-radius: 10px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 1rem;
        }
        
        .comments-section {
            border-top: 1px solid #eee;
            padding-top: 2rem;
            margin-top: 2rem;
        }
        
        .comment-card {
            background: #f8f9fa;
            padding: 1rem;
            border-radius: 8px;
            margin-bottom: 1rem;
        }
        
        .comment-header {
            display: flex;
            justify-content: space-between;
            margin-bottom: 0.5rem;
        }
        
        .comment-author {
            font-weight: 600;
            color: #222;
        }
        
        .comment-date {
            font-size: 0.85rem;
            color: #999;
        }
        
        .comment-content {
            color: #555;
            line-height: 1.6;
        }
        
        .comment-form {
            background: #f8f9fa;
            padding: 1.5rem;
            border-radius: 8px;
            margin-top: 2rem;
        }
        
        .form-group {
            margin-bottom: 1rem;
        }
        
        .form-group label {
            display: block;
            margin-bottom: 0.5rem;
            font-weight: 600;
            color: #333;
        }
        
        .form-group input,
        .form-group textarea {
            width: 100%;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 4px;
            font-family: inherit;
            font-size: 1rem;
        }
        
        .form-group textarea {
            min-height: 120px;
            resize: vertical;
        }
        
        .form-group input:focus,
        .form-group textarea:focus {
            outline: none;
            border-color: #569ae3;
            box-shadow: 0 0 0 3px rgba(86, 154, 227, 0.1);
        }
        
        .form-row {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 1rem;
        }
        
        .loading {
            text-align: center;
            padding: 2rem;
            color: #999;
        }
        
        @media (max-width: 768px) {
            .blog-detail {
                padding: 1rem;
            }
            
            .blog-detail-meta {
                flex-direction: column;
                gap: 0.5rem;
            }
            
            .blog-detail-footer {
                flex-direction: column;
                text-align: center;
            }
            
            .form-row {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>
<body>
    <!-- Navigation -->
    <nav class="navbar">
        <div class="container">
            <div class="logo">
                <h1>Ar Creative</h1>
            </div>
            <ul class="nav-links">
                <li><a href="../index.html">Portfolio</a></li>
                <li><a href="../blog.html">Blog</a></li>
                <li><a href="#contact">Hubungi Kami</a></li>
            </ul>
        </div>
    </nav>
    
    <!-- Content -->
    <div class="blog-detail" id="article-container">
        <div class="loading">
            <i class="fas fa-spinner fa-spin"></i> Memuat artikel...
        </div>
    </div>
    
    <script>
        const identifier = '<?php echo htmlspecialchars($article_identifier); ?>';
        let articleId = null;
        
        // Debug info
        console.log('Loading article with identifier:', identifier);
        
        // Fetch article data from API
        fetch(`../api/articles.php?action=${identifier}`)
            .then(response => {
                console.log('Response status:', response.status, response.statusText);
                if (!response.ok) {
                    throw new Error(`HTTP Error: ${response.status} ${response.statusText}`);
                }
                return response.json();
            })
            .then(result => {
                console.log('API Response:', result);
                
                if (result.success && result.data) {
                    const article = result.data;
                    articleId = article.id;
                    document.title = article.title + ' - Ar Creative';
                    
                    const html = `
                        <div class="blog-detail-header">
                            <h1>${article.title}</h1>
                            <div class="blog-detail-meta">
                                <span>
                                    <i class="fas fa-user"></i>
                                    ${article.author_id || 'Ar Creative'}
                                </span>
                                <span>
                                    <i class="fas fa-calendar"></i>
                                    ${new Date(article.published_at).toLocaleDateString('id-ID', { year: 'numeric', month: 'long', day: 'numeric' })}
                                </span>
                                <span>
                                    <i class="fas fa-folder"></i>
                                    <a href="../blog.html?category=${article.category_id || ''}">${article.category || 'Uncategorized'}</a>
                                </span>
                                <span>
                                    <i class="fas fa-clock"></i>
                                    ${article.read_time} menit baca
                                </span>
                                <span>
                                    <i class="fas fa-eye"></i>
                                    ${article.views || 0} views
                                </span>
                            </div>
                        </div>
                        
                        <div class="blog-detail-content">
                            ${article.content}
                        </div>
                        
                        <div class="blog-detail-tags">
                            ${article.tags ? article.tags.split(',').map(tag => {
                                const cleanTag = tag.trim();
                                const encodedTag = encodeURIComponent(cleanTag);
                                return '<a href="../blog.html?search=' + encodedTag + '">#' + cleanTag + '</a>';
                            }).join('') : ''}
                        </div>
                        
                        <div class ="comments-section">
                            <h2 style="font-size: 1.3rem; margin-bottom: 1.5rem;">Komentar (<span id="comments-count">0</span>)</h2>
                            
                            <div id="comments-list" style="margin-bottom: 2rem;"></div>
                            
                            <div class="comment-form">
                                <h3 style="font-size: 1.1rem; margin-bottom: 1.5rem;">Tinggalkan Komentar</h3>
                                <form id="comment-submit-form">
                                    <div class="form-row">
                                        <div class="form-group">
                                            <label for="comment-name">Nama*</label>
                                            <input type="text" id="comment-name" name="name" required />
                                        </div>
                                        <div class="form-group">
                                            <label for="comment-email">Email*</label>
                                            <input type="email" id="comment-email" name="email" required />
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="comment-content">Komentar*</label>
                                        <textarea id="comment-content" name="content" required></textarea>
                                    </div>
                                    <button type="submit" class="btn btn-primary" style="margin-bottom: 1rem;">
                                        <i class="fas fa-paper-plane"></i> Kirim Komentar
                                    </button>
                                    <div id="comment-message" style="display: none; padding: 12px 15px; border-radius: 8px;"></div>
                                </form>
                            </div>
                        </div>
                        
                        <div class="blog-detail-footer">
                            <div>
                                <strong>Bagikan:</strong>
                                <a href="https://www.facebook.com/sharer/sharer.php?u=${window.location.href}" target="_blank" style="margin-left: 1rem;">
                                    <i class="fab fa-facebook"></i>
                                </a>
                                <a href="https://twitter.com/intent/tweet?url=${window.location.href}&text=${article.title}" target="_blank" style="margin-left: 0.5rem;">
                                    <i class="fab fa-twitter"></i>
                                </a>
                                <a href="https://wa.me/?text=${article.title} ${window.location.href}" target="_blank" style="margin-left: 0.5rem;">
                                    <i class="fab fa-whatsapp"></i>
                                </a>
                            </div>
                            <a href="../blog.html" class="btn btn-primary">
                                <i class="fas fa-arrow-left"></i> Kembali ke Blog
                            </a>
                        </div>
                    `;
                    
                    document.getElementById('article-container').innerHTML = html;
                    
                    // Load comments
                    loadComments(article.id);
                    
                    // Handle comment form submission
                    document.getElementById('comment-submit-form').addEventListener('submit', function(e) {
                        e.preventDefault();
                        
                        const formData = new FormData();
                        formData.append('article_id', article.id);
                        formData.append('name', document.getElementById('comment-name').value);
                        formData.append('email', document.getElementById('comment-email').value);
                        formData.append('content', document.getElementById('comment-content').value);
                        
                        fetch('../api/comments.php', {
                            method: 'POST',
                            body: formData
                        })
                        .then(response => response.json())
                        .then(result => {
                            const messageDiv = document.getElementById('comment-message');
                            messageDiv.style.display = 'block';
                            
                            if (result.success) {
                                messageDiv.style.backgroundColor = 'rgba(40, 167, 69, 0.1)';
                                messageDiv.style.color = '#28a745';
                                messageDiv.innerHTML = '<i class="fas fa-check-circle"></i> ' + result.message;
                                document.getElementById('comment-submit-form').reset();
                                
                                // Reload comments after 2 seconds
                                setTimeout(() => loadComments(article.id), 2000);
                            } else {
                                messageDiv.style.backgroundColor = 'rgba(220, 53, 69, 0.1)';
                                messageDiv.style.color = '#dc3545';
                                messageDiv.innerHTML = '<i class="fas fa-exclamation-circle"></i> ' + result.message;
                            }
                        })
                        .catch(error => {
                            const messageDiv = document.getElementById('comment-message');
                            messageDiv.style.display = 'block';
                            messageDiv.style.backgroundColor = 'rgba(220, 53, 69, 0.1)';
                            messageDiv.style.color = '#dc3545';
                            messageDiv.innerHTML = '<i class="fas fa-exclamation-circle"></i> Gagal mengirim komentar: ' + error.message;
                            console.error('Comment submission error:', error);
                        });
                    });
                } else {
                    const errorMsg = result.message || 'Artikel tidak ditemukan';
                    document.getElementById('article-container').innerHTML = '<p style="text-align: center; color: #999;">❌ ' + errorMsg + '</p>';
                }
            })
            .catch(error => {
                console.error('Fetch error:', error);
                document.getElementById('article-container').innerHTML = `
                    <div style="text-align: center; color: #999; padding: 2rem;">
                        <h2>❌ Gagal memuat artikel</h2>
                        <p>${error.message}</p>
                        <p style="font-size: 0.9rem; margin-top: 1rem;">
                            Kemungkinan penyebab:
                            <br>- Database belum di-setup
                            <br>- Artikel belum dibuat
                            <br>- Server error (cek admin/error.log)
                        </p>
                        <p style="margin-top: 1rem;">
                            <a href="../admin/setup.php" style="color: #569ae3;">Setup Database</a> | 
                            <a href="../blog.html" style="color: #569ae3;">Kembali ke Blog</a>
                        </p>
                    </div>
                `;
            });
        
        function loadComments(articleId) {
            fetch(`../api/comments.php?article_id=${articleId}`)
                .then(response => response.json())
                .then(result => {
                    const commentsList = document.getElementById('comments-list');
                    const commentCount = document.getElementById('comments-count');
                    
                    if (result.success && result.data && result.data.length > 0) {
                        commentCount.textContent = result.data.length;
                        commentsList.innerHTML = result.data.map(comment => {
                            return '<div class="comment-card">' +
                                '<div class="comment-header">' +
                                '<strong class="comment-author">' + comment.name + '</strong>' +
                                '<span class="comment-date">' + comment.date + '</span>' +
                                '</div>' +
                                '<div class="comment-content">' + comment.content + '</div>' +
                                '</div>';
                        }).join('');
                    } else {
                        commentCount.textContent = '0';
                        commentsList.innerHTML = '<p style="color: #999;">Belum ada komentar. Jadilah yang pertama!</p>';
                    }
                })
                .catch(error => {
                    console.error('Error loading comments:', error);
                    document.getElementById('comments-list').innerHTML = '<p style="color: #999;">Tidak bisa memuat komentar</p>';
                });
        }
    </script>
</body>
</html>

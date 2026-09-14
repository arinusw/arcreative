// Blog Data Storage
const BLOG_STORAGE_KEY = 'arcreative_blog_posts';
const CATEGORIES_STORAGE_KEY = 'arcreative_categories';

// Default Categories with Colors
const defaultCategories = [
    { id: 'tutorial-design', name: 'Tutorial Design', color: '#ff6b35' },
    { id: 'tutorial-web', name: 'Tutorial Web Dev', color: '#6b35ff' },
    { id: 'tutorial-ms', name: 'Tutorial Microsoft', color: '#35b8ff' },
    { id: 'edukasi', name: 'Edukasi Digitalisasi', color: '#35ff6b' },
    { id: 'teknologi', name: 'Update Teknologi', color: '#ffb335' },
    { id: 'tutorial-komputer', name: 'Tutorial Instalasi Komputer', color: '#ff35b8' },
    { id: 'tutorial-teknis', name: 'Tutorial Teknisi Komputer', color: '#35ffb8' },
    { id: 'management-konten', name: 'Management Konten', color: '#ff6b9d' }
];

// Sample Blog Posts
const samplePosts = [
    {
        id: Date.now() - 10000,
        title: 'Panduan Lengkap Memulai Desain Grafis untuk Pemula',
        category: 'tutorial-design',
        excerpt: 'Belajar dasar-dasar desain grafis dari nol. Panduan ini akan membimbing Anda mengenal tools, prinsip desain, dan best practices.',
        content: 'Desain grafis adalah seni visual yang menggabungkan tipografi, gambar, dan elemen visual lainnya untuk menyampaikan pesan. Dalam panduan ini, kami akan membahas:\n\n1. **Tools Dasar Desain**\n- Adobe Photoshop\n- Adobe Illustrator\n- CorelDraw\n- Figma\n\n2. **Prinsip-Prinsip Desain**\n- Komposisi\n- Warna dan Harmoni\n- Tipografi\n- Whitespace\n\n3. **Membuat Karya Pertama Anda**\n- Logo sederhana\n- Poster\n- Banner\n\n4. **Tips dan Trik**\n- Jangan takut bereksperimen\n- Pelajari dari desainer lain\n- Practice makes perfect\n\n5. **Resource Pembelajaran**\n- Udemy\n- Skillshare\n- YouTube Tutorial\n- Design Websites',
        image: 'img/placeholder-work.jpg',
        author: 'Arinus Wantik',
        date: new Date(Date.now() - 432000000).toISOString(),
        readTime: 8,
        tags: ['design', 'pemula', 'tutorial']
    },
    {
        id: Date.now() - 20000,
        title: '6 Tips Membuat Website yang SEO Friendly dan Cepat',
        category: 'tutorial-web',
        excerpt: 'Tingkatkan kualitas website Anda dengan tips SEO dan optimasi kecepatan loading. Pelajari strategi terbaik untuk ranking lebih tinggi.',
        content: 'Website yang cepat dan SEO-friendly adalah kunci kesuksesan online. Berikut adalah 6 tips penting:\n\n**Tip 1: Optimasi Kecepatan Loading**\n- Kompresi gambar\n- Minify CSS dan JavaScript\n- Gunakan CDN\n- Caching yang tepat\n\n**Tip 2: Mobile Responsive**\n- Design responsive sejak awal\n- Test di berbagai device\n- Perhatikan viewport\n\n**Tip 3: SEO On-Page**\n- Keyword research\n- Meta tags yang tepat\n- Heading structure\n- Internal linking\n\n**Tip 4: Content Quality**\n- Konten original\n- Informatif dan berguna\n- Update secara berkala\n\n**Tip 5: Backlink Strategy**\n- Guest posting\n- Resource pages\n- Broken link building\n\n**Tip 6: Analytics Monitoring**\n- Setup Google Analytics\n- Monitor traffic\n- Adjust strategy',
        image: 'img/placeholder-web.jpeg',
        author: 'Arinus Wantik',
        date: new Date(Date.now() - 345600000).toISOString(),
        readTime: 10,
        tags: ['web', 'seo', 'performance']
    },
    {
        id: Date.now() - 30000,
        title: 'Troubleshooting Komputer: Solusi Error Umum dan Cepat',
        category: 'tutorial-teknis',
        excerpt: 'Mengatasi masalah komputer dengan cepat dan efisien. Panduan troubleshooting untuk error-error umum yang sering terjadi.',
        content: 'Komputer mengalami masalah? Jangan panik! Berikut solusi untuk error-error umum:\n\n**ERROR: Blue Screen of Death (BSOD)**\n- Restart komputer\n- Update driver\n- Scan malware\n- Cek hard drive\n\n**ERROR: Program Not Responding**\n- Tutup program paksa\n- Update software\n- Bersihkan temp files\n\n**ERROR: Internet Connection Error**\n- Restart router\n- Update network driver\n- Cek kabel network\n- Reset network settings\n\n**ERROR: Slow Performance**\n- Hapus program tidak perlu\n- Disable startup programs\n- Upgrade RAM\n- Gunakan SSD\n\n**ERROR: Sistem Restart Tiba-tiba**\n- Cek suhu CPU\n- Update BIOS\n- Cek power supply\n- Scan virus\n\n**Preventive Maintenance**\n- Regular update\n- Antivirus protection\n- Backup penting\n- Disk cleanup',
        image: 'img/placeholder-work.jpg',
        author: 'Arinus Wantik',
        date: new Date(Date.now() - 259200000).toISOString(),
        readTime: 7,
        tags: ['komputer', 'troubleshooting', 'tips']
    }
];

// Initialize Blog
document.addEventListener('DOMContentLoaded', function() {
    initializeBlogCategories();
    loadBlogPosts();
    setupCategoryFilters();
    setupSearch();
});

// Initialize Categories
function initializeBlogCategories() {
    const stored = localStorage.getItem(CATEGORIES_STORAGE_KEY);
    if (!stored) {
        localStorage.setItem(CATEGORIES_STORAGE_KEY, JSON.stringify(defaultCategories));
    }
}

// Get All Categories
function getBlogCategories() {
    const stored = localStorage.getItem(CATEGORIES_STORAGE_KEY);
    return stored ? JSON.parse(stored) : defaultCategories;
}

// Get Blog Posts
function getBlogPosts() {
    let stored = localStorage.getItem(BLOG_STORAGE_KEY);
    if (!stored) {
        localStorage.setItem(BLOG_STORAGE_KEY, JSON.stringify(samplePosts));
        stored = JSON.stringify(samplePosts);
    }
    return JSON.parse(stored);
}

// Load Blog Posts
function loadBlogPosts(category = 'all', searchQuery = '') {
    let posts = getBlogPosts();

    // Filter by category
    if (category !== 'all') {
        posts = posts.filter(post => post.category === category);
    }

    // Filter by search
    if (searchQuery.trim()) {
        const query = searchQuery.toLowerCase();
        posts = posts.filter(post => 
            post.title.toLowerCase().includes(query) ||
            post.excerpt.toLowerCase().includes(query) ||
            post.content.toLowerCase().includes(query)
        );
    }

    // Sort by date (newest first)
    posts.sort((a, b) => new Date(b.date) - new Date(a.date));

    displayBlogPosts(posts, category, searchQuery);
}

// Display Blog Posts
function displayBlogPosts(posts, category, searchQuery) {
    const blogGrid = document.getElementById('blogGrid');
    const postsLoading = document.getElementById('postsLoading');
    const postsEmpty = document.getElementById('postsEmpty');

    postsLoading.style.display = 'none';

    if (posts.length === 0) {
        blogGrid.innerHTML = '';
        postsEmpty.style.display = 'block';
        document.getElementById('blogPagination').innerHTML = '';
        return;
    }

    postsEmpty.style.display = 'none';

    const categories = getBlogCategories();
    blogGrid.innerHTML = posts.map(post => {
        const cat = categories.find(c => c.id === post.category);
        const catName = cat ? cat.name : 'Uncategorized';
        const catColor = cat ? cat.color : '#ff6b35';
        const postDate = new Date(post.date).toLocaleDateString('id-ID', {
            year: 'numeric',
            month: 'long',
            day: 'numeric'
        });

        return `
            <article class="blog-card">
                <div class="blog-image">
                    <img src="${post.image}" alt="${post.title}" onerror="this.src='img/placeholder-work.jpg'">
                    <div class="blog-overlay">
                        <span class="category-badge" style="background: ${catColor}">${catName}</span>
                    </div>
                </div>
                <div class="blog-content">
                    <h3 class="blog-title">${post.title}</h3>
                    <p class="blog-excerpt">${post.excerpt}</p>
                    <div class="blog-meta">
                        <span class="meta-item">
                            <i class="fas fa-calendar"></i> ${postDate}
                        </span>
                        <span class="meta-item">
                            <i class="fas fa-clock"></i> ${post.readTime} min
                        </span>
                    </div>
                    <button class="btn btn-secondary" onclick="openBlogModal(${post.id})">
                        Lihat Selengkapnya <i class="fas fa-arrow-right"></i>
                    </button>
                </div>
            </article>
        `;
    }).join('');
}

// Open Blog Modal
function openBlogModal(postId) {
    const posts = getBlogPosts();
    const post = posts.find(p => p.id === postId);
    if (!post) return;

    const categories = getBlogCategories();
    const category = categories.find(c => c.id === post.category);
    const catColor = category ? category.color : '#ff6b35';
    const catName = category ? category.name : 'Uncategorized';
    const postDate = new Date(post.date).toLocaleDateString('id-ID', {
        year: 'numeric',
        month: 'long',
        day: 'numeric'
    });

    const content = post.content.split('\n').map(para => {
        if (para.trim()) {
            return `<p>${para.replace(/\*\*(.+?)\*\*/g, '<strong>$1</strong>').replace(/- /g, '• ')}</p>`;
        }
        return '';
    }).join('');

    const modal = document.createElement('div');
    modal.className = 'blog-modal active';
    modal.id = 'blogModal';
    modal.innerHTML = `
        <div class="modal-overlay" onclick="closeBlogModal()"></div>
        <div class="modal-dialog">
            <button class="modal-close" onclick="closeBlogModal()">&times;</button>
            <div class="modal-header">
                <img src="${post.image}" alt="${post.title}" class="modal-image" onerror="this.src='img/placeholder-work.jpg'">
            </div>
            <div class="modal-body">
                <div class="modal-category" style="background: ${catColor}">${catName}</div>
                <h2 class="modal-title">${post.title}</h2>
                <div class="modal-meta">
                    <span><i class="fas fa-user"></i> ${post.author}</span>
                    <span><i class="fas fa-calendar"></i> ${postDate}</span>
                    <span><i class="fas fa-clock"></i> ${post.readTime} min baca</span>
                </div>
                <div class="modal-content">
                    ${content}
                </div>
                <div class="modal-tags">
                    ${post.tags.map(tag => `<span class="tag">#${tag}</span>`).join('')}
                </div>
            </div>
        </div>
    `;

    document.body.appendChild(modal);
    document.body.style.overflow = 'hidden';
}

// Close Blog Modal
function closeBlogModal() {
    const modal = document.getElementById('blogModal');
    if (modal) {
        modal.remove();
        document.body.style.overflow = 'auto';
    }
}

// Setup Category Filters
function setupCategoryFilters() {
    const categoryLinks = document.querySelectorAll('.category-link');
    categoryLinks.forEach(link => {
        link.addEventListener('click', function(e) {
            e.preventDefault();
            document.querySelectorAll('.category-link').forEach(l => l.classList.remove('active'));
            this.classList.add('active');
            const category = this.dataset.category;
            loadBlogPosts(category);
        });
    });
}

// Setup Search
function setupSearch() {
    const searchInput = document.getElementById('searchBlog');
    const searchBtn = document.querySelector('.search-btn');
    if (searchInput) {
        searchInput.addEventListener('keyup', function() {
            loadBlogPosts('all', this.value);
        });
        if (searchBtn) {
            searchBtn.addEventListener('click', function() {
                loadBlogPosts('all', searchInput.value);
            });
        }
    }
}

// Clear Filter
function clearFilter(e) {
    e.preventDefault();
    document.querySelectorAll('.category-link').forEach(l => l.classList.remove('active'));
    document.querySelector('[data-category="all"]').classList.add('active');
    loadBlogPosts('all');
}

// Add CSS for Blog Modal
const blogModalStyle = document.createElement('style');
blogModalStyle.textContent = `
    .blog-modal {
        display: none;
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        z-index: 2000;
        animation: modalFade 0.3s ease;
    }

    .blog-modal.active {
        display: flex;
        align-items: center;
        justify-content: center;
    }

    @keyframes modalFade {
        from { opacity: 0; }
        to { opacity: 1; }
    }

    .modal-overlay {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(0, 0, 0, 0.7);
    }

    .modal-dialog {
        position: relative;
        background: #141923;
        border-radius: 10px;
        max-width: 700px;
        max-height: 90vh;
        overflow-y: auto;
        box-shadow: 0 10px 40px rgba(0, 0, 0, 0.5);
        animation: slideUp 0.3s ease;
    }

    @keyframes slideUp {
        from { transform: translateY(50px); opacity: 0; }
        to { transform: translateY(0); opacity: 1; }
    }

    .modal-close {
        position: absolute;
        top: 20px;
        right: 20px;
        width: 40px;
        height: 40px;
        border: none;
        background: rgba(255, 107, 53, 0.2);
        color: #ff6b35;
        font-size: 28px;
        border-radius: 50%;
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: all 0.3s;
        z-index: 10;
    }

    .modal-close:hover {
        background: rgba(255, 107, 53, 0.4);
        transform: rotate(90deg);
    }

    .modal-header {
        position: relative;
        height: 300px;
        overflow: hidden;
        border-radius: 10px 10px 0 0;
    }

    .modal-image {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .modal-body {
        padding: 30px;
    }

    .modal-category {
        display: inline-block;
        padding: 8px 15px;
        border-radius: 20px;
        color: white;
        font-weight: 600;
        font-size: 12px;
        margin-bottom: 15px;
    }

    .modal-title {
        font-size: 28px;
        color: #fff;
        margin-bottom: 15px;
        line-height: 1.3;
    }

    .modal-meta {
        display: flex;
        gap: 20px;
        margin-bottom: 25px;
        color: #999;
        font-size: 14px;
        flex-wrap: wrap;
    }

    .modal-meta span {
        display: flex;
        align-items: center;
        gap: 5px;
    }

    .modal-meta i {
        color: #ff6b35;
    }

    .modal-content {
        color: #ddd;
        line-height: 1.8;
        margin-bottom: 25px;
        font-size: 15px;
    }

    .modal-content p {
        margin-bottom: 15px;
    }

    .modal-content strong {
        color: #ff6b35;
    }

    .modal-tags {
        display: flex;
        flex-wrap: wrap;
        gap: 10px;
    }

    .tag {
        display: inline-block;
        padding: 6px 12px;
        background: rgba(255, 107, 53, 0.1);
        color: #ff6b35;
        border-radius: 15px;
        font-size: 12px;
        border: 1px solid rgba(255, 107, 53, 0.3);
    }

    @media (max-width: 768px) {
        .modal-dialog {
            max-width: 95vw;
            max-height: 95vh;
            border-radius: 10px;
        }

        .modal-header {
            height: 200px;
        }

        .modal-body {
            padding: 20px;
        }

        .modal-title {
            font-size: 20px;
        }

        .modal-meta {
            gap: 10px;
        }
    }
`;
document.head.appendChild(blogModalStyle);

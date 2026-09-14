// Portfolio Manager - Load posts from localStorage to display

const POSTS_STORAGE_KEY = 'arcreative_posts';

// Get all posts
function getPosts() {
    const postsJSON = localStorage.getItem(POSTS_STORAGE_KEY);
    return postsJSON ? JSON.parse(postsJSON) : [];
}

// Get latest posts
function getLatestPosts(limit = 3) {
    const posts = getPosts();
    return posts.slice(0, limit);
}

// Filter posts by category
function getPostsByCategory(category) {
    const posts = getPosts();
    return posts.filter(post => post.category === category);
}

// Portfolio Modal Data
const portfolioData = {
    design: {
        1: {
            id: 1,
            title: 'Logo Perusahaan',
            category: 'design',
            description: 'Desain Grafis',
            image: 'img/placeholder-work.jpg',
            content: 'Professional logo design untuk perusahaan modern. Menggunakan konsep yang minimalis namun memorable dengan kombinasi warna yang tepat untuk branding.',
            tags: ['Logo', 'Branding', 'Design']
        },
        3: {
            id: 3,
            title: 'Banner Promosi',
            category: 'design',
            description: 'Desain Grafis',
            image: 'img/placeholder-banerdesign.jpg',
            content: 'Banner promosi berkualitas tinggi untuk kampanye pemasaran digital. Dirancang dengan prinsip visual hierarchy yang baik dan eye-catching design.',
            tags: ['Banner', 'Promosi', 'Digital']
        }
    },
    web: {
        2: {
            id: 2,
            title: 'Web Profesional',
            category: 'web',
            description: 'Web Development',
            image: 'img/placeholder-web.jpeg',
            content: 'Website profesional dengan design responsif dan user experience yang optimal. Dibangun menggunakan teknologi terkini dengan performance yang cepat.',
            tags: ['Website', 'Web Design', 'Development']
        },
        4: {
            id: 4,
            title: 'Web Portofolio Client',
            category: 'web',
            description: 'Web Development',
            image: 'img/placeholder-webfortofolio.jpeg',
            content: 'Portfolio website untuk showcase karya dan keahlian. Fitur lengkap dengan galeri, blog, dan contact form yang terintegrasi.',
            tags: ['Portfolio', 'Website', 'Development']
        }
    }
};

// Initialize portfolio on page load
document.addEventListener('DOMContentLoaded', function() {
    loadPortfolioItems();
    updateLatestPostsInHome();
    setupPortfolioModal();
});

// Load portfolio items from localStorage
function loadPortfolioItems() {
    const posts = getPosts();
    const portfolioGrid = document.querySelector('.portfolio-grid');

    if (!portfolioGrid) return;

    // Keep default items
    let html = '';

    // Add posts from localStorage
    posts.forEach((post, index) => {
        html += `
            <div class="portfolio-item" data-category="${post.category}" data-project-id="${post.id}">
                <div class="portfolio-image">
                    <img src="${post.image}" alt="${post.title}" onerror="this.src='img/placeholder-work.jpg'">
                    <div class="portfolio-overlay">
                        <h4>${post.title}</h4>
                        <p>${post.category === 'design' ? 'Graphic Design' : 'Web Development'}</p>
                        <button class="portfolio-btn" onclick="openPortfolioModal(${post.id})">View Details</button>
                    </div>
                </div>
            </div>
        `;
    });

    if (posts.length > 0) {
        portfolioGrid.innerHTML = html;
    }
}

// Setup portfolio modal
function setupPortfolioModal() {
    const modal = document.getElementById('portfolioModal');
    const closeBtn = document.querySelector('.modal-close');
    const closeModalBtn = document.getElementById('closeModalBtn');

    if (closeBtn) closeBtn.addEventListener('click', closePortfolioModal);
    if (closeModalBtn) closeModalBtn.addEventListener('click', closePortfolioModal);

    // Close modal when clicking outside
    if (modal) {
        modal.addEventListener('click', function(e) {
            if (e.target === modal) closePortfolioModal();
        });
    }

    // Add click listener to portfolio buttons
    document.addEventListener('click', function(e) {
        if (e.target.classList.contains('portfolio-btn')) {
            const projectId = e.target.closest('.portfolio-item')?.getAttribute('data-project-id');
            if (projectId) {
                openPortfolioModal(projectId);
            }
        }
    });
}

// Open portfolio modal
function openPortfolioModal(projectId) {
    const posts = getPosts();
    const post = posts.find(p => p.id == projectId);

    if (!post) return;

    const modal = document.getElementById('portfolioModal');
    if (!modal) return;

    document.getElementById('modalImage').src = post.image;
    document.getElementById('modalImage').onerror = function() { this.src = 'img/placeholder-work.jpg'; };
    document.getElementById('modalTitle').textContent = post.title;
    document.getElementById('modalCategory').textContent = post.category === 'design' ? 'Graphic Design' : 'Web Development';
    document.getElementById('modalDescription').textContent = post.content;

    // Tags
    const tagsContainer = document.getElementById('modalTags');
    if (tagsContainer) {
        tagsContainer.innerHTML = post.tags.map(tag => 
            `<span class="modal-tag">${tag}</span>`
        ).join('');
    }

    modal.style.display = 'flex';
}

// Close portfolio modal
function closePortfolioModal() {
    const modal = document.getElementById('portfolioModal');
    if (modal) modal.style.display = 'none';
}

// Update latest posts in home/about sections
function updateLatestPostsInHome() {
    const posts = getLatestPosts(3);

    if (posts.length === 0) return;

    // Add latest posts section if needed
    const aboutSection = document.getElementById('about');
    if (aboutSection && !document.getElementById('latestPostsContainer')) {
        const latestPostsHTML = `
            <section id="latest-posts" class="latest-posts">
                <div class="container">
                    <div class="section-header">
                        <h2>Latest <span class="text-orange">Works</span></h2>
                    </div>
                    <div class="latest-posts-grid" id="latestPostsContainer">
                        <!-- Will be populated by JavaScript -->
                    </div>
                </div>
            </section>
        `;

        // Insert after about section
        aboutSection.insertAdjacentHTML('afterend', latestPostsHTML);
        populateLatestPosts();
    }
}

// Populate latest posts
function populateLatestPosts() {
    const container = document.getElementById('latestPostsContainer');
    if (!container) return;

    const posts = getLatestPosts(3);

    const html = posts.map(post => `
        <div class="latest-post-card">
            <div class="post-image">
                <img src="${post.image}" alt="${post.title}" onerror="this.src='img/placeholder-work.jpg'">
                <div class="post-overlay">
                    <button class="btn btn-primary" onclick="openPortfolioModal(${post.id})">
                        <i class="fas fa-eye"></i> View
                    </button>
                </div>
            </div>
            <div class="post-info">
                <span class="post-category">${post.category === 'design' ? 'Design' : 'Web'}</span>
                <h3>${post.title}</h3>
                <p>${post.description}</p>
            </div>
        </div>
    `).join('');

    container.innerHTML = html;
}

// Add modal tag styles
const modalTagStyle = document.createElement('style');
modalTagStyle.textContent = `
    .modal-tag {
        display: inline-block;
        padding: 5px 12px;
        background: rgba(255, 107, 53, 0.1);
        color: #ff6b35;
        border-radius: 20px;
        font-size: 12px;
        margin: 5px 5px 5px 0;
        font-weight: 600;
    }

    .latest-posts {
        padding: 60px 0;
        background: linear-gradient(135deg, #0f1419 0%, #1a1f2e 100%);
        border-top: 1px solid rgba(255, 107, 53, 0.1);
        border-bottom: 1px solid rgba(255, 107, 53, 0.1);
    }

    .latest-posts-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
        gap: 20px;
    }

    .latest-post-card {
        background: rgba(20, 25, 35, 0.5);
        border: 1px solid rgba(255, 107, 53, 0.2);
        border-radius: 8px;
        overflow: hidden;
        transition: all 0.3s;
    }

    .latest-post-card:hover {
        border-color: rgba(255, 107, 53, 0.5);
        transform: translateY(-5px);
    }

    .post-image {
        position: relative;
        overflow: hidden;
        height: 200px;
    }

    .post-image img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.3s;
    }

    .latest-post-card:hover .post-image img {
        transform: scale(1.1);
    }

    .post-overlay {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(0, 0, 0, 0.7);
        display: flex;
        align-items: center;
        justify-content: center;
        opacity: 0;
        transition: opacity 0.3s;
    }

    .latest-post-card:hover .post-overlay {
        opacity: 1;
    }

    .post-info {
        padding: 20px;
    }

    .post-category {
        display: inline-block;
        padding: 4px 8px;
        background: rgba(255, 107, 53, 0.2);
        color: #ff6b35;
        border-radius: 3px;
        font-size: 12px;
        font-weight: 600;
        margin-bottom: 10px;
    }

    .post-info h3 {
        margin: 10px 0;
        color: #fff;
        font-size: 16px;
    }

    .post-info p {
        color: #999;
        font-size: 13px;
        line-height: 1.5;
    }

    @media (max-width: 768px) {
        .latest-posts-grid {
            grid-template-columns: 1fr;
        }
    }
`;
document.head.appendChild(modalTagStyle);

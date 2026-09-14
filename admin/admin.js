// Storage keys
const POSTS_STORAGE_KEY = 'arcreative_posts';
const BLOG_STORAGE_KEY = 'arcreative_blog_posts';
const CATEGORIES_STORAGE_KEY = 'arcreative_categories';

// Default Categories
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

// Check if user is logged in
function checkAuth() {
    if (sessionStorage.getItem('adminLoggedIn') !== 'true') {
        window.location.href = 'login.html';
    } else {
        document.getElementById('userDisplay').textContent = sessionStorage.getItem('adminUsername') || 'Admin';
    }
}

// Initialize on page load
document.addEventListener('DOMContentLoaded', function() {
    checkAuth();
    initializeCategories();
    loadPortfolioPosts();
    loadBlogPosts();
    setupBlogCategorySelect();
    setupEventListeners();
});

// Initialize categories
function initializeCategories() {
    const stored = localStorage.getItem(CATEGORIES_STORAGE_KEY);
    if (!stored) {
        localStorage.setItem(CATEGORIES_STORAGE_KEY, JSON.stringify(defaultCategories));
    }
}

// Get categories
function getCategories() {
    const stored = localStorage.getItem(CATEGORIES_STORAGE_KEY);
    return stored ? JSON.parse(stored) : defaultCategories;
}

// Setup event listeners
function setupEventListeners() {
    // Menu items
    document.querySelectorAll('.menu-item').forEach(item => {
        item.addEventListener('click', function(e) {
            const section = this.getAttribute('data-section');
            if (section && section !== 'logout') {
                e.preventDefault();
                switchSection(e, section);
            }
        });
    });

    // Logout buttons
    document.getElementById('logoutBtn').addEventListener('click', logout);
    document.getElementById('logoutBtn2').addEventListener('click', logout);

    // Portfolio post form
    document.getElementById('postForm').addEventListener('submit', savePortfolioPost);

    // Blog post form
    document.getElementById('blogForm').addEventListener('submit', saveBlogPost);

    // Sidebar toggle for mobile
    document.getElementById('sidebarToggle')?.addEventListener('click', toggleSidebar);

    // Color picker
    const colorInput = document.getElementById('categoryColor');
    const colorHex = document.getElementById('categoryColorHex');
    if (colorInput) {
        colorInput.addEventListener('change', function() {
            colorHex.value = this.value;
        });
    }
}

// Switch between sections
function switchSection(e, section) {
    if (e) e.preventDefault();

    // Hide all sections
    document.querySelectorAll('.content-section').forEach(s => {
        s.classList.remove('active');
    });

    // Remove active from menu items
    document.querySelectorAll('.menu-item').forEach(item => {
        item.classList.remove('active');
    });

    // Show selected section
    const sectionId = section + '-section';
    document.getElementById(sectionId)?.classList.add('active');

    // Mark menu item as active
    document.querySelector(`[data-section="${section}"]`)?.classList.add('active');

    // Special handlers
    if (section === 'add-post') {
        resetPortfolioForm();
        document.getElementById('formTitle').textContent = 'Add New Portfolio Post';
        document.getElementById('submitBtn').textContent = 'Create Post';
    }

    if (section === 'add-blog') {
        resetBlogForm();
        document.getElementById('blogFormTitle').textContent = 'Add New Blog Post';
        document.getElementById('blogSubmitBtn').textContent = 'Create Blog Post';
    }

    if (section === 'categories') {
        loadCategoriesUI();
    }

    // Hide sidebar on mobile
    if (window.innerWidth <= 768) {
        document.querySelector('.sidebar').classList.remove('active');
    }
}

// Toggle sidebar on mobile
function toggleSidebar() {
    document.querySelector('.sidebar').classList.toggle('active');
}

// ==================== PORTFOLIO POSTS ====================

// Load portfolio posts
function loadPortfolioPosts() {
    const postsJSON = localStorage.getItem(POSTS_STORAGE_KEY);
    const posts = postsJSON ? JSON.parse(postsJSON) : [];

    const tableBody = document.getElementById('postsTableBody');
    const emptyMessage = document.getElementById('emptyPostsMessage');

    if (posts.length === 0) {
        tableBody.innerHTML = '';
        emptyMessage.style.display = 'block';
        return;
    }

    emptyMessage.style.display = 'none';
    tableBody.innerHTML = posts.map((post, index) => `
        <tr>
            <td><strong>${post.title}</strong></td>
            <td><span class="category-badge">${post.category === 'design' ? 'Graphic Design' : 'Web Development'}</span></td>
            <td>${new Date(post.date).toLocaleDateString('id-ID')}</td>
            <td><span class="status published">Published</span></td>
            <td>
                <div class="table-actions">
                    <button class="btn btn-edit" onclick="editPortfolioPost(${index})">
                        <i class="fas fa-edit"></i> Edit
                    </button>
                    <button class="btn btn-delete" onclick="confirmDeletePortfolio(${index}, '${post.title}')">
                        <i class="fas fa-trash"></i> Delete
                    </button>
                </div>
            </td>
        </tr>
    `).join('');
}

// Save portfolio post
function savePortfolioPost(e) {
    e.preventDefault();

    const postsJSON = localStorage.getItem(POSTS_STORAGE_KEY);
    const posts = postsJSON ? JSON.parse(postsJSON) : [];

    const newPost = {
        id: Date.now(),
        title: document.getElementById('postTitle').value,
        category: document.getElementById('postCategory').value,
        description: document.getElementById('postDescription').value,
        content: document.getElementById('postContent').value,
        image: document.getElementById('postImage').value,
        tags: document.getElementById('postTags').value.split(',').map(tag => tag.trim()).filter(tag => tag),
        date: new Date().toISOString()
    };

    const editingId = document.getElementById('submitBtn').getAttribute('data-edit-id');
    if (editingId) {
        const index = posts.findIndex(p => p.id == editingId);
        if (index !== -1) {
            posts[index] = { ...posts[index], ...newPost };
        }
        document.getElementById('submitBtn').removeAttribute('data-edit-id');
    } else {
        posts.unshift(newPost);
    }

    localStorage.setItem(POSTS_STORAGE_KEY, JSON.stringify(posts));

    alert('Portfolio post saved successfully!');
    resetPortfolioForm();
    loadPortfolioPosts();
    switchSection(null, 'posts');
}

// Edit portfolio post
function editPortfolioPost(index) {
    const postsJSON = localStorage.getItem(POSTS_STORAGE_KEY);
    const posts = postsJSON ? JSON.parse(postsJSON) : [];
    const post = posts[index];

    if (!post) return;

    document.getElementById('postTitle').value = post.title;
    document.getElementById('postCategory').value = post.category;
    document.getElementById('postDescription').value = post.description;
    document.getElementById('postContent').value = post.content;
    document.getElementById('postImage').value = post.image;
    document.getElementById('postTags').value = post.tags.join(', ');

    document.getElementById('formTitle').textContent = 'Edit Portfolio Post';
    document.getElementById('submitBtn').textContent = 'Update Post';
    document.getElementById('submitBtn').setAttribute('data-edit-id', post.id);

    switchSection(null, 'add-post');
}

// Confirm delete portfolio
function confirmDeletePortfolio(index, title) {
    const modal = document.getElementById('deleteModal');
    document.getElementById('deleteMessage').textContent = `Are you sure you want to delete "${title}"?`;
    document.getElementById('confirmDeleteBtn').onclick = function() {
        deletePortfolioPost(index);
        closeDeleteModal();
    };
    modal.classList.add('active');
}

// Delete portfolio post
function deletePortfolioPost(index) {
    const postsJSON = localStorage.getItem(POSTS_STORAGE_KEY);
    const posts = postsJSON ? JSON.parse(postsJSON) : [];

    posts.splice(index, 1);
    localStorage.setItem(POSTS_STORAGE_KEY, JSON.stringify(posts));

    loadPortfolioPosts();
    alert('Portfolio post deleted successfully!');
}

// Reset portfolio form
function resetPortfolioForm() {
    document.getElementById('postForm').reset();
    document.getElementById('submitBtn').removeAttribute('data-edit-id');
    document.getElementById('formTitle').textContent = 'Add New Portfolio Post';
    document.getElementById('submitBtn').textContent = 'Create Post';
}

// ==================== BLOG POSTS ====================

// Load blog posts
function loadBlogPosts() {
    const postsJSON = localStorage.getItem(BLOG_STORAGE_KEY);
    const posts = postsJSON ? JSON.parse(postsJSON) : [];

    const tableBody = document.getElementById('blogTableBody');
    const emptyMessage = document.getElementById('emptyBlogMessage');

    if (posts.length === 0) {
        tableBody.innerHTML = '';
        emptyMessage.style.display = 'block';
        return;
    }

    emptyMessage.style.display = 'none';
    const categories = getCategories();
    
    tableBody.innerHTML = posts.map((post, index) => {
        const category = categories.find(c => c.id === post.category);
        const catName = category ? category.name : 'Uncategorized';
        return `
            <tr>
                <td><strong>${post.title}</strong></td>
                <td><span class="category-badge" style="background: ${category?.color || '#ff6b35'}">${catName}</span></td>
                <td>${new Date(post.date).toLocaleDateString('id-ID')}</td>
                <td>${post.readTime} min</td>
                <td>
                    <div class="table-actions">
                        <button class="btn btn-edit" onclick="editBlogPost(${index})">
                            <i class="fas fa-edit"></i> Edit
                        </button>
                        <button class="btn btn-delete" onclick="confirmDeleteBlog(${index}, '${post.title}')">
                            <i class="fas fa-trash"></i> Delete
                        </button>
                    </div>
                </td>
            </tr>
        `;
    }).join('');
}

// Setup blog category select
function setupBlogCategorySelect() {
    const select = document.getElementById('blogCategory');
    if (!select) return;

    const categories = getCategories();
    const options = categories.map(cat => 
        `<option value="${cat.id}">${cat.name}</option>`
    ).join('');

    select.innerHTML = '<option value="">Select category</option>' + options;
}

// Save blog post
function saveBlogPost(e) {
    e.preventDefault();

    const postsJSON = localStorage.getItem(BLOG_STORAGE_KEY);
    const posts = postsJSON ? JSON.parse(postsJSON) : [];

    const newPost = {
        id: Date.now(),
        title: document.getElementById('blogTitle').value,
        category: document.getElementById('blogCategory').value,
        excerpt: document.getElementById('blogExcerpt').value,
        content: document.getElementById('blogContent').value,
        image: document.getElementById('blogImage').value,
        author: document.getElementById('blogAuthor').value || 'Arinus Wantik',
        readTime: parseInt(document.getElementById('blogReadTime').value),
        tags: document.getElementById('blogTags').value.split(',').map(tag => tag.trim()).filter(tag => tag),
        date: new Date().toISOString()
    };

    const editingId = document.getElementById('blogSubmitBtn').getAttribute('data-edit-id');
    if (editingId) {
        const index = posts.findIndex(p => p.id == editingId);
        if (index !== -1) {
            posts[index] = { ...posts[index], ...newPost };
        }
        document.getElementById('blogSubmitBtn').removeAttribute('data-edit-id');
    } else {
        posts.unshift(newPost);
    }

    localStorage.setItem(BLOG_STORAGE_KEY, JSON.stringify(posts));

    alert('Blog post saved successfully!');
    resetBlogForm();
    loadBlogPosts();
    switchSection(null, 'blog');
}

// Edit blog post
function editBlogPost(index) {
    const postsJSON = localStorage.getItem(BLOG_STORAGE_KEY);
    const posts = postsJSON ? JSON.parse(postsJSON) : [];
    const post = posts[index];

    if (!post) return;

    document.getElementById('blogTitle').value = post.title;
    document.getElementById('blogCategory').value = post.category;
    document.getElementById('blogExcerpt').value = post.excerpt;
    document.getElementById('blogContent').value = post.content;
    document.getElementById('blogImage').value = post.image;
    document.getElementById('blogAuthor').value = post.author;
    document.getElementById('blogReadTime').value = post.readTime;
    document.getElementById('blogTags').value = post.tags.join(', ');

    document.getElementById('blogFormTitle').textContent = 'Edit Blog Post';
    document.getElementById('blogSubmitBtn').textContent = 'Update Blog Post';
    document.getElementById('blogSubmitBtn').setAttribute('data-edit-id', post.id);

    switchSection(null, 'add-blog');
}

// Confirm delete blog
function confirmDeleteBlog(index, title) {
    const modal = document.getElementById('deleteModal');
    document.getElementById('deleteMessage').textContent = `Delete blog post "${title}"?`;
    document.getElementById('confirmDeleteBtn').onclick = function() {
        deleteBlogPost(index);
        closeDeleteModal();
    };
    modal.classList.add('active');
}

// Delete blog post
function deleteBlogPost(index) {
    const postsJSON = localStorage.getItem(BLOG_STORAGE_KEY);
    const posts = postsJSON ? JSON.parse(postsJSON) : [];

    posts.splice(index, 1);
    localStorage.setItem(BLOG_STORAGE_KEY, JSON.stringify(posts));

    loadBlogPosts();
    alert('Blog post deleted successfully!');
}

// Reset blog form
function resetBlogForm() {
    document.getElementById('blogForm').reset();
    document.getElementById('blogSubmitBtn').removeAttribute('data-edit-id');
    document.getElementById('blogFormTitle').textContent = 'Add New Blog Post';
    document.getElementById('blogSubmitBtn').textContent = 'Create Blog Post';
}

// ==================== CATEGORY MANAGEMENT ====================

// Load categories UI
function loadCategoriesUI() {
    const categories = getCategories();
    const grid = document.getElementById('categoriesGrid');

    grid.innerHTML = categories.map(cat => `
        <div class="category-card" style="border-left: 4px solid ${cat.color}">
            <div class="category-card-header">
                <div class="category-color-circle" style="background: ${cat.color}"></div>
                <h3>${cat.name}</h3>
            </div>
            <p class="category-id">${cat.id}</p>
            <p class="category-color">${cat.color}</p>
            <div class="category-actions">
                <button class="btn btn-edit btn-sm" onclick="openEditCategoryModal('${cat.id}')">
                    <i class="fas fa-edit"></i> Edit
                </button>
                <button class="btn btn-delete btn-sm" onclick="confirmDeleteCategory('${cat.id}', '${cat.name}')">
                    <i class="fas fa-trash"></i> Delete
                </button>
            </div>
        </div>
    `).join('');
}

// Open add category modal
function openAddCategoryModal() {
    document.getElementById('categoryModalTitle').textContent = 'Add New Category';
    document.getElementById('categoryForm').reset();
    document.getElementById('categoryColor').value = '#ff6b35';
    document.getElementById('categoryColorHex').value = '#ff6b35';
    document.getElementById('categoryForm').setAttribute('data-edit-id', '');
    document.getElementById('categoryModal').classList.add('active');
}

// Open edit category modal
function openEditCategoryModal(categoryId) {
    const categories = getCategories();
    const category = categories.find(c => c.id === categoryId);
    if (!category) return;

    document.getElementById('categoryModalTitle').textContent = 'Edit Category';
    document.getElementById('categoryName').value = category.name;
    document.getElementById('categoryColor').value = category.color;
    document.getElementById('categoryColorHex').value = category.color;
    document.getElementById('categoryForm').setAttribute('data-edit-id', categoryId);
    document.getElementById('categoryModal').classList.add('active');
}

// Close category modal
function closeCategoryModal() {
    document.getElementById('categoryModal').classList.remove('active');
}

// Save category form
function saveCategoryForm(e) {
    e.preventDefault();

    const categories = getCategories();
    const categoryId = document.getElementById('categoryForm').getAttribute('data-edit-id');
    const name = document.getElementById('categoryName').value;
    const color = document.getElementById('categoryColor').value;

    if (categoryId) {
        // Edit
        const index = categories.findIndex(c => c.id === categoryId);
        if (index !== -1) {
            categories[index].name = name;
            categories[index].color = color;
        }
    } else {
        // Add new
        const newId = name.toLowerCase().replace(/\s+/g, '-');
        if (categories.find(c => c.id === newId)) {
            alert('Category ID already exists!');
            return;
        }
        categories.push({
            id: newId,
            name: name,
            color: color
        });
    }

    localStorage.setItem(CATEGORIES_STORAGE_KEY, JSON.stringify(categories));
    alert('Category saved successfully!');
    closeCategoryModal();
    loadCategoriesUI();
    setupBlogCategorySelect();
}

// Confirm delete category
function confirmDeleteCategory(categoryId, categoryName) {
    if (confirm(`Are you sure you want to delete "${categoryName}"?\n\nThis will NOT delete associated blog posts.`)) {
        deleteCategory(categoryId);
    }
}

// Delete category
function deleteCategory(categoryId) {
    const categories = getCategories();
    const index = categories.findIndex(c => c.id === categoryId);
    if (index !== -1) {
        categories.splice(index, 1);
        localStorage.setItem(CATEGORIES_STORAGE_KEY, JSON.stringify(categories));
        alert('Category deleted successfully!');
        loadCategoriesUI();
        setupBlogCategorySelect();
    }
}

// ==================== GENERAL FUNCTIONS ====================

// Close delete modal
function closeDeleteModal() {
    document.getElementById('deleteModal').classList.remove('active');
}

// Logout
function logout(e) {
    if (e) e.preventDefault();
    sessionStorage.clear();
    window.location.href = 'login.html';
}

// Clear all posts
function clearAllPosts() {
    if (confirm('Are you sure? This will delete ALL posts permanently!')) {
        localStorage.removeItem(POSTS_STORAGE_KEY);
        localStorage.removeItem(BLOG_STORAGE_KEY);
        loadPortfolioPosts();
        loadBlogPosts();
        alert('All posts cleared!');
    }
}

// Export data
function exportData() {
    const posts = JSON.parse(localStorage.getItem(POSTS_STORAGE_KEY) || '[]');
    const blogs = JSON.parse(localStorage.getItem(BLOG_STORAGE_KEY) || '[]');
    const categories = JSON.parse(localStorage.getItem(CATEGORIES_STORAGE_KEY) || '[]');

    const data = {
        portfolioPosts: posts,
        blogPosts: blogs,
        categories: categories,
        exportDate: new Date().toISOString()
    };

    const dataStr = JSON.stringify(data, null, 2);
    const dataBlob = new Blob([dataStr], { type: 'application/json' });
    const url = URL.createObjectURL(dataBlob);

    const link = document.createElement('a');
    link.href = url;
    link.download = `arcreative_data_${new Date().toISOString().split('T')[0]}.json`;
    link.click();

    URL.revokeObjectURL(url);
}

// Add styles for category cards
const styles = document.createElement('style');
styles.textContent = `
    .categories-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
        gap: 20px;
        margin-top: 20px;
    }

    .category-card {
        background: var(--card-bg);
        border-radius: 8px;
        padding: 20px;
        border: 1px solid var(--border-color);
        transition: all 0.3s;
    }

    .category-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 5px 15px rgba(255, 107, 53, 0.2);
    }

    .category-card-header {
        display: flex;
        align-items: center;
        gap: 12px;
        margin-bottom: 15px;
    }

    .category-color-circle {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        flex-shrink: 0;
    }

    .category-card-header h3 {
        font-size: 16px;
        color: var(--text-primary);
        margin: 0;
    }

    .category-id,
    .category-color {
        font-size: 12px;
        color: var(--text-muted);
        margin: 5px 0;
        font-family: monospace;
    }

    .category-actions {
        display: flex;
        gap: 8px;
        margin-top: 15px;
    }

    .btn-sm {
        padding: 6px 12px;
        font-size: 12px;
    }

    .color-picker-group {
        display: flex;
        gap: 10px;
        align-items: center;
    }

    .color-picker-group input[type="color"] {
        width: 60px;
        height: 40px;
        border: 1px solid var(--border-color);
        border-radius: 5px;
        cursor: pointer;
    }

    .color-picker-group input[type="text"] {
        flex: 1;
    }
`;
document.head.appendChild(styles);

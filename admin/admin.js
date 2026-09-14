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
    loadPosts();
    setupEventListeners();
});

// Storage key for posts
const POSTS_STORAGE_KEY = 'arcreative_posts';

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

    // Post form
    document.getElementById('postForm').addEventListener('submit', savePost);

    // Sidebar toggle for mobile
    document.getElementById('sidebarToggle')?.addEventListener('click', toggleSidebar);
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

    // Reset form when switching to add-post
    if (section === 'add-post') {
        resetPostForm();
        document.getElementById('formTitle').textContent = 'Add New Post';
        document.getElementById('submitBtn').textContent = 'Create Post';
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

// Load posts from localStorage
function loadPosts() {
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
                    <button class="btn btn-edit" onclick="editPost(${index})">
                        <i class="fas fa-edit"></i> Edit
                    </button>
                    <button class="btn btn-delete" onclick="confirmDelete(${index}, '${post.title}')">
                        <i class="fas fa-trash"></i> Delete
                    </button>
                </div>
            </td>
        </tr>
    `).join('');
}

// Save or update post
function savePost(e) {
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
        tags: document.getElementById('postTags').value.split(',').map(tag => tag.trim()),
        date: new Date().toISOString()
    };

    // Check if editing
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

    // Show success message
    alert('Post saved successfully!');

    // Reset form and go back to posts list
    resetPostForm();
    loadPosts();
    switchSection(null, 'posts');
}

// Edit post
function editPost(index) {
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

    document.getElementById('formTitle').textContent = 'Edit Post';
    document.getElementById('submitBtn').textContent = 'Update Post';
    document.getElementById('submitBtn').setAttribute('data-edit-id', post.id);

    switchSection(null, 'add-post');
}

// Confirm delete
function confirmDelete(index, title) {
    const modal = document.getElementById('deleteModal');
    document.getElementById('deleteMessage').textContent = `Are you sure you want to delete "${title}"?`;
    document.getElementById('confirmDeleteBtn').onclick = function() {
        deletePost(index);
        closeDeleteModal();
    };
    modal.classList.add('active');
}

// Close delete modal
function closeDeleteModal() {
    document.getElementById('deleteModal').classList.remove('active');
}

// Delete post
function deletePost(index) {
    const postsJSON = localStorage.getItem(POSTS_STORAGE_KEY);
    const posts = postsJSON ? JSON.parse(postsJSON) : [];

    posts.splice(index, 1);
    localStorage.setItem(POSTS_STORAGE_KEY, JSON.stringify(posts));

    loadPosts();
    alert('Post deleted successfully!');
}

// Reset form
function resetPostForm() {
    document.getElementById('postForm').reset();
    document.getElementById('submitBtn').removeAttribute('data-edit-id');
}

// Logout
function logout(e) {
    if (e) e.preventDefault();
    sessionStorage.clear();
    window.location.href = 'login.html';
}

// Clear all posts
function clearAllPosts() {
    if (confirm('Are you sure? This will delete all posts permanently!')) {
        localStorage.removeItem(POSTS_STORAGE_KEY);
        loadPosts();
        alert('All posts cleared!');
    }
}

// Export data
function exportData() {
    const postsJSON = localStorage.getItem(POSTS_STORAGE_KEY);
    const posts = postsJSON ? JSON.parse(postsJSON) : [];

    const dataStr = JSON.stringify(posts, null, 2);
    const dataBlob = new Blob([dataStr], { type: 'application/json' });
    const url = URL.createObjectURL(dataBlob);

    const link = document.createElement('a');
    link.href = url;
    link.download = `arcreative_posts_${new Date().toISOString().split('T')[0]}.json`;
    link.click();

    URL.revokeObjectURL(url);
}

// Add CSS for category badge
const style = document.createElement('style');
style.textContent = `
    .category-badge {
        display: inline-block;
        padding: 4px 8px;
        background: rgba(255, 107, 53, 0.2);
        color: #ff6b35;
        border-radius: 3px;
        font-size: 12px;
        font-weight: 600;
    }
`;
document.head.appendChild(style);

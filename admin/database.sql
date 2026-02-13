-- =============================================
-- ARCREATIVE CMS DATABASE SCHEMA
-- =============================================

-- Create Database
CREATE DATABASE IF NOT EXISTS arcreative_db;
USE arcreative_db;

-- =============================================
-- USERS TABLE (Admin)
-- =============================================
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

-- =============================================
-- CATEGORIES TABLE
-- =============================================
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

-- =============================================
-- ARTICLES TABLE
-- =============================================
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

-- =============================================
-- TAGS TABLE
-- =============================================
CREATE TABLE IF NOT EXISTS tags (
    id INT PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(100) NOT NULL UNIQUE,
    slug VARCHAR(100) NOT NULL UNIQUE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- =============================================
-- ARTICLE TAGS (Junction Table)
-- =============================================
CREATE TABLE IF NOT EXISTS article_tags (
    article_id INT NOT NULL,
    tag_id INT NOT NULL,
    PRIMARY KEY (article_id, tag_id),
    FOREIGN KEY (article_id) REFERENCES articles(id) ON DELETE CASCADE,
    FOREIGN KEY (tag_id) REFERENCES tags(id) ON DELETE CASCADE
);

-- =============================================
-- COMMENTS TABLE
-- =============================================
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

-- =============================================
-- Insert Default Categories
-- =============================================
INSERT INTO categories (name, slug, description, icon, color) VALUES
('Tutorial Design', 'tutorial-design', 'Tips dan trik design grafis profesional', 'fas fa-palette', '#569ae3'),
('Tutorial Web Dev', 'tutorial-web', 'Tutorial web development dan programming', 'fas fa-code', '#4a8bc2'),
('Tutorial Microsoft', 'tutorial-ms', 'Tutorial Microsoft Office dan Windows', 'fas fa-file-word', '#7cb5e8'),
('Edukasi Digitalisasi', 'edukasi', 'Materi edukasi transformasi digital', 'fas fa-graduation-cap', '#569ae3'),
('Update Teknologi', 'teknologi', 'Update dan berita teknologi terkini', 'fas fa-microchip', '#4a8bc2'),
('Tutorial Instalasi Komputer', 'tutorial-komputer', 'Tutorial instalasi hardware dan software', 'fas fa-desktop', '#7cb5e8'),
('Tutorial Teknisi Komputer', 'tutorial-teknis', 'Troubleshooting dan maintenance komputer', 'fas fa-wrench', '#569ae3'),
('Management Konten', 'management-konten', 'Tips management dan publikasi konten', 'fas fa-pen', '#4a8bc2');

-- =============================================
-- Insert Default Admin User
-- =============================================
-- Email: admin@arcreative.com
-- Password: Ar@Creative123
-- Hash Method: bcrypt (PASSWORD_BCRYPT in PHP)
INSERT INTO users (name, email, password, role, is_active) VALUES
('Admin', 'admin@arcreative.com', '$2y$10$Ye3.ZE.emg.9MTXSrUfJGOkDw2jMQEglArH4EJJfgJSfITr/o7LDK', 'admin', TRUE);

-- =============================================
-- Create Indexes for Performance
-- =============================================
CREATE INDEX idx_articles_created ON articles(created_at DESC);
CREATE INDEX idx_articles_title ON articles(title);

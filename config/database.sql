-- Veritabanı oluşturma
CREATE DATABASE IF NOT EXISTS dilekce_db CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE dilekce_db;

-- Kullanıcılar tablosu
CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) UNIQUE NOT NULL,
    email VARCHAR(100) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    full_name VARCHAR(100) NOT NULL,
    phone VARCHAR(20),
    address TEXT,
    role ENUM('user', 'admin', 'officer') DEFAULT 'user',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- Dilekçe kategorileri tablosu
CREATE TABLE petition_categories (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    description TEXT,
    icon VARCHAR(50),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Dilekçeler tablosu
CREATE TABLE petitions (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    category_id INT,
    title VARCHAR(200) NOT NULL,
    content TEXT NOT NULL,
    ai_generated BOOLEAN DEFAULT FALSE,
    status ENUM('draft', 'submitted', 'in_review', 'approved', 'rejected', 'completed') DEFAULT 'draft',
    priority ENUM('low', 'medium', 'high', 'urgent') DEFAULT 'medium',
    assigned_to INT,
    reference_number VARCHAR(50) UNIQUE,
    submitted_at TIMESTAMP NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (category_id) REFERENCES petition_categories(id),
    FOREIGN KEY (assigned_to) REFERENCES users(id)
);

-- Dilekçe yanıtları tablosu
CREATE TABLE petition_responses (
    id INT AUTO_INCREMENT PRIMARY KEY,
    petition_id INT NOT NULL,
    user_id INT NOT NULL,
    content TEXT NOT NULL,
    is_official BOOLEAN DEFAULT FALSE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (petition_id) REFERENCES petitions(id) ON DELETE CASCADE,
    FOREIGN KEY (user_id) REFERENCES users(id)
);

-- Dosya ekleri tablosu
CREATE TABLE petition_attachments (
    id INT AUTO_INCREMENT PRIMARY KEY,
    petition_id INT NOT NULL,
    filename VARCHAR(255) NOT NULL,
    original_name VARCHAR(255) NOT NULL,
    file_size INT NOT NULL,
    mime_type VARCHAR(100) NOT NULL,
    uploaded_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (petition_id) REFERENCES petitions(id) ON DELETE CASCADE
);

-- Sistem logları tablosu
CREATE TABLE activity_logs (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT,
    action VARCHAR(100) NOT NULL,
    description TEXT,
    ip_address VARCHAR(45),
    user_agent TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id)
);

-- Varsayılan kategoriler ekleme
INSERT INTO petition_categories (name, description, icon) VALUES
('Genel Talep', 'Genel konularda dilekçe', 'fas fa-file-alt'),
('İzin Talebi', 'İzin ve tatil talepleri', 'fas fa-calendar-alt'),
('Şikayet', 'Şikayet ve problemler', 'fas fa-exclamation-triangle'),
('Öneri', 'İyileştirme önerileri', 'fas fa-lightbulb'),
('Mali Konular', 'Finansal talep ve şikayetler', 'fas fa-money-bill-wave'),
('İnsan Kaynakları', 'İK ile ilgili konular', 'fas fa-users'),
('Teknik Destek', 'Teknik sorunlar', 'fas fa-tools'),
('Diğer', 'Diğer konular', 'fas fa-question-circle');

-- Varsayılan admin kullanıcı (şifre: admin123)
INSERT INTO users (username, email, password, full_name, role) VALUES
('admin', 'admin@dilekce.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'Sistem Yöneticisi', 'admin');
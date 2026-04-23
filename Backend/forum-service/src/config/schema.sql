-- ============================================
-- FORUM DISKUSI - DATABASE SCHEMA
-- HIRIFY-KELA Platform
-- ============================================

-- Tabel kategori forum (misal: Karier, Teknis, Interview, dll)
CREATE TABLE IF NOT EXISTS forum_categories (
  id INT AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(100) NOT NULL UNIQUE,
  slug VARCHAR(120) NOT NULL UNIQUE,
  description TEXT,
  icon VARCHAR(50),
  thread_count INT DEFAULT 0,
  is_active BOOLEAN DEFAULT TRUE,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  INDEX idx_slug (slug),
  INDEX idx_active (is_active)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Tabel thread (topik diskusi utama)
CREATE TABLE IF NOT EXISTS forum_threads (
  id INT AUTO_INCREMENT PRIMARY KEY,
  category_id INT NOT NULL,
  user_id INT NOT NULL,
  title VARCHAR(255) NOT NULL,
  slug VARCHAR(280) NOT NULL UNIQUE,
  content TEXT NOT NULL,
  view_count INT DEFAULT 0,
  reply_count INT DEFAULT 0,
  like_count INT DEFAULT 0,
  is_pinned BOOLEAN DEFAULT FALSE,
  is_locked BOOLEAN DEFAULT FALSE,
  is_deleted BOOLEAN DEFAULT FALSE,
  last_activity_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  FOREIGN KEY (category_id) REFERENCES forum_categories(id) ON DELETE CASCADE,
  FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
  INDEX idx_category (category_id),
  INDEX idx_user (user_id),
  INDEX idx_slug (slug),
  INDEX idx_last_activity (last_activity_at),
  INDEX idx_pinned (is_pinned),
  FULLTEXT idx_search (title, content)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Tabel reply/komentar pada thread
CREATE TABLE IF NOT EXISTS forum_replies (
  id INT AUTO_INCREMENT PRIMARY KEY,
  thread_id INT NOT NULL,
  user_id INT NOT NULL,
  parent_reply_id INT DEFAULT NULL,
  content TEXT NOT NULL,
  like_count INT DEFAULT 0,
  is_solution BOOLEAN DEFAULT FALSE,
  is_deleted BOOLEAN DEFAULT FALSE,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  FOREIGN KEY (thread_id) REFERENCES forum_threads(id) ON DELETE CASCADE,
  FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
  FOREIGN KEY (parent_reply_id) REFERENCES forum_replies(id) ON DELETE CASCADE,
  INDEX idx_thread (thread_id),
  INDEX idx_user (user_id),
  INDEX idx_parent (parent_reply_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Tabel likes untuk thread dan reply
CREATE TABLE IF NOT EXISTS forum_likes (
  id INT AUTO_INCREMENT PRIMARY KEY,
  user_id INT NOT NULL,
  target_type ENUM('thread', 'reply') NOT NULL,
  target_id INT NOT NULL,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
  UNIQUE KEY unique_like (user_id, target_type, target_id),
  INDEX idx_target (target_type, target_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Tabel tags untuk thread
CREATE TABLE IF NOT EXISTS forum_tags (
  id INT AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(50) NOT NULL UNIQUE,
  slug VARCHAR(60) NOT NULL UNIQUE,
  usage_count INT DEFAULT 0,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  INDEX idx_slug (slug)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Tabel pivot thread-tags (many-to-many)
CREATE TABLE IF NOT EXISTS forum_thread_tags (
  thread_id INT NOT NULL,
  tag_id INT NOT NULL,
  PRIMARY KEY (thread_id, tag_id),
  FOREIGN KEY (thread_id) REFERENCES forum_threads(id) ON DELETE CASCADE,
  FOREIGN KEY (tag_id) REFERENCES forum_tags(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Tabel report untuk moderasi konten
CREATE TABLE IF NOT EXISTS forum_reports (
  id INT AUTO_INCREMENT PRIMARY KEY,
  reporter_id INT NOT NULL,
  target_type ENUM('thread', 'reply') NOT NULL,
  target_id INT NOT NULL,
  reason VARCHAR(100) NOT NULL,
  description TEXT,
  status ENUM('pending', 'reviewed', 'resolved', 'rejected') DEFAULT 'pending',
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  reviewed_at TIMESTAMP NULL,
  FOREIGN KEY (reporter_id) REFERENCES users(id) ON DELETE CASCADE,
  INDEX idx_status (status),
  INDEX idx_target (target_type, target_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Seed kategori default
INSERT INTO forum_categories (name, slug, description, icon) VALUES
  ('Karier Umum', 'karier-umum', 'Diskusi seputar pengembangan karier secara umum', '💼'),
  ('Tips Interview', 'tips-interview', 'Bagikan dan dapatkan tips persiapan interview kerja', '🎯'),
  ('Teknologi & IT', 'teknologi-it', 'Diskusi teknis seputar dunia IT dan programming', '💻'),
  ('Mentorship', 'mentorship', 'Forum diskusi dengan mentor dan mentee', '🤝'),
  ('CV & Portfolio', 'cv-portfolio', 'Review dan tips pembuatan CV serta portfolio', '📄'),
  ('Freshgraduate', 'freshgraduate', 'Khusus untuk freshgraduate mencari kerja pertama', '🎓')
ON DUPLICATE KEY UPDATE name = name;

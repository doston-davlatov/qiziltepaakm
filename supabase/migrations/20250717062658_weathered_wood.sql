-- Database schema for Library Management System
-- Create database
CREATE DATABASE IF NOT EXISTS library_db CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE library_db;

-- Users table
CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    email VARCHAR(255) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    first_name VARCHAR(100) NOT NULL,
    last_name VARCHAR(100) NOT NULL,
    phone VARCHAR(20),
    address TEXT,
    role ENUM('admin', 'librarian', 'user') DEFAULT 'user',
    is_active BOOLEAN DEFAULT TRUE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    INDEX idx_email (email),
    INDEX idx_role (role)
) ENGINE=InnoDB;

-- Librarians table
CREATE TABLE IF NOT EXISTS librarians (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT,
    full_name VARCHAR(100) NOT NULL,
    position VARCHAR(100) NOT NULL,
    department VARCHAR(100),
    phone VARCHAR(20),
    email VARCHAR(100),
    image_path VARCHAR(255),
    bio TEXT,
    is_active BOOLEAN DEFAULT TRUE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE SET NULL,
    INDEX idx_full_name (full_name),
    INDEX idx_position (position)
) ENGINE=InnoDB;

-- Authors table
CREATE TABLE IF NOT EXISTS authors (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    biography TEXT,
    birth_date DATE,
    death_date DATE,
    nationality VARCHAR(100),
    image_path VARCHAR(255),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    INDEX idx_name (name),
    INDEX idx_nationality (nationality)
) ENGINE=InnoDB;

-- Genres table
CREATE TABLE IF NOT EXISTS genres (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    description TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    INDEX idx_name (name)
) ENGINE=InnoDB;

-- Publishers table
CREATE TABLE IF NOT EXISTS publishers (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    address TEXT,
    phone VARCHAR(20),
    email VARCHAR(255),
    website VARCHAR(255),
    logo_path VARCHAR(255),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    INDEX idx_name (name)
) ENGINE=InnoDB;

-- Books table
CREATE TABLE IF NOT EXISTS books (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    author_id INT NOT NULL,
    genre_id INT,
    publisher_id INT,
    isbn VARCHAR(20) UNIQUE,
    publication_year YEAR,
    pages INT,
    language VARCHAR(50) DEFAULT 'uz',
    description TEXT,
    cover_image VARCHAR(255),
    file_pdf VARCHAR(255),
    is_featured BOOLEAN DEFAULT FALSE,
    is_available BOOLEAN DEFAULT TRUE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (author_id) REFERENCES authors(id) ON DELETE RESTRICT,
    FOREIGN KEY (genre_id) REFERENCES genres(id) ON DELETE SET NULL,
    FOREIGN KEY (publisher_id) REFERENCES publishers(id) ON DELETE SET NULL,
    INDEX idx_title (title),
    INDEX idx_author (author_id),
    INDEX idx_genre (genre_id),
    INDEX idx_isbn (isbn),
    INDEX idx_featured (is_featured),
    INDEX idx_available (is_available),
    INDEX idx_language (language)
) ENGINE=InnoDB;

-- News table
CREATE TABLE IF NOT EXISTS news (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    content TEXT NOT NULL,
    image VARCHAR(255),
    author_id INT NOT NULL,
    is_published BOOLEAN DEFAULT FALSE,
    published_at TIMESTAMP NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (author_id) REFERENCES users(id) ON DELETE CASCADE,
    INDEX idx_title (title),
    INDEX idx_published (is_published),
    INDEX idx_created (created_at),
    INDEX idx_published_at (published_at)
) ENGINE=InnoDB;

-- Events table
CREATE TABLE IF NOT EXISTS events (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    description TEXT,
    event_date DATETIME NOT NULL,
    end_date DATETIME,
    location VARCHAR(255),
    capacity INT,
    registered_count INT DEFAULT 0,
    image VARCHAR(255),
    organizer_id INT NOT NULL,
    is_published BOOLEAN DEFAULT FALSE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (organizer_id) REFERENCES users(id) ON DELETE CASCADE,
    INDEX idx_title (title),
    INDEX idx_event_date (event_date),
    INDEX idx_published (is_published)
) ENGINE=InnoDB;

-- Event registrations table
CREATE TABLE IF NOT EXISTS event_registrations (
    id INT AUTO_INCREMENT PRIMARY KEY,
    event_id INT NOT NULL,
    user_id INT NOT NULL,
    registration_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    status ENUM('registered', 'attended', 'cancelled') DEFAULT 'registered',
    FOREIGN KEY (event_id) REFERENCES events(id) ON DELETE CASCADE,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    UNIQUE KEY unique_registration (event_id, user_id),
    INDEX idx_event (event_id),
    INDEX idx_user (user_id),
    INDEX idx_status (status)
) ENGINE=InnoDB;

-- Book borrowings table
CREATE TABLE IF NOT EXISTS borrowings (
    id INT AUTO_INCREMENT PRIMARY KEY,
    book_id INT NOT NULL,
    user_id INT NOT NULL,
    librarian_id INT NOT NULL,
    borrow_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    due_date DATE NOT NULL,
    return_date TIMESTAMP NULL,
    status ENUM('borrowed', 'returned', 'overdue', 'lost') DEFAULT 'borrowed',
    fine_amount DECIMAL(10, 2) DEFAULT 0.00,
    notes TEXT,
    FOREIGN KEY (book_id) REFERENCES books(id) ON DELETE RESTRICT,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (librarian_id) REFERENCES users(id) ON DELETE RESTRICT,
    INDEX idx_book (book_id),
    INDEX idx_user (user_id),
    INDEX idx_status (status),
    INDEX idx_due_date (due_date),
    INDEX idx_return_date (return_date)
) ENGINE=InnoDB;

-- Book reservations table
CREATE TABLE IF NOT EXISTS reservations (
    id INT AUTO_INCREMENT PRIMARY KEY,
    book_id INT NOT NULL,
    user_id INT NOT NULL,
    reservation_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    expiry_date TIMESTAMP NOT NULL,
    status ENUM('pending', 'fulfilled', 'cancelled', 'expired') DEFAULT 'pending',
    FOREIGN KEY (book_id) REFERENCES books(id) ON DELETE CASCADE,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    INDEX idx_book (book_id),
    INDEX idx_user (user_id),
    INDEX idx_status (status),
    INDEX idx_expiry (expiry_date)
) ENGINE=InnoDB;

-- Book reviews table
CREATE TABLE IF NOT EXISTS reviews (
    id INT AUTO_INCREMENT PRIMARY KEY,
    book_id INT NOT NULL,
    user_id INT NOT NULL,
    rating INT NOT NULL CHECK (rating >= 1 AND rating <= 5),
    review TEXT,
    is_approved BOOLEAN DEFAULT FALSE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (book_id) REFERENCES books(id) ON DELETE CASCADE,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    UNIQUE KEY unique_review (book_id, user_id),
    INDEX idx_book (book_id),
    INDEX idx_user (user_id),
    INDEX idx_rating (rating),
    INDEX idx_approved (is_approved)
) ENGINE=InnoDB;

-- Activity log table
CREATE TABLE IF NOT EXISTS activity_log (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT,
    action VARCHAR(255) NOT NULL,
    details TEXT,
    ip_address VARCHAR(45),
    user_agent TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE SET NULL,
    INDEX idx_user (user_id),
    INDEX idx_action (action),
    INDEX idx_created (created_at)
) ENGINE=InnoDB;

-- Categories table
CREATE TABLE IF NOT EXISTS categories (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    parent_id INT,
    description TEXT,
    image_path VARCHAR(255),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (parent_id) REFERENCES categories(id) ON DELETE SET NULL,
    INDEX idx_name (name),
    INDEX idx_parent (parent_id)
) ENGINE=InnoDB;

-- Book-category relationship table
CREATE TABLE IF NOT EXISTS book_categories (
    book_id INT NOT NULL,
    category_id INT NOT NULL,
    PRIMARY KEY (book_id, category_id),
    FOREIGN KEY (book_id) REFERENCES books(id) ON DELETE CASCADE,
    FOREIGN KEY (category_id) REFERENCES categories(id) ON DELETE CASCADE,
    INDEX idx_book (book_id),
    INDEX idx_category (category_id)
) ENGINE=InnoDB;

-- Password reset tokens table
CREATE TABLE IF NOT EXISTS password_resets (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    token VARCHAR(255) NOT NULL,
    expires_at TIMESTAMP NOT NULL,
    used BOOLEAN DEFAULT FALSE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    UNIQUE KEY unique_token (token),
    INDEX idx_user (user_id),
    INDEX idx_expires (expires_at)
) ENGINE=InnoDB;

-- Settings table
CREATE TABLE IF NOT EXISTS settings (
    id INT AUTO_INCREMENT PRIMARY KEY,
    setting_key VARCHAR(100) UNIQUE NOT NULL,
    setting_value TEXT,
    setting_group VARCHAR(50),
    is_public BOOLEAN DEFAULT FALSE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    INDEX idx_key (setting_key),
    INDEX idx_group (setting_group)
) ENGINE=InnoDB;

-- Insert initial data

-- -- Insert sample publishers
-- INSERT INTO publishers (name, address, phone, email, website) VALUES
-- ('O\'zbekiston Milliy Ensiklopediyasi', 'Toshkent, O\'zbekiston', '+998712345678', 'info@ziyonet.uz', 'https://ziyonet.uz'),
-- ('Sharq nashriyoti', 'Toshkent, Navoiy ko\'chasi 30', '+998712345679', 'info@sharq.uz', 'https://sharq.uz'),
-- ('Yosh gvardiya', 'Toshkent, Amir Temur ko\'chasi 15', '+998712345680', 'info@yosh.uz', 'https://yosh.uz'),
-- ('G\'afur G\'ulom nomidagi nashriyot', 'Toshkent, Bobur ko\'chasi 12', '+998712345681', 'info@gafur.uz', 'https://gafur.uz'),
-- ('Fan nashriyoti', 'Toshkent, Universitet ko\'chasi 4', '+998712345682', 'info@fan.uz', 'https://fan.uz');

-- -- Insert sample authors
-- INSERT INTO authors (name, biography, nationality) VALUES
-- ('Abdulla Qodiriy', 'O\'zbek adabiyotining buyuk vakili', 'O\'zbek'),
-- ('Cho\'lpon', 'O\'zbek shoiri va yozuvchisi', 'O\'zbek'),
-- ('Oybek', 'O\'zbek adabiyotining yirik namoyandasi', 'O\'zbek'),
-- ('Pushkin A.S.', 'Rus adabiyotining buyuk shoiri', 'Rus'),
-- ('Tolstoy L.N.', 'Rus yozuvchisi', 'Rus'),
-- ('Alisher Navoiy', 'Buyuk o\'zbek shoiri va mutafakkiri', 'O\'zbek'),
-- ('Zulfiya', 'O\'zbekiston xalq shoirasi', 'O\'zbek'),
-- ('Erkin Vohidov', 'O\'zbekiston xalq shoiri', 'O\'zbek');

-- -- Insert sample genres
-- INSERT INTO genres (name, description) VALUES
-- ('Badiy adabiyot', 'Badiiy asarlar'),
-- ('Ilmiy adabiyot', 'Ilmiy kitoblar'),
-- ('Tarixiy roman', 'Tarixiy mavzudagi romanlar'),
-- ('Poeziya', 'She\'riy to\'plamlar'),
-- ('Dramaturgiya', 'Dramatik asarlar'),
-- ('Fantastika', 'Fantastik janrdagi asarlar'),
-- ('Detektiv', 'Detektiv janrdagi asarlar'),
-- ('Biografiya', 'Tarixiy shaxslar haqidagi asarlar');

-- -- Insert sample categories
-- INSERT INTO categories (name,  description) VALUES
-- ('Bolalar adabiyoti', 'Bolalar uchun kitoblar'),
-- ('Ilmiy fantastika',  'Ilmiy fantastik asarlar'),
-- ('Detektiv',  'Detektiv janridagi kitoblar'),
-- ('Biografiya',  'Biografik asarlar'),
-- ('O\'zbek adabiyoti', 'O\'zbek adiblarining asarlari'),
-- ('Jahon adabiyoti', 'Chet el adiblarining asarlari'),
-- ('Diniy adabiyot', 'Diniy mavzudagi kitoblar'),
-- ('Ilmiy-ommabop', 'Ilmiy-ommabop adabiyotlar');

-- -- Insert sample books
-- INSERT INTO books 
-- (title, author_id, genre_id, publisher_id, isbn, publication_year, pages, description, is_featured, is_available) 
-- VALUES
-- ('O\'tkan kunlar', 1, 3, 1, '978-9943-01-001-1', 2020, 350, 'O\'zbek xalqining tarixiy roman', TRUE, TRUE),
-- ('Kecha va kunduz', 2, 4, 2, '978-9943-01-002-2', 2019, 280, 'She\'riy to\'plam', FALSE, TRUE),
-- ('Navoiy', 3, 3, 1, '978-9943-01-003-3', 2021, 420, 'Alisher Navoiy haqida roman', TRUE, TRUE),
-- ('Evgeniy Onegin', 4, 1, 3, '978-9943-01-004-4', 2018, 310, 'Rus adabiyotining durdonasi', FALSE, TRUE),
-- ('Urush va tinchlik', 5, 1, 3, '978-9943-01-005-5', 2020, 850, 'Buyuk roman', TRUE, TRUE),
-- ('Xamsa', 6, 4, 4, '978-9943-01-006-6', 2022, 520, 'Alisher Navoiyning mashhur asari', TRUE, TRUE),
-- ('Tong qo\'shig\'i', 7, 4, 5, '978-9943-01-007-7', 2021, 180, 'Zulfiyaning she\'rlar to\'plami', FALSE, TRUE),
-- ('O\'zbekiston qalblarda', 8, 4, 1, '978-9943-01-008-8', 2020, 210, 'Erkin Vohidov she\'rlari', TRUE, TRUE);

-- -- Insert book-category relationships
-- INSERT INTO book_categories (book_id, category_id) VALUES
-- (1, 5), (1, 3),  -- O'tkan kunlar - O'zbek adabiyoti, Tarixiy roman
-- (2, 5), (2, 4),  -- Kecha va kunduz - O'zbek adabiyoti, Poeziya
-- (3, 5), (3, 8),  -- Navoiy - O'zbek adabiyoti, Biografiya
-- (4, 6), (4, 4),  -- Evgeniy Onegin - Jahon adabiyoti, Poeziya
-- (5, 6),          -- Urush va tinchlik - Jahon adabiyoti
-- (6, 5), (6, 4),  -- Xamsa - O'zbek adabiyoti, Poeziya
-- (7, 5), (7, 4),  -- Tong qo'shig'i - O'zbek adabiyoti, Poeziya
-- (8, 5), (8, 4);  -- O'zbekiston qalblarda - O'zbek adabiyoti, Poeziya

-- -- Insert sample librarians
-- INSERT INTO users (email, password, first_name, last_name, role) VALUES
-- ('librarian1@library.uz', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'Nazira', 'Olimova', 'librarian'),
-- ('librarian2@library.uz', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'Bobur', 'Karimov', 'librarian'),
-- ('librarian3@library.uz', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'Gulnora', 'Tosheva', 'librarian');

-- INSERT INTO librarians (user_id, full_name, position, department, email, is_active) VALUES
-- (2, 'Olimova Nazira', 'Direktor', 'Boshqarma', 'librarian1@library.uz', TRUE),
-- (3, 'Karimov Bobur', 'Bosh kutubxonachi', 'Kitob fondi', 'librarian2@library.uz', TRUE),
-- (4, 'Tosheva Gulnora', 'Kutubxonachi', 'Elektron resurslar', 'librarian3@library.uz', TRUE);

-- -- Insert sample news
-- INSERT INTO news (title, content, author_id, is_published, published_at) VALUES
-- ('Yangi kitoblar keldi', 'Kutubxonamizga yangi kitoblar keldi. Foydalanuvchilar ushbu kitoblarni kutubxonada topishlari mumkin.', 1, TRUE, NOW()),
-- ('Kitob ko\'rgazmasi', 'Kelgusi oyda kitob ko\'rgazmasi tashkil etiladi. Barcha qiziquvchilar taklif qilinadi.', 1, TRUE, NOW()),
-- ('Yangi yil tadbiri', 'Yangi yil munosabati bilan kutubxonada maxsus tadbir o\'tkaziladi.', 1, FALSE, NULL);

-- -- Insert sample events
-- INSERT INTO events (title, description, event_date, end_date, location, capacity, organizer_id, is_published) VALUES
-- ('Adabiyot kechasi', 'Yosh adiblar bilan uchrashuv', '2024-02-15 18:00:00', '2024-02-15 20:00:00', 'Kutubxona zali', 50, 1, TRUE),
-- ('Kitob muhokamasi',  'Yangi kitoblarni muhokama qilish', '2024-02-20 16:00:00', '2024-02-20 18:00:00', 'Kutubxona zali', 30, 1, TRUE),
-- ('She\'riyat kuni', 'She\'riyat kuni nishonlanadi', '2024-03-10 10:00:00', '2024-03-10 16:00:00', 'Kutubxona bog\'i', 100, 1, FALSE);

-- -- Insert initial settings
-- INSERT INTO settings (setting_key, setting_value, setting_group, is_public) VALUES
-- ('library_name', 'O\'zbekiston Milliy Kutubxonasi', 'general', TRUE),
-- ('library_address', 'Toshkent shahar, Mustaqillik ko\'chasi, 123-uy', 'general', TRUE),
-- ('library_phone', '+998712345678', 'contact', TRUE),
-- ('library_email', 'info@milliykutubxona.uz', 'contact', TRUE),
-- ('library_website', 'https://kutubxona.uz', 'contact', TRUE),
-- ('library_opening_hours', 'Dushanba-Juma: 08:00-18:00', 'general', TRUE),
-- ('books_per_page', '10', 'display', FALSE),
-- ('max_borrow_days', '14', 'borrowing', FALSE),
-- ('daily_fine_amount', '5000', 'borrowing', FALSE),
-- ('featured_books_count', '5', 'display', FALSE);
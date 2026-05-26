-- =============================================
-- TravelNotes - Полная база данных
-- Тестовый вход: alex_travel / admin123
-- Другие пользователи: maria_adventures, ivan_hiker / user123
-- Пароли: bcrypt через core/Hash.php
-- =============================================

CREATE DATABASE IF NOT EXISTS travelnotes;
USE travelnotes;

-- 1. Пользователи
CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(100) NOT NULL UNIQUE,
    email VARCHAR(150) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    avatar VARCHAR(255) NULL,
    bio TEXT NULL,
    country VARCHAR(100) NULL,
    role ENUM('user', 'admin') DEFAULT 'user',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- 2. Категории статей
CREATE TABLE IF NOT EXISTS categories (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL UNIQUE,
    slug VARCHAR(100) NOT NULL UNIQUE,
    description TEXT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- 3. Статьи о путешествиях
CREATE TABLE IF NOT EXISTS articles (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    slug VARCHAR(255) NOT NULL UNIQUE,
    content TEXT NOT NULL,
    excerpt TEXT NULL,
    cover_image VARCHAR(255) NULL,
    author_id INT NOT NULL,
    views INT DEFAULT 0,
    status ENUM('draft', 'published') DEFAULT 'published',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (author_id) REFERENCES users(id) ON DELETE CASCADE
);

-- 4. Связь статей с категориями (многие ко многим)
CREATE TABLE IF NOT EXISTS article_category (
    article_id INT NOT NULL,
    category_id INT NOT NULL,
    PRIMARY KEY (article_id, category_id),
    FOREIGN KEY (article_id) REFERENCES articles(id) ON DELETE CASCADE,
    FOREIGN KEY (category_id) REFERENCES categories(id) ON DELETE CASCADE
);

-- 5. Комментарии к статьям
CREATE TABLE IF NOT EXISTS comments (
    id INT AUTO_INCREMENT PRIMARY KEY,
    content TEXT NOT NULL,
    article_id INT NOT NULL,
    user_id INT NOT NULL,
    status ENUM('pending', 'approved', 'spam') DEFAULT 'approved',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (article_id) REFERENCES articles(id) ON DELETE CASCADE,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);

-- 6. Контакты путешественников (записная книжка)
CREATE TABLE IF NOT EXISTS contacts (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    lastname VARCHAR(100) NOT NULL,
    firstname VARCHAR(100) NOT NULL,
    middlename VARCHAR(100) NULL,
    gender VARCHAR(10) NULL,
    birthdate DATE NULL,
    phone VARCHAR(30) NULL,
    address TEXT NULL,
    email VARCHAR(150) NULL,
    comment TEXT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);

-- 7. Поездки/маршруты
CREATE TABLE IF NOT EXISTS trips (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    title VARCHAR(255) NOT NULL,
    destination VARCHAR(255) NOT NULL,
    start_date DATE NOT NULL,
    end_date DATE NOT NULL,
    budget DECIMAL(10, 2) NULL,
    notes TEXT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);

-- =============================================
-- ТЕСТОВЫЕ ДАННЫЕ
-- =============================================

-- Пользователи (bcrypt: admin123 / user123)
INSERT INTO users (username, email, password, role, bio, country) VALUES
('alex_travel', 'alex@travelnotes.com', '$2y$10$csE.HUTCZ4XZ8BKhabYmT.NHrsReIufBtXgs.W34WxMIJMrqkxKLq', 'admin', 'Путешественник со стажем, посетил 30 стран', 'Россия'),
('maria_adventures', 'maria@travelnotes.com', '$2y$10$2XxDM/J12K/.BMnJWzlW/OJAbU1Tu8N8kWMtmJZugxwB94v5CLsHG', 'user', 'Люблю горы и море', 'Украина'),
('ivan_hiker', 'ivan@travelnotes.com', '$2y$10$2XxDM/J12K/.BMnJWzlW/OJAbU1Tu8N8kWMtmJZugxwB94v5CLsHG', 'user', 'Профессиональный турист', 'Казахстан');

-- Категории
INSERT INTO categories (name, slug, description) VALUES
('Европа', 'europe', 'Путешествия по Европе'),
('Азия', 'asia', 'Экзотические страны Азии'),
('Трекинг', 'trekking', 'Пешие походы и горы'),
('Пляжи', 'beaches', 'Пляжный отдых'),
('Экстрим', 'extreme', 'Экстремальные путешествия');

-- Статьи
INSERT INTO articles (title, slug, content, excerpt, author_id, views) VALUES
('10 лучших мест в Европе', 'top-10-europe', 'Париж, Рим, Барселона, Амстердам, Прага, Лондон, Берлин, Вена, Будапешт, Краков. Каждый город уникален по-своему...', 'Путеводитель по лучшим европейским городам', 1, 150),
('Как собрать рюкзак в поход', 'how-to-pack-backpack', 'Список вещей: палатка, спальник, коврик, горелка, посуда, аптечка, запас еды, вода, тёплая одежда, дождевик...', 'Советы по упаковке для многодневного похода', 2, 89),
('Секреты бюджетных путешествий', 'budget-travel-secrets', 'Используйте лоукостеры, бронируйте жильё заранее, ешьте в местных кафе, путешествуйте в низкий сезон...', 'Как путешествовать дёшево и комфортно', 1, 234);

-- Связи статей с категориями
INSERT INTO article_category (article_id, category_id) VALUES
(1, 1), (2, 3), (2, 4), (3, 1), (3, 2);

-- Комментарии
INSERT INTO comments (content, article_id, user_id) VALUES
('Отличная статья! Спасибо!', 1, 2),
('Очень полезные советы', 2, 3),
('А что насчёт Африки?', 1, 3);

-- Контакты (для пользователя 1)
INSERT INTO contacts (user_id, lastname, firstname, middlename, gender, birthdate, phone, email, comment) VALUES
(1, 'Петров', 'Петр', 'Петрович', 'Мужской', '1985-03-15', '+7-999-123-4567', 'petr@example.com', 'Попутчик из Москвы'),
(1, 'Сидорова', 'Анна', 'Ивановна', 'Женский', '1990-07-22', '+7-999-765-4321', 'anna@example.com', 'Соседка по купе');

-- Поездки
INSERT INTO trips (user_id, title, destination, start_date, end_date, budget, notes) VALUES
(1, 'Европейское турне', 'Париж → Барселона → Рим', '2026-06-01', '2026-06-15', 2500.00, 'Забронировать отели заранее'),
(2, 'Поход на Алтай', 'Горный Алтай', '2026-07-10', '2026-07-20', 800.00, 'Взять тёплую палатку');
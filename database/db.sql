CREATE DATABASE IF NOT EXISTS travelnotes;
USE travelnotes;

CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(100) NOT NULL UNIQUE,
    email VARCHAR(150) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    bio TEXT NULL,
    country VARCHAR(100) NULL,
    role ENUM('user', 'admin') DEFAULT 'user',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

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

CREATE TABLE IF NOT EXISTS articles (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    content TEXT NOT NULL,
    excerpt TEXT NULL,
    author_id INT NOT NULL,
    user_id INT NOT NULL,
    views INT DEFAULT 0,
    status ENUM('draft', 'published') DEFAULT 'published',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (author_id) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);

INSERT INTO users (username, email, password, role, bio, country) VALUES
('alex_travel', 'alex@travelnotes.com', '$2y$10$csE.HUTCZ4XZ8BKhabYmT.NHrsReIufBtXgs.W34WxMIJMrqkxKLq', 'admin', 'Путешественник со стажем, посетил 30 стран', 'Россия'),
('maria_adventures', 'maria@travelnotes.com', '$2y$10$2XxDM/J12K/.BMnJWzlW/OJAbU1Tu8N8kWMtmJZugxwB94v5CLsHG', 'user', 'Люблю горы и море', 'Украина');

INSERT INTO articles (title, content, excerpt, author_id, user_id, views) VALUES
('10 лучших мест в Европе', 'Париж, Рим, Барселона, Амстердам, Прага, Лондон, Берлин...', 'Путеводитель по лучшим европейским городам', 1, 1, 150),
('Как собрать рюкзак в поход', 'Список вещей: палатка, спальник, коврик, горелка...', 'Советы по упаковке для многодневного похода', 2, 2, 89);

INSERT INTO contacts (user_id, lastname, firstname, middlename, gender, birthdate, phone, email, comment) VALUES
(1, 'Петров', 'Петр', 'Петрович', 'Мужской', '1985-03-15', '+7-999-123-4567', 'petr@example.com', 'Попутчик из Москвы');

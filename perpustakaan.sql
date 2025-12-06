-- ======================================================
-- FILE: perpustakaan_recreate.sql
-- PURPOSE: recreate database perpustakaan (drop & create tables)
-- WARNING: this will DROP existing tables 'users' and 'books'
-- ======================================================

-- 1) create database if not exists and use it
CREATE DATABASE IF NOT EXISTS perpustakaan CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE perpustakaan;

-- 2) USERS table (drop if exists to ensure fresh state)
DROP TABLE IF EXISTS users;
CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nama VARCHAR(100) NOT NULL,
    password VARCHAR(255) NOT NULL,
    role ENUM('admin','user') NOT NULL DEFAULT 'user',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- 3) Insert default admin and user
-- NOTE: password hashes below are bcrypt (password_verify compatible)
-- admin password = admin123
-- user password  = azhrul123

INSERT INTO users (nama, password, role)
VALUES
('admin', '$2y$10$KfJxCLN9vQ6k1xOB5K1H0e5Yz5Hwe.LllX1zB2f5QfC4fKZxC25y.', 'admin'),
('Azhrul', '$2y$10$CIdFJWgxU0frqQcmfV6v5eMN5UFUKFBEk3pA1MIyaIm1mXrVJ0Vnq', 'user')
ON DUPLICATE KEY UPDATE nama=nama;

-- 4) BOOKS table (drop if exists and recreate)
DROP TABLE IF EXISTS books;
CREATE TABLE books (
    id INT AUTO_INCREMENT PRIMARY KEY,
    judul VARCHAR(255) NOT NULL,
    penulis VARCHAR(255),
    kategori VARCHAR(100),
    cover VARCHAR(255),   -- simpan path relatif seperti: img/namafile.jpg
    deskripsi TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- 5) Insert sample books (matching project)
INSERT INTO books (judul, penulis, kategori, cover, deskripsi) VALUES
('Laskar Pelangi', 'Andrea Hirata', 'Novel', 'img/Laskar Pelangi.webp', 'Kisah inspiratif persahabatan dan perjuangan meraih mimpi.'),
('Filosofi Teras', 'Henry Manampiring', 'Filsafat', 'img/filosofi teras.webp', 'Penjelasan Stoisisme dalam kehidupan modern.'),
('Bumi Manusia', 'Pramoedya Ananta Toer', 'Novel', 'img/bumi manusia.jpg', 'Bagian pertama dari Tetralogi Buru.'),
('Madilog', 'Tan Malaka', 'Filsafat', 'img/madilog.jpg', 'Materialisme, dialektika, dan logika.'),
('Clean Code', 'Robert C. Martin', 'Teknologi', 'img/clean code.jpg', 'Cara menulis kode yang bersih dan mudah dirawat.'),
('Introduction to AI', 'Wolfgang Ertel', 'Teknologi', 'img/artificial intelligence.jpg', 'Buku dasar mengenai kecerdasan buatan.'),
('The Prince', 'Niccolò Machiavelli', 'Politik', 'img/the prince.jpg', 'Karya klasik tentang kekuasaan dan strategi.'),
('Ihya Ulumuddin', 'Al-Ghazali', 'Agama', 'img/ihya ulumuddin.jpg', 'Kitab monumental tentang tasawuf dan akhlak.'),
('Filsafat Pendidikan', 'Hasbullah', 'Pendidikan', 'img/filsafat pendidikan.jpg', 'Pemahaman dasar konsep pendidikan.'),
('Clementine 1', 'Tillie Walden', 'Komik', 'img/clementine 1.jpg', 'Petualangan Clementine setelah seri The Walking Dead.');

-- ======================================================
-- FINISHED
-- ======================================================

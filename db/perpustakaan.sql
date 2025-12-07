-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 06 Des 2025 pada 16.55
-- Versi server: 10.4.32-MariaDB
-- Versi PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `perpustakaan`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `books`
--

CREATE TABLE `books` (
  `id` int(11) NOT NULL,
  `judul` varchar(255) NOT NULL,
  `penulis` varchar(255) DEFAULT NULL,
  `kategori` varchar(100) DEFAULT NULL,
  `cover` varchar(255) DEFAULT NULL,
  `pdf_file` varchar(255) DEFAULT NULL,
  `deskripsi` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `file_pdf` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `books`
--

INSERT INTO `books` (`id`, `judul`, `penulis`, `kategori`, `cover`, `pdf_file`, `deskripsi`, `created_at`, `file_pdf`) VALUES
(1, 'Laskar Pelangi', 'Andrea Hirata', 'Novel', 'img/Laskar Pelangi.webp', NULL, 'Kisah inspiratif persahabatan dan perjuangan meraih mimpi.', '2025-11-20 12:18:20', NULL),
(2, 'Filosofi Teras', 'Henry Manampiring', 'Filsafat', 'img/filosofi teras.webp', NULL, 'Penjelasan Stoisisme dalam kehidupan modern.', '2025-11-20 12:18:20', NULL),
(3, 'Bumi Manusia', 'Pramoedya Ananta Toer', 'Novel', 'img/bumi manusia.jpg', NULL, 'Bagian pertama dari Tetralogi Buru.', '2025-11-20 12:18:20', 'pdf/bumi-manusia-pramoedya.pdf'),
(4, 'Madilog', 'Tan Malaka', 'Filsafat', 'img/madilog.jpg', NULL, 'Materialisme, dialektika, dan logika.', '2025-11-20 12:18:20', NULL),
(5, 'Clean Code', 'Robert C. Martin', 'Teknologi', 'img/clean code.jpg', NULL, 'Cara menulis kode yang bersih dan mudah dirawat.', '2025-11-20 12:18:20', NULL),
(6, 'Introduction to AI', 'Wolfgang Ertel', 'Teknologi', 'img/artificial intelligence.jpg', NULL, 'Buku dasar mengenai kecerdasan buatan.', '2025-11-20 12:18:20', NULL),
(7, 'The Prince', 'Niccolò Machiavelli', 'Politik', 'img/the prince.jpg', NULL, 'Karya klasik tentang kekuasaan dan strategi.', '2025-11-20 12:18:20', NULL),
(9, 'Filsafat Pendidikan', 'Hasbullah', 'Pendidikan', 'img/filsafat pendidikan.jpg', NULL, 'Pemahaman dasar konsep pendidikan.', '2025-11-20 12:18:20', NULL),
(10, 'Clementine 1', 'Tillie Walden', 'Komik', 'img/clementine 1.jpg', NULL, 'Petualangan Clementine setelah seri The Walking Dead.', '2025-11-20 12:18:20', NULL),
(11, 'Hello Salma', 'Erisca Febriani', 'Romance', 'img/Hello Salma.jpg', NULL, 'Menceritakan lanjutan dari Karakter bernama Salma:)', '2025-11-20 15:58:04', NULL),
(12, 'Namaku Alam', 'Leila S. Chudori', 'Fiksi Sejarah', 'img/Namaku alam.jpeg', NULL, 'Buku ini menceritakan kisah Segara Alam, anak dari seorang ayah yang dieksekusi, saat ia beranjak dewasa dan berjuang mencari jati diri di tengah stigma sebagai anak eks-tapol.', '2025-11-20 16:51:58', NULL),
(14, 'Hitler Mati Di Indonesia', ' KH Soeryo Goeritno', 'Sejarah', 'img/Buku hitler.jpg', NULL, 'Buku ini menghadirkan fakta ternyata Hitler bersembunyi di Indonesia, sampai ia mati di Indonesia. Bagaimana ia bisa sembunyi di Indonesia, Mengapa akhirnya hitler masuk islam, siapa saja yang mengetahui hitler di Indonesia, Bagaimana hubungan hitler dengan Soekarno, semuanya di bahas lengkap disertai foto-foto, surat-surat hitler dan contoh tulisan tangan hitler.', '2025-11-23 05:49:06', NULL),
(17, 'Seporsi Mie Ayam Sebelum Mati', 'kelass kinggg', 'Novel', 'img/seporsi mie ayam sebelum mati.jpg', NULL, 'tesssss', '2025-11-25 15:33:39', 'pdf/seporsi-mie-ayam.pdf');

-- --------------------------------------------------------

--
-- Struktur dari tabel `comments`
--

CREATE TABLE `comments` (
  `id` int(11) NOT NULL,
  `book_id` int(11) NOT NULL,
  `nama` varchar(100) NOT NULL,
  `komentar` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `comments`
--

INSERT INTO `comments` (`id`, `book_id`, `nama`, `komentar`, `created_at`) VALUES
(1, 10, 'Azhrul 67', 'garbage', '2025-11-21 15:14:35'),
(2, 4, 'Intelektual', 'Saya Sukaaaa!!!', '2025-11-21 15:15:21'),
(3, 12, 'Azhrul', 'bagus', '2025-11-21 15:22:16'),
(4, 12, 'Farah', 'sangat bagus', '2025-11-21 15:22:43'),
(5, 11, 'Farah', 'Aku pernah meminjamkan buku ini kepada seseorang yang aku kenal, aku sangat merekomendasikan nya untuk membaca novel ini wokwokwkwk', '2025-11-21 16:34:27'),
(6, 12, 'uje', 'bagus banget \r\n', '2025-11-22 13:17:32');

-- --------------------------------------------------------

--
-- Struktur dari tabel `ratings`
--

CREATE TABLE `ratings` (
  `id` int(11) NOT NULL,
  `book_id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `rating` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `ratings`
--

INSERT INTO `ratings` (`id`, `book_id`, `user_id`, `rating`, `created_at`) VALUES
(1, 10, NULL, 1, '2025-11-21 15:14:22'),
(2, 4, NULL, 1, '2025-11-21 15:15:29'),
(3, 4, NULL, 5, '2025-11-21 15:15:32'),
(4, 4, NULL, 5, '2025-11-21 15:15:36'),
(5, 4, NULL, 5, '2025-11-21 15:15:49'),
(6, 4, NULL, 5, '2025-11-21 15:15:51'),
(7, 4, NULL, 5, '2025-11-21 15:15:54'),
(8, 12, NULL, 5, '2025-11-21 15:22:22'),
(9, 12, NULL, 4, '2025-11-21 15:22:55'),
(10, 12, NULL, 5, '2025-11-21 15:22:58'),
(11, 12, NULL, 5, '2025-11-21 15:23:00'),
(12, 12, NULL, 5, '2025-11-21 15:23:03'),
(13, 12, NULL, 5, '2025-11-21 15:23:06'),
(14, 11, NULL, 5, '2025-11-21 16:34:34');

-- --------------------------------------------------------

--
-- Struktur dari tabel `reviews`
--

CREATE TABLE `reviews` (
  `id` int(11) NOT NULL,
  `book_id` int(11) DEFAULT NULL,
  `nama` varchar(100) DEFAULT NULL,
  `komentar` text DEFAULT NULL,
  `rating` int(11) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `reviews`
--

INSERT INTO `reviews` (`id`, `book_id`, `nama`, `komentar`, `rating`, `created_at`) VALUES
(1, 12, 'Klora', 'Rekomended banget ygy', 5, '2025-11-22 16:16:35'),
(2, 9, 'Klora', 'Berpengetahuan', 5, '2025-11-22 16:19:01'),
(3, 9, 'Klora', 'Berpengetahuan', 5, '2025-11-22 16:25:46'),
(4, 4, 'intelektual', 'Berpengetahuan\r\n', 5, '2025-11-24 02:04:39'),
(5, 6, 'Azhrul', 'bagus', 5, '2025-11-24 03:13:37'),
(6, 6, 'duta', 'kurang bagus', 2, '2025-11-24 03:14:01'),
(7, 17, 'Normies', 'good, a bit suicidal tho', 4, '2025-11-27 12:55:56');

-- --------------------------------------------------------

--
-- Struktur dari tabel `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `nama` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('admin','user') NOT NULL DEFAULT 'user',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `users`
--

INSERT INTO `users` (`id`, `nama`, `password`, `role`, `created_at`) VALUES
(1, 'admin', '$2y$10$8ljyj/hRx2f8H5r/nk4tnuxfWY6himLlwmtK2m0YK4cEJksRln7Du', 'admin', '2025-11-20 12:18:20'),
(2, 'Azhrul', '$2y$10$CIdFJWgxU0frqQcmfV6v5eMN5UFUKFBEk3pA1MIyaIm1mXrVJ0Vnq', 'user', '2025-11-20 12:18:20'),
(3, 'Admin', '$2y$10$CTH9drEDBKWqJLdnOjFkTe3LI4sdJER7dHGy0aT5h9UPMXPpIj0Ia', 'admin', '2025-11-20 12:37:38'),
(4, 'User Biasa', '$2y$10$CTH9drEDBKWqJLdnOjFkTe3LI4sdJER7dHGy0aT5h9UPMXPpIj0Ia', 'user', '2025-11-20 12:37:38'),
(5, 'user', '$2y$10$3MjgQz0qKCTOjg0Myxe6Quj/1qZUlXwUVvuVrdGuvvECaxwsT2peK', 'user', '2025-11-20 15:44:51');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `books`
--
ALTER TABLE `books`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `ratings`
--
ALTER TABLE `ratings`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `reviews`
--
ALTER TABLE `reviews`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `books`
--
ALTER TABLE `books`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT untuk tabel `comments`
--
ALTER TABLE `comments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT untuk tabel `ratings`
--
ALTER TABLE `ratings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT untuk tabel `reviews`
--
ALTER TABLE `reviews`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT untuk tabel `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

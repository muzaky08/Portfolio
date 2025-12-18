-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 18 Des 2025 pada 19.42
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
-- Database: `portfolio_cms`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `activities`
--

CREATE TABLE `activities` (
  `id` int(11) UNSIGNED NOT NULL,
  `title` varchar(180) NOT NULL,
  `description` text DEFAULT NULL,
  `activity_date` date NOT NULL,
  `location` varchar(160) DEFAULT NULL,
  `category` varchar(40) NOT NULL DEFAULT 'lainnya',
  `icon` varchar(120) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `activities`
--

INSERT INTO `activities` (`id`, `title`, `description`, `activity_date`, `location`, `category`, `icon`, `created_at`, `updated_at`) VALUES
(3, 'Latihan Lari 10 K', 'Pemanasan menjelang event komunitas lari minggu depan.', '2025-12-09', 'GBK Senayan', 'lainnya', 'bi-activity', '2025-12-11 12:23:11', '2025-12-18 12:08:05'),
(4, 'Memancing', 'Memamncing adalah Kunci Kesabaran', '2025-12-11', 'Pemancingan', 'lainnya', 'bi-calendar-event', '2025-12-11 18:19:08', '2025-12-11 18:19:08'),
(5, 'Belajar', '', '2025-12-18', 'Tangerang', 'kuliah', 'bi-calendar-event', '2025-12-18 12:07:24', '2025-12-18 12:07:24');

-- --------------------------------------------------------

--
-- Struktur dari tabel `admin_activity_logs`
--

CREATE TABLE `admin_activity_logs` (
  `id` int(11) UNSIGNED NOT NULL,
  `user_id` int(11) UNSIGNED DEFAULT NULL,
  `user_name` varchar(160) DEFAULT NULL,
  `action` varchar(120) NOT NULL,
  `description` text DEFAULT NULL,
  `context` text DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` varchar(255) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `admin_activity_logs`
--

INSERT INTO `admin_activity_logs` (`id`, `user_id`, `user_name`, `action`, `description`, `context`, `ip_address`, `user_agent`, `created_at`) VALUES
(1, NULL, NULL, 'auth.register', 'Registrasi akun baru', '{\"username\":\"mznf08\"}', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36 Edg/143.0.0.0', '2025-12-11 16:41:41'),
(2, 2, 'zaky', 'auth.login', 'Login berhasil', '{\"user_id\":\"2\"}', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36 Edg/143.0.0.0', '2025-12-11 16:41:50'),
(3, 2, 'zaky', 'profile.update', 'Memperbarui biodata', NULL, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36 Edg/143.0.0.0', '2025-12-11 16:45:59'),
(4, 2, 'zaky', 'settings.update', 'Memperbarui pengaturan situs', NULL, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36 Edg/143.0.0.0', '2025-12-11 18:16:09'),
(5, 2, 'zaky', 'profile.update', 'Memperbarui biodata', NULL, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36 Edg/143.0.0.0', '2025-12-11 18:17:24'),
(6, 2, 'zaky', 'profile.update', 'Memperbarui biodata', NULL, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36 Edg/143.0.0.0', '2025-12-11 18:17:38'),
(7, 2, 'zaky', 'profile.update', 'Memperbarui biodata', NULL, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36 Edg/143.0.0.0', '2025-12-11 18:17:52'),
(8, 2, 'zaky', 'activity.create', 'Menambahkan aktivitas: Memancing', NULL, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36 Edg/143.0.0.0', '2025-12-11 18:19:08'),
(9, 2, 'zaky', 'project.update', 'Memperbarui proyek: Marketplace UMKM', '{\"id\":2}', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36 Edg/143.0.0.0', '2025-12-11 18:21:51'),
(10, 2, 'zaky', 'auth.login', 'Login berhasil', '{\"user_id\":\"2\"}', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36 Edg/143.0.0.0', '2025-12-18 00:41:25'),
(11, 2, 'zaky', 'profile.update', 'Memperbarui biodata', NULL, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36 Edg/143.0.0.0', '2025-12-18 05:32:54'),
(12, 2, 'zaky', 'settings.update', 'Memperbarui pengaturan situs', NULL, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36 Edg/143.0.0.0', '2025-12-18 05:55:45'),
(13, 2, 'zaky', 'profile.update', 'Memperbarui biodata', NULL, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36 Edg/143.0.0.0', '2025-12-18 05:58:48'),
(14, 2, 'zaky', 'settings.update', 'Memperbarui pengaturan situs', NULL, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36 Edg/143.0.0.0', '2025-12-18 08:14:49'),
(15, 2, 'zaky', 'auth.logout', 'Logout dari panel admin', NULL, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36 Edg/143.0.0.0', '2025-12-18 08:15:15'),
(16, NULL, NULL, 'auth.register', 'Registrasi akun baru', '{\"username\":\"Muzaky.08\"}', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36 Edg/143.0.0.0', '2025-12-18 08:16:34'),
(17, 3, 'Muzaky', 'auth.login', 'Login berhasil', '{\"user_id\":\"3\"}', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36 Edg/143.0.0.0', '2025-12-18 08:16:39'),
(18, 3, 'Muzaky', 'education.update', 'Memperbarui pendidikan: Universitas Yatsi Madani', '{\"id\":4}', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36 Edg/143.0.0.0', '2025-12-18 11:56:00'),
(19, 3, 'Muzaky', 'education.update', 'Memperbarui pendidikan: SMA Nusantara Unggul', '{\"id\":3}', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36 Edg/143.0.0.0', '2025-12-18 11:57:09'),
(20, 3, 'Muzaky', 'education.update', 'Memperbarui pendidikan: SMP Negeri 2 Bandung', '{\"id\":2}', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36 Edg/143.0.0.0', '2025-12-18 11:58:08'),
(21, 3, 'Muzaky', 'education.update', 'Memperbarui pendidikan: MI MA Klebet II', '{\"id\":1}', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36 Edg/143.0.0.0', '2025-12-18 11:59:33'),
(22, 3, 'Muzaky', 'education.update', 'Memperbarui pendidikan: MTS Daarul Hikmah', '{\"id\":2}', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36 Edg/143.0.0.0', '2025-12-18 12:00:02'),
(23, 3, 'Muzaky', 'experience.update', 'Memperbarui pengalaman: Leader Of Art Section', '{\"id\":1}', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36 Edg/143.0.0.0', '2025-12-18 12:02:36'),
(24, 3, 'Muzaky', 'experience.update', 'Memperbarui pengalaman: Anggota Himpunan Mahasiswa Komputer', '{\"id\":2}', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36 Edg/143.0.0.0', '2025-12-18 12:04:50'),
(25, 3, 'Muzaky', 'skill.update', 'Memperbarui skill: JavaScript', '{\"id\":2}', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36 Edg/143.0.0.0', '2025-12-18 12:06:11'),
(26, 3, 'Muzaky', 'skill.delete', 'Menghapus skill ID 3', NULL, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36 Edg/143.0.0.0', '2025-12-18 12:06:36'),
(27, 3, 'Muzaky', 'activity.create', 'Menambahkan aktivitas: Belajar', NULL, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36 Edg/143.0.0.0', '2025-12-18 12:07:24'),
(28, 3, 'Muzaky', 'activity.delete', 'Menghapus aktivitas ID 2', NULL, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36 Edg/143.0.0.0', '2025-12-18 12:07:33'),
(29, 3, 'Muzaky', 'activity.update', 'Memperbarui aktivitas: Latihan Lari 10 K', '{\"id\":3}', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36 Edg/143.0.0.0', '2025-12-18 12:08:05'),
(30, 3, 'Muzaky', 'activity.delete', 'Menghapus aktivitas ID 1', NULL, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36 Edg/143.0.0.0', '2025-12-18 12:08:18'),
(31, 3, 'Muzaky', 'message.delete', 'Menghapus pesan masuk ID 1', NULL, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36 Edg/143.0.0.0', '2025-12-18 12:09:37'),
(32, 3, 'Muzaky', 'project.update', 'Memperbarui proyek: Membuat sistem aktivasi rekening Online', '{\"id\":1}', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36 Edg/143.0.0.0', '2025-12-18 12:12:13'),
(33, 3, 'Muzaky', 'auth.login', 'Login berhasil', '{\"user_id\":\"3\"}', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36 Edg/143.0.0.0', '2025-12-18 21:05:12'),
(34, 3, 'Muzaky', 'education.update', 'Memperbarui pendidikan: Universitas Yatsi Madani', '{\"id\":4}', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36 Edg/143.0.0.0', '2025-12-18 22:31:49'),
(35, 3, 'Muzaky', 'education.update', 'Memperbarui pendidikan: SMA Nusantara Unggul', '{\"id\":3}', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36 Edg/143.0.0.0', '2025-12-18 22:32:38'),
(36, 3, 'Muzaky', 'education.update', 'Memperbarui pendidikan: SMA Nusantara Unggul', '{\"id\":3}', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36 Edg/143.0.0.0', '2025-12-18 22:32:57'),
(37, 3, 'Muzaky', 'education.update', 'Memperbarui pendidikan: MTS Daarul Hikmah', '{\"id\":2}', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36 Edg/143.0.0.0', '2025-12-18 22:33:19'),
(38, 3, 'Muzaky', 'education.update', 'Memperbarui pendidikan: MI MA Klebet II', '{\"id\":1}', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36 Edg/143.0.0.0', '2025-12-18 22:33:38'),
(39, 3, 'Muzaky', 'skill.update', 'Memperbarui skill: PHP & CodeIgniter', '{\"id\":1}', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36 Edg/143.0.0.0', '2025-12-18 22:37:48'),
(40, 3, 'Muzaky', 'skill.update', 'Memperbarui skill: PHP & CodeIgniter', '{\"id\":1}', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36 Edg/143.0.0.0', '2025-12-18 22:38:06'),
(41, 3, 'Muzaky', 'skill.update', 'Memperbarui skill: JavaScript', '{\"id\":2}', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36 Edg/143.0.0.0', '2025-12-18 22:38:37'),
(42, 3, 'Muzaky', 'auth.logout', 'Logout dari panel admin', NULL, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36 Edg/143.0.0.0', '2025-12-18 22:52:29'),
(43, 3, 'Muzaky', 'auth.login', 'Login berhasil', '{\"user_id\":\"3\"}', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36 Edg/143.0.0.0', '2025-12-18 22:53:14'),
(44, 3, 'Muzaky', 'profile.update', 'Memperbarui biodata', NULL, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36 Edg/143.0.0.0', '2025-12-18 23:13:21'),
(45, 3, 'Muzaky', 'profile.update', 'Memperbarui biodata', NULL, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36 Edg/143.0.0.0', '2025-12-18 23:13:38'),
(46, 3, 'Muzaky', 'profile.update', 'Memperbarui biodata', NULL, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36 Edg/143.0.0.0', '2025-12-18 23:49:26'),
(47, 3, 'Muzaky', 'profile.backup', 'Membuat backup biodata', NULL, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36 Edg/143.0.0.0', '2025-12-18 23:50:36'),
(48, 3, 'Muzaky', 'profile.update', 'Memperbarui biodata', NULL, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36 Edg/143.0.0.0', '2025-12-18 23:50:50'),
(49, 3, 'Muzaky', 'project.update', 'Memperbarui proyek: Portfolio', '{\"id\":2}', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36 Edg/143.0.0.0', '2025-12-19 00:02:29'),
(50, 3, 'Muzaky', 'project.update', 'Memperbarui proyek: Portfolio', '{\"id\":2}', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36 Edg/143.0.0.0', '2025-12-19 00:03:09'),
(51, 3, 'Muzaky', 'project.update', 'Memperbarui proyek: Sistem Lampu Otomatis', '{\"id\":3}', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36 Edg/143.0.0.0', '2025-12-19 00:03:45'),
(52, 3, 'Muzaky', 'project.update', 'Memperbarui proyek: Sistem Lampu Otomatis', '{\"id\":3}', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36 Edg/143.0.0.0', '2025-12-19 00:07:00'),
(53, 3, 'Muzaky', 'project.update', 'Memperbarui proyek: Membuat sistem aktivasi rekening Online', '{\"id\":1}', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36 Edg/143.0.0.0', '2025-12-19 00:07:19');

-- --------------------------------------------------------

--
-- Struktur dari tabel `biodata`
--

CREATE TABLE `biodata` (
  `id` int(11) UNSIGNED NOT NULL,
  `full_name` varchar(160) NOT NULL,
  `job_title` varchar(160) NOT NULL,
  `address` varchar(255) DEFAULT NULL,
  `email` varchar(160) NOT NULL,
  `phone` varchar(60) DEFAULT NULL,
  `short_bio` text DEFAULT NULL,
  `skills` text DEFAULT NULL,
  `photo` varchar(255) DEFAULT NULL,
  `cv_path` varchar(255) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `biodata`
--

INSERT INTO `biodata` (`id`, `full_name`, `job_title`, `address`, `email`, `phone`, `short_bio`, `skills`, `photo`, `cv_path`, `created_at`, `updated_at`) VALUES
(1, 'Muhamad Zaky Nurfaiz', 'Web Developer', 'Tangerang, Indonesia', 'zakynurfaiz08@gmail.com', '+62 858 9027 5879', '<p>Menyusun solusi digital lintas industri dengan fokus pada performa dan pengalaman pengguna. Terbiasa memimpin tim lintas disiplin dan memvalidasi eksperimen produk.</p>', '[{\"label\":\"Computer Network\",\"level\":80},{\"label\":\"Desainer\",\"level\":85},{\"label\":\"Microsoft Office\",\"level\":80},{\"label\":\"Pemrograman\",\"level\":80}]', 'uploads/profile/1766010773_bae897307f8a839e648c.png', 'uploads/docs/1766076650_3148783f6c6d9c80d884.pdf', '2025-12-11 12:23:11', '2025-12-18 23:50:50');

-- --------------------------------------------------------

--
-- Struktur dari tabel `educations`
--

CREATE TABLE `educations` (
  `id` int(11) UNSIGNED NOT NULL,
  `institution` varchar(160) NOT NULL,
  `level` varchar(60) NOT NULL,
  `major` varchar(120) DEFAULT NULL,
  `start_year` year(4) DEFAULT NULL,
  `end_year` year(4) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `logo` varchar(255) DEFAULT NULL,
  `sort_order` int(11) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `educations`
--

INSERT INTO `educations` (`id`, `institution`, `level`, `major`, `start_year`, `end_year`, `description`, `logo`, `sort_order`, `created_at`, `updated_at`) VALUES
(1, 'MI MA Klebet II', 'SD', '', '2009', '2015', 'Aktif dikegiatan belajar mengajar dan meraih prestasi pringkat atas selama 3 tahun', 'uploads/educations/1766072018_bec4ebec1d031273b6bf.jpeg', 1, '2025-12-11 12:23:11', '2025-12-18 22:33:38'),
(2, 'MTS Daarul Hikmah', 'SMP', '', '2015', '2018', 'Menekuni kegiatan belajar mengajar ', 'uploads/educations/1766071999_327d9ebe90923d6ec468.jpeg', 2, '2025-12-11 12:23:11', '2025-12-18 22:33:19'),
(3, 'SMA Nusantara Unggul', 'SMA', 'IPA', '2018', '2021', 'Membangun relasi dengan aktif diorganisasi sekolah', 'uploads/educations/1766071958_b2e552457f30c0d893ff.jpeg', 3, '2025-12-11 12:23:11', '2025-12-18 22:32:57'),
(4, 'Universitas Yatsi Madani', 'Kuliah', 'Ilmu Komputer', '2023', '2027', 'Mahasiswa aktif disemester 5', 'uploads/educations/1766071909_e782d4041cded7669986.jpeg', 4, '2025-12-11 12:23:11', '2025-12-18 22:31:49');

-- --------------------------------------------------------

--
-- Struktur dari tabel `experiences`
--

CREATE TABLE `experiences` (
  `id` int(11) UNSIGNED NOT NULL,
  `role` varchar(120) NOT NULL,
  `company` varchar(120) NOT NULL,
  `location` varchar(120) DEFAULT NULL,
  `start_date` date NOT NULL,
  `end_date` date DEFAULT NULL,
  `is_current` tinyint(1) NOT NULL DEFAULT 0,
  `description` text DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `experiences`
--

INSERT INTO `experiences` (`id`, `role`, `company`, `location`, `start_date`, `end_date`, `is_current`, `description`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'Leader Of Art Section', 'Organisasi Sekolah', 'Sukadiri', '2020-01-01', '2021-01-01', 0, 'Memimpin squad pengembangan kesenian dalam instansi', '2025-12-11 12:23:10', '2025-12-18 12:02:36', NULL),
(2, 'Anggota Himpunan Mahasiswa Komputer', 'Universitas', 'Tangerang', '2025-10-02', '2026-10-02', 1, 'Membangun relasi dan menjadi pengembangan sumber dasa manusia', '2025-12-11 12:23:10', '2025-12-18 12:04:50', NULL);

-- --------------------------------------------------------

--
-- Struktur dari tabel `messages`
--

CREATE TABLE `messages` (
  `id` int(11) UNSIGNED NOT NULL,
  `name` varchar(120) NOT NULL,
  `email` varchar(150) NOT NULL,
  `subject` varchar(150) DEFAULT NULL,
  `message` text NOT NULL,
  `is_read` tinyint(1) NOT NULL DEFAULT 0,
  `read_at` datetime DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `messages`
--

INSERT INTO `messages` (`id`, `name`, `email`, `subject`, `message`, `is_read`, `read_at`, `created_at`, `updated_at`) VALUES
(2, 'fatchul', 'lapoh0@gmail.com', 'penting', 'ngopiiiiiiiiiiiiiiiiii', 1, '2025-12-18 22:53:48', '2025-12-18 22:52:47', '2025-12-18 22:53:48');

-- --------------------------------------------------------

--
-- Struktur dari tabel `migrations`
--

CREATE TABLE `migrations` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `version` varchar(255) NOT NULL,
  `class` varchar(255) NOT NULL,
  `group` varchar(255) NOT NULL,
  `namespace` varchar(255) NOT NULL,
  `time` int(11) NOT NULL,
  `batch` int(11) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `migrations`
--

INSERT INTO `migrations` (`id`, `version`, `class`, `group`, `namespace`, `time`, `batch`) VALUES
(1, '2025-12-10-194736', 'App\\Database\\Migrations\\CreateUsersTable', 'default', 'App', 1765398224, 1),
(2, '2025-12-10-194745', 'App\\Database\\Migrations\\CreateSettingsTable', 'default', 'App', 1765398224, 1),
(3, '2025-12-10-194801', 'App\\Database\\Migrations\\CreateSkillsTable', 'default', 'App', 1765398224, 1),
(4, '2025-12-10-194806', 'App\\Database\\Migrations\\CreateProjectsTable', 'default', 'App', 1765398224, 1),
(5, '2025-12-10-194821', 'App\\Database\\Migrations\\CreateExperiencesTable', 'default', 'App', 1765398224, 1),
(6, '2025-12-10-194843', 'App\\Database\\Migrations\\CreateMessagesTable', 'default', 'App', 1765398224, 1),
(7, '2025-12-10-202626', 'App\\Database\\Migrations\\CreateActivitiesTable', 'default', 'App', 1765399527, 2),
(8, '2025-12-10-202633', 'App\\Database\\Migrations\\CreateEducationsTable', 'default', 'App', 1765399527, 2),
(9, '2025-12-10-202641', 'App\\Database\\Migrations\\CreateProfileTable', 'default', 'App', 1765399527, 2),
(10, '2025-12-10-204645', 'App\\Database\\Migrations\\AddRememberTokenToUsers', 'default', 'App', 1765400549, 3),
(11, '2025-12-10-204751', 'App\\Database\\Migrations\\AddSortOrderToEducations', 'default', 'App', 1765400549, 3),
(12, '2025-12-11-112900', 'App\\Database\\Migrations\\UpdateBiodataAndSocialLinks', 'default', 'App', 1765428560, 4),
(13, '2025-12-11-113200', 'App\\Database\\Migrations\\AddPortfolioIndexes', 'default', 'App', 1765428560, 4),
(14, '2025-12-11-115000', 'App\\Database\\Migrations\\CreateAdminActivityLogs', 'default', 'App', 1765430205, 5);

-- --------------------------------------------------------

--
-- Struktur dari tabel `projects`
--

CREATE TABLE `projects` (
  `id` int(11) UNSIGNED NOT NULL,
  `title` varchar(150) NOT NULL,
  `slug` varchar(160) NOT NULL,
  `summary` text DEFAULT NULL,
  `description` mediumtext DEFAULT NULL,
  `technologies` varchar(255) DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `project_url` varchar(255) DEFAULT NULL,
  `client` varchar(120) DEFAULT NULL,
  `completed_at` date DEFAULT NULL,
  `is_featured` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `projects`
--

INSERT INTO `projects` (`id`, `title`, `slug`, `summary`, `description`, `technologies`, `image`, `project_url`, `client`, `completed_at`, `is_featured`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'Membuat sistem aktivasi rekening Online', 'membuat-sistem-aktivasi-rekening-online', 'Platform aktivasi rekening online', 'memudahkan pengguna untuk aktivasi rekening berbasis online, tidak perlu ketempat, dari hp pun bisa!', 'PhpMyAdmin, MySQL, Java Script', NULL, 'https://example.com/saas', 'Training', '2025-02-20', 1, '2025-12-11 12:23:10', '2025-12-19 00:07:19', NULL),
(2, 'Portfolio', 'portfolio', 'Portfolio pribadi menggunakan cedeignitor dan PHP', 'Portfolio yang menarik publik', 'CodeIgniter 4, Bootstrap 5, Tailwind CSS', 'uploads/projects/1766077389_24aba2f47d4fdbaad769.png', 'https://example.com/umkm', 'Training', '2025-12-11', 1, '2025-12-11 12:23:10', '2025-12-19 00:03:09', NULL),
(3, 'Sistem Lampu Otomatis', 'sistem-lampu-otomatis', 'Sistem Lampu otomatis berbasis LDR', 'Lampu cerdas yang bisa dikendalikan sesuai dengan keadaan cuaca, Jika cuaca gelap/malam maka lampu akan menyala, dan jika cuaca terang/siang maka lampu akan mati otomatis', 'Arduino UNO, Arduino IDE', NULL, 'https://example.com/company', 'Training', '2025-12-11', 1, '2025-12-11 12:23:10', '2025-12-19 00:07:00', NULL);

-- --------------------------------------------------------

--
-- Struktur dari tabel `settings`
--

CREATE TABLE `settings` (
  `id` int(11) UNSIGNED NOT NULL,
  `key` varchar(100) NOT NULL,
  `value` text DEFAULT NULL,
  `type` varchar(50) NOT NULL DEFAULT 'text',
  `section` varchar(50) NOT NULL DEFAULT 'general',
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `settings`
--

INSERT INTO `settings` (`id`, `key`, `value`, `type`, `section`, `created_at`, `updated_at`) VALUES
(1, 'hero_headline', 'Halo, Iam Zaky.', 'text', 'hero', '2025-12-11 12:23:10', '2025-12-18 08:14:49'),
(2, 'hero_headline_en', 'Hello, I’m Zaky.', 'text', 'hero', '2025-12-11 12:23:10', '2025-12-18 08:14:49'),
(3, 'hero_subheadline', 'Web developer yang fokus pada pengalaman pengguna.', 'text', 'hero', '2025-12-11 12:23:10', '2025-12-18 08:14:49'),
(4, 'hero_subheadline_en', 'Web developer focused on delightful experiences.', 'text', 'hero', '2025-12-11 12:23:10', '2025-12-18 08:14:49'),
(5, 'hero_cta_text', 'Lihat Portofolio', 'text', 'hero', '2025-12-11 12:23:10', '2025-12-18 08:14:49'),
(6, 'hero_cta_link', '#projects', 'url', 'hero', '2025-12-11 12:23:10', '2025-12-18 08:14:49'),
(7, 'about_summary', 'Lebih dari 3 tahun membangun aplikasi web modern untuk startup dan enterprise.', 'text', 'about', '2025-12-11 12:23:10', '2025-12-18 08:14:49'),
(8, 'about_summary_en', 'Over Three years building modern web apps for startups and enterprises.', 'text', 'about', '2025-12-11 12:23:10', '2025-12-18 08:14:49'),
(9, 'about_description', 'Saya menggabungkan analisis bisnis dan craft engineering untuk menghadirkan solusi digital yang berdampak. Saat ini fokus pada PHP, JavaScript, dan cloud-native stack.', 'textarea', 'about', '2025-12-11 12:23:10', '2025-12-18 08:14:49'),
(10, 'about_description_en', 'I blend business analysis with thoughtful engineering to ship impactful digital products. Focused on PHP, JavaScript, and cloud-native stacks.', 'textarea', 'about', '2025-12-11 12:23:10', '2025-12-18 08:14:49'),
(11, 'contact_email', 'zakynurfaiz08@gmail.com', 'email', 'contact', '2025-12-11 12:23:10', '2025-12-18 08:14:49'),
(12, 'contact_phone', '+62 858 9027 5879', 'text', 'contact', '2025-12-11 12:23:10', '2025-12-18 08:14:49'),
(13, 'contact_address', 'Tangerang, Indonesia', 'text', 'contact', '2025-12-11 12:23:10', '2025-12-18 08:14:49'),
(14, 'social_linkedin', 'https://www.linkedin.com/in/zaky-nurfaiz', 'url', 'social', '2025-12-11 12:23:10', '2025-12-18 08:14:49'),
(15, 'social_github', 'https://github.com/muzaky08', 'url', 'social', '2025-12-11 12:23:10', '2025-12-18 08:14:49'),
(16, 'meta_keywords', 'portfolio, developer, codeigniter', 'text', 'seo', '2025-12-11 12:23:10', '2025-12-18 08:14:49'),
(17, 'meta_keywords_en', 'portfolio, web developer, codeigniter', 'text', 'seo', '2025-12-11 12:23:10', '2025-12-18 08:14:49'),
(18, 'analytics_measurement_id', '', 'text', 'analytics', '2025-12-11 12:23:10', '2025-12-18 08:14:49');

-- --------------------------------------------------------

--
-- Struktur dari tabel `skills`
--

CREATE TABLE `skills` (
  `id` int(11) UNSIGNED NOT NULL,
  `name` varchar(100) NOT NULL,
  `category` varchar(60) NOT NULL DEFAULT 'general',
  `level` int(3) NOT NULL DEFAULT 80,
  `description` text DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `skills`
--

INSERT INTO `skills` (`id`, `name`, `category`, `level`, `description`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'PHP & CodeIgniter', 'Frontend', 89, 'Membangun REST API dan aplikasi modular dengan CI4 dan Laravel.', '2025-12-11 12:23:10', '2025-12-18 22:38:06', NULL),
(2, 'JavaScript', 'Frontend', 85, 'Menyusun komponen UI yang interaktif dan nyaman bagi pengguna', '2025-12-11 12:23:10', '2025-12-18 22:38:37', NULL);

-- --------------------------------------------------------

--
-- Struktur dari tabel `social_links`
--

CREATE TABLE `social_links` (
  `id` int(11) UNSIGNED NOT NULL,
  `biodata_id` int(11) UNSIGNED NOT NULL,
  `label` varchar(100) NOT NULL,
  `url` varchar(255) NOT NULL,
  `icon` varchar(60) DEFAULT NULL,
  `sort_order` int(11) NOT NULL DEFAULT 0,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `social_links`
--

INSERT INTO `social_links` (`id`, `biodata_id`, `label`, `url`, `icon`, `sort_order`, `created_at`, `updated_at`) VALUES
(34, 1, 'LinkedIn', 'https://www.linkedin.com/in/zaky-nurfaiz', 'bi-linkedin', 0, '2025-12-18 23:50:50', '2025-12-18 23:50:50'),
(35, 1, 'GitHub', 'https://github.com/muzaky08', 'bi-github', 1, '2025-12-18 23:50:50', '2025-12-18 23:50:50'),
(36, 1, 'Twitter', 'https://twitter.com/zakynurfaiz', 'bi-twitter', 2, '2025-12-18 23:50:50', '2025-12-18 23:50:50'),
(37, 1, 'Instagram', 'https://www.instagram.com/zky.nf?igsh=MTJvNjlpOGs4anE2NQ==', 'bi-link-45deg', 3, '2025-12-18 23:50:50', '2025-12-18 23:50:50');

-- --------------------------------------------------------

--
-- Struktur dari tabel `users`
--

CREATE TABLE `users` (
  `id` int(11) UNSIGNED NOT NULL,
  `full_name` varchar(120) NOT NULL,
  `username` varchar(80) NOT NULL,
  `email` varchar(120) NOT NULL,
  `password_hash` varchar(255) NOT NULL,
  `role` varchar(20) NOT NULL DEFAULT 'admin',
  `last_login_at` datetime DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  `remember_token` varchar(255) DEFAULT NULL,
  `remember_expires_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `users`
--

INSERT INTO `users` (`id`, `full_name`, `username`, `email`, `password_hash`, `role`, `last_login_at`, `created_at`, `updated_at`, `deleted_at`, `remember_token`, `remember_expires_at`) VALUES
(1, 'Super Admin', 'admin', 'admin@example.com', '$2y$10$vvhYYN/wtCwZgXZ5GgqMnOSpW3U08Ek0l8oqQ1pNC9LjOLJ1uJIse', 'admin', NULL, '2025-12-11 12:23:10', '2025-12-11 12:23:10', NULL, NULL, NULL),
(2, 'zaky', 'mznf08', 'muzakynf@gmail.com', '$2y$10$USv5MY8MY.5QnkZPPjs5WO9hykshueke9NmC9d9wZvyP7Cy8KD8gK', 'admin', '2025-12-18 00:41:25', '2025-12-11 16:41:41', '2025-12-18 08:15:15', NULL, NULL, NULL),
(3, 'Muzaky', 'Muzaky.08', 'zakynurfaiz08@gmail.com', '$2y$10$bJakWmkc323y.TtZUiix1u6HsNcdvTSLQqCNUIk8/f1hiP0VyUiZu', 'admin', '2025-12-18 22:53:14', '2025-12-18 08:16:34', '2025-12-18 22:53:14', NULL, NULL, NULL);

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `activities`
--
ALTER TABLE `activities`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_activities_activity_date` (`activity_date`),
  ADD KEY `idx_activities_category` (`category`),
  ADD KEY `idx_activities_title` (`title`);

--
-- Indeks untuk tabel `admin_activity_logs`
--
ALTER TABLE `admin_activity_logs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `action` (`action`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `created_at` (`created_at`);

--
-- Indeks untuk tabel `biodata`
--
ALTER TABLE `biodata`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `educations`
--
ALTER TABLE `educations`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_educations_level` (`level`),
  ADD KEY `idx_educations_start_year` (`start_year`);

--
-- Indeks untuk tabel `experiences`
--
ALTER TABLE `experiences`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `messages`
--
ALTER TABLE `messages`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `projects`
--
ALTER TABLE `projects`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `slug` (`slug`),
  ADD KEY `idx_projects_completed_at` (`completed_at`);

--
-- Indeks untuk tabel `settings`
--
ALTER TABLE `settings`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `key` (`key`);

--
-- Indeks untuk tabel `skills`
--
ALTER TABLE `skills`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_skills_name` (`name`),
  ADD KEY `idx_skills_category` (`category`);

--
-- Indeks untuk tabel `social_links`
--
ALTER TABLE `social_links`
  ADD PRIMARY KEY (`id`),
  ADD KEY `biodata_id` (`biodata_id`),
  ADD KEY `label` (`label`);

--
-- Indeks untuk tabel `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `activities`
--
ALTER TABLE `activities`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT untuk tabel `admin_activity_logs`
--
ALTER TABLE `admin_activity_logs`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=54;

--
-- AUTO_INCREMENT untuk tabel `biodata`
--
ALTER TABLE `biodata`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT untuk tabel `educations`
--
ALTER TABLE `educations`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT untuk tabel `experiences`
--
ALTER TABLE `experiences`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT untuk tabel `messages`
--
ALTER TABLE `messages`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT untuk tabel `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT untuk tabel `projects`
--
ALTER TABLE `projects`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT untuk tabel `settings`
--
ALTER TABLE `settings`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT untuk tabel `skills`
--
ALTER TABLE `skills`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT untuk tabel `social_links`
--
ALTER TABLE `social_links`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=38;

--
-- AUTO_INCREMENT untuk tabel `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `social_links`
--
ALTER TABLE `social_links`
  ADD CONSTRAINT `social_links_biodata_id_foreign` FOREIGN KEY (`biodata_id`) REFERENCES `biodata` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

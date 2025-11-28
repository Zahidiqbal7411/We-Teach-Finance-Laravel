-- phpMyAdmin SQL Dump
-- version 5.2.2
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Nov 28, 2025 at 06:37 AM
-- Server version: 10.6.19-MariaDB-cll-lve
-- PHP Version: 8.4.14

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `mmmtapp_vteach`
--

-- --------------------------------------------------------

--
-- Table structure for table `acc_courses`
--

CREATE TABLE `acc_courses` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `course_title` varchar(255) NOT NULL,
  `edu_system_id` bigint(20) UNSIGNED NOT NULL,
  `exam_board_id` bigint(20) UNSIGNED NOT NULL,
  `subject_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `acc_courses`
--

INSERT INTO `acc_courses` (`id`, `course_title`, `edu_system_id`, `exam_board_id`, `subject_id`, `created_at`, `updated_at`) VALUES
(2, 'A-Level Physics', 5, 4, 7, '2025-11-13 22:41:20', '2025-11-13 22:41:20'),
(4, 'IGCSE Mathematics', 5, 4, 6, '2025-11-13 22:51:25', '2025-11-13 22:51:25'),
(6, 'SAT Math Prep', 4, 4, 6, '2025-11-13 22:58:36', '2025-11-13 22:58:36'),
(7, 'SAT Math Prep', 4, 4, 6, '2025-11-13 23:00:40', '2025-11-13 23:00:40'),
(8, 'SAT Math Prep', 6, 5, 8, '2025-11-13 23:05:13', '2025-11-13 23:05:13'),
(9, 'IB Chemistry HL', 4, 5, 10, '2025-11-13 23:06:21', '2025-11-13 23:06:21'),
(11, 'English', 4, 6, 8, '2025-11-16 02:37:13', '2025-11-16 02:37:13');

-- --------------------------------------------------------

--
-- Table structure for table `acc_currencies`
--

CREATE TABLE `acc_currencies` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `currency_name` varchar(100) NOT NULL,
  `exchange_rate` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `acc_currencies`
--

INSERT INTO `acc_currencies` (`id`, `currency_name`, `exchange_rate`, `created_at`, `updated_at`) VALUES
(1, 'USD', ' 40.85', '2025-11-05 17:41:49', '2025-11-06 13:46:52'),
(2, 'EGP', '40', '2025-11-10 17:41:53', '2025-11-06 13:46:52'),
(3, 'EURO', '33.42', '2025-11-03 17:41:56', '2025-11-06 13:46:52'),
(5, 'AED', '45', '2025-11-25 00:47:34', '2025-11-25 00:47:34');

-- --------------------------------------------------------

--
-- Table structure for table `acc_settings`
--

CREATE TABLE `acc_settings` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `type` varchar(45) NOT NULL,
  `value` varchar(45) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `acc_settings`
--

INSERT INTO `acc_settings` (`id`, `type`, `value`, `created_at`, `updated_at`) VALUES
(1, 'admin-pin', '123433', NULL, '2025-11-06 12:52:11'),
(2, 'session_timeout', '1', NULL, '2025-11-16 02:20:41'),
(3, 'email_notification', '1', NULL, '2025-11-07 00:50:59'),
(4, 'payment_alert', '0', NULL, '2025-11-06 13:43:50'),
(5, 'low_balance_warning', '1', NULL, '2025-11-16 02:21:03'),
(6, 'default_currency', '2', NULL, '2025-11-28 16:37:10');

-- --------------------------------------------------------

--
-- Table structure for table `acc_taxonomies_educational_systems`
--

CREATE TABLE `acc_taxonomies_educational_systems` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `educational_title` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `acc_taxonomies_educational_systems`
--

INSERT INTO `acc_taxonomies_educational_systems` (`id`, `educational_title`, `created_at`, `updated_at`) VALUES
(4, 'British System', '2025-11-13 22:33:46', '2025-11-13 22:33:46'),
(5, 'American System', '2025-11-13 22:33:53', '2025-11-13 22:33:53'),
(6, 'Egyptian System', '2025-11-13 22:34:00', '2025-11-13 22:34:00'),
(7, 'International Baccalaureate', '2025-11-13 22:34:07', '2025-11-13 22:34:07'),
(8, 'French System', '2025-11-13 22:34:17', '2025-11-13 22:34:17');

-- --------------------------------------------------------

--
-- Table structure for table `acc_taxonomies_examination_boards`
--

CREATE TABLE `acc_taxonomies_examination_boards` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `examination_board_title` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `acc_taxonomies_examination_boards`
--

INSERT INTO `acc_taxonomies_examination_boards` (`id`, `examination_board_title`, `created_at`, `updated_at`) VALUES
(4, 'Cambridge IGCSE', '2025-11-13 22:35:11', '2025-11-13 22:35:11'),
(5, 'Edexcel', '2025-11-13 22:35:17', '2025-11-13 22:35:17'),
(6, 'AQA', '2025-11-13 22:35:24', '2025-11-13 22:35:24'),
(7, 'OCR', '2025-11-13 22:35:29', '2025-11-13 22:35:29'),
(8, 'IB Organization', '2025-11-13 22:35:38', '2025-11-13 22:35:38'),
(9, 'Egyptian Ministry of Education', '2025-11-13 22:35:44', '2025-11-13 22:35:44');

-- --------------------------------------------------------

--
-- Table structure for table `acc_taxonomies_sessions`
--

CREATE TABLE `acc_taxonomies_sessions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `session_title` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `acc_taxonomies_sessions`
--

INSERT INTO `acc_taxonomies_sessions` (`id`, `session_title`, `created_at`, `updated_at`) VALUES
(6, 'May/June 2026', '2025-11-13 22:35:50', '2025-11-13 22:35:50'),
(7, 'October/November 2025', '2025-11-13 22:35:55', '2025-11-13 22:35:55'),
(8, 'May/June 2025', '2025-11-13 22:35:59', '2025-11-13 22:35:59'),
(9, 'October/November 2024', '2025-11-13 22:36:04', '2025-11-13 22:36:04');

-- --------------------------------------------------------

--
-- Table structure for table `acc_taxonomies_subjects`
--

CREATE TABLE `acc_taxonomies_subjects` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `subject_title` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `acc_taxonomies_subjects`
--

INSERT INTO `acc_taxonomies_subjects` (`id`, `subject_title`, `created_at`, `updated_at`) VALUES
(6, 'Mathematics', '2025-11-13 22:34:23', '2025-11-13 22:34:23'),
(7, 'Physics', '2025-11-13 22:34:28', '2025-11-13 22:34:28'),
(8, 'Chemistry', '2025-11-13 22:34:34', '2025-11-13 22:34:34'),
(9, 'Biology', '2025-11-13 22:34:40', '2025-11-13 22:34:40'),
(10, 'English Language', '2025-11-13 22:34:45', '2025-11-13 22:34:45'),
(11, 'Arabic Language', '2025-11-13 22:34:51', '2025-11-13 22:34:51'),
(12, 'History', '2025-11-13 22:34:56', '2025-11-13 22:34:56'),
(13, 'Geography', '2025-11-13 22:35:01', '2025-11-13 22:35:01');

-- --------------------------------------------------------

--
-- Table structure for table `acc_teachers`
--

CREATE TABLE `acc_teachers` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `teacher_name` varchar(255) DEFAULT NULL,
  `teacher_contact` varchar(255) DEFAULT NULL,
  `teacher_email` varchar(255) DEFAULT NULL,
  `teacher_other_info` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `acc_teachers`
--

INSERT INTO `acc_teachers` (`id`, `teacher_name`, `teacher_contact`, `teacher_email`, `teacher_other_info`, `created_at`, `updated_at`) VALUES
(2, 'Dr. Ahmed Hassan', '03242342342', 'ahmed.hassan@weteach.com', 'no', '2025-11-13 22:37:53', '2025-11-13 22:37:53'),
(3, 'Prof. Sarah Johnson', '03242342342', 'sarah.johnson@weteach.com', 'testing', '2025-11-13 22:40:29', '2025-11-13 22:40:29'),
(4, 'Dr. Mohamed Ali', '03242342342', 'mohamed.ali@weteach.com', 'test', '2025-11-13 22:43:52', '2025-11-13 22:43:52'),
(5, 'Ms. Emily Davis', '03242342342', 'emily.davis@weteach.com', 'no', '2025-11-13 23:07:38', '2025-11-13 23:07:38'),
(6, 'Dr. Fatima Al-Zahra', '03242342342', 'fatima.alzahra@weteach.com', 'test', '2025-11-13 23:08:11', '2025-11-13 23:08:11');

-- --------------------------------------------------------

--
-- Table structure for table `acc_teacher_courses`
--

CREATE TABLE `acc_teacher_courses` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `teacher_id` bigint(20) UNSIGNED NOT NULL,
  `course_id` bigint(20) UNSIGNED NOT NULL,
  `teacher_percentage` decimal(10,2) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `acc_teacher_courses`
--

INSERT INTO `acc_teacher_courses` (`id`, `teacher_id`, `course_id`, `teacher_percentage`, `created_at`, `updated_at`) VALUES
(2, 4, 2, 65.00, '2025-11-13 22:45:07', '2025-11-13 22:45:07'),
(4, 2, 4, 70.00, '2025-11-13 22:56:24', '2025-11-13 22:56:24'),
(9, 2, 2, 75.00, '2025-11-13 23:01:21', '2025-11-13 23:01:21'),
(10, 3, 2, 75.00, '2025-11-13 23:01:46', '2025-11-13 23:01:46'),
(22, 16, 2, 50.00, '2025-11-16 23:09:38', '2025-11-16 23:09:38'),
(24, 17, 2, 50.00, '2025-11-17 10:22:34', '2025-11-17 10:22:34'),
(25, 15, 2, 50.00, '2025-11-17 10:30:02', '2025-11-17 10:30:02'),
(26, 14, 2, 50.00, '2025-11-17 10:37:18', '2025-11-17 10:37:18'),
(27, 3, 4, 50.00, '2025-11-17 10:38:59', '2025-11-17 10:38:59'),
(28, 9, 2, 50.00, '2025-11-17 11:41:12', '2025-11-17 11:41:12'),
(29, 6, 7, 50.00, '2025-11-17 11:45:17', '2025-11-17 11:45:17'),
(30, 5, 8, 50.00, '2025-11-17 11:52:15', '2025-11-17 11:52:15'),
(32, 6, 2, 50.00, '2025-11-17 11:56:58', '2025-11-17 11:56:58'),
(40, 5, 2, 50.00, '2025-11-17 12:16:42', '2025-11-17 12:16:42'),
(79, 5, 6, 50.00, '2025-11-17 14:53:08', '2025-11-17 14:53:08'),
(80, 5, 9, 60.00, '2025-11-17 14:53:26', '2025-11-17 14:53:26'),
(84, 2, 6, 50.00, '2025-11-17 20:54:30', '2025-11-17 20:54:30'),
(92, 2, 9, 50.00, '2025-11-18 11:10:50', '2025-11-18 11:10:50'),
(96, 2, 8, 50.00, '2025-11-18 11:19:10', '2025-11-18 11:19:10');

-- --------------------------------------------------------

--
-- Table structure for table `acc_transactions`
--

CREATE TABLE `acc_transactions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `teacher_id` bigint(20) UNSIGNED NOT NULL,
  `course_id` bigint(20) UNSIGNED NOT NULL,
  `session_id` bigint(20) UNSIGNED NOT NULL,
  `student_name` varchar(255) NOT NULL,
  `parent_name` varchar(255) NOT NULL,
  `student_email` varchar(255) DEFAULT NULL,
  `student_contact` varchar(255) DEFAULT NULL,
  `course_fee` int(11) DEFAULT NULL,
  `note_fee` int(11) DEFAULT NULL,
  `total` decimal(10,2) NOT NULL,
  `paid_amount` decimal(10,2) NOT NULL,
  `selected_currency` bigint(20) UNSIGNED NOT NULL DEFAULT 0,
  `platform_amount` bigint(20) DEFAULT NULL,
  `teacher_amount` bigint(20) DEFAULT NULL,
  `express_course_id` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `acc_transactions`
--

INSERT INTO `acc_transactions` (`id`, `teacher_id`, `course_id`, `session_id`, `student_name`, `parent_name`, `student_email`, `student_contact`, `course_fee`, `note_fee`, `total`, `paid_amount`, `selected_currency`, `platform_amount`, `teacher_amount`, `express_course_id`, `created_at`, `updated_at`) VALUES
(1, 2, 9, 6, 'Student We Teach', 'Parent We Teach', 'zahor@gmail.com', '+97399552347', 100, 50, 150.00, 150.00, 2, 50, 100, NULL, '2025-11-28 15:25:33', '2025-11-28 15:25:33'),
(2, 2, 9, 6, 'Khaled tharwat mahmoud', 'hukam dad', 'platform@gmail.com', '03449203130', 100, 50, 150.00, 150.00, 2, 50, 100, NULL, '2025-11-28 15:26:10', '2025-11-28 15:26:10'),
(3, 2, 9, 6, 'Student We Teach', 'hukam dad', 'khaledth338@gmail.com', '+971', 7500, 50, 7550.00, 7550.00, 2, 3750, 3800, 127, '2025-11-28 15:26:49', '2025-11-28 15:26:49'),
(4, 2, 2, 6, 'tharwat', 'mahmoud', '1111@gmail.com', '212', 1220, 10, 1230.00, 100.00, 2, 305, 925, NULL, '2025-11-28 16:12:27', '2025-11-28 16:12:27'),
(5, 5, 8, 6, 'Student We Teach', 'Parent We Teach', 'm@gmail.com', '+97399552347', 16000, 0, 16000.00, 11000.00, 2, 8000, 8000, 9, '2025-11-28 16:37:25', '2025-11-28 16:37:25');

-- --------------------------------------------------------

--
-- Table structure for table `acc_transaction_payments`
--

CREATE TABLE `acc_transaction_payments` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `transaction_id` bigint(20) UNSIGNED DEFAULT NULL,
  `paid_amount` decimal(10,2) NOT NULL,
  `type` varchar(255) NOT NULL DEFAULT 'platform',
  `remarks` varchar(250) DEFAULT NULL,
  `teacher_id` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `acc_transaction_payments`
--

INSERT INTO `acc_transaction_payments` (`id`, `transaction_id`, `paid_amount`, `type`, `remarks`, `teacher_id`, `created_at`, `updated_at`) VALUES
(1, 1, 150.00, 'platform', NULL, NULL, '2025-11-28 15:25:33', '2025-11-28 15:25:33'),
(2, 2, 150.00, 'platform', NULL, 2, '2025-11-28 15:26:10', '2025-11-28 15:26:10'),
(3, 3, 7550.00, 'platform', NULL, 2, '2025-11-28 15:26:49', '2025-11-28 15:26:49'),
(4, 4, 100.00, 'platform', NULL, 2, '2025-11-28 16:12:27', '2025-11-28 16:12:27'),
(5, 5, 11000.00, 'platform', NULL, 5, '2025-11-28 16:37:25', '2025-11-28 16:37:25');

-- --------------------------------------------------------

--
-- Table structure for table `acc_transaction_payouts`
--

CREATE TABLE `acc_transaction_payouts` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `transaction_id` bigint(20) UNSIGNED DEFAULT NULL,
  `selected_currency` bigint(20) UNSIGNED NOT NULL,
  `session_id` bigint(20) UNSIGNED NOT NULL,
  `course_id` bigint(20) UNSIGNED DEFAULT NULL,
  `teacher_id` bigint(20) UNSIGNED DEFAULT NULL,
  `paid_amount` decimal(10,2) NOT NULL,
  `type` varchar(255) NOT NULL,
  `remarks` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `acc_transaction_payouts`
--

INSERT INTO `acc_transaction_payouts` (`id`, `transaction_id`, `selected_currency`, `session_id`, `course_id`, `teacher_id`, `paid_amount`, `type`, `remarks`, `created_at`, `updated_at`) VALUES
(1, NULL, 2, 6, NULL, NULL, 50.00, 'platform', 'nothing', '2025-11-28 15:28:52', '2025-11-28 15:28:52');

-- --------------------------------------------------------

--
-- Table structure for table `acc_users`
--

CREATE TABLE `acc_users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(191) NOT NULL,
  `email` varchar(191) NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(191) NOT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `acc_users`
--

INSERT INTO `acc_users` (`id`, `name`, `email`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'Test User', 'test@example.com', '2025-11-24 01:19:14', '$2y$12$jkaexTUT5geK9ZIcpJ88M.LqsqZI1mCGCzRgIpmHZVQ1MBSGWC0/a', 'amRw20yyBi', '2025-11-24 01:19:14', '2025-11-24 01:19:14'),
(2, 'Admin User', 'admin@gmail.com', '2025-11-24 01:19:42', '$2y$12$nde9I8gAQZZC/B4cn2PbAeXCWXd5UnMx4qRMQ8QhciNO3akr6aHOy', NULL, '2025-11-24 01:19:42', '2025-11-24 01:19:42');

-- --------------------------------------------------------

--
-- Table structure for table `cache`
--

CREATE TABLE `cache` (
  `key` varchar(191) NOT NULL,
  `value` mediumtext NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cache_locks`
--

CREATE TABLE `cache_locks` (
  `key` varchar(191) NOT NULL,
  `owner` varchar(191) NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` varchar(191) NOT NULL,
  `connection` text NOT NULL,
  `queue` text NOT NULL,
  `payload` longtext NOT NULL,
  `exception` longtext NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `jobs`
--

CREATE TABLE `jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `queue` varchar(191) NOT NULL,
  `payload` longtext NOT NULL,
  `attempts` tinyint(3) UNSIGNED NOT NULL,
  `reserved_at` int(10) UNSIGNED DEFAULT NULL,
  `available_at` int(10) UNSIGNED NOT NULL,
  `created_at` int(10) UNSIGNED NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `job_batches`
--

CREATE TABLE `job_batches` (
  `id` varchar(191) NOT NULL,
  `name` varchar(191) NOT NULL,
  `total_jobs` int(11) NOT NULL,
  `pending_jobs` int(11) NOT NULL,
  `failed_jobs` int(11) NOT NULL,
  `failed_job_ids` longtext NOT NULL,
  `options` mediumtext DEFAULT NULL,
  `cancelled_at` int(11) DEFAULT NULL,
  `created_at` int(11) NOT NULL,
  `finished_at` int(11) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `jwy_express_courses`
--

CREATE TABLE `jwy_express_courses` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(99) DEFAULT NULL,
  `email` varchar(99) DEFAULT NULL,
  `whatsapp` varchar(99) DEFAULT NULL,
  `parent_name` varchar(99) DEFAULT NULL,
  `parent_email` varchar(99) DEFAULT NULL,
  `parent_whatsapp` varchar(99) DEFAULT NULL,
  `country` varchar(99) DEFAULT NULL,
  `educational_system` text NOT NULL,
  `subject` text NOT NULL,
  `examination_board` text NOT NULL,
  `course` text NOT NULL,
  `pay_status` varchar(99) NOT NULL,
  `course_other` text NOT NULL,
  `origional_price` varchar(99) DEFAULT NULL,
  `origional_price_currency` varchar(99) NOT NULL,
  `origional_price_amount` varchar(99) NOT NULL,
  `paid_amount` varchar(99) NOT NULL,
  `custom_link` text NOT NULL,
  `students_notes` text NOT NULL,
  `admin_notes` text NOT NULL,
  `timestamp_req` varchar(45) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `jwy_express_courses`
--

INSERT INTO `jwy_express_courses` (`id`, `name`, `email`, `whatsapp`, `parent_name`, `parent_email`, `parent_whatsapp`, `country`, `educational_system`, `subject`, `examination_board`, `course`, `pay_status`, `course_other`, `origional_price`, `origional_price_currency`, `origional_price_amount`, `paid_amount`, `custom_link`, `students_notes`, `admin_notes`, `timestamp_req`) VALUES
(8, 'oGGznFlALV', 'ywileyp19@gmail.com', '+263eDisVjXNSGyZH', 'CIgjXDLNu', 'ywileyp19@gmail.com', '+263pNpvMUGQf', 'Zimbabwe', 'Younger Grades', 'NUibVKggKAeN', 'XpLzGTTgupk', 'wZzuzNPdmVB', 'now', '', '', '', '', '', 'OWMxMTFjNjFkMDJjMjA5ZjI5YzA5NjJhYmUxOGYxNzVmODQ3N2QyMjlhMDhlMTlmOTAxYjJkMjExNDFiMDRjNg..', '', '', '03-07-2025 20:28'),
(9, 'Student We Teach', 'm@gmail.com', '+97399552347', 'Parent We Teach', 'o@gail.cco', '+97190975112', 'United Arab Emirates', 'IGCSE-OL', 'Biology', 'Cambridge', 'IGCSE – Biology – OL – Cambridge – Jun25 [Dr Gehan Fares]', 'now', '', 'EGP 16000', 'EGP', '16000', '', 'NTkwNGM2NjA4NDFiMWQ3YTYzMDAyYjFhOTY2MzQ2MTgxYWJkOTdlODk2OTc4N2VjZmNmMjZjMTVhZGI2NWY0Zg..', '', '00', '03-07-2025 22:42'),
(10, 'ACmDIjxNxuI', 'walomiha13@gmail.com', '+263pEjwqzWpg', 'rYgGiayPvKSxZ', 'walomiha13@gmail.com', '+263dSBFfceoKAh', 'Zimbabwe', 'Younger Grades', 'sYrHGGWmgxwlLXd', 'MWDFDAxHd', 'DTkzjqXz', 'now', '', '', '', '', '', 'NzU5ODU3YWJlZDg1MGZkNmJkY2YwYWVlYjQ5MzJmZmZhYWMwZDE5MDAxNjI0ZmJkOGJiZTI2OWNmY2I1NzllZQ..', '', '', '04-07-2025 22:48'),
(11, 'zLiCTgIEN', 'vehaden842@gmail.com', '+263EIyzUJaNaBNYei', 'hPQzVxtBca', 'vehaden842@gmail.com', '+263ldyGuXXHhBHx', 'Zimbabwe', 'Younger Grades', 'GyECZZEbO', 'ShjsRTjSTS', 'KNLwMzAblOJ', 'now', '', '', '', '', '', 'ZTNmODBhYWExMzIwNTg2ZTM4Zjk2NzE4YmRmNTUxNzIyMWY5OWIzN2RjOTY5MTU1MzIwZDdmMzgwMDRkOTE2OQ..', '', '', '05-07-2025 02:16'),
(12, 'yBXjzlWza', 'ifizuzu218@gmail.com', '+263SzuLikXTqfNFhO', 'qrcBxNpU', 'ifizuzu218@gmail.com', '+263TSaIFkSRId', 'Zimbabwe', 'Younger Grades', 'wTAjQkxfXgY', 'mQukmBIm', 'RuzPbVVoNDahNL', 'now', '', '', '', '', '', 'NjRiNTc1ZmEwMzAwNjZlNGY2N2ZhMzk1YWFhMzA2YmQ0ZTQyZmYxZGNjMWQ2NDE5ZjY1ZWFkOGUwOTA0ZWI1MQ..', '', '', '05-07-2025 04:47'),
(13, 'STXqpKhBogF', 'thomaslori871087@yahoo.com', '+263SHULGEbZUTGw', 'QQJtHvxeTfrB', 'thomaslori871087@yahoo.com', '+263tpZpWpXe', 'Zimbabwe', 'Younger Grades', 'wfqwBkOkxOsmvX', 'pefmNuGpSNE', 'tVJUvuiDEGHjr', 'now', '', '', '', '', '', 'ZmU1Mjk1ZTRmMGU4NTBjZmU1NDUxZjEwYjdmZjdlYjI2NmIyMjQ1Yzk4ZWE4YTA1ZGZlYWNhZWEyZjQ0NmY1YQ..', '', '', '06-07-2025 12:30'),
(14, 'xOAgRCXsx', 'olliduartef41@gmail.com', '+263DqmmYDqkLzHDfuG', 'LOyiOGaKrOfW', 'olliduartef41@gmail.com', '+263KqqudnyLZaALKX', 'Zimbabwe', 'Younger Grades', 'wxigPbdtCUmO', 'klPLYFavVRuTy', 'XoxYAgdizZwr', 'now', '', '', '', '', '', 'ODJjOWJmMGEyYmM1M2IzOTA2NTU4ZmY4YjBmOTUxM2M5N2U2N2ZhZjVlZTRiNzYzNWViZDcyOTI3M2IzNTJlZA..', '', '', '06-07-2025 12:55'),
(15, 'IgOBAABiXSarTq', 'caredjorsf48@gmail.com', '+263gziqcatfJ', 'UESZsKafFuZDm', 'caredjorsf48@gmail.com', '+263NeoECzahCQWuzpg', 'Zimbabwe', 'Younger Grades', 'NbbUNqgr', 'ckStHstc', 'GvADhxJnMYSczy', 'now', '', '', '', '', '', 'NjkyZDA5ZWM1OGIyMTZmZTUzNDgyMjExMDkxNDI1OWFiOGVjNDgxMDAzMjIyZTVlNjVhMTlkOTg1YTlkNWFlOA..', '', '', '06-07-2025 17:44'),
(16, 'xwfUSuSP', 'kbraundx39@gmail.com', '+263aylVwZivgMZ', 'AUHGVdnce', 'kbraundx39@gmail.com', '+263dTEgHLgNjN', 'Zimbabwe', 'Younger Grades', 'QzPJYrpwA', 'JIkzzuKTpA', 'odxZMERkeWldFy', 'now', '', '', '', '', '', 'NGVjZGIwNTRhYWViNDZmNGYzNWNkOWEzZjNmY2M3ZDVmYjk0YzkyMWRmMDliOGE2YzY5MzA5MTBkZTFjZmYzYw..', '', '', '07-07-2025 09:13'),
(18, 'TXYFmPIj', 'mkertis50@gmail.com', '+263IBCacPzjMTZoUO', 'ISQIyXQQ', 'mkertis50@gmail.com', '+263CRLQFjoxuieEK', 'Zimbabwe', 'Younger Grades', 'KniARMPs', 'InzEMEex', 'HPuVbGzqQEHET', 'now', '', '', '', '', '', 'NzhlMDY5MmY4MWVhZjhjZDQzMDE0MGU3ZWI2ZGE5OTc2MDUyZmJmMjkwZmRjOWY0OTRmYmE0ZGNiOWJlOWE1ZQ..', '', '', '07-07-2025 11:29'),
(20, 'RSaZrcNajkRJ', 'sherloklbj16@gmail.com', '+263UtHYyHLPlWsbz', 'fLYddUsEBPR', 'sherloklbj16@gmail.com', '+263SQgmRIiCzfz', 'Zimbabwe', 'Younger Grades', 'RGjHvPucg', 'kGfaDSWpRqTgAKj', 'KpnMGfrNZhL', 'now', '', '', '', '', '', 'MTQyYWEwNjJlYzRiNmEzMTM5YWY0OWY4Y2NmMzY2MTI0ODUwOWQ1MjIyMWRjZWI5OTY0YjYyMzExMjgyNjgyZg..', '', '', '09-07-2025 19:43'),
(21, 'zNEuHPQgnq', 'figueroaflemming6@gmail.com', '+263pqaolCYuY', 'wNKKcibSRuFNjMi', 'figueroaflemming6@gmail.com', '+263QEFYEYnfK', 'Zimbabwe', 'Younger Grades', 'xxLESumHHJ', 'GnbhtsgTkr', 'VXqvcZXZ', 'now', '', '', '', '', '', 'YjIyNGEwNWY1OTZmZGYwNDcxYzFjZDdkOWY5OTNkNTEzNWFkZWEyMmU4ZDM1MDAyNzhmNGQxYjY2MjFiZTNiYQ..', '', '', '10-07-2025 03:57'),
(22, 'MUyDUvtJCzHjZB', 'veritibridges19@gmail.com', '+263NtvcdVUBWl', 'OsjEXTGYlgdFCp', 'veritibridges19@gmail.com', '+263hbNkHJIYOTzlw', 'Zimbabwe', 'Younger Grades', 'CsjIEqJoHyDsu', 'quppMijEV', 'gTPxDEnPH', 'now', '', '', '', '', '', 'ZTQ0YWJlZmFjZGViMDI5M2NkY2ZjNDNhMjA2NTQ3YTI0OWNkN2I0NjNiMjA0M2IwNjEzOTllNGNjZTBlZjM3OA..', '', '', '10-07-2025 18:12'),
(23, 'GBaMbzssdLqHx', 'arellaangebk1982@gmail.com', '+263lBrvkMVQfRQr', 'xeGtHnfxvhFhu', 'arellaangebk1982@gmail.com', '+263NVJowEteUxeV', 'Zimbabwe', 'Younger Grades', 'IpfmWbjiVPLpsz', 'CrdLYSnJGLI', 'tuSlSEDjonp', 'now', '', '', '', '', '', 'MWVjOTRlY2ViNTZmNWRmOGRkYjUxYmI5ZDQ0ZjNhYjZmZTQ2YjM1ZWI5NzI4ZGYwYzY0MWJiZGM2MmM5YzBiMQ..', '', '', '10-07-2025 20:57'),
(24, 'qjubnQWCZX', 'ocuxujefe689@gmail.com', '+263SCYQvQeeRysfwvf', 'HKIEIsPboKB', 'ocuxujefe689@gmail.com', '+263GSoZcWSljrp', 'Zimbabwe', 'Younger Grades', 'NGtKMKHVVqBWy', 'xmhMnRKkImYAwsS', 'mdLhnoXCKEbnzAq', 'now', '', '', '', '', '', 'ZjFlYzhjNjUzYzlmZWIxYjgwNDNiOTVhM2I3Y2YyZDFlNzk0NjNkM2UwNWI3NTA4Y2RlOWI2ZjA4OGRlMmUxZA..', '', '', '11-07-2025 09:11'),
(25, 'FpIOPJdjJEaKT', 'uqeqawuq78@gmail.com', '+263DaZIIvIk', 'euYhalUp', 'uqeqawuq78@gmail.com', '+263jEuIJMHhWmMrEsG', 'Zimbabwe', 'Younger Grades', 'OnCnvvLPOqx', 'THxQdWOCcGud', 'MXytBcLHIoYlw', 'now', '', '', '', '', '', 'YWJjMTUxOGVhMzYwNGE0MmUwOTEzNDE4NWRlYTgyNGYxYWJmYzQyNDE2OTZmZjgzNTEwOGI5OTQ1MzAzODkyNw..', '', '', '11-07-2025 22:12'),
(26, 'KzZIrVRIhzgctI', 'dominguezjennifer8811@yahoo.com', '+263GiXteZGTijWtnk', 'grEgHyDyFRmQNj', 'dominguezjennifer8811@yahoo.com', '+263SiDGqFhWhuCSp', 'Zimbabwe', 'Younger Grades', 'zPekUGzTtbR', 'kjRqZbZDvGBFLGk', 'MyjggXiptAL', 'now', '', '', '', '', '', 'ZjA0Y2FkMmM5NmNmNDA3ZDA1M2Q4NTJjY2I0OThlZDcyM2E2YTAxYmZkZmNiN2I0MzhiYTQxODAyOWY5ZGYyZQ..', '', '', '11-07-2025 23:20'),
(27, 'DWigSybdgB', 'farmeralisteirlw97@gmail.com', '+263cvIcrSzvfpGr', 'riYQUArURBss', 'farmeralisteirlw97@gmail.com', '+263SpPpHqVAKPJoros', 'Zimbabwe', 'Younger Grades', 'ihrWoeOnNZIPO', 'AIBFPypBtgIHtm', 'FLCqHcLIJnzgRAT', 'now', '', '', '', '', '', 'OWQyNzE4MDY1M2U1M2M0OTZlNTE5ZjBjYWQxMjU5NjdjMDIxMWM5OTNlYjA3M2UwY2NiM2JiZDE4N2E0NTQ0NA..', '', '', '11-07-2025 23:50'),
(28, 'iGhRnuPrcfUx', 'carsonprimrojy8@gmail.com', '+263FhyKePJr', 'sBTbrwjBxzxNzAk', 'carsonprimrojy8@gmail.com', '+263CYCrTOXtFYY', 'Zimbabwe', 'Younger Grades', 'RPaXbNOZuB', 'YYfOzLwBAzpidvT', 'eQZQGfjXciNCR', 'now', '', '', '', '', '', 'MjRlMTUxNmFmY2M2YzFlZDY4N2I0ZDg5NDNjMDhmNjU2YWEzNmM3YTczZWNlMDIwY2VlZmQzZmM0YTZlODVjZA..', '', '', '12-07-2025 23:48'),
(29, 'mSYkXmWyS', 'moondalindan5@gmail.com', '+263GUVlqUoixMNNaq', 'KJMCtNpPI', 'moondalindan5@gmail.com', '+263uIgjNimfk', 'Zimbabwe', 'Younger Grades', 'WRFDONwj', 'diyAsqAdbYXnGMR', 'zZlJvILB', 'now', '', '', '', '', '', 'NTY3MDI4MDUxZTdjYWY5ZmVkZGNhODAxMTU2OTY3M2Q1YWQ0YzA4ZTk4MWY5Yzk4ZDhhM2JjNmU0NDFhNDhhMw..', '', '', '13-07-2025 00:31'),
(30, 'plpDFYxM', 'needhamjohn200801@yahoo.com', '+263qBBpiLMAXE', 'AZtCryJbLVTGH', 'needhamjohn200801@yahoo.com', '+263JoEALrVUAmqP', 'Zimbabwe', 'Younger Grades', 'PUOhZFYN', 'nWhKvvUPAupkiC', 'XOkjlDIGPnDB', 'now', '', '', '', '', '', 'MWViZTkyZTY3ODdmNzgyZjUxODViZTg4MDUzYzYxYmQ3MWNlNjc2YTU5YzZmZmIzOWY5OTNmNmMwZGU1MjhlMA..', '', '', '13-07-2025 14:55'),
(31, 'BJYpfgWZt', 'pachyilpp1984@gmail.com', '+263NZksBqjDMunzNc', 'zjsXzNuxQgj', 'pachyilpp1984@gmail.com', '+263KBNARFykYjTHCLi', 'Zimbabwe', 'Younger Grades', 'RElUciuLOKJ', 'gccbEJZg', 'FscINlWQBQceLYB', 'now', '', '', '', '', '', 'YjMyYzAxYzY4ZjQ5NjE1NDQ2ZjQ2NTZiZjgyMDM5YTA2NTExMTg1NzFjNGFkY2JiZTgzZWFmM2YyMGZmODhkZg..', '', '', '13-07-2025 19:29'),
(32, 'kevpmWneplHduMF', 'kyiconwj@gmail.com', '+263ljXrGaOTsLTc', 'IVrpibTNPTkeKy', 'kyiconwj@gmail.com', '+263MaZvtwzW', 'Zimbabwe', 'Younger Grades', 'IZIcIFhRKeiv', 'TZnBGzcUQWWts', 'zsLrUnin', 'now', '', '', '', '', '', 'MGVkMDUzMzUyNWRjZGIzNmJlN2JlYWUyNThhNGU0YzYzZDI0ZjEyOTRhMjBiNWNjMWUxNDM3OGI0ZGUwZDBjNg..', '', '', '13-07-2025 20:50'),
(33, 'IyrKRqZMuBPhrZ', 'annikkwhitec89@gmail.com', '+263kgtRVgRJwdmFyTw', 'BDTQTIAxZHefVzS', 'annikkwhitec89@gmail.com', '+263wWlWAOWwZyVOW', 'Zimbabwe', 'Younger Grades', 'GEutmRnT', 'PGAeahXidDGHAe', 'jzNlXAuezZ', 'now', '', '', '', '', '', 'NWUzYTU1MDFiOWY3NmI2ZWU0MTQyNjFjZmMxNGJhNDZiODVkNDNjYTNkMjk2MGM2ZTNiN2QyY2M3NjI5OThkMw..', '', '', '14-07-2025 11:35'),
(34, 'IXLFHXZWHGsu', 'ballakli1997@gmail.com', '+263dycbNQJlU', 'nSeIhbWYkTNApMb', 'ballakli1997@gmail.com', '+263mUiYKbSk', 'Zimbabwe', 'Younger Grades', 'zrrqlEdDvMudXqX', 'QLpEWGcwTUgCFsH', 'bdHrAGNnAP', 'now', '', '', '', '', '', 'OTg0Yzk5OGRlZDQ3YTY2ODViYzlmM2E1NzBmY2MwNjNlZDQ3NzE3M2U4ZDdlZmI5OTczOGI5Y2RkNGVlZjFkOQ..', '', '', '14-07-2025 13:29'),
(35, 'WIJIcfISl', 'braianwhiteheadjt47@gmail.com', '+263ZgCYkfgofRnNf', 'NvJmqvDMOpXahc', 'braianwhiteheadjt47@gmail.com', '+263tZWnuEcN', 'Zimbabwe', 'Younger Grades', 'xaRiWtOqf', 'bDfPpOGTIwUGjA', 'VgrOgdTb', 'now', '', '', '', '', '', 'YWMzNDZjNWNkY2U0MGFjNTc1ODg2MjEzNmRiNzcwNTUwMDNjMGQ5MWQ2MTQ5ZmI3Y2Q5NzNlYzlhOTZiNWE3NQ..', '', '', '14-07-2025 18:38'),
(36, 'HhKQaZkAPP', 'braianwhiteheadjt47@gmail.com', '+263bSqZPudRXZKDv', 'QqlESKjBwv', 'braianwhiteheadjt47@gmail.com', '+263ZJdbwqrheJEend', 'Zimbabwe', 'Younger Grades', 'lmtwozlaNSEBQr', 'KqrpzWjZMynL', 'aFkMTFwlCVre', 'now', '', '', '', '', '', 'MzBmZTkyN2FmNzk0MDQxNmY5MjU5MjI0YWY3ODk0YjljY2M5MDA4ZDk1MTM5MTEyODFjMmNlNDY4YTRkZDZkYg..', '', '', '15-07-2025 01:16'),
(37, 'maFpgZXivGZUsU', 'ehahucukogo83@gmail.com', '+263eDemNCvMAlPXvbm', 'SxmYlJYACmSlWz', 'ehahucukogo83@gmail.com', '+263akwWZpgIUgH', 'Zimbabwe', 'Younger Grades', 'cnAQXQUnlt', 'dmCwHQOvlkJcN', 'iilWPTxpkcY', 'now', '', '', '', '', '', 'MjE3ZjdjYzdmOThhNjAyOTMwZTdmYzMwZWM0Y2ExMjFjNGQxMzJjNzNhMjA0MjlkMDlhZmU3ZGIxMjc2Y2Q2MA..', '', '', '16-07-2025 02:15'),
(38, 'ClogsSKYe', 'umizuyekujo031@gmail.com', '+263ClOnrHSCYzdE', 'iEZFFxRDTPGWM', 'umizuyekujo031@gmail.com', '+263HkMpOOwodZdgK', 'Zimbabwe', 'Younger Grades', 'UcXHzrhi', 'SxkcidBQSlb', 'xXMRbvEDxwg', 'now', '', '', '', '', '', 'OTg3NDQ1ZTYxN2E0Zjk1MGE0YTYwMTM1MjExNmViNjA4YTk5YTIwNzg0MzY2NGRlYjlmMDg3ODJlY2U3Zjc4Nw..', '', '', '17-07-2025 17:33'),
(39, 'gmehACMhVQdfj', 'katiegrant665938@yahoo.com', '+263aRabBNWF', 'DBBwyUnQirPohB', 'katiegrant665938@yahoo.com', '+263jCpIPwMBvVooce', 'Zimbabwe', 'Younger Grades', 'epmuetAFeFswp', 'LUOtKiLONtfHGD', 'NrEioejX', 'now', '', '', '', '', '', 'NWM1ZTUxMDlmODY5YzA2NmQ0Mzk1NmQ4ZGY5NTdiMmRlMjlhODVjYjdjMzFlZTdmMmIxZTNkMzg4MTQ4ZDY0Mg..', '', '', '18-07-2025 09:41'),
(40, 'Mohamed Ahmed Fawzy', 'mohamed.ahmed.fawzy.hagouz@gmail.com', '+966541250273', 'Mohamed Ahmed Fawzy', 'Ahmed.fawzy.hagouz@gmail.com', '+966506909709', 'Saudi Arabia', 'IGCSE-OL', 'Combined Science', 'Cambridge', 'IGCSE – Combined Science –OL – Cambridge – Jun25 [Dr Nihal Gabr - Dr Peter Alfred - Eng Hussein Khaled]', 'now', '', 'EGP', 'EGP', '', '', 'ZjZiMmM2ODZiNmJhYTg2MmEwNjljNTQ5YTIzMDc4NzkyNTcxZDg4ZDE4ZDMyYWI4MWZmMzk3YTRlYjVmMmRlNw..', '', 'course cost/fee', '19-07-2025 01:27'),
(41, 'Mohamed Ahmed Fawzy', 'mohamed.ahmed.fawzy.hagouz@gmail.com', '+966541250273', 'Mohamed Ahmed Fawzy', 'Ahmed.fawzy.hagouz@gmail.com', '+966506909709', 'Saudi Arabia', 'IGCSE-OL', 'Combined Science', 'Cambridge', 'IGCSE – Combined Science –OL – Cambridge – Jun25 [Dr Nihal Gabr - Dr Peter Alfred - Eng Hussein Khaled]', '', '', 'EGP ', 'EGP', '', '', 'YjJmZTdiZmNlMzRiMTdhN2VkYWExNTY3ZDVmMGVmNTRiMWRjYTIyNDUwOTJjNWYxNjkyY2I3NWI1OWRmZGU1Mg..', '', 'fee', '19-07-2025 01:29'),
(42, 'dYcJQcWgdgQZg', 'bkishakz1985@gmail.com', '+263LLJeFzdDIdBzAQ', 'YjbIEliMFKpE', 'bkishakz1985@gmail.com', '+263JZEgZKko', 'Zimbabwe', 'Younger Grades', 'lOjBUWvZJA', 'EPobXjsEgxwbcDE', 'ghhNWAJCEIxj', 'now', '', '', '', '', '', 'NTg2NzQ1Y2IxNjdmNmE3MGZlZDUzMjZiN2U5NDJiNzI2OWVjMmQwNjExMjM0MzI1NjBjYjhlZWUyZGEyOTVlMQ..', '', '', '19-07-2025 03:50'),
(43, 'BpzFQHOKePcrBA', 'klodibas60@gmail.com', '+263wSYQOwpvgg', 'mVVYqIzyEwEHo', 'klodibas60@gmail.com', '+263LcBZZLmkGLSytkU', 'Zimbabwe', 'Younger Grades', 'XgfrnjSDPRyvl', 'iXTCdAkpdWj', 'PYwUWkTtpoqDwQz', 'now', '', '', '', '', '', 'ZTIzODhiMjhmNmUxYjgzMmRjZGJlMjAwMjc0ZTFkZmViMjc3ODllYmVmNGRmMjMyNWM5YzMxNGY4ZjQ3YzYyZA..', '', '', '19-07-2025 08:00'),
(44, 'mWMtQfLfHGZOoou', 'wubernisx@gmail.com', '+263cJhsjePtwq', 'YVNVrzQRUFYMu', 'wubernisx@gmail.com', '+263TFAaKJgFYXRyPUT', 'Zimbabwe', 'Younger Grades', 'pqKmpqcRmnFCD', 'uyvsNfIQNKJsdlv', 'TpFjrfrusoyntu', 'now', '', '', '', '', '', 'NmM4YWEyZjFiZTAwMWUyN2M0NDVjOWM1ZTBlMGU1MThhMTBmOTQ4YTZhZTYwMGY1NGNmZDNjOGU3MmRkNGYxMQ..', '', '', '19-07-2025 16:51'),
(45, 'XZCzjIGbNjcdB', 'marsgatesj34@gmail.com', '+263OPftYAtXXZk', 'dOgwnbQJUGG', 'marsgatesj34@gmail.com', '+263fYkEWESHeYX', 'Zimbabwe', 'Younger Grades', 'RpqBtFriKHueL', 'NfVyslnhFZUs', 'JpKlWNbLjJnX', 'now', '', '', '', '', '', 'ZDIxYjNkMGJlYWU0MGUwNzExYTI3ZjE5YzcwYmVmNWE1MDJmOWYxZmM0MjM2MmJiNGZhODA4N2VmMWUxODQ0NA..', '', '', '20-07-2025 04:50'),
(46, 'aSUrOujXQ', 'salinastasiyak2004@gmail.com', '+263OcIuNpsZHWFjii', 'MUZVnbfIYCbh', 'salinastasiyak2004@gmail.com', '+263GswQSbrMN', 'Zimbabwe', 'Younger Grades', 'llFSYWWIHZHMY', 'GxNERYjzOydDVWH', 'HnsaAoFOtg', 'now', '', '', '', '', '', 'ZjQ2MjViYWI2MDMxMGUwMzBkNzljMTAxODdlYjI5YTk3ZGUyYWFkMTFhNjRlMjEyMTNlZjIyZDI5MjAyNWFmNg..', '', '', '21-07-2025 05:33'),
(47, 'lBhDRjzOWhpqwfr', 'solashlje@gmail.com', '+263mQBsznGJOrprmQL', 'rlGjPrNCw', 'solashlje@gmail.com', '+263VfSQBnYsoe', 'Zimbabwe', 'Younger Grades', 'uXRVKdnQscU', 'TBebqtRHWQbH', 'YotJsmWbkaaDVq', 'now', '', '', '', '', '', 'MzVmMWM3NzU0NTIwYmE4MzdmNmQ0N2NiYjg1YjQzZmVkODcyMmFiYmQ4YWJhZTllMWMwMjFhMWExMmNhMTJmYw..', '', '', '22-07-2025 02:32'),
(48, 'OjPbHfjyYWWxeNf', 'kimaggaim2001@gmail.com', '+263cRsfLDdKpxiL', 'aZMeATusQAUxSXG', 'kimaggaim2001@gmail.com', '+263rIaPclLHAFuNk', 'Zimbabwe', 'Younger Grades', 'nRFrfVMIP', 'kkxSQgrOsn', 'BLorUxWWVn', 'now', '', '', '', '', '', 'N2I4NzBkNWJiMWE0MWFkYjFjYTgwMzdjYWFmMTAyN2RiMzdhMmY1Mjk3MThiNDI0MmZmM2IyYjI1NGVkYTY2OA..', '', '', '22-07-2025 15:10'),
(49, 'zfkghKHM', 'oqiqewajub78@gmail.com', '+263nesLoDRpB', 'VyzGDHShsDJz', 'oqiqewajub78@gmail.com', '+263WHMolqNZf', 'Zimbabwe', 'Younger Grades', 'ThQUhcbha', 'NnbbKfiMT', 'KQpIpaIaa', 'now', '', '', '', '', '', 'N2IwYjQ0MjAxMGQxZDNlMmNiODliZGZiNDM0MDRiOWY0NDM5NDQ0OTk5ZjU5YTBkYWQ1ZGMxNTViMzFlZjlkYw..', '', '', '23-07-2025 00:49'),
(50, 'aZHGFaXFAkAFV', 'johnortiz433297@yahoo.com', '+263ruunONDk', 'yZkJeJrIY', 'johnortiz433297@yahoo.com', '+263tFkmMqwTD', 'Zimbabwe', 'Younger Grades', 'hvYkqnDzsBL', 'ciKKhVVhgqXGnFq', 'NAgnwrZhXxLfl', 'now', '', '', '', '', '', 'OTEzMTlkNmYwMjk1ZWZhNTZlYjNkYjYwNjE2MmVmMGY3NzMxMGYzMWJhYzBiYmM3YjZkYzY4MjVhZTYxY2NhMw..', '', '', '23-07-2025 12:01'),
(51, 'aGyHmuUnbMzmbpD', 'nonicasenp1@gmail.com', '+263BWMpfDme', 'rAMOjHSiYg', 'nonicasenp1@gmail.com', '+263VJRgSWeOC', 'Zimbabwe', 'Younger Grades', 'qaymETorIFWDW', 'UjBoJwXUjXM', 'TryTUeDFA', 'now', '', '', '', '', '', 'MzdhODkyZjI2NzAzYjIzMTFjNTcwMTNkMGEzNjAzM2FiZjY1OTQyMzFjNTY5M2I2ODc4N2ZkMGRkMDhmNjg1OQ..', '', '', '23-07-2025 12:46'),
(52, 'NOCcSbPQOO', 'orecuzoyudev69@gmail.com', '+263SbLBtYXgoBwJ', 'GRIKpFghnwQWR', 'orecuzoyudev69@gmail.com', '+263TVgOwzLfjeea', 'Zimbabwe', 'Younger Grades', 'cPHUhmXJAHYmac', 'ZzKeKpobqvM', 'dVFxcTGLtlfroX', 'now', '', '', '', '', '', 'OTBkMTNlMmQ3NzYzYjkwNTg0ODk3YzdjMTEyOTMzZWQ3NTFlODdkMTdmYmY2YTg0ZjQ5ZmI4YjNjZWQ4ODNhYw..', '', '', '23-07-2025 14:23'),
(53, 'UQsLfaNVlUqMn', 'kliffordcastrob27@gmail.com', '+263LZfxVQVUKqTEeb', 'udnbWviSZvn', 'kliffordcastrob27@gmail.com', '+263rAEWAdGDwesP', 'Zimbabwe', 'Younger Grades', 'kIlwyNImPJRAAwX', 'oduTHhoC', 'iMQlDLhkCJAo', 'now', '', '', '', '', '', 'OTJmZDUyYTg2YzFkZWMyYzY5MzA5MmZiMTUwZTNlZmM4NDk4Zjk2NDkzZDRmNzRjNTFkZThlMWJhYTBiYjg5Mg..', '', '', '23-07-2025 15:02'),
(54, 'cCiJmYOpTa', 'valerevmu@gmail.com', '+263EzFMhzUc', 'dNtdjkVgPE', 'valerevmu@gmail.com', '+263fOeTtbvQI', 'Zimbabwe', 'Younger Grades', 'haBtdUPj', 'TsNvTFmPKnOssk', 'nTQYWEtu', 'now', '', '', '', '', '', 'MGFjODdmODNlZDVlOTM3MzY0MzE0NjFiY2UxMDVlNDg1NjU0NWUxZmRkMDYxNTE3NDc1ZDYzNmI4YWE4ZjA5OQ..', '', '', '23-07-2025 19:48'),
(55, 'svgFYEkAY', 'hetolegez898@gmail.com', '+263saKkFsdVpkv', 'SXVzXsjrHT', 'hetolegez898@gmail.com', '+263wrISBsuAyd', 'Zimbabwe', 'Younger Grades', 'ZCbtjRLlQbp', 'weAgEofEks', 'RrmprvLFeREU', 'now', '', '', '', '', '', 'MGFmNDQ5NWRmMGVkMWNkYzg2Y2RjMmZiY2RmNTZjNjk3ZjU2ZDBiNmZjMGU2NzIxNTY4MzNiN2E5MzA0Mjg1Yg..', '', '', '24-07-2025 12:12'),
(56, 'eGwJigKry', 'sosboernkc5@gmail.com', '+263xXQGuOJVK', 'VePVeGAUXJ', 'sosboernkc5@gmail.com', '+263QDOgJHqI', 'Zimbabwe', 'Younger Grades', 'RFqUOVOZIIbyuA', 'jAWEKyjUOkEIgp', 'wtLMyWyWeKBvRqC', 'now', '', '', '', '', '', 'NzhiNDU3ZGJiNWQyNDhkMGY1NDYyMDliNzdlYTEwOTI1OGU2ODcwYzRlZDA1Yjg2ZDMzYmUyYTAxNDU2Zjc5NA..', '', '', '24-07-2025 15:02'),
(57, 'zuUZnyNyBdljhH', 'nataliakelly345102@yahoo.com', '+263wEmAkRRynY', 'bqqVAYxl', 'nataliakelly345102@yahoo.com', '+263PgAdQyKXK', 'Zimbabwe', 'Younger Grades', 'FsSneyxhRUlgD', 'GApzfYxaiN', 'pCjqEnmEicZI', 'now', '', '', '', '', '', 'NTRmY2M1ZDkwMGVhZTNjNGUxN2FjZjM4MjQ0YjdkNGM2ZmZlNTA5MDM3NmQxYmIzYWZmYzdkZWIwMDkyMzcxMg..', '', '', '25-07-2025 02:47'),
(58, 'cBRcANnqkMQQ', 'ehufagixori613@gmail.com', '+263lVsnpcqk', 'ODlUTaNaQmFb', 'ehufagixori613@gmail.com', '+263DsgmTvvyey', 'Zimbabwe', 'Younger Grades', 'BBhWLWTtJQp', 'VtCcRUmhPrlQya', 'liEdGvRQBZT', 'now', '', '', '', '', '', 'ODMwODk1ZWFlMWRjYjcyNTM0YTljYjFjZGQwMThiNzUxMmJhZDY4MWZkZDJkMDE1OTgxNWRkYzZlODBjYmVlYg..', '', '', '25-07-2025 04:31'),
(59, 'YEnxNokJXwOj', 'zoyutofenu71@gmail.com', '+263XfGqAXEDJs', 'ecgHdDgJFxh', 'zoyutofenu71@gmail.com', '+263JQliIsFJzwGQVQ', 'Zimbabwe', 'Younger Grades', 'tEgdJNhQnJU', 'YsByBxLlIWaXt', 'AdlqBabqzyqgth', 'now', '', '', '', '', '', 'NDcxMzQ4NGEyNjExOGY5OGY1MzVjMmM1YTkzMTZlNjhkOTNlNmE3YWRiMjQ5OGY4ZDc0YmUxODBmNDUzODYzYg..', '', '', '25-07-2025 08:58'),
(60, 'MbeneQJtRoqILW', 'farleyopra46@gmail.com', '+263RjJKJxTwKFycyA', 'HRcjNWppYIEx', 'farleyopra46@gmail.com', '+263fVXAUdBV', 'Zimbabwe', 'Younger Grades', 'cXqamEKgplmGylr', 'ZCMzGcrn', 'OmrAuJlegdSJ', 'now', '', '', '', '', '', 'YTViZmY0ODM5YmJhYjVjMDNjNGNhZTNlMmEyNzlkNmZiY2E5YmUwNmNiZjBlNjMwYWVmMWVkY2ZjY2NiNWViMA..', '', '', '26-07-2025 17:10'),
(61, 'eoCAtRHiPNmc', 'mukoyiruba34@gmail.com', '+263kNhQQyGJ', 'kfOjRZfP', 'mukoyiruba34@gmail.com', '+263tvRQPZTmA', 'Zimbabwe', 'Younger Grades', 'RXrnjbQAEQ', 'KsHDwpinmMbcYY', 'HBLCPSXvYUSC', 'now', '', '', '', '', '', 'MDIxM2QyODJhZmViYWNkYjBlMDQ4NDczOGFlMzgzMWZlMTVjNTEyYmFlMDMyOWRiOTE0OTNmNTFmNmE2ZDFkYQ..', '', '', '27-07-2025 19:14'),
(62, 'VCUclohWwQL', 'equdaxiq12@gmail.com', '+263qoUxUOKZMSgcE', 'vYOwVMyWqVwpalq', 'equdaxiq12@gmail.com', '+263XqLVlfmWuILdJE', 'Zimbabwe', 'Younger Grades', 'QOiQtGHoWow', 'bRJhbpyFS', 'MHvAKSCcMwWblA', 'now', '', '', '', '', '', 'MjkzMzExZTQxYzE1ODNiMjhkYmZhOWEwMzBkM2ZjNTc0Y2I1ZWJiYTRjMmFkNGNkNTUwYjgxNTJjNmQ3ZThhZQ..', '', '', '28-07-2025 00:50'),
(63, 'TtJEsFrAX', 'yilfredgoodman1982@gmail.com', '+263OGaZqedhizzwb', 'yiNGKnvWL', 'yilfredgoodman1982@gmail.com', '+263GvJsMUIZK', 'Zimbabwe', 'Younger Grades', 'MdkMEEkCxQCQC', 'iLdnASYLUtTLU', 'YEcpzqChK', 'now', '', '', '', '', '', 'YmNmMWZjYWI5MDYxZGZjNGQ4ODU5NzYyZDAwNTBlNDBiNGQ1M2NhOGI0M2JjNGI0YzVjOTljNDc4Mzc5MDI2NQ..', '', '', '28-07-2025 15:20'),
(64, 'SFTAAPHqAjTQNp', 'adelisbgq41@gmail.com', '+263zPXWZyxCwlB', 'qiluvLYKHZOc', 'adelisbgq41@gmail.com', '+263QyzeOBYapCiXh', 'Zimbabwe', 'Younger Grades', 'XhvzYZEM', 'UvInMpAFgTbAmO', 'hsKRoTeCmiW', 'now', '', '', '', '', '', 'YmM5MjViNDc1NTYwYjE2ZWFjOTRmZGM0Njk4YmNhNjEyZDM5MGVlYTJjNDQ1MWQzMWM3N2RmMTdmMTgyZTEyOA..', '', '', '28-07-2025 15:23'),
(65, 'PzfOdZyWhMgxuxU', 'adusexifaj86@gmail.com', '+263igWzvDWxtrqAAZQ', 'nCYZLtmMBeJiRne', 'adusexifaj86@gmail.com', '+263HDycNtNZXgTjj', 'Zimbabwe', 'Younger Grades', 'fckaMuzvDm', 'HGsucmxY', 'JROzjEZEng', 'now', '', '', '', '', '', 'NGY0MGI0YzRkNTQ3NDU3MzU1ODllNzNjNDQyOTI3MjllNjQwMjQ1NmNjN2QyZWJjMzgyMWZlMGYyNDU2NDQ3Zg..', '', '', '29-07-2025 00:16'),
(66, 'eVgyKqbeiwstCfO', 'bellaclarkw52@gmail.com', '+263QCemlDLc', 'kfCfsLjFdH', 'bellaclarkw52@gmail.com', '+263SLIeDNHfVNvX', 'Zimbabwe', 'Younger Grades', 'QyJLfRtC', 'bDEutUnu', 'FESJVOsznDRg', 'now', '', '', '', '', '', 'YTJjZWIzNjRjZGUwNzdhOTI3MzY0ZDYyMjE2ODJlZTU5MGRmNDA3N2M0NjQxMWQ2YWY4Zjk2YWYwOGNiYzlkNg..', '', '', '29-07-2025 02:53'),
(67, 'OMYzbejHiTHF', 'bardalfdawsonn40@gmail.com', '+263lfKpFUEaemebrZH', 'vwPGosRyj', 'bardalfdawsonn40@gmail.com', '+263RljwCKJCZM', 'Zimbabwe', 'Younger Grades', 'WffaJwxvnVJzBxi', 'qHdYpygPfdK', 'sowwtUkFx', 'now', '', '', '', '', '', 'NWI0ODE3MzZjMzAyZTQyMzg4Njg1ZWRlOWJiY2YyZTA0MDMyZWY2ZDZjM2M4ZWFjOTY3ZjI1Zjk5MTZlMTQxMQ..', '', '', '29-07-2025 13:56'),
(68, 'JVNzftGe', 'usosegoguw599@gmail.com', '+263mCFuFFXwI', 'ahZmWZGsoJ', 'usosegoguw599@gmail.com', '+263bsiRwwbm', 'Zimbabwe', 'Younger Grades', 'uZSywBFOPNDdos', 'gbxLpHXYfeZi', 'imkEskuBY', 'now', '', '', '', '', '', 'OTY0ZDJlZDY3ZGE1ZjUyNzI1M2MyMTI5NzhmYzNiYjQ4YWI3N2IxMmFhZGEyNmQ4ZGFhZTcyNjNiMzUzYWI4Nw..', '', '', '30-07-2025 10:08'),
(69, 'lyPqiiXa', 'emuxunuyuz63@gmail.com', '+263iDUlqHbsfv', 'xgUhVkbI', 'emuxunuyuz63@gmail.com', '+263EBgJJrKZPuj', 'Zimbabwe', 'Younger Grades', 'MiwCIwfACWuPnhE', 'UvFtYoAKfvw', 'EXXqiBqJl', 'now', '', '', '', '', '', 'MGVmMzAxMTU5ZDAxZjJmOTM2NGZjN2Y4ZmVkNDg5ZDM4ZWIyNTZmY2M4NzA5YzBhNzExYjgyZjIzYjJiNzRiMQ..', '', '', '31-07-2025 08:34'),
(70, 'bdLmWisnKAjMvE', 'lisawood966646@yahoo.com', '+263GZqIVkQFv', 'ElcHOKWozaaHmn', 'lisawood966646@yahoo.com', '+263ZRLnguyNk', 'Zimbabwe', 'Younger Grades', 'CCPVwpXxElQ', 'tENbhPiRPJbw', 'THoCZQVIBd', 'now', '', '', '', '', '', 'ZjgzNzExZDUzMDVkNzY2NzdmYzdjMWFjMDE3MTcwMjc5ODkzM2EyYzY1NmQ1OWUwZDUyZGFlZjM1YmViZmVkMQ..', '', '', '31-07-2025 11:38'),
(71, 'GmmLUwqAuOe', 'exiqukiju328@gmail.com', '+263SlSRkgnrrKqUX', 'TvkpDrTf', 'exiqukiju328@gmail.com', '+263sWqituFh', 'Zimbabwe', 'Younger Grades', 'pdhMGabjtjXj', 'dtmUQXQANRSBLb', 'szokiDxpv', 'now', '', '', '', '', '', 'ZTYyYjc4NTJiODcwMGU0ZWU2NTkzMGY5ZWNhNzE3ZTM0MWE4ODVkMzAyODE1ODMxZDdkZmZhODcyYzg5MTVlNA..', '', '', '02-08-2025 00:38'),
(72, 'rimhnZGLflzsau', 'elonidepe18@gmail.com', '+263QgLHEaWL', 'IxRlZgxPjPP', 'elonidepe18@gmail.com', '+263aYeDkFKGwC', 'Zimbabwe', 'Younger Grades', 'xGstNQdBuwip', 'sPLZXMKr', 'rgThbSAE', 'now', '', '', '', '', '', 'NDNmYjk2NDQxMTAzNGRlY2ZlNzU5YmY1MjUwYmVlZmMzNjJiZDNmY2NkMmJmOGU2ODkyMjc3YjQ4NWIzOTliMg..', '', '', '02-08-2025 04:49'),
(73, 'tIQMjUos', 'abaxowiyomed20@gmail.com', '+263ovFQWewm', 'dMfQufhGGHn', 'abaxowiyomed20@gmail.com', '+263RPfLINSGcp', 'Zimbabwe', 'Younger Grades', 'aHXDcSyOBNxBu', 'RCOZpxcuvrBO', 'xTTmAJyLy', 'now', '', '', '', '', '', 'NWM3MWQ1YTgzYmIxODhmMWJkYzE5OGY0NDQxNDZhNWFlMDMwYjk4ZDIzZmI1YTVhMDE0ZWVmNWNmZjgyZTc2ZQ..', '', '', '02-08-2025 06:08'),
(74, 'HUyFZvMbHmBqjIT', 'qewuporuj028@gmail.com', '+263QxIkihJwVdWiBM', 'nUSxoqKlKIwiN', 'qewuporuj028@gmail.com', '+263FLyMpKyEMn', 'Zimbabwe', 'Younger Grades', 'XxKAXlqef', 'YBwLsEZzUbymPg', 'LsrJqTzRhqbjuKf', 'now', '', '', '', '', '', 'NTIwZGVhMzI5MGI3NDllMGVjN2FlODU0MjE4NTI5YjBkOTJhZTZiNzVkMWQ3YTBmYWY0YmQ2Yjg3OTZmOGQ1Yg..', '', '', '03-08-2025 00:04'),
(75, 'wqnwNRzMkdvjmi', 'bestdjak8@gmail.com', '+263wEDuCmDWXlWxeAa', 'ZGjhXWcJimh', 'bestdjak8@gmail.com', '+263IpcImqNAaRGwXRM', 'Zimbabwe', 'Younger Grades', 'MkRvMsNcqQXFGe', 'JIVTkHaXlorb', 'DPwBLJvqdh', 'now', '', '', '', '', '', 'ZjAzMTMyYWRkOGJhZTc0NTdmZWNiNmFkOGI1NDk5YTQ4NDM5M2I1NzM5OGRhMTAzYWRjMzZhZmE0N2JlYzA2ZA..', '', '', '03-08-2025 12:05'),
(76, 'IQSbvakUyXzrnd', 'scottsanders812125@yahoo.com', '+263OZhahcfg', 'TCkhntqQCYgu', 'scottsanders812125@yahoo.com', '+263dweMHieSZoajDL', 'Zimbabwe', 'Younger Grades', 'tfyrGlbFUb', 'OFqQWFdNkyT', 'WDdkAvaUj', 'now', '', '', '', '', '', 'NjA0ODk4MWFiYTc3ZDgzNjdlZTVlYmJhMTM3NGM2YmYzODViYzg1ZDlkN2VlM2Q2OTZmOGIyNGVmNDQ3M2EyNQ..', '', '', '03-08-2025 23:36'),
(77, 'qIcGvoJp', 'andreaboudreaux1999@yahoo.com', '+263XwfClpNhIMM', 'xxogsTWQu', 'andreaboudreaux1999@yahoo.com', '+263hhPSCEIYQttEpd', 'Zimbabwe', 'Younger Grades', 'wdQIsvRfJuxLbjM', 'RDibvptHmY', 'EvngrcRYM', 'now', '', '', '', '', '', 'MDU3MjdhYTE0NzE5MjM4OGZmYzc3MDcxY2IyZmM0MGQ4MTA3MGEwYTQ4ZWU5MDRkYTYxZTJlZDA3MWJhNTUyZQ..', '', '', '04-08-2025 03:00'),
(78, 'AgVqueiDgj', 'bogaquta354@gmail.com', '+263YoTpNSTatcU', 'tDMCScJJK', 'bogaquta354@gmail.com', '+263qAUKfbxGHdM', 'Zimbabwe', 'Younger Grades', 'uucvNDhrPJ', 'JlgjGjWlyUF', 'khnODShM', 'now', '', '', '', '', '', 'YTJiM2ZiMmMzNWZkMmE5MGE4MTcwNGNjMDQ4MzhhNTY4N2I3Y2RiZjc4NDY2NjYyYmEwOGZmNGFlYzllZDJmZg..', '', '', '04-08-2025 04:32'),
(79, 'adlcVgHxlgWMqq', 'ehuduwuru873@gmail.com', '+263qyWLJcpDOAd', 'HyyyvCUOaSF', 'ehuduwuru873@gmail.com', '+263IdoFrKXMWW', 'Zimbabwe', 'Younger Grades', 'WVpOSgIIhvJzL', 'emNzWKYfpcgJ', 'EDTpPuNdfpi', 'now', '', '', '', '', '', 'MWQ1NWMwMGIyZWViZDMzMjg4NjZmNWVlZDRlYzMzOGNkM2JiYmI4Mjk1YTBhZWM5OTY1NjgyYmM1MDY2ZDZhYQ..', '', '', '04-08-2025 15:14'),
(80, 'RNYFAaeIWC', 'roxofafiler446@gmail.com', '+263PweFPdeLngmdSIV', 'tbQdTKMy', 'roxofafiler446@gmail.com', '+263HqooHWhnQX', 'Zimbabwe', 'Younger Grades', 'jZLRSBAzgeveU', 'LjvRPjkS', 'HZWDVxTtny', 'now', '', '', '', '', '', 'NDJmOGM2NjYxODlhMzkxOTM3YTVjY2MyMDc1YzJlNzJiOWFhZjQ4MzFjMDlkYmMyZDNlNTE0MWQwMmI0YWQxNg..', '', '', '04-08-2025 16:17'),
(81, 'JhOcPndPIqqqH', 'kevinsanchez744284@yahoo.com', '+263vHKMXksOlkVOO', 'AtMlUFvclHC', 'kevinsanchez744284@yahoo.com', '+263gzzDNqaDWOowq', 'Zimbabwe', 'Younger Grades', 'xeUoFBCqg', 'lYIcryuDUfYs', 'KPpSDMgBYzK', 'now', '', '', '', '', '', 'NjFhNzlkYjM2NmY4NjA4YzBiYjZjN2JlNDkzMTNhNjZmN2E4OTc4YzlmMTc3MzY5NGIxM2UwMjViYWE1NzdhZg..', '', '', '05-08-2025 05:44'),
(82, 'zMnLFSEyCyGW', 'gmerite26@gmail.com', '+263kwlWSMsFdQazr', 'PTAzpNgRW', 'gmerite26@gmail.com', '+263htTvrYaamSI', 'Zimbabwe', 'Younger Grades', 'mxppCQoMOHiJn', 'GCibfKDoDm', 'IFjYqiOGHN', 'now', '', '', '', '', '', 'NTQ5ZjkzYzIwYTU4MDUzODUzN2YyNDkyZDIyZDM0YjkyOWZhMjY5MjdkMGFlYjJiZTQxOGE1MjQzZWVkYzNmZg..', '', '', '05-08-2025 16:36'),
(83, 'WlRrNlpWtx', 'fupiripepa523@gmail.com', '+263tVzpzwlr', 'OMvzYKQKcyLz', 'fupiripepa523@gmail.com', '+263rRhRefHQQrRCkC', 'Zimbabwe', 'Younger Grades', 'OUokEJyNWpnB', 'QwTjaJzMkfeteIn', 'LiYPhGpvZ', 'now', '', '', '', '', '', 'Mzg0NGVlYmNhNGEwOTFjMWM5NGU0OTA5MDBmYWUxMzY3MjYyNWY0OGM4MGFhNTM3YjUyZjFjNTY1MzJhZmEzNw..', '', '', '05-08-2025 21:18'),
(84, 'JhmwzXlB', 'ojacotapef927@gmail.com', '+263hUFFBmaGvhDQpz', 'GIiGTvEzdJXyl', 'ojacotapef927@gmail.com', '+263yRgFgnhkwb', 'Zimbabwe', 'Younger Grades', 'rHlmKiJLNe', 'WdsjCZbOchYW', 'GXezdSoHWKNv', 'now', '', '', '', '', '', 'MDAzODdiZTdkNDVlZTVmYTYyZWQ0MmRmYzIxNjdjOGZjNzhjMjQwMTlkYmU2ZDY3ZTViOWU0MWYxNDdkNTg4ZQ..', '', '', '06-08-2025 13:35'),
(85, 'mgPNYqBrmmBYFZ', 'alitohereheh90@gmail.com', '+263NaSEUmyiRWa', 'YSooXauqb', 'alitohereheh90@gmail.com', '+263bdEytTLcFCuP', 'Zimbabwe', 'Younger Grades', 'KgSSTPrRlJ', 'UKJgossp', 'TUORHiJZmT', 'now', '', '', '', '', '', 'ZWZhNjg0YjdkN2ZmOGE1NjhmOGEwY2Y2NmM0YzQ5Nzk3NWQyOWIzMmZiOGNlNmJjMDM2ZDA2MTNhZmZkZjEzYQ..', '', '', '06-08-2025 15:36'),
(86, 'wukcEvNAUtZ', 'amuliyoyavo10@gmail.com', '+263lGSUOWOwi', 'aPzvkUtPc', 'amuliyoyavo10@gmail.com', '+263CmBvlXFFjMk', 'Zimbabwe', 'Younger Grades', 'bSGovuCbK', 'vdHFKLsOSEfdccY', 'HdnSZQMlLC', 'now', '', '', '', '', '', 'MDg4ODZlMGY1NjEwMzUxZjJhODg3ODVjNjA3MTEwMzc0YjQ1NmY4MDQ3OTg2ZWM4MDFhZGQ1N2ZlMGU4NDRhNQ..', '', '', '07-08-2025 02:49'),
(87, 'YiyEVUnjsW', 'acidopimed19@gmail.com', '+263YqjyzALSUxewm', 'cWSnQvviZqKcIvB', 'acidopimed19@gmail.com', '+263NJGFTVMTkGvGQjl', 'Zimbabwe', 'Younger Grades', 'FeBaiHrwQHpL', 'FFzFqVTbmz', 'FtzAbXpBnw', 'now', '', '', '', '', '', 'Mjc3NmExNjk5NWJiMTM2ZTY0Y2Y0NmYyYmNlOTZlMTdlODhkNTliODNiNDkyOTMwMjE0NzQ1YjNkZGVlYWQ4NA..', '', '', '07-08-2025 22:45'),
(88, 'fbTagdKso', 'busafisitako18@gmail.com', '+263GsCicvOzuekF', 'UIZaLCzUQUD', 'busafisitako18@gmail.com', '+263YjuxTYEZihZ', 'Zimbabwe', 'Younger Grades', 'NNWUKqJgnhi', 'LuwkydIJx', 'HYovdnNMGNIZ', 'now', '', '', '', '', '', 'MmI3OThkYzM4ZWY2ZDIxZmU5MGZmZGMzY2ZkNDQ4YzczMDdhZWZmN2E5NTE1ZTJiNGZlNzI3OWM4ZmQyNWY0Yw..', '', '', '08-08-2025 12:28'),
(89, 'YNrWITZhjsTyxm', 'yapiwilevoli08@gmail.com', '+263apJsGKzJn', 'WBeclawGwT', 'yapiwilevoli08@gmail.com', '+263jlyzkhuIvU', 'Zimbabwe', 'Younger Grades', 'FdzCUvhr', 'tiuRyMZiWPZ', 'SYicffidULbKeSF', 'now', '', '', '', '', '', 'NGMxOTg3NTY0MWNmNDMzMzQ1MTRlYjVlNjc0YTJhYzM4NjE3NGU1NmNiMmQzNjhkY2UxZDZiMTQ1ZjczOWQ5Yw..', '', '', '08-08-2025 14:18'),
(90, 'sooTwQSOPiMA', 'decubice183@gmail.com', '+263XuGLojBs', 'YWIFVifDLNRFLKN', 'decubice183@gmail.com', '+263weBXpMVmy', 'Zimbabwe', 'Younger Grades', 'duridAeKONVro', 'KxytKyqru', 'HuzVCclei', 'now', '', '', '', '', '', 'MjU2MDRkOWE4YzNkODZkMDZlNmI3MjA0ZDg1OTEwOTIzOTE0NmJlNDU3YThiYTFkOTU1NWZlZTVhNTFjZjFjMA..', '', '', '09-08-2025 07:54'),
(91, 'RotTAnwQxEvpVu', 'palmquistdoug578056@yahoo.com', '+263XuiFfivexKjCODj', 'bdgtLDecwGypghi', 'palmquistdoug578056@yahoo.com', '+263ofOlwKDqgY', 'Zimbabwe', 'Younger Grades', 'BXnZDcnbmnO', 'btoqmtcDnRbFyE', 'WVmtmuTYdgXcwZm', 'now', '', '', '', '', '', 'OGY2YTA0MWRjYjI0MjE4MmZjNTBiZjEzODMyNWJiNzllZmE4YWYwZWZhZjIxMWM2MzdmZDY5YmI4ZjI5Yjc0Zg..', '', '', '10-08-2025 03:17'),
(92, 'ssLeQcbrIWT', 'mesukomapeg93@gmail.com', '+263IlKtYoLXSPw', 'dKdBwzbjXSqDCcI', 'mesukomapeg93@gmail.com', '+263gshudOYJ', 'Zimbabwe', 'Younger Grades', 'zUAzehLasXi', 'tmpfjxcdP', 'YFPgkiLZi', 'now', '', '', '', '', '', 'N2RjMTNkOTJiODc5MzQ5MmMzMTNlZGE0ZTc1YWRkMjc1YWU3MjEwYjk4ZGE4MTE3NzUxOWY1ZDI0NTlkZGQ0MQ..', '', '', '10-08-2025 04:51'),
(93, 'QNwfggnNiLw', 'michaeldaugherty327975@yahoo.com', '+263qFDMwzpLrxa', 'SemhIoStnlkwGC', 'michaeldaugherty327975@yahoo.com', '+263PgNkgkYXgahunA', 'Zimbabwe', 'Younger Grades', 'prmLlPpCud', 'PqbwngPcqhauiS', 'FFeapAswPu', 'now', '', '', '', '', '', 'ZjVjOTc3ZGVlNGQzZGVhZTkwM2MxMmQ5NTc4N2QwMzllY2JiMjY5N2M1Y2U4YTUwMzU0MWNmNDQ3YmM3YzA2Yg..', '', '', '10-08-2025 15:45'),
(94, 'pRCrOWspN', 'fohanufixawo13@gmail.com', '+263HuNrqsoTPEpgf', 'YAkLcdyNHMbDpo', 'fohanufixawo13@gmail.com', '+263AXgjJqbtp', 'Zimbabwe', 'Younger Grades', 'vLYVuVmOZ', 'cwPpBWXDV', 'EnAbrjBRsJV', 'now', '', '', '', '', '', 'ODhlNmFiYzI2YTU3ZDFlMmJmZjVjM2RkZTUxZmY5YTE4NWM0MTMzOTg3YjliYTQwODdhMGViODJkODMwMTliZA..', '', '', '11-08-2025 07:04'),
(95, 'vNdrDBjkFLsrZ', 'erichacker742536@yahoo.com', '+263akWFmWLWg', 'ewdYKFoCAsN', 'erichacker742536@yahoo.com', '+263lkloULcxfng', 'Zimbabwe', 'Younger Grades', 'ixVOyqrsKWO', 'DmNuYxtrXoTw', 'iVolwSJNIYOieE', 'now', '', '', '', '', '', 'YzllMmY5Mzg1MDk0ZTNlNzJmZGNhOTczYjdjOTA0MzM3ZDViYjgxMzAzNDhiODdlMzgwNDljM2ZlNjg4YzVhZA..', '', '', '11-08-2025 10:46'),
(96, 'TqJijYDybt', 'shortgregory125722@yahoo.com', '+263jbslahHX', 'EyuLayHPRikQ', 'shortgregory125722@yahoo.com', '+263ttwqPQKqtl', 'Zimbabwe', 'Younger Grades', 'BWgmCMZpqTb', 'PCELLRmjc', 'MTygTSwfZvvM', 'now', '', '', '', '', '', 'NTE5Y2MyODI3MWE3MmFmMWI5NWViNjdhNmU3ZTQ2ODI5ZjNhYzA2ZDAwOWQ5YTYyYzIyMjg2NTg0ZThmMmRlMA..', '', '', '11-08-2025 17:28'),
(97, 'NACKeyvQLXr', 'webbrobin928290@yahoo.com', '+263rARaQQUMz', 'ElQbZZbo', 'webbrobin928290@yahoo.com', '+263RWwolBErDr', 'Zimbabwe', 'Younger Grades', 'vvKgPrsMM', 'hDqWnWBLN', 'mKziocJYCyaNtbH', 'now', '', '', '', '', '', 'NTkxNmE2ZDc0YTYyOTliOTZhNTQ0NTg1YTI3YjI0M2E2NjFiMmJkY2EzZTFkZTI0MmYwNzhhN2Y5NmI1ZjM0Zg..', '', '', '11-08-2025 19:56'),
(98, 'EABYICXOIRUDqM', 'jubuwijoton187@gmail.com', '+263XlWWLkSSXzMmZ', 'asObcwIaxevIMX', 'jubuwijoton187@gmail.com', '+263kPLOZPcoLTqjm', 'Zimbabwe', 'Younger Grades', 'UlgQVuMNvUzi', 'FYdBlSFLD', 'pokPwZhAZufI', 'now', '', '', '', '', '', 'ODJiNGZlZGEyOWUxNTFlOTVlMDM1YmRlYTE3MDBlYmIxMjRmNmY3NmQ2ZWQ3MDQzMDU5MDJjMzI1M2UxMWRlYQ..', '', '', '12-08-2025 19:39'),
(99, 'kwXdVEudYIsdEt', 'ayucoxetolo798@gmail.com', '+263AlAfBqSQlAxbhWm', 'KjQlRdqbeMm', 'ayucoxetolo798@gmail.com', '+263kyQStjIONDhn', 'Zimbabwe', 'Younger Grades', 'ZUzvhNYm', 'vyyUaSuotMlljvP', 'GXQGicqAE', 'now', '', '', '', '', '', 'MzA5OTkwYzQzYWFhMWNmMTU1MDJmNjhkN2E5MjBkNWEzMDM5M2Y4MTJlMTZlMzM2MzMzNWI0NjEwMzQzNWU2Ng..', '', '', '13-08-2025 02:00'),
(100, 'HxVetAEVOZlrVEg', 'spojarandy279528@yahoo.com', '+263jOwtQlkemfv', 'QPoRfbqZRfh', 'spojarandy279528@yahoo.com', '+263JTbYYfWhdnZuZ', 'Zimbabwe', 'Younger Grades', 'JGSaManbmIj', 'PVfPHrYPJAau', 'BKqwFCxATAgq', 'now', '', '', '', '', '', 'N2U2MTdjMzRiMWJiMDUzNWNlNWViNjQzZDllMzIwNmY3MDFmNDBiYmE3MjY5OGJlY2FkZDc5ODQ5Mjc2ZWQxNw..', '', '', '13-08-2025 04:28'),
(101, 'zDpVxqSLepVJ', 'obojowi411@gmail.com', '+263kBdCSmYFpGQn', 'genylpioRHd', 'obojowi411@gmail.com', '+263QvVrNQfJVsc', 'Zimbabwe', 'Younger Grades', 'svhZJISJzHSi', 'rjhSfAeXayfaH', 'fiMJWNBR', 'now', '', '', '', '', '', 'YmU2NmM4M2EwMDM2ZGNiMzZjYTdhZjdkNWQ3YTdmZmQ4ZmNiZGZhMzVlMjgyNGU3YWZhNjNlMjI4ZDJlNTE3Mw..', '', '', '13-08-2025 12:40'),
(102, 'rCsbHOqDsljM', 'ixoroweto28@gmail.com', '+263uwBGmJeeFbAImb', 'TRYOTydvaR', 'ixoroweto28@gmail.com', '+263IBOXfMPufgXUZIW', 'Zimbabwe', 'Younger Grades', 'QbggYZiLskX', 'dMGdXNKFtJ', 'sveSlVOre', 'now', '', '', '', '', '', 'NGU3YTBkNDkzNzVmYTA4MzAzOWRiYTFmNDMwMzk2ODYzZDY4YTUxODg3NmFlNWNlZmE2ZTNhN2E0MDVlMTRkYQ..', '', '', '13-08-2025 18:32'),
(103, 'aRQhBvhEqIjZ', 'odeniyikec477@gmail.com', '+263mqIOaDXBLMG', 'HaCcZVKSelKaHU', 'odeniyikec477@gmail.com', '+263MJsPPVzukCALOf', 'Zimbabwe', 'Younger Grades', 'lZeuimWQjc', 'BZxmFfCVZ', 'LHRRolhIOyMsukd', 'now', '', '', '', '', '', 'ZTcyYjcwZWVlOTYwMmEwNzFmZDU2NDBlY2E4ZTM2ZjYyZDRjNjcyYzFjOTY2MGNhZTZkMTgxZDc2ZTA1YmViZA..', '', '', '14-08-2025 05:08'),
(104, 'cEBZGpyFhCQlkxk', 'ajuqutix92@gmail.com', '+263zDmAoxyEWZzuFaZ', 'FXLjkIbOLVBVe', 'ajuqutix92@gmail.com', '+263IdXDKPLrkiCml', 'Zimbabwe', 'Younger Grades', 'MuxFiHGyhePpf', 'jSCgLZeSnRaQZGJ', 'oqwewjEZMPD', 'now', '', '', '', '', '', 'YWQ0NTNlZTEzNDBmZWZjN2UwZmViOGYxMGMyNzU1OTUzNjRjMmRiNDI2MDEzZGQ2NzUwMWYwNTNlYWRkOGZhMA..', '', '', '15-08-2025 06:05'),
(105, 'kVuaKfuUICx', 'aqefobeyix497@gmail.com', '+263tCtJrslPUF', 'acoYlxVTzV', 'aqefobeyix497@gmail.com', '+263eCbHrxZrPYhMA', 'Zimbabwe', 'Younger Grades', 'WbZHYYGkKEHFim', 'adytrfKTV', 'kDuUuYBxtcGMsL', 'now', '', '', '', '', '', 'MDY2Nzk1MGJiZDBlZDk2MjM2NzlmMjlmMTI1MGQxM2JlYzI0NzJiODc1YzgyY2M5Yzc0NjIxZDAyMjc0YWFkMQ..', '', '', '15-08-2025 08:54'),
(106, 'HZoPPLuIg', 'riqedekoges328@gmail.com', '+263RXktYzccGnzzM', 'hsFNvwDxZyMpMFS', 'riqedekoges328@gmail.com', '+263fBvsEHYNYaX', 'Zimbabwe', 'Younger Grades', 'PYMtMtZIFS', 'kmLpxXlX', 'MzKleRLyHGEM', 'now', '', '', '', '', '', 'MzliNmU1YWJjZGM5NGVjOWIwZGRjZmQzMzcwNzE3MmM3MzRmYmU5N2I0MjM1NTQxNjUyOWQyYmFjZjk0YTJkMQ..', '', '', '15-08-2025 13:11'),
(107, '* * * Unlock Free Spins Today * * * hs=e04daf3c38441e79af359b0c45d419d6* ххх*', 'paouqua@mailbox.in.ua', '+2637685429136', 'mmaez8', 'paouqua@mailbox.in.ua', '+2637685429136', 'Zimbabwe', 'Younger Grades', '', '', '', 'now', '', '', '', '', '', 'YjgyMzk2NmRiMjc3ZjM5MzY5OWZhNTNiYzQzYzFjZTM2NWEyNDFjMDY5NTdjM2Q3NzBiMWQxNzhiZWY5M2RmMw..', '', '', '16-08-2025 06:55'),
(108, '* * * Win Free Cash Instantly * * * hs=91b95bd792e66b3690164a34314acb65* ххх*', 'paouqua@mailbox.in.ua', '+263971475591505', 'z82qtc', 'paouqua@mailbox.in.ua', '+263971475591505', 'Zimbabwe', 'Younger Grades', '', '', '', '', '', ' ', '', '', '', 'MDFkMWJlMDNiZTk5YzA2ZTE5ZmM0MTcwYzEyY2QxYjIyOTRlMDBhODUzYThhNzYyYTg0OGRmZTk2N2E2N2ZkYw..', '', 'umyh9g', '16-08-2025 06:55'),
(109, 'PqByfpqQFfOVgJB', 'izayobese434@gmail.com', '+263jzOTrabtQdvgD', 'LgVdVcztDGCtJ', 'izayobese434@gmail.com', '+263SwpjrAAKrWdjF', 'Zimbabwe', 'Younger Grades', 'cHlEzJdLXv', 'KebHkAhysLbG', 'HvMigAlGt', 'now', '', '', '', '', '', 'NjZmM2MxNThlZTVkOWI2NzJhZjQxYTFkMjhjNmM3ZDcwODUwNmJlYmZjY2I4ZmIyNjdkZGZjY2U0M2ViYTgwNA..', '', '', '16-08-2025 18:21'),
(110, 'ErGBPpAnJTLK', 'ohakaxobi498@gmail.com', '+263KSapjNNbgQ', 'MUwkRmwYtKKwIs', 'ohakaxobi498@gmail.com', '+263TneStLzcUW', 'Zimbabwe', 'Younger Grades', 'dgfGxgjBQX', 'NzOTHuCBdUOH', 'eKJDrKBp', 'now', '', '', '', '', '', 'MGZmYmYxZTJmYTUyM2FlMmQwMTRjZGQ4MDdkNGMzYzIyNzQ0NTQxYzc5ZTk0ZWM2MmJjZGUxZDUwMmUzOWQ4Mw..', '', '', '17-08-2025 14:40'),
(111, 'OajHTBqprCdMb', 'iqudibimeju65@gmail.com', '+263LXNoCsngEPaNmD', 'ejMjeLpTFYkIh', 'iqudibimeju65@gmail.com', '+263rNksqSryccRX', 'Zimbabwe', 'Younger Grades', 'nNlUvdjeFUA', 'rqxefOFWsM', 'gfUGHHUIJup', 'now', '', '', '', '', '', 'YzBhMjZlMzNmNzQ5YzUyZDNiNTI5ZGQ5NTVjNTAyZDgyZDY0OTc2OWM1NWNkYjlhZjMwODBjZDE3MTU0ODVmNg..', '', '', '17-08-2025 19:22'),
(112, 'CuZmaalojcunZj', 'efuhedoja636@gmail.com', '+263DFcuKcNhIuzXUhy', 'mOeJrcRLhW', 'efuhedoja636@gmail.com', '+263FktYIKvBi', 'Zimbabwe', 'Younger Grades', 'ycZyscCWMhKSTqS', 'KnApXPICvhTQY', 'dVMNfLPkJvCxMk', 'now', '', '', '', '', '', 'ODJhYjRkNTU3N2QyZDE0ODE5NGIwNmYzNGVkMzhjOGYzMDliNzdhZTZiNzk5ODA2OWEwNzRkODNjOTI2YjRhYg..', '', '', '18-08-2025 05:06'),
(113, 'bleqrxLn', 'lecafazag98@gmail.com', '+263EQTNBRsfpu', 'IvJLuTRgooZ', 'lecafazag98@gmail.com', '+263tmpYXkCk', 'Zimbabwe', 'Younger Grades', 'ImCqEwWPD', 'EzWLITJtvP', 'XjENSrlhyFxbc', 'now', '', '', '', '', '', 'OTk4NTUyYzZhZDg2ZDI1MGJmYzc2ZDE3MmZlOTZlNjJmOTJmMmQ3ZWY1Mzc4ZTA2MmYyYzQwOGI1YWU4YmIyZg..', '', '', '20-08-2025 10:26'),
(114, 'UQKIevGGUgzfM', 'aaronpegram669358@yahoo.com', '+263oECCzChtZq', 'aptukcNKT', 'aaronpegram669358@yahoo.com', '+263OFtQGUwvUF', 'Zimbabwe', 'Younger Grades', 'avjLTNqgyczeH', 'nuNVAYpVRCrgdTW', 'hBVLpxLfPEDfQhW', 'now', '', '', '', '', '', 'MDEzZTcyNzU3MmZlNDg0MDZjMDcxMDU3N2M4ZTUzMTgyZmM0MmIwYzU2MzYwYjRjZTE3MGQ0OGRkYWE1NTM2YQ..', '', '', '20-08-2025 16:03'),
(115, 'wGMbKTmst', 'bubimoh163@gmail.com', '+263xvkuyLtWOkfA', 'mlTkeJtFctoCEw', 'bubimoh163@gmail.com', '+263gjFUkMJVmbIAhHT', 'Zimbabwe', 'Younger Grades', 'cHSUPecUCoy', 'laRcqWCXHF', 'PUAQrQuMwRo', 'now', '', '', '', '', '', 'YjcyYjdiMDFlNzc4ZDA1MDY3NjA2NzhhMzAxNmE4OThiNzlmNjZiZWQ1YzU2NGJlN2E4MTNmOTAxODE4YzBiYw..', '', '', '21-08-2025 10:45'),
(116, 'XCpeFfFirVcsOy', 'samasuqeci83@gmail.com', '+263bFacfOOtmNAGCt', 'NHcMmurcd', 'samasuqeci83@gmail.com', '+263AzIBHndpBresosq', 'Zimbabwe', 'Younger Grades', 'lqImiUdJf', 'EzjVKnUzwjjgRy', 'jXCyWfpH', 'now', '', '', '', '', '', 'ZTllZGRmOTIzODdjNDhkNjg5YzhmYjMwYjViMTA1YmE1MmMwNGNjYzQ3MjM0MTQ0M2EzZjAzZTJlMmQyZWI0YQ..', '', '', '21-08-2025 16:54'),
(117, 'ajZQcKHYCWTL', 'dixonaelftritr2005@gmail.com', '+263DXmxHvcWgigD', 'chJQzNMSby', 'dixonaelftritr2005@gmail.com', '+263oLpXUeFFk', 'Zimbabwe', 'Younger Grades', 'PHPQlGCOxtOETEr', 'BGUwkUmEGOdQ', 'DHyAyXbHdgT', 'now', '', '', '', '', '', 'NjZlYTQ4N2ZiMzlkYmZhMTg2NDk4YzNkMjcwNWYyZjNmYjY3MjU1YjU2OTk4ZDc1MDQ1MzJkOTg0OGYxZjM2Mg..', '', '', '22-08-2025 11:23'),
(118, 'NBVSlHooYLdu', 'beqehame914@gmail.com', '+263PkcFoDLcB', 'Hwefkman', 'beqehame914@gmail.com', '+263duKbBdYsULtzuM', 'Zimbabwe', 'Younger Grades', 'pdWqEPUpz', 'LrQqWApXNrcrzY', 'LDBNkgTShEey', 'now', '', '', '', '', '', 'OTM0YmU5NzZmMTQ3ODBhYjg1NjA5YTVhMWI5ODMzYWJjYzhjYmRhNzEwYzE2ZmMxMzMxOGY5MTViYjljMWQzYw..', '', '', '22-08-2025 12:30'),
(119, 'wnHYOPdUexGX', 'oveqawet24@gmail.com', '+263xUQxjsaynGe', 'zfONSMfahJlXb', 'oveqawet24@gmail.com', '+263SfHdtJbXSR', 'Zimbabwe', 'Younger Grades', 'StRcTGKNhAm', 'EorEKSrtnoXGby', 'BEzWEPjk', 'now', '', '', '', '', '', 'MGUzY2RiMGZlMTRmMmU5ZmY4ZDRlOGEyYjNmOGI4ZGQxMDZhMGNkNTQ1YjViM2U5ODI1MzBmNzMzYWQxOTJjZQ..', '', '', '22-08-2025 13:24'),
(120, 'XoirCCeHJJ', 'ijopakaqovo27@gmail.com', '+263xFmQdFpEKXrYgI', 'jTmbXfWWPOlD', 'ijopakaqovo27@gmail.com', '+263XhZfqruqh', 'Zimbabwe', 'Younger Grades', 'HiHXUVsmYrIXTw', 'qVjtzjrxIV', 'orQOjGcjFUFIjua', 'now', '', '', '', '', '', 'MzQ5YWUzODdkN2M4ZTk4ZjZjZmYwNjU5YzI0YTg0MmZhNjBhMjZmMzdkNGE0OTAxOWYyNzkyYzVhYTc0MjE2YQ..', '', '', '22-08-2025 19:21'),
(121, 'xYvgMKqFICu', 'ayayotuyah79@gmail.com', '+263FrTjddsjTw', 'BvjPXZyjO', 'ayayotuyah79@gmail.com', '+263UQPLEjZwYFxxy', 'Zimbabwe', 'Younger Grades', 'voGpsMxzVU', 'HZHgIHqQj', 'ukFqpKHPRGHBL', 'now', '', '', '', '', '', 'OTYwOTFjZjkwMGNiOThkNjIwMmE1YzVjMGQ0NmM5YTRhMjY4MzQ5YmVkNjExZGNjNWQ0MzJkYzdjMjQxNTZiNw..', '', '', '22-08-2025 23:34'),
(122, 'ctKKqOYSye', 'bevicimigib336@gmail.com', '+263GZcOJhMoiYvE', 'GYiGLruNj', 'bevicimigib336@gmail.com', '+263EdVDyzgCxSO', 'Zimbabwe', 'Younger Grades', 'vCKYlaAkFYrmi', 'UqBECEeBlPhG', 'sdzVtMbWPozI', 'now', '', '', '', '', '', 'MmMyODAxMTVjODAzMGQ4ZTJlNTVlOWJhZmRiYTcwMzIxNjlkYzZhZTc3OGY1NmQzYWUzZTJkOTY3ODgwNzBlMA..', '', '', '23-08-2025 06:27'),
(123, 'HOooHTKom', 'cuzofop300@gmail.com', '+263RrPcbsldoQ', 'DIzPKbIB', 'cuzofop300@gmail.com', '+263ZWWbOzauiUWg', 'Zimbabwe', 'Younger Grades', 'jDLCPAxemYKRw', 'pgNKzRUcSEX', 'CqmaHnxGpfgY', 'now', '', '', '', '', '', 'ZmZjODRhZDgwODM1YmRkOThjOTc3Zjg3NGNhYWEyODczMGFhZWI3Y2EyNTkzMzhiMjJhZTY2NTIyNDg0YzZmOA..', '', '', '24-08-2025 02:26'),
(124, 'gygzPwbtKrIl', 'eqigegi076@gmail.com', '+263uGxMPDIYrM', 'LIbGZHcU', 'eqigegi076@gmail.com', '+263znlwoCCcJSAG', 'Zimbabwe', 'Younger Grades', 'JjDrdoVOkL', 'wYYaKRzysB', 'hexzKfJU', 'now', '', '', '', '', '', 'OTdiYjFjZjdlNTY4YmVkZDE0MTdkMWU0NjQyOWRiZTFjYjgyMmQwNWVkMzdjY2U3NWJiNGQxNDVkMzA0MjRmMg..', '', '', '24-08-2025 12:45'),
(125, 'MfdLhWRSz', 'iwubehexu351@gmail.com', '+263vazQymmfq', 'wAFKyvwniiQT', 'iwubehexu351@gmail.com', '+263vhEWyELfRSjiBDI', 'Zimbabwe', 'Younger Grades', 'ToEJJCgvKXJdb', 'ALjdthlsUfzRwc', 'FvKPDaqky', 'now', '', '', '', '', '', 'OWFlZDhmN2E2ZmI2YTQyYjE5NGI0ZWY5OTRmOGY4Mjc5OTk1MTMwYWQ5NTc3YjNiMjE3NWY5NDE3ZTlmYzM2Ng..', '', '', '24-08-2025 14:36'),
(126, 'IBSdNxZC', 'beqehame914@gmail.com', '+263NmfIfZvL', 'HRjpeoopAWxMieZ', 'beqehame914@gmail.com', '+263kCXPwsEOtw', 'Zimbabwe', 'Younger Grades', 'vDeFQkQGJ', 'rHAuiCBUt', 'LECodksEVbh', 'now', '', '', '', '', '', 'Yzc1ZGNiNjc5ZWU0Y2U0Y2RiMzgxYjJjMGNmOGVlYmEzNTEwMjZiYmY5ZWYwMzRmMzgzMzU5ZTFkN2M5NmFiNA..', '', '', '24-08-2025 15:05'),
(127, '', '', '+971', '', '', '+971', 'United Arab Emirates', 'IGCSE-AS', 'Biology', 'Edexcel', 'IGCSE – Biology – AS – Edexcel – Jun25 – Unit 3 [Dr Gehan Fares]', 'later', '', 'EGP 7500', 'EGP', '7500', '', 'ZjIxYjAzNmRhN2YwZWQyNTMzZTcxNjZiMmU4ODk4YzBhMTVjMjU3MmM5ZmNjYzEzZTg4NjU1ZjJlNTZhYjE5MA..', '', '', '25-08-2025 07:49'),
(128, 'rXqRaxQdbYpYF', 'akejuyow05@gmail.com', '+263aRRmLFUsVcHery', 'HFIvzkJoYHkjHNq', 'akejuyow05@gmail.com', '+263DCoirWNEUBg', 'Zimbabwe', 'Younger Grades', 'SpaarlcpHrM', 'KYvVovKkKattqOU', 'YvFjMUtCwsnoUAR', 'now', '', '', '', '', '', 'MjRiNWFlMmI2MGJkYmJiZGVmM2M4NWFhYTNjY2M1NDdkZDc4OWYzNGVkOTgwZDczNzdjZThhMWJkZTQxNDYzNA..', '', '', '25-08-2025 15:53'),
(129, 'MAUtAnBAlWfRoB', 'ayojogab151@gmail.com', '+263xLwhJQnRWbOOV', 'dftPWBkk', 'ayojogab151@gmail.com', '+263uMrVtxghWVUKkY', 'Zimbabwe', 'Younger Grades', 'cJtFiiwClkcxwM', 'DGhgEskrUeJIu', 'RGUbOUaHEL', 'now', '', '', '', '', '', 'NDE2M2ZhZTI5MjNiYTRhMzdiZDNjNzUyY2NhYTg0MWUyNDYyYzkzOGJjYWRmNTIxN2RiMmM2ZWI0MWE5YTI3Zg..', '', '', '25-08-2025 20:14'),
(130, 'ajLCqeICBCANbEE', 'nopohufuxej416@gmail.com', '+263WGisMCfgBCXGF', 'FADGReKik', 'nopohufuxej416@gmail.com', '+263xRysRMKkkUnby', 'Zimbabwe', 'Younger Grades', 'jfmaOFzHrwgELz', 'nRgKtFpT', 'ygAyUyqXkrYzV', 'now', '', '', '', '', '', 'ZjI5NDc4ZTA3MDllMmE4MWViM2Y3MjVjNWE2NjQzMmQ1N2NiMjcyM2RjOTY0OTc0ODIwNGYwMDViMzAyZDA4NQ..', '', '', '26-08-2025 07:47'),
(131, 'UOqNtDRxFQyzajy', 'jupozizaca868@gmail.com', '+263mNOjJyrzCEC', 'eduMDppnESyWV', 'jupozizaca868@gmail.com', '+263XWHYwiLXLC', 'Zimbabwe', 'Younger Grades', 'kVlWHTvk', 'mdkpmqITXxO', 'BnQMuiOyiUZdJ', 'now', '', '', '', '', '', 'NzcwZDE3ZDBjNGM5NTA4ZDA0YzIzZTEzZTMwMmFiYTFlNGNjOTU2ZGE0YWExOWQ5OTVmMTE3ZWZkNmU0NjM2Zg..', '', '', '27-08-2025 06:27'),
(132, 'euGpyniuBoZUBJ', 'jamefuj005@gmail.com', '+263qORWzOHuch', 'IKoPMjRp', 'jamefuj005@gmail.com', '+263LnBNZelvnKL', 'Zimbabwe', 'Younger Grades', 'gsxgcjZN', 'owMcVqJkoh', 'HrdtyvkdZBqjSI', 'now', '', '', '', '', '', 'ZmM0Zjc0N2RhZjQ4ZjczNGNhMDhkZTFiOTRmOWFmMzNlNjA3OWUwODk1NzJlMzgwOWFhNTU3ZDJkMTFjMTEwYw..', '', '', '27-08-2025 08:19'),
(133, 'BFUNQHRzYstIA', 'urotujut104@gmail.com', '+263hmGQqoyDKu', 'lhvFAYvPOC', 'urotujut104@gmail.com', '+263vjJQzuAyLgma', 'Zimbabwe', 'Younger Grades', 'oQIpkWOgZuiuvr', 'wwhMfwEUyKcTBBC', 'uLqgdvwmfkwM', 'now', '', '', '', '', '', 'Y2MzNGRiMzI0NTE3YmFhODhkYzE4MjUwOGQ0ZGYzODVlNTkxZTZlZGE3NWJjMWNkZjViZTU4ZDY0MmM2NTViMA..', '', '', '27-08-2025 15:08'),
(134, 'EhTxIqxM', 'eqigegi076@gmail.com', '+263dMLRRapaBzO', 'zUPOUwawPKuU', 'eqigegi076@gmail.com', '+263sEOTVmMQWX', 'Zimbabwe', 'Younger Grades', 'YONWXqnEp', 'HXrNAdLNQgQUltn', 'tRhrBhiYOUul', 'now', '', '', '', '', '', 'MDFkNTdlZWM1ZTZhZjQ4YWE1Y2ZhOGZmMTE2YjVmY2RkYmNiNDMyMjM5ZGZjNmFjNmExYTFiOWZiMTRkYjFmOQ..', '', '', '27-08-2025 17:49'),
(135, 'dRMBFRUVEaTJKXf', 'edurosusi489@gmail.com', '+263WozKIriR', 'CtpLeUyUdgtg', 'edurosusi489@gmail.com', '+263KZqMkXpzDRM', 'Zimbabwe', 'Younger Grades', 'ezTOJNWYX', 'xcUgSYXSxjQ', 'RTpoeYPrJMzctEu', 'now', '', '', '', '', '', 'MTFlMDdmZTE0OWE3Njk3NjFjOWJiMTlhMTI2NDg5ZjJhMDNkYjgwYWEzOWIyOGQ0MTFlYWViMzJjYTU5MGE0NA..', '', '', '28-08-2025 16:20'),
(136, 'NiWpDgSAsroHaCP', 'oxomoqu613@gmail.com', '+263pExOrlMsridk', 'dkuWVKNL', 'oxomoqu613@gmail.com', '+263rLyqVXbj', 'Zimbabwe', 'Younger Grades', 'qRKEEVsqIo', 'wEaoSkwKfxkvS', 'sDXItBFdVjqCTzN', 'now', '', '', '', '', '', 'NjhmMzJjMTExZTA5MGNkNTBmYWJhOGY2OTEyMmNlZTM5ZWI1YTFiMjY5MjIxNDA0NTE4Y2VhMjUxYjM0OTUyMQ..', '', '', '28-08-2025 17:02'),
(137, 'TipZueLORqZ', 'ijopakaqovo27@gmail.com', '+263Evswaedb', 'YzMRjgLucQl', 'ijopakaqovo27@gmail.com', '+263cciZCZkMgwqshsN', 'Zimbabwe', 'Younger Grades', 'GMIeringLLXeswR', 'QxYgpkJMPgGZdPa', 'WjUOkirBwu', 'now', '', '', '', '', '', 'MWRiZDE2Y2VkYTgwMWMyNzA4NjhjY2UyZDE4NTlhNTRhYmY5ODRhY2ZmYzg4ZjI0NDdjZTM2Yjg3ODhjNGM5Ng..', '', '', '28-08-2025 18:17'),
(138, 'Khaled tharwat mahmoud', 'khaledth338@gmail.com', '+96560094701', 'Doaa mahrous', 'doaamahrous78@hotmail.com', '+96590080461', 'Kuwait', 'IGCSE-OL', 'English', 'Oxford', 'IGCSE – English – OL- Oxford - Jun25 [Mr Mohamed Abdelsalam]', 'later', '', 'AED 1250', 'AED', '1250', '', 'NTgxZDgxOTM2OTQyYWNmYzdmYjYxNGM5MDE4NzEzODExZDViMzI5MzVmZTM2YmIyZGQ5MzQ3MmYxM2I0N2U2ZQ..', '', '', '28-08-2025 19:19'),
(139, 'YSyxuaNw', 'datozorisi59@gmail.com', '+263FItnsMbZF', 'OYlvwxxbLjuE', 'datozorisi59@gmail.com', '+263BIOgkSaUrF', 'Zimbabwe', 'Younger Grades', 'xUETrPghNf', 'XmkvRGdb', 'YyAtyVvb', 'now', '', '', '', '', '', 'OTFmOTY3MjkxZTEzZTNmMTNmMjQ0YzcwMjVkZWYzNzYwMjhmOGNiYTE2MmE1M2JkOTA5MWQ3MGVmMzQ0ZGE1OA..', '', '', '29-08-2025 09:28'),
(140, 'IpZETkfrv', 'eqigegi076@gmail.com', '+263xRdgMfeJDPxHFe', 'MZBEhSSMYbfh', 'eqigegi076@gmail.com', '+263XwQKQustW', 'Zimbabwe', 'Younger Grades', 'mhhWiAixJ', 'MMeVhbssvJXql', 'LuBaQlrWFyf', 'now', '', '', '', '', '', 'YTFhYjU1NGVhZGJhNjYwOWZmZmQyOGZiN2JlYmQ1MDA5NzJkODZmYzQ0MzNkMjZlMTNiNjE1ZDhmNjliNDUzNA..', '', '', '29-08-2025 13:04'),
(141, 'NWoRYpDLpHMH', 'akejuyow05@gmail.com', '+263UZZNCUxXljdI', 'FWIMtHBsZKUt', 'akejuyow05@gmail.com', '+263nnEWHMUbLPQ', 'Zimbabwe', 'Younger Grades', 'MbsfKDkb', 'gfcsRDKjtRRPjJ', 'aqvpTaVj', 'now', '', '', '', '', '', 'MDI3MDMyZDIxMmFlZTM3YWI4YzBjODVhNWRmMDNmODljMGRlMjExNWRkYzk0ODdlZjFjM2UwNGVlODFmMzBkZA..', '', '', '30-08-2025 05:31'),
(142, 'HrLcVeaZG', 'ihigakuhe54@gmail.com', '+263bjGirLPIGlad', 'YLESmLUmY', 'ihigakuhe54@gmail.com', '+263zcDWaRvUGVskUgu', 'Zimbabwe', 'Younger Grades', 'itNcdzQRsF', 'PxUCFmEtz', 'kwwwYpWY', 'now', '', '', '', '', '', 'ZjI5NTEwODdiNDhkYWIwMTkzNzM0ZmMwODEyMTY3YTVlZTM2NDkyOGY2NDg1MDdiZGY2YjZjMjRlYjZkYzBhOQ..', '', '', '30-08-2025 23:30'),
(143, 'hdkfifrwgv', 'dsrduhty@testform.xyz', '+93+1-661-737-6498', 'fmltqyuxqt', 'dsrduhty@testform.xyz', '+93+1-661-737-6498', 'Afghanistan', 'Select Category', 'Select Subject', 'Select Board', 'Select Course', '', '', 'tztdfftv nltrhozm', 'tztdfftv', 'nltrhozm', '', 'NDQ0YTNmZWEwZmRiYTQ3NmYwMDhmZWU0ZWZiMzllMzVhMWEzYmMyYTA2OWY1ZWRhOGFhZDhmNTZhMTFiNGIyZA..', '', 'hsdmsogwfejtsfjkqmoqudosoeehex', '31-08-2025 00:19'),
(144, 'joqnozmxjh', 'vjwzjrhs@testform.xyz', '+93+1-071-874-6324', 'mvxxoerijm', 'vjwzjrhs@testform.xyz', '+93+1-071-874-6324', 'Afghanistan', 'Select Category', 'Select Subject', 'Select Board', 'Select Course', 'now', '', 'epdsgdri', 'qmvhfgki', 'gwmddqih', '', 'NjFmMWRkODc1ZjZhNWU5MzMzM2I2ZTJmYmFhMjI2YTRiZWZkOGU1MDU3Y2MzMTIxZTZjMTRlYTM5MTRhOTUwZQ..', '', '', '31-08-2025 00:19'),
(145, 'UpZhYERcEpVE', 'jogmqfqru@yahoo.com', '+263oOGoJPQATO', 'deDvRIcJjU', 'jogmqfqru@yahoo.com', '+263OmNXHVczlWQXTPU', 'Zimbabwe', 'Younger Grades', 'YtZLdLcpFwevY', 'hGKomQGRYAnWBbx', 'zSXPMcOqUdgR', 'now', '', '', '', '', '', 'MzVlYjEzODA5NzkzZTJjZGNlMzU5OTMxM2E4NjBjMGVjZjYzMDllMWQyOTFmN2EyMTQwM2E0M2IyYWEzMzYwYg..', '', '', '31-08-2025 06:20'),
(146, 'qVluMqSVssgNx', 'dequrulofi31@gmail.com', '+263ajVdJiKteOSjT', 'OgyqOLwgo', 'dequrulofi31@gmail.com', '+263gXvOWuEidLu', 'Zimbabwe', 'Younger Grades', 'EwAvdSlXcBwVtfG', 'mwPexHMoJGogalm', 'KcooWmCLJq', 'now', '', '', '', '', '', 'YThhM2Y5MzlkOGYzY2VjNTc2ODJjZDYwNzRhOWQ5NjY1MzE5ZjgyOTUwNTAxNTE5MTE0ODFhYmM0ZDUyMzM2ZQ..', '', '', '31-08-2025 08:44'),
(147, 'QILpbHVA', 'iwubehexu351@gmail.com', '+263FETPsqyuZnIoQ', 'pjufNSMBlYydKq', 'iwubehexu351@gmail.com', '+263yFamTOjp', 'Zimbabwe', 'Younger Grades', 'PiCBJwiu', 'UfkCQrOvEIbIx', 'HdSeYeMYKzrSj', 'now', '', '', '', '', '', 'YTlkMTQ2YWY3YWNmYzk0NzVlNTE0MDJiYTZlZDNhMWMyYjI2OTEzMTIxODAxMWRjYzgzZjZjMzI5Yjk3NjM1Mg..', '', '', '31-08-2025 18:12'),
(148, 'FkXbLtVOodxBfo', 'ayayotuyah79@gmail.com', '+263TTapeveJ', 'TtvskiYQ', 'ayayotuyah79@gmail.com', '+263BJpGdMXP', 'Zimbabwe', 'Younger Grades', 'AbZCULRkQu', 'ZVJYueBmfuTXnn', 'QdYXvmoocorC', 'now', '', '', '', '', '', 'OTA3NTQzZjlmODY2ODlkYjdjODNhMjBkZjI4Y2Q1NDQyNjIzMmUxM2MxNjVmNjc0Njk0OTIyMmQwOTQ4MDM3ZQ..', '', '', '01-09-2025 07:19');
INSERT INTO `jwy_express_courses` (`id`, `name`, `email`, `whatsapp`, `parent_name`, `parent_email`, `parent_whatsapp`, `country`, `educational_system`, `subject`, `examination_board`, `course`, `pay_status`, `course_other`, `origional_price`, `origional_price_currency`, `origional_price_amount`, `paid_amount`, `custom_link`, `students_notes`, `admin_notes`, `timestamp_req`) VALUES
(149, 'NBEpWQnuXZGa', 'ikubiyise18@gmail.com', '+263sugUTWHDeucvkQO', 'DeMPKHTO', 'ikubiyise18@gmail.com', '+263zmWZXkibqx', 'Zimbabwe', 'Younger Grades', 'DphMpKgdUSVcPg', 'cKclaVssFZSu', 'IcEvHsACEFbvjO', 'now', '', '', '', '', '', 'MWRhZDJhYmFlNjYwZmEzMjNmNGNhMmU2ZWE2NjViMTA3ZGU4MmExZTU3YzFhMDY2NjMzYTc4ZjhkOGI4NWQxNA..', '', '', '01-09-2025 09:37'),
(150, 'ZqSxcDgHjmakn', 'ijopakaqovo27@gmail.com', '+263scwnELeSvrzGiba', 'PwVMkHIFCjwPrma', 'ijopakaqovo27@gmail.com', '+263auYIEOFJJ', 'Zimbabwe', 'Younger Grades', 'DROCPGxJqBJFX', 'cerUdrDCOMur', 'tPpxCmIhIa', 'now', '', '', '', '', '', 'MDBlMGNiOGRkYjEyNzhiZmVkNDAwODZmMDNhYzk2YTk4Y2Q4MGE5YmRiZjA4NDlhNWRjNDJiNTNkZGZkZTFiOQ..', '', '', '01-09-2025 13:29'),
(151, 'YaFTxBFfEmN', 'bivopogo445@gmail.com', '+263OHbksJBOlPV', 'piTpswLPcHJG', 'bivopogo445@gmail.com', '+263uJoADEYnEoBtgH', 'Zimbabwe', 'Younger Grades', 'EHiDbpsmcq', 'hwxCsOLbjwJ', 'OFqOiPQjpfgw', 'now', '', '', '', '', '', 'YTdkODQyOTY2MzIyNjNkY2M1OTAzYTE2ZTI2MDViYjRjNTNhMmRhZjA1NDRkNTVjZDViNjA1MjYzYWJjMDY5Yw..', '', '', '02-09-2025 07:00'),
(152, 'NfSQQBhQtV', 'qijudonabo94@gmail.com', '+263iynPszfOzNkwy', 'GYJlWlGMAwWD', 'qijudonabo94@gmail.com', '+263IjgPtcgaSxZS', 'Zimbabwe', 'Younger Grades', 'RefjnzfgTEScqi', 'NTfdoDGxnPahx', 'MTTWnkzDfHS', 'now', '', '', '', '', '', 'OWNmMDFjYmZiZTg0NmY4YjVmYWE0NWVkYzNhM2M3NjA3MmYzYjdkMTczMjg5OWRhOTUxYTRhNzFkNTkwYmVkMw..', '', '', '02-09-2025 18:49'),
(153, 'FAyiAyoIrfPTAtJ', 'ejlxjxgerf74tb2@yahoo.com', '+263icxCcRdsg', 'zDVVzKmaIllAvYp', 'ejlxjxgerf74tb2@yahoo.com', '+263enWfELnpx', 'Zimbabwe', 'Younger Grades', 'PwXLYqAkakrea', 'EthrBeXWNvubraK', 'HPUdMmRnLvD', 'now', '', '', '', '', '', 'ZjNlZGNmN2I1NjUwZTliYjM1YTMzNmRjMThiN2RmZmM4ZTdkNzU1NjAwYmVjYmU3MDViOTEwM2MzN2JkNzM2Ng..', '', '', '03-09-2025 07:57'),
(154, 'ivvOniRjUv', 'afomufivik35@gmail.com', '+263KjCIQxqGjCr', 'rhVPxOrUHBVdMCJ', 'afomufivik35@gmail.com', '+263aWtAQgGX', 'Zimbabwe', 'Younger Grades', 'UfEZlvuQgZ', 'gRuEPqTkcV', 'AkxDtFTrTYJ', 'now', '', '', '', '', '', 'ZDAyM2E2OWIwMTE1NzI4YTEyNDc0NmNhN2I5ZTlmZjVjN2FhZDNlZmNjZmE5MTdjOTRiNWZkNTMzNDk2M2RlYQ..', '', '', '03-09-2025 14:22'),
(155, 'jTYUTiRxwYgKps', 'xntbvhglyyfkoml@yahoo.com', '+263rTEsYYbPTfPiqU', 'JDXaPUbnAdGtaQq', 'xntbvhglyyfkoml@yahoo.com', '+263DSSBrNwrSdMATk', 'Zimbabwe', 'Younger Grades', 'ydFfzlboxiXuYo', 'BpZdssbe', 'wWQUveqoVEVDnSd', 'now', '', '', '', '', '', 'YjdhMzBjNmY3ZWFkMTI2MDk1YjZlNWJiNTU2MDZjOGExOTA4ZjVjNzk1OGUwZmZjMTcyNjQ2YTI5Njc4ZGY0NA..', '', '', '03-09-2025 14:41'),
(156, 'QWImjILMjVDY', 'beqehame914@gmail.com', '+263jMdqVYVJfRxi', 'IKcwyakuQYS', 'beqehame914@gmail.com', '+263uFUcBRsgIgOIxg', 'Zimbabwe', 'Younger Grades', 'dPIEdhqpqQuS', 'MBWtWJvEzHaW', 'EHGCwYFVIZh', 'now', '', '', '', '', '', 'YTY3MWM3NWY5OWI3MDUxNDMxZmVhZjkyMDNmYjhmODZjOTg4MGQwNDg5OGYzYmE2NzIyMjM1OTg1ZDRmMmJmZQ..', '', '', '03-09-2025 16:13'),
(157, 'kzEOcLngxMnw', 'exadahafepa12@gmail.com', '+263ZhjcRXoVVv', 'OTlwqAEOmXi', 'exadahafepa12@gmail.com', '+263MywkHGtyvic', 'Zimbabwe', 'Younger Grades', 'aQjKutfNTTgXK', 'MCWQzVGZmq', 'BDHLnGIHciln', 'now', '', '', '', '', '', 'YWU0NDg5ZDQ5NzUyZTJiYzM0MWY2YTIzYmRkM2EzNWI4YzlmN2NlNjVlZWU0ODRmNGQwZGMxMGZjOGMwNGVmOQ..', '', '', '03-09-2025 19:08'),
(158, 'upYSqPXJ', 'ohrmacddq6maqiz@yahoo.com', '+263ztjHGTelh', 'uyWwIqFwo', 'ohrmacddq6maqiz@yahoo.com', '+263grGfnhIghkF', 'Zimbabwe', 'Younger Grades', 'ATDbEbGU', 'kHMdMElfsgdk', 'NasRVwkpwBNO', 'now', '', '', '', '', '', 'MTA0MjBkMTZlNTY1YzgzZGQzYjNkNDQzZWUzMWRjOWFjZDY4YzhmZDQ3MjQ5MjY1OTgzYzhiZTlkYmRkNWM0OA..', '', '', '03-09-2025 22:44'),
(159, 'FYjNjMvG', 'ayayotuyah79@gmail.com', '+263eeqUHKzTSR', 'jjDmggLzGKqKYb', 'ayayotuyah79@gmail.com', '+263JlRHTGFkb', 'Zimbabwe', 'Younger Grades', 'RMoTxywBcHqDP', 'uBLeyuLS', 'YTUQtjalGrw', 'now', '', '', '', '', '', 'Nzg5OTE1ZDc4ZGE5MTBkMGFlOWNhN2M5NzlkNDNiZmRiNjJjZDg5ZDcyMjlmN2FkNGJiZDdkNmZmOTBkMWE3MQ..', '', '', '04-09-2025 00:05'),
(160, 'PWBgjWfLH', 'bevicimigib336@gmail.com', '+263qkSCvsVOEtEKl', 'kCvwNPimEzcxEd', 'bevicimigib336@gmail.com', '+263RptYApFpRQOT', 'Zimbabwe', 'Younger Grades', 'gmBWaecfdTjx', 'OSoxjapbpFpPEgI', 'qxNfXVrNz', 'now', '', '', '', '', '', 'YmNiZjEyY2E0NjUzYmM2NzAxZjhkNDM5ODUyYjQ0N2VkZjA0NTEzYzIyYzE1OWExNGE2ZWI2YjgyYTA3MWJkMQ..', '', '', '04-09-2025 08:38'),
(161, 'zxVMxpUKxaC', 'iteroxezun534@gmail.com', '+263wFRnkrugnUN', 'FbyXAtpoamiGq', 'iteroxezun534@gmail.com', '+263cSMYrkSdZqHZy', 'Zimbabwe', 'Younger Grades', 'qjvVLwJdYLk', 'IwGxSWoUBetHmY', 'MqbEtSctEbCpH', 'now', '', '', '', '', '', 'ZTAyZjU0ZjkyMTk5ZmQ2OWRlZjRlMjM5NmE2MDg1ZTNkNDBkNjUzNmMxMDBjNzg1NmQxMjQ5MzZiMWM4ZTE2ZA..', '', '', '05-09-2025 01:58'),
(162, 'KbLhuLDtjZfy', 'unomesfridokxhd@yahoo.com', '+263ElkOeXCJQ', 'xSbPEqgnmeJ', 'unomesfridokxhd@yahoo.com', '+263meWYhZdzGlmDj', 'Zimbabwe', 'Younger Grades', 'nxueRPESvEIPdn', 'IxazdWkziTAHwpP', 'BCJYoyMorsav', 'now', '', '', '', '', '', 'MjBjM2I2ODg2NzAyMWQzMmU3ZjhmYzhmOTFlNjQ5NzdhNmM4Y2Q2NzlkZTJhMmVjODBhYzUzYTQzN2ZlZmQ4Zg..', '', '', '05-09-2025 04:14'),
(163, 'njbnZhknTXl', 'serikakulo555@gmail.com', '+263EmmLKVFVoHt', 'vWjUToJq', 'serikakulo555@gmail.com', '+263miFqeHGQtvN', 'Zimbabwe', 'Younger Grades', 'DkUQofdBUdfSS', 'wBjtkhSxwrqrr', 'nrtqsUnNWcDqr', 'now', '', '', '', '', '', 'MmMxNzRlZjQxNGE5NDI3NjUyM2MyZjMwNmMzZDFjZTZjMjZlZDg2ZWViOTY5N2U1YjFiMWEwMDk4ZGJhMzYzMg..', '', '', '05-09-2025 11:08'),
(164, 'jbZiZxLlArAcyPH', 'azefisasowo953@gmail.com', '+263ZuvpxFDUP', 'bvHsTnAmaKgl', 'azefisasowo953@gmail.com', '+263uMEwnTRfm', 'Zimbabwe', 'Younger Grades', 'wNKmdwdbrIDZvGM', 'QiRkGrWqpJm', 'nMtZYRZSzlDhmB', 'now', '', '', '', '', '', 'YTQ2MjBiYWVlNWEzNzQ4ZTAyNTZiMWEwNWNhZTM2ODRiMWMyNTM0NTdjYTMyZDkzYzYyOGVkMDhiZTI4MmUwNQ..', '', '', '05-09-2025 12:08'),
(165, 'ZxnnjaCYDgHiBvL', 'baqoman731@gmail.com', '+263XwvNsaKWNrjQnV', 'ExhhQAxDCI', 'baqoman731@gmail.com', '+263sEEDYesZHsUumS', 'Zimbabwe', 'Younger Grades', 'EUeJEOuDyXiuV', 'FTVmknwdKUjgi', 'ArUZiUgbg', 'now', '', '', '', '', '', 'NjZmNjEyMmU5YTcxZDFlMjgwOWEwMWFjNDFhOGJkZWQ4M2QzZTdlMjcxYzg0ODU5M2Y4MzU4NDUzNzBkMGE5Mw..', '', '', '05-09-2025 17:34'),
(166, 'ZwGuiXhCwZXasG', 'eqigegi076@gmail.com', '+263nJtYqgFYnEg', 'qZgKvKlLDr', 'eqigegi076@gmail.com', '+263YeRmzQtOLOq', 'Zimbabwe', 'Younger Grades', 'cPURzMIKzkRV', 'aArvxCQSYcrTCp', 'LSZaWVxGpCAs', 'now', '', '', '', '', '', 'OTIxNzZhMGU5MWFjZDU3NTk5NWE3ZjdjMWViMDk3MTk3YzVlZDYyN2VmMjEwMzgwMjAxZDc4NzVmN2JjYzYwMA..', '', '', '06-09-2025 02:44'),
(167, 'mqHhzFHkKmFDlis', 'nedocohoj18@gmail.com', '+263YeqLclpvz', 'pFfEFeNfjnf', 'nedocohoj18@gmail.com', '+263WrUjrjKCzoWlO', 'Zimbabwe', 'Younger Grades', 'LHBtvjNHD', 'TzLipWsw', 'rduDJjfsARMQ', 'now', '', '', '', '', '', 'YmMxNzJlYmQ0MmZmMTc2ODI5OWY2NmZmNjY0ZWM1ZDkwYTA4ZWQwYWQzZTNmZDVlYmQxMjg3OTUwMmQzMzBhNA..', '', '', '06-09-2025 04:30'),
(168, 'LcFfzVJBSsuxzP', 'azefisasowo953@gmail.com', '+263gvDGlfkLvTZ', 'vLXMlvgZoIK', 'azefisasowo953@gmail.com', '+263JcOAVzNggpDH', 'Zimbabwe', 'Younger Grades', 'iIgxKfxOH', 'AkdPBKDop', 'VGDKyjALyy', 'now', '', '', '', '', '', 'YmFlNDE1NzhhMjczMzhiY2MxMDM0Njc5ODg2ZTBlMWQ5ODJkNjE5NmMzNzg5Mzk1Yzg0MDQzYzU4NTE4YzcxYg..', '', '', '07-09-2025 02:10'),
(169, 'cZOgYXmyhq', 'schemrahbqhcynagawa@yahoo.com', '+263CeBPlZTGzZcPL', 'uQqkezBnKRQQb', 'schemrahbqhcynagawa@yahoo.com', '+263DtZNMTnw', 'Zimbabwe', 'Younger Grades', 'xxGUifjSxOcuOZ', 'YQXVbCOlnujCoHf', 'WssHQfghWdWJ', 'now', '', '', '', '', '', 'YzU0ZGVlMzQwNjE0MmY5MThkZTA3YTEwZmY5YTVkZWUzNzM4NWNiMWE3NDc5ODkwMThjMDZiMWJjNzUwZGEyMg..', '', '', '08-09-2025 01:09'),
(170, 'fYlBzTSlSiQFF', 'ufaqebubiwe908@gmail.com', '+263EFYTkwsyEsdca', 'WNrmVPKIr', 'ufaqebubiwe908@gmail.com', '+263bHVYxsDzei', 'Zimbabwe', 'Younger Grades', 'XLnesORosLnJQ', 'mFmpzpVv', 'PmKsytfll', 'now', '', '', '', '', '', 'NmFlYTVlMGQzOTRkOWJiMmRjNDI2ZWY3YjZhY2EzNzM2MmUyN2Y4NDM0OWU1ZjJhOWVhYTQ1NzkyM2I5MDhiNQ..', '', '', '08-09-2025 02:54'),
(171, 'FUFOEJzuqc', 'lixojilu16@gmail.com', '+263QwPLTiMo', 'JKMsbVgbDbp', 'lixojilu16@gmail.com', '+263CMiaGuGPujO', 'Zimbabwe', 'Younger Grades', 'xldiedEpcRhzpJI', 'DkzonCXpvLcHLh', 'NeMelEWpWww', 'now', '', '', '', '', '', 'ODZlOTIwZmM5M2FhOTAyNWY2Yzk1ZWQyYzM3ZTdmOTM0MjA0YzUzNGMzMTkxZmVlNDAzYWE3ODJjMzBjMjA2Zg..', '', '', '08-09-2025 03:50'),
(172, 'kDulDhAhhQZTeb', 'qahamuc572@gmail.com', '+263lkOUFUvlFamANC', 'voZinhQtIR', 'qahamuc572@gmail.com', '+263BERkIWkd', 'Zimbabwe', 'Younger Grades', 'sQyODHglrhrKS', 'VGQEDJRA', 'YbqJSdzgL', 'now', '', '', '', '', '', 'OTM2ODM1YWU3MzlmNjJlNDdjNjYzZmMxOTNmZGMzYjY5MmJiOTJiMWIzNzIwY2I5NTNjYzNjMjVkZjRlODM1MA..', '', '', '08-09-2025 14:24'),
(173, 'qTZMRtpnKDDEAW', 'boceqibu67@gmail.com', '+263PBVHNZvGjoBAwp', 'iwVQYpwrvrgu', 'boceqibu67@gmail.com', '+263wwVUkWmPShoNzbn', 'Zimbabwe', 'Younger Grades', 'BnlvvkEROC', 'BqyMqOaPqPIu', 'xbjEjnSX', 'now', '', '', '', '', '', 'MWM1NjA1NzhiN2RmNTFlZmQ1ZTZhZDc5MTkyZGEwZmMyZWJiMzUyMDdiMTA0NThkZTlhZDc2MDdmYTdkNzcyYg..', '', '', '09-09-2025 06:14'),
(174, 'aRZtWeaq', 'qijudonabo94@gmail.com', '+263hylkVdJbbcny', 'gHnVVQCgWJ', 'qijudonabo94@gmail.com', '+263GbpOoqXVQ', 'Zimbabwe', 'Younger Grades', 'ynoEnCzvpfvc', 'YKJcCdHmXy', 'fUUOlppGWRiCOQE', 'now', '', '', '', '', '', 'YWVmOTY1YTJlMTk4ODk1NTFmOTBlMTc4ZmNkZmQ3ODhjMzk0NDZiMTI5Y2FjMWIxMWZhZDJjN2M4MjRhNDQ4Mw..', '', '', '09-09-2025 07:46'),
(175, 'jYoVwPOYBTjCG', 'gumopahaka16@gmail.com', '+263uMCXhxCAoNv', 'KFYlGVHSd', 'gumopahaka16@gmail.com', '+263QGEGMnlCy', 'Zimbabwe', 'Younger Grades', 'gARbtflAqGMV', 'kHWYzWtInEmua', 'fCtiStZBTcdN', 'now', '', '', '', '', '', 'YTUxNDIwNzkyZWNkYmQ5Y2I5ZTAxM2NjMGM1Yzk2YTg4NzIyMmY0NWM5MmVkY2NmNWFlYWMxOThkYTNiODk1MA..', '', '', '09-09-2025 11:36'),
(176, 'SgjEmcPUgcRG', 'oveqawet24@gmail.com', '+263VyQRGUsDvtmLh', 'ZzNFmCgvrFrUtW', 'oveqawet24@gmail.com', '+263kjPCuiZKV', 'Zimbabwe', 'Younger Grades', 'OTucwvLcyoMaWIM', 'bNfcQJRTfa', 'IIApknrEQqHF', 'now', '', '', '', '', '', 'YjRmYjU4YzU0NTgxOGMwNjVlMDJhZTA0YmQzNDIxOWI5ZjI1MjlhNWNlZjgyMDE5Nzk0MWExODAyMzk3NjcwOA..', '', '', '09-09-2025 15:24'),
(177, 'thxrSLSF', 'efuhedoja636@gmail.com', '+263egqgnPtMKuxMYrU', 'JCDQApYLgF', 'efuhedoja636@gmail.com', '+263bxOPxLRgrZihku', 'Zimbabwe', 'Younger Grades', 'rJUWuDnGUuM', 'cyTZSwGQGDr', 'pJsalPTfdqn', 'now', '', '', '', '', '', 'NTBkOTIwZDZiZTViNDJjZjQzNDkxZjJmYzAxYTQ2MmY1YWI4OWIyYWEwOWJiM2JmOGQ0ZjU5ZGJjNjNmNTUzYQ..', '', '', '09-09-2025 21:13'),
(178, 'IXKveKXf', 'hoxuboni83@gmail.com', '+263XBBFrsJjuVhDsaB', 'pkGlXUFVuq', 'hoxuboni83@gmail.com', '+263BZuPwcYugNso', 'Zimbabwe', 'Younger Grades', 'vKHQxJmWPlAXk', 'EcyWNPWSk', 'EPwJsxDgiffrSU', 'now', '', '', '', '', '', 'NjU4YWE0ZDA0MTEyODhkNzQxNmQ0ZjE4NGQzMjNhYmFkMDJmM2M1YWZlNzNmNjNkM2MyM2U2NmI1MDdhMGZkMw..', '', '', '10-09-2025 03:49'),
(179, 'DIznqmunwJJw', 'gbsvikdnllqh@yahoo.com', '+263muCFiSkXmINa', 'hYyJspIJHT', 'gbsvikdnllqh@yahoo.com', '+263SEcVgFNh', 'Zimbabwe', 'Younger Grades', 'rlOiDiFrsUfEkt', 'NCJOYVPRAxK', 'moAxtMqgn', 'now', '', '', '', '', '', 'ZWU2YTMxZTAyYzZlZWY5NjIzM2Q4NDk0OTA5ZmYwMGUxZGNkNDBjYmMyMTJjOGI0YTEyZTUyMmIzZjNiYzgzZQ..', '', '', '10-09-2025 05:19'),
(180, 'BVFnWFCHCDQYSH', 'qivadaja036@gmail.com', '+263wpjAtPSnWRjwxh', 'LZCQfwImVhzUeFc', 'qivadaja036@gmail.com', '+263mhjRrLUHoWXTy', 'Zimbabwe', 'Younger Grades', 'IyLVAQdNKJgBu', 'xTFVOUHEpHsSm', 'GNsbIBxBEEzEyW', 'now', '', '', '', '', '', 'NTYyYzY1ZjcyNTc1ZTk2YWVmMTIwMGMxZjNlMGNkOThhYWJhZThiYWY2NGU1YjIwNGE2NGYwNjlmNGM0ZTViNQ..', '', '', '10-09-2025 06:21'),
(181, 'rgrSJWGUvD', 'ihumuzucar85@gmail.com', '+263GHhdGPypMboOiP', 'RZBLrqha', 'ihumuzucar85@gmail.com', '+263XPNmbZJEvVh', 'Zimbabwe', 'Younger Grades', 'ndoNyOGeGTI', 'cuhhSCGCmq', 'RVABZWlxl', 'now', '', '', '', '', '', 'MjhlYTkxNTM2ZmRjY2Y5NmYxMjZjNzhhY2U0MTkxY2RhODE2ZWNhZGE2MmVkYTUwOGZkNzNlY2M2MWRkYzAwNw..', '', '', '10-09-2025 11:35'),
(182, 'OpQEdeakJmmx', 'wenaniju069@gmail.com', '+263zwMPIaeCCbFkSTz', 'hxNgzzafsRUh', 'wenaniju069@gmail.com', '+263kzRlSgaxrImrJ', 'Zimbabwe', 'Younger Grades', 'SquJEiUrJXoRAGv', 'cOdbzkPQ', 'VlKrAJsnyEFNq', 'now', '', '', '', '', '', 'OGQ5NDI1YTdmMTUwYjg1MGIyZDM5OGFlM2EzZDJhNTJlM2YxMjVkNjEwZWU4Mjc4NWQxY2IxYzBlZjM0OTkzMA..', '', '', '10-09-2025 22:15'),
(183, 'FPevxBKrAHoUoSE', 'ayayotuyah79@gmail.com', '+263AmGrsdXOTIOci', 'RtmkjdVMLzSl', 'ayayotuyah79@gmail.com', '+263yEiqdmladBPUvqz', 'Zimbabwe', 'Younger Grades', 'CrLVbKUtanUE', 'RsqCYfKIb', 'ZmDAEbpdPA', 'now', '', '', '', '', '', 'YzM3N2U1MDk4MDBmZjA0ZjYzNDFhMzhmZjA4MGY3YmQxZDAwN2EzMTJkMzM3ZDc3MzliYzViM2VjZWQxMzEyYg..', '', '', '11-09-2025 11:01'),
(184, 'AvvDUVxannNN', 'owelasuqide155@gmail.com', '+263bxbIfwhQMxAzlS', 'UVGNuGdufZZdcg', 'owelasuqide155@gmail.com', '+263habGNchdKPcA', 'Zimbabwe', 'Younger Grades', 'KMDdbWfdk', 'CuzcRhogpoHdiN', 'rEESbOrVQUCVK', 'now', '', '', '', '', '', 'MmFmM2IxM2FkMmNmNWE1ZTFmYzk5Zjg3MmI4ZDhlOGQzYzViYTI0NDAyYjBmZWE2ZDBiNmY5ZDk4NzM1M2EzNg..', '', '', '11-09-2025 12:51'),
(185, 'DDPZDqww', 'vedavimequd744@gmail.com', '+263qbEIVNMbKCEvM', 'RFbJAHFxrsxDY', 'vedavimequd744@gmail.com', '+263YTfNWNHL', 'Zimbabwe', 'Younger Grades', 'AZCdrYrY', 'KmeOcDBCIHUANGS', 'GpGKoWdPChyvAP', 'now', '', '', '', '', '', 'NmM1NDZkYWJjZDE0YTVkZmNlODVhMTk5ZjNmOWMyOGE1NmQ2ZWNmYWI4MjhkZjIyODVjYTIwMzczMzdiYzFmNA..', '', '', '11-09-2025 18:26'),
(186, 'tONABfMH', 'ijixubiha166@gmail.com', '+263EzkpXKMbda', 'cMxqTKui', 'ijixubiha166@gmail.com', '+263cMAKOHFho', 'Zimbabwe', 'Younger Grades', 'ozhIKBIWWsEFz', 'lkzuKoXKBqYMmx', 'xmAUhQUF', 'now', '', '', '', '', '', 'NzJjODQwZjNlYzgwMTRmMDkzNjgxOTMwZjM0NDNkZTJiOTk4Y2Y5OGI5OWJlMjY3ZmMxMjgxNDBlYjg1MWFlZg..', '', '', '12-09-2025 12:51'),
(187, 'EXlGJuzCmisQ', 'cnrpvwgtwfmtqk@yahoo.com', '+263qvQtfPrzRBrANIy', 'BhWQslPrICnVz', 'cnrpvwgtwfmtqk@yahoo.com', '+263kJETVEBZ', 'Zimbabwe', 'Younger Grades', 'mWqKNgZXEI', 'ugeGBfGY', 'hUJcirITFrtYgc', 'now', '', '', '', '', '', 'OWUwNTA4ZTg4OTNhMDcwNmE0MjM5MTEwM2MyNTc2YWVhMGY5NWU1Mzk0NmJhNzViNDMyY2FiZWY0MGEwY2M4MQ..', '', '', '12-09-2025 17:20'),
(188, 'YZZcBQSMQTjSmS', 'otabafageku755@gmail.com', '+263InQNpvTtcbdgpYd', 'BeclQPjTTUsD', 'otabafageku755@gmail.com', '+263FuLKzHGVARoOnS', 'Zimbabwe', 'Younger Grades', 'VNtMkLwbc', 'wVgCZGPCuBrBz', 'NIvTLMTd', 'now', '', '', '', '', '', 'MGQ1YTcyMDNiZGIwMjhiZWM0ODBmOGUxYmQxOGNlMTZiNGQ0YmY2ODIwMGI1NjIyZjY1M2RmZjg2NDBiN2QxOQ..', '', '', '12-09-2025 21:19'),
(189, 'gRzuKlXaxuzQQe', 'idafecifinuz68@gmail.com', '+263fXDxNzVsesZt', 'cONYjOGhLxBakU', 'idafecifinuz68@gmail.com', '+263KYaLbEWoU', 'Zimbabwe', 'Younger Grades', 'DikJDNRZiE', 'NCHrfMqVIpLGg', 'ALCKnlZUi', 'now', '', '', '', '', '', 'YjI1MWY3NWEyZGE3ZmI0YTYwNzFlNDA2ZDQwM2QwNmQ1NzgzODYyNDQwYWZjMjI4MGE3YTA3YTFmYjAzYzU1YQ..', '', '', '13-09-2025 13:25'),
(190, 'UnshKUIx', 'bead1yltqb@yahoo.com', '+263jzCNCLVdV', 'XYFrhqyZQVkjs', 'bead1yltqb@yahoo.com', '+263WHqIUAjh', 'Zimbabwe', 'Younger Grades', 'wrUiblxw', 'uIuweQDBHqIjGCs', 'jpJYnlQiOgfF', 'now', '', '', '', '', '', 'ZjhmNWVhZTNjNWJkNmI4Y2VkYzFjN2ZjOTUxZGNkZWEwMDQyOWYwZWE0ZTQ5NzFkNGZiOWIxYzZlNzU0YTAxOA..', '', '', '14-09-2025 08:36'),
(191, 'daBjoDSBO', 'gamizuxug15@gmail.com', '+263eyZnYouThE', 'IRXQCMOUo', 'gamizuxug15@gmail.com', '+263LkMVdIzGBH', 'Zimbabwe', 'Younger Grades', 'JGTyIGvLdVbaw', 'GsyinLyCMK', 'HURztXkfeXrwTCs', 'now', '', '', '', '', '', 'NmUxZTJkYTM2NDk5YjIxZjllZWRlMDQxNTUwNWNjZWI1ZGNmOTMzNjY3MTkzYTQ4ZTZkNDE5MjdmNGYwNmY5MA..', '', '', '14-09-2025 13:06'),
(192, 'ILMIpLND', 'efuhedoja636@gmail.com', '+263sgLqFOpIK', 'CivYJpqXl', 'efuhedoja636@gmail.com', '+263adsprjGGblx', 'Zimbabwe', 'Younger Grades', 'mvNjikCgsq', 'DoCEDUerpv', 'qXEgdpEonRbADRK', 'now', '', '', '', '', '', 'ZTFhY2M2OWIxZDRjMmVhN2QwYjZkODdhMWZkMzU0NDNlMmE4OGU5MmU1M2IzZTllOGQxZmQ2NjVhOTMyMzgxZQ..', '', '', '14-09-2025 20:14'),
(193, 'iEhQfBGFkzJ', 'fuxugocacule01@gmail.com', '+263xkCmctQRpZBinQ', 'mRAQyixMraBaY', 'fuxugocacule01@gmail.com', '+263zeNIvzGGpZII', 'Zimbabwe', 'Younger Grades', 'wpuBqjJNXgbR', 'DwBaLcWIp', 'KhBZwfMQNkQpk', 'now', '', '', '', '', '', 'ODE4YmUwMTNlNmJmYTg1ODJlMDdlZjk5ZjlkYWRlMTUxMzlhZjMzNTA4ZGE1MDY0MjVlZjMzNTlmMTc5ODM4NA..', '', '', '14-09-2025 21:50'),
(194, 'DanitAakWqk', 'latno1jgfoglesong@yahoo.com', '+263zrfAKsgPwSeJ', 'VpmDGzfuSqv', 'latno1jgfoglesong@yahoo.com', '+263YwZcnxJXT', 'Zimbabwe', 'Younger Grades', 'RFsIUynoq', 'OxaVcnjFqVSoPA', 'DQwUeelFtEU', 'now', '', '', '', '', '', 'OWI1OWRhNmM4MmE1NjRlYzE1MmRkMzZlZTViZTA2Y2RlNDFlODMwNWE1NGRmZmJkOGM2MDM4YjJiZGI2NGYwMA..', '', '', '15-09-2025 00:59'),
(195, 'WBxzComfTWZ', 'movjadkmswakhy@yahoo.com', '+263ldTBdjhrnYZx', 'fghUBWkq', 'movjadkmswakhy@yahoo.com', '+263gaZlaLAH', 'Zimbabwe', 'Younger Grades', 'wkXGwEJYVIz', 'EXrJrugLJuSlp', 'lsXftLuSUK', 'now', '', '', '', '', '', 'MWYxNmZlNzUwOTZmMjA0ZDM3MGE3NjkyNjUwMmRlNTcxNDBhZWQ1MTZkZjQ5ZTI1ODU1YzI1Y2EzY2EwNjA0Mg..', '', '', '15-09-2025 14:52'),
(196, 'fVAwLWWg', 'ilawupiluc60@gmail.com', '+263JCwDIuToK', 'zSYmPItjY', 'ilawupiluc60@gmail.com', '+263GrkeOBATNGssjc', 'Zimbabwe', 'Younger Grades', 'nTOJGmlnV', 'kkViXnlwdYXJrX', 'knHlPCeNa', 'now', '', '', '', '', '', 'ZGJiZmFmNWZiZDhkNTlhMzE3NWE2Y2ZlNzk1N2EzNjlkNzcwZDc5ZjdiN2NlNWZhZGNlYzJiODNiODM3YzBmMA..', '', '', '18-09-2025 00:12'),
(197, 'EXdCZGcpqfCBMYX', 'avilozag497@gmail.com', '+263AvqWIZFlrwtEAV', 'FtmYhAmFC', 'avilozag497@gmail.com', '+263FhEvjRUWghZJ', 'Zimbabwe', 'Younger Grades', 'wBnNTfUV', 'xLlwjYef', 'OjgveGBoSWAmAX', 'now', '', '', '', '', '', 'ODMxYTNiOWUxNDEyOWNmNjI4ZTdmMGMwNDdhZWE3Zjk1Yjc0YWIxNjExZTRlOTFkZDBkNmU0N2ZlYWQ5Nzc1Mw..', '', '', '18-09-2025 05:41'),
(198, 'lKUKtUnA', 'qexahub451@gmail.com', '+263GNJOzZQFI', 'CPZZWInJVOA', 'qexahub451@gmail.com', '+263GNhEQpmYAFF', 'Zimbabwe', 'Younger Grades', 'aSxjTsoil', 'fzrnwdgYQEN', 'jfySyZJrBXxky', 'now', '', '', '', '', '', 'M2JiZWFkMWJiYTRlZjJhZDNjZjFlMDBmMTJjNjg3NWVmYjcyNzFkNjA2ZGQzZjRlNzFlYTkzNGQ0Y2U4NzdjMg..', '', '', '18-09-2025 06:28'),
(199, 'fYYEBYiKVOVDy', 'uwizoxu366@gmail.com', '+263RoSZMAfnxIrTcs', 'IlaZJzZgSsdPlYo', 'uwizoxu366@gmail.com', '+263yUVrySpgTFI', 'Zimbabwe', 'Younger Grades', 'xZVVGzyQyGenbdf', 'UmwMRUGOqjsmjs', 'XVjlCBNdqqHrJD', 'now', '', '', '', '', '', 'ZDQ5ZTQ0NzMyMzMwNTI1ODhjZTBkNTgwYWE3NTFkYTc5ODgzZjk1NzZlMDVlZTJmNDY0MTM5YmViYjhjMjA1ZQ..', '', '', '18-09-2025 16:31'),
(210, 'danniejudkins4', 'm.eg.ast.o.p.lay@gmail.com', '+394807095943', 'danniejudkins4', 'm.eg.ast.o.p.lay@gmail.com', '+3874807095943', 'Sweden', '', '', '', '', 'later', '', '', '', '', '', 'MDNmMzUyZTUyZDE3NmJkNDQ0MDJkOGYzYWMzODkyMzlmZDQwODNkM2EwNGM4NDMwZjE0Mzc3NjlhOGQ1YjQwYQ..', '', '', '20-10-2025 06:44'),
(211, 'roxannaricci4', 'mega.sto.pl.a.y@gmail.com', '+255745527658', 'roxannaricci4', 'mega.sto.pl.a.y@gmail.com', '+1745527658', 'Australia', '', '', '', '', 'later', '', '', '', '', '', 'YTVkZDBiZGY4ZTVhMDMwODE5ZmNlYmNhZDcxM2JiNGJjYTUxYTRkMmQwN2QyNzRmZTU0OWMwMTJhMDRiYjNjMQ..', '', '', '20-10-2025 21:33'),
(212, 'cameronmathes', 'jenifferkelly1989@acetylcholgh.ru', '+3813196720573', 'cameronmathes', 'jenifferkelly1989@acetylcholgh.ru', '+5903196720573', 'Italy', '', '', '', '', 'later', '', '', '', '', '', 'ZWQwMjU0MWY2MDg0NTBjNjE4MzY3ZWQ0NjM0YWVhYmZkMTMyM2FiNzQxMjU0NTNkY2M0ZDVhN2ZkNTc1Y2FjYQ..', '', '', '27-10-2025 18:10'),
(213, '* * * $3,222 deposit available * * * hs=e04daf3c38441e79af359b0c45d419d6* ххх*', 'paouqua@mailbox.in.ua', '+263308874841786', 'kipo3h', 'paouqua@mailbox.in.ua', '+263308874841786', 'Zimbabwe', 'Younger Grades', '', '', '', 'now', '', '', '', '', '', 'MDljZjBkNWI2NDVjYzM1NzlhYzQwNjQwOWExMzRmNTQzY2U2ZDAxOTEzNDdhYTNlZWY5ZTMyNzBkM2EyMDU1NQ..', '', '', '02-11-2025 02:33'),
(214, '* * * $3,222 payment available * * * hs=91b95bd792e66b3690164a34314acb65* ххх*', 'paouqua@mailbox.in.ua', '+263842977417707', '52jp2n', 'paouqua@mailbox.in.ua', '+263842977417707', 'Zimbabwe', 'Younger Grades', '', '', '', '', '', ' ', '', '', '', 'N2UxNTM1MjJlNTdhNmVjNzhmZGIwZjRjZDUwNmVhYTg1ZTJlZTVjMjc2ODkxN2Y3ZWJkM2Y2ZGUyNWY0MmZkMA..', '', 'p0ehv4', '02-11-2025 02:33'),
(215, 'davidalxb3889715', 'charlesdesai1951@acetylcholgh.ru', '+226312446494', 'davidalxb3889715', 'charlesdesai1951@acetylcholgh.ru', '+676312446494', 'Switzerland', '', '', '', '', 'later', '', '', '', '', '', 'MThlY2M4OTA4MTk4ZDIwOWQ3NWI2MzUyMmE4NjY4NWRhMDQwMWZiNzZlYjg4ZDMzNzAzNjJjMTk0ZTk3OTY5YQ..', '', '', '05-11-2025 17:14'),
(216, 'mammietruebridge', 'br.a.nd.er.k.r.idk.r.a.c.h55.6.4@gmail.com', '+443508178248', 'mammietruebridge', 'br.a.nd.er.k.r.idk.r.a.c.h55.6.4@gmail.com', '+663508178248', 'Italy', '', '', '', '', 'later', '', '', '', '', '', 'MDhjYmY4ZmVmYzlmMDg1ZDMwYTFkMGNmNzNmOTFjMDU2ZGNlMGExY2MxZWRmNTM3NTJiODgyNDMyZWI1ZmViMA..', '', '', '09-11-2025 06:31'),
(217, 'domenice65', 'shirleytaylor1900@acetylcholgh.ru', '+99589944435', 'domenice65', 'shirleytaylor1900@acetylcholgh.ru', '+26789944435', 'Germany', '', '', '', '', 'later', '', '', '', '', '', 'YzhmN2Y1NDBkODViNTQyOWFjY2MxZjVkMjIzYzQzOGM4ZmU0ZDc2MGMyZDJkYmIyYjIyN2U1YjA4ZmQ0OTU1Nw..', '', '', '10-11-2025 05:27');

-- --------------------------------------------------------

--
-- Table structure for table `jwy_express_course_payments`
--

CREATE TABLE `jwy_express_course_payments` (
  `pay_id` int(11) NOT NULL,
  `id` bigint(20) UNSIGNED NOT NULL,
  `timestamp` varchar(99) NOT NULL,
  `paid_amount` varchar(20) NOT NULL,
  `paid_currency` varchar(20) NOT NULL,
  `exchange_rate` varchar(45) NOT NULL,
  `origional_amount` varchar(20) NOT NULL,
  `unique_link` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `jwy_express_course_payments`
--

INSERT INTO `jwy_express_course_payments` (`pay_id`, `id`, `timestamp`, `paid_amount`, `paid_currency`, `exchange_rate`, `origional_amount`, `unique_link`) VALUES
(6, 9, '2025-11-19 11:09:04', '16000', '2', '1', '16000.00', 'some-link'),
(7, 138, '2025-11-19 15:22:04', '1250.00', '1', '1', '1250.00', 'some-link');

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(191) NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '0001_01_01_000000_create_users_table', 1),
(2, '0001_01_01_000001_create_cache_table', 1),
(3, '0001_01_01_000002_create_jobs_table', 1),
(4, '2025_10_24_092612_create_settings_table', 1),
(5, '2025_10_28_092216_create_taxonomies_educational_systems_table', 1),
(6, '2025_10_28_092258_create_taxonomies_subjects_table', 1),
(7, '2025_10_28_092348_create_taxonomies_examination_boards_table', 1),
(8, '2025_10_28_092447_create_taxonomies_sessions_table', 1),
(9, '2025_10_29_121817_create_teachers_table', 1),
(10, '2025_10_31_064443_create_courses_table', 1),
(11, '2025_10_31_120536_create_teacher_courses_table', 1),
(12, '2025_11_02_000231_create_currencies_table', 1),
(13, '2025_11_03_000233_create_acc_transactions_table', 1),
(14, '2025_11_04_133439_create_acc_transaction_payments_table', 1),
(15, '2025_11_18_084456_create_acc_transaction_payouts_table', 1),
(16, '2025_11_24_061507_add_course_fee_and_note_fee_to_acc_transactions_table', 1);

-- --------------------------------------------------------

--
-- Table structure for table `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(191) NOT NULL,
  `token` varchar(191) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `sessions`
--

CREATE TABLE `sessions` (
  `id` varchar(191) NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` text DEFAULT NULL,
  `payload` longtext NOT NULL,
  `last_activity` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sessions`
--

INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
('qslJCf84xDk8AEsHAAd5mQpa9dUYmy5ehdTIUUjb', 2, '154.192.9.39', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', 'YTo2OntzOjY6Il90b2tlbiI7czo0MDoiS3ZrWk5KZmlvb2NMdFA4eWJ4MWdkeWU0QlF4WFZST2JsMmdidFBaSiI7czozOiJ1cmwiO2E6MDp7fXM6OToiX3ByZXZpb3VzIjthOjE6e3M6MzoidXJsIjtzOjY0OiJodHRwczovL3Z0ZWFjaC5tbW10LmFwcC9wbGF0Zm9ybS90cmFuc2FjdGlvbnMvaW5kZXg/c2Vzc2lvbl9pZD02Ijt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo1MDoibG9naW5fd2ViXzU5YmEzNmFkZGMyYjJmOTQwMTU4MGYwMTRjN2Y1OGVhNGUzMDk4OWQiO2k6MjtzOjIyOiJQSFBERUJVR0JBUl9TVEFDS19EQVRBIjthOjA6e319', 1764329830),
('jd1zsChYQe5i3n4TqNAe3ncf7VEN3tBTa3p8sgcX', 2, '197.121.21.122', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', 'YTo2OntzOjY6Il90b2tlbiI7czo0MDoidHFSOUttVWpPTTM1Q3ZienVpOUxKdFNUTVU4ckg1WDZDem9OSGF4UCI7czozOiJ1cmwiO2E6MDp7fXM6OToiX3ByZXZpb3VzIjthOjE6e3M6MzoidXJsIjtzOjY4OiJodHRwczovL3Z0ZWFjaC5tbW10LmFwcC90ZWFjaGVyL3BheW91dHMvNj9jdXJyZW5jeV9pZD0yJnRlYWNoZXJfaWQ9NSI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fXM6NTA6ImxvZ2luX3dlYl81OWJhMzZhZGRjMmIyZjk0MDE1ODBmMDE0YzdmNThlYTRlMzA5ODlkIjtpOjI7czoyMjoiUEhQREVCVUdCQVJfU1RBQ0tfREFUQSI7YTowOnt9fQ==', 1764329867);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `acc_courses`
--
ALTER TABLE `acc_courses`
  ADD PRIMARY KEY (`id`),
  ADD KEY `courses_edu_system_id_foreign` (`edu_system_id`),
  ADD KEY `courses_exam_board_id_foreign` (`exam_board_id`),
  ADD KEY `courses_subject_id_foreign` (`subject_id`);

--
-- Indexes for table `acc_currencies`
--
ALTER TABLE `acc_currencies`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `acc_settings`
--
ALTER TABLE `acc_settings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `acc_taxonomies_educational_systems`
--
ALTER TABLE `acc_taxonomies_educational_systems`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `acc_taxonomies_examination_boards`
--
ALTER TABLE `acc_taxonomies_examination_boards`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `acc_taxonomies_sessions`
--
ALTER TABLE `acc_taxonomies_sessions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `acc_taxonomies_subjects`
--
ALTER TABLE `acc_taxonomies_subjects`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `acc_teachers`
--
ALTER TABLE `acc_teachers`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `acc_teacher_courses`
--
ALTER TABLE `acc_teacher_courses`
  ADD PRIMARY KEY (`id`),
  ADD KEY `teacher_courses_teacher_id_foreign` (`teacher_id`),
  ADD KEY `teacher_courses_course_id_foreign` (`course_id`);

--
-- Indexes for table `acc_transactions`
--
ALTER TABLE `acc_transactions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `teacher_id` (`teacher_id`),
  ADD KEY `course_id` (`course_id`),
  ADD KEY `session_id` (`session_id`),
  ADD KEY `selected_currency` (`selected_currency`),
  ADD KEY `express_course_id` (`express_course_id`);

--
-- Indexes for table `acc_transaction_payments`
--
ALTER TABLE `acc_transaction_payments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `payments_transaction_id_foreign` (`transaction_id`),
  ADD KEY `payments_teacher_id_foreign` (`teacher_id`);

--
-- Indexes for table `acc_transaction_payouts`
--
ALTER TABLE `acc_transaction_payouts`
  ADD PRIMARY KEY (`id`),
  ADD KEY `acc_transaction_payouts_session_id_foreign` (`session_id`),
  ADD KEY `acc_transaction_payouts_course_id_foreign` (`course_id`),
  ADD KEY `acc_transaction_payouts_selected_currency_foreign` (`selected_currency`),
  ADD KEY `acc_transaction_payouts_transaction_id_foreign` (`transaction_id`),
  ADD KEY `acc_transaction_payouts_teacher_id_foreign` (`teacher_id`);

--
-- Indexes for table `acc_users`
--
ALTER TABLE `acc_users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- Indexes for table `cache`
--
ALTER TABLE `cache`
  ADD PRIMARY KEY (`key`);

--
-- Indexes for table `cache_locks`
--
ALTER TABLE `cache_locks`
  ADD PRIMARY KEY (`key`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `jobs`
--
ALTER TABLE `jobs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `jobs_queue_index` (`queue`);

--
-- Indexes for table `job_batches`
--
ALTER TABLE `job_batches`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `jwy_express_courses`
--
ALTER TABLE `jwy_express_courses`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `jwy_express_course_payments`
--
ALTER TABLE `jwy_express_course_payments`
  ADD PRIMARY KEY (`pay_id`),
  ADD KEY `fk_course_payment_to_course` (`id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indexes for table `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `acc_courses`
--
ALTER TABLE `acc_courses`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `acc_currencies`
--
ALTER TABLE `acc_currencies`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `acc_settings`
--
ALTER TABLE `acc_settings`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `acc_taxonomies_educational_systems`
--
ALTER TABLE `acc_taxonomies_educational_systems`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `acc_taxonomies_examination_boards`
--
ALTER TABLE `acc_taxonomies_examination_boards`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `acc_taxonomies_sessions`
--
ALTER TABLE `acc_taxonomies_sessions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `acc_taxonomies_subjects`
--
ALTER TABLE `acc_taxonomies_subjects`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `acc_teachers`
--
ALTER TABLE `acc_teachers`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `acc_teacher_courses`
--
ALTER TABLE `acc_teacher_courses`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=97;

--
-- AUTO_INCREMENT for table `acc_transactions`
--
ALTER TABLE `acc_transactions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `acc_transaction_payments`
--
ALTER TABLE `acc_transaction_payments`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `acc_transaction_payouts`
--
ALTER TABLE `acc_transaction_payouts`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `acc_users`
--
ALTER TABLE `acc_users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jwy_express_courses`
--
ALTER TABLE `jwy_express_courses`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=218;

--
-- AUTO_INCREMENT for table `jwy_express_course_payments`
--
ALTER TABLE `jwy_express_course_payments`
  MODIFY `pay_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `acc_courses`
--
ALTER TABLE `acc_courses`
  ADD CONSTRAINT `courses_edu_system_id_foreign` FOREIGN KEY (`edu_system_id`) REFERENCES `acc_taxonomies_educational_systems` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `courses_exam_board_id_foreign` FOREIGN KEY (`exam_board_id`) REFERENCES `acc_taxonomies_examination_boards` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `courses_subject_id_foreign` FOREIGN KEY (`subject_id`) REFERENCES `acc_taxonomies_subjects` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `acc_transactions`
--
ALTER TABLE `acc_transactions`
  ADD CONSTRAINT `transactions_course_id_foreign` FOREIGN KEY (`course_id`) REFERENCES `acc_courses` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `transactions_express_course_id_foreign` FOREIGN KEY (`express_course_id`) REFERENCES `jwy_express_courses` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `transactions_selected_currency_foreign` FOREIGN KEY (`selected_currency`) REFERENCES `acc_currencies` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `transactions_teacher_id_foreign` FOREIGN KEY (`teacher_id`) REFERENCES `acc_teachers` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

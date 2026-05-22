-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 09, 2026 at 12:37 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `hris_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `attendances`
--

CREATE TABLE `attendances` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `employee_id` bigint(20) UNSIGNED NOT NULL,
  `attendance_date` date NOT NULL,
  `time_in` time DEFAULT NULL,
  `time_out` time DEFAULT NULL,
  `status` varchar(255) DEFAULT NULL,
  `remarks` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `attendances`
--

INSERT INTO `attendances` (`id`, `employee_id`, `attendance_date`, `time_in`, `time_out`, `status`, `remarks`, `created_at`, `updated_at`) VALUES
(17, 8, '2026-04-14', '17:01:52', NULL, 'Late', NULL, '2026-04-14 09:01:52', '2026-04-14 09:01:52'),
(18, 8, '2026-04-17', '08:11:12', '16:11:54', 'Present', 'Overtime', '2026-04-17 00:11:12', '2026-04-17 08:11:54'),
(19, 9, '2026-04-17', '08:23:14', '16:09:47', 'Late', 'Undertime', '2026-04-17 00:23:13', '2026-04-17 08:09:48'),
(20, 7, '2026-04-17', NULL, NULL, 'Absent', 'absenot', '2026-04-17 00:55:04', '2026-04-23 04:20:12'),
(21, 10, '2026-04-17', NULL, NULL, 'Absent', NULL, '2026-04-17 00:55:04', '2026-04-17 00:55:04'),
(22, 7, '2026-04-22', NULL, NULL, 'Absent', NULL, '2026-04-23 04:21:55', '2026-04-23 04:21:55'),
(23, 8, '2026-04-22', NULL, NULL, 'Absent', NULL, '2026-04-23 04:21:55', '2026-04-23 04:21:55'),
(24, 9, '2026-04-22', NULL, NULL, 'Absent', NULL, '2026-04-23 04:21:55', '2026-04-23 04:21:55'),
(25, 10, '2026-04-22', NULL, NULL, 'Absent', NULL, '2026-04-23 04:21:55', '2026-04-23 04:21:55'),
(26, 8, '2026-04-23', '12:23:14', NULL, 'Late', NULL, '2026-04-23 04:23:14', '2026-04-23 04:23:14'),
(27, 9, '2026-04-23', '12:24:07', NULL, 'Late', NULL, '2026-04-23 04:24:07', '2026-04-23 04:24:07'),
(28, 7, '2026-04-26', NULL, NULL, 'Absent', NULL, '2026-04-27 08:01:28', '2026-04-27 08:01:28'),
(29, 8, '2026-04-26', NULL, NULL, 'Absent', NULL, '2026-04-27 08:01:28', '2026-04-27 08:01:28'),
(30, 9, '2026-04-26', NULL, NULL, 'Absent', NULL, '2026-04-27 08:01:28', '2026-04-27 08:01:28'),
(31, 10, '2026-04-26', NULL, NULL, 'Absent', NULL, '2026-04-27 08:01:28', '2026-04-27 08:01:28'),
(32, 8, '2026-04-27', '16:02:35', NULL, 'Late', NULL, '2026-04-27 08:02:35', '2026-04-27 08:02:35'),
(33, 9, '2026-04-27', '16:04:03', NULL, 'Late', NULL, '2026-04-27 08:04:03', '2026-04-27 08:04:03'),
(34, 10, '2026-04-27', '16:04:57', NULL, 'Late', NULL, '2026-04-27 08:04:57', '2026-04-27 08:04:57'),
(35, 7, '2026-04-29', NULL, NULL, 'Absent', NULL, '2026-04-29 23:37:24', '2026-04-29 23:37:24'),
(36, 8, '2026-04-29', NULL, NULL, 'Absent', NULL, '2026-04-29 23:37:24', '2026-04-29 23:37:24'),
(37, 9, '2026-04-29', NULL, NULL, 'Absent', NULL, '2026-04-29 23:37:24', '2026-04-29 23:37:24'),
(38, 10, '2026-04-29', NULL, NULL, 'Absent', NULL, '2026-04-29 23:37:24', '2026-04-29 23:37:24'),
(39, 10, '2026-04-30', '07:58:08', '23:50:26', 'Present', 'Overtime', '2026-04-29 23:58:08', '2026-04-30 15:50:26'),
(40, 9, '2026-04-30', '07:58:43', '23:50:04', 'Present', 'Overtime', '2026-04-29 23:58:43', '2026-04-30 15:50:05'),
(41, 8, '2026-04-30', NULL, NULL, 'On Leave', 'Approved leave', '2026-04-29 23:59:36', '2026-04-29 23:59:36'),
(42, 7, '2026-05-04', NULL, NULL, 'Absent', NULL, '2026-05-05 07:51:42', '2026-05-05 07:51:42'),
(43, 8, '2026-05-04', NULL, NULL, 'Absent', NULL, '2026-05-05 07:51:42', '2026-05-05 07:51:42'),
(44, 9, '2026-05-04', NULL, NULL, 'Absent', NULL, '2026-05-05 07:51:42', '2026-05-05 07:51:42'),
(45, 10, '2026-05-04', NULL, NULL, 'Absent', NULL, '2026-05-05 07:51:42', '2026-05-05 07:51:42'),
(46, 9, '2026-05-05', '09:52:00', '21:09:00', 'Late', 'Overtime', '2026-05-05 07:52:25', '2026-05-08 05:20:48'),
(47, 7, '2026-05-05', NULL, NULL, 'Absent', NULL, '2026-05-06 07:52:50', '2026-05-06 07:52:50'),
(48, 8, '2026-05-05', NULL, NULL, 'Absent', NULL, '2026-05-06 07:52:50', '2026-05-06 07:52:50'),
(49, 10, '2026-05-05', NULL, NULL, 'Absent', NULL, '2026-05-06 07:52:50', '2026-05-06 07:52:50'),
(50, 16, '2026-05-05', NULL, NULL, 'Absent', NULL, '2026-05-06 07:52:50', '2026-05-06 07:52:50'),
(51, 9, '2026-05-06', '21:28:00', '23:00:00', 'Late', 'Undertime', '2026-05-06 13:28:42', '2026-05-08 05:20:09'),
(52, 7, '2026-05-07', NULL, NULL, 'On Leave', 'Approved leave', '2026-05-06 13:29:22', '2026-05-06 13:29:22'),
(53, 7, '2026-05-06', '08:08:00', '17:22:00', 'Present', 'Overtime', '2026-05-07 12:09:48', '2026-05-08 05:21:56'),
(54, 8, '2026-05-06', NULL, NULL, 'Absent', NULL, '2026-05-07 12:09:48', '2026-05-07 12:09:48'),
(55, 10, '2026-05-06', NULL, NULL, 'Absent', NULL, '2026-05-07 12:09:48', '2026-05-07 12:09:48'),
(56, 16, '2026-05-06', NULL, NULL, 'Absent', NULL, '2026-05-07 12:09:48', '2026-05-07 12:09:48'),
(57, 19, '2026-05-06', NULL, NULL, 'Absent', NULL, '2026-05-07 12:09:48', '2026-05-07 12:09:48'),
(58, 8, '2026-05-08', '08:06:00', NULL, 'Late', NULL, '2026-05-08 11:16:08', '2026-05-08 11:26:36');

--
-- Triggers `attendances`
--
DELIMITER $$
CREATE TRIGGER `trg_attendance_no_duplicate_timein` BEFORE UPDATE ON `attendances` FOR EACH ROW BEGIN
    IF NEW.time_in IS NOT NULL THEN
        IF EXISTS (
            SELECT 1 FROM attendances
            WHERE employee_id = NEW.employee_id
            AND attendance_date = NEW.attendance_date
            AND time_in IS NOT NULL
            AND id != NEW.id
        ) THEN
            SIGNAL SQLSTATE '45000'
            SET MESSAGE_TEXT = 'Duplicate time-in: employee already timed in today.';
        END IF;
    END IF;
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `trg_attendance_set_remarks` BEFORE UPDATE ON `attendances` FOR EACH ROW BEGIN
    IF NEW.time_out IS NOT NULL AND NEW.time_in IS NOT NULL THEN
        SET NEW.remarks = CASE
            WHEN TIMESTAMPDIFF(MINUTE, NEW.time_in, NEW.time_out) < 465 THEN 'Undertime'
            WHEN TIMESTAMPDIFF(MINUTE, NEW.time_in, NEW.time_out) > 495 THEN 'Overtime'
            ELSE 'Complete'
        END;
    END IF;
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `trg_attendance_validate_timeout` BEFORE UPDATE ON `attendances` FOR EACH ROW BEGIN
    IF NEW.time_out IS NOT NULL AND NEW.time_in IS NOT NULL THEN
        IF NEW.time_out <= NEW.time_in THEN
            SIGNAL SQLSTATE '45000'
            SET MESSAGE_TEXT = 'time_out must be after time_in.';
        END IF;
    END IF;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `cache`
--

CREATE TABLE `cache` (
  `key` varchar(255) NOT NULL,
  `value` mediumtext NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `cache`
--

INSERT INTO `cache` (`key`, `value`, `expiration`) VALUES
('laravel-cache-emps@gmail.com|127.0.0.1', 'i:1;', 1777277119),
('laravel-cache-emps@gmail.com|127.0.0.1:timer', 'i:1777277119;', 1777277119),
('laravel-cache-zz@gmail.con|127.0.0.1', 'i:2;', 1778238954),
('laravel-cache-zz@gmail.con|127.0.0.1:timer', 'i:1778238954;', 1778238954);

-- --------------------------------------------------------

--
-- Table structure for table `cache_locks`
--

CREATE TABLE `cache_locks` (
  `key` varchar(255) NOT NULL,
  `owner` varchar(255) NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `departments`
--

CREATE TABLE `departments` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `manager_id` bigint(20) UNSIGNED DEFAULT NULL,
  `status` enum('active','inactive') NOT NULL DEFAULT 'active',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `departments`
--

INSERT INTO `departments` (`id`, `name`, `description`, `manager_id`, `status`, `created_at`, `updated_at`) VALUES
(1, 'Human Resources', 'Handles employee relations and HR operations', 14, 'active', '2026-04-12 00:01:22', '2026-04-30 00:59:26'),
(2, 'Information Technology', 'Manages IT infrastructure and development', 17, 'active', '2026-04-12 00:01:22', '2026-05-05 08:25:07'),
(3, 'Finance', 'Handles financial operations and accounting', 23, 'inactive', '2026-04-12 00:01:22', '2026-05-08 04:50:22'),
(4, 'Marketing', 'Manages marketing campaigns and brand strategy', NULL, 'active', '2026-04-12 00:01:22', '2026-04-12 00:01:22');

-- --------------------------------------------------------

--
-- Table structure for table `employees`
--

CREATE TABLE `employees` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `department_id` bigint(20) UNSIGNED DEFAULT NULL,
  `first_name` varchar(255) NOT NULL,
  `last_name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `phone` varchar(255) DEFAULT NULL,
  `address` text DEFAULT NULL,
  `position` varchar(255) NOT NULL,
  `hire_date` date NOT NULL,
  `employment_status` enum('active','inactive','terminated') NOT NULL DEFAULT 'active',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `employees`
--

INSERT INTO `employees` (`id`, `user_id`, `department_id`, `first_name`, `last_name`, `email`, `phone`, `address`, `position`, `hire_date`, `employment_status`, `created_at`, `updated_at`) VALUES
(5, 7, 3, 'Renjun', 'Huang', 'rj@gmail.com', NULL, 'bALAY, HA, HA', 'Hr', '2026-04-12', 'active', '2026-04-12 00:07:44', '2026-05-06 09:24:19'),
(7, 9, 1, 'Jisung', 'Park', 'jj@gmail.com', '09081234677', 'Balay', 'Head', '2025-10-15', 'active', '2026-04-12 00:11:00', '2026-05-06 09:30:46'),
(8, 10, 1, 'Chenle', 'Zhong', 'zz@gmail.com', '09012345899', 'Balay', 'Staff', '2026-03-04', 'active', '2026-04-12 00:11:56', '2026-04-12 00:11:56'),
(9, 11, 1, 'Yuta', 'Nakamoto', 'yy@gmail.com', '0912343455', 'Japan', 'Head', '2024-12-01', 'active', '2026-04-12 00:14:06', '2026-04-12 00:14:06'),
(10, 12, 1, 'Jaemin', 'Naa', 'jae@gmail.com', '09088912344', 'Balay', 'Head', '2024-12-01', 'active', '2026-04-12 00:56:16', '2026-04-30 00:47:40'),
(12, 14, 1, 'Mark', 'Lee', 'm@gmail.com', NULL, NULL, 'Manager', '2026-04-30', 'active', '2026-04-30 00:59:10', '2026-04-30 00:59:26'),
(15, 17, 2, 'Spens', 'Leano', 'ms@gmail.com', NULL, NULL, 'Manager', '2026-05-05', 'active', '2026-05-05 08:24:46', '2026-05-05 08:25:07'),
(16, 18, 2, 'Jhalila', 'Abdula', 'emj@gmail.com', '09087889788', 'Balay', 'Staff', '2026-04-08', 'active', '2026-05-05 08:27:17', '2026-05-05 08:27:17'),
(19, 21, 2, 'Junemard', 'Quiban', 'mimiyuh@gmail.com', '09077818299', 'Pag-Ibig Heights, 122, Diamond ST, Catalunan Grande, Davao City, Davao Del Sur, Talomo District, 8000', 'Staff', '2025-11-06', 'active', '2026-05-06 10:45:44', '2026-05-06 10:45:44'),
(21, 23, 3, 'Neyo', 'Lim', 'ny@gmail.com', NULL, NULL, 'Manager', '2026-05-08', 'active', '2026-05-08 04:50:22', '2026-05-08 04:50:22'),
(22, 24, 1, 'Alden', ' Butete', 'ad@gmail.com', NULL, NULL, 'Hr', '2026-05-08', 'active', '2026-05-08 10:14:59', '2026-05-08 10:14:59'),
(23, 25, NULL, 'Angel', 'Lentejas', 'ag@gmail.com', NULL, NULL, 'Manager', '2026-05-08', 'active', '2026-05-08 10:16:05', '2026-05-08 10:16:05');

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` varchar(255) NOT NULL,
  `connection` text NOT NULL,
  `queue` text NOT NULL,
  `payload` longtext NOT NULL,
  `exception` longtext NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `jobs`
--

CREATE TABLE `jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `queue` varchar(255) NOT NULL,
  `payload` longtext NOT NULL,
  `attempts` tinyint(3) UNSIGNED NOT NULL,
  `reserved_at` int(10) UNSIGNED DEFAULT NULL,
  `available_at` int(10) UNSIGNED NOT NULL,
  `created_at` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `job_batches`
--

CREATE TABLE `job_batches` (
  `id` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `total_jobs` int(11) NOT NULL,
  `pending_jobs` int(11) NOT NULL,
  `failed_jobs` int(11) NOT NULL,
  `failed_job_ids` longtext NOT NULL,
  `options` mediumtext DEFAULT NULL,
  `cancelled_at` int(11) DEFAULT NULL,
  `created_at` int(11) NOT NULL,
  `finished_at` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `leave_requests`
--

CREATE TABLE `leave_requests` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `employee_id` bigint(20) UNSIGNED NOT NULL,
  `leave_type` enum('Vacation Leave','Sick Leave','Emergency Leave','Maternity Leave','Paternity Leave','Solo Parent Leave') NOT NULL,
  `start_date` date NOT NULL,
  `end_date` date NOT NULL,
  `reason` text DEFAULT NULL,
  `status` enum('pending','approved','rejected') NOT NULL DEFAULT 'pending',
  `approved_by` bigint(20) UNSIGNED DEFAULT NULL,
  `approved_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `leave_requests`
--

INSERT INTO `leave_requests` (`id`, `employee_id`, `leave_type`, `start_date`, `end_date`, `reason`, `status`, `approved_by`, `approved_at`, `created_at`, `updated_at`) VALUES
(1, 8, 'Vacation Leave', '2026-04-24', '2026-04-24', 'I need to unwind', 'rejected', 6, '2026-04-27 08:03:39', '2026-04-23 04:22:59', '2026-04-27 08:03:39'),
(2, 9, 'Sick Leave', '2026-04-24', '2026-04-24', 'I need to see a doctor', 'rejected', 6, '2026-04-27 08:03:33', '2026-04-23 04:24:01', '2026-04-27 08:03:33'),
(3, 8, 'Vacation Leave', '2026-04-28', '2026-04-28', NULL, 'rejected', NULL, '2026-04-29 23:37:52', '2026-04-27 08:03:05', '2026-04-29 23:37:52'),
(4, 10, 'Sick Leave', '2026-04-28', '2026-04-28', NULL, 'rejected', NULL, '2026-04-29 23:37:52', '2026-04-27 08:05:31', '2026-04-29 23:37:52'),
(5, 8, 'Emergency Leave', '2026-04-30', '2026-04-30', NULL, 'approved', 6, '2026-04-29 23:59:36', '2026-04-29 23:59:22', '2026-04-29 23:59:36'),
(6, 7, 'Sick Leave', '2026-05-07', '2026-05-07', NULL, 'approved', 14, '2026-05-06 13:29:22', '2026-04-30 08:31:33', '2026-05-06 13:29:22');

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '0001_01_01_000000_create_users_table', 1),
(2, '0001_01_01_000001_create_cache_table', 1),
(3, '0001_01_01_000002_create_jobs_table', 1),
(4, '2026_04_02_064524_create_departments_table', 1),
(5, '2026_04_02_064525_create_employees_table', 1),
(6, '2026_04_04_135142_add_manager_id_to_departments_table', 1),
(7, '2026_04_04_135340_add_status_to_departments_table', 1),
(8, '2026_04_11_135943_create_attendances_table', 1),
(9, '2026_04_19_223920_create_leave_requests_table', 2),
(10, '2026_04_19_232234_update_leave_type_in_leave_requests', 3);

-- --------------------------------------------------------

--
-- Table structure for table `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `sessions`
--

CREATE TABLE `sessions` (
  `id` varchar(255) NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` text DEFAULT NULL,
  `payload` longtext NOT NULL,
  `last_activity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sessions`
--

INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
('LqhbxkKnQYvz4HBO6iT21bsMp5a1b6tn5m8bIIWd', 10, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36 Edg/147.0.0.0', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiOHFERkNid2RtOXdpT0lMNkpMNzVPUGZrSVBZNTBDaERkU3duVFJMQSI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MzM6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9pbnN0aXR1dGlvbiI7czo1OiJyb3V0ZSI7czoxNzoiaW5zdGl0dXRpb24uaW5kZXgiO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX1zOjUwOiJsb2dpbl93ZWJfNTliYTM2YWRkYzJiMmY5NDAxNTgwZjAxNGM3ZjU4ZWE0ZTMwOTg5ZCI7aToxMDt9', 1778252217),
('sIEMBtHXxCB0mMlsuMgdLbzujevhujm27dwvhCHz', 10, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36 Edg/147.0.0.0', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiUDNwSm1VZzFEVWxxb0VvdzN4VHBsR2dKaUxGODZ2cjRlUmxhc2VQNCI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6Mjc6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9sZWF2ZSI7czo1OiJyb3V0ZSI7czoxMToibGVhdmUuaW5kZXgiO31zOjUwOiJsb2dpbl93ZWJfNTliYTM2YWRkYzJiMmY5NDAxNTgwZjAxNGM3ZjU4ZWE0ZTMwOTg5ZCI7aToxMDt9', 1778239872),
('ztq2MI3MZ3CCV05DYwky7fq5Xes65hglJsBu7B1k', 6, '127.0.0.1', 'Mozilla/5.0 (iPhone; CPU iPhone OS 18_5 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/18.5 Mobile/15E148 Safari/604.1', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiM0wxdDdwZHRpT1JhVWtnYW5jd1Y3bnRkNnVzdG9Qd0N0MzFzdUs4UCI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MzM6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9pbnN0aXR1dGlvbiI7czo1OiJyb3V0ZSI7czoxNzoiaW5zdGl0dXRpb24uaW5kZXgiO31zOjUwOiJsb2dpbl93ZWJfNTliYTM2YWRkYzJiMmY5NDAxNTgwZjAxNGM3ZjU4ZWE0ZTMwOTg5ZCI7aTo2O30=', 1778239859);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('admin','hr','manager','employee') NOT NULL DEFAULT 'employee',
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `role`, `remember_token`, `created_at`, `updated_at`) VALUES
(5, 'Admin', 'admin@example.com', NULL, '$2y$12$vnb/So6aB/PNW6pt5gGfdOD3JA9vBnXZelzLyyb/ExrFeApO//6ra', 'employee', NULL, '2026-04-12 00:03:37', '2026-04-12 00:03:37'),
(6, 'Admin User', 'admin@gmail.com', NULL, '$2y$12$//kI7TLSaCbnjfdjZZ2W7uowDcsLbSpOymDiFGE9DfrkOJe09.f7G', 'admin', 'pepiuEJtTWgzkLZq29joVld477lxjLT7xauplnTlFxtS7vb2dZLEQCKcpb3H', '2026-04-12 00:05:45', '2026-04-12 00:06:19'),
(7, 'Renjun Huang', 'rj@gmail.com', NULL, '$2y$12$AaOZ1qa6oqWvys.jC3mOwOzaiO0ukm9qc2uDZ/GneeOBrnh.VCWRS', 'hr', NULL, '2026-04-12 00:07:44', '2026-04-12 00:07:44'),
(9, 'Jisung Park', 'jj@gmail.com', NULL, '$2y$12$gqU75kfGeNaz3dmo0XD6cu0KIU7FMGb9D2P3PPUjmFeFS6RJuda1a', 'employee', NULL, '2026-04-12 00:11:00', '2026-04-12 00:11:00'),
(10, 'Chenle Zhong', 'zz@gmail.com', NULL, '$2y$12$Zuxk86zLVnJiDeXM7.liBuJKOQkqYdgWBNxd4LDtK8XGx77vLyjGy', 'employee', NULL, '2026-04-12 00:11:56', '2026-04-12 00:11:56'),
(11, 'Yuta Nakamoto', 'yy@gmail.com', NULL, '$2y$12$sJbNSwVIL.o1o1saBiBmaeP4e6O8RxbHhD.qMSkMk1puCiNH4aPQa', 'employee', NULL, '2026-04-12 00:14:06', '2026-04-12 00:15:16'),
(12, 'Jaemin Na', 'jae@gmail.com', NULL, '$2y$12$Jaif9hQzjeRjd2ctZgqD/O5ycgn2zd6h0vMW37LP3p3mrByBu1UPq', 'employee', NULL, '2026-04-12 00:56:16', '2026-04-12 00:56:16'),
(14, 'Mark Lee', 'm@gmail.com', NULL, '$2y$12$btpIZMqzZBQuAwPbNlGbMu4KzbIKF31u99q7nuY6td3HOSY45IGH6', 'manager', NULL, '2026-04-30 00:59:10', '2026-04-30 00:59:10'),
(17, 'Spens Leano', 'ms@gmail.com', NULL, '$2y$12$yb.uZmK.938JwRLX/YmmZ.OL0wWHSHTHIGIOp4P2b8GdcY3Lnhqw6', 'manager', NULL, '2026-05-05 08:24:45', '2026-05-05 08:24:45'),
(18, 'Jhalila Abdula', 'emj@gmail.com', NULL, '$2y$12$s3KHiaQPP7N87EVE.ZxDDOyxYnTobQFpQGjosHT/WTICQLwfruob2', 'employee', NULL, '2026-05-05 08:27:17', '2026-05-05 08:27:17'),
(21, 'Junemard Quiban', 'mimiyuh@gmail.com', NULL, '$2y$12$x4hy6mw.J/mm914wQ6vTe.BggY.n6Jh.oEj8CZNtCZuR2Q5iD2VeK', 'employee', NULL, '2026-05-06 10:45:44', '2026-05-06 10:45:44'),
(23, 'Neyo Lim', 'ny@gmail.com', NULL, '$2y$12$XGv0lKTrvl3JXPsEBxJ6M.bK34LsQ1UXYtCclhs52E26w1Pqdj.By', 'manager', NULL, '2026-05-08 04:50:22', '2026-05-08 04:50:22'),
(24, 'Alden  Butete', 'ad@gmail.com', NULL, '$2y$12$z4VGrcBimdz.EM/wobDyYOHjCXJKfwDn2EIBywoYEADsf0YmwVYLm', 'hr', NULL, '2026-05-08 10:14:59', '2026-05-08 10:14:59'),
(25, 'Angel Lentejas', 'ag@gmail.com', NULL, '$2y$12$pC2TzsYN0Juhgn0CQ6TQNOOPQb6k6bgWtTAwya.dpZXF0Ya2sXsZy', 'manager', NULL, '2026-05-08 10:16:05', '2026-05-08 10:16:05');

-- --------------------------------------------------------

--
-- Stand-in structure for view `vw_department_attendance_today`
-- (See below for the actual view)
--
CREATE TABLE `vw_department_attendance_today` (
`department_id` bigint(20) unsigned
,`department_name` varchar(255)
,`employee_name` varchar(511)
,`position` varchar(255)
,`attendance_date` date
,`time_in` time
,`time_out` time
,`status` varchar(255)
,`remarks` text
,`hours_worked` decimal(24,2)
);

-- --------------------------------------------------------

--
-- Stand-in structure for view `vw_employee_attendance_summary`
-- (See below for the actual view)
--
CREATE TABLE `vw_employee_attendance_summary` (
`employee_id` bigint(20) unsigned
,`full_name` varchar(511)
,`position` varchar(255)
,`department` varchar(255)
,`total_records` bigint(21)
,`present_count` decimal(23,0)
,`late_count` decimal(23,0)
,`absent_count` decimal(23,0)
,`on_leave_count` decimal(23,0)
,`overtime_count` decimal(23,0)
,`undertime_count` decimal(23,0)
,`avg_hours_worked` decimal(24,2)
);

-- --------------------------------------------------------

--
-- Stand-in structure for view `vw_monthly_attendance_summary`
-- (See below for the actual view)
--
CREATE TABLE `vw_monthly_attendance_summary` (
`employee_id` bigint(20) unsigned
,`full_name` varchar(511)
,`department` varchar(255)
,`year` int(4)
,`month` int(2)
,`present_days` decimal(23,0)
,`late_days` decimal(23,0)
,`absent_days` decimal(23,0)
,`on_leave_days` decimal(23,0)
,`overtime_days` decimal(23,0)
,`undertime_days` decimal(23,0)
,`total_hours_worked` decimal(46,2)
);

-- --------------------------------------------------------

--
-- Stand-in structure for view `vw_pending_leaves`
-- (See below for the actual view)
--
CREATE TABLE `vw_pending_leaves` (
`leave_id` bigint(20) unsigned
,`employee_name` varchar(511)
,`position` varchar(255)
,`department` varchar(255)
,`leave_type` enum('Vacation Leave','Sick Leave','Emergency Leave','Maternity Leave','Paternity Leave','Solo Parent Leave')
,`start_date` date
,`end_date` date
,`total_days` int(8)
,`reason` text
,`status` enum('pending','approved','rejected')
,`submitted_at` timestamp
);

-- --------------------------------------------------------

--
-- Structure for view `vw_department_attendance_today`
--
DROP TABLE IF EXISTS `vw_department_attendance_today`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `vw_department_attendance_today`  AS SELECT `d`.`id` AS `department_id`, `d`.`name` AS `department_name`, concat(`e`.`first_name`,' ',`e`.`last_name`) AS `employee_name`, `e`.`position` AS `position`, `a`.`attendance_date` AS `attendance_date`, `a`.`time_in` AS `time_in`, `a`.`time_out` AS `time_out`, `a`.`status` AS `status`, `a`.`remarks` AS `remarks`, CASE WHEN `a`.`time_in` is not null AND `a`.`time_out` is not null THEN round(timestampdiff(SECOND,concat(`a`.`attendance_date`,' ',`a`.`time_in`),concat(`a`.`attendance_date`,' ',`a`.`time_out`)) / 3600.0,2) ELSE NULL END AS `hours_worked` FROM ((`departments` `d` join `employees` `e` on(`e`.`department_id` = `d`.`id`)) left join `attendances` `a` on(`a`.`employee_id` = `e`.`id` and `a`.`attendance_date` = curdate())) ;

-- --------------------------------------------------------

--
-- Structure for view `vw_employee_attendance_summary`
--
DROP TABLE IF EXISTS `vw_employee_attendance_summary`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `vw_employee_attendance_summary`  AS SELECT `e`.`id` AS `employee_id`, concat(`e`.`first_name`,' ',`e`.`last_name`) AS `full_name`, `e`.`position` AS `position`, `d`.`name` AS `department`, count(`a`.`id`) AS `total_records`, sum(`a`.`status` = 'Present') AS `present_count`, sum(`a`.`status` = 'Late') AS `late_count`, sum(`a`.`status` = 'Absent') AS `absent_count`, sum(`a`.`status` = 'On Leave') AS `on_leave_count`, sum(`a`.`remarks` = 'Overtime') AS `overtime_count`, sum(`a`.`remarks` = 'Undertime') AS `undertime_count`, round(avg(case when `a`.`time_in` is not null and `a`.`time_out` is not null then timestampdiff(SECOND,concat(`a`.`attendance_date`,' ',`a`.`time_in`),concat(`a`.`attendance_date`,' ',`a`.`time_out`)) / 3600.0 else NULL end),2) AS `avg_hours_worked` FROM ((`employees` `e` left join `departments` `d` on(`d`.`id` = `e`.`department_id`)) left join `attendances` `a` on(`a`.`employee_id` = `e`.`id`)) GROUP BY `e`.`id`, `e`.`first_name`, `e`.`last_name`, `e`.`position`, `d`.`name` ;

-- --------------------------------------------------------

--
-- Structure for view `vw_monthly_attendance_summary`
--
DROP TABLE IF EXISTS `vw_monthly_attendance_summary`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `vw_monthly_attendance_summary`  AS SELECT `e`.`id` AS `employee_id`, concat(`e`.`first_name`,' ',`e`.`last_name`) AS `full_name`, `d`.`name` AS `department`, year(`a`.`attendance_date`) AS `year`, month(`a`.`attendance_date`) AS `month`, sum(`a`.`status` = 'Present') AS `present_days`, sum(`a`.`status` = 'Late') AS `late_days`, sum(`a`.`status` = 'Absent') AS `absent_days`, sum(`a`.`status` = 'On Leave') AS `on_leave_days`, sum(`a`.`remarks` = 'Overtime') AS `overtime_days`, sum(`a`.`remarks` = 'Undertime') AS `undertime_days`, round(sum(case when `a`.`time_in` is not null and `a`.`time_out` is not null then timestampdiff(SECOND,concat(`a`.`attendance_date`,' ',`a`.`time_in`),concat(`a`.`attendance_date`,' ',`a`.`time_out`)) / 3600.0 else 0 end),2) AS `total_hours_worked` FROM ((`attendances` `a` join `employees` `e` on(`e`.`id` = `a`.`employee_id`)) left join `departments` `d` on(`d`.`id` = `e`.`department_id`)) GROUP BY `e`.`id`, `e`.`first_name`, `e`.`last_name`, `d`.`name`, year(`a`.`attendance_date`), month(`a`.`attendance_date`) ;

-- --------------------------------------------------------

--
-- Structure for view `vw_pending_leaves`
--
DROP TABLE IF EXISTS `vw_pending_leaves`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `vw_pending_leaves`  AS SELECT `lr`.`id` AS `leave_id`, concat(`e`.`first_name`,' ',`e`.`last_name`) AS `employee_name`, `e`.`position` AS `position`, `d`.`name` AS `department`, `lr`.`leave_type` AS `leave_type`, `lr`.`start_date` AS `start_date`, `lr`.`end_date` AS `end_date`, to_days(`lr`.`end_date`) - to_days(`lr`.`start_date`) + 1 AS `total_days`, `lr`.`reason` AS `reason`, `lr`.`status` AS `status`, `lr`.`created_at` AS `submitted_at` FROM ((`leave_requests` `lr` join `employees` `e` on(`e`.`id` = `lr`.`employee_id`)) left join `departments` `d` on(`d`.`id` = `e`.`department_id`)) WHERE `lr`.`status` = 'pending' ORDER BY `lr`.`start_date` ASC ;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `attendances`
--
ALTER TABLE `attendances`
  ADD PRIMARY KEY (`id`),
  ADD KEY `attendances_employee_id_foreign` (`employee_id`);

--
-- Indexes for table `cache`
--
ALTER TABLE `cache`
  ADD PRIMARY KEY (`key`),
  ADD KEY `cache_expiration_index` (`expiration`);

--
-- Indexes for table `cache_locks`
--
ALTER TABLE `cache_locks`
  ADD PRIMARY KEY (`key`),
  ADD KEY `cache_locks_expiration_index` (`expiration`);

--
-- Indexes for table `departments`
--
ALTER TABLE `departments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `departments_manager_id_foreign` (`manager_id`);

--
-- Indexes for table `employees`
--
ALTER TABLE `employees`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `employees_email_unique` (`email`),
  ADD KEY `employees_user_id_foreign` (`user_id`),
  ADD KEY `employees_department_id_foreign` (`department_id`);

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
-- Indexes for table `leave_requests`
--
ALTER TABLE `leave_requests`
  ADD PRIMARY KEY (`id`),
  ADD KEY `leave_requests_employee_id_foreign` (`employee_id`),
  ADD KEY `leave_requests_approved_by_foreign` (`approved_by`);

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
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `attendances`
--
ALTER TABLE `attendances`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=59;

--
-- AUTO_INCREMENT for table `departments`
--
ALTER TABLE `departments`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `employees`
--
ALTER TABLE `employees`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

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
-- AUTO_INCREMENT for table `leave_requests`
--
ALTER TABLE `leave_requests`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `attendances`
--
ALTER TABLE `attendances`
  ADD CONSTRAINT `attendances_employee_id_foreign` FOREIGN KEY (`employee_id`) REFERENCES `employees` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `departments`
--
ALTER TABLE `departments`
  ADD CONSTRAINT `departments_manager_id_foreign` FOREIGN KEY (`manager_id`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `employees`
--
ALTER TABLE `employees`
  ADD CONSTRAINT `employees_department_id_foreign` FOREIGN KEY (`department_id`) REFERENCES `departments` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `employees_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `leave_requests`
--
ALTER TABLE `leave_requests`
  ADD CONSTRAINT `leave_requests_approved_by_foreign` FOREIGN KEY (`approved_by`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `leave_requests_employee_id_foreign` FOREIGN KEY (`employee_id`) REFERENCES `employees` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

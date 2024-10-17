-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 17, 2024 at 02:26 PM
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
-- Database: `codefund`
--

-- --------------------------------------------------------

--
-- Table structure for table `apis`
--

CREATE TABLE `apis` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `user_id` int(11) NOT NULL,
  `key` varchar(255) NOT NULL,
  `api_quota` varchar(255) NOT NULL DEFAULT 'limited',
  `total_requests` int(11) DEFAULT NULL,
  `extra_secure` tinyint(4) NOT NULL DEFAULT 0,
  `security_header` varchar(255) DEFAULT NULL,
  `request_hit` int(11) DEFAULT 0,
  `status` tinyint(4) NOT NULL DEFAULT 1,
  `check_balance` tinyint(4) DEFAULT 0,
  `get_transactions` tinyint(4) NOT NULL DEFAULT 0,
  `find_user` tinyint(4) NOT NULL DEFAULT 0,
  `send_funds` tinyint(4) NOT NULL DEFAULT 0,
  `my_profile` tinyint(4) NOT NULL DEFAULT 0,
  `find_transaction` tinyint(4) NOT NULL DEFAULT 0,
  `generate_payment_link` tinyint(4) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `apis`
--

INSERT INTO `apis` (`id`, `name`, `user_id`, `key`, `api_quota`, `total_requests`, `extra_secure`, `security_header`, `request_hit`, `status`, `check_balance`, `get_transactions`, `find_user`, `send_funds`, `my_profile`, `find_transaction`, `generate_payment_link`, `created_at`, `updated_at`) VALUES
(1, 'UAT', 2, '55kSzrACsVysAKRFRTsy1iXvz9MtC8x0MjZ4gcKS', 'limited', 70, 0, NULL, 28, 1, 1, 1, 1, 0, 1, 1, 1, '2024-10-10 12:16:51', '2024-10-17 08:14:09'),
(2, 'Ecommerce', 2, 'BFBfCQWBPtp4k2VLLeYpHuxA1uX1CasA6I4PzKpe', 'unlimited', NULL, 1, 'QVQ9TO0L22W52KG', 0, 1, 0, 0, 0, 1, 0, 0, 1, '2024-10-16 10:24:17', '2024-10-16 11:30:13'),
(3, 'UAT', 6, 'lCWR9GnJDbcVVVnxkrlvncS5TQrPRLUft0h7IFcc', 'limited', 150, 0, NULL, 0, 1, 1, 1, 1, 1, 1, 1, 1, '2024-10-17 07:29:14', '2024-10-17 07:29:28');

-- --------------------------------------------------------

--
-- Table structure for table `deposits`
--

CREATE TABLE `deposits` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `ref_id` varchar(255) NOT NULL,
  `amount` double(40,2) NOT NULL,
  `open_secret_code` varchar(255) DEFAULT NULL,
  `secret_code` varchar(255) NOT NULL,
  `is_used` tinyint(4) NOT NULL DEFAULT 0,
  `used_by` bigint(20) UNSIGNED DEFAULT NULL,
  `expiry` datetime DEFAULT NULL,
  `added_by` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `deposits`
--

INSERT INTO `deposits` (`id`, `ref_id`, `amount`, `open_secret_code`, `secret_code`, `is_used`, `used_by`, `expiry`, `added_by`, `created_at`, `updated_at`) VALUES
(1, 'WOKZLBL6MANGY1Z', 5000.00, '936797', '1c868bad471a41ab9837d8eccdb8f88b', 1, 2, NULL, 1, '2024-10-17 06:27:31', '2024-10-17 06:27:58');

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
-- Table structure for table `friends`
--

CREATE TABLE `friends` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `account_number` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `mobile` varchar(255) NOT NULL,
  `friend_user_id` bigint(20) UNSIGNED NOT NULL,
  `status` tinyint(4) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `friends`
--

INSERT INTO `friends` (`id`, `user_id`, `account_number`, `name`, `email`, `mobile`, `friend_user_id`, `status`, `created_at`, `updated_at`) VALUES
(1, 6, '46565441364521', 'Vinay', 'vinay@gmail.com', '7206881088', 2, 1, '2024-10-17 07:02:28', '2024-10-17 07:15:37'),
(2, 6, '81919111443765', 'Ritu', 'ritu@gmail.com', '8881234000', 7, 1, '2024-10-17 07:22:29', '2024-10-17 07:22:29'),
(3, 7, '46565441364521', 'Vinay', 'vinay@gmail.com', '7206881088', 2, 1, '2024-10-17 07:23:04', '2024-10-17 07:27:14'),
(4, 7, '62341085522722', 'Sumit', 'sumit@gmail.com', '8878102020', 6, 1, '2024-10-17 07:23:55', '2024-10-17 07:23:55'),
(5, 2, '62341085522722', 'Sumit', 'sumit@gmail.com', '8878102020', 6, 1, '2024-10-17 07:24:22', '2024-10-17 07:24:22'),
(6, 2, '81919111443765', 'Ritu', 'ritu@gmail.com', '8881234000', 7, 1, '2024-10-17 07:24:43', '2024-10-17 07:24:43');

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
(1, '2014_10_12_000000_create_users_table', 1),
(2, '2014_10_12_100000_create_password_reset_tokens_table', 1),
(3, '2019_08_19_000000_create_failed_jobs_table', 1),
(4, '2019_12_14_000001_create_personal_access_tokens_table', 1),
(5, '2024_09_25_104352_create_apis_table', 2),
(6, '2024_09_25_121141_create_wallet_accounts_table', 3),
(9, '2024_09_25_133355_create_transactions_table', 4),
(10, '2024_09_25_133611_create_deposits_table', 5),
(11, '2024_10_01_113800_create_payment_links_table', 6),
(12, '2024_10_17_122112_create_friends_table', 7);

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
-- Table structure for table `payment_links`
--

CREATE TABLE `payment_links` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `link` varchar(255) NOT NULL,
  `wallet_account_id` bigint(20) UNSIGNED NOT NULL,
  `for_user_id` bigint(20) UNSIGNED NOT NULL,
  `account_number` varchar(255) NOT NULL,
  `amount` double(40,2) NOT NULL,
  `generatedBy` bigint(20) UNSIGNED NOT NULL,
  `status` tinyint(4) NOT NULL DEFAULT 0,
  `payment_on` datetime DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `payment_links`
--

INSERT INTO `payment_links` (`id`, `link`, `wallet_account_id`, `for_user_id`, `account_number`, `amount`, `generatedBy`, `status`, `payment_on`, `created_at`, `updated_at`) VALUES
(1, 'OUWkHhLBiUElLjgC1aiYhV7y6FVrmSkaMib', 1, 2, '46565441364521', 1500.00, 7, 1, '2024-10-17 12:01:30', '2024-10-17 06:28:55', '2024-10-17 06:31:30'),
(2, 'aZVwJcEakSSl00EywkyGBIY0n2XTWlE2hm9', 1, 2, '46565441364521', 1999.00, 6, 1, '2024-10-17 12:05:14', '2024-10-17 06:33:45', '2024-10-17 06:35:14');

-- --------------------------------------------------------

--
-- Table structure for table `personal_access_tokens`
--

CREATE TABLE `personal_access_tokens` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `tokenable_type` varchar(255) NOT NULL,
  `tokenable_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `token` varchar(64) NOT NULL,
  `abilities` text DEFAULT NULL,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `transactions`
--

CREATE TABLE `transactions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `transaction_id` varchar(255) DEFAULT NULL,
  `amount` double(40,2) NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `type` varchar(255) NOT NULL,
  `closing_balance` double(40,2) NOT NULL,
  `remarks` text NOT NULL,
  `narration` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `from_where` varchar(255) DEFAULT NULL,
  `from_where_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `transactions`
--

INSERT INTO `transactions` (`id`, `transaction_id`, `amount`, `user_id`, `type`, `closing_balance`, `remarks`, `narration`, `created_at`, `updated_at`, `from_where`, `from_where_id`) VALUES
(1, '3197599544', 5000.00, 2, 'Credit', 5000.00, 'Added from deposit code WOKZLBL6MANGY1Z', NULL, '2024-10-17 06:27:58', '2024-10-17 06:27:58', 'Deposit', 1),
(2, '5677000650', 1500.00, 2, 'Debit', 3500.00, 'Funds transfered successfully to 81919111443765(via Payment Link)', NULL, '2024-10-17 06:31:30', '2024-10-17 06:31:30', 'Payment Link', 7),
(3, '5677000650', 1500.00, 7, 'Credit', 1500.00, 'Funds received by 46565441364521(via Payment Link)', NULL, '2024-10-17 06:31:30', '2024-10-17 06:31:30', 'Payment Link', 2),
(4, '5802065838', 1999.00, 2, 'Debit', 1501.00, 'Funds transfered successfully to 62341085522722(via Payment Link)', NULL, '2024-10-17 06:35:14', '2024-10-17 06:35:14', 'Payment Link', 6),
(5, '5802065838', 1999.00, 6, 'Credit', 1999.00, 'Funds received by 46565441364521(via Payment Link)', NULL, '2024-10-17 06:35:14', '2024-10-17 06:35:14', 'Payment Link', 2),
(6, '6906029110', 499.00, 6, 'Debit', 1500.00, 'Funds transfered successfully to 46565441364521', NULL, '2024-10-17 07:17:24', '2024-10-17 07:17:24', 'Fund Transfer', 2),
(7, '6906029110', 499.00, 2, 'Credit', 2000.00, 'Funds received by 62341085522722', NULL, '2024-10-17 07:17:24', '2024-10-17 07:17:24', 'Fund Transfer', 6),
(8, '4319608017', 750.00, 7, 'Debit', 750.00, 'Funds transfered successfully to 62341085522722', NULL, '2024-10-17 07:27:24', '2024-10-17 07:27:24', 'Fund Transfer', 6),
(9, '4319608017', 750.00, 6, 'Credit', 2250.00, 'Funds received by 81919111443765', NULL, '2024-10-17 07:27:24', '2024-10-17 07:27:24', 'Fund Transfer', 7),
(10, '2799362863', 350.00, 2, 'Debit', 1650.00, 'Funds transfered successfully to 81919111443765', NULL, '2024-10-17 12:14:47', '2024-10-17 12:14:47', 'Fund Transfer', 7),
(11, '2799362863', 350.00, 7, 'Credit', 1100.00, 'Funds received by 46565441364521', NULL, '2024-10-17 12:14:47', '2024-10-17 12:14:47', 'Fund Transfer', 2);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` tinyint(4) NOT NULL DEFAULT 1,
  `unique_id` varchar(255) NOT NULL,
  `wallet_balance` double(40,2) NOT NULL DEFAULT 0.00,
  `keys_generated` int(11) NOT NULL DEFAULT 0,
  `pin_code` varchar(255) DEFAULT NULL,
  `plan_id` bigint(20) UNSIGNED NOT NULL DEFAULT 1,
  `identification_type` varchar(255) DEFAULT NULL,
  `identification_number` varchar(255) DEFAULT NULL,
  `status` tinyint(4) NOT NULL DEFAULT 0,
  `auth_key` varchar(255) DEFAULT NULL,
  `auth_key_expiry` datetime DEFAULT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `password`, `role`, `unique_id`, `wallet_balance`, `keys_generated`, `pin_code`, `plan_id`, `identification_type`, `identification_number`, `status`, `auth_key`, `auth_key_expiry`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'Admin', 'admin@gmail.com', '$2y$12$JbGkQzNUl75of/dv731ZzOWnZeGBjkbVjLf0l0/QojMy7WNjy6Cb2', 2, '66fa4dcc9176b', 0.00, 0, '132001', 1, 'passport', '110024ACX', 1, NULL, NULL, NULL, '2024-09-30 07:05:48', '2024-09-30 07:05:48'),
(2, 'Vinay', 'vinay@gmail.com', '$2y$12$4jAABfX5Af2Lz1DDn3.TJOGR4aHqFYBVxol8mtPe1UnKEU7nzii2O', 1, '66fa4f5896d1b', 1650.00, 2, '132001', 1, 'pan_card', 'AC2584XS', 1, 'g01RvCsK9liYIdE61X2J', '2024-10-17 13:50:16', NULL, '2024-09-30 07:12:24', '2024-10-17 12:14:47'),
(6, 'Sumit', 'sumit@gmail.com', '$2y$12$61QvlyJkZehLKeN1fKJYrue3bAkkiz./9N9Y6.hOhUXM1nI3i4vQO', 1, '6707c62a8df17', 2250.00, 1, '132001', 1, 'passport', 'D21525AC43', 1, NULL, NULL, NULL, '2024-10-10 12:18:50', '2024-10-17 07:29:14'),
(7, 'Ritu', 'ritu@gmail.com', '$2y$12$/MBsdOB.344IfaWHOXiRLOG7r7PWEWRjCiZ3PANF4QKLFaL5tbz2G', 1, '670fba68ae3b4', 1100.00, 0, '132001', 1, 'pan_card', 'ABCO857454', 1, NULL, NULL, NULL, '2024-10-16 13:06:48', '2024-10-17 12:14:47');

-- --------------------------------------------------------

--
-- Table structure for table `wallet_accounts`
--

CREATE TABLE `wallet_accounts` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `account_number` varchar(255) NOT NULL,
  `status` tinyint(4) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `wallet_accounts`
--

INSERT INTO `wallet_accounts` (`id`, `user_id`, `account_number`, `status`, `created_at`, `updated_at`) VALUES
(1, 2, '46565441364521', 1, '2024-10-10 12:06:15', '2024-10-10 12:06:15'),
(2, 6, '62341085522722', 1, '2024-10-10 12:19:41', '2024-10-10 12:19:41'),
(3, 7, '81919111443765', 1, '2024-10-16 13:07:31', '2024-10-16 13:07:31');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `apis`
--
ALTER TABLE `apis`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `apis_key_unique` (`key`);

--
-- Indexes for table `deposits`
--
ALTER TABLE `deposits`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `friends`
--
ALTER TABLE `friends`
  ADD PRIMARY KEY (`id`);

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
-- Indexes for table `payment_links`
--
ALTER TABLE `payment_links`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`);

--
-- Indexes for table `transactions`
--
ALTER TABLE `transactions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`),
  ADD UNIQUE KEY `users_unique_id_unique` (`unique_id`);

--
-- Indexes for table `wallet_accounts`
--
ALTER TABLE `wallet_accounts`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `apis`
--
ALTER TABLE `apis`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `deposits`
--
ALTER TABLE `deposits`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `friends`
--
ALTER TABLE `friends`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `payment_links`
--
ALTER TABLE `payment_links`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `transactions`
--
ALTER TABLE `transactions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `wallet_accounts`
--
ALTER TABLE `wallet_accounts`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

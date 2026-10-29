-- phpMyAdmin SQL Dump
-- version 5.2.3
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Oct 09, 2026 at 01:13 AM
-- Server version: 8.0.30
-- PHP Version: 8.5.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `pbl_ti_2025_a_asfarazuria`
--

-- --------------------------------------------------------

--
-- Table structure for table `accounts`
--

CREATE TABLE `accounts` (
  `id` varchar(36) NOT NULL,
  `name` varchar(128) NOT NULL,
  `email` varchar(128) NOT NULL,
  `password` text NOT NULL,
  `account_type_id` varchar(36) NOT NULL,
  `status` varchar(128) NOT NULL,
  `identification_number` varchar(128) NOT NULL,
  `identification_type` enum('nim','nip') NOT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  `deleted_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `accounts`
--

INSERT INTO `accounts` (`id`, `name`, `email`, `password`, `account_type_id`, `status`, `identification_number`, `identification_type`, `created_at`, `updated_at`, `deleted_at`) VALUES
('3bc27cc8-9c2f-4124-af74-8793171b907c', 'Administrator', 'admin@gmail.com', '$2y$12$scVePtLvaQoAvqsoknZ5w.8.T6PsPgCKfzUbUSu4s3jvWct4AN8T.', '0a9221d8-70ae-483c-b4ec-a43700028341', 'aktif', '6767676767', 'nim', '2026-10-08 15:30:48', '2026-10-09 08:00:20', NULL),
('488492e8-2b35-4ee9-af01-76d50ecf77c0', 'Dosen', 'dosen@gmail.com', '$2y$12$0fZVdFlPMV7QxJXajSY5y.fouLhg6YBM6/182FI3RaimFlfxnZ2nO', 'eaa9750f-9739-4504-8876-0855176e6a48', 'aktif', '2525252525', 'nip', '2026-10-08 23:11:19', NULL, NULL),
('c744fa09-b73d-43dc-a00f-db23eb682f35', 'test123', 'test123@gmail.com', '$2y$12$X0pbbZjkTIQLz8YPYekJIOXVw/g2EFE1Q2jkP6AqFURW4AUfdNlty', '5fc538f6-3ae9-4bbd-b362-456653de91a4', 'aktif', '2507411004', 'nim', '2026-10-08 16:21:07', '2026-10-08 23:14:29', NULL),
('e93e5a2b-e58d-4a16-8695-d0a9af5f6b11', 'Mahasiswa', 'mahasiswa@gmail.com', '$2y$12$JU6TXJlGzu74Yfa9mB6.fuFUPX2rad1KHt6Ejdcx7mEousenic70G', 'f09447ca-5074-4134-8d7c-f7999f8b007c', 'aktif', '2222222222', 'nim', '2026-10-08 23:11:43', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `account_type`
--

CREATE TABLE `account_type` (
  `id` varchar(36) NOT NULL,
  `name` varchar(128) NOT NULL,
  `description` text NOT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  `deleted_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `account_type`
--

INSERT INTO `account_type` (`id`, `name`, `description`, `created_at`, `updated_at`, `deleted_at`) VALUES
('0a9221d8-70ae-483c-b4ec-a43700028341', 'admin', 'administrator', '2026-10-08 14:22:06', '2026-10-08 23:10:31', NULL),
('5fc538f6-3ae9-4bbd-b362-456653de91a4', 'gokil123', 'gokil', '2026-10-08 15:35:13', '2026-10-08 19:07:09', NULL),
('eaa9750f-9739-4504-8876-0855176e6a48', 'dosen', 'dosen', '2026-10-08 23:10:48', NULL, NULL),
('f09447ca-5074-4134-8d7c-f7999f8b007c', 'mahasiswa', 'mahasiswa', '2026-10-08 23:10:56', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `actions`
--

CREATE TABLE `actions` (
  `id` varchar(36) NOT NULL,
  `name` varchar(128) NOT NULL,
  `description` text NOT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  `deleted_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `actions`
--

INSERT INTO `actions` (`id`, `name`, `description`, `created_at`, `updated_at`, `deleted_at`) VALUES
('15819969-c9c1-4ebd-85de-22f133c761e6', 'Read Accounts', 'Melihat seluruh daftar akun', '2026-10-08 19:06:35', '2026-10-08 20:37:22', '2026-10-08 20:37:22'),
('1e1edd29-80d8-49e2-b845-562e9a9453f6', 'atmin', 'atmin', '2026-10-08 16:52:22', NULL, NULL),
('23e08966-6a66-4aaa-b727-06dee7c55e27', 'Read Account Type', 'Melihat seluruh daftar tipe akun', '2026-10-08 19:06:41', '2026-10-08 20:37:18', '2026-10-08 20:37:18'),
('2fecaedd-2890-4224-8122-ae8ab7c12f5f', 'Read Accounts', 'Melihat seluruh daftar akun', '2026-10-08 19:06:29', '2026-10-08 20:37:25', '2026-10-08 20:37:25'),
('55968861-0069-411c-9f39-4012519b63f3', 'Delete', 'Menghapus data (soft delete).', '2026-10-08 23:12:11', NULL, NULL),
('7d92a0cc-66be-4095-8104-982d12d82364', 'Read Account Type', 'Melihat seluruh daftar tipe akun', '2026-10-08 19:06:40', '2026-10-08 20:37:19', '2026-10-08 20:37:19'),
('8e467ac7-66db-44e4-a3ca-06a2076098fc', 'Update', 'Mengubah data yang sudah ada.', '2026-10-08 23:12:38', NULL, NULL),
('93510da4-3d40-4444-b196-ddde1f99fc90', 'Read', 'Melihat data.', '2026-10-08 23:12:24', NULL, NULL),
('997295a5-9df3-44fe-a928-aa36ee9f211a', 'Read Accounts', 'Melihat seluruh daftar akun', '2026-10-08 19:06:30', '2026-10-08 20:37:24', '2026-10-08 20:37:24'),
('ad43a832-37c7-4c54-9ced-ef0b579232f0', 'Read Account Type', 'Melihat seluruh daftar tipe akun', '2026-10-08 19:07:09', '2026-10-08 20:37:06', '2026-10-08 20:37:06'),
('aefa0524-42c9-4e0e-8484-8528d4415f50', 'Read Accounts', 'Melihat seluruh daftar akun', '2026-10-08 19:06:58', '2026-10-08 20:37:12', '2026-10-08 20:37:12'),
('b6a0ed5c-ba7b-46d6-86f5-df6a03487b68', 'Read Account Type', 'Melihat seluruh daftar tipe akun', '2026-10-08 19:07:02', '2026-10-08 20:37:08', '2026-10-08 20:37:08'),
('e529adff-1f24-4e77-9809-3e0dd6d35c74', 'Create', 'Menambah data baru', '2026-10-08 20:37:57', NULL, NULL),
('ef7977d2-93d9-436d-8eaa-ca501bd1e696', 'Read Accounts', 'Melihat seluruh daftar akun', '2026-10-08 19:06:40', '2026-10-08 20:37:21', '2026-10-08 20:37:21'),
('f2a74983-0a6f-4e56-a395-21496497c6c1', 'Update Account Type', 'Mengubah tipe akun: gokil123 [ID: 5fc538f6-3ae9-4bbd-b362-456653de91a4]', '2026-10-08 19:07:09', '2026-10-08 20:37:07', '2026-10-08 20:37:07'),
('f2e27893-2522-4c69-bc0e-518996bc7c29', 'Read Account Type', 'Melihat seluruh daftar tipe akun', '2026-10-08 19:06:42', '2026-10-08 20:37:16', '2026-10-08 20:37:16'),
('fe16a0d1-5c9a-48ef-b005-48bee5c75352', 'Read Accounts', 'Melihat seluruh daftar akun', '2026-10-08 19:07:10', '2026-10-08 20:37:04', '2026-10-08 20:37:04');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `accounts`
--
ALTER TABLE `accounts`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`),
  ADD UNIQUE KEY `account_type_id` (`account_type_id`),
  ADD KEY `name` (`name`);

--
-- Indexes for table `account_type`
--
ALTER TABLE `account_type`
  ADD PRIMARY KEY (`id`),
  ADD KEY `name` (`name`);

--
-- Indexes for table `actions`
--
ALTER TABLE `actions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `name` (`name`);

--
-- Constraints for dumped tables
--

--
-- Constraints for table `accounts`
--
ALTER TABLE `accounts`
  ADD CONSTRAINT `fk_account_type` FOREIGN KEY (`account_type_id`) REFERENCES `account_type` (`id`) ON DELETE RESTRICT ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

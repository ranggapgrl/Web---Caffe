-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3307
-- Generation Time: Jul 30, 2025 at 09:59 AM
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
-- Database: `caffe`
--

-- --------------------------------------------------------

--
-- Table structure for table `pembayaran`
--

CREATE TABLE `pembayaran` (
  `id_pembayaran` int(11) NOT NULL,
  `no_meja` int(50) NOT NULL,
  `nama` varchar(50) NOT NULL,
  `menu` varchar(20) NOT NULL,
  `total_bayar` decimal(20,0) NOT NULL,
  `metode_pembayaran` varchar(50) NOT NULL,
  `tanggal_bayar` date NOT NULL,
  `status_pembayaran` varchar(20) DEFAULT 'Belum Bayar'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `pembayaran`
--

INSERT INTO `pembayaran` (`id_pembayaran`, `no_meja`, `nama`, `menu`, `total_bayar`, `metode_pembayaran`, `tanggal_bayar`, `status_pembayaran`) VALUES
(1, 5, 'Hariono', 'Tea', 10000, 'QRIS', '2025-07-15', 'Lunas'),
(2, 7, 'Beneget', 'Apple puie', 40000, 'Dana', '2025-07-16', 'Lunas'),
(3, 7, 'Beneget', 'Apple puie', 40000, 'Ovo', '2025-07-24', 'Lunas'),
(4, 7, 'Beneget', 'Apple puie', 40000, 'Ovo', '2025-07-24', 'Lunas'),
(5, 7, 'Beneget', 'Apple puie', 40000, 'QRIS', '2025-07-30', 'Lunas'),
(6, 12, 'Rangga Pagar Alam', 'Espreso', 18000, 'Dana', '2025-07-18', 'Lunas'),
(7, 22, 'Hariono', 'Mocha', 17000, 'Dana', '2025-07-20', 'Lunas');

-- --------------------------------------------------------

--
-- Table structure for table `pesanan`
--

CREATE TABLE `pesanan` (
  `id_menu` int(10) NOT NULL,
  `no_meja` int(20) NOT NULL,
  `nama` varchar(50) NOT NULL,
  `menu` varchar(20) NOT NULL,
  `menu2` varchar(20) NOT NULL,
  `harga` varchar(30) NOT NULL,
  `jumlah` int(10) NOT NULL,
  `foto` varchar(20) NOT NULL,
  `total_bayar` varchar(50) DEFAULT NULL,
  `metode_pembayaran` varchar(50) DEFAULT NULL,
  `tanggal_bayar` date DEFAULT NULL,
  `status_pembayaran` varchar(20) DEFAULT 'Belum Bayar'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `pesanan`
--

INSERT INTO `pesanan` (`id_menu`, `no_meja`, `nama`, `menu`, `menu2`, `harga`, `jumlah`, `foto`, `total_bayar`, `metode_pembayaran`, `tanggal_bayar`, `status_pembayaran`) VALUES
(26, 22, 'Hariono', 'Mocha', '', '17000', 1, '687d1fce82ec9.jpeg', '17000', 'Dana', '2025-07-20', 'Sudah Dibayar'),
(27, 12, 'Fathan', 'Iced Latte', '', '20000', 1, '687e3b3ba81c6.png', NULL, NULL, NULL, 'Belum Bayar');

-- --------------------------------------------------------

--
-- Table structure for table `registrasi`
--

CREATE TABLE `registrasi` (
  `id` int(10) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `registrasi`
--

INSERT INTO `registrasi` (`id`, `username`, `password`) VALUES
(1, 'rangga', '$2y$10$N7tx.JqBhrUyuLf6CLbFc.Yu2VipFoxytsDqnqwYqQu'),
(2, 'febri', '$2y$10$FlupC/mG8cxprJtZZxBI6.V5J2m7I4lcMzpND/epHM5'),
(3, 'mbiwww', '$2y$10$rwXyRqDfEUNlopdXhoa9ueo6L63t9rrPnhq1Thnm342'),
(4, 'febry', '$2y$10$MyznOdF9kKL7BMEE5G3bquL9JdICVgW6BVfvQwCDN26'),
(5, 'admin', '$2y$10$lM8hxU0D3pFBh2yclmv9ve1wxTCxEDRwB6teD2BzQxF'),
(11, 'lala1', '$2y$10$T3K6U06zPSA9LFSr7ulJR.XCuCN65v7e3H6hXF5eZug'),
(12, 'rangga1', '$2y$10$7ccIlAnKpJMMDgUhrWp30.nxbQ2f4QvVSTOLeN1RthP'),
(14, 'lama', '$2y$10$8xN8jKYZMgxt9y8sF7b2fO9LeYbJbTrkcMgqUy6.GaxQFQ8Fj8Kta'),
(15, 'lala12', '$2y$10$ZQTihlegzLSnNenVLwepHOvl9zsilMi9VhGLJnaO1aH08qyy9eac2');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id_user` int(10) NOT NULL,
  `nama` varchar(50) NOT NULL,
  `no_meja` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `pembayaran`
--
ALTER TABLE `pembayaran`
  ADD PRIMARY KEY (`id_pembayaran`);

--
-- Indexes for table `pesanan`
--
ALTER TABLE `pesanan`
  ADD PRIMARY KEY (`id_menu`);

--
-- Indexes for table `registrasi`
--
ALTER TABLE `registrasi`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id_user`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `pembayaran`
--
ALTER TABLE `pembayaran`
  MODIFY `id_pembayaran` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `pesanan`
--
ALTER TABLE `pesanan`
  MODIFY `id_menu` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT for table `registrasi`
--
ALTER TABLE `registrasi`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id_user` int(10) NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

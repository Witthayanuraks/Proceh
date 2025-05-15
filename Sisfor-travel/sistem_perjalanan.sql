-- phpMyAdmin SQL Dump
-- version 5.2.2
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: May 15, 2025 at 08:36 PM
-- Server version: 8.0.30
-- PHP Version: 8.1.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `sistem_perjalanan`
--

-- --------------------------------------------------------

--
-- Table structure for table `jadwal_pemesanan`
--

CREATE TABLE `jadwal_pemesanan` (
  `id_pemesanan` int NOT NULL,
  `id_layanan` int DEFAULT NULL,
  `nama_pelanggan` varchar(100) NOT NULL,
  `email_pelanggan` varchar(100) NOT NULL,
  `tanggal_pemesanan` date NOT NULL,
  `tanggal_berangkat` date NOT NULL,
  `jumlah_penumpang` int NOT NULL,
  `permintaan_khusus` text,
  `status` enum('menunggu','dikonfirmasi','dibatalkan') DEFAULT 'menunggu',
  `dibuat_pada` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `jadwal_pemesanan`
--

INSERT INTO `jadwal_pemesanan` (`id_pemesanan`, `id_layanan`, `nama_pelanggan`, `email_pelanggan`, `tanggal_pemesanan`, `tanggal_berangkat`, `jumlah_penumpang`, `permintaan_khusus`, `status`, `dibuat_pada`) VALUES
(1, 1, 'Ahmad', 'ahmad@gmail.com', '2025-08-15', '2025-06-20', 1, '', 'dikonfirmasi', '2025-05-15 19:51:28');

-- --------------------------------------------------------

--
-- Table structure for table `layanan_perjalanan`
--

CREATE TABLE `layanan_perjalanan` (
  `id_layanan` int NOT NULL,
  `nama_layanan` varchar(100) NOT NULL,
  `deskripsi` text,
  `harga` decimal(10,2) NOT NULL,
  `durasi` varchar(50) DEFAULT NULL,
  `dibuat_pada` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `layanan_perjalanan`
--

INSERT INTO `layanan_perjalanan` (`id_layanan`, `nama_layanan`, `deskripsi`, `harga`, `durasi`, `dibuat_pada`) VALUES
(1, 'BUS ABCD', 'PLAT A 9219 CD', 100000.00, '10 JAM ', '2025-05-15 19:50:47'),
(2, 'PESAWAT ABCD', 'SERI A23', 9000.00, '1 JAM', '2025-05-15 19:56:08');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `jadwal_pemesanan`
--
ALTER TABLE `jadwal_pemesanan`
  ADD PRIMARY KEY (`id_pemesanan`),
  ADD KEY `id_layanan` (`id_layanan`);

--
-- Indexes for table `layanan_perjalanan`
--
ALTER TABLE `layanan_perjalanan`
  ADD PRIMARY KEY (`id_layanan`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `jadwal_pemesanan`
--
ALTER TABLE `jadwal_pemesanan`
  MODIFY `id_pemesanan` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `layanan_perjalanan`
--
ALTER TABLE `layanan_perjalanan`
  MODIFY `id_layanan` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `jadwal_pemesanan`
--
ALTER TABLE `jadwal_pemesanan`
  ADD CONSTRAINT `jadwal_pemesanan_ibfk_1` FOREIGN KEY (`id_layanan`) REFERENCES `layanan_perjalanan` (`id_layanan`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

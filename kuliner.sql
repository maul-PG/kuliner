-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 12, 2025 at 11:14 AM
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
-- Database: `kuliner`
--

-- --------------------------------------------------------

--
-- Table structure for table `detail_pesanan`
--

CREATE TABLE `detail_pesanan` (
  `id_detail` int(11) NOT NULL,
  `id_pesanan` int(11) DEFAULT NULL,
  `id_menu` int(11) DEFAULT NULL,
  `jumlah` int(11) DEFAULT NULL,
  `subtotal` int(11) DEFAULT NULL,
  `id_makanan` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `detail_pesanan`
--

INSERT INTO `detail_pesanan` (`id_detail`, `id_pesanan`, `id_menu`, `jumlah`, `subtotal`, `id_makanan`) VALUES
(1, 4, NULL, 1, 18000, 1),
(2, 4, NULL, 1, 5000, 2),
(3, 5, NULL, 1, 10000, 16),
(4, 5, NULL, 1, 5000, 2),
(5, 6, NULL, 1, 15000, 3),
(6, 7, NULL, 1, 18000, 1),
(7, 7, NULL, 1, 15000, 3),
(8, 7, NULL, 1, 10000, 18),
(9, 8, NULL, 1, 5000, 2),
(10, 11, NULL, 3, 21000, 14),
(11, 12, NULL, 1, 15000, 3);

-- --------------------------------------------------------

--
-- Table structure for table `keranjang`
--

CREATE TABLE `keranjang` (
  `id_keranjang` int(11) NOT NULL,
  `id_user` int(11) NOT NULL,
  `id_menu` int(11) NOT NULL,
  `jumlah` int(11) DEFAULT 1,
  `status` enum('pending','checkout') DEFAULT 'pending',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `keranjang`
--

INSERT INTO `keranjang` (`id_keranjang`, `id_user`, `id_menu`, `jumlah`, `status`, `created_at`) VALUES
(3, 1, 2, 1, '', '2025-05-11 17:15:01'),
(5, 1, 14, 3, '', '2025-05-12 00:31:12'),
(7, 1, 3, 1, '', '2025-05-12 01:05:14');

-- --------------------------------------------------------

--
-- Table structure for table `menu_makanan`
--

CREATE TABLE `menu_makanan` (
  `id_menu` int(11) NOT NULL,
  `nama_makanan` varchar(100) NOT NULL,
  `kategori` varchar(50) NOT NULL,
  `harga` int(11) NOT NULL,
  `deskripsi` text DEFAULT NULL,
  `jumlah_terjual` int(11) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `menu_makanan`
--

INSERT INTO `menu_makanan` (`id_menu`, `nama_makanan`, `kategori`, `harga`, `deskripsi`, `jumlah_terjual`) VALUES
(1, 'Nasi Goreng Spesial', 'Makanan', 18000, 'Nasi goreng dengan telur dan ayam', 1),
(2, 'Es Teh Manis', 'Minuman', 5000, 'Minuman segar dengan gula jawa', 1),
(3, 'Ayam Geprek', 'Makanan', 15000, 'Ayam goreng tepung dengan sambal', 2),
(4, 'Pisang Coklat', 'Dessert', 8000, 'Pisang goreng isi coklat lumer', 0),
(5, 'Mie Goreng Jawa', 'Makanan', 13000, 'Mie goreng khas Jawa dengan sayur dan telur', 0),
(6, 'Sate Ayam', 'Makanan', 17000, '10 tusuk sate ayam + lontong', 0),
(7, 'Bakso Urat', 'Makanan', 14000, 'Bakso isi urat dan daging sapi asli', 0),
(8, 'Soto Ayam', 'Makanan', 12000, 'Soto bening dengan suwiran ayam kampung', 0),
(9, 'Nasi Ayam Teriyaki', 'Makanan', 20000, 'Nasi dengan ayam teriyaki khas Jepang', 0),
(10, 'Kwetiau Goreng', 'Makanan', 16000, 'Kwetiau goreng dengan telur dan sayur', 0),
(11, 'Gado-Gado', 'Makanan', 12000, 'Sayuran rebus dengan bumbu kacang', 0),
(12, 'Nasi Padang Komplit', 'Makanan', 22000, 'Nasi Padang dengan rendang, sayur, dan sambal', 0),
(13, 'Es Jeruk', 'Minuman', 6000, 'Jeruk segar dengan es', 0),
(14, 'Kopi Hitam', 'Minuman', 7000, 'Kopi tubruk asli Indonesia', 3),
(15, 'Es Cincau', 'Minuman', 8000, 'Minuman tradisional dengan cincau dan santan', 0),
(16, 'Jus Alpukat', 'Minuman', 10000, 'Alpukat segar dengan coklat', 0),
(17, 'Milkshake Coklat', 'Minuman', 11000, 'Susu kocok rasa coklat', 0),
(18, 'Martabak Mini', 'Dessert', 10000, 'Martabak manis mini berbagai rasa', 1),
(19, 'Brownies Kukus', 'Dessert', 12000, 'Brownies lembut dengan topping keju', 0),
(20, 'Puding Coklat', 'Dessert', 9000, 'Puding coklat dengan saus vla', 0);

-- --------------------------------------------------------

--
-- Table structure for table `pesanan`
--

CREATE TABLE `pesanan` (
  `id_pesanan` int(11) NOT NULL,
  `id_user` int(11) DEFAULT NULL,
  `tanggal` datetime DEFAULT current_timestamp(),
  `total_harga` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `pesanan`
--

INSERT INTO `pesanan` (`id_pesanan`, `id_user`, `tanggal`, `total_harga`) VALUES
(1, 1, '2025-05-11 10:56:22', 23000),
(2, 1, '2025-05-11 10:59:27', 23000),
(3, 1, '2025-05-11 10:59:35', 23000),
(4, 1, '2025-05-11 11:00:14', 23000),
(5, 1, '2025-05-11 11:03:53', 15000),
(6, 1, '2025-05-11 11:13:48', 15000),
(7, 1, '2025-05-11 12:05:39', 43000),
(8, 1, '2025-05-12 00:00:00', 5000),
(9, 1, '2025-05-12 00:00:00', 0),
(10, 1, '2025-05-12 00:00:00', 0),
(11, 1, '2025-05-12 00:00:00', 21000),
(12, 1, '2025-05-12 00:00:00', 15000),
(13, 1, '2025-05-12 00:00:00', 0),
(14, 1, '2025-05-12 00:00:00', 0),
(15, 1, '2025-05-12 00:00:00', 0),
(16, 1, '2025-05-12 00:00:00', 0),
(17, 1, '2025-05-12 00:00:00', 0),
(18, 1, '2025-05-12 00:00:00', 0);

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `username`, `password`) VALUES
(1, 'RafiiMaulana', '$2y$10$oxUyvKZgilp8Mna3AsQwxeuh4Q2o6BP80/cbpaR2SoDjf2lRVdfFC');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `detail_pesanan`
--
ALTER TABLE `detail_pesanan`
  ADD PRIMARY KEY (`id_detail`),
  ADD KEY `id_pesanan` (`id_pesanan`),
  ADD KEY `id_menu` (`id_menu`);

--
-- Indexes for table `keranjang`
--
ALTER TABLE `keranjang`
  ADD PRIMARY KEY (`id_keranjang`);

--
-- Indexes for table `menu_makanan`
--
ALTER TABLE `menu_makanan`
  ADD PRIMARY KEY (`id_menu`);

--
-- Indexes for table `pesanan`
--
ALTER TABLE `pesanan`
  ADD PRIMARY KEY (`id_pesanan`),
  ADD KEY `fk_user_pesanan` (`id_user`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `detail_pesanan`
--
ALTER TABLE `detail_pesanan`
  MODIFY `id_detail` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `keranjang`
--
ALTER TABLE `keranjang`
  MODIFY `id_keranjang` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `menu_makanan`
--
ALTER TABLE `menu_makanan`
  MODIFY `id_menu` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `pesanan`
--
ALTER TABLE `pesanan`
  MODIFY `id_pesanan` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `detail_pesanan`
--
ALTER TABLE `detail_pesanan`
  ADD CONSTRAINT `detail_pesanan_ibfk_1` FOREIGN KEY (`id_pesanan`) REFERENCES `pesanan` (`id_pesanan`),
  ADD CONSTRAINT `detail_pesanan_ibfk_2` FOREIGN KEY (`id_menu`) REFERENCES `menu_makanan` (`id_menu`);

--
-- Constraints for table `pesanan`
--
ALTER TABLE `pesanan`
  ADD CONSTRAINT `fk_user_pesanan` FOREIGN KEY (`id_user`) REFERENCES `user` (`id`),
  ADD CONSTRAINT `pesanan_ibfk_1` FOREIGN KEY (`id_user`) REFERENCES `user` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

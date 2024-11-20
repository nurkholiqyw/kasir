-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 16, 2024 at 07:12 AM
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
-- Database: `db_toko`
--

-- --------------------------------------------------------

--
-- Table structure for table `barang`
--

CREATE TABLE `barang` (
  `id` int(11) NOT NULL,
  `id_barang` varchar(255) NOT NULL,
  `id_kategori` int(11) NOT NULL,
  `nama_barang` text NOT NULL,
  `merk` varchar(255) NOT NULL,
  `harga_beli` varchar(255) NOT NULL,
  `harga_jual` varchar(255) NOT NULL,
  `satuan_barang` varchar(255) NOT NULL,
  `stok` text NOT NULL,
  `tgl_input` varchar(255) NOT NULL,
  `tgl_update` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `barang`
--

INSERT INTO `barang` (`id`, `id_barang`, `id_kategori`, `nama_barang`, `merk`, `harga_beli`, `harga_jual`, `satuan_barang`, `stok`, `tgl_input`, `tgl_update`) VALUES
(2, 'BR002', 1, 'Beras', 'Rojo Lele', '13000', '18000', 'Kg', '28', '6 October 2020, 0:41', '15 October 2024, 20:25'),
(3, 'BR003', 1, 'Beras', 'Maknyus', '12000', '20000', 'Kg', '59', '6 October 2020, 1:34', '15 October 2024, 20:24'),
(4, 'BR001', 1, 'Beras', 'Koi', '15000', '20000', 'Kg', '30', '15 October 2024, 23:21', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `detail_pesanan`
--

CREATE TABLE `detail_pesanan` (
  `id` int(11) NOT NULL,
  `id_pesanan` varchar(255) NOT NULL,
  `id_barang` varchar(255) NOT NULL,
  `jumlah` int(25) NOT NULL,
  `total` int(12) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `detail_pesanan`
--

INSERT INTO `detail_pesanan` (`id`, `id_pesanan`, `id_barang`, `jumlah`, `total`) VALUES
(32, 'PS001', 'BR001', 1, 20000),
(33, 'PS001', 'BR002', 1, 18000),
(34, 'PS002', 'BR001', 1, 20000),
(35, 'PS002', 'BR002', 1, 18000),
(39, 'PS003', 'BR002', 1, 18000),
(40, 'PS003', 'BR003', 1, 20000),
(43, 'PS004', 'BR002', 1, 18000),
(44, 'PS004', 'BR002', 1, 18000);

-- --------------------------------------------------------

--
-- Table structure for table `kategori`
--

CREATE TABLE `kategori` (
  `id_kategori` int(11) NOT NULL,
  `nama_kategori` varchar(255) NOT NULL,
  `tgl_input` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `kategori`
--

INSERT INTO `kategori` (`id_kategori`, `nama_kategori`, `tgl_input`) VALUES
(1, 'ATK', '7 May 2017, 10:23'),
(5, 'Sabun', '7 May 2017, 10:28'),
(6, 'Snack', '6 October 2020, 0:19'),
(7, 'Minuman', '6 October 2020, 0:20');

-- --------------------------------------------------------

--
-- Table structure for table `login`
--

CREATE TABLE `login` (
  `id_login` int(11) NOT NULL,
  `user` varchar(255) NOT NULL,
  `pass` char(32) NOT NULL,
  `id_member` int(11) NOT NULL,
  `role` enum('admin','pegawai') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `login`
--

INSERT INTO `login` (`id_login`, `user`, `pass`, `id_member`, `role`) VALUES
(1, 'admin', '202cb962ac59075b964b07152d234b70', 1, 'admin'),
(4, 'nur', 'b55178b011bfb206965f2638d0f87047', 4, 'pegawai');

-- --------------------------------------------------------

--
-- Table structure for table `member`
--

CREATE TABLE `member` (
  `id_member` int(11) NOT NULL,
  `nm_member` varchar(255) NOT NULL,
  `alamat_member` text NOT NULL,
  `telepon` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `gambar` text NOT NULL,
  `NIK` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `member`
--

INSERT INTO `member` (`id_member`, `nm_member`, `alamat_member`, `telepon`, `email`, `gambar`, `NIK`) VALUES
(1, 'Gesti Dwi Fajarsari', 'uj harapan', '081234567890', 'example@gmail.com', '1729010197p.jpg', '12314121'),
(4, 'nurKholiq', 'nur', '12312', 'nur@gmail.com', '', '123');

-- --------------------------------------------------------

--
-- Table structure for table `nota`
--

CREATE TABLE `nota` (
  `id_nota` int(11) NOT NULL,
  `id_barang` varchar(255) NOT NULL,
  `id_member` int(11) NOT NULL,
  `jumlah` varchar(255) NOT NULL,
  `total` varchar(255) NOT NULL,
  `tanggal_input` varchar(255) NOT NULL,
  `periode` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `nota`
--

INSERT INTO `nota` (`id_nota`, `id_barang`, `id_member`, `jumlah`, `total`, `tanggal_input`, `periode`) VALUES
(105, 'BR001', 4, '1', '20000', '15 October 2024, 22:50', '10-2024'),
(106, 'BR002', 4, '1', '18000', '15 October 2024, 22:50', '10-2024'),
(107, 'BR001', 4, '1', '20000', '15 October 2024, 22:50', '10-2024'),
(108, 'BR002', 4, '1', '18000', '15 October 2024, 22:50', '10-2024'),
(109, 'BR001', 4, '1', '20000', '15 October 2024, 22:50', '10-2024'),
(110, 'BR002', 4, '1', '18000', '15 October 2024, 22:50', '10-2024'),
(111, 'BR001', 4, '1', '20000', '15 October 2024, 22:50', '10-2024'),
(112, 'BR002', 4, '1', '18000', '15 October 2024, 22:50', '10-2024'),
(113, 'BR001', 4, '1', '20000', '15 October 2024, 22:50', '10-2024'),
(114, 'BR002', 4, '1', '18000', '15 October 2024, 22:50', '10-2024'),
(115, 'BR001', 4, '1', '20000', '15 October 2024, 22:50', '10-2024'),
(116, 'BR002', 4, '1', '18000', '15 October 2024, 22:50', '10-2024'),
(117, 'BR002', 4, '1', '18000', '15 October 2024, 23:30', '10-2024'),
(118, 'BR003', 4, '1', '20000', '15 October 2024, 23:30', '10-2024'),
(119, 'BR001', 4, '1', '20000', '15 October 2024, 22:50', '10-2024'),
(120, 'BR002', 4, '1', '18000', '15 October 2024, 22:50', '10-2024'),
(121, 'BR001', 4, '1', '20000', '15 October 2024, 22:50', '10-2024'),
(122, 'BR002', 4, '1', '18000', '15 October 2024, 22:50', '10-2024'),
(123, 'BR001', 4, '1', '20000', '15 October 2024, 22:50', '10-2024'),
(124, 'BR002', 4, '1', '18000', '15 October 2024, 22:50', '10-2024'),
(125, 'BR001', 4, '1', '20000', '15 October 2024, 22:50', '10-2024'),
(126, 'BR002', 4, '1', '18000', '15 October 2024, 22:50', '10-2024'),
(127, 'BR001', 4, '1', '20000', '15 October 2024, 22:50', '10-2024'),
(128, 'BR002', 4, '1', '18000', '15 October 2024, 22:50', '10-2024'),
(129, 'BR002', 4, '1', '18000', '16 October 2024, 11:59', '10-2024'),
(130, 'BR002', 4, '1', '18000', '16 October 2024, 11:59', '10-2024'),
(131, 'BR003', 4, '1', '20000', '16 October 2024, 12:00', '10-2024'),
(132, 'BR002', 4, '1', '18000', '16 October 2024, 11:59', '10-2024'),
(133, 'BR002', 4, '1', '18000', '16 October 2024, 11:59', '10-2024');

-- --------------------------------------------------------

--
-- Table structure for table `penjualan`
--

CREATE TABLE `penjualan` (
  `id_penjualan` int(11) NOT NULL,
  `id_barang` varchar(255) NOT NULL,
  `id_member` int(11) NOT NULL,
  `jumlah` varchar(255) NOT NULL,
  `total` varchar(255) NOT NULL,
  `tanggal_input` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `pesanan`
--

CREATE TABLE `pesanan` (
  `id` int(11) NOT NULL,
  `id_pesanan` varchar(255) NOT NULL,
  `total` int(255) NOT NULL,
  `nama_pemesan` varchar(25) NOT NULL,
  `id_member` int(12) NOT NULL,
  `tanggal_input` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `pesanan`
--

INSERT INTO `pesanan` (`id`, `id_pesanan`, `total`, `nama_pemesan`, `id_member`, `tanggal_input`) VALUES
(34, 'PS001', 38000, 'fajar', 4, '15 October 2024, 22:50'),
(35, 'PS002', 38000, 'coba', 4, '15 October 2024, 22:50'),
(39, 'PS003', 38000, 'sssssss', 4, '15 October 2024, 23:30'),
(41, 'PS004', 36000, 'deny', 4, '16 October 2024, 11:59');

-- --------------------------------------------------------

--
-- Table structure for table `toko`
--

CREATE TABLE `toko` (
  `id_toko` int(11) NOT NULL,
  `nama_toko` varchar(255) NOT NULL,
  `alamat_toko` text NOT NULL,
  `tlp` varchar(255) NOT NULL,
  `nama_pemilik` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `toko`
--

INSERT INTO `toko` (`id_toko`, `nama_toko`, `alamat_toko`, `tlp`, `nama_pemilik`) VALUES
(1, 'UD HR Groups', 'Ujung Harapan', '081234567890', 'Gesti Dwi Fajarsari');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `barang`
--
ALTER TABLE `barang`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `detail_pesanan`
--
ALTER TABLE `detail_pesanan`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `kategori`
--
ALTER TABLE `kategori`
  ADD PRIMARY KEY (`id_kategori`);

--
-- Indexes for table `login`
--
ALTER TABLE `login`
  ADD PRIMARY KEY (`id_login`);

--
-- Indexes for table `member`
--
ALTER TABLE `member`
  ADD PRIMARY KEY (`id_member`);

--
-- Indexes for table `nota`
--
ALTER TABLE `nota`
  ADD PRIMARY KEY (`id_nota`);

--
-- Indexes for table `penjualan`
--
ALTER TABLE `penjualan`
  ADD PRIMARY KEY (`id_penjualan`);

--
-- Indexes for table `pesanan`
--
ALTER TABLE `pesanan`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `toko`
--
ALTER TABLE `toko`
  ADD PRIMARY KEY (`id_toko`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `barang`
--
ALTER TABLE `barang`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `detail_pesanan`
--
ALTER TABLE `detail_pesanan`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=45;

--
-- AUTO_INCREMENT for table `kategori`
--
ALTER TABLE `kategori`
  MODIFY `id_kategori` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `login`
--
ALTER TABLE `login`
  MODIFY `id_login` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `member`
--
ALTER TABLE `member`
  MODIFY `id_member` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `nota`
--
ALTER TABLE `nota`
  MODIFY `id_nota` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=134;

--
-- AUTO_INCREMENT for table `penjualan`
--
ALTER TABLE `penjualan`
  MODIFY `id_penjualan` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `pesanan`
--
ALTER TABLE `pesanan`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=42;

--
-- AUTO_INCREMENT for table `toko`
--
ALTER TABLE `toko`
  MODIFY `id_toko` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

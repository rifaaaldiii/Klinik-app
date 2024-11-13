-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 13, 2024 at 04:22 PM
-- Server version: 10.4.24-MariaDB
-- PHP Version: 8.1.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `klinik`
--

-- --------------------------------------------------------

--
-- Table structure for table `asistens`
--

CREATE TABLE `asistens` (
  `id` int(11) NOT NULL,
  `notrans` varchar(11) NOT NULL,
  `id_karyawan` int(11) NOT NULL,
  `ro1` varchar(25) NOT NULL,
  `ro2` varchar(25) NOT NULL,
  `ro3` varchar(25) NOT NULL,
  `non_regio` varchar(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `detail_gaji`
--

CREATE TABLE `detail_gaji` (
  `id` int(11) NOT NULL,
  `penggajian_id` int(11) UNSIGNED NOT NULL,
  `karyawan_id` int(11) UNSIGNED NOT NULL,
  `overtime` varchar(20) NOT NULL,
  `jumlah_pasien` varchar(20) NOT NULL,
  `makan` varchar(20) NOT NULL,
  `ro1` varchar(225) NOT NULL,
  `ro2` varchar(225) NOT NULL,
  `ro3` varchar(225) NOT NULL,
  `bonus` varchar(45) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `detail_transaksi`
--

CREATE TABLE `detail_transaksi` (
  `id` int(11) NOT NULL,
  `notrans` varchar(11) NOT NULL,
  `tindakan` varchar(225) NOT NULL,
  `harga` varchar(45) NOT NULL,
  `jm` varchar(45) NOT NULL,
  `tipe_jm` varchar(11) NOT NULL,
  `modal` varchar(45) NOT NULL,
  `dp` varchar(500) NOT NULL,
  `bayar` varchar(255) NOT NULL,
  `total` varchar(45) NOT NULL,
  `diskon` varchar(45) NOT NULL,
  `diskon_jm` varchar(11) NOT NULL,
  `metode` varchar(20) NOT NULL,
  `catatan` varchar(225) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `golongan`
--

CREATE TABLE `golongan` (
  `id` int(11) UNSIGNED NOT NULL,
  `nama_golongan` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `gaji_pokok` int(12) NOT NULL,
  `tunjangan_makan` int(12) NOT NULL,
  `overtime` varchar(11) COLLATE utf8_unicode_ci NOT NULL,
  `tunjangan_pasien` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `ro1` varchar(45) COLLATE utf8_unicode_ci NOT NULL,
  `ro2` varchar(45) COLLATE utf8_unicode_ci NOT NULL,
  `ro3` varchar(45) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `golongan`
--

INSERT INTO `golongan` (`id`, `nama_golongan`, `gaji_pokok`, `tunjangan_makan`, `overtime`, `tunjangan_pasien`, `ro1`, `ro2`, `ro3`) VALUES
(1, 'Karyawan', 1950000, 17500, '550', '4000', '7500', '15000', '30000'),
(7, 'Dokter', 0, 0, '', '', '', '', ''),
(9, 'Admin', 1, 1, '1', '1', '1', '1', '1');

-- --------------------------------------------------------

--
-- Table structure for table `karyawan`
--

CREATE TABLE `karyawan` (
  `id` int(11) UNSIGNED NOT NULL,
  `nip` varchar(12) COLLATE utf8_unicode_ci NOT NULL,
  `nik` varchar(12) COLLATE utf8_unicode_ci NOT NULL,
  `nama` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `jenis_kelamin` varchar(11) COLLATE utf8_unicode_ci NOT NULL,
  `tanggal_lahir` date NOT NULL,
  `telpon` varchar(12) COLLATE utf8_unicode_ci NOT NULL,
  `no_rek` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `agama` varchar(15) COLLATE utf8_unicode_ci NOT NULL,
  `alamat` text COLLATE utf8_unicode_ci NOT NULL,
  `golongan_id` int(11) UNSIGNED NOT NULL,
  `status` varchar(11) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `penggajian`
--

CREATE TABLE `penggajian` (
  `id` int(11) UNSIGNED NOT NULL,
  `tanggal` date NOT NULL,
  `karyawan_id` int(11) UNSIGNED NOT NULL,
  `asistensi` varchar(45) COLLATE utf8_unicode_ci NOT NULL,
  `total` varchar(25) COLLATE utf8_unicode_ci NOT NULL,
  `status` varchar(11) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tindakan`
--

CREATE TABLE `tindakan` (
  `id` int(11) NOT NULL,
  `nama_tindakan` varchar(225) NOT NULL,
  `jm` int(11) NOT NULL,
  `harga` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tindakan`
--

INSERT INTO `tindakan` (`id`, `nama_tindakan`, `jm`, `harga`) VALUES
(1, 'Konsul drg. umum', 0, '50000'),
(2, 'Konsul drg. Spesialis', 0, '150000'),
(3, 'Konsul CITO', 0, '100000'),
(4, 'Adm', 1, '10000'),
(5, 'Bmhp', 1, '100000'),
(6, 'Ro periapikal / Regio', 2, '90000'),
(7, 'Gigi satuan', 0, '25000'),
(8, 'Gigi Permanen Rp.500.000 s/d 800.000', 0, '0'),
(9, 'Gigi Susu/Gigi Campur Rp.300.000 s/d 550.000', 0, '0'),
(10, 'Bleaching/Pemutihan Gigi', 0, '2500000'),
(11, 'Bleaching+Scaling', 0, '3250000'),
(12, 'Removing Gutap Rp.50.000 s/d 100.000', 0, '0'),
(13, 'Gigi Susu/Gigi Desidui 1-2 SA', 0, '200000'),
(14, 'Gigi Susu/Gigi Desidui 3-4 SA', 0, '250000'),
(15, 'K-file/tanpa K-File 1-2 SA', 0, '300000'),
(16, 'K-file/tanpa K-File 3-4 SA', 0, '350000'),
(17, 'Protaper 1-2 SA', 0, '350000'),
(18, 'Protaper 3-4 SA', 0, '400000'),
(19, 'Endomotor 1-2 SA', 0, '450000'),
(20, 'Endomotor 3-4 SA', 0, '500000'),
(21, 'Composite dan GIC Gigi Susu/Desidui Rp.300.000 s/d 500.000', 0, '0'),
(22, 'Rewalling', 0, '300000'),
(23, 'GIC Gigi Dewasa Rp.350.000 S/d 550.000', 0, '0'),
(24, 'Composite Gigi dewasa Rp.400.000 s/d 800.000', 0, '0'),
(25, 'Composite gigi depan Rp.500.000 s/d 1.000.000', 0, '0'),
(26, 'Direct Veneer', 0, '1000000'),
(27, 'Indirect Veneer (Lab)', 4, '3300000'),
(28, 'Splinting Rp.200.000 s/d 500.000', 0, '0'),
(29, 'Dycal', 0, '50000'),
(30, 'Lining RMGIC', 0, '100000'),
(31, 'Lining Bulkflow', 0, '100000'),
(32, 'Lining ZpO4', 0, '100000'),
(33, 'Dycal+Lining RMGIC', 0, '150000'),
(34, 'Tambal sementara', 0, '100000'),
(35, 'Pulp Capping + TS', 0, '300000'),
(36, 'Grinding/Polishing', 0, '100000'),
(37, 'Gigi susu/Desidui CE', 0, '150000'),
(38, 'Gigi susu/Desidui Infil', 0, '200000'),
(39, 'Gigi permanen Rp.300.000 s/d 800.000', 0, '0'),
(40, 'Komplikasi Rp.850.000 s/d 150.0000', 0, '0'),
(41, 'Removing Kortugi Rp.150.000 s/d 300.000', 0, '0'),
(42, 'Spongostan', 1, '25000'),
(43, 'Odontectomy Rp.2.000.000 s/d 6.000.000', 0, '0'),
(44, 'Operculectomy Rp.300.000 s/d 1.000.000', 0, '0'),
(45, 'Gingivectomy Rp.300.000 s/d 1.000.000', 0, '0'),
(46, 'Frenectomy Rp.300.000 s/d 1.000.000', 0, '0'),
(47, 'Hecting/Up Hecting', 0, '50000'),
(48, 'Crown Acrylic', 4, '2300000'),
(49, 'Crown Metel Porcelain', 4, '3000000'),
(50, 'Crown Full Porcelain', 4, '3500000'),
(51, 'Crown Emax', 4, '3500000'),
(52, 'Crown Zirconia', 4, '4000000'),
(53, 'Inlay/Onlay Metal/Porcelain', 4, '2550000'),
(54, 'Profisoris/Immediate denture/Temporary Crown + 100.000/gigi', 4, '1000000'),
(55, 'Pin/Post Core', 1, '300000'),
(56, 'Sementasi', 0, '500000'),
(57, 'Removing Logam / Wings Rp.100.000 s/d 250.000', 0, '0'),
(58, 'Acrylic + 300.000/gigi', 4, '2300000'),
(59, 'Valpas + 300.000/gigi', 4, '2500000'),
(60, 'Frame Acrylic + 300.000/gigi', 4, '3000000'),
(61, 'Thermosens + 300.000/gigi', 4, '2850000'),
(62, 'Alginate', 0, '300000'),
(63, 'Dauble Impression', 0, '300000'),
(64, 'Insersi Ortho drg. Umum', 0, '7000000'),
(65, 'Kontrol Ortho', 0, '350000'),
(66, 'Lem Bracket', 0, '25000'),
(67, 'Ganti Karet RA+RB', 0, '350000'),
(68, 'Removing Ortho/ rahang + Polishing', 0, '450000'),
(69, 'Removing Ortho / rahang + Scaling', 0, '600000'),
(70, 'Konvensional', 4, '9000000'),
(71, 'Konvensional Kontrol Ortho', 3, '450000'),
(72, 'Self Ligating', 3, '1500000'),
(73, 'Self Ligating Kontrol Ortho', 3, '550000'),
(74, 'Damon', 3, '20000000'),
(75, 'Damon Kontrol Ortho', 3, '0'),
(76, 'Type Damon Clear', 3, '25000000'),
(77, 'Type Damon Clear Kontrol Ortho', 3, '0'),
(78, 'Cetak gigi dengan drg. Spesialis', 3, '350000'),
(79, 'Removing Ortho/ rahang + Polishing', 3, '450000'),
(80, 'Removing Ortho / rahang + Scaling', 3, '600000'),
(81, 'Retainer (Dewasa)/ rahang', 4, '1250000'),
(82, 'Trainer (Anak) /rahang', 4, '1200000'),
(83, 'Ti-es Metronidazole Rp.100.000 s/d 150.000', 0, '0'),
(84, 'Carpule', 1, '50000'),
(85, 'Oxy Gel Rp.50.000 s/d 75.000', 1, '0'),
(86, 'Aplikasi Flouride', 0, '250000'),
(87, 'Food Debridment', 0, '100000'),
(88, 'Trepanasi', 0, '100000'),
(89, 'Opening', 0, '100000'),
(90, 'Spooling', 0, '100000'),
(91, 'GDS', 1, '50000');

-- --------------------------------------------------------

--
-- Table structure for table `transaksi`
--

CREATE TABLE `transaksi` (
  `id` int(11) UNSIGNED NOT NULL,
  `notrans` varchar(11) NOT NULL,
  `tanggal` date NOT NULL,
  `dokter` int(11) NOT NULL,
  `nama_klien` varchar(45) NOT NULL,
  `total` varchar(255) NOT NULL,
  `status` varchar(11) NOT NULL,
  `catatan` varchar(500) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `username` varchar(45) NOT NULL,
  `email` varchar(45) NOT NULL,
  `password` varchar(500) NOT NULL,
  `role` varchar(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `username`, `email`, `password`, `role`) VALUES
(1, 'owner', 'rifaldiyuda@gmail.com', '$2y$10$08zptNTIPDbCxD1Vau9Kg.FNEZJku1FGypouCpITAAnC5ukwfTqG6', 'owner'),
(4, 'admin', 'admin@gmail.com', '$2y$10$GImH.YwBxXiaI.P/0drHe.g1AZQr/d90esIl/wA1IJCGa91oy0wt2', 'admin');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `asistens`
--
ALTER TABLE `asistens`
  ADD PRIMARY KEY (`id`),
  ADD KEY `notrans` (`notrans`);

--
-- Indexes for table `detail_gaji`
--
ALTER TABLE `detail_gaji`
  ADD PRIMARY KEY (`id`),
  ADD KEY `penggajian_id` (`penggajian_id`),
  ADD KEY `karyawan_id` (`karyawan_id`);

--
-- Indexes for table `detail_transaksi`
--
ALTER TABLE `detail_transaksi`
  ADD PRIMARY KEY (`id`),
  ADD KEY `notrans` (`notrans`);

--
-- Indexes for table `golongan`
--
ALTER TABLE `golongan`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `karyawan`
--
ALTER TABLE `karyawan`
  ADD PRIMARY KEY (`id`),
  ADD KEY `karyawan_golongan_id` (`golongan_id`);

--
-- Indexes for table `penggajian`
--
ALTER TABLE `penggajian`
  ADD PRIMARY KEY (`id`),
  ADD KEY `penjualan_pelanggan_id` (`karyawan_id`);

--
-- Indexes for table `tindakan`
--
ALTER TABLE `tindakan`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `transaksi`
--
ALTER TABLE `transaksi`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `notrans` (`notrans`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `asistens`
--
ALTER TABLE `asistens`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=56;

--
-- AUTO_INCREMENT for table `detail_gaji`
--
ALTER TABLE `detail_gaji`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=56;

--
-- AUTO_INCREMENT for table `detail_transaksi`
--
ALTER TABLE `detail_transaksi`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=183;

--
-- AUTO_INCREMENT for table `golongan`
--
ALTER TABLE `golongan`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `karyawan`
--
ALTER TABLE `karyawan`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT for table `penggajian`
--
ALTER TABLE `penggajian`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=79;

--
-- AUTO_INCREMENT for table `tindakan`
--
ALTER TABLE `tindakan`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=200;

--
-- AUTO_INCREMENT for table `transaksi`
--
ALTER TABLE `transaksi`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=174;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `asistens`
--
ALTER TABLE `asistens`
  ADD CONSTRAINT `asistens_ibfk_1` FOREIGN KEY (`notrans`) REFERENCES `transaksi` (`notrans`) ON DELETE CASCADE;

--
-- Constraints for table `detail_gaji`
--
ALTER TABLE `detail_gaji`
  ADD CONSTRAINT `detail_gaji_ibfk_1` FOREIGN KEY (`penggajian_id`) REFERENCES `penggajian` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION,
  ADD CONSTRAINT `detail_gaji_ibfk_2` FOREIGN KEY (`karyawan_id`) REFERENCES `karyawan` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `detail_transaksi`
--
ALTER TABLE `detail_transaksi`
  ADD CONSTRAINT `detail_transaksi_ibfk_1` FOREIGN KEY (`notrans`) REFERENCES `transaksi` (`notrans`) ON DELETE CASCADE;

--
-- Constraints for table `karyawan`
--
ALTER TABLE `karyawan`
  ADD CONSTRAINT `karyawan_golongan_id` FOREIGN KEY (`golongan_id`) REFERENCES `golongan` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `penggajian`
--
ALTER TABLE `penggajian`
  ADD CONSTRAINT `penggajian_karyawan_id` FOREIGN KEY (`karyawan_id`) REFERENCES `karyawan` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

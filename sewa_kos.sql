-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Jan 22, 2025 at 02:08 AM
-- Server version: 8.0.40
-- PHP Version: 8.2.26

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `sewa_kos`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `ID_Admin` int NOT NULL,
  `Nama_Admin` varchar(100) NOT NULL,
  `Username` varchar(50) NOT NULL,
  `Password` varchar(255) NOT NULL,
  `Level_Akses` enum('SuperAdmin','Admin') DEFAULT 'Admin',
  `Email` varchar(100) DEFAULT NULL,
  `No_HP` varchar(15) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`ID_Admin`, `Nama_Admin`, `Username`, `Password`, `Level_Akses`, `Email`, `No_HP`) VALUES
(11, 'Rifki Nur Ikhwan', 'owner', '$2y$10$A/wQmmI9vddh5FzzrKFe/.r0NwtAyMustzu9M1HprxuI//KSYGuBy', 'SuperAdmin', 'owner@koshub.id', '088812345678');
INSERT INTO `admin` (`ID_Admin`, `Nama_Admin`, `Username`, `Password`, `Level_Akses`, `Email`, `No_HP`) VALUES
(12, 'Rio Rapansyah', 'owner2', '$2y$10$A/wQmmI9vddh5FzzrKFe/.r0NwtAyMustzu9M1HprxuI//KSYGuBy', 'SuperAdmin', 'owner2@koshub.id', '088812345679');

-- --------------------------------------------------------

--
-- Table structure for table `kamar`
--

CREATE TABLE `kamar` (
  `ID_Kamar` int NOT NULL,
  `Nomor_Kamar` varchar(10) NOT NULL,
  `Tipe_Kamar` varchar(50) DEFAULT NULL,
  `Fasilitas` text,
  `Harga_Bulanan` decimal(10,2) NOT NULL,
  `Status_Kamar` enum('Tersedia','Terisi','Maintenance') DEFAULT 'Tersedia',
  `Lantai` int DEFAULT NULL,
  `Kapasitas` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `kamar`
--

INSERT INTO `kamar` (`ID_Kamar`, `Nomor_Kamar`, `Tipe_Kamar`, `Fasilitas`, `Harga_Bulanan`, `Status_Kamar`, `Lantai`, `Kapasitas`) VALUES
(2, '102', 'Double', 'AC, TV, WiFi, Kamar Mandi Dalam', 2500000.00, 'Maintenance', 1, 2),
(3, '103', 'Single', 'AC, TV', 1400000.00, 'Tersedia', 1, 1),
(5, '201', 'Single', 'AC, TV', 1600000.00, 'Tersedia', 2, 1),
(6, '202', 'Double', 'AC, TV, Kamar Mandi Dalam', 2700000.00, 'Tersedia', 2, 2),
(7, '203', 'Single', 'AC, WiFi', 1450000.00, 'Tersedia', 2, 1),
(8, '204', 'Double', 'AC, TV, Kamar Mandi Dalam', 2400000.00, 'Maintenance', 2, 2),
(9, '301', 'Single', 'AC, TV, WiFi', 1550000.00, 'Tersedia', 3, 1),
(10, '302', 'Double', 'AC, TV, Kamar Mandi Dalam', 2600000.00, 'Tersedia', 3, 2),
(11, '129', 'Standard', 'TV,AC', 450000.00, 'Tersedia', 4, 1);

-- --------------------------------------------------------

--
-- Table structure for table `laporan`
--

CREATE TABLE `laporan` (
  `ID_Laporan` int NOT NULL,
  `Jenis_Laporan` varchar(50) NOT NULL,
  `Periode` varchar(50) DEFAULT NULL,
  `Tanggal_Dibuat` date NOT NULL,
  `ID_Admin` int DEFAULT NULL,
  `Status_Laporan` enum('Pending','Selesai') DEFAULT 'Pending',
  `Keterangan` text
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `laporan`
--

INSERT INTO `laporan` (`ID_Laporan`, `Jenis_Laporan`, `Periode`, `Tanggal_Dibuat`, `ID_Admin`, `Status_Laporan`, `Keterangan`) VALUES
(1, 'Laporan Keuangan', '2024-01', '2024-01-02', NULL, 'Selesai', 'Laporan untuk bulan Januari'),
(2, 'Laporan Pemeliharaan', '2024-02', '2024-02-02', NULL, 'Pending', 'Laporan pemeliharaan kamar'),
(3, 'Laporan Penghuni', '2024-03', '2024-03-02', NULL, 'Selesai', 'Laporan penghuni kamar per bulan Maret'),
(4, 'Laporan Keuangan', '2024-04', '2024-04-02', NULL, 'Selesai', 'Laporan keuangan untuk bulan April'),
(5, 'Laporan Pemeliharaan', '2024-05', '2024-05-02', NULL, 'Pending', 'Laporan pemeliharaan kamar'),
(6, 'Laporan Penghuni', '2024-06', '2024-06-02', NULL, 'Selesai', 'Laporan penghuni kamar per bulan Juni'),
(7, 'Laporan Keuangan', '2024-07', '2024-07-02', NULL, 'Pending', 'Laporan keuangan untuk bulan Juli'),
(8, 'Laporan Pemeliharaan', '2024-08', '2024-08-02', NULL, 'Selesai', 'Laporan pemeliharaan kamar'),
(9, 'Laporan Penghuni', '2024-09', '2024-09-02', NULL, 'Selesai', 'Laporan penghuni kamar per bulan September'),
(10, 'Laporan Keuangan', '2024-10', '2024-10-02', NULL, 'Pending', 'Laporan keuangan untuk bulan Oktober');

-- --------------------------------------------------------

--
-- Table structure for table `pembayaran`
--

CREATE TABLE `pembayaran` (
  `ID_Pembayaran` int NOT NULL,
  `ID_Reservasi` int NOT NULL,
  `Tanggal_Pembayaran` date NOT NULL,
  `Jumlah_Pembayaran` decimal(10,2) NOT NULL,
  `Metode_Pembayaran` enum('Tunai','Transfer','E-Wallet') NOT NULL,
  `Status_Pembayaran` enum('Pending','Lunas','Gagal') DEFAULT 'Pending',
  `Bukti_Pembayaran` text
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `pembayaran`
--

INSERT INTO `pembayaran` (`ID_Pembayaran`, `ID_Reservasi`, `Tanggal_Pembayaran`, `Jumlah_Pembayaran`, `Metode_Pembayaran`, `Status_Pembayaran`, `Bukti_Pembayaran`) VALUES
(2, 2, '2024-02-01', 30000000.00, 'E-Wallet', 'Pending', ''),
(3, 3, '2024-03-01', 4350000.00, 'Tunai', 'Lunas', 'Bukti2.jpg'),
(7, 7, '2024-07-01', 15600000.00, 'Transfer', 'Lunas', 'Bukti5.jpg'),
(8, 8, '2024-08-01', 9000000.00, 'E-Wallet', 'Lunas', 'Bukti6.jpg'),
(9, 9, '2024-09-01', 8700000.00, 'Transfer', 'Pending', ''),
(10, 10, '2024-10-01', 12000000.00, 'Tunai', 'Lunas', 'Bukti7.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `penyewa`
--

CREATE TABLE `penyewa` (
  `ID_Penyewa` int NOT NULL,
  `Nama_Lengkap` varchar(100) NOT NULL,
  `NIK` varchar(20) NOT NULL,
  `Jenis_Kelamin` enum('Laki-Laki','Perempuan') NOT NULL,
  `No_HP` varchar(15) NOT NULL,
  `Email` varchar(100) DEFAULT NULL,
  `Alamat_Asal` text,
  `Pekerjaan` varchar(50) DEFAULT NULL,
  `Tanggal_Masuk` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `penyewa`
--

INSERT INTO `penyewa` (`ID_Penyewa`, `Nama_Lengkap`, `NIK`, `Jenis_Kelamin`, `No_HP`, `Email`, `Alamat_Asal`, `Pekerjaan`, `Tanggal_Masuk`) VALUES
(1, 'Andi Pratama', '1234567890123456', 'Laki-Laki', '081234567890', 'andi@email.com', 'Bandung', 'Freelancer', '2024-01-01'),
(2, 'Budi Santoso', '2234567890123456', 'Laki-Laki', '082345678901', 'budi@email.com', 'Jakarta', 'Designer', '2024-02-01'),
(3, 'Citra Dewi', '3234567890123456', 'Perempuan', '083456789012', 'citra@email.com', 'Surabaya', 'Dokter', '2024-03-01'),
(4, 'Dedi Kusuma', '4234567890123456', 'Laki-Laki', '084567890123', 'dedi@email.com', 'Yogyakarta', 'Dosen', '2024-04-01'),
(5, 'Eka Setiawan', '5234567890123456', 'Laki-Laki', '085678901234', 'eka@email.com', 'Medan', 'Insinyur', '2024-05-01'),
(7, 'Gita Rahma', '7234567890123456', 'Perempuan', '087890123456', 'gita@email.com', 'Makassar', 'Pengacara', '2024-07-01'),
(8, 'Hadi Prabowo', '8234567890123456', 'Laki-Laki', '088901234567', 'hadi@email.com', 'Malang', 'Arsitek', '2024-08-01'),
(9, 'Indah Sari', '9234567890123456', 'Perempuan', '089012345678', 'indah@email.com', 'Medan', 'Guru', '2024-09-01'),
(10, 'Joko Widodo', '1023456789012345', 'Laki-Laki', '091234567890', 'joko@email.com', 'Jakarta', 'Wirausaha', '2024-10-01');

-- --------------------------------------------------------

--
-- Table structure for table `reservasi`
--

CREATE TABLE `reservasi` (
  `ID_Reservasi` int NOT NULL,
  `ID_Penyewa` int NOT NULL,
  `ID_Kamar` int NOT NULL,
  `Tanggal_Reservasi` date NOT NULL,
  `Tanggal_Mulai` date NOT NULL,
  `Durasi_Sewa` int NOT NULL COMMENT 'Durasi dalam bulan',
  `Status_Reservasi` enum('Pending','Diterima','Ditolak','Selesai') DEFAULT 'Pending'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `reservasi`
--

INSERT INTO `reservasi` (`ID_Reservasi`, `ID_Penyewa`, `ID_Kamar`, `Tanggal_Reservasi`, `Tanggal_Mulai`, `Durasi_Sewa`, `Status_Reservasi`) VALUES
(2, 2, 2, '2024-02-01', '2024-02-01', 10, 'Pending'),
(3, 3, 3, '2024-03-01', '2024-03-01', 3, 'Diterima'),
(7, 7, 7, '2024-07-01', '2024-07-01', 12, 'Diterima'),
(8, 8, 8, '2024-08-01', '2024-08-01', 9, 'Selesai'),
(9, 9, 9, '2024-09-01', '2024-09-01', 6, 'Pending'),
(10, 10, 10, '2024-10-01', '2024-10-01', 12, 'Diterima');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`ID_Admin`),
  ADD UNIQUE KEY `Username` (`Username`);

--
-- Indexes for table `kamar`
--
ALTER TABLE `kamar`
  ADD PRIMARY KEY (`ID_Kamar`);

--
-- Indexes for table `laporan`
--
ALTER TABLE `laporan`
  ADD PRIMARY KEY (`ID_Laporan`),
  ADD KEY `ID_Admin` (`ID_Admin`);

--
-- Indexes for table `pembayaran`
--
ALTER TABLE `pembayaran`
  ADD PRIMARY KEY (`ID_Pembayaran`),
  ADD KEY `ID_Reservasi` (`ID_Reservasi`);

--
-- Indexes for table `penyewa`
--
ALTER TABLE `penyewa`
  ADD PRIMARY KEY (`ID_Penyewa`);

--
-- Indexes for table `reservasi`
--
ALTER TABLE `reservasi`
  ADD PRIMARY KEY (`ID_Reservasi`),
  ADD KEY `ID_Penyewa` (`ID_Penyewa`),
  ADD KEY `ID_Kamar` (`ID_Kamar`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `ID_Admin` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `kamar`
--
ALTER TABLE `kamar`
  MODIFY `ID_Kamar` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `laporan`
--
ALTER TABLE `laporan`
  MODIFY `ID_Laporan` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `pembayaran`
--
ALTER TABLE `pembayaran`
  MODIFY `ID_Pembayaran` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `penyewa`
--
ALTER TABLE `penyewa`
  MODIFY `ID_Penyewa` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `reservasi`
--
ALTER TABLE `reservasi`
  MODIFY `ID_Reservasi` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `laporan`
--
ALTER TABLE `laporan`
  ADD CONSTRAINT `laporan_ibfk_1` FOREIGN KEY (`ID_Admin`) REFERENCES `admin` (`ID_Admin`) ON DELETE SET NULL;

--
-- Constraints for table `pembayaran`
--
ALTER TABLE `pembayaran`
  ADD CONSTRAINT `pembayaran_ibfk_1` FOREIGN KEY (`ID_Reservasi`) REFERENCES `reservasi` (`ID_Reservasi`) ON DELETE CASCADE;

--
-- Constraints for table `reservasi`
--
ALTER TABLE `reservasi`
  ADD CONSTRAINT `reservasi_ibfk_1` FOREIGN KEY (`ID_Penyewa`) REFERENCES `penyewa` (`ID_Penyewa`) ON DELETE CASCADE,
  ADD CONSTRAINT `reservasi_ibfk_2` FOREIGN KEY (`ID_Kamar`) REFERENCES `kamar` (`ID_Kamar`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
